<!DOCTYPE html>
<html class="backend">
<!-- START Head -->
<head>
    <!-- START META SECTION -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Relatório | Medisom</title>
    <meta name="description" content="Medisom">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    @include('admin.parts.head')
    {{--{{ HTML::style('public/themes/'.Option::get('theme_site').'/plugins/amcharts/style.css' )}}--}}
    {{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/amcharts_v3.21.2/amcharts/amcharts.js' )}}
    {{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/amcharts_v3.21.2/amcharts/serial.js' )}}
    {{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/amcharts_v3.21.2/amcharts/plugins/export/export.js' )}}
    {{ HTML::style('public/themes/'.Option::get('theme_site').'/plugins/amcharts_v3.21.2/amcharts/plugins/export/export.css' )}}

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
<section id="main" role="main">
    <!-- START Template Container -->
    <div class="container-fluid">
        <!-- Page Header -->
        <div class="page-header page-header-block">
            <div class="page-header-section">
                <h4 class="title semibold">Dashboard - Detalhes</h4>
            </div>

        </div>
        <!-- Page Header -->
        <div class="section-header">
            <h5 class="semibold title mb15">{{$sensor->title}}</h5>
        </div>
        <div class="row">
            <div class="col-lg-12" id="widget-{{$sensor->post_id}}">
                <!-- START Widget Panel -->
                <div class="widget panel bgcolor-default">
                    <!-- panel body -->

                    <div class="panel-body">
                        <div class="clearfix">
                            <p class="pull-left semibold">{{$Graficos['impressao']}}</p>
                            <p class="pull-left ml15">
                                <strong class="ml15 mr15">Filtrar</strong>
                                De
                                <input type="text" name="start_period" data-type="datepicker">
                                Até
                                <input type="text" name="end_period" data-type="datepicker">
                            </p>
                            <p class="pull-left ml15 action-filter ">
                                <button type="button">Filtrar</button>
                            </p>
                        </div>
                        <div class="text-center mt15 mb15">
                            <div id="chart-{{$sensor->post_id}}-{{implode(',',$Graficos['indicadores'])}}"
                                 class="charts"
                                 data-graphid="{{implode(',',$Graficos['indicadores'])}}"
                                 data-type="full"
                                 data-names="{{$Graficos['indice']}}"
                                 data-escalas="{{implode(',',$Graficos['escala'])}}"
                                 data-title="{{$Graficos['impressao']}}"
                                 data-postid="{{$sensor->post_id}}"
                                 style="height: 500px;background-color: transparent"></div>
                        </div>
                        <table border="0" class="table table-hover">
                            <thead>
                            <tr>
                                <th>Sensor</th>
                                <th><i class="ico-arrow-down5"></i> Mínimo</th>
                                <th><i class="ico-arrow-up5"></i> Máximo</th>
                                <th><i class="ico-minus"></i> Média</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($Graficos['indicadores'] as $media)
                                <tr class="media">
                                    <td>
                                        <p class="semibold sensor-{{$media}}"></p>
                                    </td>
                                    <td>
                                        <p class="pull-left semibold nm min-{{$media}}" title="Mínima"></p>
                                    </td>
                                    <td>
                                        <p class="pull-left semibold nm max-{{$media}}" title="Máxima"></p>
                                    </td>
                                    <td>
                                        <p class="pull-left semibold nm mlog-{{$media}}" title="Média"></p>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--/ panel body -->
                </div>
                <!--/ END Widget Panel -->
            </div>
        </div>
        <hr>
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

{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/charts/amcharts.def.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/charts/amcharts.report.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/charts/amcharts.details.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/dateformat/jquery-dateFormat.min.js' )}}
@include('admin.parts.footer')
<!--/ END Template Footer -->
</body>
<!--/ END Body -->
</html>