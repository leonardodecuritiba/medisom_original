/* ========================================================================
 * App.js v1.3.0
 * Copyright 2014 pampersdry
 * ======================================================================== */

'use strict';

(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define([
            'core'
        ], factory);
    } else {
        factory();
    }
}(function () {

    var APP = {
        // Core init
        // NOTE: init at html element
        // ================================
        init: function () {
            $('html').Core({
                loader: true
            });
        },
        search: function () {

            $.post('http://freela.dev/msom/site/', {'nome': 'msom'});

            $('i.search').css('cursor', 'pointer');
            $('i.search').off('click').on('click', function () {
                var s = $(this).parent('div').parent('form').find('input#search').val();
                var ac = $(this).parent('div').parent('form').attr('action');
                $(this).parent('div').parent('form').attr('action', ac + '/' + s);
                $(this).parent('div').parent('form').attr('method', 'post');
                $(this).parent('div').parent('form').submit();
            });

            $('input#search').keypress(function (e) {
                if (e.which == 13) {
                    var s = $(this).parent('div').parent('form').find('input#search').val();
                    var ac = $(this).parent('div').parent('form').attr('action');

                    $(this).parent('div').parent('form').attr('action', ac + '/' + s);
                    $(this).parent('div').parent('form').attr('method', 'post');

                    $(this).parent('div').parent('form').submit();
                }
            });
        },
        form: function () {
            if ($('#form-orcamento')) {
                $.get("app/views/site/forms/orcamento-pf.blade.php", function (data) {
                    $("form#form-orcamento #dataform").html(data);
                    showHideExtra();
                });

                $('form#form-orcamento').find('input[name=pessoa_tipo]').on('click', function () {
                    if (this.checked) {
                        if (this.value == 'Pessoa Física') {
                            $.get("app/views/site/forms/orcamento-pf.blade.php", function (data) {
                                $("form#form-orcamento #dataform").html(data);
                                showHideExtra();
                            });
                        } else {
                            $.get("app/views/site/forms/orcamento-pj.blade.php", function (data) {
                                $("form#form-orcamento #dataform").html(data);
                                showHideExtra();
                            });
                        }
                    }
                });


            }

            function showHideExtra() {
                $('form#form-orcamento input[type=radio]').each(function () {
                    $(this).on('click', function () {
                        if (this.name == 'prazo') {
                            if (this.value == 'À Prazo') {
                                $('#prazo_dias').removeClass('hide').addClass('pull-right');
                            } else {
                                $('#prazo_dias').addClass('hide');
                            }
                        }
                        if (this.name == 'pagamento') {
                            if (this.value == 'Outro') {
                                $('#pagamento_outro').removeClass('hide').addClass('pull-left');
                            } else {
                                $('#pagamento_outro').addClass('hide');
                            }
                        }
                    });
                });

                $('#selectize-tagging').selectize({
                    delimiter: ',',
                    persist: false,
                    create: function (input) {
                        return {
                            value: input,
                            text: input
                        };
                    }
                });
            }
        }

    };

    $(function () {
        // Init template core
        APP.init();

        APP.search();

        APP.form();
    });

}));