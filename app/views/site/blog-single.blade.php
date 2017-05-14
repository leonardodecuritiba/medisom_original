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
                <h4 class="title">{{$title}}</h4>
            </div>
            <div class="page-header-section">
                <!-- Toolbar -->
                <div class="toolbar">
                    <ol class="breadcrumb breadcrumb-transparent nm">
                        <li><a href="javascript:void(0);">Inicio</a></li>
                        <li><a href="javascript:void(0);">Blog</a></li>
                        <li class="active">{{$post->title}}</li>
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
            <div class="row">
                <!-- START Left Section -->
                <div class="col-md-9">
                    <!-- Blog post #1 -->
                    <article class="panel panel-minimal overflow-hidden mb0">
                        <!-- heading -->
                        <h3 class="section-title font-alt mt0">{{$post->title}}</h3>
                        <!--/ heading -->

                        <!-- meta -->
                        <p class="meta">
                            <!-- comments -->
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
                            <span class="text-muted">Por </span>{{Post::find($post->post_id)->author($post->post_author)->name}}<!-- author -->
                        </p>
                        <!--/ meta -->

                        <!-- Owl Carousel -->
                        <header class="gallery-post owl-carousel mb15">
                            <div class="image"><img
                                        src="{{ asset('public/uploads/'.Post::find($post->post_id)->postmeta($post->post_id,'image_default') )}}"
                                        width="100%" height="400px"></div>
                        </header>
                        <!--/ Owl Carousel -->

                        <!-- text -->
                    {{$post->content}}
                    <!--/ text -->
                        <div class="col-md-12">
                            <span class='st_fblike_hcount' displayText='Facebook Like'></span>
                            <span class='st_twitter_hcount' displayText='Tweet'></span>
                            <span class='st_googleplus_hcount' displayText='Google +'></span>
                            <span class='st_email_hcount' displayText='Email'></span>
                        </div>
                        <hr style="margin:60px 0;"><!-- horizontal line -->

                        <!-- Comments -->
                        <section class="mb15">
                            <h4 class="section-title font-alt mt0">Comentarios</h4>
                            <div class="fb-comments" data-href="https://www.facebook.com/medisom.com.br"
                                 data-width="100%" data-numposts="5" data-colorscheme="light"></div>
                        </section>
                        <!-- Comments -->

                        <hr style="margin:60px 0;"><!-- horizontal line -->


                    </article>
                    <!--/ Blog post #1 -->
                    <div class="mb15 visible-xs visible-sm"></div>
                </div>
                <!--/ END Left Section -->

                <!-- START Right Section -->
                <div class="col-md-3">


                    <!-- Category -->
                    <div class="pt25 mb25">
                        <!-- Title -->
                        <h4 class="section-title font-alt mt0">Categorias</h4>
                        <!--/ Title -->
                        <ul class="list-unstyled">
                            @foreach($categories as $category)
                                @if(isset($post->post_id))
                                    @if(Post::find($post->post_id)->terms($post->post_id,$category->term_taxonomy_id))
                                        <li class="mb5">
                                            <i class="ico-angle-right text-muted mr5"></i>
                                            <a href="{{Option::get('url_site')}}/categoria/{{$category->slug}}">{{$category->name}}</a>
                                        </li>
                                    @endif
                                @endif
                            @endforeach

                        </ul>
                    </div>
                    <!--/ Category -->


                    <!-- Blog Post -->

                    <!--/ Blog Post -->
                </div>
                <!--/ END Right Section -->
            </div>
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