<?php 
/*
Template Name: Contact
*/

$error = false;
$success = false;

$errorLastname = false;
$errorFirstname = false;
$errorMsg = false;
$errorPhone = false;
$errorPhoneTxt = false;
$errorMail = false;
$errorMailTxt = false;
$errorEmpty = false;
$errorSend = false;

$lastname = isset($_POST['last_name']) ? strip_tags(stripslashes($_POST['last_name'])) : '';
$firstname = isset($_POST['first_name']) ? strip_tags(stripslashes($_POST['first_name'])) : '';
$website = isset($_POST['website']) ? strip_tags($_POST['website']) : '';
$phone = isset($_POST['tel']) ? strip_tags($_POST['tel']) : '';
$mail = isset($_POST['email-contact']) ? strip_tags(stripslashes($_POST['email-contact'])) : '';
$msg = isset($_POST['message']) ? strip_tags(stripslashes($_POST['message'])) : '';
$spamUrl = isset($_POST['url']) ? strip_tags(stripslashes($_POST['url'])) : '';

$websitesCount = isset($_POST['new-websites-count']) ? strip_tags($_POST['new-websites-count']) : '';
if( $websitesCount > 0 ){
    for( $i = 1; $i <= $websitesCount; $i++){
        $newWebsites[] = isset($_POST['website'.$i]) ? strip_tags($_POST['website'.$i]) : '';
    }
}

$mailto = get_field('emails', 'options');

if( isset($_POST['submit']) ){
    if( empty($lastname) ){
        $errorLastname = true;
        $errorEmpty = true;
        $error = true;
    }

    if( empty($firstname) ){
        $errorFirstname = true;
        $errorEmpty = true;
        $error = true;
    }

    if( empty($phone) ){
        $errorPhone = true;
        $errorEmpty = true;
        $error = true;
    }else{
        if( !(strlen($phone) < 20 && strlen($phone) > 9 && preg_match("/^\+?[^.\-][0-9\.\- ]+$/", $phone)) ){
            $errorPhoneTxt = __('The phone number is not valid', 'beezup');
            $errorPhone = true;
            $error = true;
        }
    }

    if( empty($mail) ){
        $errorMail = true;
        $errorEmpty = true;
        $error = true;
    }else{
        if( !filter_var($mail, FILTER_VALIDATE_EMAIL) ){
            $errorMailTxt = __('The e-mail address is not valid', 'beezup');
            $errorMail = true;
            $error = true;
        }
    }

    if( empty($msg) ){
        $errorMsg = true;
        $errorEmpty = true;
        $error = true;
    }


    if( !$error ){
        if( empty($spamUrl) ){
            $name = sprintf('%s %s', $firstname, $lastname);
            
            $subjectMail = 'Nouveau message provenant de beezup.com';
            
            $headers = 'From: "' . $name . '" <' . $mail . '>' . "\r\n" .
                       'Reply-To: ' . $mail . "\r\n";
            
            $content = 'De: ' . $name . "\r\n" .
                       'Email: ' . $mail . "\r\n" .
                       'Téléphone: ' . $phone . "\r\n";
            if( !empty($website) ){
                $content .= 'Site web: ' . $website . "\r\n";
            }
            if( isset($newWebsites) ){
                $count = 1;
                foreach( $newWebsites as $newWebsite ){
                    if( !empty($newWebsite) ){
                        $count ++;
                        $content .= 'Site web ' . $count . ': ' . $newWebsite . "\r\n";
                    }
                }
            }
            $content .= "\r\n" . 'Message: ' . $msg;
            
            $sent = wp_mail($mailto, $subjectMail, $content, $headers);
            
            if( $sent ){
                $success = true;
            }else{
                $error = true;
                $errorSend = __("We are sorry, an error happened! Please try again later.", 'beezup');
            }
        }else{
            $success = true;
        }
    }
}

get_header(); ?>

