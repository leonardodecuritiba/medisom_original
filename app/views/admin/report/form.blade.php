<input type="hidden" name="post_id" value="{{$post_id}}">
<input type="hidden" name="post_author" value="{{Auth::id()}}">
<input type="hidden" name="type" value="report">
<input type="hidden" name="slug" value="">
<input type="hidden" name="url" value="">
<input type="hidden" name="action" value="update_or_insert">
<input type="hidden" name="method" value="Post">
<!-- START Panel -->

<?php
if ($action == 'novo') {
    $selected_sensor = '';
    $selected_indicadores = '';
} else if ($action == 'editar') {
    $selected_sensor = $report->sensor_post_id;
    $selected_indicadores = $report->content;
}
?>

<div class="panel panel-default">
    <div class="panel-body">
        <!--Dados do relatório-->
        <div class="form-group">
            <div class="col-sm-4">
                <label for="report" class="control-label">Nome do relatório <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="title" value="{{isset($report)?$report->title:''}}"
                       required>
            </div>
            <div class="col-sm-4">
                <label for="report_status" class="control-label">Sensor <span class="text-danger">*</span></label>
                <select class="form-control" name="sensor_post_id" required>
                    <?php foreach ($sensores as $sensor) { ?>
                    <option value="{{$sensor->post_id}}" {{(isset($report) && ($report->sensor_post_id == $sensor->post_id))?'selected':''}}>{{$sensor->title}}</option>
                    <?php }?>
                </select>
            </div>
            <div class="col-sm-4" id="graph-select">
                <label for="report_status" class="control-label">Indicadores <span class="text-danger">*</span></label>
                <select id="selectize-selectmultiple" class="form-control graph-select" name="measures[]"
                        placeholder="Escolha ..." multiple required="required">
                    <option value="">Escolha...</option>
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <!--Emails do relatório-->
        <div class="form-group">
            <div class="col-sm-2">
                <label for="report" class="control-label">Email principal</label>
                <input type="text" class="form-control" name="email" value="{{Auth::user()->email}}" disabled>
            </div>
            <div class="col-sm-10">
                <label for="report_status" class="control-label">Destinatários</label>
                <input type="text" class="form-control" name="destinatarios"
                       placeholder="Separe os emails com ponto e vírgula"
                       value="{{(isset($report) && ($report->destinatarios != ''))?implode(';',$report->destinatarios):''}}">
            </div>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <!--Repetição-->
        <div class="form-group">
            <div class="col-sm-2">
                <label for="alert_type" class="control-label">Repetir a execução <span
                            class="text-danger">*</span></label><br>
                <?php $key = isset($report) ? key($report_postmeta->report_exe_repetition) : ""; ?>
                <select name="report_exe_repetition" class="form-control" required>
                    <option @if((isset($report)) && ($key == "mensalmente")) selected @endif value="mensalmente">Repetir
                        mensalmente
                    </option>
                    <option @if((isset($report)) && ($key == "semanalmente")) selected @endif value="semanalmente">
                        Repetir semanalmente
                    </option>
                    <option @if((isset($report)) && ($key == "diariamente")) selected @endif value="diariamente">Repetir
                        diariamente
                    </option>
                </select>
            </div>
            <div class="col-sm-3 report_specific_repetition @if(($key != "") && ($key != "mensalmente")) hide @endif"
                 id="mensalmente">
                <label for="report" class="control-label">Todos os meses, no mesmo horário, no dia <span
                            class="text-danger">*</span></label>
                <select name="report_exe_options[mensalmente]" class="form-control">
                    @for($i=1;$i<=28;$i++)
                        <option value="{{$i}}"
                                @if((isset($report)) && ($report_postmeta->report_exe_repetition->$key == $i)) selected @endif>{{$i}}</option>
                    @endfor
                </select>
            </div>
            <div class="col-sm-10 report_specific_repetition @if($key != "semanalmente") hide @endif" id="semanalmente">
                <label for="report" class="control-label">Todas as semanas, no mesmo horário, no(s) dia(s) <span
                            class="text-danger">*</span></label><br>
                @foreach($dias as $key_dia => $dia)
                    <label class="radio-inline">
                        <input name="report_exe_options[semanalmente]" type="radio" value="{{$key_dia}}"
                        <?php
                                if (isset($report) && ($key == 'semanalmente') && ($report_postmeta->report_exe_repetition->$key == $key_dia)) {
                                    echo 'checked';
                                } else if ($key_dia == 0) {
                                    echo 'checked';
                                }
                                ?>
                        > {{$dia}}
                    </label>
                @endforeach
            </div>
            <div class="col-sm-3 report_specific_repetition @if($key != "diariamente") hide @endif" id="diariamente">
                <?php
                if ($key == 'diariamente' && isset($report_postmeta->report_exe_repetition)) {
                    $opcao = $report_postmeta->report_exe_repetition->$key;
                }
                ?>
                {{--<div class="col-sm-3">--}}
                {{--<label for="report" class="control-label">Hora de execução <span class="text-danger">*</span></label>--}}
                {{--<input name="report_exe_options[time_execution]" type="text" id="time-picker1" class="form-control" value="{{(isset($report) && ($key=='diariamente'))?$opcao['time_execution']:'00:00'}}">--}}
                {{--</div>--}}
                <label for="report" class="control-label">Resolução <span class="text-danger">*</span></label>
                <select name="report_exe_options[resolution]" class="form-control" required>
                    <option @if((isset($report)) && ($key == "diariamente") && ($opcao['resolution'] == "minuto")) selected
                            @endif value="minuto">Por minuto
                    </option>
                    <option @if((isset($report)) && ($key == "diariamente") && ($opcao['resolution'] == "hora")) selected
                            @endif value="hora">Por hora
                    </option>
                    <option @if((isset($report)) && ($key == "diariamente") && ($opcao['resolution'] == "intervalo")) selected
                            @endif value="intervalo">Por intervalo
                    </option>
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <!--Intervalo-->
        <div class="form-group">
            <div class="col-sm-2 @if($key == "diariamente") hide @endif" id="div_pai_interval">
                <label for="report" class="control-label">Intervalo <span class="text-danger">*</span></label>
                <?php $key = isset($report) ? key($report_postmeta->report_exe_interval) : ""; ?>
                <select class="form-control" name="report_exe_interval" id="report_interval">
                    <option @if((isset($report)) && ($key == 'diário')) selected @endif value="diário">Diário</option>
                    {{--<option @if((isset($report)) && ($key == 'semanal')) selected @endif value="semanal">Semanal</option>--}}
                </select>
            </div>
            <div class="col-sm-2">
                <label for="report" class="control-label">Horário Inicio <span class="text-danger">*</span></label>
                <input type="text" id="time-picker-from" class="form-control" name="report_exe_interval_hora[ini]"
                       value="{{isset($report)?$report->report_exe_interval->$key->ini:'00:00'}}">
            </div>
            <div class="col-sm-2">
                <label for="report" class="control-label">Horário Fim (execução) <span
                            class="text-danger">*</span></label>
                <input type="text" id="time-picker-to" class="form-control" name="report_exe_interval_hora[fim]"
                       value="{{isset($report)?$report->report_exe_interval->$key->fim:'23:59'}}">
            </div>
            {{--<div class="col-sm-10 report_specific_repetition_XXXXX hide">--}}
            {{--<label for="report" class="control-label">Todas as semanas, no mesmo horário, no(s) dia(s) <span class="text-danger">*</span></label><br>--}}
            {{--@foreach($dias as $key => $dia)--}}
            {{--<label class="radio-inline">--}}
            {{--<input name="report_repetition_date" type="radio" value="{{$dia}}" {{$key==0?'checked':''}}> {{$dia}}--}}
            {{--</label>--}}
            {{--@endforeach--}}
            {{--</div>--}}
        </div>
        <div class="col-md-12">
            <hr>
        </div>
        <div class="col-sm-12">
            @if((isset($report) && User::allowed('route-admin.reports.update')) || (User::allowed('route-admin.reports.create')))
                <button name="submit" type="submit" class="add_report btn btn-default">Salvar Relatório</button>
            @endif
        </div>
        <div class="col-xs-12">
            <hr>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        <!--Repetição-->
        $('form').find("select[name=report_exe_repetition]").change(function () {
            $("select[name=report_exe_repetition] option:selected").each(function () {
                $parent = $('form').find('div.report_specific_repetition');
                $($parent).addClass('hide');

                console.log($(this).val());
                console.log($('form').find('div.report_specific_repetition#' + $(this).val()));

                $('form').find('div.report_specific_repetition#' + $(this).val()).removeClass('hide');

                if ($(this).val() == 'diariamente') {
                    console.log($('form').find('select[name=report_exe_interval]'));
                    $('form').find('div#div_pai_interval').addClass('hide');
                } else {
                    $('form').find('div#div_pai_interval').removeClass('hide');
                }

            });
        });
    });
    $(function () {
        var $_GRUPOINDICADORES_ = jQuery.parseJSON('{{json_encode($report_options['indicadores'])}}');
        var $SELECT_SENSOR = $('div.panel-default > div.panel-body > div.form-group > div > select[name=sensor_post_id]').selectize();
        var $SELECT_INDICADOR = $('div.panel-default > div.panel-body > div.form-group > div > select[name="measures[]"]').selectize();
        var $selected_indicadores = '{{$selected_indicadores}}';
        if ($selected_indicadores != '') {
            var $USER_SELECTED_INDICADORES = jQuery.parseJSON($selected_indicadores);
        } else {
            var $USER_SELECTED_INDICADORES = $selected_indicadores;
        }

        $($SELECT_SENSOR).on('change', function () {
            var $select = $($SELECT_INDICADOR)[0].selectize;
            var url_ = "{{url('get_only_indicadores_by_sensorid',['XX', 'group'])}}";
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
                            value: v.nome,
                            text: $_GRUPOINDICADORES_[v.key].impressao
                        });

                    });
                    $select.refreshItems();
                    var selected_indicador = ($USER_SELECTED_INDICADORES == '') ? indicadores[0] : $USER_SELECTED_INDICADORES;
                    console.log(selected_indicador);
                    $select.setValue(selected_indicador[0]);
                    $USER_SELECTED_INDICADORES = '';
                }
            });
        });
        $SELECT_SENSOR[0].selectize.setValue({{$selected_sensor}});
    });
</script>