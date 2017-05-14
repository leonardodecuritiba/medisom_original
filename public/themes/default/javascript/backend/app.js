/* ========================================================================
 * App.js v1.3.0
 * Copyright 2014 pampersdry
 * ======================================================================== */
'use strict';
(function (factory) {
    if (typeof define === 'function' && define.amd) {
        define(['core'], factory);
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
                loader: false,
                console: false
            });
        },
        // Template sidebar sparklines
        // NOTE: require sparkline plugin
        // ================================
        sidebarSparklines: {
            init: function () {
                $('aside .sidebar-sparklines').sparkline('html', {
                    enableTagOptions: true
                });
            }
        },
        // Template header dropdown
        // ================================
        headerDropdown: {
            init: function (options) {
                // core dropdown function
                function coreDropdown(e) {
                    // define variable
                    var $target = $(e.target),
                        $mediaList = $target.find('.media-list'),
                        $indicator = $target.find('.indicator');
                    // show indicator
                    $indicator.addClass('animation animating fadeInDown').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                        $(this).removeClass('animation animating fadeInDown');
                    });
                    // Check for content via ajax
                    $.ajax({
                        url: options.url,
                        cache: false,
                        type: 'POST',
                        dataType: 'json'
                    }).done(function (data) {
                        // define some variable
                        var template = $target.find('.mustache-template').html(),
                            rendered = Mustache.render(template, data);
                        // hide indicator
                        $indicator.addClass('hide');
                        // update data total
                        $target.find('.count').html('(' + data.data.length + ')');
                        // render mustache template
                        $mediaList.prepend(rendered);
                        // add some intro animation
                        $mediaList.find('.media.new').each(function () {
                            $(this).addClass('animation animating flipInX').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function () {
                                $(this).removeClass('animation animating flipInX');
                            });
                        });
                    });
                }

                // the dropdown
                $(options.dropdown).one('shown.bs.dropdown', coreDropdown);
            }
        },
        addService: {
            init: function () {
                $('.more_services').off('click').on('click', function () {
                    $('.services').last().clone().insertAfter('.services:last-child');
                });
                $('.remove_services').off('click').on('click', function () {
                    if ($('.services').length > 1) {
                        $('.services').last().remove();
                    } else {
                        $.gritter.add({
                            title: 'Aviso',
                            text: 'não é possivel excluir este servico, é necessário pelo menos 1 cadastrado.',
                            sticky: false,
                        });
                    }
                });
            }
        },
        removeAction: {
            init: function () {
                $('body').find('i.fa-remove').parent('a').off('click').on('click', function () {
                    var c = confirm('Confirma excluir este registro, esta ação é irreversivel.');
                    if (!c) {
                        return false;
                    }
                    return true;
                });
            }
        },
    };
    $(function () {
        // Init template core
        APP.init();
        APP.addService.init();
        APP.removeAction.init();
        doModals();

        if ($('#form-users')) {
            $('form#form-users').find('input[name=user_tipo]').on('click', function () {
                if (this.checked) {
                    if (this.value == 1) {
                        $.get(Ajax.url_site + "/app/views/forms/new-user.blade.php", function (data) {
                            $("form#form-users #dataform").html(data);
                            $("form#form-users #dataform").append('<input type="hidden" name="send_email_to_user" value="1">');
                            showHideExtra();
                        });
                        $('#pessoa_tipo').addClass('hide');
                    } else {
                        $('#pessoa_tipo').removeClass('hide');
                    }
                }
            });
            $('form#form-users').find('input[name=pessoa_tipo]').on('click', function () {
                if (this.checked) {
                    if (this.value == 'Pessoa Física') {
                        $.get(Ajax.url_site + "/app/views/forms/orcamento-pf.blade.php", function (data) {
                            $("form#form-users #dataform").html(data);
                            $("form#form-users #dataform").append('<input type="hidden" name="send_email_to_user" value="1">');
                            showHideExtra();
                        });
                    } else {
                        $.get(Ajax.url_site + "/app/views/forms/orcamento-pj.blade.php", function (data) {
                            $("form#form-users #dataform").html(data);
                            $("form#form-users #dataform").append('<input type="hidden" name="send_email_to_user" value="1">');
                            showHideExtra();
                        });
                    }

                }
            });
        }

        function doModals() {
            $('body').find('.modals').each(function () {
                $(this).on('click', function () {
                    $($(this).data('target')).on('show.bs.modal', function (event) {
                        doLoading('hide');

                        var button = $(event.relatedTarget);
                        var title = button.data('title');
                        var form = button.data('form');
                        var formaction = button.data('formaction');
                        var nameid = button.data('nameid');
                        var id = button.data('id');
                        var size = button.data('size');
                        var vars = button.data('vars');
                        var varsdata = '{';
                        var i = 0;
                        if (vars != '') {
                            vars = vars.split(',');
                            for (var i in vars) {
                                var tmp_name = vars[i];
                                varsdata += '"' + tmp_name + '":"' + button.data(vars[i]) + '",';
                            }
                        }
                        varsdata += '}';

                        varsdata = varsdata.replace(',}', '}');

                        var modal = $(this);
                        modal.find('.modal-dialog').addClass(size);
                        modal.find('.modal-body').html(doLoading('show'));
                        modal.find('.modal-title').text(title);
                        modal.find('.modal-content form').find('input').val('');
                        modal.find('.modal-content form').attr('id', form).attr('name', form).attr('action', formaction);
                        console.log(formaction);

                        modal.find('.modal-body').load(Ajax.url_views + 'forms/' + form + '.blade.php', {
                            formid: form,
                            nameid: nameid,
                            id: id,
                            vars: varsdata
                        }, function () {
                            loadFormData(form);
                        });

                        sendForm(form);
                    });
                });

            });

        }

        function doLoading(action) {

            if (action == '') {
                action = 'hide';
            } else if (action == 'hide') {
                $('body').find('.indicator').remove();
            } else {
                return '<div class="indicator ' + action + '"><span class="spinner"></span></div>';
            }
        }

        function sendForm(formid) {
            $('form').find('.form-send').off('click').on('click', function () {
                var thisForm = event.target.form;
                var action = $(thisForm).attr('action');
                var method = $(thisForm).attr('method');
                if (method == '')
                    method = 'POST';

                var data = $(thisForm).serialize();

                $.ajax({
                    url: action + '/' + $(thisForm).find('input[name=method]').val() + '/' + $(thisForm).find('input[name=action]').val() + '/',
                    type: method,
                    data: data,
                    beforeSend: function (xhr) {
                        $(thisForm).parent('.modal-content').append(doLoading('show'));
                    },
                    success: function (response) {
                        console.log(response);
                        doLoading('hide');
                    }
                });

            });

        }

        function loadFormData(form) {

            var thisForm = '#' + form;
            var action = $(thisForm).attr('action');
            var method = $(thisForm).attr('method');


            if (method == '')
                method = 'GET';

            var data = $(thisForm).serialize();

            console.log(action + '/' + $(thisForm).find('input[name=method]').val() + '/' + $(thisForm).find('input[name=getdata]').val() + '/');
            console.log(data);
            //formid=add-alert&post_id=52&method=Postmeta&action=update_meta&getdata=get_alert_dashboard&alert_min_time_leq=&alert_min_alarm_set=&alert_min_ipa=&alert_max_time_leq=&alert_max_alarm_set=&alert_max_ipa=
            $.ajax({
                url: action + '/' + $(thisForm).find('input[name=method]').val() + '/' + $(thisForm).find('input[name=getdata]').val() + '/',
                type: method,
                data: data,
                beforeSend: function (xhr) {
                    $(thisForm).parent('.modal-content').append(doLoading('show'));
                },
                success: function (response) {

                    var arr = $.parseJSON(response);
                    // console.log(response);
                    for (var i in arr) {
                        $(thisForm + ' input').each(function () {

                            // console.log(arr[i][this.name]);
                            // console.log(arr[i]['meta_key']);
                            // console.log(arr[i]['meta_value']);
                            // {"postmeta_id":"150","post_id":"52","meta_key":"alert_max_email_laeq","meta_value":"1"}
                            if (typeof (arr[i][this.name]) != 'undefined') {
                                if (this.type == 'checkbox') {
                                    if (arr[i][this.name] == 1) {
                                        this.checked = true;
                                    } else {
                                        this.checked = false;
                                    }
                                } else {
                                    $(thisForm + ' input[name=' + this.name + ']').val(arr[i][this.name]);
                                }
                            }
                            else if (typeof (arr[i]['meta_key']) != 'undefined') {
                                if (arr[i]['meta_key'] == this.name) {
                                    if (this.type == 'checkbox') {
                                        if (arr[i]['meta_value'] == 1) {
                                            this.checked = true;
                                        } else {
                                            this.checked = false;
                                        }
                                    } else {
                                        $(thisForm + ' input[name=' + this.name + ']').val(arr[i]['meta_value']);
                                    }
                                }
                            }
                        });
                    }


                    doLoading('hide');
                }
            });
        }


        function showHideExtra() {
            $('form#form-users input[type=radio]').each(function () {
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
            $('#selectize-selectmultiple').selectize();
        }


        $('a.alert-confirm').on('click', function () {
            if (confirm('Deseja confirmar a remoção desse ' + $(this).attr('data-title') + '? Esta ação é irreversivel.')) {
                //alert('confirmado '+$(this).attr('data-href'));
                var url = $(this).attr('data-href');
                $.post(url, {"_method": "DELETE"}, function (response) {
                    // This is a callback. Do stuff here if you want.
                    location.reload();
                });
                return true;
            }
            return false;
        });

        $('.add_sensor').on('click', function () {
            var dataform = $('form#form-sensores').serialize();
            var method = $('input[name=method]').val();
            var action = $('input[name=action]').val();
            var save = false;

            if ($(this).text() == 'Salvar') {
                save = true;
            }
            $.ajax({
                url: Ajax.json_url + '/' + method + '/' + action,
                type: 'POST',
                data: dataform,
                success: function (data) {
                    //console.log(data); return;
                    location.reload(true);
                    if (save) {
                        $('form[name=form-sensores]').find('button.add_sensor').text('Add Novo');
                        alert('Salvo com sucesso.');
                    } else {

                        $.get(Ajax.json_url + '/' + method + '/get', {
                            column: 'post_id',
                            compare: '=',
                            value: data[0]
                        }, function (post) {

                            if (typeof (post[0][0].post_id) != 'undefined') {
                                var thisStatus = (post[0][0].status == 'publish') ? 'Ativo' : 'Inativo';
                                var thisClass = (post[0][0].status == 'publish') ? 'success' : 'danger';
                                var html = '<tr class="' + thisClass + '" id="' + post[0][0].post_id + '">';
                                html += '    <td>' + post[0][0].post_id + '</td>';
                                html += '    <td>' + post[0][0].title + '</td>';
                                html += '    <td class="status">' + thisStatus + '</th>';
                                html += '    <td>';
                                html += '        <a href="javascript:;" data-status="' + thisStatus + '" data-formid="form-sensores" data-id="' + post[0][0].post_id + '" class="edit_sensor" ><i class="ico ico-edit"></i>Desativar</a>';
                                html += '        <a href="javascript:;" data-status="' + thisStatus + '" data-formid="form-sensores" data-id="' + post[0][0].post_id + '" class="remove_sensor text-danger"><i class="ico ico-trash"></i>Excluir</a>';
                                html += '    </td>';
                                html += '</tr>';
                                $('table#sensores').prepend(html);
                            }

                        });
                    }
                },
                error: function () {
                    alert('Não foi possivel efetuar esta operação');
                }
            });

        });
        $('a.remove_sensor').each(function () {
            $(this).on('click', function () {
                var thisId = $(this).attr('data-id');
                var thisFormId = $(this).attr('data-formid');
                if (thisId > 0) {
                    var thisMethod = $('form#' + thisFormId + ' input[name=method]').val();
                    if (thisMethod) {
                        $.ajax({
                            url: Ajax.json_url + '/' + thisMethod + '/remove',
                            type: 'POST',
                            data: {
                                'post_id': thisId
                            },
                            success: function (data) {
                                $('table#sensores tr#' + thisId).remove();
                            },
                            error: function () {
                                alert('Não foi possivel efetuar esta operação');
                            }
                        });
                    }
                }
            });
        });
        $('a.edit_sensor').each(function () {
            $(this).on('click', function () {
                var thisId = $(this).attr('data-id');
                var thisFormId = $(this).attr('data-formid');
                var thisStatus = $(this).attr('data-status');
                if (thisId > 0) {
                    var thisMethod = $('form#' + thisFormId + ' input[name=method]').val();
                    if (thisMethod) {
                        $.ajax({
                            url: Ajax.json_url + '/' + thisMethod + '/update_status',
                            type: 'POST',
                            data: {
                                'post_id': thisId,
                                'status': thisStatus
                            },
                            success: function (data) {
                                if (thisStatus == 'publish') {
                                    $('table#sensores tr#' + thisId).removeClass('danger').addClass('success');
                                    $('table#sensores tr#' + thisId + ' a.edit_sensor').html('<i class="ico ico-edit"></i>Desativar</a>');
                                    $('table#sensores tr#' + thisId + ' td.status').text('Ativo');
                                    $('table#sensores tr#' + thisId + ' a.edit_sensor').attr('data-status', 'inactive');
                                } else {
                                    $('table#sensores tr#' + thisId).addClass('danger').removeClass('success');
                                    $('table#sensores tr#' + thisId + ' a.edit_sensor').html('<i class="ico ico-edit"></i>Ativar</a>');
                                    $('table#sensores tr#' + thisId + ' a.edit_sensor').attr('data-status', 'publish');
                                    $('table#sensores tr#' + thisId + ' td.status').text('Inativo');
                                }
                            },
                            error: function () {
                                alert('Não foi possivel efetuar esta operação');
                            }
                        });
                    }
                }
            });
        });

        $('a.update_sensor').each(function () {
            $(this).on('click', function () {
                var thisFormId = $(this).attr('data-formid');
                var thisId = $(this).attr('data-id');
                var thisTitle = $(this).attr('data-title');
                var thisStatus = $(this).attr('data-status');
                var thisMeasures = $(this).attr('data-measures');
                $('form[name=' + thisFormId + ']').find('button.add_sensor').text('Salvar');
                if (thisId > 0) {
                    $('form[name=' + thisFormId + '] input[name=id]').val(thisId); // Adicionado em 01/03
                    $('form[name=' + thisFormId + '] input[name=post_id]').val(thisId);
                    $('form[name=' + thisFormId + '] input[name=title]').val(thisTitle);
                    $('form[name=' + thisFormId + '] select[name=status]').val(thisStatus);
                    var thisContent = thisMeasures.split(';');
                    $(thisContent).each(function (i) {
                        var VA = thisContent[i].replace(/ x /g, ',');
                        console.log("Não está funcionando passar os valores dos gráficos do sensor");
                        $('form[name=form-sensores] select[name="measures[]"] option[value="' + VA + '"]').attr('selected', true);
                    });
                }
            });
        });

        //$('body').find('input[data-type=datepicker]').datepicker();

        /*
         */
        $('input[name="month"]').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: 'mm-yy',
            onClose: function (dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));
            }
        });
        $('input[name="week"]').datepicker({
            dateFormat: "dd-mm-yy",
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 1
        });
        $('input[name="start_period"]').datepicker({
            dateFormat: "dd-mm-yy",
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 3,
            onClose: function (selectedDate) {
                $("input[name=end_period]").datepicker("option", "minDate", selectedDate);
            }
        });
        $("input[name=end_period]").datepicker({
            dateFormat: "dd-mm-yy",
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 3,
            onClose: function (selectedDate) {
                $("input[name=start_period]").datepicker("option", "maxDate", selectedDate);
            }
        });

        $('#date_period').datepicker({
            dateFormat: "dd-mm-yy",
            defaultDate: "+1w",
            changeMonth: true,
            changeYear: true,
            numberOfMonths: 3
        });

        $('body').find('.tree-checkboxes').jqueryTree({
            expandAll: true,
            checkboxes: true, // depends on jquery.qubit plugin
            createCheckboxes: true // takes values from data-name and data-value, and data-name is inherited
        });
        //APP.charts.init();
        // Init template sidebar summary
        APP.sidebarSparklines.init();
        // Init template message dropdown
        APP.headerDropdown.init({
            'dropdown': '#header-dd-message',
            'url': '../api/message.php'
        });
        // Init template notification dropdown
        APP.headerDropdown.init({
            'dropdown': '#header-dd-notification',
            'url': '../api/notification.php'
        });


        function loadJSON(url) {
            $.get(url, '', function (result) {

                console.debug(result);
            });
            // parse adn return the output

        }


    });
}));