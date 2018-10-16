const $ = require('jquery');

module.exports = () => {
    const hash = window.location.hash.replace('/', '');
    const formWrapper = $('.js-form-wrapper');
    const gtmId = 'GTM-TSMVR9W';

    if (hash === '#succeded') {
        formWrapper
            .addClass('succeded')
            .children()
            .each((index, child) => {
                if (!$(child).hasClass('hide')) {
                    $(child).addClass('hide');
                }
            });

        formWrapper.find('.success-message').removeClass('hide');

        if (gtagReportConversion) {
            const gtagScript = document.createElement('script');
            gtagScript.src = `https://www.googletagmanager.com/gtag/js?id=${gtmId}`;
            document.body.appendChild(gtagScript);
            gtagScript.addEventListener(
                'load',
                () => {
                    gtagReportConversion();
                },
                false
            );
        }
    }
};
