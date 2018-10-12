<?php 
/*
Template Name: Contact
*/

// include_once( 'includes/form-handler.php' );

get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
	<section class='container-medium page-intro small-margin'>
        <div class='page-intro-title'>
            <?php // if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>
            
            <h1 class='page-title'>
                <?php get_field('title') ? the_field('title') : the_title(); ?>
            </h1>

            <?php if( get_field('subtitle') ){ ?>
                <h2><?php the_field('subtitle'); ?></h2>
            <?php } ?>

            <?php the_field('text'); ?>
        </div>
        <div class='page-intro-img'>
            <?php the_post_thumbnail( 'full' ); ?>
        </div>
    </section>
    
    <section class="cards container relative">
        <div class="card alternative">
            <div class="card-content">
                <div class="card-content-icon">
                    <svg class='icon icon-phone-bubble'><use xlink:href='#icon-phone-bubble'></use></svg>
                </div>
                <div class="card-content-text">
                    <h2>Contact direct</h2>
                    <p>Service commercial et Service client</p>
                    <a class="phone" href="tel:0183624765">01 83 62 47 65</a>
                    <p class="fake-link">horaires : 10h-12h et 15h-18h</p>
                </div>
            </div>
        </div>
        <a class="card" href="#contact-form">
            <div class="card-content">
                <div class="card-content-icon">
                    <svg class='icon icon-mail-bubble'><use xlink:href='#icon-mail-bubble'></use></svg>
                </div>
                <div class="card-content-text">
                    <h2>Nous vous recontactons</h2>
                    <p>Laissez-nous un message avec vos coordonnées</p>
                    <p class="fake-link">Accéder au formulaire</p>
                </div>
            </div>
        </a>
        <a class="card" href="#contact-calendly">
            <div class="card-content">
                <div class="card-content-icon">
                    <svg class='icon icon-calendar-bubble'><use xlink:href='#icon-calendar-bubble'></use></svg>
                </div>
                <div class="card-content-text">
                    <h2>Rendez-vous</h2>
                    <p>Réservez votre démonstration avec l’un de nos experts</p>
                    <p class="fake-link">Accéder au calendrier</p>
                </div>
            </div>
        </a>
    </section>
    

    <?php if(get_field('contactId', 'options') && get_field('contactLists', 'options')): ?>
        <section id="contact-form-will-scroll" class='contact-form container-medium relative'>
            <div class='block-half is-alone'>
                <h2 class="title">Laissez-nous vos coordonnées, nous vous recontacterons</h2>
                <p class="sub-title">Vous êtes déjà client, et souhaitez contacter le service support, <a href="">c’est par ici</a></p>
                <?php // get_template_part( 'includes/form' ); ?>
                <?php get_template_part( 'includes/sib-form' ); ?>
            </div>

            <?php if( have_rows('people', 'options') ){ $count = 0; ?>
                <ul class='members'>
                    <?php while( have_rows('people', 'options') ){ $count ++; the_row(); ?>
                        <?php if($count < 3){ ?>
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
                        <?php } ?>
                    <?php } ?>
                </ul>
            <?php } ?>
        </section>
        <?php endif; ?>
        
        <hr>

        <section id="contact-calendly-will-scroll" class="contact-calendly container-medium relative">
            <h2 class="title">Réservez votre démo BeezUP avec l'un de nos experts</h2>
            <div class="iframe-wrapper">
                <iframe src="<?php the_field('calendly', 'options'); ?>" frameborder="0"></iframe>
            </div>
        </section>

    <?php get_template_part('includes/free-links'); ?>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>