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

                                <th width="5%">Img</th>
                                <th>Nome</th>
                                <th>Site</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if( count($posts) > 0 )
                                @foreach($posts as $post)
                                    <tr class="@if($post->status == 'inactive') danger @endif">

                                        <td class="text-center">
                                            @if($post->postmeta('image_default'))
                                                <div class="media-object">
                                                    <img src="{{ asset('public/uploads/'. $post->postmeta($post->post_id,'image_default') ) }}"
                                                         alt="" class="">
                                                </div>
                                            @endif
                                        </td>
                                        <td>{{$post->title}}</td>
                                        <td>{{$post->postmeta($post->post_id,'site')}}</td>
                                        <td>{{$post->status}}</td>

                                        <td class="text-right">
                                            <a href="{{URL::route('admin.client',array('post_id'=>$post->post_id))}}"><i
                                                        class="fa fa-edit"></i>Editar</a>
                                            <a href="{{URL::route('admin.client',array('post_id'=>$post->post_id,'action'=>$post->status))}}">
                                                @if($post->status == 'publish') <i class="fa fa-eye-slash"></i>
                                                Desativar @else <i class="fa fa-eye"></i>Ativar @endif
                                            </a>
                                            <a href="{{URL::route('admin.client',array('post_id'=>$post->post_id,'action'=>'delete'))}}"
                                               class="text-danger"><i class="fa fa-remove"></i>Excluir</a>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="warning">
                                    <td class="text-center" colspan="4">Nenhum cliente ainda. <a
                                                href="{{URL::route('admin.client',array('post_id'=>0,'action'=>'novo'))}}">Clique
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