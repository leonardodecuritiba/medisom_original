<?php

/**
 *
 */
class Localization extends Eloquent
{

    public $timestamps = false;
    protected $table = 'localization';
    protected $primaryKey = 'id';

    /**
     * [get_by busca os regitro baseados nos params informados]
     * @param  string $column [nome da coluna na tabela a buscar]
     * @param  string $value [valor a comparar]
     * @param  string $compare [operador de comparação: =, !=, >, <,]
     * @return [array]         [resultado em array]
     */
    static public function get($params)
    {


        $s = '';

        extract($params, EXTR_OVERWRITE);

        if ($s != '') {
            $local = Localization::where('cidade', 'like', $s . "%")->get();
        }
        return $local;
    }


}