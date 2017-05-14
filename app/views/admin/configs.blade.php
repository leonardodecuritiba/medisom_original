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

                <div class="row">
                    <div class="col-md-12">
                        <!-- Form Elements -->
                        <div class="panel panel-default">
                            <form action="{{URL::route('admin.configs')}}" enctype="multipart/form-data" method="post"
                                  name="form-configs" data-parsley-validate>
                                <div class="panel-body">
                                    <div class="row" style="padding: 10px;">


                                        <!-- Nav tabs -->
                                        <ul class="nav nav-tabs" role="tablist">
                                            @foreach($configs as $config)
                                                @if ($config->parent == 0)
                                                    <li class="@if($config->option_key == 'config_geral') active @endif">
                                                        <a href="#{{$config->option_key}}" role="tab"
                                                           data-toggle="tab">{{$config->option_value}}</a></li>
                                                @endif
                                            @endforeach
                                        </ul>

                                        <!-- Tab panes -->
                                        <div class="tab-content">
                                            <?php #print_r($configs); ?>
                                            @foreach($configs as $config)
                                            @if ($config->parent == 0)
                                            <?php $config_id = $config->option_id; ?>
                                            <div class="tab-pane @if($config->option_key == 'config_geral') active @endif"
                                                 id="{{$config->option_key}}">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th style="width: 30%">Nome</th>
                                                            <th style="width: 70%">Valor</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($configs as $config)
                                                            @if ($config->parent > 0 && $config_id == $config->parent)

                                                                <tr>
                                                                    <td>
                                                                        @if ( substr($config->option_key,0,11) != 'textareamod' && $config->parent == 13)
                                                                        @else
                                                                            {{ ucwords(str_replace(array('_','textareamod','textarea','text','image','cao','radio'),array(' ','','','','','ção',''),$config->option_key))}}
                                                                        @endif
                                                                        <input type="hidden" name="update[]"
                                                                               value="{{$config->option_id}}">
                                                                    </td>
                                                                    @if ( substr($config->option_key,0,5) == 'image' )
                                                                        <td>
                                                                            <div class="form-group">

                                                                                @if(isset($config->option_value))

                                                                                    <img src="{{ asset('public/uploads/'.$config->option_value) }}"
                                                                                         width="50" height="50"
                                                                                         class="pull-left">
                                                                                @endif
                                                                                <input name="{{$config->option_key}}"
                                                                                       type="file" class="form-control"
                                                                                       value="{{(isset($config->option_value))?$config->option_value:''}}"
                                                                                       style="width: 80%">

                                                                            </div>
                                                                        </td>
                                                                    @elseif ( substr($config->option_key,0,11) == 'textareamod' || (substr($config->option_key,0,4) == 'text' && $config->parent == 13))
                                                                        <td colspan="2">
                                                                            <div class="form-group">
                                                                                @if ( substr($config->option_key,0,11) == 'textareamod' )
                                                                                    <textarea
                                                                                            name="{{$config->option_key}}"
                                                                                            class="summernote ">
                                                                                                @if(isset($config->option_value)) {{$config->option_value}} @endif
                                                                                            </textarea>
                                                                                @else
                                                                                    <input name="{{$config->option_key}}"
                                                                                           type="text"
                                                                                           class="form-control"
                                                                                           value="{{(isset($config->option_value))?$config->option_value:''}}"
                                                                                           placeholder="Assunto:">
                                                                                @endif
                                                                            </div>
                                                                        </td>
                                                                    @elseif ( substr($config->option_key,0,8) == 'textarea' )
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <textarea name="{{$config->option_key}}"
                                                                                          class="form-control">{{(isset($config->option_value))?$config->option_value:''}}</textarea>

                                                                            </div>
                                                                        </td>
                                                                    @elseif ( substr($config->option_key,0,4) == 'text' && $config->parent != 13)
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <input name="{{$config->option_key}}"
                                                                                       type="text" class="form-control"
                                                                                       value="{{(isset($config->option_value))?$config->option_value:''}}">

                                                                            </div>
                                                                        </td>
                                                                    @elseif ( substr($config->option_key,0,5) == 'radio')
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <label class="">
                                                                                    <input {{($config->option_value==1)?'checked':''}} name="{{$config->option_key}}"
                                                                                           type="radio"
                                                                                           class="form-control"
                                                                                           value="1"> Sim
                                                                                </label>
                                                                                <label class="">
                                                                                    <input {{($config->option_value==0)?'checked':''}} name="{{$config->option_key}}"
                                                                                           type="radio"
                                                                                           class="form-control"
                                                                                           value="0"> Não
                                                                                </label>
                                                                            </div>
                                                                        </td>
                                                                    @endif

                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            @endif
                                            @endforeach
                                        </div>  <!-- Fim Tab panes -->


                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <button type="submit" class="btn btn-primary">Salvar</button>

                                </div>
                            </form>
                        </div>
                        <!-- End Form Elements -->
                    </div>
                </div>

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