<?php 
/*
Template Name: Fonctionnalites
*/

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

    <section class='block-full section-benefits'>
        <div class='container container-benefits relative'>
            <?php if( have_rows('benefits') ){ ?>
                <ul class='benefits'>
                    <?php while( have_rows('benefits') ){ the_row(); ?>
                        <li>
                            <svg class='icon'><use xlink:href='#<?php the_sub_field('icon'); ?>'></use></svg>
                            <span><?php the_sub_field('text'); ?></span>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>

            <?php if( have_rows('sections') ){ ?>
                <ol id='menuFonctionnalites' class='list-menu list-menu-fonctionnalites'>
                    <?php while( have_rows('sections') ){ the_row(); ?>
                        <li>
                            <a class='link-arrow' href='#<?php the_sub_field('anchor'); ?>' title='<?php the_sub_field('title'); ?>'><?php the_sub_field('title'); ?></a>
                        </li>
                    <?php } ?>
                </ol>
            <?php } ?>
        </div>
    </section>

    <div class='container relative' id='animsFonctionnalites'>
        <div class='wrapper-sticky'>

            <?php if( have_rows('sections') ){ ?>
                <?php $i = 1; ?>
                <nav id='sideLinksNav' class='side-links'>
                    <ul>
                        <?php while( have_rows('sections') ){ the_row(); ?>
                            <li>
                                <a href='#<?php the_sub_field('anchor'); ?>' title='<?php the_sub_field('title'); ?>' ><?php echo sprintf('%02d', $i); ?></a>
                            </li>
                        <?php $i++; } ?>
                    </ul>
                </nav>

                <?php $i = 1; $j = 1; ?>
                <?php while( have_rows('sections') ){ the_row(); ?>
                    
                    <section id='<?php the_sub_field('anchor'); ?>' class='section'>
                        <?php if( get_sub_field('title') ){ ?>
                            <div class='section-index'>
                                <?php echo sprintf('%02d', $i); ?>
                                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 26 20' class='bees-left js-bees'>
                                    <path d='M25,16.6c-0.2-0.1-0.4-0.3-0.3-0.5c0-0.2,0.3-0.4,0.5-0.4c0.2,0,0.4,0.3,0.4,0.5 C25.5,16.5,25.3,16.6,25,16.6L25,16.6z' class='js-bee'/>
                                    <path d='M20.5,12.1c-0.7-0.1-1.2-0.8-1-1.5c0.1-0.7,0.8-1.2,1.5-1l0.1,0c0.7,0.1,1.2,0.8,1,1.6 C21.9,11.8,21.2,12.3,20.5,12.1z' class='js-bee'/>
                                    <path d='M19.2,4C19,4,18.9,3.7,19,3.5l0,0c0.1-0.2,0.4-0.3,0.6-0.2c0.2,0.1,0.3,0.3,0.2,0.6l0,0 C19.7,4.1,19.5,4.2,19.2,4L19.2,4z' class='js-bee'/>
                                    <path d='M20.5,16.5c0.7,0.2,1.1,0.9,0.9,1.6c-0.2,0.7-0.9,1.1-1.6,0.9c-0.7-0.2-1.1-0.9-0.9-1.5 C19.1,16.7,19.8,16.3,20.5,16.5z' class='js-bee'/>
                                    <path d='M17.1,6.9C16.4,6.7,16,6,16.2,5.4s0.9-1.1,1.6-0.9c0.7,0.2,1.1,0.8,0.9,1.5 C18.5,6.7,17.8,7.1,17.1,6.9z' class='js-bee'/>
                                    <path d='M13,13c-0.2-0.1-0.4-0.3-0.3-0.5c0-0.2,0.3-0.4,0.5-0.4c0.2,0,0.4,0.3,0.4,0.5 C13.5,12.9,13.3,13.1,13,13L13,13z' class='js-bee'/>
                                    <path d='M0.3,4.1C0.1,4,0,3.8,0,3.6c0.1-0.2,0.3-0.4,0.5-0.3c0.2,0.1,0.4,0.3,0.3,0.5C0.8,4,0.6,4.1,0.3,4.1 L0.3,4.1L0.3,4.1z' class='js-bee'/>
                                    <path d='M7.2,7.9C7,7.9,6.8,7.6,6.9,7.4C7,7.2,7.2,7,7.4,7.1c0.2,0.1,0.4,0.3,0.3,0.5C7.7,7.8,7.4,8,7.2,7.9 L7.2,7.9L7.2,7.9z' class='js-bee'/>
                                    <path d='M7.1,8.7C7,8.9,6.8,9,6.6,9C6.3,8.9,6.2,8.7,6.2,8.5c0.1-0.2,0.3-0.4,0.5-0.3C7,8.2,7.1,8.4,7.1,8.7 L7.1,8.7z' class='js-bee'/>
                                    <path d='M21.2,0.8c-0.2-0.1-0.4-0.3-0.3-0.5c0.1-0.2,0.3-0.4,0.5-0.3c0.2,0.1,0.4,0.3,0.3,0.5 C21.6,0.7,21.4,0.9,21.2,0.8L21.2,0.8z' class='js-bee'/>
                                </svg>
                                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 25.5 19' class='bees-right js-bees'>
                                    <path d='M0.6,16.6c0.2-0.1,0.4-0.3, 0.3-0.5c0-0.2-0.3-0.4-0.5-0.4C0.2,15.8,0,16,0,16.2 C0.1,16.5,0.3,16.6,0.6,16.6L0.6,16.6z' class='js-bee'/>
                                    <path d='M5.1,12.1c0.7-0.1,1.2-0.8,1-1.5C6,9.9,5.3,9.4,4.6,9.5l-0.1,0c-0.7,0.1-1.2,0.8-1,1.6 C3.7,11.8,4.4,12.3,5.1,12.1z' class='js-bee'/>
                                    <path d='M6.4,4C6.6,4,6.7,3.7,6.6,3.5l0,0C6.5,3.3,6.2,3.2,6,3.3C5.8,3.4,5.7,3.6,5.8,3.8l0,0 C5.9,4.1,6.1,4.2,6.4,4L6.4,4z' class='js-bee'/>
                                    <path d='M5.1,16.5C4.4,16.6,4,17.3,4.2,18c0.2,0.7,0.9,1.1,1.6,0.9c0.7-0.2,1.1-0.9,0.9-1.5 C6.5,16.7,5.8,16.3,5.1,16.5z' class='js-bee'/>
                                    <path d='M8.5,6.9C9.2,6.7,9.6,6,9.4,5.4S8.5,4.3,7.8,4.5C7.2,4.6,6.8,5.3,6.9,6C7.1,6.7,7.8,7.1,8.5,6.9z' class='js-bee'/>
                                    <path d='M12.6,13c0.2-0.1,0.4-0.3,0.3-0.5c0-0.2-0.3-0.4-0.5-0.4c-0.2,0-0.4,0.3-0.4,0.5 C12.1,12.9,12.3,13.1,12.6,13L12.6,13z' class='js-bee'/>
                                    <path d='M25.2,4.1c0.2-0.1,0.4-0.3, 0.3-0.5c-0.1-0.2-0.3-0.4-0.5-0.3c-0.2,0.1-0.4,0.3-0.3,0.5 C24.8,4,25,4.1,25.2,4.1L25.2,4.1L25.2,4.1z' class='js-bee'/>
                                    <path d='M18.4,7.9c0.2-0.1,0.4-0.3,0.3-0.5c-0.1-0.2-0.3-0.4-0.5-0.3c-0.2,0.1-0.4,0.3-0.3,0.5 C17.9,7.8,18.2,8,18.4,7.9L18.4,7.9L18.4,7.9z' class='js-bee'/>
                                    <path d='M18.5,8.7C18.5,8.9,18.8,9,19,9c0.2-0.1,0.4-0.3,0.3-0.5c-0.1-0.2-0.3-0.4-0.5-0.3 C18.6,8.2,18.4,8.4,18.5,8.7L18.5,8.7z' class='js-bee'/>
                                    <path d='M4.4,0.8c0.2-0.1,0.4-0.3,0.3-0.5C4.7,0.1,4.4-0.1,4.2,0C4,0.1,3.8,0.3,3.9,0.5 C3.9,0.7,4.2,0.9,4.4,0.8L4.4,0.8z' class='js-bee'/>
                                </svg>
                            </div>

                            <h2 class='h1 section-title'><?php the_sub_field('title'); ?></h2>
                        <?php } ?>
                        
                        <?php if( have_rows('subSections') ){ ?>
                            <?php while( have_rows('subSections') ){ the_row(); ?>
                                <div class='subsection <?php echo ($j%2 !== 0 ? 'odd' : 'even') ?>'>
                                    <div class='subsection-top'>
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
                                    <?php if(get_sub_field('video')){ ?>
                                        <div class='wrapper-video'>
                                            <hr>
                                            <div class='inner-video' data-id='<?php the_sub_field('video'); ?>'>
                                                <div class='iframe'></div>
                                                <div class='cover-video' style='background-image:url(<?php echo wp_get_attachment_url(get_sub_field('video_cover')); ?>)'>
                                                    <span class='play'></span>
                                                </div>
                                            </div>
                                            <h3 class="h2 align-center"><?php the_sub_field('video_title'); ?></h3>
                                            <span class="video-text"><?php the_sub_field('video_text'); ?></span>
                                            <hr>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php $j++;} ?>
                        <?php } ?>
                    </section>
                    <hr class='large'/>
                <?php $i++; } ?>
            <?php } ?>
        </div>

        <?php if( get_field('bottomText') ){ ?>
            <section class='demo-bottom'>
                <div class='demo-bottom-text'>
                    <?php the_field('bottomText'); ?>

                    <?php if( get_field('bottomBtn') ): ?>
                    <button id="functionalities-contact-button" class='btn-arrow btn' type='button'>
                    <a href='<?php the_field('contactLink', 'options'); ?>' title='<?php the_field('bottomBtn'); ?>'>
                        <span><?php the_field('bottomBtn'); ?></span>
                        <svg class='icon'><use xlink:href='#icon-arrow-right'></use></svg></button>
                    </a>
                    
                    <?php endif; ?>
                </div>
                <div class='demo-bottom-img'>
                    <?php echo wp_get_attachment_image( get_field('bottomImg'), 'full' ); ?>
                </div>
            </section>
        <?php } ?>
    </div>

    <?php get_template_part('includes/free-links'); ?>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>