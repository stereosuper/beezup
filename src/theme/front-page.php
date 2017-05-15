<?php 
/*
Template Name: Home
*/

get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
	<section class='container'>
		<h1>
			<?php the_title(); ?>
			<?php if( get_field('title2') ){ ?>
				<span><?php the_field('title2'); ?></span>
			<?php } ?>
		</h1>

		<?php if( get_field('headerBtn') ){ ?>
			<button class='btn'><?php the_field('headerBtn'); ?></button>
		<?php } ?>

		<?php the_post_thumbnail( 'full' ); ?>

		<?php if( get_field('title') ){ ?>
			<h2 class='h1'>
				<?php the_field('title'); ?>
				<?php if( get_field('titleBlack') ){ ?>
					<span><?php the_field('titleBlack'); ?></span>
				<?php } ?>
			</h2>
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
						<a href='<?php the_sub_field('lien'); ?>'><?php the_sub_field('texte'); ?></a>
					</li>
				<?php } ?>
			</ol>
		<?php } ?>
	</section>
	
	<section class='block-full'>
		<?php if( have_rows('numbers') ){ ?>
			<ul class='container'>
				<?php while( have_rows('numbers') ){ the_row(); ?>
					<li>
						<svg class='icon <?php the_sub_field('icon'); ?>'><use xlink:href='#<?php the_sub_field('icon'); ?>'></use></svg>
						<?php the_sub_field('number'); ?>
						<?php the_sub_field('text'); ?>
						<?php if( get_sub_field('linkText') && get_sub_field('link') ){ ?>
							<a href='<?php the_sub_field('link'); ?>' class='link-arrow'>
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

		<?php if( have_rows('people') ){ ?>
			<ul>
				<?php while( have_rows('people') ){ the_row(); ?>
					<li>
						<?php the_sub_field('name'); ?>
						<?php the_sub_field('job'); ?>
						<?php echo wp_get_attachment_image( get_sub_field('photo'), 'full' ); ?>
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
						<h3><?php the_title(); ?></h3>
						<?php the_post_thumbnail('large'); ?>
						<?php the_excerpt(); ?>
					</li>
				<?php } ?>
			</ul>
		</section>
	<?php } wp_reset_query(); ?>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>