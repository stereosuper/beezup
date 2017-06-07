<?php 
/*
Template Name: Tarifs
*/

get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
	<section class='container page-intro'>
        
        <div class='page-intro-title'>
            <?php if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>

            <h1 class='page-title'>
                <?php get_field('title') ? the_field('title') : the_title(); ?>
            </h1>
            <?php the_field('intro'); ?>
        </div>
        
        <div class='page-intro-img'>
            <p><?php the_field('benefit1'); ?></p>
            <p><?php the_field('benefit2'); ?></p>
        </div>

    </section>

    <section class='container'>
        
        <?php the_field('price'); ?>
        <ul>
            <li><?php _e('1 month', 'beezup'); ?></li>
            <li><?php _e('3 months', 'beezup'); ?></li>
            <li><?php _e('6 months', 'beezup'); ?></li>
            <li><?php _e('1 year', 'beezup'); ?></li>
        </ul>

        <?php if( have_rows('offers') ){ ?>
            <?php while( have_rows('offers') ){ the_row(); ?>
                <h2><?php the_sub_field('name'); ?></h2>
               
                <p>
                    <?php the_sub_field('price1'); ?>
                    <?php the_sub_field('price2'); ?>
                    <?php the_sub_field('price3'); ?>
                    <?php the_sub_field('price4'); ?>
                </p>

                <?php if( get_sub_field('url') ){ ?>
                    <a href='<?php the_field('url'); ?>' class='btn btn-arrow'>
                        <?php the_sub_field('btn'); ?>
                        <svg class='icon'><use xlink:href='#icon-arrow-right'></use></svg>
                    </a>
                <?php } ?>
            <?php } ?>
        <?php } ?>

        <?php if( have_rows('featuresSection') ){ ?>
            <?php while( have_rows('featuresSection') ){ the_row(); ?>
                <h3><?php the_sub_field('title'); ?> <i><?php the_sub_field('subtitle'); ?></i></h3>

                <?php if( have_rows('features') ){ ?>
                    <?php while( have_rows('features') ){ the_row(); ?>
                        <span><?php the_sub_field('title'); ?></span>

                        <?php if( have_rows('detail') ){ ?>
                            <?php while( have_rows('detail') ){ the_row(); ?>
                                <span>
                                    <?php
                                    if( get_sub_field('text') ){
                                        if( get_sub_field('link') ){ ?>
                                            <a href='<?php the_sub_field('link'); ?>'><?php the_sub_field('text'); ?></a>
                                        <?php }else{
                                            the_sub_field('text');
                                        }
                                    }elseif( get_sub_field('check') ){
                                        echo 'check';
                                    }else{
                                        echo 'nope';
                                    }
                                    ?>
                                </span>
                            <?php } ?>
                        <?php } ?>

                    <?php } ?>
                <?php } ?>

            <?php } ?>
        <?php } ?>

        <?php if( get_field('note') ){ ?>
            <i><?php the_field('note'); ?></i>
        <?php } ?>

        <?php if( get_field('fontionnalitesTitle') ){ ?>
            <h2><?php the_field('fontionnalitesTitle'); ?></h2>
        <?php } ?>

    </section>

    <?php get_template_part('includes/free-links'); ?>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>