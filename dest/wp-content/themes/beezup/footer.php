        </main>


        <footer role='contentinfo' class='footer'>
            <div class='top-footer'>
                <div class='container'>
                    <div class='wrapper-about'>
                        <h3><?php the_field('aboutTitle', 'options'); ?></h3>
                        <?php the_field('aboutText', 'options'); ?>
                        <?php if(get_field('aboutLink', 'options') && get_field('aboutLinkText', 'options')){ ?>
                            <a href='<?php the_field('aboutLink', 'options'); ?>' title='<?php the_field('aboutLinkText', 'options'); ?>' class='link-arrow'><?php the_field('aboutLinkText', 'options'); ?></a>
                        <?php } ?>
                    </div>

                    <div class='wrapper-links'>
                        <h3><?php the_field('linksTitle', 'options'); ?></h3>
                        <?php wp_nav_menu( array('theme_location' => 'secondary') ); ?>
                    </div>

                    <div class='wrapper-social-newsletter'>
                        <h3><?php the_field('socialTitle', 'options'); ?></h3>
                        <ul class='social'>
                            <?php if(get_field('twitter', 'options')){ ?>
                                <li>
                                    <a href='<?php the_field('twitter', 'options'); ?>' title='<?php _e('Follow us on', 'beezup'); ?> Twitter' class='btn-secondary' target='_blank'><span><?php _e('Follow us on', 'beezup'); ?> Twitter</span><svg class='icon icon-twitter'><use xlink:href='#icon-twitter'></use></svg></a>
                                </li>
                            <?php } ?>
                            <?php if(get_field('linkedin', 'options')){ ?>
                                <li>
                                    <a href='<?php the_field('linkedin', 'options'); ?>' title='<?php _e('Follow us on', 'beezup'); ?> LinkedIn' class='btn-secondary' target='_blank'><span><?php _e('Follow us on', 'beezup'); ?> LinkedIn</span><svg class='icon icon-linkedin'><use xlink:href='#icon-linkedin'></use></svg></a>
                                </li>
                            <?php } ?>
                            <?php if(get_field('facebook', 'options')){ ?>
                                <li>
                                    <a href='<?php the_field('facebook', 'options'); ?>' title='<?php _e('Follow us on', 'beezup'); ?> Facebook' class='btn-secondary' target='_blank'><span><?php _e('Follow us on', 'beezup'); ?> Facebook</span><svg class='icon icon-facebook'><use xlink:href='#icon-facebook'></use></svg></a>
                                </li>
                            <?php } ?>
                            <?php if(get_field('google', 'options')){ ?>
                                <li>
                                    <a href='<?php the_field('google', 'options'); ?>' title='<?php _e('Follow us on', 'beezup'); ?> Google +' class='btn-secondary' target='_blank'><span><?php _e('Follow us on', 'beezup'); ?> Google +</span><svg class='icon icon-google-plus'><use xlink:href='#icon-google-plus'></use></svg></a>
                                </li>
                            <?php } ?>
                        </ul>

                        <h3><?php the_field('newsletterTitle', 'options'); ?></h3>
                        <?php get_template_part( 'includes/newsletter' ); ?>
                    </div>
                </div>
            </div>
            <div class='bottom-footer'>
                <div class='container'>
                    <?php wp_nav_menu( array('theme_location' => 'footer') ); ?>
                </div>
            </div>
        </footer>


        <?php get_template_part( 'includes/icons' ); ?>

        <?php wp_footer(); ?>

    </body>
</html>
