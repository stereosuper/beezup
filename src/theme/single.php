<?php get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
	<section class='container-medium post-single-header'>
		<?php if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>

		<h1>
			<?php the_title(); ?>
			<?php if( get_field('title2') ){ ?>
				<span><?php the_field('title2'); ?></span>
			<?php } ?>
		</h1>

		<time datetime='<?php the_time('c');?>' class='title-time'><?php _e('Add on', 'beezup'); ?> <?php echo get_the_date(); ?></time>

		<?php the_post_thumbnail('full', array('class' => 'wide')); ?>
	</section>
		
	<?php get_template_part('includes/content-default'); ?>

	<div class='container-small'>
		<ul class='list-cat'><?php wp_list_categories( array('title_li' => '') ); ?></ul>
	</div>

	<div class='container-medium'>
		<?php get_template_part( 'includes/demo' ); ?>

		<?php get_template_part( 'includes/related' ); ?>
		
		<?php get_template_part( 'includes/free-links' ); ?>
	</div>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>