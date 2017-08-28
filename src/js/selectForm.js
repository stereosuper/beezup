var $ = require('jquery');

module.exports = function(wp, subject, form, listInput){
    if( !wp.isFormPage || !subject.length || !form.length || !listInput.length ) return;

    var contactId, contactLists;

    subject.on('change', function(){
        switch( $(this).val() ){
            case 'support':
            case 'partnership':
                contactId = wp.contactIds.support;
                contactLists = wp.contactLists.support;
                break;
            case 'accounting':
                contactId = wp.contactIds.accounting;
                contactLists = wp.contactLists.accounting;
                break;
            case 'other':
                contactId = wp.contactIds.other;
                contactLists = wp.contactLists.other;
                break;
            default:
                contactId = wp.contactIds.sales;
                contactLists = wp.contactLists.sales;
        }

        form.attr('action', form.data('action') + contactId);
        listInput.val(contactLists);
    });
}