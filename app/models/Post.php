<?php

/**
 *
 */
class Post extends Eloquent
{

    protected $table = 'posts';
    protected $primaryKey = 'post_id';
    protected $fillable = array(
        'post_id',
        'post_author',
        'title',
        'content',
        'expert',
        'status',
        'parent',
        'order',
        'type',
        'slug',
        'url',
        'mime_type'
    );

    static public function list_id_active_sensors()
    {
        return Post::where('type', '=', 'sensor')->where('status', '=', 'publish')->lists('post_id');
    }

    static public function existe_sensor_title($title)
    {
        return Post::where('title', $title)->count();
    }

    /**
     * [get_by busca os regitro baseados nos params informados]
     * @param  string $column [nome da coluna na tabela a buscar]
     * @param  string $value [valor a comparar]
     * @param  string $compare [operador de comparação: =, !=, >, <,]
     * @return [array]         [resultado em array]
     */
    static public function get($params)
    {


        $column = '';
        $compare = '';
        $value = '';

        extract($params, EXTR_OVERWRITE);

        if ($column != '' && $value != '') {
            $posts = Post::where($column, $compare, $value)->get();
        } else {
            $posts = Post::all();
        }
        return $posts;
    }

    /**
     * [update_or_insert atualiza ou insere novo registro]
     * @param  array $params [registros referentes as colunas da tabela]
     * @return [integer]         [retorna id do registro manipulado]
     */
    static public function update_or_insert($params = array())
    {

        $post_id = 0;
        $post_author = 1;
        $title = '';
        // content
        $measures = '';
        $alert_time = '';
        $alert_type = '';
        $alert_num = '';
        $alert_day = '';
        $visualization_dash = '';

        $expert = '';
        $status = 'publish';
        $parent = 0;
        $order = 0;
        $type = 'product';
        $slug = '';
        $url = '';
        $mime_type = '';

        extract($params, EXTR_OVERWRITE);

        $slug_alternative = $type . '-' . BaseController::transformWords(true, $title, array('b' => array(' '), 's' => array('-')));
        $slug = ($slug == '') ? $slug_alternative : $slug;
        $slug .= "-" . md5($title);
        $url = ($url == '') ? Option::get('url_site') . '/admin/' . $type . '/' . $slug : $url . md5($title);

        if ($post_id) {
            $post = Post::find($post_id);
        } else {
            $post = new Post();
        }

        if (($type == 'sensor') || ($type == 'report')) {
            $content = json_encode($measures);
        }

//		return $url;

        $post->post_author = $post_author;
        $post->title = $title;
        $post->content = $content;
        $post->expert = $expert;
        $post->status = $status;
        $post->parent = $parent;
        $post->order = $order;
        $post->type = $type;
        $post->slug = $slug;
        $post->url = $url;
        $post->mime_type = $mime_type;

//		return $post;
        $post->save();

        return $post->post_id;
    }

    /**
     * [remove exclui permanentemente o registro do id informado]
     * @param  integer $post_id [id do registro a excluir]
     * @return [bool]
     */
    static public function remove($post_id = 0)
    {
        $post = Post::where('post_id', '=', $post_id);
        $post->delete();

        return true;
    }

    static public function removeDataSensor($post_id = 0)
    {
        //REMOVER SENSOR / ALERTAS
        //remover todos os postmetas com o id do sensor (alertas)
        Postmeta::where('post_id', $post_id)->delete();

        //REMOVER RELATÓRIOS / REPORTS
        //selecionar todos os relatórios
        $posts_id = Post::where('parent', '=', $post_id)->lists('post_id');
        Post::where('parent', '=', $post_id)->delete();

        //selecionar todos os postmetas com o id do relatório
        $postmeta_id = Postmeta::whereIn('post_id', $posts_id)->lists('postmeta_id');
        Postmeta::whereIn('post_id', $posts_id)->delete();

        //selecionar todos os reports com o id do postmetas
        Reports::whereIn('postmeta_id', $postmeta_id)->delete();

        //selecionar todos os reports com o id do postmetas
        SensorLog::where('post_id', $post_id)->delete();

        /*
        echo 'RELATÓRIOS / REPORTS ';print_r('<br>');
        echo 'posts_id '; print_r($posts_id); print_r('<br>');
        echo 'postmeta_id '; print_r($postmeta_id); print_r('<br>');
        echo 'reports_id '; print_r($reports_id); print_r('<br>');
        exit;
        */

        return true;
    }

