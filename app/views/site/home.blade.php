<!DOCTYPE html>
<html class="frontend">
<!-- START Head -->
<head>
    <!-- START META SECTION -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Medisom</title>
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
    <!-- START Layerslider -->
    <section id="layerslider" style="width:100%; height:553px;">

    @if(count($banners))
        @foreach($banners as $banner)
            @if($banner->align == 'l')
                <!-- Slide #1 -->
                    <div class="ls-slide" data-ls="transition2d:1; slidedelay:8000;">
                    @if(isset($banner->image_background))
                        <!-- slide background -->
                            <img src="{{ asset('public/uploads/' . $banner->image_background )}}" class="ls-bg">
                            <!--/ slide background -->
                    @endif
                    @if(isset($banner->image_1))
                        <!-- Layer #1 -->
                            <img class="ls-l" style="top:90px;left:68%;"
                                 src="{{ asset('public/uploads/' . $banner->image_1 )}}"
                                 data-ls="delayin:1000; easingin:easeOutElastic;">
                            <!--/ Layer #1 -->
                    @endif
                    @if(isset($banner->title))
                        <!-- Layer #2 -->
                            <h1 class="ls-l font-alt" style="top:110px;left:150px;"
                                data-ls="offsetxin:0;durationin:2000;delayin:1500;easingin:easeOutElastic;rotatexin:-90;transformoriginin:50% top 0;offsetxout:-200;durationout:1000;">
                                <span class="text-primary">{{$banner->title}}</span>
                            </h1>
                            <!--/ Layer #2 -->
                    @endif
                    @if(isset($banner->text_1))
                        <!-- Layer #3 -->
                            <h4 class="ls-l" style="top:170px;left:150px;width:550px;"
                                data-ls="offsetxin:0; durationin:2000; delayin:2000; easingin:easeOutElastic; rotatexin:90; transformoriginin:50% top 0; offsetxout:-400;">
                                {{$banner->text_1}}
                            </h4>
                            <!--/ Layer #3 -->
                    @endif
                    @if(isset($banner->text_2))
                        <!-- Layer #4 -->
                            <p class="ls-l text-default" style="top:230px;left:150px;width:550px;"
                               data-ls="offsetxin:0; durationin:2000; delayin:2500; easingin:easeOutElastic; rotatexin:90; transformoriginin:50% top 0; offsetxout:-400;">
                                {{$banner->text_2}}
                            </p>
                            <!--/ Layer #4 -->
                    @endif
                    @if(isset($banner->text_button) && isset($banner->link_button))
                        <!-- Layer #5 -->
                            <a href="{{$banner->link_button}}" class="ls-l btn btn-primary"
                               style="top:310px; left:150px;"
                               data-ls="offsetxin:0; durationin:2000; delayin:3000; easingin:easeOutElastic; rotatexin:90; transformoriginin:50% top 0; offsetxout:-400;">
                                {{$banner->text_button}} <i class="ico-angle-right ml5"></i>
                            </a>
                            <!--/ Layer #5 -->
                    @endif
                    @if(isset($banner->chamada_button))
                        <!-- Layer #6
                                <img class="ls-l" style="top:320px;left:300px;" src="{{ asset('public/uploads/' . $banner->chamada_button )}}" data-ls="delayin:3500; offsetxin:0; offsetyin:-30; easingin:easeOutElastic;">-->
                            <!--/ Layer #6 -->
                        @endif
                    </div>
                    <!-- Slide #1 -->
            @else
                <!-- Slide #2 -->
                    <div class="ls-slide" data-ls="transition2d:1; slidedelay:8000;">
                    @if(isset($banner->image_background))
                        <!-- slide background -->
                            <img src="{{ asset('public/uploads/' . $banner->image_background )}}" class="ls-bg">
                            <!--/ slide background -->
                    @endif
                    @if(isset($banner->title))
                        <!-- Layer #2 -->
                            <h1 class="ls-l font-alt text-right" style="top:110px;left:65%;width:550px;"
                                data-ls="easingin:easeOutElastic; delayin:500;">
                                <span class="text-primary">{{$banner->title}}</span>
                            </h1>
                            <!--/ Layer #2 -->
                    @endif
                    @if(isset($banner->text_1))
                        <!-- Layer #3 -->
                            <h4 class="ls-l text-default text-right" style="top:170px;left:65%;width:550px;"
                                data-ls="easingin:easeOutElastic; delayin:1000;">
                                {{$banner->text_1}}
                            </h4>
                            <!--/ Layer #3 -->
                    @endif
                    @if(isset($banner->text_2))
                        <!-- Layer #1 -->
                            <p class="ls-l text-default text-right" style="top:230px;left:65%;width:550px;"
                               data-ls="easingin:easeOutElastic; delayin:0;">
                                {{$banner->text_2}}
                            </p>
                            <!--/ Layer #1 -->
                    @endif
                    @if(isset($banner->text_button) && isset($banner->link_button))
                        <!-- Layer #5 -->
                            <p class="ls-l text-default text-right" style="top:290px;left:65%;width:550px;"
                               data-ls="easingin:easeOutElastic; delayin:1500;">
                                <a href="{{$banner->link_button}}" class="btn btn-primary">
                                    {{$banner->text_button}} <i class="ico-angle-right ml5"></i>
                                </a>
                            </p>
                            <!--/ Layer #5 -->
                    @endif
                    @if(isset($banner->image_1))
                        <!-- Layer #6 -->
                            <img class="ls-l" style="top:80px;left:250px;"
                                 src="{{ asset('public/uploads/' . $banner->image_1 )}}"
                                 data-ls="delayin:2000; easingin:easeOutElastic;">
                            <!--/ Layer #6 -->
                        @endif
                    </div>
                    <!-- Slide #2 -->
                @endif
            @endforeach
        @endif

    </section>
    <!--/ END Layerslider -->

    <!-- START Call To Action Section -->
    <section class="pt35 pb35 bgcolor-accent">
        <div class="container">
            <div class="col-sm-9">
                <h3 class="font-alt text-white nm mt3">Não perca tempo solicite um orçamento agora mesmo.</h3>
            </div>
            <div class="mb15 visible-xs"></div>
            <div class="col-sm-3 clearfix">
                <a href="{{URL::route('orcamento')}}"
                   class="btn btn-outline btn-default text-white pull-right semibold">Solicitar Orçamento</a>
            </div>
        </div>
    </section>
    <!-- END Call To Action Section -->

    <!-- START Features Section -->

