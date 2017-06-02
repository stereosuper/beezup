<?php get_header(); ?>

<section class='container-medium page-intro'>

	<div class='page-intro-title'>
		<?php if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>

		<h1 class='page-title title-black'><?php the_field('blogTitle', 'options'); ?></h1>
	</div>

</section>

<section class='container-medium'>
	<?php if ( have_posts() ) : $count = 0; ?>

		<ul><?php wp_list_categories( array('title_li' => '') ); ?></ul>
		<?php get_search_form(); ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<div class='post <?php if( is_sticky() ) echo 'highlighted'; ?>'>
				<?php if( has_post_thumbnail() ){ ?>
					<a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>' class='post-img'>
						<?php the_post_thumbnail('large'); ?>
					</a>
				<?php } ?>
				
				<div class='post-txt'>
					<div class='post-meta'>
						<?php _e('Add on', 'beezup'); ?>
						<a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'><?php echo get_the_date(); ?></a>
						<?php _e('in', 'beezup'); ?>
						<?php echo get_the_category_list(); ?>
					</div>

					<h2>
						<a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'>
							<?php the_title(); ?>
						</a>
					</h2>

					<a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>' class='excerpt'>
						<div><?php the_excerpt(); ?></div>
					</a>
					
					<a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>' class='link-arrow'><?php _e('Lire la suite', 'beezup'); ?></a>
				</div>
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
</section>

<?php get_footer(); ?>