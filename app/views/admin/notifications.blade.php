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
                <div class="panel panel-primary">
                    <!-- panel body with collapse capabale -->
                    <div class="table-responsive panel-collapse pull out">
                        <table class="table table-bordered table-hover" id="table1">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Sensor</th>
                                <th>Título</th>
                                <th>Mensagem</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if( count($notifications) > 0 )
                                @foreach($notifications as $notification)
                                    <tr class="{{$notification->type}}">
                                        <td>{{$notification->id}}</td>
                                        <td>{{$notification->sensor->title}}</td>
                                        <td>{{$notification->title}}</td>
                                        <td>{{$notification->message}}</td>
                                        <td>{{$notification->getPretyDateTime()}}</td>
                                        <td>{{$notification->getStatusText()}}</td>
                                        <td>
                                            <a href="{{route('admin.notifications.remove',$notification->id)}}">Remover</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="warning">
                                    <td class="text-center" colspan="7">Você não possui nenhuma notificação.</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <!--/ panel body with collapse capabale -->
                </div>
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