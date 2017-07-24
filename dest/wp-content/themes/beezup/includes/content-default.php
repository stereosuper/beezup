<?php
    if( have_rows('content') ){
        while ( have_rows('content') ){ the_row();
            if( get_row_layout() == 'wysiwyg' ){ ?>
                <section class='container-small clearfix'><?php echo apply_filters( 'bj_lazy_load_html', get_sub_field('wysiwyg') ); ?></section>
            <?php }elseif( get_row_layout() == 'blockFull' ){ ?>
                <section class='block-full default'>
                    <div class='container-small clearfix'><?php echo apply_filters( 'bj_lazy_load_html',get_sub_field('blockFull') ); ?></div>
                </section>
            <?php }elseif( get_row_layout() == 'galery' ){ ?>
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