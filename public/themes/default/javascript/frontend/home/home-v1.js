/* ========================================================================
 * home-v1.js
 * Page/renders: frontend/index.html
 * Plugins used: owl carousel, layer slider 
 * ======================================================================== */

'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([
            'owl-carousel',
            'layerslider'
        ], factory);
    } else {
        factory();
    }
}(function () {

    $(function () {
        // Carousel
        // ================================
        $('#customer-reviews').owlCarousel({
            singleItem: true,
            autoPlay: true,
            autoHeight: true
        });
        $('#lovely-client').owlCarousel({
            autoPlay: true,
            autoHeight: true,
            pagination: false
        });

        // Layerslider
        // ================================
        if ($('#layerslider').length !== 0) {
            $('#layerslider').layerSlider({
                responsive: false,
                responsiveUnder: 1280,
                layersContainer: 1280,
                skin: 'fullwidth',
                hoverPrevNext: false,
                skinsPath: '../public/themes/default/plugins/layerslider/skins/'
            });
        }

        //Min-height section
        //979 - 687 = 292
        //979/4 = 244.75
        //292-244.75 = 47.25
        var mh = $(window).height();
        var minHeight = (mh / 4) + 47;
        minHeight = mh - minHeight;

        //$('section.section').css('min-height',minHeight);
    });

}));
