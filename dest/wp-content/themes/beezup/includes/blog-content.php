<?php $count = 0; ?>
    
<?php while ( have_posts() ) : the_post(); ?>
    
    <div class='post <?php if( is_sticky() && is_home() ) echo 'highlighted'; ?>' itemscope itemtype='http://schema.org/Article'>
        <?php if( has_post_thumbnail() ){ ?>
            <a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>' class='post-img'>
                <?php the_post_thumbnail('large'); ?>
            </a>
        <?php } ?>

        <div class='post-txt'>
            <div class='post-meta'>
                <?php _e('Add on', 'beezup'); ?>
                <a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>'><time datetime='<?php the_time('c');?>' itemprop='dateCreated'><?php echo get_the_date(); ?></time></a>
                <?php _e('in', 'beezup'); ?>
                <?php echo get_the_category_list(); ?>
            </div>

            <h2>
                <a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>' itemprop='name'>
                    <?php the_title(); ?>
                </a>
            </h2>

            <a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>' class='excerpt' itemprop='description'>
                <?php the_excerpt(); ?>
            </a>

            <a href='<?php the_permalink(); ?>' title='<?php the_title(); ?>' class='link-arrow'><?php _e('Read more', 'beezup'); ?></a>
        </div>
    </div>

    <?php if( $count === 2 ){ //newsletter ?>
        <div class='blog-newsletter'>
            <div class='newsletter-txt'>
                <?php if( get_field('blogNewsletterTitle', 'options') ){ ?>
                    <h3><?php the_field('blogNewsletterTitle', 'options'); ?></h3>
                <?php } ?>

                <p><?php the_field('blogNewsletterText', 'options'); ?></p>
            </div>

            <?php get_template_part( 'includes/newsletter' ); ?>
        </div>
    <?php } ?>

    <?php if( $count === 4 ){ //demo ?>
        <?php get_template_part( 'includes/demo' ); ?>
    <?php } ?>

<?php $count ++; endwhile; ?>

<div class='pagination'>
    <?php echo paginate_links(array( 'prev_text' => __('Previous <svg class="icon"><use xlink:href="#icon-arrow-left"></use></svg>', 'beezup'), 'next_text'  =>  __('Next <svg class="icon"><use xlink:href="#icon-arrow-right"></use></svg>', 'beezup')) ); ?>
</div>

<?php get_template_part('includes/free-links'); ?>