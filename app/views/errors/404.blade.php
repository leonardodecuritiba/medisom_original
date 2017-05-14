<!DOCTYPE html>
<html class="frontend">
<!-- START Head -->
<head>
    <!-- START META SECTION -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Página não encontrada | Medisom</title>
    <meta name="description" content="Medisom">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    @include('site.parts.head')
</head>
<!--/ END Head -->
<!-- START Body -->
<body>

<!-- START Template Header -->
<header id="header" class="navbar">
    <div class="container">
        <!-- START navbar header -->
        <div class="navbar-header navbar-header-transparent">
            <!-- Brand -->
            <a class="navbar-brand" href="{{URL::route('home')}}">

                <span class="logo-text"></span>
            </a>
            <!--/ Brand -->
        </div>
        <!--/ END navbar header -->
        <!-- START Toolbar -->
        <div class="navbar-toolbar clearfix">
            <!-- START Left nav -->
            <ul class="nav navbar-nav">
                <!-- Navbar collapse: This menu will take position at the top of template header (mobile only). Make sure that only #header have the `position: relative`, or it may cause unwanted behavior -->
                <li class="navbar-main navbar-toggle">
                    <a href="javascript:void(0);" data-toggle="collapse" data-target="#navbar-collapse">
                            <span class="meta">
                            <span class="icon"><i class="ico-paragraph-justify3"></i></span>
                            </span>
                    </a>
                </li>
                <!--/ Navbar collapse -->
            </ul>
            <!--/ END Left nav -->
            <!-- START navbar form -->
            <div class="navbar-form navbar-left dropdown open" id="dropdown-form">
                <form action="{{URL::route('search')}}" class="mb25" id="form-search" role="search"
                      data-parsley-validate>
                    <div class="has-icon">
                        <input type="text" id="search" class="form-control input-lg" placeholder="Buscar no site..."
                               required>
                        <i class="search ico-search form-control-icon"></i>
                    </div>
                </form>
            </div>
            <!-- START navbar form -->
            <!-- START Right nav -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Search form toggler -->
                <li>
                    <a href="javascript:void(0);" data-toggle="dropdown" data-target="#dropdown-form">
                            <span class="meta">
                            <span class="icon"><i class="ico-search"></i></span>
                            </span>
                    </a>
                </li>
                <!--/ Search form toggler -->

            </ul>
            <!--/ END Right nav -->
        </div>
    </div>
</header>
<!-- Header End -->
<!-- START Contact Form + Infos -->
<section class="section bgcolor-white">
    <div class="container">
        <div class="clearfix" style="margin-bottom: 100px;"></div>

        <!-- START Row -->
        <div class="row">
            <!-- START Left Section -->
            <div class="col-md-12">
                <div class="section-header no-border text-center">
                    <h1 class="section-title font-alt">Erro 404!</h1>
                    <h4 class="thin text-muted">A página que você solicitou não foi encontrada</h4>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- START Template Footer -->
@include('site.parts.footer-content')
<!--/ END Template Footer -->

@include('site.parts.footer')

</body>
</html>