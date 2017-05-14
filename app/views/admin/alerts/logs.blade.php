<div class="panel panel-primary">
    <!-- panel body with collapse capabale -->
    <div class="table-responsive panel-collapse pull out">
        <table class="table table-bordered table-hover" id="table1">
            <thead>
            <tr>
                <th>Sensor</th>
                <th>Mensagem</th>
                <th>Data</th>
            </tr>
            </thead>
            <tbody>
            @if( count($alerts) > 0 )
                @foreach($alerts as $alert)
                    <tr>
                        <td>{{$alert->sensor}} - {{$alert->name}}</td>
                        <td>{{$alert->msg}}</td>
                        <td>{{$alert->date}}</td>

                    </tr>
                @endforeach
            @else
                <tr class="warning">
                    <td class="text-center" colspan="4">Nenhum alerta ainda.</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
    <!--/ panel body with collapse capabale -->
</div>