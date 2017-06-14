<?php 
/*
Template Name: Contact
*/

include_once( 'includes/form-handler.php' );

get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
	<section class='container-medium page-intro small-margin'>
        <div class='page-intro-title'>
            <?php if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>
            
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

    <section class='container relative'>
        <div class='block-half is-alone'>
            <?php get_template_part( 'includes/form' ); ?>
        </div>

        <?php if( have_rows('people', 'options') ){ ?>
            <ul class='members'>
                <?php while( have_rows('people', 'options') ){ the_row(); ?>
                    <li class='member'>
                        <span class='photo' style='background-image: url(<?php echo wp_get_attachment_image_url( get_sub_field('photo', 'options'), 'full' ); ?>);'></span>
                        <span class='name'><?php the_sub_field('name', 'options'); ?></span>
                        <span class='job '><?php the_sub_field('job', 'options'); ?></span>
                        <svg class='icon icon-flux-vertical'><use xlink:href='#icon-flux-vertical'></use></svg>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </section>

    <?php get_template_part('includes/free-links'); ?>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>