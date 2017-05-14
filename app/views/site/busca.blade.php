<!DOCTYPE html>
<html>
<head>
    <title>Classic - A Bootstrap Classified Ads Template</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Responisve, Bootstrap, Html5, Css3, Blog, Classified, Ads, Simple, Clean ">

    @include('site.parts.head')

</head>
<body>
<!-- Header Start -->
<header id="header">
    <div class="headerdetails">
        <div class="container"><a class="logo pull-left" href="{{URL::route('home')}}"><img title="Classifieds"
                                                                                            alt="Classifieds"
                                                                                            src="{{ asset('public/themes/'.Option::get('theme_site').'/img/logo.png') }}"></a>
            @include('site.parts.navbar')
        </div>
    </div>
</header>
<!-- Header End -->
<div id="maincontainer">
    <!-- Search Start-->
    <section id="searchinner">
        <div class="container">
            <div class="searchcontianer">


                <form action="{{URL::route('search')}}" method="get" class="form-inline">
                    <div class="btn-group">
                        <input type="search" placeholder="Digite a sua cidade" name="s" class="form-control mainserarch"
                               value="{{$s}}">
                        <input type="hidden" name="lat">
                        <input type="hidden" name="long">
                        <input type="submit" value="Buscar" class="btn btn-orange tooltip-test mainserarchsubmit">
                    </div>
                </form>


            </div>
        </div>
        @if(Auth::guest())
            <a href="{{URL::route('login')}}" class="postad"><span> <i class="fa fa-pencil"></i> Anunciar</span></a>
        @endif

    </section>
    <div class="container">

        <div class="row mt40">
            <!--  Sideabar -->
            <aside class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                <!--Location-->
                <div class="sidemodule">
                    <h2 class="heading5"><span class="maintext">Filtrar por Local</span></h2>
                    <ul class="nav nav-list categories">
                        @foreach($cities as $city=>$bairros)
                            <li><a href="javasicript:;"
                                   id="{{BaseController::transformWords(true,$city,array('busca'=>array(' '),'substitui'=>array('_')))}}">{{$city}} </a>
                                <ul class="nav nav-list">
                                    @foreach($bairros as $bairro)
                                        <li><a href="javasicript:;"
                                               id="{{BaseController::transformWords(true,$bairro,array('busca'=>array(' '),'substitui'=>array('_')))}}">{{$bairro}} </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>
                </div>


            </aside>
            <!--  Container -->
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 mt40column">

                <!-- Listing-->
                <div class="mt40" id="serchlist">
                    <div class="searchresult list">
                        <ul>
                            @foreach($posts as $post)
                                @if($post->city == $s_city)
                                    <li data-city="{{BaseController::transformWords(true,$post->city,array('busca'=>array(' '),'substitui'=>array('_')))}}"
                                        data-district="{{BaseController::transformWords(true,$post->district,array('busca'=>array(' '),'substitui'=>array('_')))}}"
                                        class="clearfix  listResult">
                                        <div class="col-sm-2"><img src="{{ asset('public/uploads/'.$post->logotipo) }}"
                                                                   alt="">
                                            <!--<div class="featured">Featured</div>-->
                                        </div>
                                        <div class="col-sm-10">
                                            <h3>{{$post->title}} </h3>
                                            <ul class="icondetail">
                                                <li><i class="fa fa-phone"></i>{{$post->phones}}</li><!---->
                                                <li><i class="fa fa-link"></i> <a target="_blank"
                                                                                  href="{{$post->site}}">{{str_replace(array('http://','www.'),array('',''),$post->site)}}</a>
                                                </li>
                                                <li style="width: 100%;"><i
                                                            class="fa fa-map-marker"></i>{{$post->address}}
                                                    , {{$post->district}}, {{$post->city}} - {{$post->uf}}</li>
                                                <!---->
                                                <!--<li><i class="fa fa-user"></i> Posted by : <a href="#">pxcreate</a></li>-->
                                            </ul>
                                            <div class="discrption"> {{$post->content}} </div>
                                        </div>

                                    </li>
                                @endif
                            @endforeach
                            <hr>
                            @foreach($posts as $post)
                                @if($post->city != $s_city)
                                    <li data-city="{{BaseController::transformWords(true,$post->city,array('busca'=>array(' '),'substitui'=>array('_')))}}"
                                        data-district="{{BaseController::transformWords(true,$post->district,array('busca'=>array(' '),'substitui'=>array('_')))}}"
                                        class="clearfix  listResult">
                                        <div class="col-sm-2"><img src="{{ asset('public/uploads/'.$post->logotipo) }}"
                                                                   alt="">
                                            <!--<div class="featured">Featured</div>-->
                                        </div>
                                        <div class="col-sm-10">
                                            <h3>{{$post->title}} </h3>
                                            <ul class="icondetail">
                                                <li><i class="fa fa-phone"></i>{{$post->phones}}</li><!---->
                                                <li><i class="fa fa-link"></i> <a target="_blank"
                                                                                  href="{{$post->site}}">{{str_replace(array('http://','www.'),array('',''),$post->site)}}</a>
                                                </li>
                                                <li style="width: 100%;"><i
                                                            class="fa fa-map-marker"></i>{{$post->address}}
                                                    , {{$post->district}}, {{$post->city}} - {{$post->uf}}</li>
                                                <!---->
                                                <!--<li><i class="fa fa-user"></i> Posted by : <a href="#">pxcreate</a></li>-->
                                            </ul>
                                            <div class="discrption"> {{$post->content}} </div>
                                        </div>

                                    </li>

                                @endif
                            @endforeach
                        </ul>


                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Social-->
    <div class="container">
        <h2 class="heading3">Social</h2>
        <div class="mt40" id="social">
            <ul class="row clearfix">
                <li class="col-md-3 col-sm-6">
                    <h5 class="heading5">Twitter</h5>
                    <div id="twitter"></div>
                </li>
                <li class="col-md-3 col-sm-6 mt40column">
                    <h5 class="heading5">Flickr</h5>
                    <div class="social-feed flickr-feed"></div>
                </li>
                <li class="col-md-3 col-sm-6 mt40column">
                    <h5 class="heading5">Youtube</h5>
                    <div class="social-feed youtube-feed"></div>
                </li>
                <li class="col-md-3 col-sm-6 mt40column">
                    <h5 class="heading5">Facebook</h5>
                    <div class="">
                        <div id="fb-root"></div>
                        <script>(function (d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0];
                                if (d.getElementById(id)) return;
                                js = d.createElement(s);
                                js.id = id;
                                js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
                                fjs.parentNode.insertBefore(js, fjs);
                            }(document, 'script', 'facebook-jssdk'));</script>
                        <div class="fb-like-box" data-href="https://www.facebook.com/facebook" data-width="240"
                             data-show-faces="true" data-colorscheme="light" data-stream="false"
                             data-show-border="false" data-header="false" data-height="240"></div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- Newsletter-->
    <section class="mt40 newsletter" id="newslettersignup">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="pull-left ">
                        <h5 class="heading5 borderbottm"> Newsletters Signup</h5>
                        Sign up to Our Newsletter &amp; get attractive Offers by subscribing to our newsletters.
                    </div>
                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="pull-right mt20 surbscribeform">
                        <form class="form-inline">
                            <div class="input-prepend">
                                <input type="text" class="subscribeinput" id="inputIcon"
                                       placeholder="Subscribe to Newsletter">
                                <input type="submit" class="btn btn-orange" value="Subscribe">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer -->
    <footer id="footer">
        <section id="quicklink">
            <div class="container">
                <div class="row">
                    <ul class="quicklinks">
                        <li><a class="active home" href="index.html">Home</a></li>
                        <li><a class="" href="listing.html">Listing</a></li>
                        <li><a class="" href="detail.html">Detail Page</a></li>
                        <li><a class="" href="login.html">Login</a></li>
                        <li><a class="" href="register.html">Register</a></li>
                        <li><a class="" href="account.html">My Account</a></li>
                        <li><a class="" href="contact.html">Contact</a></li>
                        <li><a class="" href="features.html">Features</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="copyrightbottom">
            <div class="container">
                <div class="row">
                    <div class="pull-left"> Copyright © 2014. Classic. All rights reserved</div>
                    <div class="pull-right"> Developed by pxcreate</div>
                </div>
            </div>
        </section>
    </footer>
    <!-- Got to top -->
    <a id="gotop"><i class="fa fa-arrow-circle-up"></i></a></div>


@include('site.parts.footer')
</body>
</html>
