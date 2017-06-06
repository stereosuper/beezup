<form role='search' method='get' action='<?php echo home_url('/'); ?>' class='js-inline-form searchform'>
	<div class='field-inline'>
		<input type='search' name='s' id='search' value='<?php the_search_query(); ?>'>
		<label for='search'><?php _e('Search', 'beezup'); ?>...</label>
		<button type='submit' class='btn-search'><?php _e('Search', 'beezup'); ?> <svg class='icon'><use xlink:href='#icon-search'></use></svg></button>
	</div>
</form>