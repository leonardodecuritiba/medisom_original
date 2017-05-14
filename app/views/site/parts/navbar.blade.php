<div id="fb-root"></div>
<script>(function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&appId=561831317293012&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

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
            <div class="navbar-form navbar-left dropdown" id="dropdown-form">
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
            <!-- START nav collapse -->
            <div class="collapse navbar-collapse navbar-collapse-alt" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown @if( Route::currentRouteName() == 'home' ) active @endif">
                        <a href="{{URL::route('home')}}" class="dropdown-toggle dropdown-hover">
                        <span class="meta">
                        <span class="text">INICIO</span>

                        </span>
                        </a>

                    </li>
                    <li class="dropdown @if( Route::currentRouteName() == 'about' ) active @endif">
                        <a href="{{URL::route('about')}}" class="dropdown-toggle dropdown-hover">
                        <span class="meta">
                        <span class="text">QUEM SOMOS</span>
         
                        </span>
                        </a>

                    </li>
                    <li class="dropdown @if( Route::currentRouteName() == 'services' ) active @endif">
                        <a href="{{URL::route('services')}}" class="dropdown-toggle dropdown-hover">
                        <span class="meta">
                        <span class="text">PRODUTOS E SERVIÇOS</span>
                
                        </span>
                        </a>

                    </li>
                    <li class="dropdown @if( Route::currentRouteName() == 'blog' ) active @endif">
                        <a href="{{URL::route('blog')}}" class="dropdown-toggle dropdown-hover">
                        <span class="meta">
                        <span class="text">BLOG</span>
                        
                        </span>
                        </a>

                    </li>

                    <li class="@if( Route::currentRouteName() == 'contact' ) active @endif">
                        <a href="{{URL::route('contact')}}" class="dropdown-toggle dropdown-hover">
                        <span class="meta">
                        <span class="text">CONTATO</span>
                
                        </span>
                        </a>

                    </li>
                    <li class="dropdown">
                        <a href="{{URL::route('login')}}" target="_blank" class="dropdown-toggle dropdown-hover">
                            <span class="meta">
                                <span class="text text-primary">ÁREA RESTRITA (CLIENTE)</span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
            <!--/ END nav collapse -->
        </div>
        <!--/ END Toolbar -->
    </div>
</header>
<!--/ END Template Header -->