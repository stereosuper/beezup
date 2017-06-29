<?php get_header(); ?>

<?php if ( have_posts() ) : ?>

	<?php
	global $wp_query;
	$results = $wp_query->found_posts;
	$displayResults = $results > 1 ? $results . ' ' . __('results', 'beezup') : '1 ' . __('result', 'beezup');
	?>

	<section class='container-medium page-intro'>

		<div class='page-intro-title blog-title'>
			<?php // if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>

			<h1 class='page-title'><?php echo $displayResults . ' ' . __('for', 'beezup') . ' "' . get_search_query() . '"'; ?></h1>
		</div>

		<?php get_template_part( 'includes/blog-form' ); ?>

	</section>

	<section class='container-medium posts-wrapper'>
		<?php get_template_part( 'includes/blog-content' ); ?>
	</section>

<?php else : ?>

	<section class='container-medium page-intro'>

		<div class='page-intro-title blog-title'>
			<?php if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>

			<h1 class='page-title'><?php echo __('No results for', 'beezup') . ' "' . get_search_query() . '" '; ?></h1>
		</div>

		<?php get_template_part( 'includes/blog-form' ); ?>

	</section>

	<section class='container-medium posts-wrapper'>
		<p><?php echo __('The search for', 'beezup') . ' "' . get_search_query() . '" ' . __("hasn't return any results", 'beezup'); ?>.</p>
	</section>

<?php endif; ?>

<?php get_footer(); ?>