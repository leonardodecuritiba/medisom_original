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
        <div class="container"><a class="logo pull-left" href="index.html"><img title="Classifieds" alt="Classifieds"
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
            <li><a>My Account</a></li>
            <li class="active"> Dashboard</li>
        </ul>
        <a href="post-ad.html" class="postadinner"><span> <i class="fa fa-pencil"></i> Post An Ad</span></a>
        <div class="row mt40">
            <!--  Sideabar -->
            <aside class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                <!--My Account-->
                <div class="sidemodule">
                    <h2 class="heading5"><span class="maintext"> My Account</span></h2>
                    <ul class="nav nav-list categories">
                        <li><a href="account.html">Dashboard</a></li>
                        <li><a href="profile.html">Create Profile </a></li>
                        <li><a href="post-ad.html">Post An Ad</a></li>
                    </ul>
                </div>
            </aside>
            <!--  Container -->
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 mt40column">
                <h2 class="heading5"><span class="maintext"> Dashboard</span></h2>
                <ul class="state">
                    <li><i class="fa  fa-tag"></i> <br>
                        <div class="text">Your Credits : <span class="orange">500</span></div>
                    </li>
                    <li><i class="fa fa-file-text-o"></i> <br>
                        <div class="text">Published : <span class="orange">10</span></div>
                    </li>
                    <li><i class="fa fa-eye"></i> <br>
                        <div class="text">Views this week : <span class="orange">55</span></div>
                    </li>
                    <li><i class="fa fa-thumbs-o-up"></i> <br>
                        <div class="text">Total Ad views : <span class="orange">258</span></div>
                    </li>
                </ul>
                <div class="col-md-6 mt40">
                    <div class="sparkchart">
                        <h4 class="orange">16.8% more</h4>
                        <p>Monthly visitor statistics</p>
                        <span class="inlinesparkline">100,400,400,700,500,900,1002</span></div>
                </div>
                <div class="col-md-6 mt40">
                    <div class="sparkchart">
                        <h4 class="orange"> 8 Sales</h4>
                        <p>Avg. Sales per day</p>
                        <span class="monthly-sales"></span></div>
                </div>
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
