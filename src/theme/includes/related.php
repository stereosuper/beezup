<?php    
    $currentPost = $post;
    global $post;

    $categories = get_the_category($post->ID);
    if( $categories ){
        $categoryIds = array();
        foreach( $categories as $cat ){
            $categoryIds[] = $cat->term_id;
        }

        $relatedQuery = new WP_Query( array(
            'category__in' => $categoryIds,
            'post__not_in' => array($post->ID),
            'posts_per_page'=> 3,
            'orderby' => 'rand'
        ) );

        if( $relatedQuery->have_posts() ){ ?>
            <h2 class='h1 align-small'><?php _e('Related Posts', 'beezup'); ?></h2>
            
            <ul class='list-small-posts'>
                <?php while( $relatedQuery->have_posts() ){ $relatedQuery->the_post(); ?>
                    <li>
                        <a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>' class='small-post'>
                            <time class='small-post-date' datetime='<?php the_time('c');?>'><?php echo get_the_date(); ?></time>
                            <?php if( has_post_thumbnail() ){ ?>
                                <div class='small-post-image' style="background-image: url(<?php echo the_post_thumbnail_url('large'); ?>);"></div>
                            <?php } ?>
                            <h3 class='small-post-title'><?php the_title(); ?></h3>
                            <span class='link-arrow'><?php _e('Read more', 'beezup'); ?></span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        <?php }
    }

    $post = $currentPost;
    wp_reset_query();
?>