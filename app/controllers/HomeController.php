<?php

class HomeController extends BaseController
{

    public function coming()
    {

        $rodape = Post::where('type', '=', 'page')->where('slug', '=', 'foot-contact')->first();;
        return View::make('site.coming-soon', array('rodape' => $rodape));

    }

    public function home($post = '')
    {


        if ($post) {

            return View::make('site.single');
        }

        $posts = DB::table('posts')->where('status', '=', 'publish')->where('type', '=', 'post')->get();
        $categories = Term::get('term_taxonomy.taxonomy', '=', 'blog');
        $clients = DB::table('posts')->where('status', '=', 'publish')->where('type', '=', 'client')->get();
        $banners = DB::table('posts')->where('type', '=', 'banner_home')->where('status', '=', 'publish')->get();
        foreach ($banners as $banner) {
            $datameta[] = json_decode(Post::find($banner->post_id)->postmeta($banner->post_id, 'banner'));
        }

        $rodape = Post::where('type', '=', 'page')->where('slug', '=', 'foot-contact')->first();;
        return View::make('site.home', array('posts' => $posts, 'banners' => $datameta, 'clients' => $clients, 'categories' => $categories, 'rodape' => $rodape));
    }

    public function about()
    {

        $post = DB::table('posts')->where('type', '=', 'page')
            ->where('slug', '=', 'about')->first();

        $rodape = Post::where('type', '=', 'page')->where('slug', '=', 'foot-contact')->first();;
        return View::make('site.about', array('post' => $post, 'rodape' => $rodape));
    }

    public function services()
    {

//        $post = DB::table('posts')->where('url', '=', Request::url())->get();
        $post = DB::table('posts')->where('type', '=', 'page')
            ->where('slug', '=', 'services')->first();

        $meta = json_decode(Post::find($post->post_id)->postmeta($post->post_id, 'services'), true);
//        $meta = json_decode(Postmeta::where('post_id','=',$post[0]->post_id)->where('meta_key','=', 'services')->get(), true);
//        return $meta;

        if (count($meta) > 0) {
            foreach ($meta as $k => $v) {
                $service[] = $v;
            }

            for ($i = 0; $i < count($service[0]); $i++) {
                $services[] = (object)array(
                    'title' => $service[0][$i],
                    'description' => $service[1][$i]
                );
            }
        } else {
            $services = array();
        }

        $rodape = Post::where('type', '=', 'page')->where('slug', '=', 'foot-contact')->first();;
        return View::make('site.services', array('post' => $post, 'services' => $services, 'rodape' => $rodape));
    }

    public function blog($slug = '')
    {
        $categories = Term::get('term_taxonomy.taxonomy', '=', 'blog');
        if ($slug) {
            $post = DB::table('posts')->where('url', '=', Option::get('url_site') . '/blog/' . $slug)->get();
            $rodape = Post::where('type', '=', 'page')->where('slug', '=', 'foot-contact')->first();
            return View::make('site.blog-single', array('title' => 'Blog', 'post' => $post[0], 'categories' => $categories, 'rodape' => $rodape));
        }

        $posts = DB::table('posts')->where('type', '=', 'post')->where('status', '=', 'publish')->get();
        $rodape = Post::where('type', '=', 'page')->where('slug', '=', 'foot-contact')->first();
        return View::make('site.blog', array('title' => 'Blog', 'posts' => $posts, 'categories' => $categories, 'rodape' => $rodape));
    }

    public function category($slug = '')
    {
        $categories = Term::get('term_taxonomy.taxonomy', '=', 'blog');
        $dataposts = DB::table('posts')->where('type', '=', 'post')->where('status', '=', 'publish')->get();

        foreach ($dataposts as $post) {
            foreach ($categories as $category) {
                if (Post::find($post->post_id)->terms($post->post_id, $category->term_taxonomy_id)) {
                    if ($category->slug == $slug) {
                        $posts[] = $post;
                        $cat_name = $category->name;
                    }
                }
            }
        }

        $rodape = Post::where('type', '=', 'page')->where('slug', '=', 'foot-contact')->first();;
        return View::make('site.category', array('title' => 'Posts na Categoria ' . $cat_name, 'posts' => $posts, 'categories' => $categories, 'rodape' => $rodape));
    }

    public function contact()
    {

        //Mensagem de contato
        if (Request::isMethod('post')) {

            $vars = array(
                'name' => trim(Input::get('name')),
                'email' => trim(Input::get('email')),
                'msg' => trim(Input::get('message')),
                'url_site' => URL::route('contact')
            );

            if (Option::get('radio_smtp_send_active')) {
                EmailController::send_email_contact($vars);
//                Mail::send('emails.user.contato', $vars, function ($message) {
//                    $message->to(Option::get('text_contato_email'), Option::get('text_smtp_nome'))->subject(Option::get('text_emails_user_contato'));
//                });
                Session::flash('alert-code', 'SITE001S');
            } else {
                Session::flash('alert-code', 'SITE001D');
            }
        }

        $post = DB::table('posts')->where('type', '=', 'page')
            ->where('slug', '=', 'contact')->first();

        $rodape = Post::where('type', '=', 'page')->where('slug', '=', 'foot-contact')->first();;
        return View::make('site.contact', array('post' => $post, 'rodape' => $rodape));
    }

