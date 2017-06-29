<?php get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>

	<article itemscope itemtype='http://schema.org/Article'>
		<section class='container-medium post-single-header page-title-default <?php if( get_field('left') ) echo "left"; ?>'>
			<?php // if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>

			<h1 itemprop='name'>
				<?php get_field('title') ? the_field('title') : the_title(); ?>
			</h1>

			<time datetime='<?php the_time('c');?>' itemprop='dateCreated' class='title-time'><?php _e('Add on', 'beezup'); ?> <?php echo get_the_date(); ?></time>

			<?php the_post_thumbnail('full', array('class' => 'wide')); ?>
		</section>

		<div class='wrapper-sticky'>
				
			<div itemprop='articleBody'>
				<?php get_template_part('includes/content-default'); ?>
			</div>

			<div class='container-small'>
				<ul class='list-cat'><?php wp_list_categories( array('title_li' => '') ); ?></ul>

				<nav id='sideLinksNav' class='side-links share'>
					<ul>
						<li>
							<a href='https://twitter.com/share?url=<?php the_permalink(); ?>&text=<?php the_title(); ?>&via=BeezUP' rel='nofollow' target='_blank' title='<?php _e('Share on', 'beezup'); ?> Twitter'><?php _e('Share on', 'beezup'); ?> Twitter <svg class='icon'><use xlink:href='#icon-twitter'></use></svg></a>
						</li>
						<li>
							<a href='https://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&t=<?php the_title(); ?>' rel='nofollow' target='blank' title='<?php _e('Share on', 'beezup'); ?> Facebook'><?php _e('Share on', 'beezup'); ?> Facebook <svg class='icon'><use xlink:href='#icon-facebook'></use></svg></a>
						</li>
						<li>
							<a href='https://plus.google.com/share?url=<?php the_permalink(); ?>' rel='nofollow' target='blank' title='<?php _e('Share on', 'beezup'); ?> Google +'><?php _e('Share on', 'beezup'); ?> Google + <svg class='icon'><use xlink:href='#icon-google-plus'></use></svg></a>
						</li>
					</ul>
				</nav>
			</div>

			<div class='container-medium'>
				<?php get_template_part( 'includes/demo' ); ?>

				<?php get_template_part( 'includes/related' ); ?>
				
				<?php get_template_part( 'includes/free-links' ); ?>
			</div>
		</div>
	</article>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>