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

    </div>
    <!--/ END Template Container -->
    @if(isset($sensores) && count($sensores)>0)
        @foreach($sensores as $sensor)
            <div class="section-header">
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 ">
                    <h5 class="semibold title mb15">
                        {{$sensor->title}} - {{$sensor->autor->name}}
                    </h5>
                </div>
            </div>
            <div class="section-body">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    @foreach($sensor->dashboards as $dashboard)
                        @foreach($dashboard->decodeMetaKey() as $measure)
                            @if($measure=='ipaporcento')
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
                                                <a href="{{URL::route('admin.report',array('post_id'=>$sensor->post_id,'type'=>$indicator))}}"
                                                   class="pull-right">
                                                    Ver Detalhes
                                                </a>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <div class="clearfix">
                                                <p class="pull-left semibold">{{$indicator}} ({{$indicator}}
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
                                <?php $measures_str = implode(',', $measure->values);?>
                                <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12 graph"
                                     id="widget-{{$sensor->post_id}}">
                                    <!-- START Widget Panel -->
                                    <div class="widget panel panel-default">
                                        <div class="panel-head">
                                            <div class="widget-tools">
                                                <a href="{{URL::route('admin.report',array('post_id'=>$sensor->post_id,'type'=>$measures_str))}}"
                                                   class="pull-right">
                                                    Ver Detalhes
                                                </a>
                                            </div>
                                        </div>
                                        <!-- panel body -->
                                        <div class="panel-body">
                                            <div class="clearfix">
                                                <p class="pull-left semibold">{{$measures_str}}</p>
                                                <p class="pull-right semibold"></p>
                                            </div>
                                            <div class="text-center mt15 mb15">
                                                <div id="chart-{{$sensor->post_id}}-{{$measures_str}}"
                                                     class="charts"
                                                     data-type="widget"
                                                     data-last="{{\Carbon\Carbon::now()->format('YmdHis')}}"
                                                     data-graphid="{{$measures_str}}"
                                                     data-names="{{$measures_str}}"
                                                     data-title="{{$measures_str}}"
                                                     data-postid="{{$sensor->post_id}}"
                                                     style="height: 150px;background-color: transparent"></div>
                                            </div>
                                            <div class="clearfix "></div>
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
                                                @foreach($measure->values as $i => $measure)
                                                    <?php
                                                    $indicador = [
                                                        'indice' => $measure,
                                                        'escala' => $measure
                                                    ];
                                                    ?>
                                                    <tr id="{{$indicador['indice']}}" class="hide">
                                                        <td>
                                                            <strong>
                                                                <small style="color:{{$Colors[$i]}}">{{$measure}}
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
                                    <!--/ END Widget Panel -->
                                </div>
                            @endif
                        @endforeach
                    @endforeach
                </div>
            </div>
    @endforeach
@endif

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
</body>
<!--/ END Body -->
</html>