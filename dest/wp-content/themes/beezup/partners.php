<?php 
/*
Template Name: Partenaires
*/

$query_partners = new WP_Query( array( 'post_type' => 'partners' ) );


// $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
// $alt = strtr($alt,array('\''=>' ','"'=>" "));
// if(!empty($attachment_id)){
//     $attachement_srcset = wp_get_attachment_image_srcset($attachment_id, $size);
//     $attachement_src = wp_get_attachment_image_src($attachment_id, $size);
//     $unique = str_replace(' ', '', str_replace('.', '', microtime()));
//     $img_wrapper = '<img id="'.$unique.'" ';
//     $img_wrapper .= 'class="loader-settings loader-img '. $class .'" ';
//     $img_wrapper .= 'src="'. plugins_url() .'/plugin-settings/loader/blank.png" ';
//     // $img_wrapper .= 'src="'. $attachement_src[0] .'" ';
//     // $img_wrapper .= 'srcset="'. $attachement_srcset .'" ';
//     $img_wrapper .=  $alt == null ? '' : 'alt="'. $alt .'" ';
//     $img_wrapper .=  $other_attrs .'>';

get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
	<section class='container page-intro'>
        
        <div class='page-intro-title'>
            <?php // if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>

            <h1 class='page-title'>
                <?php get_field('title') ? the_field('title') : the_title(); ?>
            </h1>

            <?php if( get_field('subtitle') ): ?>
                <h2><?php the_field('subtitle'); ?></h2>
            <?php endif; ?>

            <?php if( get_field('text') ): ?>
                <?php the_field('text'); ?>
            <?php endif; ?>
        </div>
        
        <div class='page-intro-img'>
            <?php if( has_post_thumbnail() ): ?>
                <?php the_post_thumbnail( 'full' ); ?>
            <?php endif; ?>
        </div>

    </section>
    
    <section class='block-full no-pad'>
        <div class='container channels' id='channels'>
            <p id='sectorError' class='channels-error'></p>
            
            <div id='channelsList'>
                <?php if ($query_partners->have_posts()): ?>
                    <ul class="galery channels-list">
                    <?php while ( $query_partners->have_posts() ): $query_partners->the_post(); ?>
                        <?php 
                            $link = get_field('partner_link');
                            $terms = get_the_terms(get_the_ID(), 'partners-type');
                            $color = get_field('category_color', $terms[0]->taxonomy .'_'. $terms[0]->term_id);
                        ?>
                        <?php if ($link): ?>
                            <li>
                                <a href="<?php echo $link['url'] ?>" title="<?php echo htmlspecialchars(strip_tags($link['title']), ENT_QUOTES); ?>" target="<?php echo $link['target'] ?>" <?php echo $link['target'] === '_blank' ? 'rel="noopener noreferrer"' : ''; ?>>
                                    <span><?php the_title() ?></span>
                                    <?php the_post_thumbnail('medium') ?>
                                    <?php if($terms[0]): ?>
                                        <span class="category" style="background-color: <?php echo $color ?>;"><?php echo $terms[0]->name ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endwhile; ?>
                    </ul>
                <?php else: ?>
                    <p class="channels-error"><svg class="icon"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-error"></use></svg>
                    <?php _e("There are no partners.", 'beezup') ?>
                    </p>
                <?php endif; ?>
            </div>

            <?php get_template_part( 'includes/loader' ); ?>
        </div>
    </section>

    <?php get_template_part('includes/free-links'); ?>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>