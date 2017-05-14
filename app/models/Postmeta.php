<?php

/**
 *
 */
class Postmeta extends Eloquent
{

    public $timestamps = false;
    protected $table = 'postmeta';
    protected $primaryKey = 'postmeta_id';

    /**
     * [get um ou todos registros salvos]
     * @param  string $key [chave unica]
     * @return [array/string]      [valor ou valores buscados]
     */
    static public function get_by($post_id = 0, $key = '')
    {
        if ($key != '') {
            $postmeta = Postmeta::where('post_id', '=', $post_id)
                ->where('meta_key', '=', $key)
                ->first();
        } else {
            $postmeta = Postmeta::where('post_id', '=', $post_id)
                ->get();
        }
        return $postmeta;
    }

    /**
     * [get um ou todos registros salvos]
     * @param  string $key [chave unica]
     * @return [array/string]      [valor ou valores buscados]
     */
    static public function getByMetaKeyValue($post_id, $meta_key, $meta_value)
    {
        return Postmeta::where('post_id', $post_id)
            ->where('meta_key', $meta_key)
            ->where('meta_value', $meta_value);
    }

    static public function update_meta()
    {
        $param = Input::all();
        $fields_remove = array('formid', 'post_id', 'method', 'action', 'getdata');

        if ($param['post_id'] > 0) {

//            print_r($param);
            foreach ($param as $k => $v) {
                if (strpos($k, 'set_alert') !== false) {
                    $graphid = $v;
                    $param['alert_min_email_' . $graphid] = (isset($param['alert_min_email_' . $graphid])) ? $param['alert_min_email_' . $graphid] : 0;
                    $param['alert_min_sms_' . $graphid] = (isset($param['alert_min_sms_' . $graphid])) ? $param['alert_min_sms_' . $graphid] : 0;
                    $param['alert_max_email_' . $graphid] = (isset($param['alert_max_email_' . $graphid])) ? $param['alert_max_email_' . $graphid] : 0;
                    $param['alert_max_sms_' . $graphid] = (isset($param['alert_max_sms_' . $graphid])) ? $param['alert_max_sms_' . $graphid] : 0;
                }
            }

//            print_r($param);
            foreach ($param as $k => $v) {
                if (!in_array($k, $fields_remove) && (strpos($k, 'set_alert') !== true)) {
                    Postmeta::update_or_insert(array('post_id' => $param['post_id'], 'key' => $k, 'value' => $v));
                }
            }
            echo json_encode(array('success' => true, 'msg' => 'Salvo com sucesso.'));
        } else {
            echo json_encode(array('error' => true, 'msg' => 'ID Não encontrado.'));
        }
    }

    /**
     * [update_or_insert     description]
     * @param  string $key [description]
     * @param  string $value [description]
     * @return [int]         [id do registro manipulado]
     */
    static public function update_or_insert($params = array())
    {

        $postmeta_id = 0;
        $post_id = 0;
        $key = '';
        $value = '';

        extract($params, EXTR_OVERWRITE);

        if ($post_id && $key != '') {
            $postmeta = Postmeta::where('post_id', '=', $post_id)
                ->where('meta_key', '=', $key)->lists('postmeta_id');

            if (count($postmeta) > 0) {
                $postmeta_id = $postmeta[0];
            } else {
                $postmeta_id = 0;
            }
//            $postmeta_id = $postmeta[0];
//            var_dump($postmeta);
//            echo "entrometa_key', '='".$key.",<br>"; exit;
        }
        $postmeta_id = ($postmeta_id != '') ? $postmeta_id : 0;

        if ($postmeta_id == 0) {
            $postmeta = new Postmeta();
            $postmeta->post_id = $post_id;
            $postmeta->meta_key = $key;
            $postmeta->meta_value = $value;
            $postmeta->save();
        } else {
            $New_postmeta['post_id'] = $post_id;
            $New_postmeta['meta_key'] = $key;
            $New_postmeta['meta_value'] = $value;
//            print_r($postmeta_id);exit;
            $postmeta = Postmeta::where('postmeta_id', $postmeta_id)
                ->update($New_postmeta);
//            print_r($New_postmeta);exit;
        }
//        print_r($postmeta);exit;

        return $postmeta;
        /**/
    }