<?php if ( have_posts() ) : the_post(); ?>
	
	<section class='container-medium page-intro small-margin'>
        <div class='page-intro-title'>
            <?php if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>
            
            <h1 class='page-title'>
                <?php get_field('title') ? the_field('title') : the_title(); ?>
            </h1>

            <?php if( get_field('subtitle') ){ ?>
                <h2><?php the_field('subtitle'); ?></h2>
            <?php } ?>

            <?php the_field('text'); ?>
        </div>
        <div class='page-intro-img'>
            <?php the_post_thumbnail( 'full' ); ?>
        </div>
	</section>

    <section class='container relative'>
        <div class='block-half is-alone'>
            <?php if( $error && $errorSend ){ ?>
                <p class='form-error'>
                    <?php echo $errorSend; ?>
                </p>
            <?php } ?>

            <?php if( $success ){ ?>
                <p class='form-success'>
                    <?php _e('Thank you for your message ! We’ll get back to you soon.', 'beezup'); ?>
                    <svg class='icon'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='#icon-check'></use></svg>
                </p>
            <?php } ?>

            <form method='post' action='<?php the_permalink(); ?>' class='<?php if( $success ) echo "success"; ?>'>
                <div class='field <?php if($errorLastname) echo 'error'; ?>'>
                    <label for='last_name'><?php _e('Last Name', 'beezup'); ?></label>
                    <input type='text' name='last_name' id='last_name' value='<?php echo $lastname; ?>' required>
                    <?php if( $errorLastname ){ ?>
                        <svg class='icon'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='#icon-error'></use></svg>
                    <?php } ?>
                </div>

                <div class='field <?php if($errorFirstname) echo 'error'; ?>'>
                    <label for='first_name'><?php _e('First Name', 'beezup'); ?></label>
                    <input type='text' name='first_name' id='first_name' value='<?php echo $firstname; ?>' required>
                    <?php if( $errorFirstname ){ ?>
                        <svg class='icon'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='#icon-error'></use></svg>
                    <?php } ?>
                </div>

                <div class='field optionnal'>
                    <label for='website'><?php _e('E-commerce(s) website(s)', 'beezup'); ?> <i>(<?php _e('optionnal', 'beezup'); ?>)</i></label>
                    <input type='url' name='website' id='webiste' value='<?php echo $website; ?>' placeholder='http://'>
                    <button id='addUrlInput' class='btn-add' type='button'>
                        <?php _e('Add', 'beezup'); ?>
                        <svg class='icon icon-plus'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='#icon-plus'></use></svg>
                    </button>
                    <input type='hidden' value='0' name='new-websites-count' id='newInputsCount'>
                </div>

                <div class='field <?php if($errorPhone) echo 'error'; ?>'>
                    <label for='tel'><?php _e('Phone', 'beezup'); ?></label>
                    <input type='tel' name='tel' id='tel' value='<?php echo $phone; ?>' required>
                    <?php if( $errorPhone ){ ?>
                        <svg class='icon'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='#icon-error'></use></svg>
                    <?php } ?>
                </div>

                <div class='field <?php if($errorMail) echo 'error'; ?>'>
                    <label for='email'><?php _e('Email', 'beezup'); ?></label>
                    <input type='email' name='email-contact' id='email' value='<?php echo $mail; ?>' required>
                    <?php if( $errorMail ){ ?>
                        <svg class='icon'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='#icon-error'></use></svg>
                    <?php } ?>
                </div>

                <div class='field <?php if($errorMsg) echo 'error'; ?>'>
                    <label for='message'><?php _e('Message', 'beezup'); ?></label>
                    <textarea name='message' id='message' required><?php echo $msg; ?></textarea>
                    <?php if( $errorMsg ){ ?>
                        <svg class='icon'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='#icon-error'></use></svg>
                    <?php } ?>
                </div>

                <div class='hidden'>
                    <input type='url' name='url2' id='url2' value='<?php echo $spamUrl; ?>'>
                    <label for='url2'><?php _e('Please leave this field empty', 'beezup'); ?></label>
                </div>

                <?php if( $error && !$errorSend ){ ?>
                    <p class='form-error'>
                        <?php if($errorEmpty) echo __('Please fill all the required fields', 'beezup') . '<br>'; ?>
                        <?php if($errorPhoneTxt) echo $errorPhoneTxt . '<br>'; ?>
                        <?php if($errorMailTxt) echo $errorMailTxt; ?>
                        <svg class='icon'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='#icon-error'></use></svg>
                    </p>
                <?php } ?>

                <button class='btn btn-arrow' type='submit' name='submit' for='form-contact'>
                    <?php _e('Submit', 'beezup'); ?>
                    <svg class='icon icon-arrow-right'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='#icon-arrow-right'></use></svg>
                </button>
            </form>
        </div>
        <?php if( have_rows('people', 'options') ){ ?>
            <ul class='members'>
                <?php while( have_rows('people', 'options') ){ the_row(); ?>
                    <li class='member'>
                        <span class='photo' style='background-image: url(<?php echo wp_get_attachment_image_url( get_sub_field('photo', 'options'), 'full' ); ?>);'></span>
                        <span class='name'><?php the_sub_field('name', 'options'); ?></span>
                        <span class='job '><?php the_sub_field('job', 'options'); ?></span>
                    </li>
                <?php } ?>
            </ul>
        <?php } ?>
    </section>

    <?php get_template_part('includes/free-links'); ?>

<?php else : ?>

	<div class='container-small'>
		<h1>404</h1>
	</div>

<?php endif; ?>

<?php get_footer(); ?>