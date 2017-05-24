<?php 
/*
Template Name: Tarifs
*/

get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
	<section class='container'>
       <?php if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>
        
		<h1 class='title-black'>
			<?php the_title(); ?>
			<?php if( get_field('title2') ){ ?>
				<span><?php the_field('title2'); ?></span>
			<?php } ?>
		</h1>

        <?php the_field('intro'); ?>
	</section>

    <section class='block-full'>
        <div class='container'>
            <?php if( have_rows('benefits') ){ ?>
                <ul>
                    <?php while( have_rows('benefits') ){ the_row(); ?>
                        <li>
                            <svg class='icon <?php the_sub_field('icon'); ?>'><use xlink:href='#<?php the_sub_field('icon'); ?>'></use></svg>
                            <?php the_sub_field('text'); ?>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </div>
    </section>

    <section class='container'>
        <?php if( have_rows('sections') ){ ?>
            <?php while( have_rows('sections') ){ the_row(); ?>

            <?php } ?>
        <?php } ?>
    </section>

    <?php get_template_part('includes/free-links'); ?>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>