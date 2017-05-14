<?php

return $report;
//Report data
//tirando os valores nulos
foreach ($report->meta_value->data as $dt) {
    if ($dt->total > 0) {
        $REPORT_DATA['data_report'][] = $dt;
    }
}
$REPORT_DATA['data_report'] = json_encode($REPORT_DATA['data_report']);
$REPORT_DATA['medias'] = json_encode($report->meta_value->minimax);

$_DATA_REPORT_ = $report->meta_value->dados_report;
$hora_criacao = $report->meta_key;

//Report text
$REPORT_PDF['header'] = "www.medisom.com.br - Relatório Agendado - Criado em: " . $hora_criacao;
$REPORT_PDF['nome'] = $_DATA_REPORT_->nome;
$REPORT_PDF['id'] = $_DATA_REPORT_->id;
$REPORT_PDF['titulo'] = $_DATA_REPORT_->titulo;
$REPORT_PDF['sensor_nome'] = $_DATA_REPORT_->sensor_nome;
$REPORT_PDF['indicadores'] = implode(', ', json_decode($_DATA_REPORT_->indicadores));
$REPORT_PDF['periodo'] = 'De ' . $_DATA_REPORT_->range_inicial . ' a ' . $_DATA_REPORT_->range_final;
$REPORT_PDF['tipo'] = $_DATA_REPORT_->tipo;
$REPORT_PDF['intervalo'] = $_DATA_REPORT_->intervalo_inicial . '/' . $_DATA_REPORT_->intervalo_final;
$REPORT_PDF['logo_medisom'] = $_DATA_REPORT_->logo_medisom;
$REPORT_PDF['logo_cliente'] = $_DATA_REPORT_->logo_cliente;
$REPORT_PDF['filename'] = $_DATA_REPORT_->filename;

//Report options
$REPORT_OPTIONS['category_field'] = $report->meta_value->graph_options->category_field;
$REPORT_OPTIONS['colors'] = json_encode($report->meta_value->graph_options->colors);
$REPORT_OPTIONS['graph'] = $report->meta_value->graph_options->graph;

?>
        <!DOCTYPE html>
<html class="backend">
<!-- START Head -->
<head>
    <!-- START META SECTION -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$title}} | Medisom</title>
    <meta name="description" content="Medisom">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, report-scalable=no">

{{ HTML::style('public/themes/'.Option::get('theme_site').'/stylesheet/bootstrap.css') }}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/vendor.js' )}}

