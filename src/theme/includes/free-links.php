<?php if( have_rows('freeLinks') ){ ?>
    <section class='container'>
        <?php if( get_field('freeLinksTitle') ){ ?>
            <svg class='icon icon-links title-icon'><use xlink:href='#icon-links'></use></svg>
            <h2 class='h1 small-m'><?php the_field('freeLinksTitle'); ?></h2>
        <?php } ?>

        <ul class='list-usefull'>
            <?php while( have_rows('freeLinks') ){ the_row(); ?>
                <li>
                    <a href='<?php the_sub_field('link'); ?>' class='link-arrow' title='<?php the_sub_field('linkText'); ?>'><?php the_sub_field('linkText'); ?></a>
                </li>
            <?php } ?>
        </ul>
    </section>
<?php } ?>