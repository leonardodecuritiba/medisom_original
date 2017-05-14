<?php
$users = DB::table('users')->where('user_id', '<>', Auth::user()->user_id)->where('parent', '=', Auth::user()->user_id)->get();
?>
<div class="row">
    <div class="col-xs-12">
        <div class="form-group col-xs-12">

            <div class="col-xs-12 ">

                <h5>Compartilhar gráfico </h5>
                <label for="alert" class="control-label">Selecione um usuário <span class="text-danger">*</span></label>
                <select>
                    <option>Escolha...</option>
                    <?php if(count($users)){ foreach ($users as $user) { ?>
                    <option value="{{$user->user_id}}">{{$user->name}}</option>
                    <?php } } ?>
                </select>

            </div>

            <div class="col-xs-12 ">
                <label for="alert" class="control-label">Compartilhar por email </label>
                <input type="text" name="share_email" class="form-control">
            </div>

        </div>


    </div>
</div>

