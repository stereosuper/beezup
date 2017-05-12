<?php get_header(); ?>

	<?php if ( have_posts() ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

			<article>
					
				<h1>
					<?php the_title(); ?>
					<?php if(get_field('title2')){ ?>
						<span><?php the_field('title2'); ?></span>
					<?php } ?>
				</h1>
				<div>
					<?php echo get_the_date(); ?>
				</div>
						
				<?php the_content(); ?>
						
			</article>

		<?php endwhile; ?>


	<?php else : ?>
				
		<article>
			<h1>404</h1>
		</article>

	<?php endif; ?>

<?php get_footer(); ?>
