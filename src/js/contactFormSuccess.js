const $ = require('jquery');

module.exports = () => {
    const hash = window.location.hash.replace('/', '');
    const formWrapper = $('.js-form-wrapper');

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
    }
};
