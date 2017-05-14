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
                <h4 class="title semibold">Dashboard - Detalhes</h4>
            </div>

        </div>
        <!-- Page Header -->

        @if(isset($sensores) && count($sensores)>0)
            @foreach($sensores as $sensor)
                <?php $graficos = json_decode($sensor->content); ?>

                <div class="section-header">
                    <h5 class="semibold title mb15">{{$sensor->title}}</h5>
                </div>
                <div class="row">

                    @foreach($graficos as $grafico)
                        @if(strtolower(str_replace(array(' '),array('_'),$grafico)) == $graph)
                            <div class="col-lg-12" id="widget-{{$sensor->post_id}}">
                                <!-- START Widget Panel -->
                                <div class="widget panel bgcolor-default">
                                    <!-- panel body -->
                                    <div class="panel-body">
                                        <div class="clearfix">
                                            <p class="pull-left semibold">{{str_replace(array(',','Time Leq','Alarm Set'),array(' x ','Tempo de Leq','Alarme Set'),$grafico)}}</p>
                                            <p class="pull-left ml15">
                                                <strong class="ml15 mr15">Filtrar</strong> De <input type="text"
                                                                                                     name="start_period"
                                                                                                     data-type="datepicker">
                                                Até <input type="text" name="end_period" data-type="datepicker">
                                            </p>
                                            <p class="pull-left ml15 action-filter ">
                                                <button type="button">Filtrar</button>
                                            </p>
                                        </div>
                                        <div class="text-center mt15 mb15">
                                            <div id="chart-{{$sensor->post_id}}-{{strtolower(str_replace(array(' ',','),array('_',''),$grafico))}}"
                                                 class="charts"
                                                 data-graphid="{{strtolower(str_replace(array(' ',','),array('_',''),$grafico))}}"
                                                 data-type="full"
                                                 data-names="{{strtolower(str_replace(array(' '),array('_'),$grafico))}}"
                                                 data-title="{{str_replace(array(',','Time Leq','Alarm Set'),array(' x ','Tempo de Leq','Alarme Set'),$grafico)}}"
                                                 data-postid="{{$sensor->post_id}}"
                                                 style="height: 500px;background-color: transparent"></div>
                                        </div>
                                        <?php $medias = explode(',', $grafico); ?>
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
                                            @foreach($medias as $media)
                                                <?php $nome = strtolower(str_replace(array(' ', ','), array('_', ''), $media)); ?>
                                                <tr class="media">
                                                    <td>
                                                        <p class="semibold sensor-{{$nome}}"></p>
                                                    </td>
                                                    <td>
                                                        <p class="pull-left semibold nm min-{{$nome}}"
                                                           title="Mínima"></p>
                                                    </td>
                                                    <td>
                                                        <p class="pull-left semibold nm max-{{$nome}}"
                                                           title="Máxima"></p>
                                                    </td>
                                                    <td>
                                                        <p class="pull-left semibold nm mlog-{{$nome}}"
                                                           title="Média"></p>
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
                        @endif
                    @endforeach
                </div>
                <hr>
        @endforeach
    @endif

    <!--
                <div class="row">
                    <div class="col-md-12">
                        
                        <div id="chart-31" class="charts" data-names="laeq,lceq" data-title="Laeq x Lceq" data-postid="31"></div>

                    </div>
                </div>
                -->
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