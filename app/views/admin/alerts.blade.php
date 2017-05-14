<?php $dias = ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado']; ?>
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
            <div class="col-md-12 col-xs-12">
                <!-- START panel -->
                <!-- panel heading/header -->
                <!--/ panel heading/header -->
                @if($action == 'novo')
                    <form action="{{route('admin.alertas.store')}}" name="form-reports" method="post" id="form-reports"
                          data-parsley-validate>
                        @include('admin.alerts.form')
                    </form>
                @elseif($action == 'editar')
                    @if($Alert->sensor->status == 'publish')
                        <form action="{{route('admin.alertas.update',$Alert->alert_id)}}" name="form-reports"
                              method="post"
                              id="form-alerts" data-parsley-validate>
                            <input type="hidden" name="_method" value="PATCH">
                            @include('admin.alerts.form')
                        </form>
                    @else
                        Sensor inativo! Ative o sensor para editar o alerta.
                    @endif
                @elseif($action == 'logs')
                    @include('admin.alerts.logs')
                @else
                    {{--MOSTRAR TODOS--}}
                    @include('admin.alerts.index')
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