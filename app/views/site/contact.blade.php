<!DOCTYPE html>
<html class="frontend">
<!-- START Head -->
<head>
    <!-- START META SECTION -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Contato | Medisom</title>
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
                <h4 class="title">Contato</h4>
            </div>
            <div class="page-header-section">
                <!-- Toolbar -->
                <div class="toolbar">
                    <ol class="breadcrumb breadcrumb-transparent nm">
                        <li><a href="javascript:void(0);">Inicio</a></li>
                        <li class="active">Contato</li>
                    </ol>
                </div>
                <!--/ Toolbar -->
            </div>
        </div>
    </section>
    <div class="clearfix"></div>
    <!--/ END page header -->

    <!-- START Big Google Maps
    <section class="maps">
        <div id="gmaps-marker" style="height:360px;"></div>
    </section>
    END Big Google Maps -->

    <!-- START Contact Form + Infos -->
    <section class="section bgcolor-white">
        <div class="container">
            <!-- START Row -->
            <div class="row">

                <!-- START Left Section -->
                <div class="col-md-9">

                {{HTML::alert()}}

                <!-- Form -->
                    <h3 class="section-title font-alt mt0">Fale Conosco</h3>
                    <form action="{{URL::route('contact')}}" method="post" class="form-horizontal" role="form"
                          data-parsley-validate>
                        {{Form::token()}}
                        <div class="form-group">
                            <div class="col-sm-12">
                                <p class="form-control-static">Envie a sua dúvida ou sugestão, nós retornaremos o mais
                                    rápido possivel.</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label for="contact_name" class="control-label">Nome <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label for="contact_email" class="control-label">Email <span
                                            class="text-danger">*</span></label>
                                <input type="email" class="form-control" name="email" data-parsley-trigger="change"
                                       data-parsley-type="email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label for="contact_email" class="control-label">Mensagem <span
                                            class="text-danger">*</span></label>
                                <textarea class="form-control" rows="6" name="message" required></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar Mensagem</button>
                    </form>
                    <!--/ Form -->

                    <div class="mb15 visible-xs visible-sm"></div>
                </div>
                <!--/ END Left Section -->

                <!-- START Right Section -->
                <div class="col-md-3">
                    {{$post->content}}
                </div>
                <!--/ END Right Section -->
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