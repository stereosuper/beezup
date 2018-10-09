const $ = require('jquery');

const checkInput = require('./checkInput.js');

module.exports = function(forms) {
    if (!forms.length) return;

    forms.each(function() {
        $(this)
            .find('input')
            .each(function() {
                checkInput($(this));
            })
            .on('change input', function() {
                checkInput($(this));
            });
    });
};
