<?php 
/*
Template Name: Landing Page
*/
get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>

    <section class='container landing'>
        <h1 class='page-title'>
            <?php get_field('title') ? the_field('title') : the_title(); ?>
        </h1>
        <div class='landing-content'>
            <div class='landing-txt'>
                <?php the_field('content'); ?>
            </div>
            <aside>
                <div>
                    <h3><?php the_field('form_title'); ?></h3>
                    <?php if( get_field('formID') && get_field('listID') ){ ?>
                        <?php get_template_part( 'includes/sib-form-landing' ); ?>
                    <?php } ?>
                </div>
                <div>
                    <h3 class='word-title'><?php the_field('word_title'); ?></h3>
                    <?php if( have_rows('keywords') ){ ?>
                        <ul class='landing-words'>
                            <?php while ( have_rows('keywords') ) { the_row(); ?>
                                <li><?php the_sub_field('word');?></li>
                            <?php } ?>
                        </ul>
                    <?php } ?>
                </div>
            </aside>
        </div>
    </section>

<?php endif; ?>


<?php get_footer(); ?>