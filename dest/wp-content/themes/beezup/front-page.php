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
		<div class='wrapper-blocks-half'>
			<div class='block-half'>
				<?php if( have_rows('people', 'options') ){ ?>
					<ul class='members'>
						<?php while( have_rows('people', 'options') ){ the_row(); ?>
							<li>
								<span class='photo' style="background-image: url(<?php echo wp_get_attachment_image_url( get_sub_field('photo', 'options'), 'full' ); ?>);"></span>
								<span class='name'><?php the_sub_field('name', 'options'); ?></span>
								<span class='job '><?php the_sub_field('job', 'options'); ?></span>
							</li>
						<?php } ?>
					</ul>
				<?php } ?>
			</div>
			<div class='block-half block-txt'>
				<svg class='icon icon-academy'><use xlink:href='#icon-academy'></use></svg>
				<?php if( get_field('academyTitle') ){ ?>
					<h2 class='h1'><?php the_field('academyTitle'); ?></h2>
				<?php } ?>
				<?php the_field('academyText'); ?>
			</div>
		</div>
	</section>

	<section class='block-full'>
		<?php if( have_rows('quotes') ){ ?>
			<ul class='container list-quotes'>
				<?php while( have_rows('quotes') ){ the_row(); ?>
					<li>
						<div class='wrapper-txt'>
							<blockquote><?php the_sub_field('quote'); ?></blockquote>
							<span class='bq-author'><?php the_sub_field('author'); ?></span>
							<span class='bq-job'><?php the_sub_field('job'); ?></span>
						</div>
						<div class='wrapper-logo'>
							<?php echo wp_get_attachment_image( get_sub_field('logo'), 'medium' ); ?>
						</div>
					</li>
				<?php } ?>
			</ul>
		<?php } ?>
	</section>

	<section class='container'>
		<div class='wrapper-blocks-half'>
			<div class='block-half block-txt'>
				<svg class='icon icon-globe'><use xlink:href='#icon-globe'></use></svg>
				<?php if( get_field('networkTitle') ){ ?>
					<h2 class='h1'><?php the_field('networkTitle'); ?></h2>
				<?php } ?>
				<?php the_field('networkText'); ?>
			</div>
			<div class='block-half big-img'>
				<?php echo wp_get_attachment_image( get_field('networkImg'), 'full' ); ?>
			</div>
		</div>
	</section>

	<?php $lastPosts = new WP_Query( array('posts_per_page' => 3) ); ?>
	<?php if( $lastPosts->have_posts() ){ ?>
		<section class='container'>
			<svg class='icon icon-blog'><use xlink:href='#icon-blog'></use></svg>
			<?php if( get_field('blogTitle') ){ ?>
				<h2 class='h1'><?php the_field('blogTitle'); ?></h2>
			<?php } ?>

			<ul class='list-articles'>
				<?php while( $lastPosts->have_posts() ){ $lastPosts->the_post(); ?>
					<li>
						<a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'>
							<time class='article-date'><?php echo get_the_date(); ?></time>
							<span class='article-image' style="background-image: url(<?php echo the_post_thumbnail_url('large'); ?>);"></span>
							<h3 class='article-title'><?php the_title(); ?></h3>
							<span class='link-arrow'><?php _e('Lire la suite', 'beezup'); ?></span>
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