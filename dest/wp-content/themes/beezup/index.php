<?php get_header(); ?>

<section class='container-medium page-intro'>

	<div class='page-intro-title blog-title'>
		<?php if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>

		<h1 class='page-title'><?php the_field('blogTitle', 'options'); ?></h1>
	</div>

	<div class='blog-form'>
		<div class='dropdown js-dropdown closed'>
			<ul class='dropdown-list'>
				<?php if( is_home() ){ ?>
					<li class='current'><?php _e('Categories', 'beezup'); ?></li>
				<?php }else{ ?>
					<li><a href='<?php echo get_permalink( get_option('page_for_posts') ); ?>' class='link-arrow'><?php _e('Categories', 'beezup'); ?></a></li>
				<?php } ?>
				<?php wp_list_categories( array('title_li' => '') ); ?>
			</ul>

			<button class='btn-list js-btn-list' type='button'>
				<?php _e('Open catgories list', 'beezup'); ?>
				<svg class='icon'><use xlink:href='#icon-list'></use></svg>
			</button>

			<button class='btn-close js-btn-list' type='button'>
				<?php _e('Close catgories list', 'beezup'); ?>
				<svg class='icon'><use xlink:href='#icon-close'></use></svg>
			</button>
		</div>
		
		<?php get_search_form(); ?>
	</div>

</section>

<section class='container-medium posts-wrapper'>
	<?php if ( have_posts() ) : $count = 0; ?>

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
				<div class='blog-newsletter'>
					<div class='newsletter-txt'>
						<?php if( get_field('blogNewsletterTitle', 'options') ){ ?>
							<h3><?php the_field('blogNewsletterTitle', 'options'); ?></h3>
						<?php } ?>

						<p><?php the_field('blogNewsletterText', 'options'); ?></p>
					</div>

					<?php get_template_part( 'includes/newsletter' ); ?>
				</div>
			<?php } ?>

			<?php if( $count === 4 ){ //demo ?>
				<?php get_template_part( 'includes/demo' ); ?>
			<?php } ?>

		<?php $count ++; endwhile; ?>

		<div class='pagination'>
			<?php echo paginate_links(array( 'prev_text' => __('Previous <svg class="icon"><use xlink:href="#icon-arrow-left"></use></svg>', 'beezup'), 'next_text'  =>  __('Next <svg class="icon"><use xlink:href="#icon-arrow-right"></use></svg>', 'beezup')) ); ?>
		</div>

		<?php get_template_part('includes/free-links'); ?>

	<?php else : ?>

		<p><?php _e("There is no posts yet!", 'beezup'); ?></p>

	<?php endif; ?>
</section>

<?php get_footer(); ?>