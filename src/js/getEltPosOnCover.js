var $ = require('jquery');

module.exports = function(container, imgRatio, imgW, imgH, elt){
    var containerH = container.outerHeight();
    var containerW = container.width();
    var containerRatio = containerH / containerW;

    var posX = elt.data('x');
    var posY = elt.data('y');

    var finalH, finalW, newX, newY, ratioScale;

    if(containerRatio > imgRatio){
        // portrait
        finalH = containerH;
        finalW = imgW*finalH / imgH;
        newX = finalW*posX / imgW - (finalW - containerW)/2;
        newY = finalH*posY / imgH;
    }else{
        // paysage
        finalW = containerW;
        finalH = imgH*finalW / imgW;
        newX = finalW*posX / imgW;
        newY = finalH*posY / imgH - (finalH - containerH)/2;
    }

    ratioScale = (finalH / imgH).toFixed(3);

    return [newX, newY, ratioScale];
}
