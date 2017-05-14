<?php

/**
 *
 */
class Purchase extends Eloquent
{

    protected $table = 'purchases';

    /**
     * [get_by busca os regitro baseados nos params informados]
     * @param  string $column [nome da coluna na tabela a buscar]
     * @param  string $value [valor a comparar]
     * @param  string $compare [operador de comparação: =, !=, >, <,]
     * @return [array]         [resultado em array]
     */
    static public function get_by($column = '', $value = '', $compare = '=')
    {
        if ($column != '' && $value != '') {
            $purchases = Purchase::where($column, $compare, $value)->get();
        } else {
            $purchases = Purchase::all();
        }
        return $purchases;
    }

    /**
     * [update_or_insert atualiza ou insere novo registro]
     * @param  array $params [registros referentes as colunas da tabela]
     * @return [integer]         [retorna id do registro manipulado]
     */
    static public function update_or_insert($params = array())
    {

        $purchase_id = 0;
        $user_id = Auth::id();
        $post_id = 0;
        $qtd = 0;
        $value = 0;
        $status = 'publish';
        $date_purchase = '';

        extract($params, EXTR_OVERWRITE);

        if ($purchase_id) {
            $purchase = Purchase::find($purchase_id);
        } else {
            $purchase = new Purchase();
        }

        $purchase->user_id = $user_id;
        $purchase->post_id = $post_id;
        $purchase->qtd = $qtd;
        $purchase->value = $value;
        $purchase->status = $status;

        if ($date_purchase) {
            $purchase->date_purchase = $date_purchase;
        }

        $purchase->save();

        return $purchase->purchase_id;
    }

    /**
     * [remove exclui permanentemente o registro do id informado]
     * @param  integer $purchase_id [id do registro a excluir]
     * @return [bool]
     */
    static public function remove($purchase_id = 0)
    {
        $purchase = Purchase::where('purchase_id', '=', $purchase_id);
        $purchase->delete();

        return true;
    }
}