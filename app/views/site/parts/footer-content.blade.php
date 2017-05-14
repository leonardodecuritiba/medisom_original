<footer role="contentinfo" class="bgcolor-dark pt25">
    <!-- container -->
    <div class="container mb25">
        <!-- row -->
        <div class="row">
            <!-- About -->
            <div class="col-md-4">
                <h4 class="font-alt mt0">Sobre Nós</h4>
                <p>A MEDISOM se destaca como empresa de monitoramento e análise de ruídos</p>
                <p> por sua metodologia baseada em resultados.
                    A empresa utiliza as tecnologias mais avançadas do mercado para garantir
                    muita segurança e precisão em seus serviços.</p>
                <a href="{{URL::route('about')}}" class="text-primary">Leia Mais</a>
            </div>
            <div class="visible-sm visible-xs" style="margin-bottom:25px;"></div>
            <!--/ About -->
            <!-- Address + Social -->
            <div class="col-md-4"
                 style="background: url('{{ asset('public/themes/'.Option::get('theme_site').'/image/others/map-vector.png' )}}') no-repeat center center;background-size: 100%;">
                {{$rodape->content}}
            </div>
            <div class="visible-sm visible-xs" style="margin-bottom:25px;"></div>
            <!--/ Address + Social -->
            <!-- Newsletter -->
            <div class="col-md-4">
                <h4 class="font-alt mt0">Solicite um Orçamento</h4>
                <form role="form">
                    <div class="form-group">
                        <p class="form-control-static">Não perca tempo, solocite um orçamento agora mesmo!</p>
                    </div>
                    <a href="{{URL::route('orcamento')}}" class="btn btn-primary btn-block">Solicitar Orçamento</a>

                </form>
            </div>
            <!--/ Newsletter -->
        </div>
        <!--/ row -->
    </div>
    <!--/ container -->
    <!-- bottom footer -->
    <div class="footer-bottom pt15 pb15 bgcolor-dark bgcolor-dark-darken10">
        <!-- container -->
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <!-- copyright -->
                    <p class="nm text-muted">&copy; Copyright 2015 por <a href="javascript:void(0);" class="text-white">Medisom</a>.
                        Todos os direitos reservados.</p>
                    <!--/ copyright -->
                </div>
                <div class="col-sm-6 text-right hidden-xs hide">
                    <a href="javascript:void(0);" class="text-white">Politica de Privacidade</a>
                    <span class="ml5 mr5">&#8226;</span>
                    <a href="javascript:void(0);" class="text-white">Termos de Uso</a>
                </div>
            </div>
        </div>
        <!--/ container -->
    </div>
    <!--/ bottom footer -->
</footer>