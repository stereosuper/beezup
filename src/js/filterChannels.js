var $ = require('jquery');

module.exports = function(wp, wrapper, countrySelect, sectorSelect, channelsList){
    if(!wp || !wrapper.length || !channelsList.length) return;

    var form = countrySelect.closest('form');
    var channels = channelsList.find('li');
    var sectorError = wrapper.find('#sectorError');
    var btn = $('.js-btn-type');
    var typeList = $('#channelsType')/*, allTypesLi*/;

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
        countrySelect.on('change', function(){
            wrapper.addClass('loading');

            // update channels list
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

            // if(typeList.length){
            //     // Update subpages list
            //     allTypesLi = typeList.find('li').eq(0);

            //     $.ajax({
            //         method: 'GET',
            //         url: wp.adminAjax,
            //         data: 'action=beezup_ajax_get_types_pages&networkPage=' + wp.networkPage + '&' + form.serialize() + '&type=' + wp.type + '&pageID=' + wp.pageID,
            //         dataType: 'html',
            //         success: function(data){
            //             allTypesLi.siblings().remove();
            //             allTypesLi.after(data);
            //         },
            //         error: function(req, status, err){
            //             console.log(err);
            //         }
            //     });
            // }
        });
    }

    if(sectorSelect.length){
        sectorSelect.on('change', function(){
            filterBySector($(this).val());
        });
    }

    if(btn.length && typeList.length){
        btn.on('click', function(){
            typeList.toggleClass('closed').removeClass('top');
            
            if($(document).scrollTop() > typeList.offset().top){
                typeList.addClass('top');
            }
        });
    }
    
}