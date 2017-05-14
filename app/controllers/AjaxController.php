<?php

error_reporting(0);

class AjaxController extends BaseController
{
    static public function get_indicadores_by_sensorid($sensorid)
    {
        return json_encode(Post::where('post_id', $sensorid)->first()->content);
    }

    static public function get_only_indicadores_by_sensorid($sensorid, $option = 'single')
    {
        $indicadores = json_decode(Post::where('post_id', $sensorid)->first()->content);
        $retorno = NULL;
        switch ($option) {
            case 'single':
                $_INDICADORES_ = Base::$_INDICADORES_;
                foreach ($indicadores as $indicador) {
                    if (array_key_exists($indicador, $_INDICADORES_)) {
                        $retorno[] = $indicador;
                    }
                }
                break;
            case 'group':
                $_INDICADORES_ = Base::$_GRUPOINDICADORES_;
                foreach ($indicadores as $indicador) {
                    foreach ($_INDICADORES_ as $key => $ind) {
                        if ($indicador == $ind['indice']) {
                            $retorno[] = ['key' => $key, 'nome' => $indicador];
                        }
                    }
                }
                break;
        }
        return json_encode($retorno);
    }
}
