/**
 * The reason why we move preloading here again is because when we preload images in app.js or app-depth.js files,
 * we have to wait everything to be finish loading (because we use DEFER attribute) to load these images which is 
 * not a good idea. so we have to run the preloading in here to load the images in the beginning
 */

// preload important images that needs to be shown in the beginning
function preloadImages(srcs) {
    if (!preloadImages.cache) {
        preloadImages.cache = [];
    }
    var img;
    for (var i = 0; i < srcs.length; i++) {
        img = new Image();
        img.src = srcs[i];
        preloadImages.cache.push(img);
    }
}

var imageSrcs = ["/assets/images/icons/sp.png"];
preloadImages(imageSrcs);
