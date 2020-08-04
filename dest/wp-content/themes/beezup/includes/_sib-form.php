<?php

$subject = isset($_POST['subject']) ? strip_tags(stripslashes($_POST['subject'])) : '';

if( $subject === 'partnership' ){
    $contactId = get_field('contactId2', 'options');
    $contactLists = get_field('contactLists2', 'options');
}else if( $subject === 'other'){
    $contactId = get_field('contactId3', 'options');
    $contactLists = get_field('contactLists3', 'options');
}else if( $subject === 'accounting' ){
    $contactId = get_field('contactId4', 'options');
    $contactLists = get_field('contactLists4', 'options');
}else{
    $contactId = get_field('contactId', 'options');
    $contactLists = get_field('contactLists', 'options');
}

?>

<div class="form-wrapper js-form-wrapper">
    <?php if ($success_message = get_field('form_success_message')): ?>
        <span class="success-message hide"><?php _e($success_message, 'beezup') ?></span>
    <?php endif; ?>
    <?php if( get_field('contactId', 'options') && (get_field('contactId2', 'options') || get_field('contactId3', 'options')) ){ ?>
        <form class='form-choose' method='POST' action='<?php the_permalink(); ?>#sib_embed_signup'>
            <label><?php _e('Subject', 'beezup'); ?></label>
            <div>
                <div class='select'>
                    <select name='subject' id='subject'>
                        <option value='sales'><?php _e('Sales', 'beezup'); ?></option>
                        <?php if( get_field('contactId2', 'options') ){ ?>
                            <option value='partnership' <?php if($subject === 'partnership'){ echo 'selected'; } ?>><?php _e('Partnership', 'beezup'); ?></option>
                        <?php } ?>
                        <?php if( get_field('contactId4', 'options') ){ ?>
                            <option value='accounting' <?php if($subject === 'accounting'){ echo 'selected'; } ?>><?php _e('Accounting', 'beezup'); ?></option>
                        <?php } ?>
                        <?php if( get_field('contactId3', 'options') ){ ?>
                            <option value='other' <?php if($subject === 'other'){ echo 'selected'; } ?>><?php _e('Other', 'beezup'); ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <button class='btn btn-arrow' type='submit' name='choose-submit'>
                <?php _e('Choose', 'beezup'); ?>
                <svg class='icon icon-arrow-right'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='#icon-arrow-right'></use></svg>
            </button>
        </form>
    <?php } ?>

    <div id="sib_embed_signup">
        <div class="forms-builder-wrapper">
            <input type="hidden" id="sib_embed_signup_lang" value="<?php the_field('lang2', 'options'); ?>">
            <input type="hidden" id="sib_embed_invalid_email_message" value="<?php _e("This email address isn't valid", 'beezup'); ?>">
            <input type="hidden" name="primary_type" id="primary_type" value="email">
            <div id="sib_loading_gif_area" style="position: absolute;z-index: 9999;display: none;">
                <img src="https://my.sendinblue.com/public/theme/version4/assets/images/loader_sblue.gif" style="display: block;margin-left: auto;margin-right: auto;position: relative;top: 40%;">
            </div>
            <form class="description sib-form" id="theform" name="theform" action="https://my.sendinblue.com/users/subscribeembed/js_id/2kqou/id/<?php echo $contactId; ?>" onsubmit="return false;" data-action="https://my.sendinblue.com/users/subscribeembed/js_id/2kqou/id/">
                <input type="hidden" name="js_id" id="js_id" value="2kqou">
                <input type="hidden" name="listid" id="listid" value="<?php echo $contactLists; ?>">
                <input type="hidden" name="from_url" id="from_url" value="yes">
                <input type="hidden" name="hdn_email_txt" id="hdn_email_txt" value="">
                <div class="sib-container rounded">
                    <input type="hidden" name="req_hid" id="req_hid" value="~NOM~SURNAME~MESSAGE~TEL_BIS~Captcha">
                    <div class="view-messages"></div>
                    <!-- an email as primary -->
                    <div class="primary-group email-group forms-builder-group ui-sortable">
                        <div class="row">
                            <label class="lbl-tinyltr"><?php _e('Last Name', 'beezup'); ?></label>
                            <input type="text" name="SURNAME" id="SURNAME" value="">
                            <div class="hidden-btns">
                                <a class="btn move" href="#">
                                    <i class="fa fa-arrows"></i>
                                </a><br>
                                <!--<a class="btn btn-danger delete"  href="#"><i class="fa fa-trash-o fa-inverse"></i></a>-->
                            </div>
                        </div>
                        <div class="row">
                            <label class="lbl-tinyltr"><?php _e('First Name', 'beezup'); ?></label>
                            <input type="text" name="NOM" id="NOM" value="">
                            <div class="clear" style="clear:both;"></div>							<div class="hidden-btns">
                                <a class="btn move" href="#"><i class="fa fa-arrows"></i></a><br>	<!--<a class="btn btn-danger delete"  href="#"><i class="fa fa-trash-o fa-inverse"></i></a>-->
                            </div>
                        </div>
                        <div class="row optionnal">
                            <label class="lbl-tinyltr"><?php _e('E-commerce(s) website(s)', 'beezup'); ?> <i>(<?php _e('optional', 'beezup'); ?>)</i></label>
                            <input type="text" name="STORE_LIST" id="STORE_LIST" value="">
                            <div class="clear" style="clear:both;"></div>							<div class="hidden-btns">
                                <a class="btn move" href="#"><i class="fa fa-arrows"></i></a><br>	<!--<a class="btn btn-danger delete"  href="#"><i class="fa fa-trash-o fa-inverse"></i></a>-->
                            </div>
                        </div>
                        <div class="row">
                            <label class="lbl-tinyltr"><?php _e('Phone', 'beezup'); ?></label>
                            <input type="text" name="TEL_BIS" id="TEL_BIS" value="">
                            <div class="clear" style="clear:both;"></div>							<div class="hidden-btns">
                                <a class="btn move" href="#"><i class="fa fa-arrows"></i></a><br>	<!--<a class="btn btn-danger delete"  href="#"><i class="fa fa-trash-o fa-inverse"></i></a>-->
                            </div>
                        </div>
                        <div class="row mandatory-email">
                            <label class="lbl-tinyltr"><?php _e('Email', 'beezup'); ?></label>
                            <input type="email" name="email" id="email" value="">
                            <div style="clear:both;"></div>
                            <div class="hidden-btns">
                                <a class="btn move" href="#"><i class="fa fa-arrows"></i></a><br>
                                <!--<a class="btn btn-danger delete"  href="#"><i class="fa fa-trash-o fa-inverse"></i></a>-->
                            </div>
                        </div>
                        <div class="row">
                            <label class="lbl-tinyltr"><?php _e('Message', 'beezup'); ?></label>
                            <textarea name="MESSAGE" id="MESSAGE"></textarea>
                            <div class="clear" style="clear:both;"></div>
                            <div class="hidden-btns">
                                <a class="btn move" href="#"><i class="fa fa-arrows"></i></a><br>
                                <!--<a class="btn btn-danger delete"  href="#"><i class="fa fa-trash-o fa-inverse"></i></a>-->
                            </div>
                        </div>
                    </div>

                    <div class="captcha forms-builder-group"><div class="row"><div id="gcaptcha" style="transform: scale(1); margin-left: 0px;"></div></div></div>

                    <div class="byline" >
                        <button id="contact-form-send-button" class='btn btn-arrow button editable' type='submit' data-editfield="subscribe">
                            <?php _e('Submit', 'beezup'); ?>
                            <svg class='icon icon-arrow-right'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='#icon-arrow-right'></use></svg>
                        </button>
                    </div>
                    <div style="clear:both;"></div>
                </div>
            </form>
        </div>
    </div>
</div>
