<?php get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
	<section class='container-small'>
		<?php if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb(); } ?>

		<h1>
			<?php the_title(); ?>
			<?php if( get_field('title2') ){ ?>
				<span><?php the_field('title2'); ?></span>
			<?php } ?>
		</h1>

		<span><?php _e('Add on', 'beezup'); ?> <?php echo get_the_date(); ?></span>
	</section>
		
	<?php
		if( have_rows('content') ){
			while ( have_rows('content') ){ the_row();
				if( get_row_layout() == 'wysiwyg' ){ ?>
					<section class='container-small'><?php the_sub_field('wysiwyg'); ?></section>
				<?php }elseif( get_row_layout() == 'blockFull' ){ ?>
					<section class='block-full'>
						<div class='container-small'><?php the_sub_field('blockFull'); ?></div>
					</section>
				<?php }
			}
		}
	?>

	<?php get_template_part('includes/free-links'); ?>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>