@if(count($posts)>0)

    <!-- START Recent Blog Section -->
        <section class="section">
            <div class="container">
                <!-- START Section Header -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-header text-center">
                            <h1 class="section-title font-alt mb25">Blog</h1>
                        </div>
                    </div>
                </div>
                <!--/ END Section Header -->

                <!-- START row -->
                <div class="row">

                @foreach($posts as $post)

                    <!-- Blog post #1 -->
                        <div class="col-sm-4 post">
                            <article class="panel no-border overflow-hidden mb0">
                                <!-- Thumbnail -->
                                <header class="thumbnail">
                                    <!-- media -->
                                    <div class="media">
                                        <!-- indicator -->
                                        <div class="indicator"><span class="spinner"></span></div>
                                        <!--/ indicator -->
                                        <!-- toolbar overlay -->
                                        <div class="overlay">
                                            <div class="toolbar">
                                                <a href="{{$post->url}}" class="btn btn-success"><i
                                                            class="ico-new-tab"></i></a>
                                            </div>
                                        </div>
                                        <!--/ toolbar overlay -->
                                        <img data-toggle="unveil"
                                             src="{{ asset('public/themes/'.Option::get('theme_site').'/image/background/blog/placeholder.jpg' )}}"
                                             data-src="{{ asset('public/uploads/'.Post::find($post->post_id)->postmeta($post->post_id,'image_default') )}}"
                                             alt="Photo" height="200px" width="100%">
                                    </div>
                                    <!--/ media -->
                                </header>
                                <!--/ Thumbnail -->
                                <!-- Content -->
                                <section class="pa20">
                                    <!-- heading -->
                                    <h4 class="mt0 ellipsis">{{$post->title}}</h4>
                                    <!--/ heading -->
                                    <!-- meta -->
                                    <p class="meta nm">
                                        <span class="text-muted mr5 ml5">&#8226;</span>
                                        <span class="text-muted">Em </span>
                                        @foreach($categories as $category)
                                            @if(isset($post->post_id))
                                                @if(Post::find($post->post_id)->terms($post->post_id,$category->term_taxonomy_id))
                                                    <a href="{{Option::get('url_site')}}/categoria/{{$category->slug}}">{{$category->name}}
                                                        ,</a>
                                                @endif
                                            @endif
                                        @endforeach
                                        <span class="text-muted mr5 ml5">&#8226;</span>
                                        <span class="text-muted">Por </span>{{Post::find($post->post_id)->author($post->post_author)->name}}
                                    </p>
                                    <!--/ meta -->
                                </section>
                                <!--/ Content -->
                            </article>
                            <div class="mb15 visible-xs"></div>
                        </div>
                        <!--/ Blog post #1 -->

                    @endforeach

                </div>
                <!--/ END row -->
            </div>
        </section>
        <!--/ END Recent Blog Section -->
@endif

@if(count($clients))

    <!-- START Lovely Client -->
        <section class="section bgcolor-white">
            <div class="container">
                <!-- START Section Header -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="section-header text-center">
                            <h1 class="section-title font-alt mb25">Clientes</h1>
                        </div>
                    </div>
                </div>
                <!--/ END Section Header -->

                <!-- carousel -->
                <div class="owl-carousel" id="lovely-client">
                @foreach($clients as $client)
                    <!-- client #1 -->
                        <div class="item text-center">
                            <a href="{{ Post::find($client->post_id)->postmeta($client->post_id,'site') }}"
                               target="_blank"><img
                                        src="{{ asset('public/uploads/'.Post::find($client->post_id)->postmeta($client->post_id,'image_default'))}}"
                                        alt="{{$client->title}}" width="144" height="144"></a>
                        </div>
                        <!--/ client #1 -->
                    @endforeach
                </div>
                <!--/ carousel -->
            </div>
        </section>
        <!--/ END Lovely Client -->
@endif
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