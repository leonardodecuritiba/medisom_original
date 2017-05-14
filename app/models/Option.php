<?php

/**
 *
 */
class Option extends Eloquent
{

    public $timestamps = false;
    protected $table = 'options';
    protected $primaryKey = 'option_id';

    /**
     * update_or_insert     description
     * @param  string $key description
     * @param  string $value description
     * @return int             id do registro manipulado
     */
    static public function update_or_insert($key = '', $value = '', $parent = 999)
    {
        $check = Option::get($key);
//print_r($check);exit;
        if ($check) {
            $new_option['option_key'] = $key;
            $new_option['option_value'] = $value;
            $new_option['parent'] = $parent;
            $option = Option::where('option_key', $key)->update($new_option);
        } else {
            $option = new Option();
            $option->option_key = $key;
            $option->option_value = $value;
            $option->parent = $parent;

            $option->save();
        }


        return true;
    }

    /**
     * [get um ou todos registros salvos]
     * @param  string $key [chave unica]
     * @return [array/string]      [valor ou valores buscados]
     */
    static public function get($key = '')
    {
        if ($key != '') {
            $option = Option::where('option_key', '=', $key)->take(1)->get();
            if (count($option) > 0) {
                $option = $option[0]->option_value;
            } else {
                $option = '';
            }
        } else {
            $option = Option::all();
        }
        return $option;
    }

    static public function update_alert()
    {

    }
}