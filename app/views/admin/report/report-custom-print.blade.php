<?php

$REPORT_OPTIONS = $REPORT['OPTIONS'];
$REPORT_PDF = $REPORT['PDF'];
$REPORT_DATA = $REPORT['DATA'];
//echo "<pre>";
//print_r($REPORT_DATA['data_report']);
//echo "</pre>";
//exit;
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
    <style>
        .btn-huge {
            padding-top: 20px;
            padding-bottom: 20px;
        }
    </style>
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
        $REPORT_GLOBAL.amchart = {};
        $REPORT_GLOBAL.report['nome'] = '{{$REPORT_PDF['nome']}}';
        $REPORT_GLOBAL.report['id'] = '{{$REPORT_PDF['id']}}';
        $REPORT_GLOBAL.report['sensor_nome'] = '{{$REPORT_PDF['sensor_nome']}}';
        $REPORT_GLOBAL.report['indicadores'] = '{{$REPORT_PDF['indicadores']}}';
        $REPORT_GLOBAL.report['author'] = '{{$REPORT_PDF['author']}}';
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

        var _TEMPO_ = 1800;

        console.log($REPORT_GLOBAL);
        $TEXTO_BTN = [];
        $TEXTO_BTN[0] = 'Aguarde, seu Relatório está sendo gerado...';
        $TEXTO_BTN[1] = 'Clique aqui para baixar o seu Relatório';

    </script>
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
                        <div class="container">
                            <!-- Modal -->
                            <div class="modal fade" id="myModal" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Baixar Relatório</h4>
                                        </div>
                                        <div class="modal-body text-center">
                                            <button class="btn btn-info btn-lg btn-huge report-download" disabled>
                                                Aguarde, estamos carregando o seuRelatório ...
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/charts/layout_relatorio.js' )}}
<!--/ END Template Footer -->
<script type="text/javascript">
    /*
     ** Create report
     */
    function reset_button() {
        $('button.report-download').html($TEXTO_BTN[1]);
        $('button.report-download').attr('disabled', false);
    }

    $(document).ready(function () {
        $('#myModal').modal('show');
        $("#myModal").on("hidden.bs.modal", function () {
            $('#myModal').modal('show');
        });
    });
    $(document).ready(function () {
        $('button.report-download').click(function () {
            $(this).html($TEXTO_BTN[0]);
            $(this).attr('disabled', true);
            createReport($REPORT_GLOBAL, 'reset_button');
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

            $REPORT_GLOBAL.amchart = AmCharts.makeChart(e, {
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
            $REPORT_GLOBAL.amchart.responsive = {
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
            $REPORT_GLOBAL.amchart.addListener("rendered", function (e) {
                // WAIT FOR FABRIC
                var interval = setInterval(function () {
                    if (window.fabric) {
                        clearTimeout(interval);
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