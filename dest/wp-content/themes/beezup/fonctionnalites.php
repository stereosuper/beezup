<?php 
/*
Template Name: Fonctionnalites
*/

get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
	<section class='container intro'>
        <?php if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb(); } ?>
        
		<h1 class='title-black'>
			<?php the_title(); ?>
			<?php if( get_field('title2') ){ ?>
				<span><?php the_field('title2'); ?></span>
			<?php } ?>
		</h1>

        <?php the_field('intro'); ?>

        <?php the_post_thumbnail( 'full' ); ?>
	</section>

    <section class='block-full section-benefits'>
        <div class='container container-benefits'>
            <?php if( have_rows('benefits') ){ ?>
                <ul class='benefits'>
                    <?php while( have_rows('benefits') ){ the_row(); ?>
                        <li>
                            <svg class='icon <?php the_sub_field('icon'); ?>'><use xlink:href='#<?php the_sub_field('icon'); ?>'></use></svg>
                            <span><?php the_sub_field('text'); ?></span>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>

            <?php if( have_rows('sections') ){ ?>
                <ol id='menuFonctionnalites' class='list-menu'>
        
                    <?php while( have_rows('sections') ){ the_row(); ?>
                        <li>
                            <a class='link-arrow' href='#<?php the_sub_field('anchor'); ?>' title='<?php the_sub_field('title'); ?>'><?php the_sub_field('title'); ?></a>
                        </li>
                    <?php } ?>
                </ol>
            <?php } ?>
        </div>
    </section>

    <div class='container wrapper-sticky'>

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
        <?php } ?>

        <?php if( have_rows('sections') ){ ?>
            <?php $i = 1; $j = 1; ?>
            <?php while( have_rows('sections') ){ the_row(); ?>
                
                <section id='<?php the_sub_field('anchor'); ?>'>
                    <?php if( get_sub_field('title') ){ ?>
                        <h2 class='h1'><span class='number-index'><?php echo sprintf('%02d', $i); ?></span><p><?php the_sub_field('title'); ?></p></h2>
                    <?php } ?>
                    
                    <?php if( have_rows('subSections') ){ ?>
                        <?php while( have_rows('subSections') ){ the_row(); ?>
                            <div class='subsection <?php echo ($j%2 !== 0 ? 'odd' : 'even') ?>'>
                                <div class='subsection-content'>
                                    <div class='subsection-text'>
                                        <?php if( get_sub_field('title') ){ ?>
                                            <h3 class='h2'><?php the_sub_field('title'); ?></h3>
                                        <?php } ?>
                                        
                                        <?php the_sub_field('text'); ?>
                                        
                                        <?php if( get_sub_field('star') ){ ?>
                                            <div class='star'><?php the_sub_field('star'); ?></div>
                                        <?php } ?>
                                    </div>
                                    <div class='subsection-illu'>
                                        <?php echo wp_get_attachment_image( get_sub_field('img'), 'full' ); ?>
                                    </div>
                                </div>

                                <?php if( get_sub_field('link') && get_sub_field('linkText') ){ ?>
                                    <div class='subsection-link'>
                                        <a href='<?php the_sub_field('link'); ?>' class='link-arrow' title='<?php the_sub_field('linkText'); ?>'><?php the_sub_field('linkText'); ?></a>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php $j++;} ?>
                    <?php } ?>
                </section>
                <hr/>
            <?php $i++; } ?>
        <?php } ?>

        <?php if( get_field('bottomText') ){ ?>
            <section>
                <?php the_field('bottomText'); ?>

                <?php if( get_field('bottomBtn') ){ ?>
                    <button class='btn-arrow' data-appointlet-organization='beezup' data-appointlet-service='32290'><?php the_field('bottomBtn'); ?></button>
                 <?php } ?>

                 <?php echo wp_get_attachment_image( get_field('bottomImg'), 'full' ); ?>
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