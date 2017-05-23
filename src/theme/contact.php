<?php 
/*
Template Name: Contact
*/

$error = false;
$success = false;
$errorLastname = false;
$errorFirstname = false;
$errorPhone = false;
$errorMail = false;
$errorMsg = false;
$errorSend = false;

$lastname = isset($_POST['last_name']) ? strip_tags(stripslashes($_POST['last_name'])) : '';
$firstname = isset($_POST['first_name']) ? strip_tags(stripslashes($_POST['first_name'])) : '';
$website = isset($_POST['website']) ? strip_tags($_POST['website']) : '';
$phone = isset($_POST['tel']) ? strip_tags($_POST['tel']) : '';
$mail = isset($_POST['email-contact']) ? strip_tags(stripslashes($_POST['email-contact'])) : '';
$msg = isset($_POST['message']) ? strip_tags(stripslashes($_POST['message'])) : '';
$spamUrl = isset($_POST['url']) ? strip_tags(stripslashes($_POST['url'])) : '';

$mailto = get_field('emails', 'options');

if( isset($_POST['submit']) ){
    if( empty($lastname) ){
        $errorLastname = __('The field "Last Name" is mandatory', 'beezup');
        $error = true;
    }

    if( empty($firstname) ){
        $errorFirstname = __('The field "First Name" is mandatory', 'beezup');
        $error = true;
    }

    if( empty($phone) ){
        $errorPhone = __('The field "Phone" is mandatory', 'beezup');
        $error = true;
    }else{
        if( !(strlen($phone) < 20 && strlen($phone) > 9 && preg_match("/^\+?[^.\-][0-9\.\- ]+$/", $phone)) ){
            $errorPhone = __('The phone number is not valid', 'beezup');
            $error = true;
        }
    }

    if( empty($mail) ){
        $errorMail = __('The field "E-mail" is mandatory', 'beezup');
        $error = true;
    }else{
        if( !filter_var($mail, FILTER_VALIDATE_EMAIL) ){
            $errorMail = __('The e-mail address is not valid', 'beezup');
            $error = true;
        }
    }

    if( empty($msg) ){
        $errorMsg = __('The field "Your project" is mandatory', 'beezup');
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
	
	<section class='container'>
       <?php if( function_exists('yoast_breadcrumb') ){ yoast_breadcrumb('<div class="breadcrumbs">','</span></div>'); } ?>
        
		<h1 class='title-black'>
			<?php the_title(); ?>
			<?php if( get_field('title2') ){ ?>
				<span><?php the_field('title2'); ?></span>
			<?php } ?>
		</h1>

        <?php if( get_field('subtitle') ){ ?>
            <h3><?php the_field('subtitle'); ?></h3>
        <?php } ?>

        <?php the_field('text'); ?>

        <?php the_post_thumbnail( 'full' ); ?>
	</section>

    <section class='container'>
        <?php if( $error && $errorSend ){ ?>
            <p class='form-error'>
                <?php echo $errorSend; ?>
            </p>
        <?php } ?>
        
        <?php if( $success ){ ?>
            <p class='form-success'>
                <?php _e('Thank you for your message ! We’ll get back to you soon.', 'beezup'); ?>
            </p>
        <?php } ?>

        <form method='post' action='<?php the_permalink(); ?>'>
            <div class='<?php if($errorLastname) echo 'error'; ?>'>
                <label for='last_name'><?php _e('Last Name', 'beezup'); ?></label>
                <input type='text' name='last_name' id='last_name' value='<?php echo $lastname; ?>' required>
                <?php if($errorLastname) echo '<span>'. $errorLastname .'</span>'; ?>
            </div>

            <div class='<?php if($errorFirstname) echo 'error'; ?>'>
                <label for='first_name'><?php _e('First Name', 'beezup'); ?></label>
                <input type='text' name='first_name' id='first_name' value='<?php echo $firstname; ?>' required>
                <?php if($errorFirstname) echo '<span>'. $errorFirstname .'</span>'; ?>
            </div>

            <div>
                <label for='website'><?php _e('E-commerce(s) website(s)', 'beezup'); ?> <i>(<?php _e('optionnal', 'beezup'); ?>)</i></label>
                <input type='url' name='website' id='webiste' value='<?php echo $website; ?>'>
            </div>

            <div class='<?php if($errorPhone) echo 'error'; ?>'>
                <label for='tel'><?php _e('Phone', 'beezup'); ?></label>
                <input type='tel' name='tel' id='tel' value='<?php echo $phone; ?>' required>
                <?php if($errorPhone) echo '<span>'. $errorPhone .'</span>'; ?>
            </div>

            <div class='<?php if($errorMail) echo 'error'; ?>'>
                <label for='email'><?php _e('Email', 'beezup'); ?></label>
                <input type='email' name='email-contact' id='email' value='<?php echo $mail; ?>' required>
                <?php if($errorMail) echo '<span>'. $errorMail .'</span>'; ?>
            </div>

            <div class='<?php if($errorMsg) echo 'error'; ?>'>
                <label for='message'><?php _e('Message', 'beezup'); ?></label>
                <textarea name='message' id='message' required><?php echo $msg; ?></textarea>
                <?php if($errorMsg) echo '<span>'. $errorMsg .'</span>'; ?>
            </div>

            <div class='hidden'>
                <input type='url' name='url2' id='url2' value='<?php echo $spamUrl; ?>'>
                <label for='url2'><?php _e('Please leave this field empty', 'beezup'); ?></label>
            </div>

            <?php if( $error && !$errorSend ){ ?>
                <p class='form-error'>
                    <?php _e('Please fill all the required fields', 'beezup'); ?>
                </p>
            <?php } ?>

            <button class='btn-arrow' type='submit' name='submit' for='form-contact'>
                <?php _e('Submit', 'beezup'); ?>
            </button>
        </form>

        <?php if( have_rows('people', 'options') ){ ?>
            <ul>
                <?php while( have_rows('people', 'options') ){ the_row(); ?>
                    <li>
                        <?php the_sub_field('name', 'options'); ?>
                        <?php the_sub_field('job', 'options'); ?>
                        <?php echo wp_get_attachment_image( get_sub_field('photo', 'options'), 'full' ); ?>
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