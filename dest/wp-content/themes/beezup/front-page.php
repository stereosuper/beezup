<?php 
/*
Template Name: Home
*/

get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
	<section class='container wrapper-sticky'>
		<?php $imgResponsive = "<img class='illus-responsive' src='" . get_stylesheet_directory_uri() . "/layoutImg/block-beezup.png' srcset='" . get_stylesheet_directory_uri() . "/layoutImg/block-beezup@2x.png 2x' alt=''>"; ?>
		<?php echo apply_filters( 'bj_lazy_load_html', $imgResponsive); ?>

		<div class='block-half block-txt block-title-home'>
			<h2 class='title-home h1'><?php the_field('title2'); ?></h2>

			<?php if( get_field('headerBtn') ){ ?>
				<button class='btn' id='btnTopHome' type='button'>
					<?php the_field('headerBtn'); ?>
				</button>
			<?php } ?>
		</div>

		<div class='block-half block-txt block-title-home-2' id='titleHome'>
			<h1 class='title-home'><?php the_field('title'); ?></h1>

			<p class='intro-home'><?php the_field('headerText'); ?></p>

			<?php if( get_field('headerBtn2') ){ ?>
				<a id="home-page-contact-button" class='btn btn-arrow btn-intro-home' href='<?php the_field('contactLink', 'options'); ?>' title='<?php the_field('headerBtn2'); ?>'>
					<span><?php the_field('headerBtn2'); ?></span>
					<svg class='icon icon-arrow-right'><use xlink:href='#icon-arrow-right'></use></svg>
				</a>
			<?php } ?>
		</div>

		<div class='wrapper-svg-home'>
			<?php get_template_part( 'includes/schema' ); ?>
			
			<div class='text-illus market-places' data-schema-text='marketplace'>
				<div><strong><?php the_field('marketplaceText'); ?></strong></div>
			</div>
			
			<div class='text-illus google-shopping' data-schema-text='ads'>
				<div><strong><?php the_field('productText'); ?></strong></div>
			</div>

			<div class='text-illus comparator' data-schema-text='comparator'>
				<div><strong><?php the_field('comparatorText'); ?></strong></div>
			</div>

			<div class='text-illus affiliate' data-schema-text='affiliation'>
				<div><strong><?php the_field('affiliationText'); ?></strong></div>
			</div>

			<div class='text-illus retargeting' data-schema-text='retargeting'>
				<div><strong><?php the_field('retargetingText'); ?></strong></div>
			</div>

			<div class='text-illus your-shop'>
				<div><strong><?php the_field('shopText'); ?></strong></div>
			</div>
		</div>

		<div class='wrapper-list-menu-home'>
			<?php if( have_rows('anchors') ){ ?>
				<ol class='list-menu'>
					<?php while( have_rows('anchors') ){ the_row(); ?>
						<li>
							<a href='<?php the_sub_field('lien'); ?>' class='link-arrow' title='<?php the_sub_field('texte'); ?>'><?php the_sub_field('texte'); ?></a>
						</li>
					<?php } ?>
				</ol>
			<?php } ?>
		</div>
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
							<a href='<?php the_sub_field('link'); ?>' title="<?php the_sub_field('linkText'); ?>" class='link-arrow'>
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
			<div class='block-half block-visu'>
				<?php if( have_rows('people', 'options') ): ?>
					<ul class='members'>
						<?php $members_count = 0; ?>
						<?php while( have_rows('people', 'options') && $members_count < 3 ): the_row(); ?>
							<?php if (in_array("home", get_sub_field('position', 'options'))): ?>
								<li class='member' style='background-image: url(<?php echo wp_get_attachment_image_url( get_sub_field('photo', 'options'), 'full' ); ?>);' itemscope itemtype='http://schema.org/Person'>
									<span class='name' itemprop='name'><?php the_sub_field('name', 'options'); ?></span>
									<span class='job' itemprop='jobTitle'><?php the_sub_field('job', 'options'); ?></span>
									
									<svg class='bees js-bees' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12.8 32.1'>	
										<path class='js-bee' d='M9.4,30.3C9.4,30.3,9.4,30.3,9.4,30.3c0.5,0,0.9,0.4,0.9,0.8c0,0,0,0,0,0.1c0,0.5-0.4,0.9-0.9,0.9 s-0.9-0.4-0.9-0.9c0,0,0-0.1,0-0.1C8.5,30.7,8.9,30.3,9.4,30.3C9.4,30.3,9.4,30.3,9.4,30.3L9.4,30.3z'/>
										<path class='js-bee' d='M2.5,25.3c0.5,0,0.8,0.4,0.8,0.8c0,0.5-0.4,0.8-0.8,0.8s-0.8-0.4-0.8-0.8C1.7,25.6,2.1,25.3,2.5,25.3 C2.5,25.3,2.5,25.3,2.5,25.3L2.5,25.3z'/>
										<path class='js-bee' d='M8.5,19.4c0.9,0,1.7,0.8,1.7,1.7c0,0.9-0.8,1.7-1.7,1.7S6.8,22,6.8,21.1c0,0,0,0,0,0 C6.8,20.1,7.6,19.4,8.5,19.4C8.5,19.4,8.5,19.4,8.5,19.4L8.5,19.4z'/>
										<circle class='js-bee' cx='6' cy='17.7' r='0.9'/>
										<path class='js-bee' d='M1.7,11.8c0.9,0,1.7,0.8,1.7,1.7c0,0.9-0.8,1.7-1.7,1.7S0,14.4,0,13.5C0,12.6,0.8,11.8,1.7,11.8 C1.7,11.8,1.7,11.8,1.7,11.8L1.7,11.8z'/>
										<path class='js-bee' d='M11.9,8.4c0.4,0,0.8,0.4,0.8,0.8c0,0.5-0.4,0.8-0.8,0.8s-0.8-0.4-0.8-0.8C11.1,8.8,11.5,8.4,11.9,8.4 C11.9,8.4,11.9,8.4,11.9,8.4L11.9,8.4z'/>
										<circle class='js-bee' cx='6' cy='0.9' r='0.9'/>
									</svg>
								</li>
							<?php $members_count += 1; ?>
							<?php endif; ?>
						<?php endwhile; ?>
					</ul>
				<?php endif; ?>
			</div>
			
			<div class='block-half block-txt'>
				<svg class='icon icon-title icon-academy'><use xlink:href='#icon-academy'></use></svg>
				<?php if( get_field('academyTitle') ){ ?>
					<h2 class='h1'><?php the_field('academyTitle'); ?></h2>
				<?php } ?>
				<?php the_field('academyText'); ?>
			</div>
		</div>
	</section>

	<section class='block-full' id='customers'>
		<?php if( have_rows('quotes') ){ ?>
			<ul class='container list-quotes'>
				<?php while( have_rows('quotes') ){ the_row(); ?>
					<li>

						<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 38 15' class='js-bees bees'>
							<circle cx='25' cy='5' r='2' class='js-bee'/>
							<circle cx='21' cy='8' r='1' class='js-bee'/>
							<circle cx='16' cy='13' r='2' class='js-bee'/>
							<circle cx='31' cy='12' r='1' class='js-bee'/>
							<circle cx='37' cy='4' r='1' class='js-bee'/>
							<circle cx='11' cy='1' r='1' class='js-bee'/>
							<path d='M1,7c0.6,0,1,0.4,1,1c0,0.6-0.4,1-1,1S0,8.6,0,8C0,7.4,0.4,7,1,7z' class='js-bee'/>

						</svg>
						<div class='wrapper-txt'>
							<blockquote><?php the_sub_field('quote'); ?></blockquote>
							<span class='bq-author'><?php the_sub_field('author'); ?></span>
							<span class='bq-job'><?php the_sub_field('job'); ?></span>
						</div>

						<div class='wrapper-logo'>
							<?php echo apply_filters( 'bj_lazy_load_html', wp_get_attachment_image( get_sub_field('logo'), 'medium' )); ?>
						</div>

					</li>
				<?php } ?>
			</ul>
		<?php } ?>
	</section>

	<section class='container'>
		<div class='wrapper-blocks-half'>
			<div class='block-half block-txt'>
				<svg class='icon icon-title icon-globe'><use xlink:href='#icon-globe'></use></svg>
				<?php if( get_field('networkTitle') ){ ?>
					<h2 class='h1'><?php the_field('networkTitle'); ?></h2>
				<?php } ?>
				<?php the_field('networkText'); ?>
			</div>
			
			<div class='block-half block-visu big-img'>
				<?php echo apply_filters( 'bj_lazy_load_html', wp_get_attachment_image( get_field('networkImg'), 'full' )); ?>
			</div>
		</div>
	</section>

	<?php $lastPosts = new WP_Query( array('posts_per_page' => 3, 'ignore_sticky_posts' => 1) ); ?>
	<?php if( $lastPosts->have_posts() ){ ?>
		<section class='container'>
			<svg class='icon icon-blog title-icon'><use xlink:href='#icon-blog'></use></svg>
			<?php if( get_field('blogTitle') ){ ?>
				<h2 class='h1 small-m align-center'><?php the_field('blogTitle'); ?></h2>
			<?php } ?>

			<ul class='list-small-posts'>
				<?php while( $lastPosts->have_posts() ){ $lastPosts->the_post(); ?>
					<li>
						<a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>' class='small-post'>
							<time class='small-post-date' datetime='<?php the_time('c');?>'><?php echo get_the_date(); ?></time>
							<?php if( has_post_thumbnail() ){ ?>
								<div class='small-post-image' style="background-image: url(<?php echo the_post_thumbnail_url('large'); ?>);"></div>
							<?php } ?>
							<h3 class='small-post-title'><?php the_title(); ?></h3>
							<span class='link-arrow'><?php _e('Read more', 'beezup'); ?></span>
						</a>
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
