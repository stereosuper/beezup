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
                            <?php } ?><br><br>
                            <a rel="alternate" hreflang="fr-FR" href="https://www.beezup.com/"><img class="switcher-flag" src="https://www.beezup.com/wp-content/themes/beezup/layoutImg/france.png"></a><a rel="alternate" hreflang="en-GB" href="https://www.beezup.com/en/"><img class="switcher-flag" src="https://www.beezup.com/wp-content/themes/beezup/layoutImg/united-kingdom.png"></a><a rel="alternate" hreflang="de-DE" href="https://www.beezup.com/de/"><img class="switcher-flag" src="https://www.beezup.com/wp-content/themes/beezup/layoutImg/germany.png"></a><a rel="alternate" hreflang="es-ES" href="https://www.beezup.com/es/"><img class="switcher-flag" src="https://www.beezup.com/wp-content/themes/beezup/layoutImg/spain.png"></a><a rel="alternate" hreflang="it-IT" href="https://www.beezup.com/it/"><img class="switcher-flag" src="https://www.beezup.com/wp-content/themes/beezup/layoutImg/italy.png"></a>
                        </div>

                        <div class='wrapper-links'>
                            <h3><?php the_field('linksTitle', 'options'); ?></h3>
                            <?php wp_nav_menu( array('theme_location' => 'secondary') ); ?>
                        </div>

                        <div class='wrapper-social-newsletter'><?php /*
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
*/ ?>
                            <?php if(get_field('newsletterId', 'options') && get_field('newsletterLists', 'options')){ ?>
                                <h3><?php the_field('newsletterTitle', 'options'); ?></h3>
                                <?php get_template_part( 'includes/newsletter' ); ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <div class='bottom-footer'>
                    <div class='container'>
                        <ul class="footer-social-buttons"> 
						    <li>
							    <a href="https://www.linkedin.com/company/beezup/" rel="nofollow" target="blank">
                                    <svg style="width: 36px; height: 36px;" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                                     width="486.39px" height="486.39px" viewBox="0 0 486.39 486.39" enable-background="new 0 0 486.39 486.39" xml:space="preserve">
                                    <g>
	                                    <g>
		                                    <g>
			                                    <path fill="#29A5ED" d="M243.2,0C108.89,0,0,108.89,0,243.2s108.89,243.2,243.2,243.2s243.2-108.89,243.2-243.2
				                                    C486.39,108.86,377.5,0,243.2,0z M182.4,360.99h-60.8V148.2h60.8V360.99z M153.88,135.16c-15.75,0-28.48-12.77-28.48-28.51
				                                    s12.77-28.51,28.48-28.51c15.75,0.03,28.51,12.8,28.51,28.51C182.4,122.39,169.63,135.16,153.88,135.16z M395.19,360.99h-60.8
				                                    V229.43c0-15.41-4.41-26.2-23.35-26.2c-31.4,0-37.45,26.2-37.45,26.2V361h-60.8V148.2h60.8v20.34
				                                    c8.69-6.66,30.4-20.31,60.8-20.31c19.7,0,60.8,11.79,60.8,83.05L395.19,360.99L395.19,360.99z"/>
		                                    </g>
	                                    </g>
                                    </g>
                                    </svg>
                                </a>
						    </li>
						    <li>
							    <a href="https://twitter.com/beezup_fr" rel="nofollow" target="_blank">
                                    <svg style="width: 36px; height: 36px;" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                                     width="455.38px" height="445.82px" viewBox="0 0 455.38 445.82" enable-background="new 0 0 455.38 445.82" xml:space="preserve">
                                    <path fill="#29A5ED" d="M228-0.01C102.08-0.01,0,99.79,0,222.9s102.08,222.91,228,222.91s228-99.8,228-222.91S353.92-0.01,228-0.01z
	                                     M334.52,169.48c0.11,2.31,0.16,4.62,0.16,6.95c0,71.01-55.28,152.9-156.38,152.9c-31.04,0-59.92-8.89-84.22-24.15
	                                    c4.3,0.49,8.67,0.74,13.11,0.74c25.75,0,49.44-8.59,68.26-23c-24.06-0.43-44.35-15.97-51.35-37.32c3.35,0.63,6.79,0.97,10.33,0.97
	                                    c5.02,0,9.87-0.66,14.49-1.89c-25.15-4.92-44.1-26.65-44.1-52.68c0-0.24,0-0.47,0.01-0.69c7.4,4.03,15.87,6.45,24.89,6.72
	                                    c-14.76-9.63-24.46-26.09-24.46-44.73c0-9.84,2.71-19.07,7.44-27.01c27.1,32.51,67.61,53.9,113.29,56.14
	                                    c-0.95-3.93-1.43-8.03-1.43-12.25c0-29.66,24.61-53.73,54.97-53.73c15.81,0,30.09,6.54,40.12,16.98
	                                    c12.52-2.41,24.28-6.88,34.9-13.04c-4.11,12.55-12.82,23.08-24.17,29.73c11.11-1.3,21.71-4.18,31.56-8.46
	                                    C354.58,152.43,345.25,161.9,334.52,169.48z"/>
                                    </svg>
                                </a>
						    </li>
						    <li>
							    <a href="https://www.facebook.com/BeezUP" rel="nofollow" target="blank">
                                    <svg style="width: 36px; height: 36px;" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                                     width="492.12px" height="492.18px" viewBox="0 0 492.12 492.18" enable-background="new 0 0 492.12 492.18" xml:space="preserve">
                                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#29A5ED" d="M420.04,72.08c-96.1-96.1-251.92-96.1-348.02,0
	                                    s-96.1,251.92,0,348.02s251.92,96.1,348.02,0S516.15,168.18,420.04,72.08z M311.16,150.09c-8.17-0.13-16.34-0.06-24.5-0.04
	                                    c-10.87,0.03-17.38,5.63-18.06,16.39c-0.55,8.63-0.15,17.31-0.35,25.96c-0.07,3.08,1.76,2.87,3.8,2.87
	                                    c12.41-0.02,24.83,0.12,37.24-0.09c3.64-0.06,4.84,0.77,4.43,4.61c-1.56,14.44-2.9,28.91-4.14,43.39c-0.28,3.27-1.77,3.89-4.71,3.84
	                                    c-9.79-0.15-19.59-0.1-29.39-0.04c-7.04,0.04-6.35-1.03-6.35,6.15c-0.03,45.08-0.09,90.16,0.1,135.24c0.02,4.76-1.2,5.94-5.91,5.86
	                                    c-16.82-0.31-33.65-0.33-50.47,0.01c-4.74,0.09-5.52-1.51-5.48-5.74c0.19-22.74,0.1-45.44,0.1-68.14c0-23.03-0.09-46.06,0.08-69.09
	                                    c0.03-3.88-1.07-5.1-4.95-4.94c-7.18,0.29-14.37-0.03-21.56,0.14c-2.91,0.07-3.98-0.73-3.95-3.81c0.14-14.37,0.13-28.75,0.02-43.12
	                                    c-0.03-2.76,0.81-3.67,3.6-3.61c7.35,0.17,14.71-0.21,22.04,0.16c4.25,0.21,5.13-1.3,5.04-5.25c-0.26-10.94-0.26-21.89-0.02-32.83
	                                    c0.29-13.36,3.88-25.83,11.83-36.69c10.07-13.75,24.38-20.04,40.9-20.78c16.96-0.75,33.97-0.34,50.95-0.52
	                                    c2.37-0.03,3.07,0.82,3.06,3.12c-0.08,14.53-0.09,29.07,0.01,43.61C314.54,149.34,313.7,150.13,311.16,150.09z"/>
                                    </svg>
                                </a>
						    </li>
						    <li>
							    <a href="https://www.instagram.com/beezup_officiel/" rel="nofollow" target="blank">
                                   <svg style="width: 36px; height: 36px;" version="1.1" id="Calque_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                                     width="1005.8px" height="1005.8px" viewBox="0 0 1005.8 1005.8" enable-background="new 0 0 1005.8 1005.8" xml:space="preserve">
                                    <g>
	                                    <path fill="#29A5ED" d="M502.9,597.57c52.18,0,94.68-42.5,94.68-94.64c0-21.02-16.19-94.71-94.68-94.71
		                                    c-78.48,0-94.7,73.69-94.66,94.71C408.24,555.07,450.69,597.57,502.9,597.57z"/>
	                                    <polygon fill="#29A5ED" points="723.3,377.12 723.3,283.2 710.91,283.23 628.37,283.5 628.69,377.42 	"/>
	                                    <path fill="#29A5ED" d="M723.76,439.91h-77.63c7.26,17.94,11.38,42.47,11.38,63.02c0,85.3-69.38,154.74-154.71,154.74
		                                    c-85.34,0-154.73-69.44-154.73-154.74c0-20.55,4.12-45.08,11.42-63.02h-78.58v229.73c0,29.92,24.33,54.21,54.25,54.21h334.42
		                                    c29.96,0,54.25-24.32,54.25-54.21h-0.07V439.91z"/>
	                                    <path fill="#29A5ED" d="M502.9,0C225.14,0,0,225.17,0,502.9c0,277.73,225.18,502.9,502.9,502.9s502.9-225.17,502.9-502.9
		                                    C1005.8,225.18,780.63,0,502.9,0z M785.85,676.51c0,60.28-49.04,109.34-109.34,109.34h-347.2c-60.29,0-109.36-49.04-109.36-109.34
		                                    v-347.2c0-60.29,49.04-109.36,109.36-109.36h347.14c60.32,0,109.4,49.07,109.4,109.36V676.51z"/>
                                    </g>
                                    </svg>
                                </a>
						    </li>
						    <li>
							    <a href="https://www.youtube.com/channel/UChHQdNRxcctKwN1pu9hXdHw" rel="nofollow" target="blank">
                                    <svg style="width: 36px; height: 36px;" version="1.1" id="Calque_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                                     width="984px" height="984px" viewBox="0 0 984 984" enable-background="new 0 0 984 984" xml:space="preserve">
                                    <polygon fill="#29A5ED" points="433.78,585.62 434.66,398.38 576.22,491.71 "/>
                                    <path fill="#29A5ED" d="M492,0C220.28,0,0,220.28,0,492s220.28,492,492,492s492-220.28,492-492S763.72,0,492,0z M741.36,392.03
	                                    v199.96c0,41.18-33.36,74.57-74.53,74.57H317.15c-41.16,0-74.53-33.38-74.53-74.57V392.03c0-41.19,33.37-74.58,74.53-74.58h349.7
	                                    c41.16,0,74.53,33.38,74.53,74.58H741.36z"/>
                                    </svg>
                                </a>
						    </li>
						    <li>
							    <a href="https://www.pinterest.fr/beezup_officiel/" rel="nofollow" target="blank">
                                   <svg style="width: 36px; height: 36px;" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	                                     width="578.84px" height="578.8px" viewBox="0 0 578.84 578.8" enable-background="new 0 0 578.84 578.8" xml:space="preserve">
                                    <g>
	                                    <path fill="#29A5ED" d="M289.42,0C129.58,0,0,129.58,0,289.42C0,407.93,71.26,509.74,173.24,554.5
		                                    c-0.81-20.21-0.15-44.47,5.04-66.46c5.56-23.5,37.24-157.7,37.24-157.7s-9.25-18.48-9.25-45.8c0-42.89,24.86-74.92,55.82-74.92
		                                    c26.32,0,39.04,19.77,39.04,43.45c0,26.47-16.88,66.05-25.56,102.71c-7.25,30.7,15.39,55.74,45.68,55.74
		                                    c54.83,0,91.76-70.43,91.76-153.87c0-63.43-42.72-110.91-120.42-110.91c-87.79,0-142.48,65.47-142.48,138.6
		                                    c0,25.21,7.43,43,19.08,56.76c5.35,6.33,6.1,8.87,4.16,16.13c-1.39,5.33-4.57,18.15-5.89,23.23c-1.93,7.33-7.87,9.95-14.49,7.24
		                                    c-40.44-16.51-59.27-60.79-59.27-110.57c0-82.21,69.34-180.79,206.85-180.79c110.49,0,183.22,79.96,183.22,165.79
		                                    c0,113.54-63.12,198.36-156.16,198.36c-31.25,0-60.63-16.89-70.7-36.07c0,0-16.8,66.68-20.36,79.56
		                                    c-6.14,22.31-18.15,44.61-29.13,62c26.03,7.68,53.53,11.87,82.02,11.87c159.82,0,289.4-129.57,289.4-289.42
		                                    C578.82,129.58,449.24,0,289.42,0z"/>
                                    </g>
                                    </svg>
                                </a>
						    </li>
					    </ul>

                    </div>
                    <div class='container'>
                    <?php /*echo beezup_mlp_footer_lang();*/
                    
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

<a class="sttop" href="#header"><img src="https://www.beezup.com/wp-content/themes/beezup/layoutImg/anchor.png"></a>


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
