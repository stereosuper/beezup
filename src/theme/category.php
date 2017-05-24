<?php get_header(); ?>

<div class='container'>

	<?php if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>

	<h1><?php echo single_cat_title(); ?></h1>

	<?php if ( have_posts() ) : $count = 0; ?>

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
				
		<p><?php _e("There is no posts yet!", 'beezup'); ?></p>

	<?php endif; ?>

</div>

<?php get_footer(); ?>