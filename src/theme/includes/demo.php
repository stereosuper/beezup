<div>
    <?php if( get_field('blogDemoTitle', 'options') ){ ?>
        <h3><?php the_field('blogDemoTitle', 'options'); ?></h3>
    <?php } ?>

    <?php the_field('blogDemoText', 'options'); ?>

    <button class='btn-arrow' data-appointlet-organization='beezup' data-appointlet-service='32290'><?php the_field('blogDemoBtn', 'options'); ?></button>
</div>