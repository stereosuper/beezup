var $ = require('jquery');

module.exports = function(wp, countrySelect, sectorSelect, channelsList){
    if(!wp || !channelsList.length) return;

    var form = countrySelect.closest('form');
    var channels = channelsList.find('li');
    var sectorError = $('#sectorError');

    function filterBySector(sector){
        channels.removeClass('hidden');
        if(sector !== 'all'){
            channels.not('[data-sector="' + sector + '"]').addClass('hidden');
        }

        if(sectorError.length){
            channels.not('.hidden').length ? sectorError.html('') : sectorError.html(wp.noChannels);
        }
    }

    if(countrySelect.length){
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
                    channels = channelsList.find('li');

                    if(sectorSelect.length){
                        filterBySector(sectorSelect.val());
                    }
                },
                error: function(req, status, err){
                    console.log(err);
                }
            });
        });
    }

    if(sectorSelect.length){
        sectorSelect.on('change', function(){
            filterBySector($(this).val());
        });
    }
    
}