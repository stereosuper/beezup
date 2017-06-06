<?php get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
	<section class='container-small'>
		<?php if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>

		<h1 <?php if( get_field('left') ) echo 'class="left"'; ?>>
			<?php get_field('title') ? the_field('title') : the_title(); ?>
		</h1>
	</section>
		
	<?php get_template_part('includes/content-default'); ?>

	<?php get_template_part('includes/free-links'); ?>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>