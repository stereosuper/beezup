var $ = require('jquery');

module.exports = function(btn){
    if(!btn.length) return;

    var typeList;

    btn.on('click', function(){
        typeList = $(this).closest('.js-dropdown');
        typeList.toggleClass('closed').removeClass('top');

        if($(document).scrollTop() > typeList.offset().top){
            typeList.addClass('top');
        }
    });
}