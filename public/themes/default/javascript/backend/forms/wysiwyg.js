/* ========================================================================
 * wysiwyg.js
 * Page/renders: forms-wysiwyg.html
 * Plugins used: summernote
 * ======================================================================== */

'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([
            'summernote'
        ], factory);
    } else {
        factory();
    }
}(function () {

    $(function () {
        // Summernote
        // ================================
        $('.summernote').summernote({
            height: 200,
            lang: 'pt-BR'
        });
    });

}));