var $ = require('jquery');

module.exports = function(tarifHeader){
    if(!tarifHeader.length) return;

    var price, tarifOffers = $('#tarifOffers'), tarifContent = $('#tarif-content'), feature;

    tarifHeader.on('click', '.js-btnPrice', function(){
        $(this).parent().addClass('selected').siblings().removeClass('selected');

        price = $(this)[0].dataset.price;

        tarifOffers.find('.price').addClass('hidden');
        tarifOffers.find('.js-field' + price).removeClass('hidden');

        tarifContent.find('.feature').each( function(){
            feature = $(this).find('.js-feature-' + price);
            feature = feature.length ? feature : $(this).find('.js-feature-price1');
            $(this).find('.feature-content').addClass('hidden');
            feature.removeClass('hidden');
        });
    });
}