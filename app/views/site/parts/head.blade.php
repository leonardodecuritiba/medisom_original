<!-- START STYLESHEETS -->
<link rel="apple-touch-icon-precomposed" sizes="144x144"
      href="{{ asset('public/themes/'.Option::get('theme_site').'/image/touch/apple-touch-icon-144x144-precomposed.png' )}}">
<link rel="apple-touch-icon-precomposed" sizes="114x114"
      href="{{ asset('public/themes/'.Option::get('theme_site').'/image/touch/apple-touch-icon-114x114-precomposed.png' )}}">
<link rel="apple-touch-icon-precomposed" sizes="72x72"
      href="{{ asset('public/themes/'.Option::get('theme_site').'/image/touch/apple-touch-icon-72x72-precomposed.png' )}}">
<link rel="apple-touch-icon-precomposed"
      href="{{ asset('public/themes/'.Option::get('theme_site').'/image/touch/apple-touch-icon-57x57-precomposed.png' )}}">
<link rel="shortcut icon" href="{{ asset('public/themes/'.Option::get('theme_site').'/image/icon-24x24.png' )}}">
<!--/ END META SECTION -->

<!-- Plugins stylesheet : optional -->
{{ HTML::style('public/themes/'.Option::get('theme_site').'/plugins/magnific/css/magnific.css') }}
{{ HTML::style('public/themes/'.Option::get('theme_site').'/plugins/owl/css/owl-carousel.css') }}
{{ HTML::style('public/themes/'.Option::get('theme_site').'/plugins/layerslider/css/layerslider.css') }}
<!--/ Plugins stylesheet : optional -->

<!-- Application stylesheet : mandatory -->
{{ HTML::style('public/themes/'.Option::get('theme_site').'/stylesheet/bootstrap.css') }}
{{ HTML::style('public/themes/'.Option::get('theme_site').'/stylesheet/layout.css') }}
{{ HTML::style('public/themes/'.Option::get('theme_site').'/stylesheet/uielement.css') }}
{{ HTML::style('public/themes/'.Option::get('theme_site').'/stylesheet/themes/layouts/fixed-header.css') }}
{{ HTML::style('public/themes/'.Option::get('theme_site').'/plugins/selectize/css/selectize.css' )}}
<!--/ Application stylesheet -->

<!-- modernizr script -->
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/modernizr/js/modernizr.js') }}
<!--/ modernizr script -->

<!-- END STYLESHEETS -->

@if(count($Ajax)>0)
    <script type="text/javascript"> {{ 'var Ajax = '}} {{$Ajax}} </script>
@endif

@if( Option::get('textarea_custom_scripts') )
    {{ Option::get('textarea_custom_scripts') }}
@endif