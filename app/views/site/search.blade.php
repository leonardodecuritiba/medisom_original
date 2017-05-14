<!DOCTYPE html>
<html class="frontend">
<!-- START Head -->
<head>
    <!-- START META SECTION -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$title}} | Medisom</title>
    <meta name="description" content="Medisom">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">


    @include('site.parts.head')

</head>
<!--/ END Head -->

<!-- START Body -->
<body>
<!-- START Template Header -->
@include('site.parts.navbar')

<!-- START Template Main -->
<section id="main" role="main">
    <!-- START page header -->
    <section class="page-header page-header-block nm">
        <!-- pattern -->
        <div class="pattern pattern9"></div>
        <!--/ pattern -->
        <div class="container pt15 pb15">
            <div class="page-header-section">
                <h4 class="title">{{$title}}</h4>
            </div>
            <div class="page-header-section">
                <!-- Toolbar -->
                <div class="toolbar">
                    <ol class="breadcrumb breadcrumb-transparent nm">
                        <li><a href="javascript:void(0);">Inicio</a></li>
                        <li class="active">{{$title}}</li>
                    </ol>
                </div>
                <!--/ Toolbar -->
            </div>
        </div>
    </section>
    <div class="clearfix"></div>
    <!--/ END page header -->

    <!-- START Blog Content -->
    <section class="section bgcolor-white">
        <div class="container">
            <!-- START Row -->
            <div class="row" id="">
                <div class="panel">
                    <div class="panel-body">
                        <h5 class="text-primary semibold mt0">Resulado da busca por: <strong>{{$search}}</strong></h5>
                        <div class="list-group">
                            @if(count($posts)>0)
                                @foreach($posts as $post)
                                    @if($post->title != '')
                                        <a href="{{$post->url}}" class="list-group-item ">

                                            <h4 class="list-group-item-heading">{{$post->title}}</h4>
                                            @if($post->content != '')
                                                <p class="list-group-item-text">{{substr(strip_tags($post->content), 0,100)}}</p>
                                            @endif
                                        </a>

                                    @endif

                                @endforeach
                            @else
                                <div class="list-group-item ">
                                    <h4 class="list-group-item-heading">Nada encontrado com a busca:
                                        <strong>{{$search}}</strong></h4>
                                    <p class="list-group-item-text">Tente novamente
                                    <form action="{{URL::route('search')}}" class="mb25" id="form-search" role="search">
                                        <div class="has-icon">
                                            <input type="text" id="search" class="form-control input-lg"
                                                   placeholder="Buscar no site...">
                                            <i class="search ico-search form-control-icon"></i>
                                        </div>
                                    </form>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!--/ END Row -->
            <!--/ END Row -->
        </div>
    </section>
    <!--/ END Blog Content -->

    <!-- START To Top Scroller -->
    <a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut"
       data-offset="50%"><i class="ico-angle-up"></i></a>
    <!--/ END To Top Scroller -->
</section>
<!--/ END Contact Form + Infos -->

<!-- START To Top Scroller -->
<a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut"
   data-offset="50%"><i class="ico-angle-up"></i></a>
<!--/ END To Top Scroller -->
</section>
<!--/ END Template Main -->

<!-- START Template Footer -->
@include('site.parts.footer-content')
<!--/ END Template Footer -->

@include('site.parts.footer')
</body>
<!--/ END Body -->
</html>