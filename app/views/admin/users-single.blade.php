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

            <div class="col-md-6">
                <form action="@if(isset($user->user_id)) {{URL::route('admin.users',array('user_id'=>$user->user_id))}} @else {{URL::route('admin.users')}} @endif"
                      enctype="multipart/form-data" method="post" id="form-users" name="form-users"
                      data-parsley-validate>
                    <!-- START Panel -->
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <h3 class="panel-title">Cadastro de Usuário</h3>
                        </div>
                        <div class="panel-body">
                            {{Form::token()}}
                            <input type="hidden" name="type" value="cadastro">
                            <input type="hidden" name="user_id" value="{{(isset($user->user_id))?$user->user_id:0}}">

                            <div class="form-group {{(isset($user->user_id) && $user->user_id > 0)?'hide':''}}">
                                <div class="col-sm-12">
                                    @if(User::allowed('admin-users-new-client'))
                                        <label class="radio-inline">
                                            <input name="user_tipo" type="radio"
                                                   value="0" {{(isset($user->user_id) && User::find($user->user_id)->usermeta($user->user_id,'user_tipo')==0)?'checked':''}} >Novo
                                            Cadastro
                                        </label>
                                    @endif
                                    @if(User::allowed('admin-users-new-user'))
                                        <label class="radio-inline">
                                            <input name="user_tipo" type="radio"
                                                   value="1" {{(isset($user->user_id) && User::find($user->user_id)->usermeta($user->user_id,'user_tipo'))?'checked':''}} >Novo
                                            Usuário
                                        </label>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{(isset($user->user_id) && $user->user_id > 0)?'hide':'hide'}}"
                                 id="pessoa_tipo">
                                <div class="col-sm-12">
                                    <label class="radio-inline">
                                        <input name="pessoa_tipo" type="radio"
                                               value="Pessoa Física" {{(isset($user->user_id) &&  User::find($user->user_id)->usermeta($user->user_id,'pessoa_tipo') == 'Pessoa Física' )?'checked':''}}>Pessoa
                                        Física
                                    </label>
                                    <label class="radio-inline">
                                        <input name="pessoa_tipo" type="radio"
                                               value="Pessoa Jurídica" {{(isset($user->user_id) &&  User::find($user->user_id)->usermeta($user->user_id,'pessoa_tipo') == 'Pessoa Jurídica' )?'checked':''}}>Pessoa
                                        Jurídica
                                    </label>
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <hr>
                            </div>
                            @if(isset($user->user_id) && $user->user_id > 0)
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <label for="name" class="control-label">Nome <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name"
                                               value="{{(isset($user->name))?$user->name:''}}" required>
                                    </div>

                                    <div class="col-sm-6">
                                        <label for="email" class="control-label">Email <span
                                                    class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email"
                                               data-parsley-trigger="change" data-parsley-type="email"
                                               value="{{(isset($user->email))?$user->email:''}}" required>
                                    </div>
                                </div>
                                @if($user->group_id==4)
                                    <div class="form-group pf {{(isset($user->user_id) &&  User::find($user->user_id)->usermeta($user->user_id,'pessoa_tipo') == 'Pessoa Física' )?'':'hide'}}">
                                        <div class="col-sm-6">
                                            <label for="contato" class="control-label">Pessoa de Contato </label>
                                            <input type="text" class="form-control" name="contato"
                                                   value="{{(isset($user->user_id) )?User::find($user->user_id)->usermeta($user->user_id,'contato'):''}}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="contato" class="control-label">CPF </label>
                                            <input type="text" class="form-control" name="cpf"
                                                   data-mask="999.999.999-99"
                                                   value="{{(isset($user->user_id) )?User::find($user->user_id)->usermeta($user->user_id,'cpf'):''}}">
                                        </div>
                                    </div>
                                    <div class="form-group pj {{(isset($user->user_id) &&  User::find($user->user_id)->usermeta($user->user_id,'pessoa_tipo') == 'Pessoa Física' )?'hide':''}}">
                                        <div class="col-sm-4">
                                            <label for="contato" class="control-label">Pessoa de Contato </label>
                                            <input type="text" class="form-control" name="contato"
                                                   value="{{(isset($user->user_id) )?User::find($user->user_id)->usermeta($user->user_id,'contato'):''}}">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="contato" class="control-label">CNPJ </label>
                                            <input type="text" class="form-control" name="cnpj"
                                                   value="{{(isset($user->user_id) )?User::find($user->user_id)->usermeta($user->user_id,'cnpj'):''}}">
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="contact_email" class="control-label">Inscr. Estadual </label>
                                            <input type="email" class="form-control" name="ie"
                                                   value="{{(isset($user->user_id) )?User::find($user->user_id)->usermeta($user->user_id,'ie'):''}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-4">
                                            <label for="cep" class="control-label">CEP </label>
                                            <input type="text" class="form-control" name="cep"
                                                   value="{{(isset($user->user_id) )?User::find($user->user_id)->usermeta($user->user_id,'cep'):''}}">
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="cidade" class="control-label">Cidade </label>
                                            <input type="text" class="form-control" name="cidade"
                                                   value="{{(isset($user->user_id) )?User::find($user->user_id)->usermeta($user->user_id,'cidade'):''}}">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="estado" class="control-label">Estado </label>
                                            <input type="text" class="form-control" name="estado"
                                                   value="{{(isset($user->user_id) )?User::find($user->user_id)->usermeta($user->user_id,'estado'):''}}">
                                        </div>


                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <label for="bairro" class="control-label">Bairro </label>
                                            <input type="text" class="form-control" name="bairro"
                                                   value="{{(isset($user->user_id) )?User::find($user->user_id)->usermeta($user->user_id,'bairro'):''}}">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="endereco" class="control-label">Endereço </label>
                                            <input type="text" class="form-control" name="endereco"
                                                   value="{{(isset($user->user_id) )?User::find($user->user_id)->usermeta($user->user_id,'endereco'):''}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <label for="phones" class="control-label">Telefones <span
                                                        class="text-danger">*</span></label>

                                            <input type="text" class="form-control" name="phones" id="phone"
                                                   data-mask="(99)9999-99999"
                                                   value="{{(isset($user->user_id) )?User::find($user->user_id)->usermeta($user->user_id,'phones'):''}}"
                                                   required>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="fax" class="control-label">FAX </label>
                                            <input type="text" class="form-control" name="fax"
                                                   value="{{(isset($user->user_id) )?User::find($user->user_id)->usermeta($user->user_id,'fax'):''}}">
                                        </div>
                                    </div>
                                    <div class="form-group col-xs-12" style="padding-left: 0px">
                                        <div class="col-sm-6">
                                            <label for="pagamento" class="control-label">Forma de Pagamento </label><br>
                                            <label class="radio-inline">
                                                <input name="pagamento" type="radio" value="Boleto" checked="">Boleto
                                                Bancário ($4,00 p/boleto)
                                            </label>
                                            <label class="radio-inline">
                                                <input name="pagamento" type="radio" value="Outro">Outro
                                            </label>
                                        </div>
                                        <div class="col-sm-6" style="padding-left: 21px">
                                            <label for="fax" class="control-label">Prazo </label><br>
                                            <label class="radio-inline">
                                                <input name="prazo" type="radio" value="À Vista" checked="">À Vista
                                            </label>
                                            <label class="radio-inline">
                                                <input name="prazo" type="radio" value="À Prazo">À Prazo
                                            </label>
                                        </div>
                                        <div class="col-sm-6 hide" id="pagamento_outro">
                                            <label for="phones" class="control-label">Digite a outra forma de
                                                pagamento </label>
                                            <input type="text" class="form-control" name="pagamento_outro"
                                                   value="{{(isset($user->user_id) )?User::find($user->user_id)->usermeta($user->user_id,'pagamento_outro'):''}}">
                                        </div>
                                        <div class="col-sm-6 hide" id="prazo_dias">
                                            <label for="fax" class="control-label">Digite os dias a prazo
                                                necessário </label>
                                            <input type="number" class="form-control" name="prazo_dias"
                                                   value="{{(isset($user->user_id) )?User::find($user->user_id)->usermeta($user->user_id,'prazo_dias'):''}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="bairro" class="control-label">O que você precisa? </label>
                                            <textarea class="form-control" name="mensagem"
                                                      placeholder="Escreva aqui o que você precisa como tipo de serviço ...">{{(isset($user->user_id) )?User::find($user->user_id)->usermeta($user->user_id,'mensagem'):''}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <hr>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="docs" class="control-label">Imagens </label>
                                        </div>

                                        <div class="col-sm-12">
                                            <label for="doc_rg" class="control-label">Logo </label>
                                            <input type="file" class="form-control" name="logo_cliente">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <hr>
                                    </div>
                                    <div class="form-group pf {{(isset($user->user_id) &&  User::find($user->user_id)->usermeta($user->user_id,'pessoa_tipo') == 'Pessoa Física' )?'':'hide'}}">
                                        <div class="col-sm-12">
                                            <label for="docs" class="control-label">Documentos </label>
                                        </div>

                                        <div class="col-sm-12">
                                            <label for="doc_rg" class="control-label">Copia do RG </label>
                                            <input type="file" class="form-control" name="doc_rg">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="doc_cpf" class="control-label">Copia da CPF </label>
                                            <input type="file" class="form-control" name="doc_cpf">
                                        </div>
                                    </div>
                                    <div class="form-group pj {{(isset($user->user_id) &&  User::find($user->user_id)->usermeta($user->user_id,'pessoa_tipo') == 'Pessoa Física' )?'hide':''}}">
                                        <div class="col-sm-12">
                                            <label for="docs" class="control-label">Documentos </label>
                                        </div>
                                        <div class="col-sm-12 ">
                                            <label for="doc_cnpj" class="control-label">Copia do CNPJ </label>
                                            <input type="file" class="form-control" name="doc_cnpj">
                                        </div>
                                        <div class="col-sm-12 ">
                                            <label for="doc_ie" class="control-label">Copia da Inscr. Estadual </label>
                                            <input type="file" class="form-control" name="doc_ie">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="doc_rg" class="control-label">Copia do RG </label>
                                            <input type="file" class="form-control" name="doc_rg">
                                        </div>
                                        <div class="col-sm-12">
                                            <label for="doc_cpf" class="control-label">Copia da CPF </label>
                                            <input type="file" class="form-control" name="doc_cpf">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <hr>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="correspondencia" class="control-label">Preferência para
                                                recebimento de nossas correspondências (extratos, avisos e etc)
                                                por: </label><br>
                                            <label class="radio-inline">
                                                <input name="correspondencia" type="radio" value="E-mail">E-mail
                                            </label>
                                            <label class="radio-inline">
                                                <input name="correspondencia" type="radio" value="Fax">Fax
                                            </label>
                                            <label class="radio-inline">
                                                <input name="correspondencia" type="radio" value="Correio">Correio
                                            </label>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <hr>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="ref" class="control-label">Como ficou sabendo da
                                                MediSom? </label><br>
                                            <label class="radio-inline">
                                                <input name="ref" type="radio" value="Web-site">Web-site
                                            </label>
                                            <label class="radio-inline">
                                                <input name="ref" type="radio" value="Feira de Eventos">Feira de Eventos
                                            </label>
                                            <label class="radio-inline">
                                                <input name="ref" type="radio" value="Revista">Revista
                                            </label>
                                            <label class="radio-inline">
                                                <input name="ref" type="radio" value="Nossa Mala-Direta">Nossa
                                                Mala-Direta
                                            </label>
                                            <label class="radio-inline">
                                                <input name="ref" type="radio" value="Redes Sociais">Redes Sociais
                                            </label>
                                            <label class="radio-inline">
                                                <input name="ref" type="radio" value="Outro">Outro
                                            </label>
                                        </div>

                                    </div>

                                    <div class="col-sm-12">
                                        <hr>
                                    </div>
                                @endif
                            @else
                                <div id="dataform" class="mb20">
                                </div>
                            @endif

                            @if(count($groups) && User::allowed('admin-groups-edit'))
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="group" class="control-label">Grupo <span
                                                    class="text-danger">*</span></label>
                                        <select name="group_id" class="form-control" required>
                                            <option value="">Escolha...</option>
                                            @foreach($groups as $group)
                                                @if($group->group_id != 1)
                                                    <option value="{{$group->group_id}}" {{(isset($user->group_id) && $user->group_id == $group->group_id)?'selected':''}}>{{$group->description}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endif

                            @if( isset($user->user_id) && $user->user_id > 0)
                                <div class="col-sm-12">
                                    <hr>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">

                                        <label for="password" class="control-label">Alterar Senha </label>
                                        <input type="password" class="form-control" name="password" value="">

                                    </div>

                                </div>
                                <div class="col-sm-12">
                                    <hr>
                                </div>
                            @endif

                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-primary">Salvar</button>
                        </div>

                    </div>
                    <!--/ END Panel -->
                </form>
            </div>
            <!-- SENSORES -->
            @if( isset($user->user_id) && $user->user_id > 0 && User::allowed('admin-users-sensores'))
                <div class="col-md-6">
                    <!-- START Panel -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Sensores</h3>
                        </div>
                        <div class="panel-body">
                            @if(isset($sensores) && count($sensores))
                                <table class="table table-hover table-striped" id="sensores">
                                    <thead>
                                    <tr>
                                        <th colspan="4">Lista de sensores cadastrados</th>
                                    </tr>
                                    <tr>
                                        <th style="width: 5%">ID</th>
                                        <th style="width: 10%">Status</th>
                                        <th style="width: 20%">Nome</th>
                                        <th style="width: 65%">Indicadores ativos</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sensores as $sensor)
                                        <?php
                                        $indicadores_impressao = NULL;
                                        if (count($sensor->measures) > 1) {
                                            foreach ($sensor->measures_str as $measure) {
                                                $indicadores_impressao[] = $measure["impressao"];
                                            }
                                            $indicadores_impressao = implode('; ', $indicadores_impressao);
                                        } else {
                                            $indicadores_impressao = $sensor->measures_str["impressao"];
                                        }
                                        ?>
                                        <tr class="{{($sensor->status=='publish')?'success':'danger'}}"
                                            id="{{$sensor->post_id}}">
                                            <td>{{$sensor->post_id}}</td>
                                            <td class="status">
                                            {{($sensor->status=='publish')?'Ativo':'Inativo'}}</th>
                                            <td>{{$sensor->title}}</td>
                                            <td>{{$indicadores_impressao}}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="col-xs-12">
                                    Nenhum sensor cadastrado.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
            {{--@endif--}}
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