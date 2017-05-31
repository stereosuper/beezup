var $ = require('jquery');

module.exports = function(wp, wrapper, countrySelect, sectorSelect, channelsList){
    if(!wp || !wrapper.length || !channelsList.length) return;

    var form = countrySelect.closest('form');
    var channels = channelsList.find('li');
    var sectorError = wrapper.find('#sectorError');

    function filterBySector(sector){
        channels.removeClass('hidden');
        if(sector !== 'all'){
            channels.not('[data-sector="' + sector + '"]').addClass('hidden');
        }

        if(!sectorError.length) return;
        
        if(channels.not('.hidden').length){
            sectorError.html('');
        }else{
            wp.type ? sectorError.html(wp.noChannelsType) : sectorError.html(wp.noChannels);
        }
       
        if(sector === 'all'){
            sectorError.html('');
        }
    }

    if(countrySelect.length){
        form.find('#channelsSubmit').addClass('hidden');

        countrySelect.on('change', function(){
            wrapper.addClass('loading');

            $.ajax({
                method: 'GET',
                url: wp.adminAjax,
                data: 'action=beezup_ajax_get_data&isNetworkPage=' + wp.isNetworkPage + '&' + form.serialize() + '&type=' + wp.type,
                dataType: 'html',
                success: function(data){
                    channelsList.html(data);
                    wrapper.removeClass('loading');
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