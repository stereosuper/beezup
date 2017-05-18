var $ = require('jquery-slim');

window.requestAnimFrame = require('./requestAnimFrame.js');
var throttle = require('./throttle.js');

module.exports = function(stickyElt, position){
    if(!stickyElt.length) return;

    var scrollTop = $(document).scrollTop();

    function scrollHandler() {

        scrollTop = $(document).scrollTop();
        if (scrollTop >= stickyElt.data('offsetTop') - position) {
            stickyElt.addClass('sticky').css('top', position+'px');
            if (scrollTop + position + stickyElt.data('height') >= stickyElt.data('offsetBottom')) {
                stickyElt.removeClass('sticky').addClass('sticky-stuck').css({'top': 'auto', 'bottom': '0'});
            }else {
                stickyElt.addClass('sticky').removeClass('sticky-stuck').css('top', position+'px');
            }
        }else {
            stickyElt.removeClass('sticky').css('top', stickyElt.data('initialPos'));
        }
    }

    function resizeHandler() {
        stickyElt.data({
            'offsetBottom': stickyElt.closest('.wrapper-sticky').offset().top + stickyElt.closest('.wrapper-sticky').outerHeight(),
            'height': stickyElt.height()
        });

    }


    stickyElt.data({
        'initialPos': stickyElt.css('top'),
        'offsetTop': stickyElt.offset().top,
        'offsetBottom': stickyElt.closest('.wrapper-sticky').offset().top + stickyElt.closest('.wrapper-sticky').outerHeight(),
        'height': stickyElt.height()
    });


    
    $(document).on('scroll', throttle(function(){
        requestAnimFrame(scrollHandler);
    }, 10));

    $(document).on('resize', throttle(function(){
        requestAnimFrame(resizeHandler);
    }, 10));
}
