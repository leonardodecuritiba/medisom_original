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
                <h4 class="title">Blog</h4>
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
            <div class="row" id="shuffle-grid">

            @if(count($posts)>0)
                @foreach($posts as $post)
                    <!-- Blog post #3 -->
                        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 post">
                            <article class="panel overflow-hidden">
                                <!-- Owl Carousel -->
                                <?php $post_imagem = Post::find($post->post_id)->postmeta($post->post_id, 'image_default'); ?>
                                @if($post_imagem != '')
                                    <header class="owl-carousel gallery-post">
                                        <a href="{{$post->url}}">
                                            <div class="image">
                                                <img src="{{ asset('public/uploads/'. $post_imagem ) }}" width="100%">
                                            </div>
                                        </a>
                                    </header>
                            @endif
                            <!--/ Owl Carousel -->

                                <!-- Content -->
                                <section class="panel-body">
                                    <!-- heading -->
                                    <h4 class="section-title font-alt mt0"><a href="{{$post->url}}">{{$post->title}}</a>
                                    </h4>
                                    <!--/ heading -->

                                    <!-- text -->
                                    <p>{{$post->expert}}&#8230;</p>
                                    <!--/ text -->

                                    <!-- Meta & button -->
                                    <!-- meta -->
                                    <p class="meta mb15">
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
                                    <a href="{{$post->url}}" class="btn btn-success">Leia mais&#8230;</a>
                                    <!-- Meta & button -->
                                </section>
                                <!--/ Content -->
                            </article>
                        </div>
                        <!--/ Blog post #3 -->
                    @endforeach
                @endif
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