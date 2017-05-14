<?php

/**
 *
 */
class TermRelationships extends Eloquent
{

    public $timestamps = false;
    protected $table = 'term_relationships';
    protected $primaryKey = 'object_id';

    static public function get($column = '', $compare = '=', $value = '')
    {
        if ($column != '' && $value != '') {
            $terms = DB::table('term_relationships')
                ->join('term_taxonomy', 'term_relationships.term_taxonomy_id', '=', 'term_taxonomy.term_taxonomy_id')
                ->leftJoin('terms', 'terms.term_id', '=', 'term_taxonomy.term_id')
                ->select('terms.term_id', 'terms.name', 'terms.slug', 'term_taxonomy.term_taxonomy_id', 'term_taxonomy.taxonomy', 'term_taxonomy.parent', 'term_taxonomy.count')
                ->where($column, $compare, $value)
                ->get();
        } else {
            $terms = DB::table('term_relationships')
                ->join('term_taxonomy', 'term_relationships.term_taxonomy_id', '=', 'term_taxonomy.term_taxonomy_id')
                ->leftJoin('terms', 'terms.term_id', '=', 'term_taxonomy.term_id')
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
    static public function update_or_insert($object_id, $term_taxonomy_id, $term_order = 0)
    {

        DB::table('term_relationships')
            ->where('object_id', '=', $object_id)
            ->where('term_taxonomy_id', '=', $term_taxonomy_id)
            ->delete();

        $term = DB::table('term_relationships')
            ->insert(
                array(
                    'object_id' => $object_id,
                    'term_taxonomy_id' => $term_taxonomy_id,
                    'term_order' => $term_order
                )
            );


        return $term;
    }

}