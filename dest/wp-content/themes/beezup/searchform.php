<form role='search' method='get' action='<?php echo home_url('/'); ?>' class='js-inline-form'>
	<div class='field-inline'>
		<input type='search' name='s' id='search' value='<?php the_search_query(); ?>'>
		<label for='search'><?php _e('Rechercher', 'beezup'); ?>...</label>
		<button type='submit'><?php _e('Rechercher', 'beezup'); ?></button>
	</div>
</form>