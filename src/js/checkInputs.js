var $ = require('jquery-slim');

module.exports = function(forms){
    if(!forms.length) return;

    function checkInput(input){
        if($(this).is(':hidden') || $(this).attr('type') === 'radio') return;
        input.val() !== '' ? input.addClass('on') : input.removeClass('on');
    }

    forms.find('input, textarea').each(function(){
        checkInput($(this));
    }).on('change input', function(){
        checkInput($(this));
    });
}