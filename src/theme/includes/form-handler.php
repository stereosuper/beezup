<?php

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

?>