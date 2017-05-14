<?php

/**
 *
 */
class Usermeta extends Eloquent
{

    protected $table = 'usermeta';
    protected $timestamp = false;

    /**
     * [get um ou todos registros salvos]
     * @param  string $key [chave unica]
     * @return [array/string]      [valor ou valores buscados]
     */
    static public function get($user_id, $key = '')
    {
        if ($key != '') {
            $usermeta = DB::table('usermeta')->where('user_id', '=', $user_id)->where('meta_key', '=', $key)->get();
            if (count($usermeta) > 0)
                $usermeta = $usermeta[0]->meta_value;
            else
                $usermeta = '';
        } else {
            $usermeta = Usermeta::where('user_id', '=', $user_id)->get();
        }
        return $usermeta;
    }

    static public function get_by($user_id = 0, $key = '')
    {
        if ($key != '') {
            $usermeta = Usermeta::where('user_id', '=', $user_id)
                ->where('meta_key', '=', $key)
                ->first();
        } else {
            $usermeta = Usermeta::where('user_id', '=', $user_id)
                ->get();
        }
        return $usermeta;
    }

    /**
     * [set description]
     * @param  string $key [description]
     * @param  string $value [description]
     * @return [int]         [id do registro manipulado]
     */
    static public function update_or_insert($params = array())
    {
        $usermeta_id = 0;
        $user_id = 0;
        $key = '';
        $value = '';

        extract($params, EXTR_OVERWRITE);

        DB::table('usermeta')
            ->where('user_id', '=', $user_id)
            ->where('meta_key', '=', $key)
            ->delete();

        $term = DB::table('usermeta')
            ->insert(
                array(
                    'user_id' => $user_id,
                    'meta_key' => $key,
                    'meta_value' => $value
                )
            );

        return $term;
    }

    static public function insert_only($user_id, $key, $value)
    {


        $term = DB::table('usermeta')
            ->insert(
                array(
                    'user_id' => $user_id,
                    'meta_key' => $key,
                    'meta_value' => $value
                )
            );

        return $term;
    }

}