<?php 
/*
Template Name: Tarifs
*/

include_once( 'includes/form-handler.php' );

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

    <?php if( have_rows('offers') ){
        $nbrOff = 0;
        while( have_rows('offers') ){ the_row(); 
            $nbrOff++;
        }
    } ?>

    <div class='tarifs column-<?php echo $nbrOff;?>'>
        <div class='wrapper-sticky container-tarifs'>
            <div>
                <div id='tarifHeader' class='tarif-header'>
                    <div class='container'>
                        <div class='container-slider'>
                            <span><?php the_field('price'); ?></span>
                            <ul class='slider'>
                                <li class='js-price'><button class='js-btnPrice' data-price='price1' type='button'><?php _e('1 month', 'beezup'); ?></button></li>
                                <li class='js-price'><button class='js-btnPrice' data-price='price2' type='button'><?php _e('3 months', 'beezup'); ?></button></li>
                                <li class='js-price'><button class='js-btnPrice' data-price='price3' type='button'><?php _e('6 months', 'beezup'); ?></button></li>
                                <li class='js-price selected'><button class='js-btnPrice' data-price='price4' type='button'><?php _e('1 year', 'beezup'); ?></button></li>
                            </ul>
                        </div>

                        <?php if( have_rows('offers') ){ ?>
                        <div id='tarifOffers' class='offers'>
                            <?php while( have_rows('offers') ){ the_row(); ?>
                            <div class='offer <?php echo strtolower(get_sub_field("name")); ?>'>
                                <h2><?php the_sub_field('name'); ?></h2>
                                <div class='offer-spec'>
                                    <span class='js-fieldprice1 price hidden'>
                                        <?php the_sub_field('price1'); ?>
                                    </span>
                                    <span class='js-fieldprice2 price hidden'>
                                        <?php the_sub_field('price2'); ?>
                                    </span>
                                    <span class='js-fieldprice3 price hidden'>
                                        <?php the_sub_field('price3'); ?>
                                    </span>
                                    <span class='js-fieldprice4 price'>
                                        <?php the_sub_field('price4'); ?>
                                    </span>

                                    <?php if( get_sub_field('url') ){ ?>
                                        <a href='<?php the_field('url'); ?>' class='btn btn-arrow'>
                                            <?php the_field('btn'); ?>
                                            <svg class='icon'><use xlink:href='#icon-arrow-right'></use></svg>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <section class='container tarif-body'>
                            <?php if( have_rows('featuresSection') ){ ?>
                            <div class='wrapper-tarif-content'>

                                <?php if( have_rows('offers') ){ ?>
                                <div class='color-column'>
                                    <?php while( have_rows('offers') ){ the_row(); ?>
                                    <div class='<?php echo strtolower(get_sub_field("name")); ?>'></div>
                                    <?php } ?>
                                </div>
                                <?php } ?>

                                <ul class='tarif-content'>
                                    <?php while( have_rows('featuresSection') ){ the_row(); ?>
                                    <li class='section-feature'><ul>

                                        <h3><?php the_sub_field('title'); ?> <i><?php the_sub_field('subtitle'); ?></i></h3>

                                        <?php if( have_rows('features') ){ ?>

                                            <?php while( have_rows('features') ){ the_row(); ?>
                                            <li class='feature'>
                                                <span class='feature-title'><?php the_sub_field('title'); ?></span>

                                                <?php if( have_rows('detail') ){ ?>
                                                <div class='feature-content'>
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
                                                                echo '<svg class="icon icon-check"><use xlink:href="#icon-check"></use></svg>';
                                                            }
                                                            ?>
                                                        </span>
                                                    <?php } ?>
                                                </div>
                                            <?php } ?>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    </ul></li>
                                <?php } ?>
                                </ul>
                            </div>
                        <?php } ?>
                            <div class='tarif-footer'>
                                <span>
                                    <svg class='icon'><use xlink:href='#icon-tripuce'></use></svg>
                                </span>
                                <span>
                                    <svg class='icon'><use xlink:href='#icon-tripuce'></use></svg>
                                </span>
                                <span>
                                    <svg class='icon'><use xlink:href='#icon-tripuce'></use></svg>
                                </span>
                                <span>
                                    <svg class='icon'><use xlink:href='#icon-tripuce'></use></svg>
                                </span>
                            </div>

                </section>
            </div>
        </div>
    </div>

        <section class='container'>
            <?php if( get_field('note') ){ ?>
                <p class='tarif-note'><?php the_field('note'); ?></p>
            <?php } ?>
        </section>

        <section class='container'>
        <?php if( get_field('fontionnalitesTitle') ){ ?>
            <h2 class='h1'><?php the_field('fontionnalitesTitle'); ?></h2>
        <?php } ?>

        <?php if( have_rows('sections') ){ $i = 0; ?>
            <?php while( have_rows('sections') ){ the_row(); ?>
                <div class='subsection <?php echo ($i%2 !== 0 ? 'odd' : 'even') ?>'>
                    <div class='subsection-text'>
                        <?php if( get_sub_field('title') ){ ?>
                            <h3 class='h2'><?php the_sub_field('title'); ?></h3>
                        <?php } ?>

                        <?php the_sub_field('text'); ?>

                        <?php if( get_sub_field('star') ){ ?>
                            <div class='star'><?php the_sub_field('star'); ?></div>
                        <?php } ?>

                        <?php if( get_sub_field('link') && get_sub_field('linkText') ){ ?>
                            <a href='<?php the_sub_field('link'); ?>' class='link-arrow' title='<?php the_sub_field('linkText'); ?>'><?php the_sub_field('linkText'); ?></a>
                        <?php } ?>
                    </div>

                    <div class='subsection-illu'>
                        <?php echo wp_get_attachment_image( get_sub_field('img'), 'full' ); ?>
                    </div>
                </div>
            <?php $i++; } ?>
        <?php } ?>

        <?php if( get_field('contactTitle') ){ ?>
            <h2 class='h1'><?php the_field('contactTitle'); ?></h2>
        <?php } ?>

        <?php the_field('contactText'); ?>

        <?php get_template_part( 'includes/form' ); ?>

    </section>

    <?php get_template_part('includes/free-links'); ?>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>