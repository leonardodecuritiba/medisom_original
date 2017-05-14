<div class="panel panel-primary">
    <!-- panel heading/header -->
    <!--/ panel heading/header -->
    <!-- panel body with collapse capabale -->
    <div class="table-responsive panel-collapse pull out">
        <table class="table table-bordered table-hover" id="table1">
            <thead>
            <tr>
                <th width="2%">ID</th>
                <th width="3%">Status</th>
                @if ( Auth::user()->group_id == 1)
                    <th width="10%">Usuário</th>
                @endif
                <th width="10%">Nome</th>
                <th width="20%">Sensor</th>
                <th width="12%">Condição</th>
                <th width="10%">Indicadores</th>
                <th width="12%">Horário</th>
                <th width="20%">Ações</th>
            </tr>
            </thead>
            <tbody>
            @if( count($alerts) > 0 )
                @foreach($alerts as $alert)
                    <tr>
                        <td>{{$alert->alert_id}}</td>
                        @if($alert->status==1)
                            <td>
                                <small class="btn btn-xs btn-success">Ativo</small>
                            </td>
                        @else
                            <td>
                                <small class="btn btn-xs btn-danger">Inativo</small>
                            </td>
                        @endif
                        @if ( Auth::user()->group_id == 1)
                            {{--<td>{{$alert->author($alert->sensor)}}</td>--}}
                            <td>{{$alert->author($alert->sensor->post_author)->name}}</td>
                        @endif
                        <td>{{$alert->nome}}</td>
                        <td>{{$alert->sensor->title}}</td>
                        <td>{{$alert->condicao['print']}}</td>
                        <td>{{$alert->indicador['print']}}</td>
                        <td>{{$alert->horario['print']}}</td>
                        <td class="text-left">
                            <a class="btn btn-info btn-xs" href="{{URL::route('admin.alertas.show',$alert->alert_id)}}">
                                <i class="fa fa-edit"></i> Editar</a>
                            <a class="btn btn-{{($alert->status)? 'default':'success'}} btn-xs"
                               href="{{route('admin.alertas.status',$alert->alert_id)}}">
                                <i class="fa fa-{{($alert->status)? 'eye-slash':'eye'}} "></i>{{($alert->status)? ' Desativar':' Ativar'}}
                            </a>
                            @if(User::allowed('route-admin.alertas.destroy'))
                                <a class="btn btn-danger btn-xs alert-confirm"
                                   data-href="{{route('admin.alertas.destroy',$alert->alert_id)}}"
                                   data-title="sensor"><i class="ico ico-trash"></i>Excluir</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="warning">
                    <td class="text-center" colspan="10">Nenhum alerta ainda. <a
                                href="{{route('admin.alertas.create')}}">Clique
                            aqui</a> para criar um novo
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    <!--/ panel body with collapse capabale -->
</div>