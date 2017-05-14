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
    <div class="container">
        <!--  breadcrumb -->
        <ul class="breadcrumb">
            <li><a>Home</a></li>
            <li class="active">Register</li>
        </ul>
        <a href="post-ad.html" class="postadinner"><span> <i class="fa fa-pencil"></i> Post An Ad</span></a>
        <div class="mt40 row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <h5 class="heading5">Register</h5>
                @if ( count($errors) > 0)
                    <div class="errormsg alert">
                        <i class="fa fa-frown-o font36"></i>
                        <i class="fa fa-times-circle"></i>
                        <strong>Erro!</strong>
                        @foreach ($errors->all() as $e)
                            {{ $e }}<br>
                        @endforeach
                    </div>

                @endif
                <div class="loginbox">
                    <form action="{{URL::route('register',array('action'=>'register'))}}" method="post"
                          class="form-vertical">
                        <fieldset>
                            <div class="control-group">
                                <label class="control-label">Nome:</label>
                                <div class="controls">
                                    <input name="name" type="text">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">E-Mail:</label>
                                <div class="controls">
                                    <input name="email" type="email">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Senha:</label>
                                <div class="controls">
                                    <input name="password" type="password">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Repita a Senha:</label>
                                <div class="controls">
                                    <input name="passwordconfirm" type="password">
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-orange">Registrar</button>
                        </fieldset>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <div class="loginbox">
                    <h5 class="heading5"> Why Us</h5>
                    <p>By creating an account you will be able to shop faster, be up to date on an order's status, and
                        keep track of the orders you have previously made.</p>
                    <ul class="whyus">
                        <li><i class="fa  fa-magic"></i> <span class="direname">Easy to Understand</span></li>
                        <li><i class="fa fa-arrow-right"></i> <span class="direname">Fast to Navigate</span></li>
                        <li><i class="fa fa-th"></i> <span class="direname">Lot of Options</span></li>
                        <li><i class="fa fa-search"></i><span class="direname">Quick Search</span></li>
                    </ul>
                    <br>
                    <br>
                    <a class="btn btn-orange">Continue</a></div>
            </div>
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
