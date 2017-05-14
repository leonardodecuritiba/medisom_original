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
                                <th>Nome</th>
                                <th>Tipo</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @if( count($terms) > 0 )
                                @foreach($terms as $term)
                                    <tr class="">

                                        <td>{{$term->name}}</td>
                                        <td>{{$term->taxonomy}}</td>

                                        <td class="text-right">
                                            <a href="{{URL::route('admin.terms',array('term_id'=>$term->term_id))}}"><i
                                                        class="fa fa-edit"></i>Editar</a>

                                            <a href="{{URL::route('admin.terms',array('term_id'=>$term->term_id,'taxonomy'=>'blog','action'=>'delete'))}}"
                                               class="text-danger"><i class="fa fa-remove"></i>Excluir</a>

                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="warning">
                                    <td class="text-center" colspan="4">Nenhuma categoria ainda. <a
                                                href="{{URL::route('admin.terms',array('term_id'=>0,'taxonomy'=>'blog','action'=>'novo'))}}">Clique
                                            aqui</a> para criar uma nova
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