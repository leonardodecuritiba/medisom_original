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
                    <!-- panel heading/header -->

                    <!--/ panel heading/header -->


                    <!-- panel body with collapse capabale -->
                    <div class="table-responsive panel-collapse pull out">
                        <table class="table table-bordered table-hover" id="table1">
                            <thead>
                            <tr>

                                <th width="5%">Avatar</th>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                                @if ( Auth::user()->group_id == 1)
                                    <th>Tipo</th>
                                @endif
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if( count($users) > 0 )
                                @foreach($users as $user)
                                    <tr class="@if($user->active == 'inactive') danger @endif">

                                        <td class="text-center">
                                            @if(User::find($user->user_id)->usermeta('avatar'))
                                                <div class="media-object">
                                                    <img src="{{ (Auth::user()->usermeta(Auth::user()->user_id,'avatar'))? asset('public/uploads/'.Auth::user()->usermeta(Auth::user()->user_id,'avatar')) : asset('public/uploads/avatar.png') }}"
                                                         alt="" class="">
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{$user->user_id}}</td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        @if ( Auth::user()->group_id == 1)
                                            <td>{{$user->description}}</td>
                                        @endif
                                        <td>{{($user->active)?'Ativo':'Inativo'}}</td>

                                        <td class="text-right">

                                            <a href="{{URL::route('admin.users',array('user_id'=>$user->user_id))}}"><i
                                                        class="fa fa-edit"></i>Editar</a>
                                            <a href="{{URL::route('admin.users',array('user_id'=>$user->user_id,'action'=>($user->active)?'publish':'inactive'))}}">
                                                @if($user->active) <i class="fa fa-eye-slash"></i>Desativar @else <i
                                                        class="fa fa-eye"></i>Ativar @endif
                                            </a>
                                            <a href="{{URL::route('admin.users',array('user_id'=>$user->user_id,'action'=>'delete'))}}"
                                               class="text-danger"><i class="fa fa-remove"></i>Excluir</a>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="warning">
                                    <td class="text-center" colspan="4">Nenhum usuário ainda. <a
                                                href="{{URL::route('admin.users',array('user_id'=>0,'action'=>'novo'))}}">Clique
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