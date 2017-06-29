var $ = require('jquery');

module.exports = function(input){
    input.val() !== '' ? input.addClass('on') : input.removeClass('on');
}