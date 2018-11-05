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
    <?php 
    $cards_anchors = get_field('anchors');


    if( have_rows('repeater_field_name') ):

        // loop through the rows of data
        while ( have_rows('repeater_field_name') ) : the_row();

            // display a sub field value
            the_sub_field('sub_field_name');

        endwhile;

    endif;
    ?>
    <?php if(have_rows('anchors')): ?>
        <section class='cards-contact container relative' id='cardsContact'>
            <?php while (have_rows('anchors')) : the_row(); ?>
                <?php $is_link = get_sub_field('is_link'); ?>
                <?php if ($is_link): ?>
                    <div class="card alternative">
                        <div class="card-content">
                            <div class="card-content-icon">
                                <?php 
                                    $icon = get_sub_field('icon');
                                    echo $icon ? file_get_contents($icon['url']) : '';
                                ?>
                            </div>
                            <div class="card-content-text">
                                <h2><?php the_sub_field('title') ?></h2>
                                <p><?php the_sub_field('subtitle') ?></p>
                                <?php if ($phone = get_sub_field('phone')): ?>
                                    <a class="phone" href="tel:<?php echo str_replace(' ', '', $phone) ?>"><?php echo $phone ?></a>
                                <?php endif; ?>
                                <p class="fake-link"><?php the_sub_field('call_to_action') ?></p>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a class="card" href="<?php the_sub_field('id') ?>">
                        <div class="card-content">
                            <div class="card-content-icon">
                                <?php 
                                    $icon = get_sub_field('icon');
                                    echo $icon ? file_get_contents($icon['url']) : '';
                                ?>
                            </div>
                            <div class="card-content-text">
                                <h2><?php the_sub_field('title') ?></h2>
                                <p><?php the_sub_field('subtitle') ?></p>
                                <p class="fake-link"><?php the_sub_field('call_to_action') ?></p>
                            </div>
                        </div>
                    </a>
                <?php endif; ?>
            <?php endwhile; ?>
        </section>
    <?php endif; ?>

    <?php if(get_field('contactId', 'options') && get_field('contactLists', 'options')): ?>
        <section id="contact-form-will-scroll" class='contact-form container-medium relative'>
            <div class='block-half is-alone'>
                <?php if ($form_title = get_field('form_title')): ?>
                    <h2 class="title contact-title"><?php echo $form_title ?></h2>
                <?php endif; ?>
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
        
        <?php 
            $calendly_url = get_field('calendly', 'options');
        ?>
        <?php if ($calendly_url): ?>
            <section id="contact-calendly-will-scroll" class="contact-calendly container-medium relative">
                <h2 class="title contact-title"><?php the_field('calendly_title') ?></h2>
                <div class="iframe-wrapper">
                    <iframe src="<?php echo $calendly_url ?>" frameborder="0"></iframe>
                </div>
            </section>
        <?php endif; ?>

    <?php get_template_part('includes/free-links'); ?>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>