<?php
/*
Template Name: Sitemap
*/
get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>

	<section class='container-small page-title-default <?php if( get_field('left') ) echo "left"; ?>'>
		<?php // if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>

		<h1>
			<?php get_field('title') ? the_field('title') : the_title(); ?>
		</h1>
	</section>

	<?php get_template_part('includes/content-default'); ?>

	<section class='container-small'>
		<h2><?php _e('Pages'); ?></h2>
		<ul class='list-black'>
			<?php wp_list_pages( array('post_type' => 'page', 'title_li' => '') ); ?>
		</ul>

		<?php
			function listPosts($postType, $tax){
				$options = $tax ? array( array('taxonomy' => 'types', 'field' => 'slug', 'terms' => $tax) ) : '';
				$posts = get_posts( array('post_type' => $postType, 'orderby' => 'title', 'posts_per_page' => -1, 'order' => 'ASC', 'tax_query' => $options) );

				if(!$posts)
					echo '<p>Nothing was found</p>';

				$output = "<ul class='list-black'>";
				foreach( $posts as $post ){
					$output .= '<li>';
					$output .= '<a href="'. get_permalink($post->ID) .'" title="'. get_the_title($post->ID) .'">';
					$output .= get_the_title($post->ID);
					$output .= '</a>';
					$output .= '</li>';
				}
				$output .= '</ul>';

				echo $output;
			}
		?>

		<h2><?php _e('Blog', 'beezup'); ?></h2>
		<?php listPosts('post', ''); ?>
	</section>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>
