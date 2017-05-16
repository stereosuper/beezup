<?php get_header(); ?>

<div class='container'>

	<?php if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb(); } ?>

	<?php if ( have_posts() ) : $count = 0; ?>

		<?php
		global $wp_query;
		$results = $wp_query->found_posts;
		$displayResults = $results > 1 ? $results . ' ' . __('results', 'beezup') : '1 ' . __('result', 'beezup');
		?>

		<h1><?php echo __('The search for', 'beezup') . ' "' . get_search_query() . '" ' . __('returned', 'beezup') . ' ' . $displayResults; ?></h1>

		<ul><?php wp_list_categories( array('title_li' => '') ); ?></ul>
		<?php get_search_form(); ?>

		<?php while ( have_posts() ) : the_post(); ?>
			
			<div class='<?php if( get_field('highlighted') ) echo 'highlighted'; ?>'>
				<span>
					<?php _e('Add on', 'beezup'); ?>
					<a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'><?php echo get_the_date(); ?></a>
					<?php _e('in', 'beezup'); ?>
					<?php echo get_the_category_list(); ?>
				</span>
				
				<h2>
					<a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'>
						<?php the_title(); ?>
					</a>
				</h2>

				<a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'>
					<?php the_post_thumbnail('large'); ?>
					<?php the_excerpt(); ?>
					<span class='link-arrow'><?php _e('Lire la suite', 'beezup'); ?></span>
				</a>
			</div>

			<?php if( $count === 2 ){ //newsletter ?>
				<div>
					<?php if( get_field('blogNewsletterTitle', 'options') ){ ?>
						<h3><?php the_field('blogNewsletterTitle', 'options'); ?></h3>
					<?php } ?>
					
					<?php the_field('blogNewsletterText', 'options'); ?>

					<?php get_template_part( 'includes/newsletter' ); ?>
				</div>
			<?php } ?>

			<?php if( $count === 4 ){ //demo ?>
				<?php get_template_part( 'includes/demo' ); ?>
			<?php } ?>
		
		<?php $count ++; endwhile; ?>

		<div class='pagination'>
			<?php echo paginate_links(array( 'prev_text' => __('Previous', 'beezup'), 'next_text'  =>  __('Next', 'beezup')) ); ?>
		</div>

		<?php get_template_part('includes/free-links'); ?>
	
	<?php else : ?>
				
		<h1><?php echo __('The search for', 'beezup') . ' "' . get_search_query() . '" ' . __("hasn't return any results", 'beezup'); ?></h1>

		<?php get_search_form(); ?>

	<?php endif; ?>

</div>

<?php get_footer(); ?>