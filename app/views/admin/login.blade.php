<!DOCTYPE html>
<html class="backend">
<!-- START Head -->
<head>
    <!-- START META SECTION -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login | Medisom</title>
    <meta name="description" content="Medisom">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">


    @include('admin.parts.head')

</head>
<!--/ END Head -->

<!-- START Body -->
<body>


<!-- START Template Main -->
<!-- START Template Main -->
<section id="main" role="main">
    <!-- START Template Container -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-4 col-lg-offset-4">
                <!-- Brand -->
                <div class="text-center" style="margin-bottom:40px;">
                    <span class="logo-text inverse"></span>

                </div>
                <!--/ Brand -->


                <hr><!-- horizontal line -->

                <!-- Login form -->
                <form class="panel" action="{{URL::route('login',array('action'=>'authorize'))}}" method="post"
                      name="form-login" id="form-login">
                    <div class="panel-body">

                    @if ( count($errors) > 0 )
                        <!-- Alert message -->
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $e)
                                    <span class="semibold">Erro :</span>&nbsp;&nbsp;{{ $e }} <br>
                                @endforeach
                            </div>
                            <!--/ Alert message -->
                    @else
                        <!-- Alert message -->
                            <div class="alert alert-warning">
                                       
                                        <span class="semibold">Faça Login

                            </div>
                            <!--/ Alert message -->
                        @endif


                        <div class="form-group">
                            <div class="form-stack has-icon pull-left">
                                <input name="email" type="text" class="form-control input-lg" placeholder="E-mail"
                                       data-parsley-errors-container="#error-container"
                                       data-parsley-error-message="Digite seu e-mail" data-parsley-required>
                                <i class="ico-user2 form-control-icon"></i>
                            </div>
                            <div class="form-stack has-icon pull-left">
                                <input name="password" type="password" class="form-control input-lg" placeholder="Senha"
                                       data-parsley-errors-container="#error-container"
                                       data-parsley-error-message="Digite sua senha" data-parsley-required>
                                <i class="ico-lock2 form-control-icon"></i>
                            </div>
                        </div>

                        <!-- Error container -->
                        <div id="error-container" class="mb15"></div>
                        <!--/ Error container -->

                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="checkbox custom-checkbox">
                                        <input type="checkbox" name="remember" id="remember" value="1">
                                        <label for="remember">&nbsp;&nbsp;Me Lembrar</label>
                                    </div>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <a href="{{URL::route('reminder')}}">Perdeu a senha?</a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group nm">
                            <button type="submit" class="btn btn-block btn-success"><span class="semibold">Entrar</span>
                            </button>
                        </div>
                    </div>
                </form>
                <!-- Login form -->
            </div>
        </div>
    </div>
    <!--/ END Template Container -->
</section>
<!--/ END Template Main -->
<!-- START Template Footer -->
@include('admin.parts.footer')
<!--/ END Template Footer -->
</body>
<!--/ END Body -->
</html>