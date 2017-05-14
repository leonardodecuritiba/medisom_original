<?php

/**
 *
 */
class Term extends Eloquent
{

    public $timestamps = false;
    protected $table = 'terms';
    protected $primaryKey = 'term_id';

    static public function get($column = '', $compare = '=', $value = '')
    {
        if ($column != '' && $value != '') {
            $terms = DB::table('terms')
                ->join('term_taxonomy', 'terms.term_id', '=', 'term_taxonomy.term_id')
                ->select('terms.term_id', 'terms.name', 'terms.slug', 'term_taxonomy.term_taxonomy_id', 'term_taxonomy.taxonomy', 'term_taxonomy.description', 'term_taxonomy.parent', 'term_taxonomy.count')
                ->where($column, $compare, $value)
                ->get();
        } else {
            $terms = DB::table('terms')
                ->join('term_taxonomy', 'terms.term_id', '=', 'term_taxonomy.term_id')
                ->select('terms.term_id', 'terms.name', 'terms.slug', 'term_taxonomy.term_taxonomy_id', 'term_taxonomy.taxonomy', 'term_taxonomy.parent', 'term_taxonomy.count')
                ->get();
        }
        return $terms;
    }

    /**
     * [update_or_insert atualiza ou insere novo registro]
     * @param  array $params [registros referentes as colunas da tabela]
     * @return [integer]         [retorna id do registro manipulado]
     */
    static public function update_or_insert($params = array())
    {

        $term_id = 0;
        $name = '';
        $slug = '';

        extract($params, EXTR_OVERWRITE);


        if ($term_id) {
            $term = Term::find($term_id);
        } else {
            $term = new Term();
        }

        $term->name = $name;
        $term->slug = $slug;

        $term->save();

        if ($term_id) {
            $params['term_id'] = $term_id;
        } else {
            $params['term_id'] = ($term->id) ? $term->id : DB::getPdo()->lastInsertId();
        }

        TermTaxonomy::update_or_insert($params);

        return $term->id;
    }

    /**
     * [remove exclui permanentemente o registro do id informado]
     * @param  integer $term_id [id do registro a excluir]
     * @return [bool]
     */
    static public function remove($term_id = 0)
    {

        if (is_array($term_id)) {
            $term_id = $term_id['id'];
        }

        $term = Term::find($term_id);
        $term->delete();

        return true;
    }
}