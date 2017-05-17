<!DOCTYPE html>

<html <?php language_attributes(); ?> class='no-js'>
	
	<head>
		<meta charset='utf-8'>
		<meta name='viewport' content='width=device-width,initial-scale=1'>
		<meta name='format-detection' content='telephone=no'>

		<link rel='alternate' type='application/rss+xml' title='BeezUP Feed' href='<?php echo get_bloginfo('rss2_url') ?>'>

		<?php wp_head(); ?>

		<script>document.getElementsByTagName('html')[0].className = 'js';</script>
	</head>

	<body <?php body_class(); ?>>

		<header id='header' role='banner' class='header'>
			<div class='container'>
				
				<div class='wrapper-logo'>
					<a class='logo-header' href='<?php echo home_url('/'); ?>' title='BeezUP' rel='home'>
						<svg xmlns="http://www.w3.org/2000/svg"  viewBox="0 0 438.25 262.21">
							<path fill="#319bd2" d="M50.25 215.29q16.46-6.5 16.46-21.6 0-20.61-25.25-20.61H0v88.51h40.18q27.67 0 27.67-26.18 0-16.84-17.6-20.12zm-10.77 32.06H16.4v-60h24q9.16 0 9.16 7.43 0 13.67-20.38 17v10.63h5q16.28 0 16.28 13.8-.08 11.13-10.98 11.14zm68.4-50.75q-32.37 0-32.37 31.75 0 33.23 35.34 33.24a108.14 108.14 0 0 0 22.15-1.86v-13a106.16 106.16 0 0 1-19.68 1.86q-21.42 0-21.42-13.12h42.52q5.76-38.88-26.54-38.87zM119 223.45H91.91q1.11-14 14.11-14 13.86 0 12.98 14zm56.1-26.85q-32.37 0-32.37 31.75 0 33.23 35.34 33.24a108.13 108.13 0 0 0 22.11-1.86v-13a106.15 106.15 0 0 1-19.68 1.86q-21.41 0-21.41-13.12h42.52q5.8-38.88-26.51-38.87zm11.14 26.85h-27.11q1.11-14 14.11-14 13.86 0 13 14zm27.42-13.85h32.49l-33.73 39.61v12.38h50.13v-12.38h-32l33.24-39.61v-13h-50.13z"/>
							<path fill="#38393b" d="M276.79 226.8v-53.72h16.39v53.73q0 21.17 21.66 21.17t21.66-21.17v-53.73h16.4v53.73q0 35.4-38.06 35.4t-38.05-35.41zm94.7 34.78v-88.5H413q25.25 0 25.25 22.47 0 26.43-36.46 32.12l-2.35-14.61q21.66-4 21.66-17 0-8.54-9.16-8.54h-24v74.09z"/>
							<path class="bee" fill="#319bd2" d="M241.06.99c13.36-6.16 37.34 17 55.17 52.55a10.16 10.16 0 0 1 5.69-5c11-3.33 27.61 18.29 40 50.39-11.11-19.48-23.75-30.84-33.37-27.94a11 11 0 0 0-3.76 2 176.29 176.29 0 0 1 8.43 28.5c-2.18-6-4.71-12.14-7.58-18.37q-1.72-3.72-3.5-7.29c-4.89 6.77-7 19.51-6.06 35.4-4.53-21.15-5.34-39.6-2.47-51-15.79-26.35-33.2-42.46-42.9-38-12.28 5.65-7.58 42 10.48 81.3 2.65 5.77 5.45 11.27 8.33 16.46a190.16 190.16 0 0 1-21.46-36.11c-18-39.25-21.19-76.36-7-82.89zm151.73 113a12.08 12.08 0 0 0-1.47-.87c-13.32-6.51-52.17.31-86.77 15.24-34.24 14.78-57.87 37.64-45.33 44.31-7.55.37-7.14-6-10.85-7.79-13.27-6.51 7.75-25.52 47-42.46s81.86-25.43 95.18-18.91c4.54 2.22 5.09 5.94 2.24 10.48z"/>
						</svg>
					</a>
				</div>

				<button id='btn-menu' class='btn-menu' type='button'><span></span></button>
				<div class='nav'>	
					<div id='container-menu-head' class='container-menu-head'>
						<button id='btn-menu-close' class='btn-menu-close' type='button'></button>
						<div id='wrapper-menu-head' class='wrapper-menu-head'>
							<?php echo beezup_mlp_navigation(); ?>
							<ul id='menu-head' class='menu-head'>
								<?php if( get_field('contactLink', 'options') && get_field('contactLinkText', 'options') ){ ?>
									<li class="head-contact">
										<a href='<?php the_field('contactLink', 'options'); ?>'>
											<svg class='icon icon-envelop'><use xlink:href='#icon-envelop'></use></svg>
											<span><?php the_field('contactLinkText', 'options'); ?></span>
										</a>
									</li>
								<?php } ?>
								<?php if( get_field('connectLink', 'options') && get_field('connectLinkText', 'options') ){ ?>
									<li class="head-connect">
										<a href='<?php the_field('connectLink', 'options'); ?>'>
											<svg class='icon icon-user'><use xlink:href='#icon-user'></use></svg>
											<span><?php the_field('connectLinkText', 'options'); ?></span>
										</a>
									</li>
								<?php } ?>
							</ul>
						</div>
					</div>
					
					<div class='container-menu-main'>
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'nav', 'menu_class' => 'menu-main' ) ); ?>
						<button class='btn' data-appointlet-organization='beezup' data-appointlet-service='32290'><?php _e('Demo', 'Beezup'); ?></button>
					</div>
				</div>
				<div class='bg-mobile-nav'></div>

			</div>
		</header>

		<main role='main' class='main'>
