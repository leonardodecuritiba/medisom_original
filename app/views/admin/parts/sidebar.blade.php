<aside class="sidebar sidebar-left sidebar-menu">
    <!-- START Sidebar Content -->
    <section class="content slimscroll">
    <?php
    $config_site = (
        Route::is('admin.pages') ||
        Route::is('admin.banner') ||
        Route::is('admin.blog') ||
        Route::is('admin.client') ||
        Route::is('admin.configs')
    );
    $versao = Config::get('app.version');
    ?>
    <!-- START Template Navigation/Menu -->
        <ul class="topmenu topmenu-responsive" data-toggle="menu">
            <li><a href="javascript:void(0);"><span class="text">Versão {{$versao}}</span></a></li>
            <li class="@if(Route::is('admin.dashboard')) active @endif">
                <a href="{{URL::route('admin.dashboard')}}">
                    <span class="figure"><i class="ico-dashboard2"></i></span>
                    <span class="text">Dashboard </span>
                </a>
            </li>
        @if(User::allowed('admin-site'))
            <!-- Administração do Site -->
                <li class="@if($config_site) active @endif">
                    <a href="javascript:void(0);" data-toggle="submenu" data-target="#page" data-parent=".topmenu">
                        <span class="figure"><i class="ico-file6"></i></span>
                        <span class="text">Administração do Site</span>
                        <span class="arrow"></span>
                    </a>
                    <!-- START 2nd Level Menu -->
                    <ul id="page" class="submenu collapse @if($config_site) in @endif">
                        <li class="submenu-header ellipsis @if(Route::currentRouteName() != 'admin.dashboard' && Route::currentRouteName() != 'admin.users' && Route::currentRouteName() != 'admin.groups'  && Route::currentRouteName() != 'admin.report'  && Route::currentRouteName() != 'admin.report-custom' && Route::currentRouteName() != 'admin.sensores') active @endif">
                            Administração do Site
                        </li>

                        @if(User::allowed('admin-site-pages'))
                            <li class="@if(Route::currentRouteName() == 'admin.pages') active @endif">
                                <a href="javascript:void(0);" data-toggle="submenu" data-target="#pages"
                                   data-parent="#page">
                                    <span class="text">Páginas</span>
                                    <span class="arrow"></span>
                                </a>
                                <!-- START 2nd Level Menu -->
                                <ul id="pages"
                                    class="submenu collapse @if(Route::currentRouteName() == 'admin.pages') in @endif">
                                    @if(User::allowed('admin-site-pages-home'))
                                        <li>
                                            <a href="{{URL::route('admin.pages',array('post_id'=>1))}}"><span
                                                        class="text">Página Inicial</span></a>
                                        </li>
                                    @endif

                                    @if(User::allowed('admin-site-pages-about'))
                                        <li class="@if(strrpos(Request::url(), '8')) active @endif">
                                            <a href="{{URL::route('admin.pages',array('post_id'=>8))}}"><span
                                                        class="text">Quem Somos</span></a>
                                        </li>
                                    @endif
                                    @if(User::allowed('admin-site-pages-product'))
                                        <li class="@if(strrpos(Request::url(), '17')) active @endif">
                                            <a href="{{URL::route('admin.pages',array('post_id'=>17))}}"><span
                                                        class="text">Produtos e Serviços</span></a>
                                        </li>
                                    @endif
                                    @if(User::allowed('admin-site-pages-contact'))
                                        <li>
                                            <a href="{{URL::route('admin.pages',array('post_id'=>2))}}"><span
                                                        class="text">Contato</span></a>
                                        </li>
                                    @endif
                                    <li>
                                        <a href="{{URL::route('admin.pages',array('post_id'=>3))}}"><span class="text">Rodapé</span></a>
                                    </li>
                                </ul>
                                <!--/ END 2nd Level Menu -->
                            </li>
                        @endif
                        @if(User::allowed('admin-site-banner'))
                            <li class="@if(Route::currentRouteName() == 'admin.banner') active @endif">
                                <a href="javascript:void(0);" data-toggle="submenu" data-target="#banner"
                                   data-parent="#page">
                                    <span class="text">Banner</span>
                                    <span class="arrow"></span>
                                </a>
                                <!-- START 2nd Level Menu -->
                                <ul id="banner"
                                    class="submenu collapse @if(Route::currentRouteName() == 'admin.banner') in @endif">
                                    <li class="@if(strrpos(Request::url(), '/banner') && !strrpos(Request::url(), '/banner/')) active @endif">
                                        <a href="{{URL::route('admin.banner')}}"><span
                                                    class="text">Todos os Banners</span></a>
                                    </li>
                                    <li class="@if(strrpos(Request::url(), 'banner/0')) active @endif">
                                        <a href="{{URL::route('admin.banner',array('post_id'=>0,'action'=>'novo'))}}"><span
                                                    class="text">Novo Banner</span></a>
                                    </li>
                                </ul>
                                <!--/ END 2nd Level Menu -->
                            </li>
                        @endif
                        @if(User::allowed('admin-site-blog'))
                            <li class="@if(Route::currentRouteName() == 'admin.blog') active @endif">
                                <a href="javascript:void(0);" data-toggle="submenu" data-target="#blog"
                                   data-parent="#page">
                                    <span class="text">Blog</span>
                                    <span class="arrow"></span>
                                </a>
                                <!-- START 2nd Level Menu -->
                                <ul id="blog"
                                    class="submenu collapse  @if(Route::currentRouteName() == 'admin.blog' || Route::currentRouteName() == 'admin.terms') in @endif">
                                    <li class="@if(strrpos(Request::url(), 'admin/blog') && !strrpos(Request::url(), '/blog/')) active @endif">
                                        <a href="{{URL::route('admin.blog')}}"><span class="text">Todos os Posts</span></a>
                                    </li>
                                    <li class="@if(strrpos(Request::url(), 'blog/0/novo')) active @endif">
                                        <a href="{{URL::route('admin.blog',array('post_id'=>0,'action'=>'novo'))}}"><span
                                                    class="text">Novo Post</span></a>
                                    </li>
                                    <li class="@if(strrpos(Request::url(), '/categoria/0/blog') && !strrpos(Request::url(), 'categoria/0/blog/novo')) active @endif">
                                        <a href="{{URL::route('admin.terms',array('term_id'=>0,'taxonomy'=>'blog'))}}"><span
                                                    class="text">Categorias</span></a>
                                    </li>
                                    <li class="@if(strrpos(Request::url(), 'categoria/0/blog/novo')) active @endif">
                                        <a href="{{URL::route('admin.terms',array('term_id'=>0,'taxonomy'=>'blog','action'=>'novo'))}}"><span
                                                    class="text">Nova Categoria</span></a>
                                    </li>
                                </ul>
                                <!--/ END 2nd Level Menu -->
                            </li>
                        @endif
                        @if(User::allowed('admin-site-cases'))
                            <li class="@if(Route::currentRouteName() == 'admin.cases') active @endif">
                                <a href="javascript:void(0);" data-toggle="submenu" data-target="#cases"
                                   data-parent="#page">
                                    <span class="text">Cases</span>
                                    <span class="arrow"></span>
                                </a>
                                <!-- START 2nd Level Menu -->
                                <ul id="cases"
                                    class="submenu collapse  @if(Route::currentRouteName() == 'admin.cases') in @endif">
                                    <li>
                                        <a href="page-blog-default.html"><span class="text">Todos os Cases</span></a>
                                    </li>
                                    <li>
                                        <a href="page-blog-grid.html"><span class="text">Novo Case</span></a>
                                    </li>
                                    <li>
                                        <a href="page-blog-single.html"><span class="text">Categorias</span></a>
                                    </li>
                                </ul>
                                <!--/ END 2nd Level Menu -->
                            </li>
                        @endif
                        @if(User::allowed('admin-site-client'))
                            <li class="@if(Route::currentRouteName() == 'admin.client') active @endif">
                                <a href="javascript:void(0);" data-toggle="submenu" data-target="#client"
                                   data-parent="#page">
                                    <span class="text">Clientes</span>
                                    <span class="arrow"></span>
                                </a>
                                <!-- START 2nd Level Menu -->
                                <ul id="client"
                                    class="submenu collapse  @if(Route::currentRouteName() == 'admin.client') in @endif">
                                    <li class="@if(strrpos(Request::url(), 'admin/cliente') && !strrpos(Request::url(), 'admin/cliente/0')) active @endif">
                                        <a href="{{URL::route('admin.client')}}"><span
                                                    class="text">Todos os Clientes</span></a>
                                    </li>
                                    <li class="@if(strrpos(Request::url(), 'admin/cliente/0')) active @endif">
                                        <a href="{{URL::route('admin.client',array('post_id'=>0,'action'=>'novo'))}}"><span
                                                    class="text">Novo Cliente</span></a>
                                    </li>
                                </ul>
                                <!--/ END 2nd Level Menu -->
                            </li>
                        @endif
                        @if(User::allowed('admin-site-portfolio'))
                            <li class="@if(Route::currentRouteName() == 'admin.portfolio') active @endif">
                                <a href="javascript:void(0);" data-toggle="submenu" data-target="#portfolio"
                                   data-parent="#page">
                                    <span class="text">Portfólio</span>
                                    <span class="arrow"></span>
                                </a>
                                <!-- START 2nd Level Menu -->
                                <ul id="portfolio"
                                    class="submenu collapse  @if(Route::currentRouteName() == 'admin.portfolio') in @endif">
                                    <li>
                                        <a href="page-blog-default.html"><span
                                                    class="text">Todos os Porfólios</span></a>
                                    </li>
                                    <li>
                                        <a href="page-blog-grid.html"><span class="text">Novo Portfólio</span></a>
                                    </li>
                                    <li>
                                        <a href="page-blog-single.html"><span class="text">Categorias</span></a>
                                    </li>
                                </ul>
                                <!--/ END 2nd Level Menu -->
                            </li>
                        @endif
                        @if(User::allowed('admin-site-others'))
                            <li class="@if(Route::currentRouteName() == 'admin.other') active @endif">
                                <a href="javascript:void(0);" data-toggle="submenu" data-target="#outras"
                                   data-parent="#page">
                                    <span class="text">Outras</span>
                                    <span class="arrow"></span>
                                </a>
                                <!-- START 2nd Level Menu -->
                                <ul id="outras"
                                    class="submenu collapse  @if(Route::currentRouteName() == 'admin.other') in @endif">
                                    <li>
                                        <a href="page-blog-single.html"><span class="text">Copyright</span></a>
                                    </li>

                                </ul>
                                <!--/ END 2nd Level Menu -->
                            </li>
                        @endif
                        @if(User::allowed('admin-site-configs'))
                            <li class="@if(Route::currentRouteName() == 'admin.configs') active @endif">
                                <a href="{{URL::route('admin.configs')}}">
                                    <span class="text">Configurações</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                    <!--/ END 2nd Level Menu -->
                </li>
        @endif
        @if(User::allowed('admin-users'))
            <!-- Administração de Usuários -->
                <li class="@if(Route::is('admin.users')) active @endif">
                    <a href="javascript:void(0);" data-toggle="submenu" data-target="#users" data-parent=".topmenu">
                        <span class="figure"><i class="ico ico-group"></i></span>
                        <span class="text">Usuários</span>
                        <span class="arrow"></span>
                    </a>
                    <!-- START 2nd Level Menu -->
                    <ul id="users" class="submenu collapse @if(Route::is('admin.users')) in @endif">
                        <li class="@if(strrpos(Request::url(), 'admin/usuarios') && !strrpos(Request::url(), 'admin/usuarios/0')) active @endif">
                            <a href="{{URL::route('admin.users')}}">
                                <span class="text">Todos os Usuários</span>
                            </a>
                        </li>
                        <li class="@if(strrpos(Request::url(), 'admin/usuarios/0')) active @endif">
                            <a href="{{URL::route('admin.users',array('user_id'=>0,'action'=>'novo'))}}">
                                <span class="text">Novo Usuário</span>
                            </a>
                        </li>
                        @if(User::allowed('admin-users-groups'))
                            <li class="@if(strrpos(Request::url(), 'admin/permissoes')) active @endif">
                                <a href="{{URL::route('admin.groups')}}">
                                    <span class="text">Permissões</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                    <!--/ END 2nd Level Menu -->
                </li>
        @endif

        @if(User::allowed('route-admin.sensores.index'))
            <!-- Administração dos Sensores -->
                <li class="@if(Route::is('admin.sensores.*')) active @endif">
                    <a href="javascript:void(0);" data-toggle="submenu" data-target="#sensors" data-parent=".topmenu">
                        <span class="figure"><i class="ico ico-feed"></i></span>
                        <span class="text">Sensores</span>
                        <span class="arrow"></span>
                    </a>
                    <!-- START 2nd Level Menu -->
                    <ul id="sensors" class="submenu collapse @if(Route::is('admin.sensores.*')) in @endif">
                        <li class="@if(Route::is('admin.sensores.index')) active @endif">
                            <a href="{{route('admin.sensores.index')}}">
                                <span class="text">Todos os Sensores</span>
                            </a>
                        </li>
                        @if(User::allowed('route-admin.sensores.create'))
                            <li class="@if(Route::is('admin.sensores.create')) active @endif">
                                <a href="{{route('admin.sensores.create')}}">
                                    <span class="text">Novo Sensor</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                    <!--/ END 2nd Level Menu -->
                </li>
        @endif
        @if(User::allowed('route-admin.alertas.index'))
            <!-- Administração dos Alertas -->
                <li class="@if(Route::is('admin.alertas.*')) active @endif">
                    <a href="javascript:void(0);" data-toggle="submenu" data-target="#alerts" data-parent=".topmenu">
                        <span class="figure"><i class="fa fa-bell-o"></i></span>
                        <span class="text">Alertas</span>
                        <span class="arrow"></span>
                    </a>
                    <!-- START 2nd Level Menu -->
                    <ul id="alerts" class="submenu collapse @if(strrpos(Request::url(), 'alertas')) in @endif">
                        @if(Auth::user()->group_id == 1) {{--Admin--}}
                        <li class="@if(Route::is('admin.alertas.todos')) active @endif">
                            <a href="{{route('admin.alertas.todos')}}">
                                <span class="text">Todos Alertas</span>
                            </a>
                        </li>
                        @endif
                        @if(User::allowed('route-admin.alertas.index'))
                            <li class="@if(Route::is('admin.alertas.index')) active @endif">
                                <a href="{{route('admin.alertas.index')}}">
                                    <span class="text">Meus Alertas</span>
                                </a>
                            </li>
                        @endif
                        @if(User::allowed('route-admin.alertas.create'))
                            <li class="@if(Route::is('admin.alertas.create')) active @endif">
                                <a href="{{route('admin.alertas.create')}}">
                                    <span class="text">Novo Alerta</span>
                                </a>
                            </li>
                        @endif
                        <li class="@if(Route::is('admin.alertas.logs')) active @endif">
                            <a href="{{route('admin.notifications')}}">
                                <span class="text">Notificações</span>
                            </a>
                        </li>
                    </ul>
                    <!--/ END 2nd Level Menu -->
                </li>
            @endif
            @if(User::allowed('route-admin.reports.index'))
                <li class="@if(Route::currentRouteName() == 'admin.report-custom') active @endif">
                    <a href="javascript:void(0);" data-toggle="submenu" data-target="#report" data-parent=".topmenu">
                        <span class="figure"><i class="ico-stats-up"></i></span>
                        <span class="text">Relatórios</span>
                        <span class="arrow"></span>
                    </a>
                    <!-- START 2nd Level Menu -->
                    <ul id="report"
                        class="submenu collapse @if(Route::currentRouteName() == 'admin.report' || Route::currentRouteName() == 'admin.report-custom') in @endif">
                        @if(Auth::user()->group_id == 1) {{--Admin--}}
                        <li class="@if(strrpos(Request::url(), 'admin/relatorio-customizado/0/todos'))) active @endif">
                            <a href="{{URL::route('admin.report-custom',array('post_id' =>0, 'action'=>'todos'))}}">
                                <span class="text">Todos Relatórios</span>
                            </a>
                        </li>
                        @endif
                        @if(User::allowed('route-admin.reports.index'))
                            <li class="@if(strrpos(Request::url(), 'admin/relatorio-customizado') && !strrpos(Request::url(), 'todos') && !strrpos(Request::url(), 'novo') && !strrpos(Request::url(), 'manual')) active @endif">
                                <a href="{{URL::route('admin.report-custom')}}">
                                    <span class="text">Relatórios Agendados</span>
                                </a>
                            </li>
                        @endif
                        @if(User::allowed('route-admin.reports.create'))
                            <li class="@if(strrpos(Request::url(), 'admin/relatorio-customizado/0/novo')) active @endif">
                                <a href="{{URL::route('admin.report-custom',array('post_id' =>0, 'action'=>'novo'))}}">
                                    <span class="text">Agendar Relatório</span>
                                </a>
                            </li>
                        @endif
                        @if(User::allowed('route-admin.reports.manual'))
                            <li class="@if(strrpos(Request::url(), 'admin/relatorio-customizado/0/manual')) active @endif">
                                <a href="{{URL::route('admin.report-custom',array('post_id' =>0, 'action'=>'manual'))}}">
                                    <span class="text">Gerar Relatório</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                    <!--/ END 2nd Level Menu -->
                </li>
            @endif
            <li>
                <a target="_blank" href="http://medisom.com.br/categoria/biblioteca-de-conteudos">
                    <span class="figure"><i class="ico-book"></i></span>
                    <span class="text">Biblioteca de conteúdos </span>
                </a>
            </li>
        </ul>
        <!--/ END Template Navigation/Menu -->
    </section>
    <!--/ END Sidebar Container -->
</aside>