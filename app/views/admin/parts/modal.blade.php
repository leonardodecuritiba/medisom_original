<div class="modal fade" id="modal-admin" tabindex="-1" role="dialog" aria-labelledby="modal-dashboard-label"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="" name="">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <span class="spinner"></span>
                </div>
                <div class="modal-footer">
                    <button type="button" class=" btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" class="form-send btn btn-primary">Salvar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="modal-share" tabindex="-1" role="dialog" aria-labelledby="modal-dashboard-label"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <form id="form-share" name="form-share">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Compartilhar gráfico</h4>
                </div>
                <div class="modal-body">
                    <?php
                    $users = DB::table('users')->join('groups', 'users.group_id', '=', 'groups.group_id')->where('user_id', '<>', Auth::user()->user_id)->where('parent', '=', Auth::user()->user_id)->get();

                    if (Auth::user()->group_id == 1) {
                        $users = DB::table('users')
                                ->join('groups', 'users.group_id', '=', 'groups.group_id')
                                ->where('user_id', '<>', Auth::user()->user_id)->get();
                    }
                    ?>
                    <div class="row">
                        <img id="graph-share" src="" width="100%" height="200px">
                        <div class="col-lg-12">
                            <hr>
                        </div>
                        <input type="hidden" name="img_shared" id="img_shared">
                        <div class="col-xs-12">
                            <div class="form-group col-xs-12">
                                <?php if(count($users)){ ?>
                                <div class="col-xs-12 ">

                                    <label for="alert" class="control-label">Selecione um usuário </label>
                                    <select name="share_users" multiple>
                                        <option>Escolha...</option>
                                        <?php  foreach ($users as $user) { ?>
                                        <option value="{{$user->user_id}}">{{$user->name}}</option>
                                        <?php } ?>
                                    </select>
                                    <small>Para selecionar mais de um contato precione CTRL</small>

                                </div>
                                <div class="col-lg-12">
                                    <hr>
                                </div>
                                <?php }  ?>
                                <div class="col-xs-12 ">
                                    <label for="alert" class="control-label">Compartilhar por email </label>
                                    <input type="text" name="share_email" class="form-control"
                                           placeholder="Insira os emails aqui">
                                    <small>Separe os emails por "," ex.: medisom@medisom.com.br, contato@medisom
                                        .com.br
                                    </small>
                                </div>

                            </div>


                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class=" btn btn-default" data-dismiss="modal">Fechar</button>
                    <button type="button" class="form-send btn btn-primary">Compartilhar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->