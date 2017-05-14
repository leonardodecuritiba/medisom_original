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
                    <form action="@if(isset($post->post_id)) {{URL::route('admin.blog',array('post_id'=>$post->post_id))}} @else {{URL::route('admin.blog')}} @endif"
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

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="control-label">Conteúdo <span class="text-danger">*</span></label>
                                        <!-- Summernote -->
                                        <textarea name="content"
                                                  class="summernote">@if(isset($post->content)) {{$post->content}} @endif</textarea>
                                        <!--/ Summernote -->
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="control-label">Resumo <span class="text-danger">*</span></label>
                                        <!-- Summernote -->
                                        <textarea name="expert"
                                                  class="summernote">@if(isset($post->expert)) {{$post->expert}} @endif</textarea>
                                        <!--/ Summernote -->
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="control-label">Categorias <span
                                                    class="text-danger">*</span></label><br>
                                        @foreach($categories as $category)
                                            <label class="checkbox-inline">
                                                <input type="checkbox" name="category[]"
                                                       value="{{$category->term_taxonomy_id}}"
                                                       @if(isset($post->post_id)) @if(Post::find($post->post_id)->terms($post->post_id,$category->term_taxonomy_id)) checked @endif @endif> {{$category->name}}
                                            </label>
                                        @endforeach

                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    @if(isset($post->post_id))
                                        @if(Post::find($post->post_id)->postmeta('image_default'))
                                            <div class="col-sm-12">
                                                <label class="control-label">Imagem</label>
                                            </div>
                                            <div class="col-sm-1">
                                                <div class="media-object">
                                                    <?php
                                                    $post_imagem = Post::find($post->post_id)->postmeta($post->post_id, 'image_default');
                                                    $url_imagem = ($post_imagem != '') ? $post_imagem : 'no_icon_red.png';
                                                    ?>
                                                    <img src="{{ asset('public/uploads/'. $url_imagem ) }}" width="30">
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-sm-11">

                                            <input type="file" class="form-control" name="image_default">
                                        </div>
                                    @else
                                        <div class="col-sm-12">
                                            <label class="control-label">Imagem</label>
                                            <input type="file" class="form-control" name="image_default">
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