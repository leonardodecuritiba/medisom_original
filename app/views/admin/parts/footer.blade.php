<!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->
<!-- Application and vendor script : mandatory -->
<!--/ Application and vendor script : mandatory -->
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/selectize/js/selectize.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/parsley/js/pt-BR.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/parsley/js/parsley.js' )}}
<script type="text/javascript">
    window.ParsleyValidator.setLocale('pt-br');
</script>
{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/forms/validation.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/jquery-ui/js/jquery-ui.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/jquery-ui/js/addon/timepicker/jquery-ui-timepicker.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/jquery-ui/js/jquery-ui-touch.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/inputmask/js/inputmask.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/select2/js/select2.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/touchspin/js/jquery.bootstrap-touchspin.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/forms/element.js' )}}

{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/gritter/js/jquery.gritter.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/bootbox/js/bootbox.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/summernote/js/summernote.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/summernote/lang/summernote-pt-BR.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/forms/wysiwyg.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/jqueryTree/qubit.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/jqueryTree/jqueryTree.js' )}}

{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/charts/amcharts.def.js' )}}

@if(Route::currentRouteName() == 'admin.dashboard')
    {{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/charts/amcharts.widget.js' )}}
@endif

@if((Route::currentRouteName() == 'admin.report'))
    {{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/charts/amcharts.report.js' )}}
    {{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/dateformat/jquery-dateFormat.min.js' )}}
    {{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/charts/amcharts.details.js' )}}
    {{--                {{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/charts/amcharts.full.js' )}}--}}
@endif


@if((Route::currentRouteName() == 'ws') || (Route::currentRouteName() == 'teste.report'))
    {{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/dateformat/jquery-dateFormat.min.js' )}}
    {{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/charts/amcharts.report.js' )}}
@endif

@if((Route::currentRouteName() == 'login') || (Route::currentRouteName() == 'reminder'))
    {{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/pages/login.js' )}}
@endif

{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/backend/app.js' )}}
<!--/ END JAVASCRIPT SECTION -->



