<?php

/**
 *
 */
class TermTaxonomy extends Eloquent
{

    public $timestamps = false;
    protected $table = 'term_taxonomy';
    protected $primaryKey = 'term_taxonomy_id';

    /**
     * [update_or_insert atualiza ou insere novo registro]
     * @param  array $params [registros referentes as colunas da tabela]
     * @return [integer]         [retorna id do registro manipulado]
     */
    static public function update_or_insert($params = array())
    {

        $term_taxonomy_id = 0;
        $term_id = 0;
        $taxonomy = '';
        $description = '';
        $parent = 0;
        $count = 0;

        extract($params, EXTR_OVERWRITE);

        if ($term_taxonomy_id) {
            $term_taxonomy = TermTaxonomy::find($term_taxonomy_id);
        } else {
            $term_taxonomy = new TermTaxonomy();
        }

        $term_taxonomy->term_id = $term_id;
        $term_taxonomy->taxonomy = $taxonomy;
        $term_taxonomy->description = $description;
        $term_taxonomy->parent = $parent;
        $term_taxonomy->count = $count;

        $term_taxonomy->save();

        return $term_taxonomy->term_taxonomy_id;
    }

    /**
     * [remove exclui permanentemente o registro do id informado]
     * @param  integer $term_taxonomy_id [id do registro a excluir]
     * @return [bool]
     */
    static public function remove($term_taxonomy_id = 0)
    {
        $term_taxonomy = TermTaxonomy::where('term_taxonomy_id', '=', $term_taxonomy_id);
        $term_taxonomy->delete();

        return true;
    }

    public function term()
    {
        return $this->belongsTo('Term', 'term_id');
    }
}