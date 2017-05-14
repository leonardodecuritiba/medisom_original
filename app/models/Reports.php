<?php

/**
 *
 */
class Reports extends Eloquent
{

    protected $table = 'reports';
    protected $timestamp = false;
    protected $primaryKey = 'reports_id';

    /**
     * [get um ou todos registros salvos]
     * @param  string $key [chave unica]
     * @return [array/string]      [valor ou valores buscados]
     */
    static public function get($reports_id, $key = '', $transformed = 0)
    {
        if ($key != '') {
            $reports = Reports::where('reports_id', '=', $reports_id)->where('meta_key', '=', $key)->first();
        } else {
            $reports = Reports::where('reports_id', '=', $reports_id)->get();
        }

        if ($transformed) {
            $reports->meta_value = json_decode($reports->meta_value);
        }
        return $reports;
    }

    static public function getByPostmeta($postmeta_id, $key = '', $transformed = 0)
    {
        if ($key != '') {
            $reports = Reports::where('postmeta_id', '=', $postmeta_id)->where('meta_key', '=', $key)->first();
        } else {
            $reports = Reports::where('postmeta_id', '=', $postmeta_id)->get();
        }
        if ($transformed) {
            $reports->meta_value = json_decode($reports->meta_value);
        }
        return $reports;
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

//		if(isset($params['reports_id']))
        $report = Reports::where('postmeta_id', '=', $params['postmeta_id'])
            ->where('meta_key', '=', $params['meta_key'])
            ->first();

        if (isset($report->exists)) {
            $report->postmeta_id = $params['postmeta_id'];
            $report->meta_key = $params['meta_key'];
            $report->meta_value = $params['meta_value'];
            $report->save();
            $report = $report->reports_id;
        } else {
            $report = Reports::insert_only($params['postmeta_id'], $params['meta_key'], $params['meta_value']);
        }

        return $report;
    }

    static public function insert_only($postmeta_id, $meta_key, $meta_value)
    {
        return Reports::insertGetId(['postmeta_id' => $postmeta_id, 'meta_key' => $meta_key, 'meta_value' => $meta_value]);
    }
}