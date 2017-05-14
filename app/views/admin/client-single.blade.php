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
                    <form action="@if(isset($post->post_id)) {{URL::route('admin.client',array('post_id'=>$post->post_id))}} @else {{URL::route('admin.client')}} @endif"
                          enctype="multipart/form-data" method="post" name="form-pages" data-parsley-validate>

                        <div class="panel-body">

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="control-label">Nome <span class="text-danger">*</span></label>
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
                                        <label class="control-label">Site <span class="text-danger">*</span></label>
                                        @if(isset($post->post_id))

                                            <input name="site" type="text" class="form-control" placeholder="Site"
                                                   value="{{Post::find($post->post_id)->postmeta($post->post_id,'site')}}"
                                                   required>
                                        @else
                                            <input name="site" type="text" class="form-control" placeholder="Site"
                                                   value="" required>
                                        @endif
                                    </div>

                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label class="control-label">Descrição </label>
                                        <!-- Summernote -->
                                        <textarea name="content"
                                                  class="summernote">@if(isset($post->content)) {{$post->content}} @endif</textarea>
                                        <!--/ Summernote -->
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
                                                    <img src="{{ asset('public/uploads/'. Post::find($post->post_id)->postmeta($post->post_id,'image_default') ) }}"
                                                         width="50" alt="" class="">
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