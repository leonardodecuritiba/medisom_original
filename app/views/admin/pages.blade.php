<!DOCTYPE html>
<html class="backend">
<!-- START Head -->
<head>
    <!-- START META SECTION -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Administração de Páginas | Medisom</title>
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
                    <form action="{{URL::route('admin.pages',array('post_id'=>$post->post_id))}}" method="post"
                          name="form-pages">
                        <div class="panel-heading">
                            <h3 class="panel-title ellipsis"><i class="ico-pen4"></i> Administração - {{$post->title}}
                            </h3>
                        </div>
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
                                        <label class="control-label">Descrição </label>
                                        <!-- Summernote -->
                                        <textarea name="content"
                                                  class="summernote">@if(isset($post->content)) {{$post->content}} @endif</textarea>
                                        <!--/ Summernote -->
                                    </div>

                                </div>
                            </div>

                            @if($post->slug == 'services')
                                <hr>
                                <h3 class="panel-title ellipsis"><i class="ico-pen4"></i> Serviços <a
                                            href="javascript:;" class="btn btn-default more_services">+ Add</a> <a
                                            href="javascript:;" class="btn btn-default remove_services">- Remove</a>
                                </h3>
                                <hr>
                                @if(count($services) > 0)

                                    @foreach($services as $service)

                                        <div class="form-group services" id="services-1">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <label class="control-label">Título <span
                                                                class="text-danger">*</span></label>
                                                    <input name="services['title'][]" type="text" class="form-control"
                                                           placeholder="Site" value="{{$service->title}}" required>
                                                    <label class="control-label">Descrição <span
                                                                class="text-danger">*</span></label>
                                                    <textarea name="services['description'][]"
                                                              class="summernote">{{$service->description}}</textarea>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="form-group services" id="services-1">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label class="control-label">Título <span
                                                            class="text-danger">*</span></label>
                                                <input name="services['title'][]" type="text" class="form-control"
                                                       placeholder="Site" value="" required>
                                                <label class="control-label">Descrição <span
                                                            class="text-danger">*</span></label>
                                                <textarea name="services['description'][]"
                                                          class="summernote"></textarea>

                                            </div>

                                        </div>
                                        <hr>
                                    </div>
                                @endif

                            @endif


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