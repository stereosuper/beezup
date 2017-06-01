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
		
	<?php
		if( have_rows('content') ){
			while ( have_rows('content') ){ the_row();
				if( get_row_layout() == 'wysiwyg' ){ ?>
					<section class='container-small'><?php the_sub_field('wysiwyg'); ?></section>
				<?php }elseif( get_row_layout() == 'blockFull' ){ ?>
					<section class='block-full'>
						<div class='container-small'><?php the_sub_field('blockFull'); ?></div>
					</section>
				<?php }elseif( get_row_layout() == 'galery' ){ ?>
					<section class='<?php if( get_sub_field('blueBg') ){ echo "block-full no-pad"; } ?>'>
						<div class='container'>
							<?php $images = get_sub_field('galery'); ?>
							<?php if( $images ){ ?>
							<ul class='galery <?php if( !get_sub_field("photos") ) echo "channels-list"; ?>'>
								<?php foreach( $images as $image ){ ?>
								<li>
									<a href='<?php echo $image['url']; ?>' title='<?php echo $image['caption']; ?>'>
										<img src='<?php echo $image['sizes']['medium']; ?>' alt='<?php echo $image['alt']; ?>'>
									</a>
								</li>
								<?php } ?>
							</ul>
							<?php } ?>
						</div>
					</section>
				<?php }
			}
		}
	?>

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