    public function orcamento()
    {

        if (Request::isMethod('post')) {
            $slug = BaseController::transformWords(true, trim(Input::get('name')), array('b' => array(' '), 's' => array('-')));


            if (Input::hasFile('doc_cnpj')) {
                $file = Input::file('doc_cnpj');

                $destinationPath = public_path() . '/uploads/docs-cadastro';
                $filename = 'cnpj-' . $slug . '-' . BaseController::transformWords(true, trim($file->getClientOriginalName()), array('b' => array(' ', '_'), 's' => array('-', '-')));
                $upload_success = Input::file('doc_cnpj')->move($destinationPath, $filename);
                if ($upload_success) {
                    $doc_cnpj = $filename;
                }
            } else {
                $doc_cnpj = '';
            }
            if (Input::hasFile('doc_ie')) {
                $file = Input::file('doc_ie');

                $destinationPath = public_path() . '/uploads/docs-cadastro';
                $filename = 'ie-' . $slug . '-' . BaseController::transformWords(true, trim($file->getClientOriginalName()), array('b' => array(' ', '_'), 's' => array('-', '-')));
                $upload_success = Input::file('doc_ie')->move($destinationPath, $filename);
                if ($upload_success) {
                    $doc_ie = $filename;
                }
            } else {
                $doc_ie = '';
            }
            if (Input::hasFile('doc_rg')) {
                $file = Input::file('doc_rg');

                $destinationPath = public_path() . '/uploads/docs-cadastro';
                $filename = 'rg-' . $slug . '-' . BaseController::transformWords(true, trim($file->getClientOriginalName()), array('b' => array(' ', '_'), 's' => array('-', '-')));
                $upload_success = Input::file('doc_rg')->move($destinationPath, $filename);
                if ($upload_success) {
                    $doc_rg = $filename;
                }
            } else {
                $doc_rg = '';
            }
            if (Input::hasFile('doc_cpf')) {
                $file = Input::file('doc_cpf');

                $destinationPath = public_path() . '/uploads/docs-cadastro';
                $filename = 'cpf-' . $slug . '-' . BaseController::transformWords(true, trim($file->getClientOriginalName()), array('b' => array(' ', '_'), 's' => array('-', '-')));
                $upload_success = Input::file('doc_cpf')->move($destinationPath, $filename);
                if ($upload_success) {
                    $doc_cpf = $filename;
                }
            } else {
                $doc_cpf = '';
            }

            $pass = $this->do_token();
            $passHash = Hash::make($pass);

            $vars = array(
                'title' => trim(Input::get('name')),
                'name' => trim(Input::get('name')),
                'post_author' => 3,
                'type' => 'orcamento',
                'slug' => 'orcamento-' . $slug,
                'url' => URL::route('home') . '/admin/usuarios/' . $slug,
                'email' => trim(Input::get('email')),
                'pass' => $pass,
                'password' => $passHash,
                'pessoa_tipo' => trim(Input::get('pessoa_tipo')),
                'contato' => trim(Input::get('contato')),
                'endereco' => trim(Input::get('endereco')),
                'cidade' => trim(Input::get('cidade')),
                'estado' => trim(Input::get('estado')),
                'cep' => trim(Input::get('cep')),
                'bairro' => trim(Input::get('bairro')),
                'phones' => trim(Input::get('phones')),
                'fax' => trim(Input::get('fax')),
                'ref' => trim(Input::get('ref')),
                'cpf' => trim(Input::get('cpf')),
                'cnpj' => trim(Input::get('cnpj')),
                'ie' => trim(Input::get('ie')),
                'correspondencia' => trim(Input::get('correspondencia')),
                'pagamento' => trim(Input::get('pagamento')),
                'prazo' => trim(Input::get('prazo')),
                'pagamento_outro' => trim(Input::get('pagamento_outro')),
                'prazo_dias' => trim(Input::get('prazo_dias')),
                'doc_cnpj' => $doc_cnpj,
                'doc_ie' => $doc_ie,
                'doc_rg' => $doc_rg,
                'doc_cpf' => $doc_cpf,
                'url_site' => URL::route('orcamento')
            );

            $user = User::update_or_insert($vars);

            if ($user) {
                foreach ($vars as $k => $v) {
                    if ($v) Usermeta::update_or_insert(array('user_id' => $user, 'key' => $k, 'value' => $v));
//                        $postmeta = Usermeta::update_or_insert(array('user_id' => $user, 'key' => $k, 'value' => $v));
                }

                if (Option::get('radio_smtp_send_active')) {
                    EmailController::send_email_estimate($vars);
//                    Mail::send('emails.user.orcamento', $vars, function ($message) {
//                        $message->to(Option::get('text_smtp_email'), Option::get('text_smtp_nome'))->subject(Option::get('text_emails_user_orcamento'));
//                    });
                }

                Session::flash('alert-code', 'SITE002S');
            } else {
                Session::flash('alert-code', 'SITE002D');
            }
        }

        $rodape = Post::where('type', '=', 'page')->where('slug', '=', 'foot-contact')->first();;
        return View::make('site.orcamento', array('title' => 'Solicitar Orçamento', 'rodape' => $rodape));
    }

    public function search($search)
    {

        $posts = DB::table('posts')->where('status', '=', 'publish')->whereRaw('type IN ("page","post") AND ( title LIKE "%' . $search . '%" or content LIKE "%' . $search . '%")')->get();
        $rodape = Post::where('type', '=', 'page')->where('slug', '=', 'foot-contact')->first();;
        return View::make('site.search', array('title' => 'Busca', 'posts' => $posts, 'search' => $search, 'rodape' => $rodape));
    }

    public function single()
    {

        $post = DB::table('posts')->where('type', '=', 'page')->where('url', '=', Request::url())->get();

        $rodape = Post::where('type', '=', 'page')->where('slug', '=', 'foot-contact')->first();
        return View::make('site.single', array('post' => $post[0], 'rodape' => $rodape));
    }

}
