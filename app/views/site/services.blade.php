<!DOCTYPE html>
<html class="frontend">
<!-- START Head -->
<head>
    <!-- START META SECTION -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$post->title}} | Medisom</title>
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
                <h4 class="title">{{$post->title}}</h4>
            </div>
            <div class="page-header-section">
                <!-- Toolbar -->
                <div class="toolbar">
                    <ol class="breadcrumb breadcrumb-transparent nm">
                        <li><a href="javascript:void(0);">Inicio</a></li>
                        <li class="active">{{$post->title}}</li>
                    </ol>
                </div>
                <!--/ Toolbar -->
            </div>
        </div>
    </section>
    <div class="clearfix"></div>
    <!--/ END page header -->

    <!-- START Welcome Message + Video -->
    <section class="section bgcolor-white">
        <div class="container">
            <!-- START Row -->
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header text-center">
                        <h1 class="section-title font-alt mb25">{{$post->title}}</h1>
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="thin text-muted text-center">
                                    {{$post->content}}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                @if(count($services))
                    <div class="col-md-12">
                        <div class="pt25">

                            <ul class="nav nav-tabs nav-justified">
                                @foreach($services as $k=>$service)
                                    <li class="@if($k==0) active @endif"><a href="#service_{{$k}}" data-toggle="tab"
                                                                            aria-expanded="true">
                                            <h4>{{$service->title}}</h4></a></li>
                                @endforeach

                            </ul>

                            <div class="tab-content panel ">
                                @foreach($services as $k=>$service)
                                    <div class="tab-pane  @if($k==0) active @endif" id="service_{{$k}}">
                                        <p>{{$service->description}}</p>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                @endif

            </div>
            <!--/ END Row -->
        </div>
    </section>
    <!--/ END Welcome Message + Video -->

    <!-- START Meet Team -->

    <!--/ END Meet Team -->

    <!-- START Lovely Client -->


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