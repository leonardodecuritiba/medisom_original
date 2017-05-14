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

<!-- Application stylesheet : mandatory -->
{{ HTML::style('public/themes/'.Option::get('theme_site').'/stylesheet/bootstrap.css') }}
{{ HTML::style('public/themes/'.Option::get('theme_site').'/stylesheet/layout.css') }}
{{ HTML::style('public/themes/'.Option::get('theme_site').'/stylesheet/uielement.css') }}
<!--/ Application stylesheet -->
{{--{{ HTML::style('//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css' )}}--}}
{{--{{ HTML::script('https://use.fontawesome.com/bcf73a7020.js' )}}--}}
{{ HTML::style('public/themes/'.Option::get('theme_site').'/plugins/font-awesome-4.6.3/css/font-awesome.min.css') }}

{{ HTML::style('public/themes/'.Option::get('theme_site').'/plugins/selectize/css/selectize.css' )}}
{{ HTML::style('public/themes/'.Option::get('theme_site').'/plugins/jquery-ui/css/jquery-ui.css' )}}
{{ HTML::style('public/themes/'.Option::get('theme_site').'/plugins/select2/css/select2.css' )}}
{{ HTML::style('public/themes/'.Option::get('theme_site').'/plugins/touchspin/css/touchspin.css' )}}
{{ HTML::style('public/themes/'.Option::get('theme_site').'/plugins/gritter/css/gritter.css' )}}

{{ HTML::style('public/themes/'.Option::get('theme_site').'/plugins/summernote/css/summernote.css' )}}


<!-- modernizr script -->
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/modernizr/js/modernizr.js') }}
<!--/ modernizr script -->
{{ HTML::style('public/themes/'.Option::get('theme_site').'/stylesheet/custom.css') }}
<!-- END STYLESHEETS -->
{{ HTML::style('public/themes/'.Option::get('theme_site').'/plugins/amcharts/style.css' )}}

{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/vendor.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/core.js' )}}

{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/amcharts/amcharts.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/amcharts/serial.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/amcharts/amstock.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/amcharts/pie.js' )}}

{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/amcharts/plugins/export/export.js' )}}
{{ HTML::style('public/themes/'.Option::get('theme_site').'/plugins/amcharts/plugins/export/export.css' )}}



@if(count($Ajax)>0)
    <script type="text/javascript"> {{ 'var Ajax = '}} {{$Ajax}} </script>
@endif

@if( Option::get('textarea_custom_scripts') )
    {{ Option::get('textarea_custom_scripts') }}
@endif

