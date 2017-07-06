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
		<?php $posts = get_posts( array('post_type' => 'post', 'orderby' => 'title', 'posts_per_page' => -1, 'order' => 'ASC') ); ?>

		<?php if($posts){ ?>
			<h2><?php _e('Pages'); ?></h2>
		<?php } ?>
		<ul class='list-black'>
			<?php wp_list_pages( array('post_type' => 'page', 'title_li' => '') ); ?>
		</ul>

		<?php if($posts){ ?>
			<h2><?php _e('Blog', 'beezup'); ?></h2>
			<?php
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
			?>
		<?php } ?>
	</section>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>
