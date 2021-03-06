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

<style>
    .input-firulinha {
        border: 0;
        color: #f6931f;
        font-weight: bold;
    }

    .slider-green {
        width: 90%;
        margin: 15px;
    }

    .ui-slider {
        background-color: #CCC !important;
    }

    .slider-green .ui-slider-range {
        background: #75e208;
    }

    .slider-green .ui-slider-handle {
        border-color: #ef2929;
    }
</style>
<!-- START Template Main -->
<!-- START Template Main -->
<section id="main" role="main">
    <!-- START Template Container -->
    <div class="container-fluid">
        <!-- Page Header -->
    @include('admin.parts.page-header')
    <!-- Page Header -->

        <div class="row">
            @if(isset($sensor->post_id))
                {{ Form::open(['method' => 'PATCH',
                    'route'=>['admin.sensores.update',$sensor->post_id],
                    'data-parsley-validate']) }}
            @else
                {{ Form::open(['route' => 'admin.sensores.store',
                    'method' => 'POST',
                    'data-parsley-validate']) }}
            @endif
            <div class="col-md-12">
                <!-- START Panel -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">Cadastro de Sensores</h3>
                    </div>
                    <div class="panel-body">
                        <input type="hidden" name="type" value="sensor">
                        <input type="hidden" name="post_author"
                               value="{{(isset($sensor->post_author))?$sensor->post_author:0}}">
                        <input type="hidden" name="alert_num"
                               value="{{(isset($sensor->alert_num))?$sensor->alert_num:0}}">
                        <input type="hidden" name="alert_day"
                               value="{{(isset($sensor->alert_day))?$sensor->alert_day:00-00-0000}}">
                        <div class="form-group">
                            @if ( Auth::user()->group_id == 1)
                                <div class="col-sm-6">
                                    <label for="title" class="control-label">Nome do sensor <span
                                                class="text-danger">*</span></label>
                                    <input name="title" type="text" class="form-control"
                                           value="{{(isset($sensor->title))?$sensor->title:''}}" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="post_author" class="control-label">Usuário <span
                                                class="text-danger">*</span></label>
                                    @if (isset($authors))
                                        <select name="post_author" class="form-control" placeholder="Escolha ..."
                                                required>
                                            <option value="">Escolha...</option>
                                            @foreach($authors as $post_author)
                                                <option value="{{$post_author->user_id}}"
                                                        {{(isset($sensor->post_author) && ($sensor->post_author==$post_author->user_id))?'selected':''}}>{{$post_author->name}}</option>
                                            @endforeach
                                        </select>
                                    @else
                                        <p>{{(isset($user->name))?$user->name:''}} </p>
                                    @endif
                                </div>
                            @else
                                <div class="col-sm-6">
                                    <label for="title" class="control-label">Nome do sensor <span
                                                class="text-danger">*</span></label>
                                    <input name="title" type="text" class="form-control"
                                           value="{{(isset($sensor->title))?$sensor->title:''}}" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="title" class="control-label">Usuário <span
                                                class="text-danger">*</span></label>
                                    <p>{{(isset($user->name))?$user->name:''}} </p>
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <label for="measures" class="control-label">Indicadores <span
                                            class="text-danger">*</span></label>
                                <select name="measures[]" id="selectize-selectmultiple"
                                        class="form-control graph-select" placeholder="Escolha ..." multiple
                                        required>
                                    @foreach($Indicadores as $key => $indicador)
                                        <option value="{{$key}}"
                                                @if(isset($sensor->measures) && (in_array($key,$sensor->measures))) selected @endif>{{$indicador['nome'].' (' . $indicador['escala'] . ')'}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @if(isset($sensor->post_id))
                            <div class="form-group">
                                <div class="col-md-2 col-md-2 col-xs-12">
                                    <p class="control-label"
                                       data-toggle="popover"
                                       data-trigger="hover"
                                       data-placement="top"
                                       data-content="Esta é a hora em que o último alerta foi enviado para você!">
                                        Última atividade registada em: </p>
                                    <p class="text-danger">{{$sensor->last_alert}} </p>
                                </div>
                                <div class="col-md-2 col-md-2 col-xs-12">
                                    <p class="control-label"
                                       data-toggle="popover"
                                       data-trigger="hover"
                                       data-placement="top"
                                       data-content="Aqui você vê o número de alertas de inatividade que foram emitidos hoje.">
                                        Alertas emitidos hoje: </p>
                                    <p class="text-danger">{{$sensor->alert_num}} </p>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="panel-footer">
                        @if(isset($sensor->post_id))
                            <div class="pull-left">
                                @if(User::allowed('route-admin.sensores.clean'))
                                    <a class="btn btn-danger alert-confirm"
                                       data-href="{{route('admin.alertas.zerar',$sensor->post_id)}}"
                                       data-title="sensor"><i class="ico ico-trash"></i>Limpar dados do sensor</a>
                                @endif
                                @if(Auth::user()->is_admin() && isset($sensor->post_id))
                                    <a class="btn btn-default btn-teste">Testar Indicadores</a>
                                    <a class="btn btn-danger"
                                       href="{{URL::route('admin.alertas.zerar',array('user_id'=>$sensor->post_id))}}">Zerar
                                        Contador de Alertas</a>
                                @endif
                            </div>
                        @endif
                        <div class="pull-right">
                            @if((isset($sensor) && User::allowed('route-admin.sensores.update')) || (User::allowed('route-admin.sensores.create')))
                                <button type="submit" class="btn btn-primary">Salvar</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            {{ Form::close() }}
        </div>
        @if(Auth::user()->is_admin() && isset($sensor->post_id))
            <div class="row" style="display: none" id="teste">
                {{--'AdminController@test_sensor'--}}
                <form action="{{route('admin.sensores.test_sensor',$sensor->post_id)}}" method="post" id="form-sensors"
                      name="form-sensors">
                    <div class="col-md-12">
                        <!-- START Panel -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Teste dos Indicadores (Definido com últimos valores enviados
                                    pelo Sensor)</h3>
                            </div>
                            <div class="panel-body ">
                                {{Form::token()}}
                                @foreach($Indicadores as $indicador => $valores)
                                    <?php
                                    $valor = $sensor->last_sensormeta()->last_values->$indicador;
                                    $min = $valores['faixa']['min'];
                                    $max = $valores['faixa']['max'];
                                    ?>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="measures" class="control-label">
                                                {{$valores['nome']." (" . $valores['escala'] . ")"}}
                                                {{" (min:" .$min . ", max:" .$max . ")"}}
                                            </label>
                                            {{--<input name="{{$indicador}}" type="text" class="form-control">--}}
                                            <input type="text" name="{{$indicador}}" value="{{$valor}}" min="{{$min}}"
                                                   max="{{$max}}" class="input-firulinha">
                                            <div class="slider-green"></div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="measures" class="control-label">failover</label>
                                        <select name="failover" class="form-control" placeholder="Escolha ..." required>
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="measures" class="control-label">failenergy</label>
                                        <select name="failenergy" class="form-control" placeholder="Escolha ..."
                                                required>
                                            <option value="0">0</option>
                                            <option value="1">1</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="pull-right">
                                    <button type="submit" class="btn btn-success">Enviar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        @endif
        @if(isset($sensor->post_id))
            <?php
            $Dashboard = $sensor->dashboard->decodeMetaKey();
            $num_dashboards = count($Dashboard->values);
            ?>
            <div class="row">
                <div class="col-md-12">
                    <!-- START Panel -->
                    {{ Form::open(['method' => 'POST',
                        'route'=>['admin.sensores.dashboard',$sensor->post_id],
                        'data-parsley-validate']) }}
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Dashboard</h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-sm-12">
                                <label for="measures" class="control-label">Período <span
                                            class="text-danger">*</span></label>
                                <select name="dash_period" class="form-control"
                                        placeholder="Visualizar por...">
                                    @foreach($DashboardPeriods as $period)
                                        <option value="{{$period['code']}}"
                                                @if($Dashboard->period == $period['code']) selected @endif
                                        >{{$period['description']}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <hr>
                            </div>
                            @if($num_dashboards > 0)
                                @foreach($Dashboard->values as $measure_key => $measures)
                                    {{--                                    {{json_encode($measure)}}--}}
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="measures" class="control-label">Dashboard ({{$measure_key+1}})
                                                <span
                                                        class="text-danger">*</span></label>
                                            <select name="dash_measure[{{$measure_key}}][]"
                                                    id="selectize-selectmultiple"
                                                    class="form-control graph-select" placeholder="Escolha ..." multiple
                                                    required>
                                                @foreach($Indicadores as $key => $indicador)
                                                    <option value="{{$key}}"
                                                            @if(in_array($key, $measures)) selected @endif>{{$indicador['nome'].' (' . $indicador['escala'] . ')'}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="measures" class="control-label">Dashboard (1)<span
                                                    class="text-danger">*</span></label>
                                        <select name="dash_measure[0][]" id="selectize-selectmultiple"
                                                class="form-control graph-select" placeholder="Escolha ..." multiple
                                                required>
                                            @foreach($Indicadores as $indicador)
                                                <option value="{{$indicador['indice']}}">{{$indicador['impressao']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif
                            <script>
                                var IND = {{(isset($sensor->dashboard)) ? $num_dashboards : 1}};
                                $(document).ready(function () {
                                    $('a.btn-add').click(function () {
                                        var $parent = $(this).parents('div.panel-footer').prev();
                                        var form = '<div class="form-group"><div class="col-sm-12">' +
                                            '<label for="measures" class="control-label">Dashboard (' + (IND + 1) + ') <span class="text-danger">*</span></label>' +
                                            '<select name="dash_measure[' + IND + '][]" class="form-control graph-select" placeholder="Escolha ..." multiple required>' +
                                            '<option value="">Selecione</option>';
                                        @foreach($Indicadores as $key => $indicador)
                                            form += '<option value="{{$key}}">{{$indicador['nome'].' (' . $indicador['escala'] . ')'}}</option>';
                                        @endforeach
                                            form += '</select></div></div>';
                                        $($parent).append(form);

                                        $($parent).find('div.form-group').last().find('select').selectize();
                                        IND++;
                                    })
                                    $('a.btn-rem').click(function () {
                                        if (IND > 1) {
                                            IND--;
                                            var $parent = $(this).parents('div.panel-footer').prev();
                                            $($parent).find('div.form-group').last().remove();
                                        }
                                    })
                                })
                            </script>
                        </div>
                        <div class="panel-footer">
                            <div class="pull-left">
                                <a class="btn btn-danger btn-rem"><i class="fa fa-minus"></i> Remover</a>
                                <a class="btn btn-primary btn-add"><i class="fa fa-plus"></i> Adicionar</a>
                            </div>
                            <div class="pull-right">
                                <button class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>
                            </div>
                        </div>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        @endif
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
<script>
    $(document).ready(function () {
        $('a.btn-teste').click(function () {
            $(this).parents('div.row').siblings('div#teste').toggle();
        });
    });
    $(document).ready(function () {
        $('[data-toggle="popover"]').popover();
    });
</script>
<script>
    $(function () {
        $(".slider-green").slider({
            orientation: "horizontal",
            min: 0,
            max: 600,
            value: 0,
            slide: function (event, ui) {
                $(this).siblings('input.input-firulinha').val(ui.value);
            }
        });
        $(".slider-green").each(function (i, v) {

            var $_input_slider_valor = $(this).siblings('input.input-firulinha');

            var v_min = parseInt($($_input_slider_valor).attr('min'));
            var v_max = parseInt($($_input_slider_valor).attr('max'));
            var v_value = $($_input_slider_valor).val();
            v_value = (v_value == "") ? parseInt((v_min + v_max) / 2) : v_value;

            $(this).slider("option", "min", v_min);
            $(this).slider("option", "max", v_max);
            $(this).slider("option", "max", v_max);
            $(this).slider("option", "value", v_value);
            $($_input_slider_valor).val(v_value);
        })
    });
</script>
</body>
<!--/ END Body -->
</html>