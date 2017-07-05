<!DOCTYPE html>

<html <?php language_attributes(); ?> class='no-js'>
	
	<head>
		<meta charset='utf-8'>
		<meta name='viewport' content='width=device-width,initial-scale=1'>
		<meta name='format-detection' content='telephone=no'>

		<link rel='alternate' type='application/rss+xml' title='BeezUP Feed' href='<?php bloginfo('rss2_url'); ?>'>
		<link rel='alternate' href='<?php echo site_url(); ?>' hreflang='x-default'>

		<link rel='apple-touch-icon' sizes='180x180' href='/apple-touch-icon.png'>
		<link rel='icon' type='image/png' sizes='32x32' href='/favicon-32x32.png'>
		<link rel='icon' type='image/png' sizes='16x16' href='/favicon-16x16.png'>
		<link rel='manifest' href='/manifest.json'>
		<link rel='mask-icon' href='/safari-pinned-tab.svg' color='#00a0f0'>
		<meta name='apple-mobile-web-app-title' content='BeezUP'>
		<meta name='application-name' content='BeezUP'>
		<meta name='theme-color' content='#fff'>

		<?php wp_head(); ?>

		<!-- Calendly style -->
		<link href='https://calendly.com/assets/external/widget.css' rel='stylesheet'>

		<script>document.getElementsByTagName('html')[0].className = 'js';</script>

		<?php if( get_field("ga", "options") ){ ?>
			<script>
				(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
				ga('create', '<?php the_field("ga", "options") ?>', 'auto');
				ga('send', 'pageview');
			</script>
		<?php } ?>
	</head>

	<body <?php body_class('wrapper-sticky'); ?>>

		<div class='wrapper'>

			<header id='header' role='banner' class='header'>
				<div class='container'>
					
					<div class='wrapper-logo'>
						<a class='logo-header' href='<?php echo home_url('/'); ?>' title='BeezUP' rel='home'>
							<img src='<?php echo get_template_directory_uri(); ?>/layoutImg/beezup-gestionnaire-de-flux-e-commerce.svg' alt='<?php _e("Beezup, gestionnaire de flux e-commerce", "beezup"); ?>'>
						</a>

						<button id='btnMenu' class='btn-menu' type='button'><?php _e('Open menu', 'beezup'); ?><span></span></button>
					</div>
					
					<div class='nav'>	
						<div id='containerMenuHead' class='container-menu-head'>
							<button id='btnMenuClose' class='btn-menu-close' type='button'><?php _e('Close menu', 'beezup'); ?></button>
							
							<div class='wrapper-menu-head'>
								<?php echo beezup_mlp_navigation(); ?>
								<ul id='menuHead' class='menu-head'>
									<?php if( get_field('contactLink', 'options') && get_field('contactLinkText', 'options') ){ ?>
										<li class='head-contact'>
											<a href='<?php the_field('contactLink', 'options'); ?>'>
												<svg class='icon icon-envelop'><use xlink:href='#icon-envelop'></use></svg>
												<span><?php the_field('contactLinkText', 'options'); ?></span>
											</a>
										</li>
									<?php } ?>
									<?php if( get_field('connectLink', 'options') && get_field('connectLinkText', 'options') ){ ?>
										<li class='head-connect'>
											<a href='<?php the_field('connectLink', 'options'); ?>' target='_blank' rel='nofollow'>
												<svg class='icon icon-user'><use xlink:href='#icon-user'></use></svg>
												<span><?php the_field('connectLinkText', 'options'); ?></span>
											</a>
										</li>
									<?php } ?>
								</ul>
							</div>
						</div>
						
						<div class='container-menu-main'>
							<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'nav', 'menu_class' => 'menu-main', 'menu_id' => 'menuMain', 'walker' => new Child_Wrap() ) ); ?>
							<button id='btnDemo' class='btn' onclick="Calendly.showPopupWidget('<?php the_field('calendly', 'options'); ?>');return false;" type='button'><?php _e('Demo', 'Beezup'); ?></button>
						</div>
					</div>

					<div id='bgMobile' class='bg-mobile-nav'></div>

				</div>
			</header>

			<main role='main' class='main wrapper-sticky'>