{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/amcharts/amcharts.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/amcharts/serial.js' )}}

{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/amcharts/plugins/export/export.js' )}}
{{ HTML::style('public/themes/'.Option::get('theme_site').'/plugins/amcharts/plugins/export/export.css' )}}

<!-- START Template Footer -->
    {{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/charts/amcharts.def.js' )}}
    {{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/charts/amcharts.report.js' )}}
    {{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/dateformat/jquery-dateFormat.min.js' )}}

</head>
<!--/ END Head -->
<!-- START Body -->
<body>
<!-- START Template Main -->
<section id="main" role="main">
    <div class="container-fluid">
        <div class="row">
            <div class="panel">
                <!-- panel body -->
                <div class="panel-body">
                    <div class="col-md-12">
                        <!-- START Template Main -->
                        <button class="btn btn-info report-download" disabled>Aguarde, estamos carregando o seu
                            Relatório...
                        </button>
                    </div>
                    <div class="col-md-12">
                        <!-- START Template Main -->
                        <div class="charts" style="height: 500px;width: 1900px; background-color: transparent"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">

    //Variáveis do layout do relatório
    //Report data
    var temp = '{{$REPORT_DATA['data_report']}}';
    var chartData = jQuery.parseJSON(temp);

    //Report text
    $REPORT_GLOBAL = {};

    $REPORT_GLOBAL.header = '{{$REPORT_PDF['header']}}';
    $REPORT_GLOBAL.title = '{{$REPORT_PDF['titulo']}}';
    $REPORT_GLOBAL.report = [];
    $REPORT_GLOBAL.report['nome'] = '{{$REPORT_PDF['nome']}}';
    $REPORT_GLOBAL.report['id'] = '{{$REPORT_PDF['id']}}';
    $REPORT_GLOBAL.report['sensor_nome'] = '{{$REPORT_PDF['sensor_nome']}}';
    $REPORT_GLOBAL.report['indicadores'] = '{{$REPORT_PDF['indicadores']}}';
    $REPORT_GLOBAL.report['periodo'] = '{{$REPORT_PDF['periodo']}}';
    $REPORT_GLOBAL.report['tipo'] = '{{$REPORT_PDF['tipo']}}';
    $REPORT_GLOBAL.report['intervalo'] = '{{$REPORT_PDF['intervalo']}}';
    temp = '{{json_encode($REPORT_PDF['logo_medisom'])}}';
    $REPORT_GLOBAL.report['logo_medisom'] = jQuery.parseJSON(temp);
    temp = '{{json_encode($REPORT_PDF['logo_cliente'])}}';
    $REPORT_GLOBAL.report['logo_cliente'] = jQuery.parseJSON(temp);
    $REPORT_GLOBAL.report['filename'] = '{{$REPORT_PDF['filename']}}';

    temp = '{{$REPORT_DATA['medias']}}';
    $REPORT_GLOBAL.report['medias'] = jQuery.parseJSON(temp); //Cálculo do máx, mín e média

    //Report options
    $REPORT_GLOBAL.report['categoryField'] = '{{$REPORT_OPTIONS['category_field']}}';
    temp = '{{$REPORT_OPTIONS['colors']}}';
    $REPORT_GLOBAL.report['colors'] = jQuery.parseJSON(temp);
    $REPORT_GLOBAL.report['graph'] = '{{$REPORT_OPTIONS['graph']}}';

    $_AMCHART_ = null;
    var _TEMPO_ = 1800;

    $TEXTO_BTN = [];
    $TEXTO_BTN[0] = 'Aguarde, seu Relatório está sendo criado...';
    $TEXTO_BTN[1] = 'Clique aqui para baixar o seu Relatório';

</script>
{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/charts/layout_relatorio.js' )}}

<!--/ END Template Footer -->
<script type="text/javascript">
    /*
     ** Create report
     */
    function createReport() {
        var pdf_layout = layout_relatorio; // global reference from layouts/layout_1.js

        // Capture the current state of the chart
        $_AMCHART_.export.capture({}, function () {
            // Export to PNG
            this.toPNG({
                multiplier: 2
                // Add image to the layout reference
            }, function (data) {

                pdf_layout.images["image_1"] = data;

                // Once all has been processed create the PDF
                // Build the table dynamically
                rows = new Array();
                i_row = 0;
                rows[i_row] = [{text: 'Indicador(es)', bold: true, fontSize: 12},
                    {text: 'Mínimo (dB)', bold: true, fontSize: 12},
                    {text: 'Máximo (dB)', bold: true, fontSize: 12},
                    {text: 'Média (dB)', bold: true, fontSize: 12}];

                medias = $REPORT_GLOBAL.report['medias'];
                colors = $REPORT_GLOBAL.report['colors'];

                var DateFormat = 'dd MMM yyyy HH:mm';
                switch ('{{strtolower($REPORT_PDF['tipo'])}}') {
                    case 'semanalmente':
                        DateFormat = 'ddd';
                        break;
                    case 'mensalmente':
                        DateFormat = 'dd MMM yyyy';
                        break;
                }

                $.each(medias, function (i, value) {
                    console.log(value.data_min);
                    i_row++;
                    rows[i_row] = [{text: value.base, bold: true, fontSize: 11, color: colors[i]},
                        {text: value.min + ' (' + $.format.date(value.data_min, DateFormat) + ')', fontSize: 10},
                        {text: value.max + ' (' + $.format.date(value.data_max, DateFormat) + ')', fontSize: 10},
                        {text: value.med.toString(), fontSize: 10}];
                });

                x = 1;
                findThatBody(pdf_layout).table.body = rows;

                // Save as single PDF and offer as download
                this.toPDF(pdf_layout, function (data) {
                    this.download(data, this.defaults.formats.PDF.mimeType, $REPORT_GLOBAL.report['filename']);
                    $('button.report-download').html($TEXTO_BTN[1]);
                    $('button.report-download').attr('disabled', false);
                });
            });
        });
    }

    $(document).ready(function () {
        $('button.report-download').click(function () {
//                $(this).html('<img alt="" src="'+ src_onload_gif + '" /> Aguarde');
            $(this).html($TEXTO_BTN[0]);
            $(this).attr('disabled', true);
            createReport();
        });
        $(".charts").each(function () {

            /*
             ** Create chart instance; merged two in one for simplicity
             */
            var GRAPH = $REPORT_GLOBAL.report['graph'];
            var CATEGORY_FIELD = $REPORT_GLOBAL.report['categoryField'];
            var color = $REPORT_GLOBAL.report['colors'];

//                    alert(CATEGORY_FIELD);return;
            var nomes = chartData[0].category.split(',');
            var bullet = ["round", "square", "triangleUp", "triangleDown", "bubble"];
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

            var e = this;
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

            $_AMCHART_ = AmCharts.makeChart(e, {
                "legend": {
                    "horizontalGap": 10,
                    "maxColumns": 1,
                    "position": "right",
                    "useGraphSettings": true,
                    "markerSize": 15
                },
                "autoResize": false,
                "type": "serial",
                "fontSize": 15,
                "theme": "light",
                "dataProvider": chartData,
                "valueAxes": [{
                    "position": "left",
                    "title": "Decibéis"
                }],
                "graphs": graph,
                "plotAreaFillAlphas": 0.1,
                "categoryField": CATEGORY_FIELD,
                "categoryAxis": CATEGORY_AXIS,
                "export": {
                    "enabled": true,
                    "libs": {
                        "path": "//amcharts.com/lib/3/plugins/export/libs/"
                    },
                    "menu": [] //
                }
            });

            $_AMCHART_.responsive = {
                "enabled": true,
                "rules": [
                    // at 400px wide, we hide legend
                    {
                        "maxWidth": 400,
                        "overrides": {
                            "legend": {
                                "enabled": true
                            }
                        }
                    },

                    // at 300px or less, we move value axis labels inside plot area
                    // the legend is still hidden because the above rule is still applicable
                    {
                        "maxWidth": 300,
                        "overrides": {
                            "valueAxes": {
                                "inside": true
                            }
                        }
                    },

                    // at 200 px we hide value axis labels altogether
                    {
                        "maxWidth": 200,
                        "overrides": {
                            "valueAxes": {
                                "labelsEnabled": false
                            }
                        }
                    }

                ]
            };
//
            $_AMCHART_.addListener("rendered", function (e) {
                // WAIT FOR FABRIC
                var interval = setInterval(function () {
                    if (window.fabric) {
                        clearTimeout(interval);
//                                createReport();
                        $('button.report-download').html($TEXTO_BTN[1]);
                        $('button.report-download').attr('disabled', false);
                    }
                }, _TEMPO_);
            });


        });
    });

</script>

</body>
<!--/ END Body -->
</html>