<?php $dias = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'];?>
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

    @include('admin.parts.head')
    {{--{{ HTML::style('public/themes/'.Option::get('theme_site').'/plugins/amcharts/style.css' )}}--}}
    {{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/amcharts_v3.21.2/amcharts/amcharts.js' )}}
    {{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/amcharts_v3.21.2/amcharts/serial.js' )}}
    {{--{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/amcharts/amstock.js' )}}--}}
    {{--{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/amcharts/pie.js' )}}--}}
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
<!-- START Template Main -->
<section id="main" role="main">
    <!-- START Template Container -->
    <div class="container-fluid">
        <!-- Page Header -->
    @include('admin.parts.page-header')
    <!-- Page Header -->

        <div class="row">
            <div class="col-md-12">
                <!-- START panel -->
                <!-- panel heading/header -->
                <!--/ panel heading/header -->
                @if($action == 'novo')
                    <div class="col-xs-12 col-md-12">
                        <form action="{{URL::route('admin.report-custom',array('action'=>'novo','post_id'=>0))}}"
                              name="form-reports"
                              method="post" id="form-reports">
                            @include('admin.report.form')
                        </form>
                    </div>
                @elseif($action == 'editar')
                    <?php
                    $report_postmeta = (object)Postmeta::get_transform_report($reports->post_id);
                    $report = (object)array_merge((array)$reports, (array)$report_postmeta);
                    $indicadores = json_decode($report->content);
                    ?>
                    <div class="col-xs-12 col-md-12">
                        <form action="{{URL::route('admin.report-custom',array('action'=>'editar','post_id'=>$post_id))}}"
                              name="form-reports" method="post" id="form-reports">
                            @include('admin.report.form')
                        </form>
                    </div>
                @elseif($action == 'manual')
                    <div class="col-xs-12 col-md-12">
                        @include('admin.report.form-manual')
                    </div>
                @else
                    @include('admin.report.index')
                @endif
            </div>
        </div>
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
</body>
<!--/ END Body -->
</html>