<div class='demo'>
    <div class='demo-txt'>
        <?php if( get_field('blogDemoTitle', 'options') ){ ?>
            <h3><?php the_field('blogDemoTitle', 'options'); ?></h3>
        <?php } ?>

        <p><?php the_field('blogDemoText', 'options'); ?></p>

        <a id="blog-contact-button" class='btn btn-black btn-arrow' href='<?php the_field('contactLink', 'options'); ?>' title='<?php the_field('blogDemoBtn', 'options'); ?>'>
            <span><?php the_field('blogDemoBtn', 'options'); ?></span>
            <svg class='icon'><use xlink:href='#icon-arrow-right'></use></svg>
        </a>
    </div>

    <?php echo apply_filters( 'bj_lazy_load_html', wp_get_attachment_image(get_field('blogDemoImg', 'options'), 'large') ); ?>
</div>