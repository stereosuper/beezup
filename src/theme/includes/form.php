<?php
    global $error, $errorSend, $success, $lastname, $errorLastname, $firstname, $errorFirstname,
    $website, $errorPhone, $phone, $errorMail, $mail, $msg, $errorMsg, $spamUrl, $errorEmpty, $errorPhoneTxt, $errorMailTxt;
?>

<div id='form'>

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

    <form method='post' action='<?php the_permalink(); ?>#form' class='<?php if( $success ) echo "success"; ?>' id='form-contact'>
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
            <input type='url' name='website' id='website' value='<?php echo $website; ?>' placeholder='http://'>
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
            <label for='email-contact'><?php _e('Email', 'beezup'); ?></label>
            <input type='email' name='email-contact' id='email-contact' value='<?php echo $mail; ?>' required>
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

        <button class='btn btn-arrow' type='submit' name='submit' form='form-contact'>
            <?php _e('Submit', 'beezup'); ?>
            <svg class='icon icon-arrow-right'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='#icon-arrow-right'></use></svg>
        </button>
    </form>
    
</div>