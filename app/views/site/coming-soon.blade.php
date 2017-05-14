<!DOCTYPE html>
<html lang="en">
<head>
    <title>Medisom</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0"/>
    <!-- CSS start here -->
{{ HTML::style('public/themes/coming_soon/css/bootstrap.min.css') }}
{{ HTML::style('public/themes/coming_soon/css/styles.css') }}
{{ HTML::style('public/themes/coming_soon/css/font-awesome.css') }}
<!-- CSS end here -->
    <!-- Google fonts start here -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
    <!-- Google fonts end here -->
</head>
<body class="tictoc">
<!-- Preloader start here -->
<div id="preloader">
    <div id="status"><img src="{{ asset('public/themes/'.Option::get('theme_site').'/image/logo/logo-220x100.png') }}"
                          alt="Medisom" style="
    margin-top: -45px;
"></div>
</div>
<!-- Preloader end here -->
<!-- Main container start here -->
<section class="container main-wrapper">
    <!-- Logo start here -->
    <section id="logo" class="fade-down">
        <a href="#" title="Medisom"><img
                    src="{{ asset('public/themes/'.Option::get('theme_site').'/image/logo/logo-220x100.png') }}"
                    alt="Medisom"></a>
    </section>
    <!-- Logo end here -->
    <!-- Slogan start here -->
    <section class="slogan fade-down">
        <p>"Não é possível gerir o que não se pode medir... e, se não se pode gerir, não se poderá melhorar" <br>
            <small>William Hewlett</small>
        </p>
    </section>
    <!-- Slogan end here -->
    <!-- Count Down start here -->
    <section class="count-down-wrapper fade-down">
        <ul class="row count-down">
            <li class="col-md-3 col-sm-6">
                <input class="knob days" data-readonly=true data-min="0" data-max="365" data-width="260"
                       data-height="260" data-thickness="0.07" data-fgcolor="#34aadc" data-bgColor="#e1e2e6"
                       data-angleOffset="180">
                <span id="days-title">dias</span>
            </li>
            <li class="col-md-3 col-sm-6">
                <input class="knob hour" data-readonly=true data-min="0" data-max="24" data-width="260"
                       data-height="260" data-thickness="0.07" data-fgcolor="#4cd964" data-bgColor="#e1e2e6"
                       data-angleOffset="180">
                <span id="hours-title">horas</span>
            </li>
            <li class="col-md-3 col-sm-6">
                <input class="knob minute" data-readonly=true data-min="0" data-max="60" data-width="260"
                       data-height="260" data-thickness="0.07" data-fgcolor="#ff9500" data-bgColor="#e1e2e6"
                       data-angleOffset="180">
                <span id="mins-title">minutos</span>
            </li>
            <li class="col-md-3 col-sm-6">
                <input class="knob second" data-readonly=true data-min="0" data-max="60" data-width="260"
                       data-height="260" data-thickness="0.07" data-fgcolor="#ff3b30" data-bgColor="#e1e2e6"
                       data-angleOffset="180">
                <span id="secs-title">segundos</span>
            </li>
        </ul>
    </section>
    <!-- Count Down end here -->

    <!-- Footer start here -->
    <footer class="fade-down">
        <p>&copy; 2015. Medisom</p>
    </footer>
    <!-- Footer end here -->
</section>

<!-- Main container start here -->
<!-- Javascript framework and plugins start here -->

{{ HTML::script('public/themes/coming_soon/js/jquery.js') }}
{{ HTML::script('public/themes/coming_soon/js/bootstrap.min.js') }}
{{ HTML::script('public/themes/coming_soon/js/jquery.validate.min.js') }}
{{ HTML::script('public/themes/coming_soon/js/modernizr.js') }}
{{ HTML::script('public/themes/coming_soon/js/appear.js') }}

<script type="text/javascript">
    $(window).load(function () {
        $('#status').fadeOut();
        $('#preloader').delay(350).fadeOut('slow');
        $('body').delay(350).css({'overflow': 'visible'});
        $(".count-down").ccountdown(2015, 03, 23, '16:30');
    })
</script>
{{ HTML::script('public/themes/coming_soon/js/jquery.knob.js') }}
{{ HTML::script('public/themes/coming_soon/js/jquery.ccountdown.js') }}
{{ HTML::script('public/themes/coming_soon/js/init.js') }}


<!-- Javascript framework and plugins end here -->
</body>
</html>