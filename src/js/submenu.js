var $ = require('jquery');

module.exports = function(nav){
    if(!nav.length) return;

    var submenus = nav.find('.sub-menu');

    if(!submenus.length) return;

    var navLeft = nav.offset().left;
    var item;
    var menu;

    submenus.each(function(){
        item = $(this).parents('li');
        menu = $(this).children('ul');

        menu.css({
            'marginLeft': item.offset().left + item.width() / 2 - menu.width() / 2 - navLeft
        });
    });
}
