<!DOCTYPE html>
<html class="backend">
<!-- START Head -->
<head>
    <!-- START META SECTION -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dashboard | Medisom</title>
    <meta name="description" content="Medisom">
    {{--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">--}}
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">


    @include('admin.parts.head')

    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script>
        var global_data = "{{\Carbon\Carbon::now()->subMinute()->format('YmdHis')}}";
        var json_url = "{{route('jsonp')}}";
        var gauge_data = [];
        var gauge_options = {};
        google.load('visualization', '1', {packages: ['gauge']});
        $(document).ready(function () {
            gauge_data = google.visualization.arrayToDataTable([
                ['Label', 'Value'],
                ['IPA (%)', 0]
            ]);
            gauge_options = {
                width: 150, height: 150,
                max: 100, min: 0,
                animation: {duration: 500},
                redFrom: 20, redTo: 100,
                yellowFrom: 10, yellowTo: 20,
                greenFrom: 0, greenTo: 10,
                minorTicks: 10,
                majorTicks: ["0", , 20, , 40, , 60, , 80, , 100]
            };
            $.ajaxSetup({cache: false});
        });
        // function to update data automatically
        function createGauge(sensor_id) {
            charts[sensor_id] = new google.visualization.Gauge(document.getElementById('visualization-' + sensor_id));
            charts[sensor_id].draw(gauge_data, gauge_options);
            updateGauge(sensor_id);
        }
        function drawGauge(sensor_id, valor) {
            gauge_data.setValue(0, 1, valor);
            charts[sensor_id].draw(gauge_data, gauge_options);
        }
        function updateGauge(sensor_id) {
            $.getJSON(json_url + '/SensorLog/charts/?type=add&base=ipaporcento' +
                '&post_id=' + sensor_id + '&start=' + global_data, function (result) {
//                console.log(json_url + '/SensorLog/charts/?type=add&base=ipaporcento' +
//                    '&post_id=' + sensor_id +'&start=' + global_data);
//                console.log(result);
                if (result.status) {
                    var valor = result.response[0].value0;
                    var datahora = result.response[0].date.replace(/\-/g, '');
                    datahora = datahora.replace(/\:/g, '');
                    global_data = datahora.replace(' ', '');
                    drawGauge(sensor_id, valor);
                }
            });
        }
    </script>

</head>
<!--/ END Head -->

<!-- START Body -->
<body>
<!-- START Template Header -->
@include('admin.parts.navbar')
<!--/ END  START Template Header -->

<!--Template Sidebar (Left) -->
@include('admin.parts.sidebar')
<!--/ END Template Sidebar (Left) -->

<!-- START Template Main -->
<!-- START Template Main -->
<section id="main" role="main">
    <!-- START Template Container -->
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header page-header-block">
            <div class="page-header-section">
                <h4 class="title semibold">Dashboard </h4>
            </div>
        </div>
        <!-- Page Header -->
        <script>
            var charts = {};
        </script>
        @if(isset($sensores) && count($sensores)>0)
            @foreach($sensores as $sensor)
                <div class="section-header">
                    <div class="row">
                        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 ">
                            <h5 class="semibold title mb15">
                                {{$sensor->title}}
                                - {{ Post::find($sensor->post_id)->author($sensor->post_author)->name }}
                            </h5>
                        </div>
                        <div class="col-lg-offset-4 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                            <form action="{{route('admin.sensores.dashboard',$sensor->post_id)}}"
                                  method="post" id="form-sensors" name="form-sensors">
                                {{Form::token()}}
                                <select id="visualization_dash" name="visualization_dash" class="form-control"
                                        placeholder="Visualizar por...">
                                    <option value="h" @if(!strcmp($sensor->visualization_dash,"h")) selected @endif>
                                        Hoje
                                    </option>
                                    <option value="u1" @if(!strcmp($sensor->visualization_dash,"u1")) selected @endif>
                                        Última hora
                                    </option>
                                    <option value="u6" @if(!strcmp($sensor->visualization_dash,"u6")) selected @endif>
                                        Últimas 6 horas
                                    </option>
                                    <option value="u12" @if(!strcmp($sensor->visualization_dash,"u12")) selected @endif>
                                        Últimas 12 horas
                                    </option>
                                    <option value="u24" @if(!strcmp($sensor->visualization_dash,"u24")) selected @endif>
                                        Últimas 24 horas
                                    </option>
                                </select>
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        @if(count($sensor->measures)>1)
                            @foreach($sensor->measures as $ind_measure => $measures)
                                <?php $Measures_str = $sensor->measures_str[$ind_measure]['impressao'];?>
                                @if($measures=='ipaporcento')
                                    <?php $escala_str = $sensor->measures_str[$ind_measure]['escala'][0];?>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            google.setOnLoadCallback(createGauge('{{$sensor->post_id}}'));
                                            setInterval('updateGauge("{{$sensor->post_id}}")', 60000);
                                        });
                                    </script>
                                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 graph"
                                         id="widget-{{$sensor->post_id}}">
                                        <div class="widget panel panel-default">
                                            <div class="panel-head">
                                                <div class="widget-tools">
                                                    <a href="{{URL::route('admin.report',array('post_id'=>$sensor->post_id,'type'=>$measures))}}"
                                                       class="pull-right">
                                                        Ver Detalhes
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="panel-body">
                                                <div class="clearfix">
                                                    <p class="pull-left semibold">{{$Measures_str}} ({{$escala_str}}
                                                        )</p>
                                                    <p class="pull-right semibold">
                                                    </p>
                                                </div>
                                                <div class="text-center mt15 mb15">
                                                    <div id="visualization-{{$sensor->post_id}}"
                                                         style="height: 150px;background-color: transparent"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 graph"
                                         id="widget-{{$sensor->post_id}}">
                                        <!-- START Widget Panel -->
                                        <div class="widget panel panel-default">
                                            <div class="panel-head">
                                                <div class="widget-tools">
                                                    <a href="{{URL::route('admin.report',array('post_id'=>$sensor->post_id,'type'=>$measures))}}"
                                                       class="pull-right">
                                                        Ver Detalhes
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- panel body -->
                                            <div class="panel-body">
                                                <div class="clearfix">
                                                    <p class="pull-left semibold">{{$Measures_str}}</p>
                                                    <p class="pull-right semibold">
                                                    </p>
                                                </div>
                                                <div class="text-center mt15 mb15">
                                                    <div id="chart-{{$sensor->post_id}}-{{$measures}}"
                                                         class="charts"
                                                         data-type="widget"
                                                         data-last="{{\Carbon\Carbon::now()->format('YmdHis')}}"
                                                         data-graphid="{{$measures}}"
                                                         data-names="{{$measures}}"
                                                         data-title="{{$measures}}"
                                                         data-postid="{{$sensor->post_id}}"
                                                         style="height: 150px;background-color: transparent"></div>
                                                </div>
                                                <div class="clearfix ">
                                                    <table border="0" class="table table-hover media hide">
                                                        <thead>
                                                        <tr>
                                                            <th>
                                                                <small>Indicador</small>
                                                            </th>
                                                            <th><i class="ico-arrow-down5"></i>
                                                                <small>Mínimo</small>
                                                            </th>
                                                            <th><i class="ico-arrow-up5"></i>
                                                                <small>Máximo</small>
                                                            </th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($sensor->measures_str[$ind_measure]['impressao_individual'] as $i => $INDICADOR)
                                                            <?php $indicador = [
                                                                    'indice' => $sensor->measures_str[$ind_measure]['indicadores'][$i],
                                                                    'escala' => $sensor->measures_str[$ind_measure]['escala'][$i]
                                                            ];
                                                            ?>
                                                            <tr id="{{$indicador['indice']}}" class="hide">
                                                                <td>
                                                                    <strong>
                                                                        <small style="color:{{$Colors[$i]}}">{{$INDICADOR}}
                                                                            ({{$indicador['escala']}})
                                                                        </small>
                                                                    </strong></td>
                                                                <td>
                                                                    <strong class="semibold min"
                                                                            title="Mínima"></strong>
                                                                </td>
                                                                <td>
                                                                    <strong class="semibold nm max"
                                                                            title="Máxima"></strong>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                            <!--/ panel body -->
                                        </div>
                                        <!--/ END Widget Panel -->
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <?php
                            $measures = $sensor->measures[0];
                            $Measures_str = $sensor->measures_str['impressao'];
                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 graph" id="widget-{{$sensor->post_id}}">
                                <!-- START Widget Panel -->
                                <div class="widget panel panel-default ">
                                    <div class="panel-head">
                                        <div class="widget-tools">
                                            <a href="{{URL::route('admin.report',array('post_id'=>$sensor->post_id,'type'=>$measures))}}"
                                               class="pull-right">
                                                Ver Detalhes
                                            </a>
                                        </div>
                                    </div>
                                    <!-- panel body -->
                                    <div class="panel-body">
                                        <div class="clearfix">
                                            <p class="pull-left semibold">{{$Measures_str}}</p>
                                            <p class="pull-right semibold">
                                            </p>
                                        </div>
                                        <div class="text-center mt15 mb15">
                                            <div id="chart-{{$sensor->post_id}}-{{$measures}}"
                                                 class="charts"
                                                 data-type="widget"
                                                 data-last="{{\Carbon\Carbon::now()->format('YmdHis')}}"
                                                 data-graphid="{{$measures}}"
                                                 data-names="{{$measures}}"
                                                 data-title="{{$measures}}"
                                                 data-postid="{{$sensor->post_id}}"
                                                 style="height: 150px;background-color: transparent"></div>
                                        </div>

                                        <div class="clearfix ">
                                            <table border="0" class="table table-hover media hide">
                                                <thead>
                                                <tr>
                                                    <th>
                                                        <small>Indicador</small>
                                                    </th>
                                                    <th><i class="ico-arrow-down5"></i>
                                                        <small>Mínimo</small>
                                                    </th>
                                                    <th><i class="ico-arrow-up5"></i>
                                                        <small>Máximo</small>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($sensor->measures_str['impressao_individual'] as $i => $INDICADOR)
                                                    <?php $indicador = [
                                                            'indice' => $sensor->measures_str['indicadores'][$i],
                                                            'escala' => $sensor->measures_str['escala'][$i]
                                                    ];
                                                    ?>
                                                    <tr id="{{$indicador['indice']}}" class="hide">
                                                        <td>
                                                            <strong>
                                                                <small style="color:{{$Colors[$i]}}">{{$INDICADOR}}
                                                                    ({{$indicador['escala']}})
                                                                </small>
                                                            </strong></td>
                                                        <td>
                                                            <strong class="semibold min" title="Mínima"></strong>
                                                        </td>
                                                        <td>
                                                            <strong class="semibold nm max" title="Máxima"></strong>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                    <!--/ panel body -->
                                </div>
                                <!--/ END Widget Panel -->
                            </div>
                        @endif
                    </div>
                    <hr>
                </div>
            @endforeach
        @endif

    </div>
    <!--/ END Template Container -->

    <!-- START To Top Scroller -->
    <a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut"
       data-offset="50%"><i class="ico-angle-up"></i></a>
    <!--/ END To Top Scroller -->
</section>
<!--/ END Template Main -->
@include('admin.parts.modal')
<!-- START Template Footer -->
@include('admin.parts.footer')
<!--/ END Template Footer -->
<script>
    $(document).ready(function () {
        $('select#visualization_dash').change(function () {
            $(this).parent('form').submit();
        });
    });
</script>
</body>
<!--/ END Body -->
</html>