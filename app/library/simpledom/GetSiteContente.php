<?php

set_time_limit(10000000);

#include app_path()."\library\simpledom\simple_html_dom.php";


class GetSiteContent
{


    function search($repository = '', $url = '', $s_param = '', $search = '')
    {

        $repositories = $this->repositories($repository, $url, $s_param, $search);

        $result = $this->get($repositories);

        return $result;

    }

    /**
     * repositorios
     * @param  string $url parametro unico, url do site a ser varrido
     * @param  string $s_param parametro unico, parametro de busca do site
     * @param  string $search parametro unico, busca efetuada
     * @return array
     */
    function repositories($repo, $url, $s_param, $search)
    {

        $search = str_replace(' ', '+', $search);


        $repositories = Post::get_by('title', '=', $repo);

        foreach ($repositories as $repostory) {
            $postmetas = Postmeta::get_by('post_id', $repostory->post_id, '=');

            if (count($postmetas) > 0) {
                foreach ($postmetas as $postmeta) {
                    if ($postmeta->key == 'elements') {
                        $elements = json_decode($postmeta->value);
                        $postmeta_id = $postmeta->postmeta_id;
                    }

                }


                $i = 0;
                foreach ($elements as $value) {

                    $element[] = (object)array(
                        'n' => $i + 1,
                        'title' => $value->elements_title,
                        'content' => $value->elements_content,
                        'element' => $value->elements_element,
                        'dom' => $value->elements_dom,
                        'item' => $value->elements_item,
                        'single' => $value->elements_single,
                    );
                }
            } else {
                $element = array();
                $postmeta_id = 0;
            }
            $postmeta = (object)$element;

            foreach ($postmeta as $post) {
                if ($post->title == 'url') {
                    $repositorio[$post->title] = array(
                        'single' => $post->single,
                        'content' => $post->content,
                        'element' => $url,
                        'dom' => $post->dom,
                        'item' => $post->item
                    );
                }
                if ($post->title == 's_param') {
                    $repositorio[$post->title] = array(
                        'single' => $post->single,
                        'content' => $post->content,
                        'element' => $s_param,
                        'dom' => $post->dom,
                        'item' => $post->item
                    );
                }
                if ($post->title == 's') {
                    $repositorio[$post->title] = array(
                        'single' => $post->single,
                        'content' => $post->content,
                        'element' => $search,
                        'dom' => $post->dom,
                        'item' => $post->item
                    );
                }
                if ($post->title != 'url' && $post->title != 's_param' && $post->title != 's') {
                    $repositorio[$post->title] = array(
                        'single' => $post->single,
                        'content' => $post->content,
                        'element' => $post->element,
                        'dom' => $post->dom,
                        'item' => $post->item
                    );
                }
            }
        }
        $r[] = $repositorio;
        #print_r($r);
        return $r;

    }

    /**
     * get
     * @param  array $params busca o conteudo com base nas tags informadas no repositories
     * @return array         retorna um array com todos itens encontrados
     */
    public function get($repositorio)
    {

        foreach ($repositorio as $value) {
            foreach ($value as $k => $v) {

                $v = (object)$v;

                if ($v->dom == 'param') {
                    $param[$v->item] = $v->element;

                    if ($v->item == 'next') {
                        $param['paginate_content'] = (isset($v->content) && $v->content != '') ? $v->content : '';
                        $param['next'] = (isset($v->element) && $v->element != '') ? $v->element : '';
                        $param['item'] = (isset($v->n) && $v->n != '') ? $v->n : 0;
                        $param['url_site'] = (isset($v->url_site) && $v->url_site != '') ? $v->url_site : '';
                    }
                    if ($v->item == 'url_to_single') {
                        $param['url_to_single'] = (isset($v->element) && $v->element != '') ? $v->element : false;
                    }
                    $params = (object)$param;

                } else {
                    $tag[$k] = (object)array(
                        'single' => (isset($v->single) && $v->single != '') ? $v->single : 0,
                        'content' => (isset($v->content) && $v->content != '') ? $v->content : '',
                        'element' => (isset($v->element) && $v->element != '') ? $v->element : '',
                        'dom' => (isset($v->dom) && $v->dom != '') ? $v->dom : '',
                        'item' => (isset($v->item) && $v->item != '') ? $v->item : 0);
                    $tags = (object)$tag;
                }

            }
        }

        #print_r($params);

        $return = array();

        $html = new simple_html_dom($params->url . $params->s_param . $params->s);


        if ($params->next) {
            foreach ($html->find($params->paginate_content) as $p) {
                $pagination = $p->find($params->next, $params->item)->href;
                $result['next'] = $pagination;
                if ($params->url_site) {
                    $result['next'] = $params->url . $pagination;
                }
            }
        }


        foreach ($html->find($params->content) as $e):

            foreach ($tags as $key => $value) {

                $dom = $tags->$key->dom;
                $element = $tags->$key->element;
                $item = $tags->$key->item;

                if ($key == 'link') {

                    $link_single = $e->find($element, $item)->$dom;
                    $return[$key] = $e->find($element, $item)->$dom;
                } else {
                    if (!$tags->$key->single) {
                        #echo $key.' = '.$element.','.$item.'->'.$dom;
                        $return[$key] = $e->find($element, $item)->$dom;
                    }
                }

                if ($tags->$key->single) {

                    $url_single = $link_single;

                    if (isset($params->url_to_single) && $params->url_to_single != '') {

                        $url_single = str_replace('//', '/', $params->url_to_single . $url_single);

                    }

                    $return['url_single'] = $url_single;

                    $html_single = new simple_html_dom($url_single);

                    foreach ($html_single->find($tags->$key->content) as $ee) {

                        $return[$key] = $ee->find($element, $item)->$dom;

                    }

                }

            }

            $result[] = $return;


        endforeach;

        $result = $result;

        return $result;
    }

    public function testUrl($url = '', $repository = '', $search_parameter = '', $search = '')
    {

        $html = file_get_html($url);


        print_r($html);

    }


}
/*
$search = (isset($_REQUEST['s']) && $_REQUEST['s'] != '')?$_REQUEST['s']:'';


$url = 'http://presuntovegetariano.com.br/category/videos/';
$search_parameter = '';
$repository = 'presuntovegetariano';


$url = 'http://filmesdoyoutube.net/';
$search_parameter = '?s=';
$repository = 'filmesdoyoutube';

$url = 'http://www.guiamais.com.br/';
$search_parameter = 'busca/';
$repository = 'guiamais';


$url = 'http://www.guiamais.com.br/';
$search_parameter = 'busca/';
$repository = 'guiamais';



$url = 'http://www.saborintenso.com/chef/caderno-41/';
$search_parameter = '';
$repository = 'saborintenso';


$qtd_pages = 0;
$qtd_results = 0;

$s = new GetSiteContent(); */
/*
$r = $s->testUrl('http://receitasdeminuto.com/categoria/video/');

$r[] = $s->search($repository, $url, $search_parameter, $search);*/
/*
for($i=0;$i<$qtd_pages;$i++){
	if ( $r[$i]['next'] != '') {
		$r[] = $s->search($repository, $r[$i]['next'], $search_parameter, $search);
	}
}

print '<pre>';
print_r($r);*/