            </main>

            <?php $cookie = isset($_COOKIE['beez-cookies']) ? true : false; ?>

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
                            <div class='wrapper-social'>
                                <ul class='social'>
                                    <?php if(get_field('twitter', 'options')){ ?>
                                        <li>
                                            <a href='<?php the_field('twitter', 'options'); ?>' title='<?php _e('Follow us on', 'beezup'); ?> Twitter' class='btn-secondary' target='_blank'><span><?php _e('Follow us on', 'beezup'); ?> Twitter</span> <svg class='icon'><use xlink:href='#icon-twitter'></use></svg></a>
                                        </li>
                                    <?php } ?>
                                    <?php if(get_field('linkedin', 'options')){ ?>
                                        <li>
                                            <a href='<?php the_field('linkedin', 'options'); ?>' title='<?php _e('Follow us on', 'beezup'); ?> LinkedIn' class='btn-secondary' target='_blank'><span><?php _e('Follow us on', 'beezup'); ?> LinkedIn</span> <svg class='icon'><use xlink:href='#icon-linkedin'></use></svg></a>
                                        </li>
                                    <?php } ?>
                                    <?php if(get_field('facebook', 'options')){ ?>
                                        <li>
                                            <a href='<?php the_field('facebook', 'options'); ?>' title='<?php _e('Follow us on', 'beezup'); ?> Facebook' class='btn-secondary' target='_blank'><span><?php _e('Follow us on', 'beezup'); ?> Facebook</span> <svg class='icon'><use xlink:href='#icon-facebook'></use></svg></a>
                                        </li>
                                    <?php } ?>
                                    <?php if(get_field('google', 'options')){ ?>
                                        <li>
                                            <a href='<?php the_field('google', 'options'); ?>' title='<?php _e('Follow us on', 'beezup'); ?> Google +' class='btn-secondary' target='_blank'><span><?php _e('Follow us on', 'beezup'); ?> Google +</span> <svg class='icon'><use xlink:href='#icon-google-plus'></use></svg></a>
                                        </li>
                                    <?php } ?>
                                </ul>

                                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 26.3 22' class='bees-top js-bees'>
                                    <ellipse cx='21.5' cy='0.5' rx='0.5' ry='0.5' class='js-bee'/>
                                    <path d='M17.7,6.4c-0.7,0.4-1,1.3-0.7,2c0.4,0.7,1.3,1,2,0.7c0.7-0.4,1-1.3,0.7-2C19.4,6.3,18.5,6,17.7,6.4L17.7,6.4z' class='js-bee'/>
                                    <ellipse cx='24.8' cy='15.8' rx='1.5' ry='1.5' class='js-bee'/>
                                    <path d='M15.5,13.2c-0.7,0.4-1,1.3-0.6,2c0.4,0.7,1.3,1,2,0.6s1-1.3,0.6-2C17.2,13.1,16.3,12.8,15.5,13.2z' class='js-bee'/>
                                    <ellipse cx='22.1' cy='19.5' rx='0.5' ry='0.5' class='js-bee'/>
                                    <path d='M3.8,14.7c-0.2,0.1-0.3,0.4-0.2,0.7c0.1,0.2,0.4,0.3,0.7,0.2c0.2-0.1,0.3-0.4,0.2-0.7C4.4,14.6,4.1,14.5,3.8,14.7L3.8,14.7 z' class='js-bee'/>
                                    <path d='M0.3,21C0,21.1-0.1,21.4,0,21.7l0,0c0.1,0.2,0.4,0.3,0.7,0.2s0.3-0.4,0.2-0.7C0.8,21,0.5,20.9,0.3,21L0.3,21z' class='js-bee'/>
                                </svg>

                                <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30.3 19' class='bees-bottom js-bees'>
                                    <path d='M22.5,0c0.3-0.1,0.5,0,0.7,0.3c0.1,0.3,0,0.5-0.3,0.7s-0.5,0-0.7-0.3l0,0C22.1,0.4,22.2,0.2,22.5,0z' class='js-bee'/>
                                    <path d='M29.6,1.3c0.3-0.1,0.5,0,0.7,0.3s0,0.5-0.3,0.7c-0.3,0.1-0.5,0-0.7-0.3C29.2,1.7,29.3,1.4,29.6,1.3L29.6,1.3z' class='js-bee'/>
                                    <path d='M14,8.1c0.8-0.3,1.6,0,2,0.8c0.3,0.8,0,1.6-0.8,2c-0.8,0.3-1.6,0-2-0.8C12.9,9.3,13.2,8.4,14,8.1L14,8.1z' class='js-bee'/>
                                    <path d='M7.4,5.5c0.8-0.3,1.6,0,2,0.8c0.3,0.8,0,1.6-0.8,2c-0.8,0.3-1.6,0-2-0.8l0,0C6.3,6.7,6.6,5.8,7.4,5.5z' class='js-bee'/>
                                    <path d='M14.4,16.6c0.3-0.1,0.5,0,0.7,0.3c0.1,0.3,0,0.5-0.3,0.7s-0.5,0-0.7-0.3l0,0C14,17,14.2,16.7,14.4,16.6z' class='js-bee'/>
                                    <path d='M9.5,15.5c0.8-0.3,1.6,0,2,0.8c0.3,0.8,0,1.6-0.8,2s-1.6,0-2-0.8l0,0C8.4,16.7,8.8,15.8,9.5,15.5z' class='js-bee'/>
                                    <path d='M0.3,4.2c0.3-0.1,0.5,0,0.7,0.3C1.1,4.7,1,5,0.7,5.1C0.5,5.2,0.2,5.1,0,4.9C-0.1,4.6,0.1,4.3,0.3,4.2L0.3,4.2z' class='js-bee'/>
                                </svg>
                            </div>

                            <?php if(get_field('newsletterId', 'options') && get_field('newsletterLists', 'options')){ ?>
                                <h3><?php the_field('newsletterTitle', 'options'); ?></h3>
                                <?php get_template_part( 'includes/newsletter' ); ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class='bottom-footer'>
                    <div class='container'>
                    <?php echo beezup_mlp_footer_lang();
                    
                        wp_nav_menu( array('theme_location' => 'footer') ); ?>
                    </div>
                </div>

                <?php if(!$cookie){ ?>
                    <div class='cookies' id='cookies'>
                        <div class='container'>
                            <p><?php the_field('cookies', 'options'); ?></p>
                            <button type='button' class='btn-cookies' id='btnCookies'>OK</button>
                        </div>
                    </div>
                <?php } ?>
            </footer>

        </div>


        <?php get_template_part( 'includes/icons' ); ?>

        <?php wp_footer(); ?>

        <?php //if( is_page_template( 'contact.php' ) || is_page_template( 'tarifs.php' ) ){ ?>
            <!--<script defer src="https://www.google.com/recaptcha/api.js?onload=myCallBack&render=explicit&hl=fr"></script>

            <script defer>
                var verifyCallback = function(response) {
                    if(response.length > 0) {
                        $(".captcha > div.row > div.message_area").remove();
                    }
                };

                var myCallBack = function() {
                    //Render the recaptcha1 on the element with ID "recaptcha1"
                    if($('.captcha > div.row > div#gcaptcha').length > 0) {
                        var captcha = grecaptcha.render('gcaptcha', {
                          'sitekey' : '6Lf9DiwUAAAAAMoeVnb6WB4Chvbq-15a19__3E0N',
                          'theme' : 'light',
                          'callback' : verifyCallback,
                          'hl' : '<?php //the_field('lang2', 'options'); ?>'
                        });
                    }
                };
            </script>-->
        <?php //} ?>
    </body>
</html>
