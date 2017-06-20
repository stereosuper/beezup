<div class='demo'>
    <div class='demo-txt'>
        <?php if( get_field('blogDemoTitle', 'options') ){ ?>
            <h3><?php the_field('blogDemoTitle', 'options'); ?></h3>
        <?php } ?>

        <p><?php the_field('blogDemoText', 'options'); ?></p>

        <button class='btn btn-black btn-arrow' data-appointlet-organization='beezup' data-appointlet-service='32290' type='button'>
            <?php the_field('blogDemoBtn', 'options'); ?>
            <svg class='icon'><use xlink:href='#icon-arrow-right'></use></svg>
        </button>
    </div>

    <?php echo wp_get_attachment_image(get_field('blogDemoImg', 'options'), 'large'); ?>
</div>