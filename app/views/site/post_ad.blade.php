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
            <li class="active">Post An Ad</li>
        </ul>
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
                <div class="">
                    <h2 class="heading5"><span class="maintext"> Post An Ad</span></h2>
                    <form class="form-horizontal mt20">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Title:</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Title">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Category:</label>
                                <div class="col-sm-6">
                                    <select name="category" class="form-control" id="category">
                                        <option value="">Choose a category</option>
                                        <optgroup label="Vehicle">
                                            <option value="2">Aircraft</option>
                                            <option value="3">Automotive Items &amp; Parts</option>
                                            <option value="4">Boats &amp; Watercraft</option>
                                            <option value="5">Cars</option>
                                            <option value="6">Classic Cars</option>
                                            <option value="7">Commercial Trucks &amp; Tractor Trailers</option>
                                            <option value="8">Off Road Vehicles</option>
                                            <option value="9">RV &amp; Motorhomes</option>
                                            <option value="10">SUVs</option>
                                            <option value="11">Utility &amp; Work Trailers</option>
                                            <option value="12">Vans</option>
                                        </optgroup>
                                        <optgroup label="Sevices">
                                            <option value="2">Automotive Services</option>
                                            <option value="3">Beauty & Salon Services</option>
                                            <option value="4">Caregivers & Baby Sitting</option>
                                            <option value="5">Cleaning Services</option>
                                            <option value="6">Construction & Remodeling</option>
                                            <option value="7">Financial Services</option>
                                            <option value="8">Health & Wellness</option>
                                            <option value="9">Home Services</option>
                                            <option value="10">Insurance</option>
                                            <option value="11">Office Services</option>
                                            <option value="12">Real Estate Services</option>
                                        </optgroup>
                                        <optgroup label="Pets">
                                            <option value="2">Birds</option>
                                            <option value="3">Cats</option>
                                            <option value="4">Dogs</option>
                                            <option value="5">Fish & Reptile Pets</option>
                                            <option value="6">Free Pets to Good Home</option>
                                            <option value="7">Horses</option>
                                            <option value="8">Pet Supplies</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Description</label>
                                <div class="col-sm-6">
                                    <textarea rows="6" class="form-control col-sm-6"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Keywords</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Keywords">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Adress</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Address">
                                    <input type="text" class="form-control  mt10" placeholder="State">
                                    <input type="text" class="form-control mt10" placeholder="Country">
                                    <input type="text" class="form-control mt10" placeholder="Post Code">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Upload photos</label>
                                <div class="col-sm-6">
                                    <input type="file" class="form-control">
                                    <input type="file" class="form-control mt10">
                                    <input type="file" class="form-control mt10">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Price</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" placeholder="Price">
                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox">
                                        I agree to the terms and conditions </label>
                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-sm-10 mt20">
                                <input type="submit" class="btn btn-orange" value="Post An Ad">
                            </div>
                        </fieldset>
                    </form>
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
