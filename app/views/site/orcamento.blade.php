<!DOCTYPE html>
<html class="frontend">
<!-- START Head -->
<head>
    <!-- START META SECTION -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$title}} | Medisom</title>
    <meta name="description" content="Medisom">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">


    @include('site.parts.head')

</head>
<!--/ END Head -->

<!-- START Body -->
<body>
<!-- START Template Header -->
@include('site.parts.navbar')

<!-- START Template Main -->
<section id="main" role="main">
    <!-- START page header -->
    <section class="page-header page-header-block nm">
        <!-- pattern -->
        <div class="pattern pattern9"></div>
        <!--/ pattern -->
        <div class="container pt15 pb15">
            <div class="page-header-section">
                <h4 class="title">{{$title}}</h4>
            </div>
            <div class="page-header-section">
                <!-- Toolbar -->
                <div class="toolbar">
                    <ol class="breadcrumb breadcrumb-transparent nm">
                        <li><a href="javascript:void(0);">Inicio</a></li>
                        <li class="active">{{$title}}</li>
                    </ol>
                </div>
                <!--/ Toolbar -->
            </div>
        </div>
    </section>
    <div class="clearfix"></div>
    <!--/ END page header -->

    <!-- START Contact Form + Infos -->
    <section class="section bgcolor-white">
        <div class="container">
            <!-- START Row -->
            <div class="row">

                <!-- START Left Section -->
                <div class="col-md-12">

                {{HTML::alert()}}

                <!-- Form -->
                    <h3 class="section-title font-alt mt0">Solicitar Orcamento</h3>

                    <form action="{{URL::route('orcamento')}}" method="post" id="form-orcamento" class="form-horizontal"
                          role="form" enctype="multipart/form-data" data-parsley-validate>

                        {{Form::token()}}
                        <input type="hidden" name="type" value="orcamento">

                        <div class="form-group">
                            <div class="col-sm-12">
                                <p class="form-control-static">Preencha o formulário abaixo.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label class="radio-inline">
                                    <input name="pessoa_tipo" type="radio" value="Pessoa Física" checked="">Pessoa
                                    Física
                                </label>
                                <label class="radio-inline">
                                    <input name="pessoa_tipo" type="radio" value="Pessoa Jurídica">Pessoa Jurídica
                                </label>
                            </div>
                        </div>
                        <div id="dataform">

                        </div>
                    </form>
                    <!--/ Form -->

                    <div class="mb15 visible-xs visible-sm"></div>
                </div>
                <!--/ END Left Section -->


            </div>
            <!--/ END Row -->
        </div>
    </section>
    <!--/ END Contact Form + Infos -->

    <!-- START To Top Scroller -->
    <a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut"
       data-offset="50%"><i class="ico-angle-up"></i></a>
    <!--/ END To Top Scroller -->
</section>
<!--/ END Template Main -->

<!-- START Template Footer -->
@include('site.parts.footer-content')
<!--/ END Template Footer -->

@include('site.parts.footer')
</body>
<!--/ END Body -->
</html>