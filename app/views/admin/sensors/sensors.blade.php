<!DOCTYPE html>
<html class="backend">
<!-- START Head -->
<head>
    <!-- START META SECTION -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$title}} | Medisom</title>
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
    @include('admin.parts.page-header')
    <!-- Page Header -->

        <div class="row">
            <div class="col-md-12">
                <!-- START panel -->
                <div class="panel panel-primary">
                    <!-- panel body with collapse capabale -->
                    <div class="table-responsive panel-collapse pull out">
                        <table class="table table-bordered table-hover" id="table1">
                            <thead>
                            <tr>
                                <th width="3%">ID</th>
                                <th width="5%">Status</th>
                                <th>Nome</th>
                                <th>Indicadores</th>
                                @if ( Auth::user()->group_id == 1)
                                    <th>Usuário</th>
                                @endif
                                <th>Última atividade</th>
                                <th>Alertas emitidos hoje</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if( count($sensors) > 0 )
                                @foreach($sensors as $sensor)
                                    <?php
                                    $indicadores_impressao = NULL;
                                    if (count($sensor->measures) > 1) {
                                        foreach ($sensor->measures_str as $measure) {
                                            $indicadores_impressao[] = $measure["impressao"];
                                        }
                                        $indicadores_impressao = implode('; ', $indicadores_impressao);
                                    } else {
                                        $indicadores_impressao = $sensor->measures_str["impressao"];
                                    }
                                    ?>
                                    <tr>
                                        <td>{{$sensor->post_id}}</td>
                                        @if($sensor->status=='publish')
                                            <td>
                                                <small class="btn btn-xs btn-success">Ativo</small>
                                            </td>
                                        @else
                                            <td>
                                                <small class="btn btn-xs btn-danger">Inativo</small>
                                            </td>
                                        @endif
                                        <td>{{$sensor->title}}</td>
                                        <td>{{$indicadores_impressao}}</td>
                                        @if ( Auth::user()->group_id == 1)
                                            <td>{{$sensor->name}}</td>
                                        @endif
                                        <td class="text-danger">{{$sensor->last_activity}}</td>
                                        <td class="text-danger">{{$sensor->alert_num}}</td>
                                        <td class="text-left">
                                            <?php $publish = ($sensor->status == 'publish') ? 1 : 0;?>

                                            @if(User::allowed('route-admin.sensores.edit'))
                                                <a class="btn btn-info btn-xs"
                                                   href="{{route('admin.sensores.show',$sensor->post_id)}}"><i
                                                            class="fa fa-edit"></i> Editar</a>
                                            @endif
                                            <a class="btn btn-{{($publish)? 'default':'success'}} btn-xs"
                                               href="{{route('admin.sensores.status',$sensor->post_id)}}">
                                                <i class="fa fa-{{($publish)? 'eye-slash':'eye'}} "></i>{{($publish)? ' Desativar':' Ativar'}}
                                            </a>
                                            @if(User::allowed('route-admin.sensores.destroy'))
                                                <a class="btn btn-danger btn-xs alert-confirm"
                                                   data-href="{{route('admin.sensores.destroy',$sensor->post_id)}}"
                                                   data-title="sensor"><i class="ico ico-trash"></i>Excluir</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="warning">
                                    <td class="text-center" colspan="10">Nenhum sensor ainda. <a
                                                href="{{route('admin.sensores.create')}}">Clique
                                            aqui</a> para criar um novo
                                    </td>
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

<!-- START Template Footer -->
@include('admin.parts.footer')
<!--/ END Template Footer -->
</body>
<!--/ END Body -->
</html>