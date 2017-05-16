<?php 
/*
Template Name: Home
*/

get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
	<section class='container'>
		<h2 class='h1'>
			<?php the_title(); ?>
			<?php if( get_field('title2') ){ ?>
				<span><?php the_field('title2'); ?></span>
			<?php } ?>
		</h2>

		<?php if( get_field('headerBtn') ){ ?>
			<a href='#flux' class='btn' title='<?php _e('Gestion du flux e-commerce - BeezUP', 'beezup'); ?>'><?php the_field('headerBtn'); ?></a>
		<?php } ?>

		<?php the_post_thumbnail( 'full' ); ?>

		<?php if( get_field('title') ){ ?>
			<h1>
				<?php the_field('title'); ?>
				<?php if( get_field('titleBlack') ){ ?>
					<span><?php the_field('titleBlack'); ?></span>
				<?php } ?>
			</h1>
		<?php } ?>

		<?php the_field('headerText'); ?>

		<?php if( get_field('headerBtn2') ){ ?>
			<button class='btn-arrow' data-appointlet-organization='beezup' data-appointlet-service='32290'>
				<?php the_field('headerBtn2'); ?>
			</button>
		<?php } ?>

		<?php if( have_rows('anchors') ){ ?>
			<ol>
				<?php while( have_rows('anchors') ){ the_row(); ?>
					<li>
						<a href='<?php the_sub_field('lien'); ?>' title='<?php the_sub_field('texte'); ?>'><?php the_sub_field('texte'); ?></a>
					</li>
				<?php } ?>
			</ol>
		<?php } ?>
	</section>
	
	<section class='block-full'>
		<?php if( have_rows('numbers') ){ ?>
			<ul class='container list-picto'>
				<?php while( have_rows('numbers') ){ the_row(); ?>
					<li>
						<svg class='icon <?php the_sub_field('icon'); ?>'><use xlink:href='#<?php the_sub_field('icon'); ?>'></use></svg>
						<h3>
							<strong><?php the_sub_field('number'); ?></strong>
							<?php the_sub_field('text'); ?>
						</h3>
						<?php if( get_sub_field('linkText') && get_sub_field('link') ){ ?>
							<a href='<?php the_sub_field('link'); ?>' title='<?php the_sub_field('linkText'); ?>' class='link-arrow'>
								<?php the_sub_field('linkText'); ?>
							</a>
						<?php } ?>
					</li>
				<?php } ?>
			</ul>
		<?php } ?>
	</section>
	
	<section class='container'>
		<?php if( get_field('academyTitle') ){ ?>
			<h2 class='h1'><?php the_field('academyTitle'); ?></h2>
		<?php } ?>
		
		<?php the_field('academyText'); ?>

		<?php if( have_rows('people', 'options') ){ ?>
			<ul>
				<?php while( have_rows('people', 'options') ){ the_row(); ?>
					<li>
						<?php the_sub_field('name', 'options'); ?>
						<?php the_sub_field('job', 'options'); ?>
						<?php echo wp_get_attachment_image( get_sub_field('photo', 'options'), 'full' ); ?>
					</li>
				<?php } ?>
			</ul>
		<?php } ?>
	</section>

	<section class='block-full'>
		<?php if( have_rows('quotes') ){ ?>
			<ul class='container'>
				<?php while( have_rows('quotes') ){ the_row(); ?>
					<li>
						<blockquote><?php the_sub_field('quote'); ?></blockquote>
						<?php the_sub_field('author'); ?>
						<?php the_sub_field('job'); ?>
						<?php echo wp_get_attachment_image( get_sub_field('logo'), 'medium' ); ?>
					</li>
				<?php } ?>
			</ul>
		<?php } ?>
	</section>

	<section class='container'>
		<?php if( get_field('networkTitle') ){ ?>
			<h2 class='h1'><?php the_field('networkTitle'); ?></h2>
		<?php } ?>

		<?php the_field('networkText'); ?>

		<?php echo wp_get_attachment_image( get_field('networkImg'), 'full' ); ?>
	</section>

	<?php $lastPosts = new WP_Query( array('posts_per_page' => 3) ); ?>
	<?php if( $lastPosts->have_posts() ){ ?>
		<section class='container'>
			<?php if( get_field('blogTitle') ){ ?>
				<h2 class='h1'><?php the_field('blogTitle'); ?></h2>
			<?php } ?>

			<ul>
				<?php while( $lastPosts->have_posts() ){ $lastPosts->the_post(); ?>
					<li>
						<a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'>
							<?php echo get_the_date(); ?>
							<?php the_post_thumbnail('large'); ?>
							<h3><?php the_title(); ?></h3>
							<span><?php _e('Lire la suite', 'beezup'); ?></span>
						</a>
					</li>
				<?php } ?>
			</ul>
		</section>
	<?php } wp_reset_query(); ?>

	<?php get_template_part('includes/free-links'); ?>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>