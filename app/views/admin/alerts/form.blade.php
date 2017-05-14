<style>
    .input-firulinha {
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

    .not_show {
        display: none;
    }
</style>
<input type="hidden" name="post_author" value="{{Auth::id()}}">
<!-- START Panel -->
<div class="panel panel-default">
    <div class="panel-body">
    <?php
    //            dd($Alert->tipo_alerta);
    //            print_r('<br><br>');

    $alert_type = isset($Alert->tipo_alerta) ? $Alert->tipo_alerta : '';
    $class_sensor_inactive = 'not_show';
    $class_sensor_value = 'not_show';
    $class_sensor_value_valor = 'not_show';
    $class_sensor_value_valores = 'not_show';
    $valor_sensor_inactive = 1;
    $valor_sensor_value = 1;
    $valor_sensor_values = ['minimo' => -10, 'maximo' => 10];
    $selected_sensor = $sensores[0]->post_id;
    $selected_indicador = '';
    $alert_condition = '';

    if ($action == 'novo') {
        $class_sensor_value = '';
        $class_sensor_value_valores = '';
    } else if ($action == 'editar') {
        $selected_sensor = $Alert->sensor_id;
        $selected_indicador = $Alert->indicador['valor'];
        switch ($alert_type) {
            case 2:
                $class_sensor_inactive = '';
                $valor_sensor_inactive = $Alert->condicao['tempo_inativo'];
                break;
            case 3:
                $class_sensor_value = '';
                $alert_condition = $Alert->condicao['condicao']['indice'];
//                        dd($alert_condition);
                if ($alert_condition >= 2) {
                    $valor_sensor_value = $Alert->condicao['valores'];
                    $class_sensor_value_valor = '';
                } else {
                    $valor_sensor_values = $Alert->condicao['valores'];
                    $class_sensor_value_valores = '';
                }
                break;
            default:
                $class_sensor_value = 'not_show';
                break;
        }
    }
    ?>
    <!--Dados do relatório-->
        <div class="form-group">
            <div class="col-md-4 col-sm-4 col-xs-12">
                <label for="report_status" class="control-label">Sensor <span class="text-danger">*</span></label>
                <select class="form-control" name="sensor_id" required>
                    @foreach ($sensores as $sensor)
                        <option value="{{$sensor->post_id}}"
                        >{{$sensor->title}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <label for="report" class="control-label">Tipo do Alerta<span class="text-danger">*</span></label>
                <select class="form-control" name="tipo_alerta" required>
                    @foreach ($TiposAlertas as $i => $tipo)
                        <option value="{{$i}}"
                                {{(($action=='novo') || ($alert_type == $i))
                                ? 'selected':''}}
                        >{{$tipo}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <label for="report" class="control-label">Nome do Alerta <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="nome"
                       value="{{($action=='editar')?$Alert->nome:''}}" required="required">
            </div>
        </div>

        <!--Dados SENSOR INATIVO-->
        <section data-tipo="2" class="{{$class_sensor_inactive}}">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <hr>
            </div>
            <div class="form-group">
                <div class="col-sm-12 col-md-12 col-xs-12 valor">
                    <label for="report" class="control-label">Tempo de inatividade (minutos): <span class="text-danger">*</span></label>
                    <input type="text" name="tempo_inativo" class="input-firulinha" readonly
                           value="{{$valor_sensor_inactive}}">
                    <div class="slider-green" id="tempo_inativo"></div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <hr>
            </div>
        </section>

        <!--Dados SENSOR VALORES-->
        <section data-tipo="3" class="{{$class_sensor_value}}">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <hr>
            </div>
            <!--Indicador-->
            <div class="form-group">
                <div class="col-md-9 col-sm-9 col-xs-9" id="graph-select">
                    <label for="report_status" class="control-label">Indicador <span
                                class="text-danger">*</span></label>
                    <select class="form-control" name="indicador" @if($alert_type == 3) required @endif>
                        <option value="">Escolha...</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <hr>
            </div>

            <!--Condição-->
            <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label for="report_status" class="control-label">Condição <span class="text-danger">*</span></label>
                    <select class="form-control" name="condicao" @if($alert_type == 3) required @endif>
                        @foreach($Condicoes as $key => $condicao){ ?>
                        <option value="{{$key}}"
                                @if($alert_condition == $key) selected @endif>{{$condicao}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-12 col-sm-12 col-xs-12 valores {{$class_sensor_value_valores}}">
                    <label for="report" class="control-label">Mínimo/Máximo: <span class="text-danger">*</span></label>
                    <input type="text" name="minimo" class="input-firulinha"> /
                    <input type="text" name="maximo" class="input-firulinha">
                    <div class="slider-green" id="valores"></div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 valor {{$class_sensor_value_valor}}">
                    <label for="report" class="control-label">Valor: <span class="text-danger">*</span></label>
                    <input type="text" name="valor" class="input-firulinha">
                    <div class="slider-green" id="valor"></div>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <hr>
            </div>
        </section>

        <!--Horários-->
        <section class="horarios">
            <div class="form-group">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <label for="report" class="control-label">Horário Inicial (ativação) <span
                                class="text-danger">*</span></label>
                    <input type="text" id="time-picker-from" class="form-control" name="horario_inicial"
                           value="{{($action=='editar')?$Alert->horario['horario_inicial']:'00:00'}}">
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <label for="report" class="control-label">Horário Final (ativação) <span
                                class="text-danger">*</span></label>
                    <input type="text" id="time-picker-to" class="form-control" name="horario_final"
                           value="{{($action=='editar')?$Alert->horario['horario_final']:'23:59'}}">
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label for="report" class="control-label">Dias da Semana <span
                                class="text-danger">*</span></label><br>
                    @foreach($DiasDaSemana as $key => $dia)
                        <label class="checkbox-inline">
                            <input name="horario_dias[]" type="checkbox" value="{{$key}}"
                                    {{(
                                        ($action=='novo') ||
                                        (
                                             ($action=='editar') &&
                                             ($Alert->horario['horario_dias']!=NULL) &&
                                             (in_array($key, $Alert->horario['horario_dias']))
                                         )
                                     )?'checked':''}}
                            > {{$dia}}
                        </label>
                    @endforeach
                </div>
            </div>
        </section>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <hr>
        </div>

        <!--Formas de envio-->
        <div class="form-group">
            <div class="col-sm-3 col-md-3">
                <label for="report" class="control-label">Enviar por Email</label>
                <label class="checkbox-inline">
                    <input name="envio_email" class="checks" type="checkbox" value="checked"
                           @if(($action=='editar') && ($Alert->envio_email==1)) checked @endif>
                </label>
            </div>
            <div class="col-sm-9 col-md-9">
                <label for="report_status" class="control-label">Emails adicionais</label>
                <input type="text" class="form-control" name="destinatarios_email"
                       placeholder="Emails adicionais separados com ponto e vírgula"
                       @if((($action=='editar') && ($Alert->envio_email==0)) || ($action=='novo')) disabled @endif
                       value="{{($action=='editar')?$Alert->get_destinatarios('email')->print:''}}">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-3 col-md-3">
                <label for="report" class="control-label">Enviar por SMS</label>
                <label class="checkbox-inline">
                    <input name="envio_sms" class="checks" type="checkbox"
                           value="checked"
                           @if(($action=='editar') && ($Alert->envio_sms==1)) checked @endif>
                </label>
            </div>
            <div class="col-sm-9 col-md-9">
                <label for="report_status" class="control-label">Celulares adicionais</label>
                <input type="text" class="form-control" name="destinatarios_sms"
                       placeholder="Celulares adicionais separados com ponto e vírgula"
                       @if((($action=='editar') && ($Alert->envio_sms==0)) || ($action=='novo')) disabled @endif
                       value="{{($action=='editar')?$Alert->get_destinatarios('sms')->print:''}}">
            </div>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <hr>
        </div>
        <div class="col-sm-12">
            @if($action=='editar')
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <label for="report" class="control-label"
                           data-toggle="popover"
                           data-trigger="hover"
                           data-placement="top"
                           data-content="Aqui você vê o número de alertas que foram emitidos hoje.">Número de alertas
                        emitidos hoje</label>
                    <p class="text-danger">{{$Alert->sensor->sensormeta->first()->alert_count}}</p>
                </div>
            @endif
            <button name="submit" type="submit" class="pull-right btn btn-default">Salvar Alerta</button>
        </div>
    </div>
</div>
<script>
    var $_INDICADORES_ = jQuery.parseJSON('{{json_encode($Indicadores)}}');
    var $_slider_valores = "div#valores";
    var $_slider_valor = "div#valor";
    var $_input_slider_valor_min = "input[name=minimo]";
    var $_input_slider_valor_max = "input[name=maximo]";
    var $_input_slider_valor = "input[name=valor]";

    //FUNÇÃO PARA RETORNAR APENAS OS INDICADORES DEFINIDOS NO SENSOR
    $(function () {
        var $SELECT_SENSOR = $('div.panel-default > div.panel-body > div.form-group select[name=sensor_id]').selectize();
        var $SELECT_INDICADOR = $('div.panel-default > div.panel-body > section select[name=indicador]').selectize();
        var $USER_SELECTED_INDICATOR = '{{$selected_indicador}}';

        $($SELECT_SENSOR).on('change', function () {
            console.log($_INDICADORES_);
            var $select = $($SELECT_INDICADOR)[0].selectize;
            var url_ = "{{url('get_only_indicadores_by_sensorid',['XX', 'single'])}}";
            url_ = url_.replace('XX', $(this).find(':selected').val());
            $select.clearOptions();
            $.ajax({
                url: url_,
                type: 'get',
                dataType: "json",
                error: function (xhr, textStatus) {
                    console.log('xhr-error: ' + xhr.responseText);
                    console.log('textStatus-error: ' + textStatus);
                },
                success: function (indicadores) {
                    $(indicadores).each(function (i, v) {
                        $select.addOption({
                            value: v,
                            text: $_INDICADORES_[v].nome
                        });
                    });
                    $select.refreshItems();
                    var selected_indicador = ($USER_SELECTED_INDICATOR == '') ? indicadores[0] : $USER_SELECTED_INDICATOR;
                    $select.setValue(selected_indicador, true);
                    $USER_SELECTED_INDICATOR = '';
                }
            });
        });
        //SETANDO O SENSOR
        var editar = 0;
        @if($action=='novo')
            $SELECT_SENSOR[0].selectize.setValue({{$sensores[0]->post_id}});
//            $($_input_slider_valor_min).attr('required',true);
//            $($_input_slider_valor_max).attr('required',true);
//            $($_input_slider_valor).attr('required',false);
        @elseif($action=='editar')
            editar = 1;
        $SELECT_SENSOR[0].selectize.setValue({{$selected_sensor}});
//            console.log($("select[name=condicao] option:selected").val());
//            if ($("select[name=condicao] option:selected").val() > 1) {
//                $($_input_slider_valor_min).attr('required',false);
//                $($_input_slider_valor_max).attr('required',false);
//                $($_input_slider_valor).attr('required',true);
//            } else {
//                $($_input_slider_valor_min).attr('required',true);
//                $($_input_slider_valor_max).attr('required',true);
//                $($_input_slider_valor).attr('required',false);
//            }
        @endif
        $($SELECT_INDICADOR).on('change', function () {
            var v = $(this).find(':selected').val();
            if (v != '') {
                console.log($_INDICADORES_[v]);
                if ($_INDICADORES_[v].tipo == 'float') {
                    $($_slider_valores).slider("option", "step", 0.1);
                    $($_slider_valor).slider("option", "step", 0.1);

                    $($_input_slider_valor_min).attr('step', 0.1);
                    $($_input_slider_valor_max).attr('step', 0.1);
                    $($_input_slider_valor).attr('step', 0.1);
                } else {
                    $($_slider_valores).slider("option", "step", 1);
                    $($_slider_valor).slider("option", "step", 1);

                    $($_input_slider_valor_min).attr('step', 1);
                    $($_input_slider_valor_max).attr('step', 1);
                    $($_input_slider_valor).attr('step', 1);
                }
                var v_min = $_INDICADORES_[v].faixa.min;
                var v_max = $_INDICADORES_[v].faixa.max;
                var v_value = parseInt((v_min + v_max) / 2);

                $($_slider_valores).slider("option", "min", v_min);
                $($_slider_valores).slider("option", "max", v_max);
                $($_slider_valor).slider("option", "min", v_min);
                $($_slider_valor).slider("option", "max", v_max);

                $($_input_slider_valor_min).attr('min', v_min);
                $($_input_slider_valor_min).attr('max', v_max);
                $($_input_slider_valor_max).attr('min', v_min);
                $($_input_slider_valor_max).attr('max', v_max);

                $($_input_slider_valor).attr('min', v_min);
                $($_input_slider_valor).attr('max', v_max);
                if(editar){
                    editar = 0;
                    if ($("select[name=condicao] option:selected").val() > 1) {
                        //MÚLTIPLOS VALORES
                        $($_slider_valores).slider("option", "values", [v_value - 1, v_value + 1]);
                        $($_input_slider_valor_min).val(v_value - 1);
                        $($_input_slider_valor_max).val(v_value + 1);
                    } else {
                        //ÚNICO VALOR
                        $($_slider_valor).slider("option", "value", v_value);
                        $($_input_slider_valor).val(v_value);
                    }
                } else {
                    $($_slider_valores).slider("option", "values", [v_value - 1, v_value + 1]);
                    $($_slider_valor).slider("option", "value", v_value);
                    $($_input_slider_valor_min).val(v_value - 1);
                    $($_input_slider_valor_max).val(v_value + 1);
                    $($_input_slider_valor).val(v_value);
                }

            }
        });
    });

    //FUNÇÃO PARA DEFINIR A BARRA DE ROLAGEM DA FAIXA DE VALORES
    $(function () {
        $($_slider_valores).slider({
            range: true,
            min: -100,
            max: 100,
            values: [{{$valor_sensor_values['minimo']}},{{$valor_sensor_values['maximo']}} ],
            slide: function (event, ui) {
                $(this).parents('div.valores').find('input[name=minimo]').val(ui.values[0]);
                $(this).parents('div.valores').find('input[name=maximo]').val(ui.values[1]);
            }
        });
        $($_input_slider_valor_min).val("{{$valor_sensor_values['minimo']}}");
        $($_input_slider_valor_max).val("{{$valor_sensor_values['maximo']}}");

    });

    //FUNÇÃO PARA DEFINIR A BARRA DE ROLAGEM DO VALOR
    $(function () {
        $($_slider_valor).slider({
            orientation: "horizontal",
//            min: -100,
//            max: 100,
            value: '{{$valor_sensor_value}}',
            slide: function (event, ui) {
//                $(this).prev().val(ui.value);
                $(this).parents('div.valor').find('input[name=valor]').val(ui.value);
            }
        });
        $($_input_slider_valor).val({{$valor_sensor_value}});
        $($_input_slider_valor).change(function () {
            $($_slider_valor).slider("value", $(this).val());
        });
    });

    //VALOR DE INATIVIDADE DO SENSOR
    $(function () {
        $("div#tempo_inativo").slider({
            orientation: "horizontal",
//            min: 1,
//            max: 240,
            value: '{{$valor_sensor_inactive}}',
            slide: function (event, ui) {
                $(this).prev().val(ui.value);
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        <!--Condição-->
        $('form').find("select[name=condicao]").change(function () {
            var v = $("select[name=condicao] option:selected").val();
            var $parent = $(this).parents('.form-group').next();
            $($parent).find('.valores').toggle(false);
            $($parent).find('.valor').toggle(false);
            console.log(v);
            if (v > 1) {
                $($parent).find('.valor').toggle(true);
            } else {
                $($parent).find('.valores').toggle(true);
            }
        });
    });
</script>
<script>
    $(document).ready(function () {
        $('input.checks').change(function () {
            if (this.checked) {
                $(this).parents('div.form-group').find('input[type="text"]').attr('disabled', false);
            } else {
                $(this).parents('div.form-group').find('input[type="text"]').attr('disabled', true);
            }
        });
    });
</script>

<script>
    //FUNÇÃO PARA RETORNAR APENAS O LAYOUT REFERENTE AO TIPO DE ALERTA
    $(function () {
        var $SELECT_TIPOS_ALERTAS = $('div.panel-default > div.panel-body > div.form-group select[name=tipo_alerta]').selectize();
        $($SELECT_TIPOS_ALERTAS).on('change', function () {
            var valor = $(this).find(':selected').val();
            var $parent = $(this).parents('div.panel-body');
            //fazer desaparecer o layout do tipo de alerta correspondente e inserir o required
            $($parent).find('section').hide();
            if (valor > 1) {
                //aparecer layout horários
                $($parent).find('section.horarios').toggle();
                //fazer aparecer o layout do tipo de alerta correspondente e inserir o required
                $parent = $($parent).find('section[data-tipo=' + valor + ']');
                $($parent).toggle();
            }
        });
    });
</script>