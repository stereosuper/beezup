<?php
	/**
	* Plugin Name: Tracking Script Manager
	* Plugin URI: http://wordpress.org/plugins/tracking-script-manager/
	* Description: A plugin that allows you to add tracking scripts to your site.
	* Version: 2.0.5
	* Author: Red8 Interactive
	* Author URI: http://red8interactive.com
	* License: GPL2
	*/

	/*
		Copyright 2019 Red8 Interactive  (email : james@red8interactive.com)

		This program is free software; you can redistribute it and/or
		modify it under the terms of the GNU General Public License
		as published by the Free Software Foundation; either version 2
		of the License, or (at your option) any later version.

		This program is distributed in the hope that it will be useful,
		but WITHOUT ANY WARRANTY; without even the implied warranty of
		MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
		GNU General Public License for more details.

		You should have received a copy of the GNU General Public License
		along with this program; if not, write to the Free Software
		Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
	*/

	if ( ! defined( 'ABSPATH' ) ) {
    	exit; // Exit if accessed directly
	}

	if ( ! class_exists('Tracking_Scripts') ) {

		class Tracking_Scripts {

			/**
			 * @var TSM_Process_Tracking_Scripts
			 */
			protected $process_all;

			function __construct() {}

			public function initialize() {

				// Constants
				define( 'TRACKING_SCRIPT_PATH', plugins_url( ' ', __FILE__ ) );
				define( 'TRACKING_SCRIPT_BASENAME', plugin_basename( __FILE__ ) );
                define( 'TRACKING_SCRIPT_DIR_PATH', plugin_dir_path( __FILE__ ) );
				define( 'TRACKING_SCRIPT_TEXTDOMAIN', 'tracking-scripts-manager' );

				// Actions
				add_action( 'init', array( $this, 'register_scripts_post_type' ) );
				add_action( 'save_post', array( $this, 'save_post' ) );
				add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
				add_action( 'wp_head', array( $this, 'find_header_tracking_codes' ), 10 );
				add_action( 'wp_footer', array( $this, 'find_footer_tracking_codes'), 10 );
				add_action( 'admin_menu', array( $this, 'tracking_scripts_create_menu') );
                add_action( 'add_meta_boxes', array( $this, 'add_script_metaboxes' ) );
				add_action( 'wp_ajax_tracking_scripts_get_posts', array( $this, 'tracking_scripts_posts_ajax_handler' ) );
				add_action( 'manage_r8_tracking_scripts_posts_custom_column', array( $this, 'tracking_script_column_content' ), 10, 2 );
				add_action( 'wp_body_open', array( $this, 'find_page_tracking_codes' ) );
				add_action( 'tsm_page_scripts', array( $this, 'find_page_tracking_codes' ) );
				add_action( 'admin_init', array( $this, 'process_handler' ) );
				add_action( 'admin_notices', array( $this, 'admin_notices' ) );

				// fallback for page scripts if wp_body_open action isn't supported
				add_action( 'get_footer', function() {
					if ( did_action( 'wp_body_open' ) === 0 ) {
						add_action( 'wp_footer', array( $this, 'find_page_tracking_codes' ) );
					}
				} );

				// Filters
				add_filter( 'manage_r8_tracking_scripts_posts_columns', array( $this, 'add_tracking_script_columns' ) );
				add_filter( 'manage_edit-r8_tracking_scripts_sortable_columns', array( $this, 'tracking_scripts_column_sort' ) );

				// Includes
				require_once plugin_dir_path( __FILE__ ) . 'classes/wp-async-request.php';
				require_once plugin_dir_path( __FILE__ ) . 'classes/wp-background-process.php';
				require_once plugin_dir_path( __FILE__ ) . 'classes/class-process-tracking-scripts.php';

				$this->process_all = new TSM_Process_Tracking_Scripts();

			}

			/*************************************************
			 * Front End
			**************************************************/

			public function process_handler() {

				if ( ! isset( $_GET['tsm_update_scripts'] ) || ! isset( $_GET['_wpnonce'] ) ) {
					return;
				}

				if ( ! wp_verify_nonce( $_GET['_wpnonce'], 'tsm_update_scripts' ) ) {
					return;
				}

				if ( 'true' === $_GET['tsm_update_scripts'] ) {
					update_option( 'tsm_is_processing', true );
					$this->handle_all();
				}

			}

			protected function handle_all() {
				$scripts = $this->get_tracking_scripts();
				
				if ( ! empty( $scripts ) ) {

					foreach ( $scripts as $script ) {
						$this->process_all->push_to_queue( $script );
					}

					$this->process_all->save()->dispatch();

				}
			}

			protected function get_tracking_scripts() {

				$scripts = array();
				$header_scripts = get_option( 'header_tracking_script_code' ) ? unserialize( get_option('header_tracking_script_code') ) : null;
				$page_scripts   = get_option( 'page_tracking_script_code' ) ? unserialize( get_option('page_tracking_script_code') ) : null;
				$footer_scripts = get_option( 'footer_tracking_script_code' ) ? unserialize( get_option('footer_tracking_script_code') ) : null;

				if ( ! empty( $header_scripts ) ) {
					$scripts = array_merge( $scripts, $header_scripts );
				}

				if ( ! empty( $page_scripts ) ) {
					$scripts = array_merge( $scripts, $page_scripts );
				}

				if ( ! empty( $footer_scripts ) ) {
					$scripts = array_merge( $scripts, $footer_scripts );
				}

				return $scripts;

			}

			function admin_notices() {
				$class = 'notice notice-info is-dismissible';
				$header_scripts = get_option('header_tracking_script_code');
				$page_scripts = get_option('page_tracking_script_code');
				$footer_scripts = get_option('footer_tracking_script_code');
				$is_processing = get_option('tsm_is_processing');
				$has_tracking_scripts = ( $header_scripts || $page_scripts || $footer_scripts ) ? true : false;
				$is_admin = current_user_can('manage_options') ? true : false;
				
				if ( $has_tracking_scripts && $is_processing && $is_admin ) {
					$message = __( 'Your scripts are currently processing. This may take several minutes. If you don’t see all of your scripts please wait a moment and refresh the page.', TRACKING_SCRIPT_TEXTDOMAIN );
					$notice = sprintf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
					echo $notice;
				}

				if ( $has_tracking_scripts && ! $is_processing && $is_admin ) {
					$url = wp_nonce_url( admin_url('edit.php?post_type=r8_tracking_scripts&tsm_update_scripts=true&tsm_is_processing=true'), 'tsm_update_scripts' );
					$message = __( 'Tracking Scripts Manager has updated to a new version, click OK to update your scripts to the updated version.', TRACKING_SCRIPT_TEXTDOMAIN );
					$notice = sprintf( '<div class="%1$s"><p>%2$s</p><a class="button button-primary" href="%3$s" style="margin-bottom: .5em;">OK</a></div>', esc_attr( $class ), esc_html( $message ), esc_url( $url ) );
					echo $notice;
				}
			}

			// Header Tracking Codes
			function find_header_tracking_codes() {

				global $wp_query;
				$current_id = $wp_query->post->ID;

				$args = array(
					'post_type' 	 => 'r8_tracking_scripts',
					'post_status'	 => 'publish',
					'posts_per_page' => -1,
					'meta_key' 	 	 => 'r8_tsm_script_order',
					'orderby' 		 => 'meta_value_num',
					'order'			 => 'ASC',
					'meta_query' 	 => array(
						'relation' => 'AND',
						array(
							'key' 	  => 'r8_tsm_script_location',
							'value'   => 'header',
							'compare' => '='
						),
						array(
							'key'	  => 'r8_tsm_active',
							'value'   => 'active',
							'compare' => '='
						)
					)
				);

				$header_scripts = new WP_Query($args);

				if ( $header_scripts->have_posts() ) {
					while ( $header_scripts->have_posts() ) : $header_scripts->the_post();
						$page = get_post_meta( get_the_ID(), 'r8_tsm_script_page', true );

						if ( is_array( $page ) && in_array(intval($current_id), $page) ) {
							echo html_entity_decode(get_post_meta( get_the_ID(), 'r8_tsm_script_code', true ), ENT_QUOTES, 'cp1252');
						} elseif ( empty( $page ) ) {
							echo html_entity_decode( get_post_meta( get_the_ID(), 'r8_tsm_script_code', true ), ENT_QUOTES, 'cp1252' );
						}

					endwhile; wp_reset_postdata();
				}
			}

			function find_page_tracking_codes() {

				global $wp_query;
				$current_id = $wp_query->post->ID;

				$args = array(
					'post_type' 	 => 'r8_tracking_scripts',
					'posts_per_page' => -1,
					'post_status'	 => 'publish',
					'meta_key' 	 	 => 'r8_tsm_script_order',
					'orderby' 		 => 'meta_value_num',
					'order'			 => 'ASC',
					'meta_query' 	 => array(
						'relation' => 'AND',
						array(
							'key' 	  => 'r8_tsm_script_location',
							'value'   => 'page',
							'compare' => '='
						),
						array(
							'key'	  => 'r8_tsm_active',
							'value'   => 'active',
							'compare' => '='
						)
					)
				);

				$page_scripts = new WP_Query($args);

				if ( $page_scripts->have_posts() ) {
					while ( $page_scripts->have_posts() ) : $page_scripts->the_post();
						$page = get_post_meta( get_the_ID(), 'r8_tsm_script_page', true );

						if ( is_array( $page ) && in_array(intval($current_id), $page) ) {
							echo html_entity_decode(get_post_meta( get_the_ID(), 'r8_tsm_script_code', true ), ENT_QUOTES, 'cp1252');
						} elseif ( empty( $page ) ) {
							echo html_entity_decode(get_post_meta( get_the_ID(), 'r8_tsm_script_code', true ), ENT_QUOTES, 'cp1252');
						}

					endwhile; wp_reset_postdata();
				}

			}

			function find_footer_tracking_codes() {
				global $wp_query;
				$current_id = $wp_query->post->ID;

				$args = array(
					'post_type' 	 => 'r8_tracking_scripts',
					'posts_per_page' => -1,
					'post_status' 	 => 'publish',
					'meta_key' 	 	 => 'r8_tsm_script_order',
					'orderby' 		 => 'meta_value_num',
					'order'			 => 'ASC',
					'meta_query' 	 => array(
						'relation' => 'AND',
						array(
							'key' 	  => 'r8_tsm_script_location',
							'value'   => 'footer',
							'compare' => '='
						),
						array(
							'key'	  => 'r8_tsm_active',
							'value'   => 'active',
							'compare' => '='
						)
					)
				);

				$footer_scripts = new WP_Query($args);

				if ( $footer_scripts->have_posts() ) {
					while ( $footer_scripts->have_posts() ) : $footer_scripts->the_post();
						$page = get_post_meta( get_the_ID(), 'r8_tsm_script_page', true );

						if ( is_array( $page ) && in_array(intval($current_id), $page) ) {
							echo html_entity_decode(get_post_meta( get_the_ID(), 'r8_tsm_script_code', true ), ENT_QUOTES, 'cp1252');
						} elseif ( empty( $page ) ) {
							echo html_entity_decode(get_post_meta( get_the_ID(), 'r8_tsm_script_code', true ), ENT_QUOTES, 'cp1252');
						}

					endwhile; wp_reset_postdata();
				}
			}

			function add_tracking_script_columns($columns) {

				$columns = array(
					'cb' => '<input type="checkbox" />',
					'title' => __( 'Script Title', TRACKING_SCRIPT_TEXTDOMAIN ),
					'global' => __( 'Global', TRACKING_SCRIPT_TEXTDOMAIN ),
					'location' => __( 'Location', TRACKING_SCRIPT_TEXTDOMAIN ),
					'status' => __( 'Status', TRACKING_SCRIPT_TEXTDOMAIN ),
				);

				return $columns;

			}

			function tracking_script_column_content($column_name, $post_ID) {

				if ( $column_name === 'status' ) {
					$active = get_post_meta( $post_ID, 'r8_tsm_active', true );
					if ( $active === 'active' ) {
						echo 'Active';
					} else {
						echo 'Inactive';
					}
				}

				if ( $column_name === 'global' ) {
					$global = get_post_meta( $post_ID, 'r8_tsm_script_page', true );

					if ( empty($global) ) {
						echo '&nbsp;&nbsp;&nbsp;&nbsp;&#10003;';
					} else {
						echo '&nbsp;&nbsp;&nbsp;&nbsp;&cross;';
					}
				}

				if ( $column_name === 'location' ) {
					$location = get_post_meta( $post_ID, 'r8_tsm_script_location', true );

					if ( $location ) {
						echo ucwords($location);
					}
				}

			}

			function tracking_scripts_column_sort($columns) {

				$columns['global'] = 'global';
				$columns['location'] = 'location';
				$columns['status'] = 'status';

				return $columns;

			}

            public function add_script_metaboxes() {

                add_meta_box( 'r8_tsm_script_code', __( 'Script Code', TRACKING_SCRIPT_TEXTDOMAIN ), array( $this, 'script_code_metabox' ), 'r8_tracking_scripts', 'normal' );
                add_meta_box( 'r8_tsm_script_active', __( 'Script Status', TRACKING_SCRIPT_TEXTDOMAIN ), array( $this, 'script_active_metabox' ), 'r8_tracking_scripts', 'side' );
				add_meta_box( 'r8_tsm_script_order', __( 'Script Order', TRACKING_SCRIPT_TEXTDOMAIN ), array( $this, 'script_order_metabox' ), 'r8_tracking_scripts', 'side' );
				add_meta_box( 'r8_tsm_script_location', __( 'Script Location', TRACKING_SCRIPT_TEXTDOMAIN ), array( $this, 'script_location_metabox' ), 'r8_tracking_scripts', 'normal' );
				add_meta_box( 'r8_tsm_script_page', __( 'Specific Script Placement (Page(s) or Post(s))', TRACKING_SCRIPT_TEXTDOMAIN ), array( $this, 'script_page_metabox' ), 'r8_tracking_scripts', 'normal' );

            }

            function script_code_metabox() {

                global $post;

                $script_code = get_post_meta( $post->ID, 'r8_tsm_script_code', true );

                include_once( TRACKING_SCRIPT_DIR_PATH . '/templates/script-code-metabox.php' );

            }

            function script_active_metabox() {

                global $post;

                $active = get_post_meta( $post->ID, 'r8_tsm_active', true );

                include_once( TRACKING_SCRIPT_DIR_PATH . '/templates/script-active-metabox.php' );

            }

			function script_order_metabox() {

				global $post;

                $order = get_post_meta( $post->ID, 'r8_tsm_script_order', true );

				include_once( TRACKING_SCRIPT_DIR_PATH . '/templates/script-order-metabox.php' );

			}

			function script_location_metabox() {

				global $post;

				$location = get_post_meta( $post->ID, 'r8_tsm_script_location', true );

				include_once( TRACKING_SCRIPT_DIR_PATH . '/templates/script-location-metabox.php' );

			}

			function script_page_metabox() {

				global $post;

				$script_page = get_post_meta( $post->ID, 'r8_tsm_script_page', true );

				include_once( TRACKING_SCRIPT_DIR_PATH . '/templates/script-page-metabox.php' );

			}


            public function register_scripts_post_type() {

                $labels = array(
            		'name'               => _x( 'Tracking Scripts', TRACKING_SCRIPT_TEXTDOMAIN ),
            		'singular_name'      => _x( 'Tracking Script', TRACKING_SCRIPT_TEXTDOMAIN ),
            		'menu_name'          => _x( 'Tracking Scripts', TRACKING_SCRIPT_TEXTDOMAIN ),
            		'name_admin_bar'     => _x( 'Tracking Scripts', TRACKING_SCRIPT_TEXTDOMAIN ),
            		'add_new'            => _x( 'Add New Tracking Script', TRACKING_SCRIPT_TEXTDOMAIN ),
            		'add_new_item'       => __( 'Add New Tracking Script', TRACKING_SCRIPT_TEXTDOMAIN ),
            		'new_item'           => __( 'New Tracking Script', TRACKING_SCRIPT_TEXTDOMAIN ),
            		'edit_item'          => __( 'Edit Tracking Script', TRACKING_SCRIPT_TEXTDOMAIN ),
            		'view_item'          => __( 'View Tracking Script', TRACKING_SCRIPT_TEXTDOMAIN ),
            		'all_items'          => __( 'All Tracking Scripts', TRACKING_SCRIPT_TEXTDOMAIN ),
            		'search_items'       => __( 'Search Tracking Scripts', TRACKING_SCRIPT_TEXTDOMAIN ),
            		'parent_item_colon'  => __( 'Parent Tracking Scripts:', TRACKING_SCRIPT_TEXTDOMAIN ),
            		'not_found'          => __( 'No Tracking Scripts found.', TRACKING_SCRIPT_TEXTDOMAIN ),
            		'not_found_in_trash' => __( 'No Tracking Scripts found in Trash.', TRACKING_SCRIPT_TEXTDOMAIN )
            	);

            	$args = array(
            		'labels'             => $labels,
                    'description'        => __( 'Description.', TRACKING_SCRIPT_TEXTDOMAIN ),
            		'public'             => false,
            		'publicly_queryable' => false,
            		'show_ui'            => true,
            		'show_in_menu'       => false,
            		'query_var'          => false,
            		'rewrite'            => array( 'slug' => 'tracking-scripts' ),
					'capability_type'    => 'post',
					'capabilities' => array(
						'edit_post'          => 'manage_options',
						'read_post'          => 'manage_options',
						'delete_post'        => 'manage_options',
						'edit_posts'         => 'manage_options',
						'edit_others_posts'  => 'manage_options',
						'delete_posts'       => 'manage_options',
						'publish_posts'      => 'manage_options',
						'read_private_posts' => 'manage_options'
					),
            		'has_archive'        => false,
            		'hierarchical'       => false,
                    'menu_position'      => null,
            		'supports'           => array( 'title', 'script-code', 'script-active', 'script-location', 'script-order' )
            	);

            	register_post_type( 'r8_tracking_scripts', $args );

            }

			/*************************************************
			 * Admin Area
			**************************************************/

			function admin_enqueue_scripts($hook) {
				global $post;

				if ( $hook === 'post.php' || $hook === 'post-new.php' ) {
					if ( $post->post_type === 'r8_tracking_scripts' ) {
						wp_enqueue_style( 'r8-tsm-edit-script', plugins_url('/css/tracking-script-edit.css', __FILE__ ) );
						wp_enqueue_style( 'r8-tsm-select2-css', plugins_url('/css/select2.min.css', __FILE__ ) );
						wp_enqueue_script( 'r8-tsm-select2-js', plugins_url( '/js/select2.min.js', __FILE__ ), array(), null, true );
						wp_enqueue_script( 'r8-tsm-post-edit-js', plugins_url( '/js/post-edit.js', __FILE__ ), array('jquery', 'r8-tsm-select2-js'), null, true );
					}
				}
			}

			function save_post() {

				global $post;

				if ( ! empty( $post->post_type ) ) {
					if ( $post->post_type === 'r8_tracking_scripts' ) {

						if ( ! empty( $_POST['r8_tsm_script_code'] ) ) {
							update_post_meta( $post->ID, 'r8_tsm_script_code', stripslashes(esc_textarea($_POST['r8_tsm_script_code'])) );
						}

						if ( ! empty( $_POST['r8_tsm_active'] ) ) {
							update_post_meta( $post->ID, 'r8_tsm_active', sanitize_text_field( $_POST['r8_tsm_active'] ) );
						}

						if ( ! empty( $_POST['r8_tsm_script_order'] ) ) {
							update_post_meta( $post->ID, 'r8_tsm_script_order', intval( $_POST['r8_tsm_script_order'] ) );
						}


						if ( ! empty( $_POST['r8_tsm_script_location'] ) ) {
							update_post_meta( $post->ID, 'r8_tsm_script_location', sanitize_text_field( $_POST['r8_tsm_script_location'] ) );
						}

						if ( ! empty( $_POST['r8_tsm_script_page'] ) && is_array( $_POST['r8_tsm_script_page'] ) ) {
							update_post_meta( $post->ID, 'r8_tsm_script_page', $_POST['r8_tsm_script_page'] );
						}

					}
				}

			}

			public function tracking_scripts_create_menu() {
				add_menu_page( 'Tracking Script Manager', 'Tracking Script Manager', 'manage_options', 'edit.php?post_type=r8_tracking_scripts', null );
				add_submenu_page( 'edit.php?post_type=r8_tracking_scripts', 'Add New Tracking Script', 'Add New Tracking Script', 'manage_options', 'post-new.php?post_type=r8_tracking_scripts', null );
			}

			// Admin Scripts
			public function tracking_scripts_admin_scripts() {
				wp_enqueue_script('jquery');

				wp_enqueue_script( 'tracking_script_js', plugin_dir_url(__FILE__) . '/js/built.min.js', array(), '', true );
				wp_localize_script( 'tracking_script_js', 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
			}


			// Ajax Functions
			public function tracking_scripts_posts_ajax_handler() {
				$post_type = ($_POST['postType']) ? esc_attr($_POST['postType']) : 'post';

				$args = array(
					'post_type' => $post_type,
					'posts_per_page' => -1,
					'orderby' => 'name',
					'order' => 'ASC'
				);

				ob_start();

				$query = new WP_Query($args);
				echo '<option value="none" id="none">Choose '.ucwords($post_type).'</option>';
				while( $query->have_posts() ) : $query->the_post();
					echo '<option value="'.get_the_ID().'" id="'.get_the_ID().'">'.ucwords(get_the_title()).'</option>';
				endwhile;
				wp_reset_postdata();

				echo ob_get_clean();
				die();
			}
		}

		function tracking_scripts() {
	
			// globals
			global $tracking_scripts;
			
			
			// initialize
			if ( ! isset($tracking_scripts) ) {
				$tracking_scripts = new Tracking_Scripts();
				$tracking_scripts->initialize();
			}
			
			// return
			return $tracking_scripts;
			
		}
		
		// initialize
		tracking_scripts();
	}

	if ( ! class_exists('Tracking_Script') ) {

		class Tracking_Script {
			public $script_name;
			public $script_code;
			public $active;
			public $order;
			public $page_id;
			public $location;
			public $script_id;

			function __construct() {

			}
		}

	}