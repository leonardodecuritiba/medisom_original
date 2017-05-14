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
        <form action="@if(isset($group->group_id)) {{URL::route('admin.groups',array('group_id'=>$group->group_id))}} @else {{URL::route('admin.groups')}} @endif"
              method="post" id="form-groups" name="form-groups" data-parsley-validate>
            <div class="row">
                <div class="col-md-12">
                    <!-- START panel -->
                    <div class="panel panel-primary">
                        <!-- panel heading/header -->

                        <!--/ panel heading/header -->


                        <!-- panel body with collapse capabale -->
                        <div class="table-responsive panel-collapse pull out">
                            @if( isset($groups) )
                                <table class="table table-bordered table-hover" id="table1">
                                    <thead>
                                    <tr>
                                        <th>Grupo</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if( count($groups) > 0 )
                                        @foreach($groups as $group)
                                            <tr class="">

                                                <td>{{$group->description}}</td>

                                                <td class="text-right">
                                                    <a href="{{URL::route('admin.groups',array('group_id'=>$group->group_id))}}"><i
                                                                class="fa fa-edit"></i>Editar</a>

                                                    <a href="{{URL::route('admin.groups',array('group_id'=>$group->group_id,'action'=>'delete'))}}"
                                                       class="text-danger"><i class="fa fa-remove"></i>Excluir</a>

                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr class="warning">
                                            <td class="text-center" colspan="4">Nenhuma grupo ainda. <a
                                                        href="{{URL::route('admin.groups',array('group_id'=>0))}}">Clique
                                                    aqui</a> para criar uma nova
                                            </td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            @else


                                <div class="form-group mb20">
                                    <div class="col-sm-12">
                                        <label for="name" class="control-label">Nome <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="description"
                                               value="{{(isset($group->description))?$group->description:''}}" required>
                                    </div>


                                </div>
                                <hr>
                                <br><br>

                            @endif
                        </div>
                        <!--/ panel body with collapse capabale -->
                    </div>
                </div>

                @if(isset($permissions))
                    <div class="col-md-12">
                        <!-- START Panel -->
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Permissões</h3>
                            </div>
                            <div class="panel-body">

                                @if(count($permissions)>0)
                                    <ul>
                                        @foreach($tree as $permission)
                                            <li>
                                                <input type="checkbox" name="permission[]"
                                                       @if( $permission->parent == 0 ) checked
                                                       @endif  value="{{$permission->permission_id}}">{{$permission->name}}
                                                @if(isset($permission->childs) && count($permission->childs))
                                                    <ul>
                                                        @foreach($permission->childs as $permission)
                                                            <li>
                                                                <input type="checkbox" name="permission[]"
                                                                       @if(in_array($permission->permission_id,$mypermissions)) checked
                                                                       @endif  value="{{$permission->permission_id}}">{{$permission->name}}
                                                                @if(isset($permission->childs) && count($permission->childs))
                                                                    <ul>
                                                                        @foreach($permission->childs as $permission)
                                                                            <li>
                                                                                <input type="checkbox"
                                                                                       name="permission[]"
                                                                                       @if(in_array($permission->permission_id,$mypermissions)) checked
                                                                                       @endif  value="{{$permission->permission_id}}">{{$permission->name}}
                                                                                @if(isset($permission->childs) && count($permission->childs))
                                                                                    <ul>
                                                                                        @foreach($permission->childs as $permission)
                                                                                            <li>
                                                                                                <input type="checkbox"
                                                                                                       name="permission[]"
                                                                                                       @if(in_array($permission->permission_id,$mypermissions)) checked
                                                                                                       @endif  value="{{$permission->permission_id}}">{{$permission->name}}
                                                                                                @if(isset($permission->childs) && count($permission->childs))
                                                                                                    <ul>
                                                                                                        @foreach($permission->childs as $permission)
                                                                                                            <li>
                                                                                                                <input type="checkbox"
                                                                                                                       name="permission[]"
                                                                                                                       @if(in_array($permission->permission_id,$mypermissions)) checked
                                                                                                                       @endif  value="{{$permission->permission_id}}">{{$permission->name}}
                                                                                                                @if(isset($permission->childs) && count($permission->childs))
                                                                                                                    <ul>
                                                                                                                        @foreach($permission->childs as $permission)
                                                                                                                            <li>
                                                                                                                                <input type="checkbox"
                                                                                                                                       name="permission[]"
                                                                                                                                       @if(in_array($permission->permission_id,$mypermissions)) checked
                                                                                                                                       @endif  value="{{$permission->permission_id}}">{{$permission->name}}
                                                                                                                            </li>
                                                                                                                        @endforeach
                                                                                                                    </ul>
                                                                                                                @endif
                                                                                                            </li>
                                                                                                        @endforeach
                                                                                                    </ul>
                                                                                                @endif
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                @endif
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-footer">
                            @if(isset($groups))
                                <a href="{{URL::route('admin.groups',array('group_id'=>0,'action'=>'novo'))}}"
                                   class="btn btn-default">Novo Grupo</a>
                            @else
                                <button type="submit" class="btn btn-primary">Salvar</button>
                                <a href="{{URL::route('admin.groups',array('group_id'=>0,'action'=>'novo'))}}"
                                   class="btn btn-default">Novo Grupo</a>
                            @endif
                        </div>
                    </div>
                </div>

        </form>
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