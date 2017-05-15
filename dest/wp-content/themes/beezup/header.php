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

		<header role='banner' class='header'>
			<div class='container'>
				
				<div class='wrapper-logo'>
					<a class='logo-header' href='./' title='BeezUP' rel='home'>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 438.21 262.22">
							<path fill='#319bd2' d='M390.55 103.52c-13.32-6.52-55.93 1.93-95.18 18.87s-60.27 35.95-47 42.46c3.71 1.82 3.3 8.16 10.85 7.79-12.54-6.67 11.09-29.53 45.33-44.31 34.6-14.93 73.45-21.75 86.77-15.24a12.08 12.08 0 0 1 1.47.87c2.85-4.5 2.3-8.22-2.24-10.44zM269.52 120c-2.88-5.19-5.68-10.69-8.33-16.46-18.06-39.25-22.76-75.65-10.48-81.3 9.7-4.46 27.11 11.65 42.9 38-2.87 11.4-2.06 29.85 2.47 51-.91-15.89 1.17-28.63 6.06-35.4q1.78 3.57 3.5 7.29c2.87 6.23 5.4 12.39 7.58 18.37a176.28 176.28 0 0 0-8.43-28.5 11 11 0 0 1 3.76-2c9.62-2.9 22.26 8.46 33.37 27.94-12.39-32.1-29-53.72-40-50.39a10.16 10.16 0 0 0-5.69 5C278.4 18 254.42-5.16 241.06 1c-14.19 6.53-11 43.64 7 82.89A190.16 190.16 0 0 0 269.52 120zM50.25 215.3q16.46-6.5 16.46-21.6 0-20.61-25.25-20.61H0v88.51h40.18q27.67 0 27.67-26.18-.02-16.84-17.6-20.12zm-10.77 32.06H16.4v-60h24q9.16 0 9.16 7.43 0 13.67-20.38 17v10.63h5q16.28 0 16.28 13.8-.08 11.13-10.98 11.14zm68.4-50.75q-32.37 0-32.37 31.75 0 33.23 35.34 33.24a108.14 108.14 0 0 0 22.15-1.86v-13a106.16 106.16 0 0 1-19.68 1.86q-21.42 0-21.42-13.12h42.52q5.76-38.88-26.54-38.87zM119 223.46H91.91q1.11-14 14.11-14 13.86 0 12.98 14zm56.1-26.85q-32.37 0-32.37 31.75 0 33.23 35.34 33.24a108.13 108.13 0 0 0 22.11-1.86v-13a106.15 106.15 0 0 1-19.68 1.86q-21.41 0-21.41-13.12h42.52q5.8-38.88-26.51-38.87zm11.14 26.85h-27.11q1.11-14 14.11-14 13.86 0 13 14zm27.42-13.85h32.49l-33.73 39.61v12.38h50.13v-12.38h-32l33.24-39.61v-13h-50.13v13z'/>
							<path fill='#38393b' d='M276.79 226.81v-53.72h16.39v53.73q0 21.17 21.66 21.17t21.66-21.17v-53.73h16.4v53.73q0 35.4-38.06 35.4t-38.05-35.41zm94.7 34.78v-88.5H413q25.25 0 25.25 22.47 0 26.43-36.46 32.12l-2.35-14.61q21.66-4 21.66-17 0-8.54-9.16-8.54h-24v74.09z'/>
						</svg>
					</a>
				</div>

				<div class='nav'>	
					<div class='container-menu-head'>
						<?php echo beezup_mlp_navigation(); ?>
						<ul class='menu-head'>
							<?php if( get_field('contactLink', 'options') && get_field('contactLinkText', 'options') ){ ?>
								<li>
									<a href='<?php the_field('contactLink', 'options'); ?>'>
										<svg class="icon icon-envelop"><use xlink:href="#icon-envelop"></use></svg>
										<?php the_field('contactLinkText', 'options'); ?>
									</a>
								</li>
							<?php } ?>
							<?php if( get_field('connectLink', 'options') && get_field('connectLinkText', 'options') ){ ?>
								<li>
									<a href='<?php the_field('connectLink', 'options'); ?>'>
										<svg class="icon icon-user"><use xlink:href="#icon-user"></use></svg>
										<?php the_field('connectLinkText', 'options'); ?>
									</a>
								</li>
							<?php } ?>
						</ul>
					</div>
					
					<div class='container-menu-main'>
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'nav', 'menu_class' => 'menu-main' ) ); ?>
						<button class='btn' data-appointlet-organization='beezup' data-appointlet-service='32290'><?php _e('Démo', 'Beezup'); ?></button>
					</div>
				</div>

			</div>
		</header>

		<main role='main' class='main'>
