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

		<meta name="google-site-verification" content="2r_x6px3JdzDZHScbYLKGbI1jx6NqLZhu1zvvCZa8nY" />
		<meta name="google-site-verification" content="9Db3rIQkWYpb2stGqzQMJoDfh-xnmBs-FoCB7OFKD4s" />

		<?php wp_head(); ?>

		<?php beezup_mlp_href_US(); ?>

		<script>document.getElementsByTagName('html')[0].className = 'js';</script>
		<?php if ($ga_id = get_field('gaId', 'options')): ?>
		<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $ga_id; ?>"></script>
		<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', '<?php echo $ga_id; ?>');
		</script>
		<?php endif; ?>
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
									<?php 
										$recruitment_page = get_field('recruitment_page', 'options');
										$recruitment_link_text = get_field('recruitment_link_text', 'options');

										if( $recruitment_page && $recruitment_link_text):
									?>
										<li class='head-recruitment'>
											<a href='<?php echo $recruitment_page ?>'>
												<svg class='icon icon-thumbs-up'><use xlink:href='#icon-thumbs-up'></use></svg>
												<span><?php echo $recruitment_link_text ?></span>
											</a>
										</li>
									<?php endif; ?>
									<?php if( get_field('connectLink', 'options') && get_field('connectLinkText', 'options') ){ ?>
										<li class='head-connect'>
											<a href='<?php the_field('connectLink', 'options'); ?>' target='_blank' rel='nofollow'>
												<svg class='icon icon-user'><use xlink:href='#icon-user'></use></svg>
												<span><?php the_field('connectLinkText', 'options'); ?></span>
											</a>
										</li>
									<?php } ?>
									<?php if( get_field('phoneTel', 'options') ){ ?>
										<li class='head-tel'>
											<a id="header-phone-button" href='tel:<?php echo str_replace(' ', '', get_field('phoneTel', 'options')); ?>' title='<?php _e('Appelez-nous', 'beezup'); ?>'>
												<svg class="icon icon-phone"><use xlink:href="#icon-phone"></use></svg>
												<span><?php the_field('phoneTel', 'options'); ?></span>
											</a>
										</li>
									<?php } ?>
								</ul>
							</div>
						</div>
						
						<div id='containerMenuMain' class='container-menu-main'>
							<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => 'nav', 'menu_class' => 'menu-main', 'menu_id' => 'menuMain', 'walker' => new Child_Wrap() ) ); ?>
							<?php if( get_field('contactLink', 'options') && get_field('contactLinkText', 'options') ){ ?>
								<a id='header-contact-button' class='btn btn-contact' href='<?php the_field('contactLink', 'options'); ?>' title='<?php the_field('contactLinkText', 'options'); ?>'>
									<span><?php the_field('contactLinkText', 'options'); ?></span>
								</a>
							<?php } ?>
						</div>
					</div>

					<div id='bgMobile' class='bg-mobile-nav'></div>

				</div>
			</header>

			<main role='main' class='main wrapper-sticky'>
