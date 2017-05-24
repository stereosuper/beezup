var $ = require('jquery-slim');

module.exports = function(btn, hiddenInputCount){
    if(!btn.length && !hiddenInputCount) return;

    var inputCount = 0;

    btn.on('click', function(){
        inputCount ++;
        $(this).parent().append('<input type="url" name="website' + inputCount + '" value="" placeholder="http://" class="new-input">').find(hiddenInputCount).val(inputCount);
    });
}