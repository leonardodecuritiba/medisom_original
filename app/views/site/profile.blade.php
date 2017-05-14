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
            <li><a>Minha Conta</a></li>
            <li class="active">Perfil</li>
        </ul>

        <div class="row mt40">
            <!--  Sideabar -->
            <aside class="col-lg-3 col-md-3 col-sm-12 col-xs-12">

                <!--My Account-->
                <div class="sidemodule">
                    <h2 class="heading5"><span class="maintext"> Minha Conta</span></h2>
                    <ul class="nav nav-list categories">
                        <li><a href="{{URL::route('profile')}}">Perfil </a></li>
                    </ul>
                </div>
            </aside>
            <!--  Container -->
            <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 mt40column">

                <div class="">
                    <h2 class="heading5"><span class="maintext">Meu Perfil</span></h2>
                    @if ( count($errors) > 0)
                        <div class="errormsg alert">
                            <i class="fa fa-frown-o font36"></i>
                            <i class="fa fa-times-circle"></i>
                            <strong>Erro!</strong>
                            @foreach ($errors->all() as $e)
                                {{ $e }}<br>
                            @endforeach
                        </div>
                    @elseif(isset($success))
                        <div class="successmsg alert">
                            <i class="fa fa-check-circle-o font36"></i><i class="fa fa-times-circle"></i>
                            <strong>Sucesso!</strong> {{$success}} </div>
                    @endif
                    <form action="{{URL::route('profile',array('action'=>'save'))}}" method="post"
                          class="form-horizontal mt20">
                        <fieldset>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nome:</label>
                                <div class="col-sm-6">
                                    <input type="text" name="name" class="form-control" placeholder="Nome"
                                           value="{{Auth::user()->name}}">
                                    <input type="hidden" name="user_id" value="{{Auth::id()}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Nome da Empresa:</label>
                                <div class="col-sm-6">
                                    <input type="text" name="company_name" class="form-control"
                                           placeholder="Nome da Empresa">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Telefones:</label>
                                <div class="col-sm-6">
                                    <input type="text" name="phones" class="form-control" placeholder="Telefones">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Email:</label>
                                <div class="col-sm-6">
                                    <input type="text" name="email" disabled="" class="form-control"
                                           placeholder="Seu email" value="{{Auth::user()->email}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Website:</label>
                                <div class="col-sm-6">
                                    <input type="text" name="site" class="form-control" placeholder="http://">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Endereço:</label>
                                <div class="col-sm-6">
                                    <input type="search" name="s" class="form-control"
                                           placeholder="Ex.: Rua das Mulas 666, Cidade - SC">

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Sobre a Empresa</label>
                                <div class="col-sm-6">
                                    <textarea rows="6" name="company_about" class="form-control col-sm-6"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Logotipo :</label>
                                <div class="col-sm-6">
                                    <input type="file" name="logotipo" class="form-control">
                                </div>
                            </div>
                            <!--<div class="form-group">
                              <label class="col-sm-2 control-label">Imagens Extras :</label>
                              <div class="col-sm-6">
                                <input type="file" name="img_extra[]" class="form-control">
                                <input type="file" name="img_extra[]" class="form-control">
                                <input type="file" name="img_extra[]" class="form-control">
                                <input type="file" name="img_extra[]" class="form-control">
                              </div>
                            </div>-->
                            <div class="col-sm-offset-2 col-sm-10 mt20">
                                <button type="submit" class="btn btn-orange">Salvar</button>
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
