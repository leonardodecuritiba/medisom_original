<?php

/**
 *
 */
class Sensormeta extends Eloquent
{

    protected $table = 'sensormeta';
    protected $timestamp = true;
    protected $primaryKey = 'sensormeta_id';

    /**
     * [get um ou todos registros salvos]
     * @param  string $key [chave unica]
     * @return [array/string]      [valor ou valores buscados]
     */
    static public function get($sensormeta_id, $key = '', $value = '')
    {
        if ($key != '') {
            $sensormeta = Alerts::where('sensormeta_id', '=', $sensormeta_id)->where($key, '=', $value)->first();
        } else {
            $sensormeta = Alerts::where('sensormeta_id', '=', $sensormeta_id)->get();
        }

        return $sensormeta;
    }

    /**
     * [set description]
     * @param  string $key [description]
     * @param  string $value [description]
     * @return [int]         [id do registro manipulado]
     */

    static public function update_or_insert($params = array())
    {
        extract($params, EXTR_OVERWRITE);

        $Sensormeta = Sensormeta::where('sensor_id', '=', $params['sensor_id'])
            ->where('alert_day', '=', $params['alert_day'])
            ->first();

        if (!isset($sensormeta->exists)) {
            $Sensormeta = new Sensormeta();
            $Sensormeta->sensor_id = $params['sensor_id'];
            $Sensormeta->alert_count = 0;
        }
        $Sensormeta->last_activity = $params['last_activity'];
        $Sensormeta->last_values = json_encode($params['last_values']);
        $Sensormeta->alert_day = $params['alert_day'];
        $Sensormeta->save();

        return $sensormeta;
    }

    public function getLastValuesAttribute($value)
    {
        return json_decode($value);
    }

    public function sensor()
    {
        return $this->belongsTo('Post', 'sensor_id', 'post_id');
    }
    /*
        static public function insert_only($sensormeta_id,$meta_key,$meta_value)
        {
            return Alerts::insertGetId(['postmeta_id' => $postmeta_id,'meta_key' => $meta_key,'meta_value' => $meta_value]);
        }
        */

}