<?php
if (Auth::user()->group_id == 1) {
    $alerts = json_decode(Option::get('log_alert_all'));
} else {
    $alerts = json_decode(Option::get('log_alert_' . Auth::id()));
}
$alert_count = 0;
if (count($alerts)) {
    foreach ($alerts as $alert) {
        if (!$alert->read) {
            $alert_count++;
        }
    }
}
?>
<header id="header" class="navbar">
    <!-- START navbar header -->
    <div class="navbar-header">
        <!-- Brand -->
        <a class="navbar-brand" href="javascript:void(0);">
            <span class="logo-figure hide"></span>
            <span class="logo-text"></span>
        </a>
        <!--/ Brand -->
    </div>
    <!--/ END navbar header -->
    <!-- START Toolbar -->
    <div class="navbar-toolbar clearfix">
        <!-- START Left nav -->
        <ul class="nav navbar-nav navbar-left">
            <!-- Sidebar shrink -->
            <li class="hidden-xs hidden-sm">
                <a href="javascript:void(0);" class="sidebar-minimize" data-toggle="minimize" title="Minimize sidebar">
                    <span class="meta">
                        <span class="icon"></span>
                    </span>
                </a>
            </li>
            <li class=" custom " id="header-dd-notification">
                <a href="{{URL::route('admin.alertas.logs')}}">
                    <span class="meta">
                        <span class="icon"><i class="ico-bell"></i></span>
                        <span class="hasnotification hasnotification-danger label ">{{$alert_count}}</span>
                    </span>
                </a>
            </li>
            @if(User::allowed('admin-site-configs'))
                <li class=" custom " id="header-dd-notification">
                    <a href="javascript:;" class="" title="Saldo de SMS disponível">
                        <span class="meta">
                            <span class="icon"><i class="ico-mobile"></i></span>
                            <span class="hasnotification hasnotification-danger label "><?php echo Option::get('smsapi_saldo') ?></span>
                        </span>
                    </a>
                </li>
        @endif
        <!--/ Sidebar shrink -->
            <!-- Offcanvas left: This menu will take position at the top of template header (mobile only). Make sure that only #header have the `position: relative`, or it may cause unwanted behavior -->
            <li class="navbar-main hidden-lg hidden-md hidden-sm">
                <a href="javascript:void(0);" data-toggle="sidebar" data-direction="ltr" rel="tooltip"
                   title="Menu sidebar">
                    <span class="meta">
                        <span class="icon"><i class="ico-paragraph-justify3"></i></span>
                    </span>
                </a>
            </li>
            <!--/ Offcanvas left -->
        </ul>
        <!--/ END Left nav -->
        <!-- START navbar form -->
        <div class="navbar-form navbar-left dropdown" id="dropdown-form">
            <form action="" role="search">
                <div class="has-icon">
                    <input type="text" class="form-control" placeholder="Search application...">
                    <i class="ico-search form-control-icon"></i>
                </div>
            </form>
        </div>
        <!-- START navbar form -->
        <!-- START Right nav -->
        <ul class="nav navbar-nav navbar-right">
            <!-- Profile dropdown -->
            <li class="dropdown profile">
                <a href="javascript:void(0);" class="dropdown-toggle dropdown-hover" data-toggle="dropdown">
                    <span class="meta">
                        <span class="avatar"><img
                                    src="{{ (Auth::user()->usermeta(Auth::user()->user_id,'avatar'))? asset('public/uploads/'.Auth::user()->usermeta(Auth::user()->user_id,'avatar')) : asset('public/uploads/avatar.png') }}"
                                    class="img-circle" alt=""/></span>
                        <span class="text hidden-xs hidden-sm pl5">{{Auth::user()->name}}</span>
                        <span class="caret"></span>
                    </span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li><a href="{{URL::route('admin.users',array('user_id'=>Auth::user()->user_id))}}"><span
                                    class="icon"><i class="ico-user-plus2"></i></span> Minha Conta</a></li>
                    <li class="divider"></li>
                    <li><a href="{{URL::route('admin.logout')}}"><span class="icon"><i class="ico-exit"></i></span> Sair</a>
                    </li>
                </ul>
            </li>
            <!-- Profile dropdown -->

        </ul>
        <!--/ END Right nav -->
    </div>
    <!--/ END Toolbar -->
</header>