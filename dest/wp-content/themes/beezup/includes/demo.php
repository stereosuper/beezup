<div class='demo'>
    <div class='demo-txt'>
        <?php if( get_field('blogDemoTitle', 'options') ){ ?>
            <h3><?php the_field('blogDemoTitle', 'options'); ?></h3>
        <?php } ?>

        <p><?php the_field('blogDemoText', 'options'); ?></p>

        <button class='btn btn-black btn-arrow' onclick="Calendly.showPopupWidget('https://calendly.com/communication-beezup');return false;" type='button'>
            <?php the_field('blogDemoBtn', 'options'); ?>
            <svg class='icon'><use xlink:href='#icon-arrow-right'></use></svg>
        </button>
    </div>

    <?php echo wp_get_attachment_image(get_field('blogDemoImg', 'options'), 'large'); ?>
</div>