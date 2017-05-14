<?php
$meses = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];
?>

<style>
    /*
    .MonthDatePicker .ui-datepicker-year
    {
        display:none;
    }
    .HideTodayButton .ui-datepicker-buttonpane .ui-datepicker-current
    {
        visibility:hidden;
    }

    .hide-calendar .ui-datepicker-calendar
    {
        display:none!important;
        visibility:hidden!important
    }
    */
</style>


<div class="col-lg-12" id="widget-report-manual">
    <!-- START Widget Panel -->
    <div class="widget panel bgcolor-default">
        <!-- panel body -->
        <div class="panel-body">
            <form id="form-report-manual">
                <div class="form-group" id="box-filter">
                    <div class="col-sm-4">
                        <label for="sensor_id" class="control-label">Sensor <span class="text-danger">*</span></label>
                        <select class="form-control" name="sensor_id">
                            @foreach ($sensores as $sensor)
                                <option value="{{$sensor->post_id}}">{{$sensor->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="report" class="control-label">Tipo de relatório:</label>
                        <select id="type_report" name="type_report" placeholder="Tipo de relatório...">
                            <option value="detalhado" selected>Detalhado</option>
                            <option value="periodo">Por período</option>
                            <option value="diario">Diário</option>
                            <option value="semanal">Semanal</option>
                            <option value="dias_da_semana">Dias da semana</option>
                            <option value="hora">Por hora</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="report" class="control-label">Indicadores: </label>
                        <select id="selectize-selectmultiple" class="form-control graph-select" name="measures[]"
                                style="z-index: 99999;" placeholder="Escolha ..." multiple required="required">
                            <option value="">Escolha...</option>
                            @foreach($report_options['indicadores'] as $indicador => $Indicador)
                                <option value="{{$indicador}}">{{$Indicador['nome']}}</option>
                                {{--<option value="{{$Indicador['indice']}}">{{$Indicador['impressao']}}</option>--}}
                            @endforeach
                        </select>
                    </div>
                    <script>
                        {{--var $_INDICADORES_ = jQuery.parseJSON('{{json_encode($Indicadores)}}');--}}
                        {{--$(document).ready(function(){--}}
                        {{--var $SELECT_SENSOR = $('select[name=sensor_id]');--}}
                        {{--var $SELECT_INDICADOR = $('select[name="measures[]"]').selectize();--}}
                        {{--$($SELECT_SENSOR).on('change', function () {--}}
                        {{--console.log($_INDICADORES_);--}}
                        {{--console.log($_INDICADORES_);--}}
                        {{--var $select = $($SELECT_INDICADOR)[0].selectize;--}}
                        {{--var url_ = "{{url('get_only_indicadores_by_sensorid','XX')}}";--}}
                        {{--url_ = url_.replace('XX', $(this).find(':selected').val());--}}
                        {{--$select.clearOptions();--}}
                        {{--$.ajax({--}}
                        {{--url: url_,--}}
                        {{--type: 'get',--}}
                        {{--dataType: "json",--}}
                        {{--error: function (xhr, textStatus) {--}}
                        {{--console.log('xhr-error: ' + xhr.responseText);--}}
                        {{--console.log('textStatus-error: ' + textStatus);--}}
                        {{--},--}}
                        {{--success: function (indicadores) {--}}
                        {{--$(indicadores).each(function (i, v) {--}}
                        {{--$select.addOption({--}}
                        {{--value: v,--}}
                        {{--text: $_INDICADORES_[v].nome--}}
                        {{--});--}}
                        {{--});--}}
                        {{--$select.refreshItems();--}}
                        {{--$select.setValue('{{$selected_indicador}}', true);--}}
                        {{--}--}}
                        {{--});--}}
                        //                            });
                        {{--//SETANDO O SENSOR--}}
                        {{--var editar = 0;--}}
                        {{--@if($action=='editar')--}}
                        {{--editar = 1;--}}
                        {{--$SELECT_SENSOR[0].selectize.setValue({{$selected_sensor}});--}}
                        {{--@endif--}}
                        //                        });

                    </script>
                    {{--<div class="col-md-3">--}}
                    {{--<label for="graph" class="control-label">Tipo de gráfico:</label>--}}
                    {{--<select id="type_graph" name="type_graph" placeholder="Tipo de gráfico...">--}}
                    {{--<option value="line">Linhas</option>--}}
                    {{--<option value="bar">Barras</option>--}}
                    {{--</select>--}}
                    {{--</div>--}}
                </div>
                <div class="col-md-12">
                    <hr>
                </div>
                <div class="form-group" id="type_report_target">
                    <div data-type="detalhado" class="col-md-2">
                        <label for="data_detalhado" class="control-label">Data</label>
                        <input type="text" class="form-control detalhado-datepicker" name="data_detalhado">
                    </div>
                    <div data-type="periodo" class="col-md-2 hide">
                        <label for="data_periodo" class="control-label">Resolução</label>
                        <select name="resolucao" class="form-control" required>
                            <option value="minuto">Por minuto</option>
                            <option value="hora">Por hora</option>
                        </select>
                    </div>

                    <div data-type="data" class="col-md-2 hide">
                        <label for="data_inicial" class="control-label">Data Inicial</label>
                        <input type="text" id="data-datepicker-from" class="form-control" name="data_inicial">
                    </div>
                    <div data-type="data" class="col-md-2 hide">
                        <label for="data_final" class="control-label">Data Final</label>
                        <input type="text" id="data-datepicker-to" class="form-control" name="data_final">
                    </div>
                    <div data-type="semanal" class="col-md-2 hide">
                        <label for="mes" class="control-label">Mês </label>
                        <select class="form-control" name="mes">
                            @foreach($meses as $i => $mes)
                                <option value="{{$i}}">{{$mes}}</option>
                                @ENDFOREACH
                        </select>
                    </div>
                    <div data-type="hora" class="col-md-2 hide">
                        <label for="hora_inicial" class="control-label">Horário Inicio </label>
                        <input type="text" id="time-picker-from" class="form-control" name="hora_inicial" value="00:00">
                    </div>
                    <div data-type="hora" class="col-md-2 hide">
                        <label for="hora_final" class="control-label">Horário Fim </label>
                        <input type="text" id="time-picker-to" class="form-control" name="hora_final" value="23:59">
                    </div>
                </div>
            </form>
            <div class="col-md-12">
                <hr>
            </div>
            {{--Botão--}}
            <div class="form-group">
                <div class="col-md-6 action-filter">
                    <button type="submit" class="btn btn-default"><i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                        Filtrar
                    </button>
                </div>
                <div class="col-md-6">
                    <button id="print-report" class="btn btn-default pull-right" disabled><i class="fa fa-print"
                                                                                             aria-hidden="true"></i>
                        Gerar PDF
                    </button>
                </div>
            </div>
        </div>
        <!--/ panel body -->
    </div>
    <div class="widget panel bgcolor-default">
        <div class="panel-body">
            <div class="col-md-12">
                <table border="0" class="media table table-hover hide">
                    <thead id="minimax_table">
                    <tr>
                        <th>Sensor</th>
                        <th><i class="ico-arrow-down5"></i> Mínimo</th>
                        <th><i class="ico-arrow-up5"></i> Máximo</th>
                        <th><i class="ico-minus"></i> Média</th>
                        <th><i class="ico-plus"></i> Acumulado</th>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <div id="charts"
                     data-type="full"
                     style="height: 500px;background-color: transparent"></div>
            </div>
        </div>
    </div>
    <!--/ END Widget Panel -->
</div>


{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/dateformat/jquery-dateFormat.min.js' )}}
{{--{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/charts/amcharts.report.manual.js' )}}--}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/charts/layout_relatorio.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/charts/amcharts.report.js' )}}

<script>
    //VARIÁVEIS GLOBAIS
    $_RETURN_REPORT = null;
    $_FORM_CHART_ = 'form#form-report-manual';
    $_BTN_PRINT_CHART_ = '.panel-body .form-group button#print-report';
    $_BTN_FILTER_CHART_ = '.panel-body .form-group div.action-filter button';
    $_ID_DIV_CHART_ = 'charts';
    $_AMCHART_ = null;
    var _TEMPO_ = 1800;

    //VARIÁVEIS DO RELATÓRIO A SER IMPRESSO
    $REPORT_GLOBAL = {};
    $REPORT_GLOBAL.report = [];
    $REPORT_GLOBAL.amchart = {};


    $TEXTO_BTN = [];
    $TEXTO_BTN[0] = '<i class="fa fa-spinner" aria-hidden="true"></i> Aguarde, seu Relatório está sendo gerado...';
    $TEXTO_BTN[1] = '<i class="fa fa-print" aria-hidden="true"></i> Gerar PDF';

    $(document).ready(function () {
        $('select#type_report').change(function () {
            type = $('select#type_report').val();
            $('div#type_report_target').find('div[data-type="detalhado"]').addClass('hide');
            $('div#type_report_target').find('div[data-type="hora"]').addClass('hide');
            $('div#type_report_target').find('div[data-type="data"]').addClass('hide');
            $('div#type_report_target').find('div[data-type="semanal"]').addClass('hide');
            $('div#type_report_target').find('div[data-type="periodo"]').addClass('hide');
            switch (type) {
                case 'detalhado':
                    $('div#type_report_target').find('div[data-type="detalhado"]').removeClass('hide');
                    break;
                case 'hora':
                    $('div#type_report_target').find('div[data-type="data"]').removeClass('hide');
                    break;
                case 'semanal':
                    $('div#type_report_target').find('div[data-type="semanal"]').removeClass('hide');
                    $('div#type_report_target').find('div[data-type="hora"]').removeClass('hide');
                    break;
                case 'periodo':
                    $('div#type_report_target').find('div[data-type="periodo"]').removeClass('hide');
                    $('div#type_report_target').find('div[data-type="data"]').removeClass('hide');
                    $('div#type_report_target').find('div[data-type="hora"]').removeClass('hide');
                    break;
                default:
                    $('div#type_report_target').find('div[data-type="data"]').removeClass('hide');
                    $('div#type_report_target').find('div[data-type="hora"]').removeClass('hide');
                    break;
            }
//                        $('div.action-filter').removeClass('hide');
        });
    });

    $(document).ready(function () {
        var src = '{{asset('public/themes/default/image/ajax-loader.gif')}}';
        $img_loader = '<img src="' + src + '" />';
        $('.detalhado-datepicker').datepicker({
            defaultDate: '+1w',
            numberOfMonths: 2,
            maxDate: new Date(),
            dateFormat: "dd-mm-yy"
        }).datepicker("setDate", "0");
        $('#data-datepicker-from').datepicker({
            defaultDate: '+1w',
            numberOfMonths: 2,
            maxDate: new Date(),
            dateFormat: "dd-mm-yy",
            onClose: function (selectedDate) {
                $('#data-datepicker-to').datepicker('option', 'minDate', selectedDate);
            }
        }).datepicker("setDate", "0");
        $('#data-datepicker-to').datepicker({
            defaultDate: '+1w',
            numberOfMonths: 2,
            maxDate: new Date(),
            dateFormat: "dd-mm-yy",
            onClose: function (selectedDate) {
                $('#data-datepicker-from').datepicker('option', 'maxDate', selectedDate);
            }
        }).datepicker("setDate", "0");
    });

    $(document).ready(function () {
        $($_BTN_FILTER_CHART_).off('click').on('click', function () {
            $('table.media').addClass('hide');
            $('#' + $_ID_DIV_CHART_).html($img_loader + " Aguarde, carregando o gráfico... ");

            $data_form = $($_FORM_CHART_).serialize();
            $json_url = '{{route('report-manual')}}';
            $TIPO = $($_FORM_CHART_).find('select#type_report').val();
            $_RETURN_REPORT = null;

            //desabilitando o botão de imprimir
            $($_BTN_PRINT_CHART_).attr('disabled', true);

            console.log($json_url + '?' + $data_form);
            $.ajax({
                type: 'GET',
                url: $json_url,
                data: $data_form,
                dataType: 'json',
                success: function (result) {
                    result = jQuery.parseJSON(result);
                    if (result.status == 0) {
                        $('#' + $_ID_DIV_CHART_).html(result.response);
                        return false;
                    }
                    $_RETURN_REPORT = result.response;
                    console.log($_RETURN_REPORT);

                    $_AMCHART_ = null;

                    //Definindo as variáveis globais
                    chartData = [];

                    $.each($_RETURN_REPORT.data, function (i, v) {
                        if (v.total > 0) {
                            chartData.push(v);
                        }
                    });

                    $REPORT_GLOBAL = {};
                    $REPORT_GLOBAL.report = [];
                    $REPORT_GLOBAL.report['medias'] = $_RETURN_REPORT.minimax;
                    $REPORT_GLOBAL.report['graph'] = $_RETURN_REPORT.graph_options.graph;
                    $REPORT_GLOBAL.report['colors'] = $_RETURN_REPORT.graph_options.colors;
                    $REPORT_GLOBAL.report['categoryField'] = $_RETURN_REPORT.graph_options.category_field;
                    $REPORT_GLOBAL.report['bullets'] = $_RETURN_REPORT.graph_options.bullets;

                    // GERAR AMCHART
                    var div_chart = $_ID_DIV_CHART_;
                    var GRAPH = $REPORT_GLOBAL.report['graph'];
                    var CATEGORY_FIELD = $REPORT_GLOBAL.report['categoryField'];
                    var color = $REPORT_GLOBAL.report['colors'];

//                    alert(CATEGORY_FIELD);return;
                    var nomes = chartData[0].category.split(',');
                    var bullet = $REPORT_GLOBAL.report['bullets'];
                    var graph = [];

                    for (var i in nomes) {

                        var idc = nomes[i]; //indicador
                        var v = "value" + (i);
                        var vid = "v" + (i);
                        var gid = "g" + (i);
                        var customBullet = bullet[i];

                        if (GRAPH == 'bar') {
                            graph.push({
                                "type": "column",
                                "balloonText": idc + ": [[" + v + "]]",
                                "fillColors": color[i],
                                "fillAlphas": 0.8,
                                "id": idc,
                                "lineAlpha": 0.2,
                                "title": idc,
                                "valueField": v,

                            });
                        } else {
                            graph.push({
                                "valueAxis": v,
                                "lineColor": color[i],
                                "bullet": customBullet,
                                "balloonText": idc + ": [[" + v + "]]",
                                "lineThickness": 3,
                                "bulletBorderThickness": 1,
                                "hideBulletsCount": 30,
                                "title": idc,
                                "valueField": v,
                                "fillAlphas": 0
                            });
                        }
                    }

                    var CATEGORY_AXIS = {};
                    CATEGORY_AXIS = {};
                    if (CATEGORY_FIELD == 'date') {
                        if (GRAPH == 'line') {
                            CATEGORY_AXIS = {
                                "axisColor": "#DADADA",
                                "parseDates": true,
                                "minPeriod": "mm",
                                "minorGridEnabled": true
                            };
                        } else if (GRAPH == 'bar') {
                            CATEGORY_AXIS = {"axisColor": "#DADADA", "parseDates": true, "gridPosition": "start"};
                        }
                    } else {
                        CATEGORY_AXIS = {"axisColor": "#DADADA", "gridPosition": "start"};
                    }

                    $_AMCHART_ = AmCharts.makeChart(div_chart, {
                        "type": "serial",
                        "theme": "light",
                        "legend": {
                            "horizontalGap": 10,
                            "maxColumns": 1,
                            "position": "right",
                            "useGraphSettings": true,
                            "markerSize": 15
                        },
                        "autoResize": false,
                        "fontSize": 15,
                        "zoomOutText": "Tudo",
                        "dataProvider": chartData,
                        "graphs": graph,
                        "chartScrollbar": {},
                        "chartCursor": {
                            "cursorPosition": "mouse",
                            "categoryBalloonDateFormat": "DD MMM YYYY JJ:NN"
                        },
                        "categoryField": CATEGORY_FIELD,
                        "categoryAxis": CATEGORY_AXIS,
                        "export": {
                            "enabled": true,
                            "position": "bottom-right",
                            "libs": {
                                //"path": "../../../public/themes/default/plugins/amcharts/plugins/export/libs/"
                                "path": "//amcharts.com/lib/3/plugins/export/libs/"
                            },
                            "menu": [{
                                "class": "export-main",
                                "label": "Export",
                                "menu": [{
                                    "label": "Download ...",
                                    "menu": ["PNG", "JPG", "SVG", {
                                        "format": "PDF",
                                        "content": ["Saved from:", window.location.href, {
                                            "image": "reference",
                                            "fit": [523.28, 769.89] // fit image to A4
                                        }]
                                    }]
                                }, {
                                    "label": "Savar como ...",
                                    "menu": ["CSV", "XLSX", "JSON"]
                                }, {
                                    "label": "Criar Anotação",
                                    "action": "draw"
                                }, {
                                    "label": "Compartilhar",
                                    "click": function () {
                                        this.capture({}, function () {
                                            this.toPNG({}, function (data) {
                                                var graph = encodeURIComponent(data);
                                                jQuery.post("/admin/share/save", {imageData: graph}, function (img) {
                                                    jQuery('#modal-share').modal('show').find('img').attr('src', '/public/uploads/share/' + img);
                                                    jQuery('#modal-share').find('input#img_shared').val(img);
                                                    jQuery('#modal-share').find('.form-send').on('click', function () {
                                                        var formdata = $(this).parent('div').parent('form').serialize();
                                                        jQuery.post("/admin/share/share", formdata, function (response) {
                                                            if (response) {
                                                                jQuery('#modal-share').find('.modal-body').prepend('<div class="alert alert-dismissable alert-success">' +
                                                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
                                                                        '<strong>Sucesso!</strong> Gráfico compartilhado.</div>');
                                                            } else {
                                                                jQuery('#modal-share').find('.modal-body').prepend('<div class="alert alert-dismissable alert-danger">' +
                                                                        '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' +
                                                                        '<strong>Erro!</strong> Não foi possível compartilhar o gráfico.</div>');
                                                            }
                                                        });
                                                    });
                                                });
                                            });
                                        });
                                    }
                                }, {
                                    "format": "PRINT",
                                    "label": "Imprimir"
                                }]
                            }],

                            "drawing": {
                                "menu": [{
                                    "class": "export-drawing",
                                    "menu": [{
                                        "label": "Adicionar ...",
                                        "menu": [{
                                            "label": "Figura",
                                            "action": "draw.shapes"
                                        }, {
                                            "label": "Texto",
                                            "action": "text"
                                        }]
                                    }, {
                                        "label": "Alterar ...",
                                        "menu": [{
                                            "label": "Modo ...",
                                            "action": "draw.modes"
                                        }, {
                                            "label": "Cor ...",
                                            "action": "draw.colors"
                                        }, {
                                            "label": "Tamanho ...",
                                            "action": "draw.widths"
                                        }, {
                                            "label": "Opacidade ...",
                                            "action": "draw.opacities"
                                        }, "UNDO", "REDO"]
                                    }, {
                                        "label": "Download ...",
                                        "menu": ["PNG", "JPG", "SVG", "PDF"]
                                    }, "PRINT", "CANCEL"]
                                }]
                            }
                        }

                    });

                    // GERAR DADOS DA TABELA
                    var DateFormat = 'dd MMM yyyy HH:mm';
                    switch ($TIPO) {
                        case 'diario':
                            DateFormat = 'dd MMM yyyy';
                            break;
                        case 'dias_da_semana':
                            DateFormat = 'ddd';
                            break;
                        case 'hora':
                            DateFormat = 'HH:mm';
                            break;
                        case 'minuto':
                            DateFormat = 'HH:mm';
                            break;
                    }

                    //Limpando a tabela com as médias do período dos indicadores
                    $('table.media').find('tbody').empty();

                    $.each($REPORT_GLOBAL.report['medias'], function (i, v) {
                        console.log(v);
                        $row = '<tr>' +
                                '<td><p class="semibold sensor-">' + v.base + ' (' + v.escala + ')</p></td>';

                        if ($TIPO == 'semanal') {
                            $row += '<td><p class="pull-left semibold" title="Mínima">' + v.min + '</p></td>' +
                                    '<td><p class="pull-left semibold" title="Máxima">' + v.max + '</p></td>';
                        } else {
                            $row += '<td><p class="pull-left semibold" title="Mínima">' + v.min + ' (' + $.format.date(v.data_min, DateFormat) + ')</p></td>' +
                                    '<td><p class="pull-left semibold" title="Máxima">' + v.max + ' (' + $.format.date(v.data_max, DateFormat) + ')</p></td>';

                        }

                        $row += '<td><p class="pull-left semibold" title="Média">' + v.med + '</p></td>';
                        if (v.base == 'IPA') {
                            $row += '<td><p class="pull-left semibold" title="Média Acumulada">' + v.acum + ' (' + v.acum_p.toString() + '%)' + '</p></td>';
                        } else {
                            $row += '<td><p class="pull-left semibold" title="Média Acumulada">-</p></td>';
                        }

                        $row += '</tr>';
                        $('table.media').find('tbody').append($row);
                    });

                    //Mostrando a tabela com as médias do período dos indicadores
                    $('table.media').removeClass('hide');
                    $($_BTN_PRINT_CHART_).attr('disabled', false);

                },
                error: function () {
                    $('#' + $_ID_DIV_CHART_).html("Ocorreu um erro inesperado, tente novamente ou utilize o filtro para buscar outros períodos.");
                }
            });
        });
    });

    function reset_button() {
        $($_BTN_PRINT_CHART_).html($TEXTO_BTN[1]);
        $($_BTN_PRINT_CHART_).attr('disabled', false);
        $($_BTN_FILTER_CHART_).attr('disabled', false);
    }

    $(document).ready(function () {
        $($_BTN_PRINT_CHART_).off('click').on('click', function () {

            $(this).html($TEXTO_BTN[0]);
            $(this).attr('disabled', true);
            $($_BTN_FILTER_CHART_).attr('disabled', true);


            tipo = $($_FORM_CHART_).find('select#type_report').val();
            switch (tipo) {
                case 'periodo':
                    $REPORT_GLOBAL.title += '(Por ' + $($_FORM_CHART_).find('select#resolucao').val() + ')';
                    break;
                case 'semanal':
                    $REPORT_GLOBAL.title += '(' + $($_FORM_CHART_).find('select#mes').val() + ')';
                    break;
            }

            $dados_report = $_RETURN_REPORT.dados_report;

            //Variáveis do layout do relatório
            $REPORT_GLOBAL.amchart = $_AMCHART_;
            $REPORT_GLOBAL.header = $dados_report.header;
            $REPORT_GLOBAL.title = $dados_report.titulo;
            $REPORT_GLOBAL.report = [];
            $REPORT_GLOBAL.report['nome'] = $dados_report.nome;
            $REPORT_GLOBAL.report['id'] = $dados_report.id;

            $REPORT_GLOBAL.report['author'] = $dados_report.author;
            $REPORT_GLOBAL.report['sensor_nome'] = $dados_report.sensor_nome;
            $REPORT_GLOBAL.report['indicadores'] = $dados_report.indicadores;
            $REPORT_GLOBAL.report['periodo'] = $dados_report.periodo;
            $REPORT_GLOBAL.report['tipo'] = $dados_report.tipo;
            $REPORT_GLOBAL.report['intervalo'] = $dados_report.intervalo;
            $REPORT_GLOBAL.report['logo_medisom'] = $dados_report.logo_medisom;
            $REPORT_GLOBAL.report['logo_cliente'] = $dados_report.logo_cliente;
            $REPORT_GLOBAL.report['filename'] = $dados_report.filename;

            $REPORT_GLOBAL.report['medias'] = $_RETURN_REPORT.minimax; //Cálculo do máx, mín e média

            //Report options
            $REPORT_GLOBAL.report['categoryField'] = $_RETURN_REPORT.graph_options.category_field;
            $REPORT_GLOBAL.report['colors'] = $_RETURN_REPORT.graph_options.colors;
            $REPORT_GLOBAL.report['graph'] = $_RETURN_REPORT.graph_options.graph;

            console.log($_RETURN_REPORT);
            console.log($REPORT_GLOBAL);

            createReport($REPORT_GLOBAL, 'reset_button');

        })
    });


</script>