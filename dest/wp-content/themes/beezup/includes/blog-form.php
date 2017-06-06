<div class='blog-form'>
    <div class='dropdown js-dropdown closed'>
        <ul class='dropdown-list'>
            <?php if( is_home() || is_search() ){ ?>
                <li class='current-cat'><?php _e('Categories', 'beezup'); ?></li>
            <?php }else{ ?>
                <li><a href='<?php echo get_permalink( get_option('page_for_posts') ); ?>'><?php _e('All categories', 'beezup'); ?></a></li>
            <?php } ?>
            <?php wp_list_categories( array('title_li' => '') ); ?>
        </ul>

        <button class='btn-list js-btn-list' type='button'>
            <?php _e('Open catgories list', 'beezup'); ?>
            <svg class='icon'><use xlink:href='#icon-list'></use></svg>
        </button>

        <button class='btn-close js-btn-list' type='button'>
            <?php _e('Close catgories list', 'beezup'); ?>
            <svg class='icon'><use xlink:href='#icon-close'></use></svg>
        </button>
    </div>

    <form role='search' method='get' action='<?php echo home_url('/'); ?>' class='js-inline-form searchform'>
        <div class='field-inline'>
            <input type='search' name='s' id='search' value='<?php the_search_query(); ?>'>
            <label for='search'><?php _e('Search', 'beezup'); ?>...</label>
            <button type='submit' class='btn-search'><?php _e('Search', 'beezup'); ?> <svg class='icon'><use xlink:href='#icon-search'></use></svg></button>
        </div>
    </form>
</div>