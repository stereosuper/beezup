<?php get_header(); ?>

<div class='container-small'>
	<?php if ( have_posts() ) : the_post(); ?>

		<h1>
			<?php the_title(); ?>
			<?php if(get_field('title2')){ ?>
				<span><?php the_field('title2'); ?></span>
			<?php } ?>
		</h1>
		<?php the_content(); ?>

	<?php else : ?>

		<h1>404</h1>

	<?php endif; ?>
</div>

<?php get_footer(); ?>