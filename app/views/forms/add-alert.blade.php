<?php
$formid = (isset($_REQUEST['formid']) && $_REQUEST['formid'] != '') ? $_REQUEST['formid'] : FALSE;
$id = (isset($_REQUEST['id']) && $_REQUEST['id'] != '') ? $_REQUEST['id'] : FALSE;
$name_id = (isset($_REQUEST['nameid']) && $_REQUEST['nameid'] != '') ? $_REQUEST['nameid'] : FALSE;
$vars = (isset($_REQUEST['vars']) && $_REQUEST['vars'] != '') ? json_decode($_REQUEST['vars']) : FALSE;

if ($formid) {
    echo '<input type="hidden" name="formid" value="' . $formid . '">';
}
if ($name_id) {
    if ($id) {
        echo '<input type="hidden" name="' . $name_id . '" value="' . $id . '">';
    }
}

if ($vars) {
    foreach ($vars as $k => $v) {
        if ($k == 'alert') {
            if ($v == 'time_leq_alarm_set_ipa') {
                $graphsid = array('time_leq', 'alarm_set', 'ipa');
            } else {
                $graphsid = explode('_', $v);
            }
            /**/

        } else {
            echo '<input type="hidden" name="' . $k . '" value="' . $v . '">';
        }
    }

}

$col = (count($graphsid) == 3) ? 4 : 6;

?>
<div class="row">
    <div class="form-group">
        <?php foreach ($graphsid as $graphid): ?>
        <?php $indicador = strtolower(str_replace(' ', '_', $graphid));?>
        <input type="hidden" name="set_alert_<?php echo $indicador ?>" value="<?php echo $indicador ?>">
        <div class="col-sm-<?php echo $col ?> col-xs-12">
            <div class="col-sm-12 col-xs-12">
                <h5>Valor Mínimo <?php echo ucwords(str_replace('_', ' ', $graphid)) ?></h5>
                <label for="alert" class="control-label">Valor <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="alert_min_<?php echo $indicador ?>" required value="">
            </div>
            <div class="col-sm-12 col-xs-12">
                <label for="alertar" class="control-label">Receber alerta por: </label><br>
                <label class="radio-inline">
                    <input name="alert_min_email_<?php echo $indicador ?>" type="checkbox" value="1">E-mail
                </label>
                <label class="radio-inline">
                    <input name="alert_min_sms_<?php echo $indicador ?>" type="checkbox" value="1">SMS
                </label>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="col-sm-12">
        <hr>
    </div>
    <div class="form-group">
        <?php foreach ($graphsid as $graphid): ?>
        <?php $indicador = strtolower(str_replace(' ', '_', $graphid));?>
        <div class="col-sm-<?php echo $col ?> col-xs-12">
            <div class="col-sm-12 col-xs-12">
                <h5>Valor Máximo <?php echo ucwords(str_replace('_', ' ', $graphid)) ?></h5>
                <label for="alert" class="control-label">Valor <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="alert_max_<?php echo $indicador ?>" required value="">
            </div>

            <div class="col-sm-12 col-xs-12">
                <label for="alertar" class="control-label">Receber alerta por: </label><br>
                <label class="radio-inline">
                    <input name="alert_max_email_<?php echo $indicador ?>" type="checkbox" value="1">E-mail
                </label>
                <label class="radio-inline">
                    <input name="alert_max_sms_<?php echo $indicador ?>" type="checkbox" value="1">SMS
                </label>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
</div>