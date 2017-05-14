<div class="panel panel-primary">
    <!-- panel body with collapse capabale -->
    <div class="table-responsive panel-collapse pull out">
        <table class="table table-bordered table-hover" id="table1">
            <thead>
            <tr>
                <th width="2%">ID</th>
                <th>Nome do relatório</th>
                <th>Sensor</th>
                <th>Indicadores</th>
                <th>Próxima execução</th>
                <th>Repetição</th>
                <th>Intervalo</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody>
            @if( count($reports) > 0 )
                @foreach($reports as $report)
                    <?php
                    $sensor = Post::find($report->parent)->title;
                    $title = $report->title;
                    $indicadores = json_decode($report->content);
                    if (count($indicadores) > 1) {
                        $measures = implode('; ', ReportController::transformNomeGrupoIndicadores($indicadores));
                    } else {
                        $measures = ReportController::transformNomeGrupoIndicadores($indicadores[0]);
                    }
                    $report_postmeta = Postmeta::get_transform_report($report->post_id);
                    $key_interval = key($report_postmeta['report_exe_interval']);
                    $key_repetition = key($report_postmeta['report_exe_repetition']);
                    $report_exe_calendar = new DateTime($report_postmeta['report_exe_calendar']);

                    //                            print_r($report_postmeta);
                    ?>
                    <tr class="">
                        <td>{{$report_postmeta['post_id']}}</td>
                        <td>{{$title}}</td>
                        <td>{{$sensor}}</td>
                        <td>{{$measures}}</td>
                        <td>{{$report_exe_calendar->format('d/m/Y H:i')}}</td>
                        <td>{{($key_repetition=='n')?'Não repetir':ucfirst($key_repetition)}}</td>
                        <td>{{ucfirst($key_interval)}}
                            ({{$report_postmeta['report_exe_interval']->$key_interval->ini." - ".$report_postmeta['report_exe_interval']->$key_interval->fim}}
                            )
                        </td>
                        <td>
                            <a href="{{URL::route('admin.report-custom',array('action'=>'editar','post_id'=>$report->post_id))}}"
                               class="update_report">
                                <i class="ico ico-edit"></i>Editar / Visualizar
                            </a>
                            @if(User::allowed('route-admin.reports.destroy'))
                                <a href="{{URL::action('admin.report-custom',array('action'=>'remover','post_id'=>$report->post_id))}}"
                                   class="remove_report text-danger">
                                    <i class="ico ico-trash"></i>Excluir
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="warning">
                    <td class="text-center" colspan="8">Nenhum relatório ainda. <a
                                href="{{URL::route('admin.report-custom',array('post_id'=>0,'action'=>'novo'))}}">Clique
                            aqui</a> para criar um novo
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>
<!--/ panel body with collapse capabale -->