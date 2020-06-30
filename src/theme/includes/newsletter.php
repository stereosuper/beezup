<?php
$newsletter_form_script_id = get_field('newsletterFormId', 'options');
$newsletter_form_script_src = get_field('newsletterFormSrc', 'options');
if($newsletter_form_script_id && $newsletter_form_script_src):
?>
<form id="<?php echo $newsletter_form_script_id ?>"></form>
<script async src="<?php echo $newsletter_form_script_src ?>"></script>
<?php endif; ?>
