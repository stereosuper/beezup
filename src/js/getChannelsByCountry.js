var $ = require('jquery');

module.exports = function(wp, countrySelect, channelsList){
    if(!wp || !countrySelect.length || !channelsList.length) return;

    var form = countrySelect.closest('form');

    form.find('#channelsSubmit').addClass('hidden');

    countrySelect.on('change', function(){
        channelsList.addClass('loading');

        $.ajax({
            method: 'GET',
            url: wp.adminAjax,
            data: 'action=beezup_ajax_get_data&isNetworkPage=' + wp.isNetworkPage + '&' + form.serialize(),
            dataType: 'html',
            success: function(data){
                channelsList.html(data).removeClass('loading');
            },
            error: function(req, status, err){
                console.log(err);
            }
        })
    });
}