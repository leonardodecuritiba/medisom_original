<!-- START JAVASCRIPT SECTION (Load javascripts at bottom to reduce load time) -->
<!-- Application and vendor script : mandatory -->
{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/vendor.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/core.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/frontend/app.js' )}}
<!--/ Application and vendor script : mandatory -->

<!-- Plugins and page level script : optional -->
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/smoothscroll/js/smoothscroll.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/owl/js/owl.carousel.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/layerslider/js/greensock.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/layerslider/js/layerslider.transitions.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/layerslider/js/layerslider.kreaturamedia.jquery.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/frontend/home/home-v1.js' )}}

{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/magnific/js/jquery.magnific-popup.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/shuffle/js/jquery.shuffle.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/selectize/js/selectize.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/parsley/js/pt-BR.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/parsley/js/parsley.js' )}}
{{ HTML::script('public/themes/'.Option::get('theme_site').'/plugins/inputmask/js/inputmask.js' )}}
<script type="text/javascript">
    window.ParsleyValidator.setLocale('pt-br');
</script>
{{ HTML::script('public/themes/'.Option::get('theme_site').'/javascript/frontend/pages/blog.js' )}}
<!--/ Plugins and page level script : optional -->
<!--/ END JAVASCRIPT SECTION -->
