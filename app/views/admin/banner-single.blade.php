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
                    <form action="@if(isset($post->post_id)) {{URL::route('admin.banner',array('post_id'=>$post->post_id))}} @else {{URL::route('admin.banner')}} @endif"
                          enctype="multipart/form-data" method="post" name="form-pages" data-parsley-validate>

                        <div class="panel-body">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="control-label">Título <span class="text-danger">*</span></label>
                                        <input name="title" type="text" class="form-control" placeholder="Titulo"
                                               value="@if(isset($post->title)) {{$post->title}} @endif" required>
                                        @if(isset($post->post_id))
                                            <input name="post_id" type="hidden" class="form-control"
                                                   value="{{$post->post_id}}">
                                        @endif
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="control-label">Texto 1 </label>
                                        <textarea name="text_1"
                                                  class="form-control">@if(isset($postmeta->text_1))  {{$postmeta->text_1}} @endif</textarea>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="control-label">Texto 2 </label>
                                        <textarea name="text_2"
                                                  class="form-control">@if(isset($postmeta->text_2))  {{$postmeta->text_2}} @endif</textarea>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="control-label">Botão Texto</label>
                                        <input name="text_button" class="form-control"
                                               value="@if(isset($postmeta->text_button))  {{$postmeta->text_button}} @endif">
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="control-label">Botão Link</label>
                                        <input name="link_button" class="form-control"
                                               value="@if(isset($postmeta->link_button))  {{$postmeta->link_button}} @endif">
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="control-label">Alinhamento</label>
                                        <select name="align">
                                            <option value="r"
                                                    @if(isset($postmeta->align) && $postmeta->align == 'r') selected @endif>
                                                Direita
                                            </option>
                                            <option value="l"
                                                    @if(isset($postmeta->align) && $postmeta->align == 'l') selected @endif>
                                                Esquerda
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group">
                                <div class="row">
                                    @if(isset($post->post_id))
                                        @if(isset($postmeta->image_background))
                                            <div class="col-sm-12">
                                                <label class="control-label">Imagem de Fundo</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="media-object">
                                                    <img src="{{ asset('public/uploads/'. $postmeta->image_background ) }}"
                                                         width="50" alt="" class="">
                                                </div>
                                            </div>

                                        @endif
                                        <div class="col-sm-11">
                                            <input type="file" class="form-control" name="image_background">
                                        </div>
                                        @if(isset($postmeta->image_1))
                                            <div class="col-sm-12">
                                                <label class="control-label">Imagem Sobreposta</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="media-object">
                                                    <img src="{{ asset('public/uploads/'. $postmeta->image_1 ) }}"
                                                         width="50" alt="" class="">
                                                </div>
                                            </div>

                                        @endif
                                        <div class="col-sm-11">
                                            <input type="file" class="form-control" name="image_1">
                                        </div>
                                    @else
                                        <div class="col-sm-12">
                                            <label class="control-label">Imagem de Fundo</label>
                                            <input type="file" class="form-control" name="image_1">
                                        </div>
                                        <div class="col-sm-12">
                                            <label class="control-label">Imagem Sobreposta</label>
                                            <input type="file" class="form-control" name="image_1">
                                        </div>
                                    @endif
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