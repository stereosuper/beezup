jQuery(document).ready(function($) {

    $('.r8_tsm_page_select').select2({
        data: tsm_data,
        placeholder: 'Select page(s) or post(s) where the script should be output',
        width: '400'
    });

});