    static public function up_meta()
    {
        $v = Postmeta::where('meta_key', 'like', 'alert_email%')->get();
        print_r($v);
        foreach ($v as $postmeta) {
            $meta_key = explode('_', $postmeta->meta_key);
            $temp = $meta_key[1];
            $meta_key[1] = $meta_key[2];
            $meta_key[2] = $temp;
            Postmeta::where('postmeta_id', $postmeta->postmeta_id)
                ->update(['meta_key' => implode('_', $meta_key)]);
        }
        $v = Postmeta::where('meta_key', 'like', 'alert_sms%')->get();
        print_r($v);
        foreach ($v as $postmeta) {
            $meta_key = explode('_', $postmeta->meta_key);
            $temp = $meta_key[1];
            $meta_key[1] = $meta_key[2];
            $meta_key[2] = $temp;
            Postmeta::where('postmeta_id', $postmeta->postmeta_id)
                ->update(['meta_key' => implode('_', $meta_key)]);
        }
        return $v;
    }

    static public function get_meta()
    {
        $param = Input::all();

        if ($param['post_id']) {
            if ($param['action'] == 'update_meta') {
                echo json_encode(Postmeta::where('post_id', '=', $param['post_id'])->where('meta_key', 'like', 'alert_m%')->get());
            } else {
                echo json_encode(Postmeta::get($param['post_id']));
            }

        } else {
            echo json_encode(array('error' => true, 'msg' => 'ID Não encontrado.'));
        }
    }

    /**
     * [get um ou todos registros salvos]
     * @param  string $key [chave unica]
     * @return [array/string]      [valor ou valores buscados]
     */
    static public function get($post_id, $key = '', $returnid = false)
    {
        if ($key != '') {
            $postmeta = DB::table('postmeta')->where('post_id', '=', $post_id)->where('meta_key', '=', $key)->get();
            if (count($postmeta) > 0) {

                if ($returnid) {
                    $postmeta = $postmeta[0];
                } else {
                    $postmeta = $postmeta[0]->meta_value;
                }
            } else {
                $postmeta = '';
            }
        } else {
            $postmeta = Postmeta::where('post_id', '=', $post_id)->get();
        }
        return $postmeta;
    }

    /**
     * [delete de um registros salvos]
     * @param  string $key [chave unica]
     * @return [array/string]      [valor ou valores buscados]
     */
    static public function delete_by($post_id = 0, $key = '')
    {
        if ($key != '') {

            $postmeta = DB::table('postmeta')
                ->where('post_id', '=', $post_id)
                ->where('meta_key', '=', $key)
                ->delete();

            return $postmeta;
        } else {
            return 0;
        }
        return $postmeta;
    }

    static public function get_transform_report($post_id)
    {

        $Postmeta = Postmeta::where('post_id', $post_id)->first();
        $report['postmeta_id'] = $Postmeta->postmeta_id;
        $report['post_id'] = $Postmeta->post_id;
        $report['post'] = $Postmeta->post;

        $report_exe = json_decode($Postmeta->meta_value, 1);
        $report['sensor_post_id'] = $report_exe['sensor_post_id']; // id do sensor
        $report['report_exe_calendar'] = $report_exe['report_exe_calendar']; // data da próxima execução do relatório
        $report['report_exe_repetition'] = (object)$report_exe['report_exe_repetition']; // parâmetros da repetição da geração do relatório
        $key = key($report_exe['report_exe_interval']); // intervalo de execução do relatório
        $report['report_exe_interval'] = (object)array(
            $key => (object)$report_exe['report_exe_interval'][$key]
        );
        $report['destinatarios'] = $report_exe['destinatarios']; // dados de envio do relatório

        return $report;
    }

    static public function get_original_report($Postmeta)
    {
        $PostmetaORIG = Postmeta::find($Postmeta->postmeta_id);
        $meta_value['sensor_post_id'] = $Postmeta->sensor_post_id;
        $meta_value['report_exe_calendar'] = $Postmeta->report_exe_calendar;
        $meta_value['report_exe_repetition'] = (array)$Postmeta->report_exe_repetition;
        $key = key($Postmeta->report_exe_interval);
        $meta_value['report_exe_interval'] = array(
            $key => (array)$Postmeta->report_exe_interval->$key
        );
        $meta_value['destinatarios'] = $Postmeta->destinatarios;

        $PostmetaORIG->meta_value = json_encode($meta_value);
        return $PostmetaORIG;
    }

    public function post()
    {
        return $this->belongsTo('Post', 'post_id', 'post_id');
    }
}
