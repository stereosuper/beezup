var $ = require('jquery');
var TweenLite = require('gsap/TweenLite');

module.exports = function(){
    var tag = document.createElement('script'), firstScriptTag = document.getElementsByTagName('script')[0];
    var wrapperVideos = $('.inner-video'), players = [];

    global.onYouTubeIframeAPIReady = function(){
        function onPlayerReady(wrapperVideoParent){
            wrapperVideoParent.on('click', function(){
                TweenLite.to($(this).find('.cover-video'), 0.5, {opacity: 0, display: 'none'});
                players[$(this).index('.inner-video')].playVideo();
            }).find('.cover-video').addClass('on');
        }

        wrapperVideos.each(function(i){
            players[i] = new YT.Player($(this).find('.iframe').get(0), {
                videoId: $(this).data('id'),
                playerVars: {
                    modestbranding: 1,
                    color: 'white',
                    rel: 0,
                    showinfo: 0
                },
                events: {
                    'onReady': onPlayerReady($(this))
                }
            });
        });
    };

    tag.src = 'https://www.youtube.com/iframe_api';
    firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
};