    static public function update_status()
    {
        $post = Post::find(Input::get('post_id'));
        $post->status = Input::get('status');
        if ($post->save()) {
            return true;
        }
        return false;

    }

    static public function getPublishedReportBySensorID($sensor_id)
    {
        $report['Post'] = Post::where('type', 'report')
            ->where('status', 'publish')
            ->where('parent', $sensor_id)->first();
        if (count($report['Post']) > 0) {
            $report['Postmeta'] = (object)Postmeta::get_transform_report($report['Post']->post_id);
            $report['Sensor'] = Post::find($report['Post']->parent);
            $report['User'] = User::find($report['Post']->post_author);
            $retorno = $report;
        } else {
            $retorno = 0;
        }
        return $retorno;
    }

    static public function getPublishedReportByPostID($post_id)
    {
        $report['Post'] = Post::find($post_id);
        if (count($report['Post']) > 0) {
            $report['Postmeta'] = (object)Postmeta::get_transform_report($report['Post']->post_id);
            $report['Sensor'] = Post::find($report['Post']->parent);
            $report['User'] = User::find($report['Post']->post_author);
            $retorno = $report;
        } else {
            $retorno = 0;
        }
        return $retorno;
    }
//    public function sensormeta_ultimo()
//    {
//        return $this->hasMany('Sensormeta', 'sensor_id', 'post_id');
//        return $this->sensormetas()->get();
//            ->orderBy('last_activity', 'asc');
//    }

    static public function updatePublishedReport($Report)
    {
        //Saving POS
        $Post = $Report['Post'];
        $Post->save();

        $Postmeta = Postmeta::get_original_report($Report['Postmeta']);
        $Postmeta->save();

        return $Report;
    }

    public function postmeta($post_id, $key = '')
    {
        return Postmeta::get($post_id, $key);
    }

    public function author($post_id)
    {
        return User::find($post_id);
    }

    public function post_author()
    {
        return $this->belongsTo('User', 'user_id', 'post_author');
    }

    public function owner()
    {
        return $this->belongsTo('User', 'post_author', 'user_id');
    }
    /* ********************* SENSOR ********************* */

    public function alerts()
    {
        return $this->hasMany('Alerts', 'post_id');
    }

    public function last_sensormeta()
    {
        return $this->sensormetas()->first();
//        ->where('alert_day', $hoje->format('Y-m-d'))
//        ->first();
    }

    /* ********************* REPORT ********************* */

    public function sensormetas()
    {
        return $this->hasMany('Sensormeta', 'sensor_id', 'post_id');
    }

    public function sensormeta()
    {
        return $this->sensormetas()->orderBy('last_activity', 'dsc');
    }

    public function terms($object_id, $term_taxonomy_id)
    {
        $terms = DB::table('term_relationships')
            ->join('term_taxonomy', 'term_relationships.term_taxonomy_id', '=', 'term_taxonomy.term_taxonomy_id')
            ->leftJoin('terms', 'terms.term_id', '=', 'term_taxonomy.term_id')
            ->select('terms.term_id', 'terms.name', 'terms.slug', 'term_taxonomy.term_taxonomy_id', 'term_taxonomy.taxonomy', 'term_taxonomy.parent', 'term_taxonomy.count')
            ->where('term_relationships.object_id', '=', $object_id)
            ->where('term_relationships.term_taxonomy_id', '=', $term_taxonomy_id)
            ->get();

        return $terms;
    }
}