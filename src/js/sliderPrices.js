var $ = require('jquery');

module.exports = function(tarifHeader){
    if(!tarifHeader.length) return;

    var price, classPrice, tarifOffers = $('#tarifOffers');

    tarifHeader.on('click', '.js-btnPrice', function(){
        $(this).parent().addClass('selected').siblings().removeClass('selected');

        price = $(this)[0].dataset.price;
        classPrice = '.js-field' + price;
        tarifOffers.find('.price').addClass('hidden');
        tarifOffers.find(classPrice).removeClass('hidden');
    });
}