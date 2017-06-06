<?php
    if( have_rows('content') ){
        while ( have_rows('content') ){ the_row();
            if( get_row_layout() == 'wysiwyg' ){ ?>
                <section class='container-small'><?php the_sub_field('wysiwyg'); ?></section>
            <?php }elseif( get_row_layout() == 'blockFull' ){ ?>
                <section class='block-full default'>
                    <div class='container-small'><?php the_sub_field('blockFull'); ?></div>
                </section>
            <?php }elseif( get_row_layout() == 'galery' ){ ?>
                <section class='<?php if( get_sub_field('blueBg') ){ echo "block-full default"; } ?>'>
                    <div class='container'>
                        <?php $images = get_sub_field('galery'); ?>
                        <?php if( $images ){ ?>
                        <ul class='galery <?php if( !get_sub_field("photos") ) echo "channels-list"; ?>'>
                            <?php foreach( $images as $image ){ ?>
                            <li>
                                <a href='<?php echo $image['url']; ?>' title='<?php echo $image['caption']; ?>'>
                                    <img src='<?php echo $image['sizes']['medium']; ?>' alt='<?php echo $image['alt']; ?>'>
                                </a>
                            </li>
                            <?php } ?>
                        </ul>
                        <?php } ?>
                    </div>
                </section>
            <?php }
        }
    }
?>