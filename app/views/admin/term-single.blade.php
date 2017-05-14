<!DOCTYPE html>
<html class="backend">
<!-- START Head -->
<head>
    <!-- START META SECTION -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{$title}} | Medisom</title>
    <meta name="description" content="Medisom">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">


    @include('admin.parts.head')

</head>
<!--/ END Head -->

<!-- START Body -->
<body>
<!-- START Template Header -->
@include('admin.parts.navbar')
<!--/ END  START Template Header -->

<!--Template Sidebar (Left) -->
@include('admin.parts.sidebar')
<!--/ END Template Sidebar (Left) -->

<!-- START Template Main -->
<!-- START Template Main -->
<section id="main" role="main">
    <!-- START Template Container -->
    <div class="container-fluid">
        <!-- Page Header -->
    @include('admin.parts.page-header')
    <!-- Page Header -->

        <div class="row">
            <div class="col-md-12">
                <!-- START Panel -->
                <div class="panel panel-default">
                    <form action="@if(isset($term->term_id)) {{URL::route('admin.terms',array('term_id'=>$term->term_id))}} @else {{URL::route('admin.terms')}} @endif"
                          enctype="multipart/form-data" method="post" name="form-pages" data-parsley-validate>

                        <div class="panel-body">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="control-label">Nome <span class="text-danger">*</span></label>
                                        <input name="name" type="text" class="form-control" placeholder="Titulo"
                                               value="@if(isset($term->name)) {{$term->name}} @endif" required>
                                        @if(isset($term->term_id))
                                            <input name="term_id" type="hidden" class="form-control"
                                                   value="{{$term->term_id}}">
                                            <input name="term_taxonomy_id" type="hidden" class="form-control"
                                                   value="{{$term->term_taxonomy_id}}">
                                        @endif
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="control-label">Tipo <span class="text-danger">*</span></label>
                                        <select name="taxonomy" class="form-control" required>
                                            <option>Escolha um tipo de categoria</option>
                                            <option value="blog"
                                                    @if(isset($term->taxonomy) && $term->taxonomy =='blog') selected @endif>
                                                Blog
                                            </option>
                                            <option value="cases"
                                                    @if(isset($term->taxonomy) && $term->taxonomy =='cases') selected @endif>
                                                Cases
                                            </option>
                                            <option value="clientes"
                                                    @if(isset($term->taxonomy) && $term->taxonomy =='clientes') selected @endif>
                                                Clientes
                                            </option>
                                            <option value="portfolio"
                                                    @if(isset($term->taxonomy) && $term->taxonomy =='portfolio') selected @endif>
                                                Portfólio
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="control-label">Descriçao </label>
                                        <textarea name="description"
                                                  class="form-control">@if(isset($term->description)) {{$term->description}} @endif</textarea>
                                    </div>

                                </div>
                            </div>


                            <div class="panel-footer">
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            </div>
                    </form>
                </div>
                <!--/ END Panel -->
            </div>
        </div>

    </div>
    <!--/ END Template Container -->

    <!-- START To Top Scroller -->
    <a href="#" class="totop animation" data-toggle="waypoints totop" data-showanim="bounceIn" data-hideanim="bounceOut"
       data-offset="50%"><i class="ico-angle-up"></i></a>
    <!--/ END To Top Scroller -->
</section>
<!--/ END Template Main -->

<!-- START Template Footer -->
@include('admin.parts.footer')
<!--/ END Template Footer -->
</body>
<!--/ END Body -->
</html>