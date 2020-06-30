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
                    <?php
                    $landing_form_script_id = get_field('landingFormId', 'options');
                    $landing_form_script_src = get_field('landingFormSrc', 'options');
                    if($landing_form_script_id && $landing_form_script_src):
                    ?>
                    <form id="<?php echo $landing_form_script_id ?>"></form>
                    <script async src="<?php echo $landing_form_script_src ?>"></script>
                    <?php endif; ?>
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