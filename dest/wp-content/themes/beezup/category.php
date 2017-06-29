<?php get_header(); ?>

<section class='container-medium page-intro'>

	<div class='page-intro-title blog-title'>
		<?php // if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>

		<h1 class='page-title'><?php echo single_cat_title(); ?></h1>
	</div>

	<?php get_template_part( 'includes/blog-form' ); ?>

</section>

<section class='container-medium posts-wrapper'>

	<?php if ( have_posts() ) : ?>

		<?php get_template_part( 'includes/blog-content' ); ?>
	
	<?php else : ?>
				
		<p><?php _e("There is no posts yet!", 'beezup'); ?></p>

	<?php endif; ?>

</section>

<?php get_footer(); ?>