<?php 
/*
Template Name: Tarifs
*/

include_once( 'includes/form-handler.php' );

get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
	<section class='container page-intro'>
        
        <div class='page-intro-title'>
            <?php // if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>

            <h1 class='page-title'>
                <?php get_field('title') ? the_field('title') : the_title(); ?>
            </h1>
            <?php the_field('intro'); ?>
        </div>
        
        <div class='page-intro-img'>
            <?php the_post_thumbnail( 'full' ); ?>
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
                                        <a href='<?php the_sub_field('url'); ?>' class='btn btn-arrow'>
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
                        <div class='wrapper-tarif-content relative'>

                            <?php if( have_rows('offers') ){ ?>
                                <div class='color-column'>
                                    <?php while( have_rows('offers') ){ the_row(); ?>
                                    <div class='<?php echo strtolower(get_sub_field("name")); ?>'></div>
                                    <?php } ?>
                                </div>
                            <?php } ?>

                            <ul class='tarif-content' id='tarif-content'>
                                <?php while( have_rows('featuresSection') ){ the_row(); ?>
                                    <li class='section-feature'><div>

                                        <h3><?php the_sub_field('title'); ?> <i><?php the_sub_field('subtitle'); ?></i></h3>

                                        <?php if( have_rows('features') ){ ?>

                                            <?php while( have_rows('features') ){ the_row(); ?>
                                            <div class='feature'>
                                                <span class='feature-title'><?php the_sub_field('title'); ?></span>

                                                <?php if( have_rows('detail') ){ ?>
                                                    <div class='feature-content js-feature-price1'>
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
                                                <?php if( have_rows('detail2') ){ ?>
                                                    <div class='feature-content js-feature-price2 hidden'>
                                                        <?php while( have_rows('detail2') ){ the_row(); ?>
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
                                                <?php if( have_rows('detail3') ){ ?>
                                                    <div class='feature-content js-feature-price3 hidden'>
                                                        <?php while( have_rows('detail3') ){ the_row(); ?>
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
                                                <?php if( have_rows('detail4') ){ ?>
                                                    <div class='feature-content js-feature-price4 hidden'>
                                                        <?php while( have_rows('detail4') ){ the_row(); ?>
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
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    </div><svg class='icon icon-swipe'><use xlink:href='#icon-swipe'></use></svg></li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php } ?>
                    
                    <div class='tarif-footer'>
                        <div>
                            <svg class='icon js-bees' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'>
                                <path class='js-bee' d='M11.967 20.669c0 3.305-2.679 5.983-5.983 5.983s-5.983-2.679-5.983-5.983c0-3.305 2.679-5.983 5.983-5.983s5.983 2.679 5.983 5.983z'/>
                                <path class='js-bee' d='M23.564 2.674c0 1.477-1.197 2.674-2.674 2.674s-2.674-1.197-2.674-2.674c0-1.477 1.197-2.674 2.674-2.674s2.674 1.197 2.674 2.674z'/>
                                <path class='js-bee' d='M32.448 29.326c0 1.477-1.197 2.674-2.674 2.674s-2.674-1.197-2.674-2.674c0-1.477 1.197-2.674 2.674-2.674s2.674 1.197 2.674 2.674z'/>
                            </svg>
                        </div>
                            
                        <div>
                            <svg class='icon js-bees' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'>
                                <path class='js-bee' d='M11.967 20.669c0 3.305-2.679 5.983-5.983 5.983s-5.983-2.679-5.983-5.983c0-3.305 2.679-5.983 5.983-5.983s5.983 2.679 5.983 5.983z'/>
                                <path class='js-bee' d='M23.564 2.674c0 1.477-1.197 2.674-2.674 2.674s-2.674-1.197-2.674-2.674c0-1.477 1.197-2.674 2.674-2.674s2.674 1.197 2.674 2.674z'/>
                                <path class='js-bee' d='M32.448 29.326c0 1.477-1.197 2.674-2.674 2.674s-2.674-1.197-2.674-2.674c0-1.477 1.197-2.674 2.674-2.674s2.674 1.197 2.674 2.674z'/>
                            </svg>
                        </div>
                        
                        <div>
                            <svg class='icon js-bees' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'>
                                <path class='js-bee' d='M11.967 20.669c0 3.305-2.679 5.983-5.983 5.983s-5.983-2.679-5.983-5.983c0-3.305 2.679-5.983 5.983-5.983s5.983 2.679 5.983 5.983z'/>
                                <path class='js-bee' d='M23.564 2.674c0 1.477-1.197 2.674-2.674 2.674s-2.674-1.197-2.674-2.674c0-1.477 1.197-2.674 2.674-2.674s2.674 1.197 2.674 2.674z'/>
                                <path class='js-bee' d='M32.448 29.326c0 1.477-1.197 2.674-2.674 2.674s-2.674-1.197-2.674-2.674c0-1.477 1.197-2.674 2.674-2.674s2.674 1.197 2.674 2.674z'/>
                            </svg>
                        </div>
                                
                        <div>
                            <svg class='icon js-bees' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'>
                                <path class='js-bee' d='M11.967 20.669c0 3.305-2.679 5.983-5.983 5.983s-5.983-2.679-5.983-5.983c0-3.305 2.679-5.983 5.983-5.983s5.983 2.679 5.983 5.983z'/>
                                <path class='js-bee' d='M23.564 2.674c0 1.477-1.197 2.674-2.674 2.674s-2.674-1.197-2.674-2.674c0-1.477 1.197-2.674 2.674-2.674s2.674 1.197 2.674 2.674z'/>
                                <path class='js-bee' d='M32.448 29.326c0 1.477-1.197 2.674-2.674 2.674s-2.674-1.197-2.674-2.674c0-1.477 1.197-2.674 2.674-2.674s2.674 1.197 2.674 2.674z'/>
                            </svg>
                        </div>
                    </div>

                </section>
            </div>
        </div>
    </div>

    <?php if( get_field('note') ){ ?>
        <div class='container'>
            <p class='tarif-note'><?php the_field('note'); ?></p>
        </div>
    <?php } ?>

    <?php if( get_field('fontionnalitesTitle') ){ ?>
        <section class='container tarif-sections' id='animsFonctionnalites'>
            <h2 class='h1 section-title'><?php the_field('fontionnalitesTitle'); ?></h2>

            <?php if( have_rows('videos') ){ ?>
                <div class='tarifs-video'>
                    <?php while( have_rows('videos') ){ the_row(); ?>
                        <div class='wrapper-video'>
                            <div class='inner-video' data-id='<?php the_sub_field('video_id'); ?>'>
                                <div class='iframe'></div>
                                <div class='cover-video' style='background-image:url(<?php echo wp_get_attachment_url(get_sub_field('video_cover')); ?>)'>
                                    <span class='play'></span>
                                </div>
                            </div>
                            <h3 class="h2"><?php the_sub_field('video_title'); ?></h3>
                            <span class="video-text"><?php the_sub_field('video_text'); ?></span>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <?php if( have_rows('sections') ){ $i = 0; ?>
                <?php while( have_rows('sections') ){ the_row(); ?>
                    <div class='subsection <?php echo ($i%2 !== 0 ? 'odd' : 'even') ?>'>
                        <div class='subsection-top'>
                            <div class='subsection-text'>
                                <?php if( get_sub_field('title') ){ ?>
                                    <h3 class='h2'><?php the_sub_field('title'); ?></h3>
                                <?php } ?>

                                <p><?php the_sub_field('text'); ?></p>

                                <?php if( get_sub_field('star') ){ ?>
                                    <div class='star'><?php the_sub_field('star'); ?></div>
                                <?php } ?>

                                <?php if( get_sub_field('link') && get_sub_field('linkText') ){ ?>
                                    <a href='<?php the_sub_field('link'); ?>' class='link-arrow pink' title='<?php the_sub_field('linkText'); ?>'><?php the_sub_field('linkText'); ?></a>
                                <?php } ?>
                            </div>

                            <?php 
                            if(get_sub_field('anim') == 4 ){
                                $classIllu = 'subsection-illu with-gradient';
                            }else if(get_sub_field('anim') == 3 || get_sub_field('anim') == 7){
                                $classIllu = 'subsection-illu with-gradient-right';
                            }else {
                                $classIllu = 'subsection-illu';
                            }
                            ?>
                            <div class='<?php echo $classIllu ?>'>
                                <?php get_template_part( 'includes/fonctionnalites/anim'.get_sub_field('anim') ); ?>
                            </div>
                        </div>
                    </div>
                <?php $i++; } ?>
            <?php } ?>
        </section>
     <?php } ?>
    
    <?php if(get_field('contactId', 'options') && get_field('contactLists', 'options')) : ?>
        <section class='container contact-us'>
            <?php if( get_field('contactTitle') ) : ?>
                <div class='contact-us-txt'>
                    <h2 class='h1'><?php the_field('contactTitle'); ?></h2>
                    <?php the_field('contactText'); ?>
                    <?php if( get_field('contactLink', 'options') && get_field('contactLinkText', 'options') ) : ?>
                        <a id='header-contact-button' class='btn btn-contact' href='<?php the_field('contactLink', 'options'); ?>' title='<?php the_field('contactLinkText', 'options'); ?>'>
                            <span><?php the_field('contactLinkText', 'options'); ?></span>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php // get_template_part( 'includes/form' ); ?>
            <?php // get_template_part( 'includes/sib-form' ); ?>
        </section>
    <?php endif; ?>

    <?php get_template_part('includes/free-links'); ?>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>