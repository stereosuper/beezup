var $ = require('jquery-slim');

module.exports = function(forms){
    if(!forms.length) return;

    function checkInput(input){
        input.val() !== '' ? input.addClass('on') : input.removeClass('on');
    }

    forms.find('input').each(function(){
        checkInput($(this));
    }).on('change input', function(){
        checkInput($(this));
    });
}