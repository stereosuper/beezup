<?php
    if( have_rows('content') ){
        while ( have_rows('content') ){ the_row();
            if( get_row_layout() == 'wysiwyg' ){ ?>
                <section class='container-small clearfix'><?php echo apply_filters( 'bj_lazy_load_html', get_sub_field('wysiwyg') ); ?></section>
            <?php } else if ( get_row_layout() == 'blockFull' ) { ?>
                <?php 
                    $recruitment_page_id = url_to_postid(get_field('recruitment_page', 'option'));
                    $current_page_id = get_the_ID();
                    
                    $is_recruitment_page = false;
                    if ($recruitment_page_id === $current_page_id) {
                        $is_recruitment_page = true;
                    } 
                ?>
                <section class='<?php echo $is_recruitment_page ? 'recruitment' : '' ?> block-full default '>
                    <div class='<?php echo $is_recruitment_page ? 'container' : 'container-small' ?> clearfix'>
                        <?php if ($is_recruitment_page): ?>
                            <?php 
                                $recruitment_articles = [];
                                $query_articles = new WP_Query(
                                    array(
                                        'post_type' => 'post',
                                        'category_name' => 'recruitment',
                                    )
                                );
                                if ( $query_articles->have_posts() ) {
	                                while ( $query_articles->have_posts() ) {
                                        $query_articles->the_post();

                                        $recruitment_ad_text = get_field('recruitment_ad_text');

                                        $recruitment_articles[] = array(
                                            'ad_text' =>  $recruitment_ad_text,
                                            'link' => get_permalink(),
                                        );
                                    }
                                    wp_reset_postdata();
                                }
                            ?>
                            <div class="recruitment-ads">
                                <?php if (sizeof($recruitment_articles) > 0): ?>
                                    <p><?php _e('Nous recherchons actuellement...', 'beezup') ?></p>
                                    <ul>
                                        <?php foreach ($recruitment_articles as $article): ?>
                                            <li>
                                                <a class="link-arrow" href="<?php echo $article['link'] ?>">
                                                    <?php echo $article['ad_text'] ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                        <li>
                                            <a class="link-arrow" href="<?php echo get_permalink(get_option('page_for_posts')) ?>">
                                                <?php _e('Consulter l\'ensemble des offres', 'beezup') ?>
                                            </a>
                                        </li>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($is_recruitment_page): ?>
                            <div class="recruitment-description">
                        <?php endif; ?>
                        <?php echo apply_filters('bj_lazy_load_html', get_sub_field('blockFull')); ?>
                        <?php if ($is_recruitment_page): ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            <?php } else if ( get_row_layout() == 'galery' ) { ?>
                <section class='<?php if( get_sub_field('blueBg') ){ echo "block-full default"; } ?>'>
                    <div class='container'>
                        <?php $images = get_sub_field('galery'); ?>
                        <?php if( $images ){ ?>
                        <ul class='galery <?php if( !get_sub_field("photos") ) echo "channels-list"; ?>'>
                            <?php foreach( $images as $image ){ ?>
                            <?php $img = "<img src='" . $image['sizes']['medium'] . "' alt='" . $image['alt'] . "'>"; ?>
                            <li>
                                <div><?php echo apply_filters( 'bj_lazy_load_html', $img); ?></div>
                            </li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </div>
                </section>
            <?php }elseif( get_row_layout() == 'newsletter' ){ ?>
                <section class='container-small'>
                    <div class='blog-newsletter small'>
                        <div class='newsletter-txt'>
                            <?php if( get_field('blogNewsletterTitle', 'options') ){ ?>
                                <h3><?php the_field('blogNewsletterTitle', 'options'); ?></h3>
                            <?php } ?>

                            <p><?php the_field('blogNewsletterText', 'options'); ?></p>
                        </div>

                        <?php get_template_part( 'includes/newsletter' ); ?>
                    </div>
                </section>
            <?php }
        }
    }
?>