<?php

class AdminController extends BaseController
{

    static public function charts($sensor_id = 0, $build = '')
    {
        if ($sensor_id) {
            if (count($build)) {
                $buildLine = DB::table('sensores_log');
            }
        }
    }

    static public function report($post_id, $graficos)
    {
        $query = DB::table('posts')->where('post_id', $post_id)
            ->where('type', 'sensor')->where('status', 'publish');
        if (Auth::user()->group_id == 1) {
            $sensor = $query->first();
        } else {
            $sensor = $query->where('post_author', Auth::id())->first();
        }

        return View::make('admin.report.report-details', array(
            'sensor' => $sensor,
            'Graficos' => ReportController::getGrupoIndicadoresStr($graficos)));
    }

    static public function report_manual($post_id, $type)
    {

        // Se for um usuário administrador, seleciona o sensor de um determinado dono
        if (Auth::user()->group_id == 1) {
            $sensores = DB::table('posts')->where('post_id', $post_id)->where('type', 'sensor')->where('status', 'publish')->orderBy('post_author', 'desc')->get();
        } else {
            // Senão, seleciona o próprio sensor
            $sensores = DB::table('posts')->where('post_id', $post_id)->where('type', 'sensor')->where('post_author', Auth::id())->where('status', 'publish')->get();
        }

        $sensores = BaseController::getDataSensors($sensores);
//        return $sensores;
        return View::make('admin.report-MANUAL', array('sensores' => $sensores, 'graph' => $type));
    }

    static public function genPrintableReport($report_id, $token)
    {
        $REPORT = ReportController::genPrintableReport($report_id, $token);
        return View::make('admin.report.report-custom-print', array(
            'title' => 'Relatório Agendado',
            'REPORT' => $REPORT));
    }

    static public function print_report()
    {

        //Essa função significa que o usuário está gerando o REPORT
        //Depois que o usuário gerar o PDF, vamos guardar os dados em PDF
        //VAMOS usar uma variável TIPO para identificar se é DADOS ou PDF para ser exibido ou SER GERADO
        //se for DADOS, quando o usuário abrir pela primeira vez, irá ser gerado um PDF  e guardado no BANCO no
        //mesma tupla
        $report = Input::get('report');
        //criar VIEW
        return View::make('admin.report.report-manual-print', array(
            'title' => 'Relatório Agendado',
            'report' => $report));
    }

    static public function get_report_aux($reports_id, $token)
    {

        //Essa função significa que o usuário está gerando o REPORT
        //Depois que o usuário gerar o PDF, vamos guardar os dados em PDF
        //VAMOS usar uma variável TIPO para identificar se é DADOS ou PDF para ser exibido ou SER GERADO
        //se for DADOS, quando o usuário abrir pela primeira vez, irá ser gerado um PDF  e guardado no BANCO no
        //mesma tupla
        $meta_key = Crypt::decrypt($token);
        $report = Reports::get($reports_id, $meta_key, 1);

        //logo da Medisom
        $path = asset('public/uploads/LogoMedisom128px.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $logo = file_get_contents($path);

        //opcoes
        $options = (object)[
            'filename' => 'medisom.pdf',
            'logo' => 'data:image/' . $type . ';base64,' . base64_encode($logo)
        ];

//        return $report;
        //criar VIEW
        return View::make('admin.report-custom-print-aux', array(
            'title' => 'Relatório Agendado',
            'options' => $options,
            'report' => $report));
    }

    static public function run_report_manual()
    {
//        return 1;
        set_time_limit(180);
        $debug = 0;
        $ReportController = new ReportController(0, $debug, 'manual');
        $dataReport = $ReportController->fake_report();
        print_r(json_encode($dataReport));
    }

    static public function run_alert_check()
    {
        $alerts = Alerts::where('status', '=', 1)->get();
        $AlertController = new AlertController(0);
        $AlertController->run($alerts);
//        $AlertController->run([102]);
        print_r("<br>***** FIM DA CHECAGEM DOS ALERTAS ******<br>");
        return;
    }

    static public function run_report_check()
    {
        $debug = 0;
        //localhost/workana/medisom/verify-reports-run
        set_time_limit(360);
        $ids_report = Post::where('type', '=', 'report')->where('status', '=', 'publish')->lists('post_id');
        $data_agora = \Carbon\Carbon::now();
        $time_agora = $data_agora->timestamp;

        print_r("***** INÍCIO DA CHECAGEM DOS REPORTS (" . $data_agora->format('Y-m-d H:i') . ") ******<br><br>");
        print_r('REPORTS (ID) = ');
        print_r(json_encode($ids_report));
        print_r("<br>___________________________________________________________<br>");
        print_r("___________________________________________________________<br>");

        if ($debug > 0) {
            print_r("****** CHECAGEM EM TESTE ******<br>");
            print_r("___________________________________________________________<br><br>");
        }


        foreach ($ids_report as $report_id) {
//            $report_id = $ids_report[2];
            print_r("<br>report_id = " . $report_id . "<br>");

            $report = (object)Postmeta::get_transform_report($report_id);
            print_r("report_exe_calendar = " . $report->report_exe_calendar . "<br>");
            print_r("name = " . $report->post->title . "<br>");
            //ler data
            $time_report = strtotime($report->report_exe_calendar);
            //testar se já chegou o prazo de geração
            if ($time_report < $time_agora) {
                print_r("RODAR: " . $report->post->title . "<br>");

                $ReportController = new ReportController($report_id, $debug, 'agendado');

                //aqui vamos apenas guardar no banco
                //na primeira vez, guardar os dados do report no banco: contendo
                //Mandar um link com referência a essa tupla do banco para que possamos gerar um relatório pela primeira vez
                $flag_email_report = $ReportController->run('report'); //retorna o reports_id

                print_r("******* flag_email_report = " . $flag_email_report . "<br>");

                if ($flag_email_report > 0) {
                    //Email com link
                    $ReportController->send_email_reminder_report($flag_email_report); //retorna 1
                }
            }
            print_r("___________________________________________________________<br>");
        }
        print_r("<br>***** FIM DA CHECAGEM DOS REPORTS ******<br>");
        return;
    }

    public function dashboard()
    {

        if (Auth::user()->group_id == 2) {
            $sensores = Post::where('type', 'sensor')->where('post_author', Auth::user()->parent)->where('status', 'publish')->get();
        } else if (Auth::user()->group_id == 1) {
            $sensores = Post::where('type', 'sensor')->where('status', 'publish')->orderBy('post_author', 'desc')->get();
        } else {
            $sensores = Post::where('type', 'sensor')->where('post_author', Auth::id())->where('status', 'publish')->get();
        }

        $sms = $this->SMSAPI_initialize();
        $Colors = ReportController::$Colors;
        #$this->SMSAPI_enviar('554888394340', 'Medisom - teste de envio sms');

//        $sensores = BaseController::getDataSensors($sensores);
//        $sensores = $sensores[0];
//        return $sensores;
        return View::make('admin.dashboard', array('sensores' => $sensores, 'sms' => $sms, 'Colors' => $Colors, 'DashboardPeriods' => array_slice(Base::$_DASHBOARD_PERIODS_, 0, 5), 'Indicadores' => Base::$_INDICADORES_));
    }

//    public function alerts($alert_id = 0, $action = '')
//    {
//
//        if ($action == 'novo') {
//            $route = 'admin.alerts';
//            $array_response = [
//                'title' => 'Novo Alerta',
//                'action' => 'novo',
//                'sensores' => Auth::user()->sensors_published(),
//                'Indicadores' => Base::$_INDICADORES_,
//                'Condicoes' => Base::$_ALERT_CONDITIONS_
////                'Indicadores' => ReportController::$Indicadores,
////                'Condicoes' => AlertController::$Condicoes
//            ];
//        } else if ($action == 'logs') {
//            $alert_count = 0;
//            if (Auth::user()->group_id == 1) {
//                $alerts = json_decode(Option::get('log_alert_all'));
//            } else {
//                $alerts = json_decode(Option::get('log_alert_' . Auth::id()));
//            }
//            if (count($alerts)) {
//                foreach ($alerts as $alert) {
//                    $nlog[] = array('sensor' => $alert->sensor, 'name' => $alert->name, 'value' => $alert->value, 'date' => $alert->date, 'type' => $alert->type, 'read' => true, 'msg' => $alert->msg);
//                    $alert_count++;
//                }
//
//                if ($alert_count) {
//                    if (Auth::user()->group_id == 1) {
//                        Option::update_or_insert('log_alert_all', json_encode($nlog));
//                    } else {
//                        Option::update_or_insert('log_alert_' . Auth::id(), json_encode($nlog));
//                    }
//                }
//            }
//
//            $route = 'admin.alerts';
//            $array_response = array(
//                'alerts' => $alerts,
//                'action' => 'logs',
//                'title' => 'Log de Alertas'
//            );
//        } else { //ver todos
//            return AlertController::index();
//        }
//        return View::make($route, $array_response);
//    }

    public function share($method)
    {
        if ($method == 'save') {
            $data = urldecode($_POST['imageData']);
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);

            file_put_contents('public/uploads/share/' . Auth::user()->user_id . '-' . time() . '.png', $data);

            echo Auth::user()->user_id . '-' . time() . '.png';
        } else if ($method == 'share') {

            $image = Input::get('img_shared');

            if (Input::get('share_email') != '') {
                $emails = explode(',', Input::get('share_email'));
                foreach ($emails as $mail) {
                    $vars = array(
                        'name' => Auth::user()->name,
                        'url_site' => URL::route('admin.dashboard')
                    );

                    $email_data = [
                        'vars' => $vars,
                        'mail' => $mail,
                        'image' => $image,
                    ];
                    EmailController::send_email_user_share_mail($email_data);

//                    Mail::send('emails.user.compartilhar-por-email', $vars, function ($message) use ($to, $image) {
//                        $message->to($to)->subject(Option::get('text_emails_user_compartilhar-por-email'));
//                        $message->attach('public/uploads/share/' . $image);
//                    });
                }
            }
            if (Input::get('share_users') != '') {
                $users[] = Input::get('share_users');
                foreach ($users as $uid) {
                    $user = User::find($uid);
                    $email_data = [
                        'vars' => $vars,
                        'user' => $user,
                        'image' => $image,
                    ];
                    EmailController::send_email_user_share($email_data);
//                    Mail::send('emails.user.compartilhar', $vars, function ($message) use ($user, $image) {
//                        $message->to($user->email, $user->name)->subject(Option::get('text_emails_user_compartilhar'));
//                        $message->attach('public/uploads/share/' . $image);
//                    });

                    Usermeta::insert_only($user->user_id, 'shared', $image);
                }
            }

            echo true;
        }
    }

    public function reminder_password($action = '', $token = '')
    {
        if (Auth::check()) {
            return Redirect::route('admin.dashboard');
        } else if ($action == 'send_email') {
            $email = Input::get('email');
            $user = User::where('email', $email)->first();
            if ($user != '') {
                $email_data['url_token'] = URL::to('reminder/reset', $user->remember_token);
                $email_data['time_token'] = Config::get('auth.reminder.expire', 60);
                $email_data['name'] = $user->name;
                $email_data['email'] = $email;
                $email_data['titulo'] = 'Recuperar Senha';
                EmailController::send_email_reminder_password($email_data);
                return View::make('admin.reminder', array('sucesso' => 'Enviamos um email para redefinir sua senha.', 'title' => 'Recuperar Senha'));
            } else {
                return Redirect::back()->withErrors(array('Email não cadastrado no sistema.'));
            }
        } else if ($action == 'reset') {
            $user = User::where('remember_token', $token)->first();
            if ($user != '') {
                return View::make('admin.reminder', array('user' => $user, 'title' => 'Recuperar Senha'));
            } else {
                return View::make('admin.reminder', array('title' => 'Recuperar Senha'))->withErrors(array('Este Link é inválido. Por favor tente novamente!'));
            }

        } else if ($action == 'renew_password') {

            $password = Input::get('password');
            if (strlen($password) < 6) {
                return Redirect::back()->withErrors(array('A senha deve ter no mínimo 6 caracteres.', 'title' => 'Recuperar Senha'));
            }
            if ($password != Input::get('cpassword')) {
                return Redirect::back()->withErrors(array('Os campos Senha e Confirmar Senha devem ser iguais.', 'title' => 'Recuperar Senha'));
            }
            $email = Input::get('email');
            $user = User::where('email', $email)->first();
            $user->password = Hash::make($password);
            $user->remember_token = Str::random(60);
            $user->save();
            Auth::attempt(array('email' => $email, 'password' => $password, 'active' => 1), 1);
            return Redirect::route('admin.dashboard');
        } else {
            return View::make('admin.reminder', ['title' => 'Recuperar Senha']);
        }
    }

    public function login($action = '')
    {
        if (Auth::check()) {
            return Redirect::route('admin.dashboard');
        } else if ($action == 'authorize') {
            if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password'), 'active' => 1), Input::get('rememberme'))) {
                return Redirect::route('admin.dashboard');
            } else {
                return Redirect::back()->withErrors(array('Usuário ou senha inválidos.'));
            }
        } else {
            return View::make('admin.login');
        }
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::route('home');
    }

    public function register($action = '')
    {
        if ($action == 'register') {
            $regras = ['name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'passwordconfirm' => 'required|same:password'];

            //executando validação
            $validacao = Validator::make(Input::all(), $regras);

            //se a validação deu errado
            if ($validacao->fails()) {
                return Redirect::back()->withErrors($validacao);
            } else {

                $user = new User;
                $user->name = trim(Input::get('name'));
                $user->email = trim(Input::get('email'));
                $user->password = Hash::make(trim(Input::get('password')));
                $user->save();

                /*
                  Mail::send('emails.auth.register', array('name' => Input::get('name'), 'email' => Input::get('email'), 'password' => Input::get('password') ), function($message){
                  $message->to(Input::get('email'),Input::get('name'))->subject(BaseController::getConfig('subject_emails_auth_register'));
                  });
                 */
                if (Auth::attempt(array('email' => Input::get('email'), 'password' => Input::get('password'), 'active' => 1), Input::get('rememberme'))) {

                    return Redirect::route('profile');
                } else {

                    return Redirect::back()->withErrors(array('Usuário ou senha inválidos.'));
                }
            }
        }

        return View::make('site.register');
    }

    public function myaccount()
    {

        return View::make('admin.myaccount');
    }

    public function pages($post_id = 0)
    {
        $service = array();
        $services = array();
        if ($post_id):
            $post = Post::find($post_id);


            if (Request::isMethod('post')) {

                $url = Option::get('url_site') . '/' . BaseController::transformWords(true, trim(Input::get('title')), array('b' => array(' '), 's' => array('-')));

                $post->post_author = Auth::id();
                $post->title = trim(Input::get('title'));
                $post->content = trim(Input::get('content'));
                $post->type = 'page';
                $post->url = $url;

                if ($post->save()) {

                    if (Input::get('services')) {
                        $services = json_encode(Input::get('services'));
                        if (Postmeta::update_or_insert(array('post_id' => $post->post_id, 'key' => 'services', 'value' => $services))) {
                            Session::flash('alert-code', 'PA001S');
                        } else {
                            Session::flash('alert-code', 'PA001D');
                        }
                    }

                    Session::flash('alert-code', 'PA001S');

                    return Redirect::route('admin.pages', array('post_id' => $post->post_id));
                } else {
                    Session::flash('alert-code', 'PA001D');
                    return Redirect::route('admin.pages', array('post_id' => $post->post_id));
                }
            } else {
                $meta = json_decode(Post::find($post_id)->postmeta($post->post_id, 'services'), true);

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

                return View::make('admin.pages', array('post' => $post, 'services' => $services, 'title' => $post->title));
            }

        else:
            return Redirect::route('admin.dashboard');
        endif;
    }

    public function terms($term_id = 0, $taxonomy = '', $action = '')
    {
        $taxonomy = ($taxonomy == '') ? Input::get('taxonomy') : $taxonomy;
        if (Request::isMethod('post')) {

            $term = Term::find($term_id);
            $slug = BaseController::transformWords(true, trim(Input::get('name')), array('b' => array(' '), 's' => array('-')));

            if ($term_id) {

                $term->name = trim(Input::get('name'));
                $term->slug = $slug;

                if ($term->save()) {

                    $term_taxonomy = TermTaxonomy::find(intval(Input::get('term_taxonomy_id')));
                    $term_taxonomy->term_id = $term_id;
                    $term_taxonomy->taxonomy = trim(Input::get('taxonomy'));
                    $term_taxonomy->description = trim(Input::get('description'));
                    $term_taxonomy->save();

                    $term = Term::get('terms.term_id', '=', $term->term_id);
                    $term = (count($term) > 0) ? $term[0] : $term;

                    Session::flash('alert-code', 'C001S');
                    return View::make('admin.term-single', array('term' => $term, 'title' => 'Editar Categoria'));
                } else {
                    $term = Term::get('terms.term_id', '=', $term->term_id);
                    $term = (count($term) > 0) ? $term[0] : $term;

                    Session::flash('alert-code', 'C001D');
                    return View::make('admin.term-single', array('term' => $term, 'title' => 'Editar Categoria'))->withErrors('Erro ao salvar a página');
                }
            } else {

                $term = new Term;
                $term->name = trim(Input::get('name'));
                $term->slug = $slug;

                if ($term->save()) {

                    $term_taxonomy = new TermTaxonomy;
                    $term_taxonomy->term_id = $term->term_id;
                    $term_taxonomy->taxonomy = trim(Input::get('taxonomy'));
                    $term_taxonomy->description = trim(Input::get('description'));
                    $term_taxonomy->save();

                    $term = Term::get('terms.term_id', '=', $term->term_id);
                    $term = (count($term) > 0) ? $term[0] : $term;

                    Session::flash('alert-code', 'C002S');

                    return View::make('admin.term-single', array('term' => $term, 'title' => 'Editar Categoria'));
                } else {
                    $term = Term::get('terms.term_id', '=', $term->term_id);
                    $term = (count($term) > 0) ? $term[0] : $term;

                    Session::flash('alert-code', 'C002D');
                    return View::make('admin.term-single', array('term' => $term, 'title' => 'Editar Categoria'))->withErrors('Erro ao salvar a página');
                }
            }
        } else {
            if ($action == 'novo') {
                return View::make('admin.term-single', array('title' => 'Nova Categoria'));
            } else {
                if ($term_id) {
                    $term = Term::find($term_id);
                    if ($action == 'delete') {
                        if (Term::remove($term_id)) {
                            Session::flash('alert-code', 'C003S');
                        } else {
                            Session::flash('alert-code', 'C003D');
                        }
                        $terms = Term::get('term_taxonomy.taxonomy', '=', $taxonomy);
                        $terms = (count($terms) > 0) ? $terms : $terms;
                        return View::make('admin.terms', array('terms' => $terms, 'title' => 'Categorias'));
                    } else {
                        $term = Term::get('terms.term_id', '=', $term_id);
                        $term = (count($term) > 0) ? $term[0] : $term;
                        return View::make('admin.term-single', array('term' => $term, 'title' => 'Editar Categoria '));
                    }
                } else {
                    $terms = Term::get('term_taxonomy.taxonomy', '=', $taxonomy);
                    $terms = (count($terms) > 0) ? $terms : $terms;
                    return View::make('admin.terms', array('terms' => $terms, 'title' => 'Categorias'));
                }
            }
        }
    }

    public function blog($post_id = 0, $action = '')
    {

        $categories = Term::get('term_taxonomy.taxonomy', '=', 'blog');

        if (Request::isMethod('post')) {
            $post = Post::find($post_id);

            $url = Option::get('url_site') . '/blog/' . BaseController::transformWords(true, trim(Input::get('title')), array('b' => array(' '), 's' => array('-')));

            if ($post_id) {

                $post->post_author = Auth::id();
                $post->title = trim(Input::get('title'));
                $post->content = trim(Input::get('content'));
                $post->expert = trim(Input::get('expert'));
                $post->status = (Input::get('status') != '') ? trim(Input::get('status')) : 'publish';
                $post->url = $url;
                $post->type = 'post';

                if ($post->save()) {
                    foreach (Input::get('category') as $category) {
                        TermRelationships::update_or_insert($post->post_id, $category);
                    }

                    if (Input::hasFile('image_default')) {
                        $file = Input::file('image_default');
                        BaseController::upload_image($file, $post);
                    }
                    Session::flash('alert-code', 'P001S');

                    return View::make('admin.blog-single', array('post' => $post, 'categories' => $categories, 'title' => 'Novo Post'));
                } else {
                    Session::flash('alert-code', 'P001D');

                    return View::make('admin.blog-single', array('post' => $post, 'categories' => $categories, 'title' => 'Novo Post'));
                }
            } else {

                $post = new Post;
                $post->post_author = Auth::id();
                $post->title = trim(Input::get('title'));
                $post->content = trim(Input::get('content'));
                $post->expert = trim(Input::get('expert'));
                $post->status = (Input::get('status') != '') ? trim(Input::get('status')) : 'publish';
                $post->url = $url;
                $post->type = 'post';

                if ($post->save()) {
                    foreach (Input::get('category') as $category) {
                        TermRelationships::update_or_insert($post->post_id, $category);
                    }
                    if (Input::hasFile('image_default')) {
                        $file = Input::file('image_default');
                        BaseController::upload_image($file, $post);
                    }
                    Session::flash('alert-code', 'P002S');
                    return View::make('admin.blog-single', array('post' => $post, 'categories' => $categories, 'title' => 'Novo Post'));
                } else {
                    Session::flash('alert-code', 'P002D');
                    return View::make('admin.blog-single', array('post' => $post, 'categories' => $categories, 'title' => 'Novo Post'))->withErrors('Erro ao salvar a página');
                }
            }
        } else {
            if ($action == 'novo') {
                return View::make('admin.blog-single', array('title' => 'Novo Post', 'categories' => $categories));
            } else {
                if ($post_id) {
                    $post = Post::find($post_id);
                    if ($action == 'delete') {
                        if (Post::remove($post_id)) {
                            Session::flash('alert-code', 'P003S');
                        } else {
                            Session::flash('alert-code', 'P003D');
                        }
                        $posts = Post::where('type', '=', 'post')->get();
                        return View::make('admin.blog', array('posts' => $posts));
                    } else if ($action == 'publish') {
                        $post->status = 'inactive';
                        if ($post->save()) {
                            Session::flash('alert-code', 'P001S');
                        } else {
                            Session::flash('alert-code', 'P001D');
                        }
                        $posts = Post::where('type', '=', 'post')->get();
                        return View::make('admin.blog', array('posts' => $posts));
                    } else if ($action == 'inactive') {
                        $post->status = 'publish';
                        if ($post->save()) {
                            Session::flash('alert-code', 'P001S');
                        } else {
                            Session::flash('alert-code', 'P001D');
                        }
                        $posts = Post::where('type', '=', 'post')->get();
                        return View::make('admin.blog', array('posts' => $posts));
                    } else {
                        $post = Post::find($post_id);
                        return View::make('admin.blog-single', array('post' => $post, 'categories' => $categories, 'title' => 'Editar Post'));
                    }
                } else {
                    $posts = Post::where('type', '=', 'post')->get();
                    return View::make('admin.blog', array('posts' => $posts));
                }
            }
        }
    }

    public function banner($post_id = 0, $action = '')
    {

        if (Request::isMethod('post')) {
            $post = Post::find($post_id);

            $url = Option::get('url_site') . '/banner/' . BaseController::transformWords(true, trim(Input::get('title')), array('b' => array(' '), 's' => array('-')));

            if ($post_id) {

                $post->post_author = Auth::id();
                $post->title = trim(Input::get('title'));
                $post->status = (Input::get('status') != '') ? trim(Input::get('status')) : 'publish';
                $post->url = $url;
                $post->type = 'banner_home';
                $post->slug = 'banner-' . BaseController::transformWords(true, trim(Input::get('title')), array('b' => array(' '), 's' => array('-')));

                if ($post->save()) {
                    $old = json_decode(Post::find($post->post_id)->postmeta($post->post_id, 'banner'));
                    $banner['image_background'] = (isset($old->image_background)) ? $old->image_background : '';
                    $banner['image_1'] = (isset($old->image_1)) ? $old->image_1 : '';

                    if (Input::hasFile('image_background')) {
                        $file = Input::file('image_background');

                        $destinationPath = public_path() . '/uploads';
                        $filename = 'banner-' . $file->getClientOriginalName();
                        $upload_success = Input::file('image_background')->move($destinationPath, $filename);
                        if ($upload_success) {
                            $banner['image_background'] = $filename;
                        }
                    }
                    if (Input::hasFile('image_1')) {
                        $file = Input::file('image_1');
                        $filename = 'banner-' . $file->getClientOriginalName();
                        $destinationPath = public_path() . '/uploads';
                        $upload_success = Input::file('image_1')->move($destinationPath, $filename);
                        if ($upload_success) {
                            $banner['image_1'] = $filename;
                        }
                    }
                    $banner['title'] = trim(Input::get('title'));
                    $banner['text_1'] = trim(Input::get('text_1'));
                    $banner['text_2'] = trim(Input::get('text_2'));
                    $banner['text_button'] = trim(Input::get('text_button'));
                    $banner['link_button'] = trim(Input::get('link_button'));
                    $banner['chamada_button'] = 0;
                    $banner['align'] = trim(Input::get('align'));

                    Postmeta::update_or_insert(array('post_id' => $post->post_id, 'key' => 'banner', 'value' => json_encode($banner)));

                    Session::flash('alert-code', 'B002S');

                    $postmeta = json_decode(Post::find($post->post_id)->postmeta($post->post_id, 'banner'));

                    return View::make('admin.banner-single', array('post' => $post, 'title' => 'Editar Banner', 'postmeta' => $postmeta));
                } else {
                    Session::flash('alert-code', 'B002D');

                    $postmeta = json_decode(Post::find($post->post_id)->postmeta($post->post_id, 'banner'));

                    return View::make('admin.banner-single', array('post' => $post, 'title' => 'Editar Banner', 'postmeta' => $postmeta));
                }
            } else {

                $post = new Post;
                $post->post_author = Auth::id();
                $post->title = trim(Input::get('title'));
                $post->status = (Input::get('status') != '') ? trim(Input::get('status')) : 'publish';
                $post->url = $url;
                $post->type = 'banner_home';
                $post->slug = 'banner-' . BaseController::transformWords(true, trim(Input::get('title')), array('b' => array(' '), 's' => array('-')));

                if ($post->save()) {


                    if (Input::hasFile('image_background')) {
                        $file = Input::file('image_background');

                        $destinationPath = public_path() . '/uploads';
                        $filename = 'banner-' . $file->getClientOriginalName();
                        $upload_success = Input::file('image_background')->move($destinationPath, $filename);
                        if ($upload_success) {
                            $banner['image_background'] = $filename;
                            if (Input::hasFile('image_1')) {
                                $file = Input::file('image_1');
                                $filename = 'banner-' . $file->getClientOriginalName();
                                $upload_success = Input::file('image_1')->move($destinationPath, $filename);
                                if ($upload_success) {
                                    $banner['image_1'] = $filename;
                                }
                            }
                        }
                    }

                    $banner['title'] = trim(Input::get('title'));
                    $banner['text_1'] = trim(Input::get('text_1'));
                    $banner['text_2'] = trim(Input::get('text_2'));
                    $banner['text_button'] = trim(Input::get('text_button'));
                    $banner['link_button'] = trim(Input::get('link_button'));
                    $banner['chamada_button'] = 0;
                    $banner['align'] = trim(Input::get('align'));

                    Postmeta::update_or_insert(array('post_id' => $post->post_id, 'key' => 'banner', 'value' => json_encode($banner)));

                    Session::flash('alert-code', 'B001S');

                    $post = Post::find($post_id);
                    $postmeta = json_decode(Post::find($post->post_id)->postmeta($post->post_id, 'banner'));

                    return View::make('admin.banner-single', array('post' => $post, 'title' => 'Editar Banner', 'postmeta' => $postmeta));
                } else {
                    Session::flash('alert-code', 'B001D');

                    return View::make('admin.banner-single', array('post' => $post, 'title' => 'Novo Banner'));
                }
            }
        } else {
            if ($action == 'novo') {
                return View::make('admin.banner-single', array('title' => 'Novo Banner'));
            } else {
                if ($post_id) {
                    $post = Post::find($post_id);
                    if ($action == 'delete') {
                        if (Post::remove($post_id)) {
                            Session::flash('alert-code', 'B003S');
                        } else {
                            Session::flash('alert-code', 'B003D');
                        }
                        $posts = Post::where('type', '=', 'banner_home')->get();
                        return View::make('admin.banner', array('posts' => $posts, 'title' => 'Banners'));
                    } else if ($action == 'publish') {
                        $post->status = 'inactive';
                        if ($post->save()) {
                            Session::flash('alert-code', 'B002S');
                        } else {
                            Session::flash('alert-code', 'B002D');
                        }
                        $posts = Post::where('type', '=', 'banner_home')->get();
                        return View::make('admin.banner', array('posts' => $posts, 'title' => 'Banners'));
                    } else if ($action == 'inactive') {
                        $post->status = 'publish';
                        if ($post->save()) {
                            Session::flash('alert-code', 'B002S');
                        } else {
                            Session::flash('alert-code', 'B002D');
                        }
                        $posts = Post::where('type', '=', 'banner_home')->get();
                        return View::make('admin.banner', array('posts' => $posts, 'title' => 'Banners'));
                    } else {
                        $post = Post::find($post_id);
                        $postmeta = json_decode(Post::find($post->post_id)->postmeta($post->post_id, 'banner'));

                        return View::make('admin.banner-single', array('post' => $post, 'title' => 'Editar Banner', 'postmeta' => $postmeta));
                    }
                } else {
                    $posts = Post::where('type', '=', 'banner_home')->get();
                    return View::make('admin.banner', array('posts' => $posts, 'title' => 'Banners'));
                }
            }
        }
    }

    public function client($post_id = 0, $action = '')
    {

        if (Request::isMethod('post')) {
            $post = Post::find($post_id);

            $url = Option::get('url_site') . '/client/' . BaseController::transformWords(true, trim(Input::get('title')), array('b' => array(' '), 's' => array('-')));

            if ($post_id) {

                $post->post_author = Auth::id();
                $post->title = trim(Input::get('title'));
                $post->content = trim(Input::get('content'));
                $post->expert = trim(Input::get('expert'));
                $post->status = (Input::get('status') != '') ? trim(Input::get('status')) : 'publish';
                $post->url = $url;
                $post->type = 'client';
                $post->slug = 'client-' . BaseController::transformWords(true, trim(Input::get('title')), array('b' => array(' '), 's' => array('-')));

                if ($post->save()) {
                    Postmeta::update_or_insert(array('post_id' => $post->post_id, 'key' => 'site', 'value' => trim(Input::get('site'))));
                    if (Input::hasFile('image_default')) {
                        $file = Input::file('image_default');

                        $destinationPath = public_path() . '/uploads';
                        $filename = 'client-' . $file->getClientOriginalName();
                        $upload_success = Input::file('image_default')->move($destinationPath, $filename);
                        if ($upload_success) {
                            Postmeta::update_or_insert(array('post_id' => $post->post_id, 'key' => 'image_default', 'value' => $filename));
                        }
                    }
                    Session::flash('alert-code', 'CLI002S');

                    return View::make('admin.client-single', array('post' => $post, 'title' => 'Editar Cliente'));
                } else {
                    Session::flash('alert-code', 'CLI002D');

                    return View::make('admin.client-single', array('post' => $post, 'title' => 'Novo Cliente'));
                }
            } else {

                $post = new Post;
                $post->post_author = Auth::id();
                $post->title = trim(Input::get('title'));
                $post->content = trim(Input::get('content'));
                $post->expert = trim(Input::get('expert'));
                $post->status = (Input::get('status') != '') ? trim(Input::get('status')) : 'publish';
                $post->url = $url;
                $post->type = 'client';
                $post->slug = 'client-' . BaseController::transformWords(true, trim(Input::get('title')), array('b' => array(' '), 's' => array('-')));


                if ($post->save()) {
                    Postmeta::update_or_insert(array('post_id' => $post->post_id, 'key' => 'site', 'value' => trim(Input::get('site'))));
                    if (Input::hasFile('image_default')) {
                        $file = Input::file('image_default');

                        $destinationPath = public_path() . '/uploads';
                        $filename = 'client-' . $file->getClientOriginalName();
                        $upload_success = Input::file('image_default')->move($destinationPath, $filename);
                        if ($upload_success) {
                            Postmeta::update_or_insert(array('post_id' => $post->post_id, 'key' => 'image_default', 'value' => $filename));
                        }
                    }
                    Session::flash('alert-code', 'CLI001S');
                    $post = Post::find($post_id);
                    return View::make('admin.client-single', array('post' => $post, 'title' => 'Editar Cliente'));
                } else {
                    Session::flash('alert-code', 'CLI001D');
                    return View::make('admin.client-single', array('post' => $post, 'title' => 'Editar Cliente'));
                }
            }
        } else {
            if ($action == 'novo') {
                return View::make('admin.client-single', array('title' => 'Novo Cliente'));
            } else {
                if ($post_id) {
                    $post = Post::find($post_id);
                    if ($action == 'delete') {
                        if (Post::remove($post_id)) {
                            Session::flash('alert-code', 'CLI003S');
                        } else {
                            Session::flash('alert-code', 'CLI003D');
                        }
                        $posts = Post::where('type', '=', 'client')->get();
                        return View::make('admin.client', array('posts' => $posts, 'title' => 'Clientes'));
                    } else if ($action == 'publish') {
                        $post->status = 'inactive';
                        if ($post->save()) {
                            Session::flash('alert-code', 'CLI002S');
                        } else {
                            Session::flash('alert-code', 'CLI002D');
                        }
                        $posts = Post::where('type', '=', 'client')->get();
                        return View::make('admin.client', array('posts' => $posts, 'title' => 'Clientes'));
                    } else if ($action == 'inactive') {
                        $post->status = 'publish';
                        if ($post->save()) {
                            Session::flash('alert-code', 'CLI002S');
                        } else {
                            Session::flash('alert-code', 'CLI002S');
                        }
                        $posts = Post::where('type', '=', 'client')->get();
                        return View::make('admin.client', array('posts' => $posts, 'title' => 'Clientes'));
                    } else {
                        $post = Post::find($post_id);
                        return View::make('admin.client-single', array('post' => $post, 'title' => 'Editar Cliente'));
                    }
                } else {
                    $posts = Post::where('type', '=', 'client')->get();
                    return View::make('admin.client', array('posts' => $posts, 'title' => 'Clientes'));
                }
            }
        }
    }

    public function configs()
    {

        if (Request::isMethod('post')) {
            foreach (Input::get('update') as $ids) {
                $configuration = Option::find($ids);
                if (Input::get($configuration->option_key) != '') {

                    #if ( $configuration->user_id == 13) {
                    if (substr($configuration->option_key, 0, 11) == 'textareamod') {
                        $dir = str_replace('textareamod_', '', $configuration->option_key);
                        $dir = str_replace('_', '/', $dir);

                        $message_html = '<!DOCTYPE html>
                            <html lang="en-US">
                                <head>
                                    <meta charset="utf-8">
                                </head>
                                <body>
                                ' . trim(Input::get($configuration->option_key)) . '
                                </body>
                            </html>';

                        $handle = fopen('app/views/' . $dir . '.blade.php', "w");
                        fwrite($handle, $message_html);
                        fclose($handle);
                    }

                    $configuration->option_value = Input::get($configuration->option_key);

                    # } else {
                    #if ($configuration->type == 'text') {
                    $configuration->option_value = trim(Input::get($configuration->option_key));
                    #}
                    # }

                    $configuration->save();
                } else if (Input::file($configuration->option_key) != '') {
                    $file = Input::file($configuration->option_key);
                    $destinationPath = public_path() . '/uploads';
                    // If the uploads fail due to file system, you can try doing public_path().'/uploads'
                    $filename = $file->getClientOriginalName();
                    //$extension =$file->getClientOriginalExtension();
                    $upload_success = Input::file($configuration->option_key)->move($destinationPath, $filename);
                    $configuration->option_value = $filename;
                }

                if ($configuration->save()) {
                    Session::flash('alert-code', 'CONF002S');
                } else {
                    Session::flash('alert-code', 'CONF002D');
                }
            }
        }
        return View::make('admin.configs', array('configs' => Option::orderBy('parent')->where('parent', '<>', 999)->orderBy('order')->get(), 'title' => 'Configurações'));
    }

    public function users($user_id = 0, $action = '')
    {

        $groups = Group::all();

        if (Request::isMethod('post')) {
            $user = User::find($user_id);

            $url = Option::get('url_site') . '/admin/usuarios/' . BaseController::transformWords(true, trim(Input::get('title')), array('b' => array(' '), 's' => array('-')));

            if ($user_id) {

                //ATUALIZAÇÃO DE CADASTRO
                $slug = BaseController::transformWords(true, trim(Input::get('name')), array('b' => array(' '), 's' => array('-')));

                $docs = ['doc_cnpj' => '', 'doc_ie' => '', 'doc_rg' => '', 'doc_cpf' => '', 'logo_cliente' => ''];
                foreach ($docs as $doc => $value) {
                    if (Input::hasFile($doc)) {
                        $file = Input::file($doc);
                        $destinationPath = public_path() . '/uploads/docs-cadastro/id-' . $user->user_id;
                        $filename = 'cnpj-' . $slug . '-' . BaseController::transformWords(true, trim($file->getClientOriginalName()), array('b' => array(' ', '_'), 's' => array('-', '-')));
                        $upload_success = Input::file($doc)->move($destinationPath, $filename);
                        if ($upload_success) {
                            $docs[$doc] = $filename;
                        }
                    }
                }

                $vars = array_merge(Input::all(), array(
                    'slug' => Input::get('type') . '-' . $slug,
                    'parent' => Auth::id(),
                    'url' => URL::route('home') . '/admin/usuarios/' . $slug,
                    'url_site' => URL::route('admin.users')
                ));
                $vars = array_merge($vars, $docs);

                $user = User::update_or_insert($vars);
//                $user = Usermeta::update_or_insert($vars);

                if ($user) {
                    foreach ($vars as $k => $v) {
                        $postmeta = Usermeta::update_or_insert(array('user_id' => $user, 'key' => $k, 'value' => $v));
                    }
                    /*
                    if (Option::get('radio_smtp_send_active') && Input::get('send_email_to_user') == 1) {
                        Mail::send('emails.user.acess', $vars, function($message) use ($user) {
                            $message->to($user->email, $user->name)->subject(Option::get('text_emails_user_acess'));
                        });
                    }*/

                    Session::flash('alert-code', 'USR002S');
                } else {
                    Session::flash('alert-code', 'USR002D');
                }

                $user = User::find($user_id);
                return View::make('admin.users-single', array('user' => $user, 'groups' => $groups, 'title' => 'Editar Usuário'));
            } else {

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

                $vars = array_merge(Input::all(), array(
                    'slug' => Input::get('type') . '-' . $slug,
                    'parent' => Auth::id(),
                    'url' => URL::route('home') . '/admin/usuarios/' . $slug,
                    'pass' => $pass,
                    'password' => $pass,
                    'doc_cnpj' => $doc_cnpj,
                    'doc_ie' => $doc_ie,
                    'doc_rg' => $doc_rg,
                    'doc_cpf' => $doc_cpf,
                    'url_site' => URL::route('admin.users'),
                    'url_admin' => URL::route('admin.dashboard')
                ));

                $regras = ['email' => 'required|email|unique:users,email'];

                //executando validação
                $validacao = Validator::make(Input::all(), $regras);

                //se a validação deu errado
                if ($validacao->fails()) {
                    Session::flash('alert-code', 'USR004D');
                    return Redirect::back();
                } else {
                    $user = User::update_or_insert($vars);

                    if ($user) {
                        foreach ($vars as $k => $v) {
                            if ($v)
                                $postmeta = Usermeta::update_or_insert(array('user_id' => $user, 'key' => $k, 'value' => $v));
                        }

                        if (Option::get('radio_smtp_send_active') && Input::get('send_email_to_user') == 1) {

                            $user = User::find($user);
                            $email_data = [
                                'vars' => $vars,
                                'user' => $user
                            ];
                            EmailController::send_email_user_register($email_data);
                        }

                        Session::flash('alert-code', 'USR001S');
                    } else {
                        Session::flash('alert-code', 'USR001D');
                    }

                    $users = DB::table('users')
                        ->join('groups', 'users.group_id', '=', 'groups.group_id')
                        ->where('user_id', '<>', Auth::user()->user_id)
                        ->where('parent', '=', Auth::user()->user_id)
                        ->get();

                    return View::make('admin.users', array('users' => $users, 'title' => 'Usuários'));
                }
            }
        } else {
            if ($action == 'novo') {
                return View::make('admin.users-single', array('title' => 'Novo Usuário', 'groups' => $groups));
            } else {
                if ($user_id) {
                    $user = User::find($user_id);
                    if ($action == 'delete') {

                        if (User::remove($user_id)) {
                            Session::flash('alert-code', 'USR003S');
                        } else {
                            Session::flash('alert-code', 'USR003D');
                        }
                        $users = DB::table('users')->join('groups', 'users.group_id', '=', 'groups.group_id')->where('user_id', '<>', Auth::user()->user_id)->where('parent', '=', Auth::user()->user_id)->get();
                        return View::make('admin.users', array('users' => $users, 'title' => 'Usuários'));
                    } else if ($action == 'publish') {
                        $user->active = 0;
                        if ($user->save()) {
                            Session::flash('alert-code', 'USR002S');
                        } else {
                            Session::flash('alert-code', 'USR002D');
                        }
                        $users = DB::table('users')->join('groups', 'users.group_id', '=', 'groups.group_id')->where('user_id', '<>', Auth::user()->user_id)->where('parent', '=', Auth::user()->user_id)->get();
                        return View::make('admin.users', array('users' => $users, 'title' => 'Usuários'));
                    } else if ($action == 'inactive') {
                        $user->active = 1;
                        if ($user->save()) {
                            Session::flash('alert-code', 'USR002S');
                        } else {
                            Session::flash('alert-code', 'USR002D');
                        }
                        $users = DB::table('users')->join('groups', 'users.group_id', '=', 'groups.group_id')->where('user_id', '<>', Auth::user()->user_id)->where('parent', '=', Auth::user()->user_id)->get();
                        return View::make('admin.users', array('users' => $users, 'title' => 'Usuários'));
                    } else {

                        $user = User::find($user_id);
                        $sensores = Post::where('type', 'sensor')->where('post_author', $user_id)->get();
                        $sensores = BaseController::getDataSensors($sensores);
                        return View::make('admin.users-single', array('user' => $user, 'groups' => $groups, 'sensores' => $sensores, 'title' => 'Editar Usuário'));
                    }
                } else {
                    $users = DB::table('users')->join('groups', 'users.group_id', '=', 'groups.group_id')->where('user_id', '<>', Auth::user()->user_id)->where('parent', '=', Auth::user()->user_id)->get();

                    if (Auth::user()->group_id == 1) {
                        $users = DB::table('users')
                            ->join('groups', 'users.group_id', '=', 'groups.group_id')
                            ->where('user_id', '<>', Auth::user()->user_id)->get();
                    }
                    return View::make('admin.users', array('users' => $users, 'title' => 'Usuários'));
                }
            }
        }
    }

    public function groups($group_id = 0, $action = '')
    {

        $permissions = DB::table('permissions')->get();
        $my = array();

        $childs = array();

        foreach ($permissions as $item)
            $childs[$item->parent][] = $item;

        foreach ($permissions as $item)
            if (isset($childs[$item->permission_id]))
                $item->childs = $childs[$item->permission_id];

        $tree = (count($childs)) ? $childs[0] : $childs;

        if ($group_id) {
            $group = Group::find($group_id);
            $my = array();
            $mypermissions = DB::table('group_permission')->where('group_id', $group->group_id)->get();
            foreach ($mypermissions as $mypermission) {
                $my[] = $mypermission->permission_id;
            }
        }

        if (Request::isMethod('post')) {


            if ($group_id) {

                $group->description = Input::get('description');

                if ($group->save()) {

                    if (count(Input::get('permission'))) {

                        DB::table('group_permission')->where('group_id', '=', $group->group_id)->delete();


                        foreach (Input::get('permission') as $permission) {


                            DB::table('group_permission')->insert(
                                array('permission_id' => $permission, 'group_id' => $group->group_id)
                            );
                        }
                    }

                    Session::flash('alert-code', 'CONF002S');
                } else {
                    Session::flash('alert-code', 'CONF002D');
                }
            } else {

                $group = new Group;

                $group->description = Input::get('description');

                if ($group->save()) {
                    if (count(Input::get('permission'))) {
                        DB::table('group_permission')->where('group_id', '=', $group->group_id)->delete();
                        foreach (Input::get('permission') as $permission) {

                            DB::table('group_permission')->insert(
                                array('permission_id' => $permission, 'group_id' => $group->group_id)
                            );
                        }
                    }

                    Session::flash('alert-code', 'CONF002S');
                } else {
                    Session::flash('alert-code', 'CONF002D');
                }
            }

            $mypermissions = DB::table('group_permission')->where('group_id', $group->group_id)->get();
            $my = array();
            foreach ($mypermissions as $mypermission) {
                $my[] = $mypermission->permission_id;
            }


            return View::make('admin.groups', array('group' => $group, 'title' => 'Grupos', 'permissions' => $permissions, 'mypermissions' => $my, 'tree' => $tree));
        } else {
            if ($group_id) {


                if ($action == 'delete') {
                    if ($group->delete()) {
                        Session::flash('alert-code', 'USR003S');
                    } else {
                        Session::flash('alert-code', 'USR003D');
                    }

                    $groups = Group::all();
                    return View::make('admin.groups', array('groups' => $groups, 'title' => 'Grupos'));
                } else {

                    return View::make('admin.groups', array('group' => $group, 'title' => 'Grupos', 'permissions' => $permissions, 'mypermissions' => $my, 'tree' => $tree));
                }
            } else {
                if ($action == 'novo') {


                    $group = array();

                    if ($group_id) {
                        $group = Group::find($group_id);
                        $my = array();
                        $mypermissions = DB::table('group_permission')->where('group_id', $group->group_id)->get();
                        foreach ($mypermissions as $mypermission) {
                            $my[] = $mypermission->permission_id;
                        }
                    }
                    return View::make('admin.groups', array('group' => $group, 'title' => 'Novo Grupo', 'permissions' => $permissions, 'mypermissions' => $my, 'tree' => $tree));
                }

                $groups = Group::all();
                if ($group_id) {
                    $group = Group::find($group_id);
                    $mypermissions = DB::table('group_permission')->where('group_id', $group->group_id)->get();
                    foreach ($mypermissions as $mypermission) {
                        $my[] = $mypermission->permission_id;
                    }
                }
                return View::make('admin.groups', array('groups' => $groups, 'title' => 'Grupos', 'mypermissions' => $my, 'my' => Input::get('permission')));
            }
        }
    }

    public function profile($action = '')
    {
        if ($action == 'save') {

            if (Input::get('user_id') > 0) {
                $user = User::find(Input::get('user_id'));
                $user->name = Input::get('name');

                if (Input::get('password') != '') {
                    $user->password = Input::get('password');
                }

                $user->save();

                $title = (Input::get('campany_name') != '') ? Input::get('campany_name') : Input::get('name');
                $url = BaseController::transformWords(true, $title, array('busca' => array('_', ' '), 'substitui' => array('-', '-')));

                $post = Post::update_or_insert(array(
                    'title' => $title,
                    'content' => Input::get('company_about'),
                    'url' => $url
                ));
                if ($post) {
                    return Redirect::route('profile')->with(array('success' => 'Dados salvos com sucesso.'));
                } else {
                    return Redirect::back()->withErrors(array('Não foi possível salvar seus dados.'));
                }
            } else {
                return Redirect::back()->withErrors(array('Não foi possível salvar seus dados.'));
            }
        }

        return View::make('admin.profile');
    }

    public function report_custom($action = 'view', $post_id = 0)
    {
        //NOVO OU UPDATE
        if (Request::isMethod('post')) {
            $dados_input = Input::all();
            ReportController::create_or_update_Report($dados_input);
            return Redirect::route('admin.report-custom');
        }

        if (Auth::user()->group_id == 1) {
            $sensores = Post::where('type', 'sensor')->where('status', 'publish')->get();
        } else {
            $sensores = Post::where('type', 'sensor')->where('status', 'publish')->where('post_author', Auth::id())->get();
        }

        $report_options = [
            'colors' => ReportController::$Colors,
//            'dias_da_semana' => ReportController::$DiasDaSemana,
            'dias_da_semana' => Base::$_DIAS_DA_SEMANA_,
            'indicadores' => Base::$_GRUPOINDICADORES_,
        ];

        switch ($action) {
            case 'novo':
                return View::make('admin.report-custom', array(
                    'title' => 'Agendar Relatório',
                    'sensores' => $sensores,
                    'report_options' => $report_options,
                    'action' => $action,
                    'post_id' => $post_id));
                break;
            case 'manual':
                $report_options['indicadores'] = Base::$_INDICADORES_;
                return View::make('admin.report-custom', array(
                    'title' => 'Gerar Relatório',
                    'report_options' => $report_options,
                    'sensores' => $sensores,
                    'action' => $action,
                    'post_id' => $post_id));
                break;
            case 'remover':
                if (ReportController::removeReport($post_id)) {
                    Session::flash('alert-code', 'REP003S');
                } else {
                    Session::flash('alert-code', 'REP003D');
                }
                return Redirect::route('admin.report-custom');
                break;
            case 'editar':
                $reports = DB::table('posts')->where('type', 'report')->where('post_id', $post_id)->first();
                break;
            case 'todos': //Visualizar todos (ADMIN)
                if (Auth::user()->group_id == 1) {
                    $reports = DB::table('posts')->where('type', 'report')->get();
                } else {
                    $reports = DB::table('posts')->where('type', 'report')->where('post_author', Auth::id())->get();
                }
                break;
            default: //Visualizar todos
                $reports = DB::table('posts')->where('type', 'report')->where('post_author', Auth::id())->get();
                break;
        }
        return View::make('admin.report-custom', array(
            'title' => 'Relatórios Agendados',
            'reports' => $reports,
            'report_options' => $report_options,
            'sensores' => $sensores,
            'action' => $action,
            'post_id' => $post_id));

    }

    public function sensors($post_id = 0, $action = '')
    {
        return 'ROTA INCORRETA!';
//        if (Request::isMethod('post')) {
//            $sensor = Post::find($post_id);
//            $slug = BaseController::transformWords(true, trim(Input::get('title')), array('b' => array(' '), 's' => array('-')));
//            $url = Option::get('url_site') . '/admin/sensores/' . $slug;
//
//            //update
////            if ($post_id) {
////                if (Input::get('visualization_dash') != "") { // Atualizar dashboard
////                    Postmeta::update_or_insert(array('post_id' => $sensor->post_id,
////                        'key' => 'visualization_dash',
////                        'value' => Input::get('visualization_dash'))); //vai ser setado quando o sensor for criado
////                    if ($sensor) {
////                        Session::flash('alert-code', 'SEN002S');
////                    } else {
////                        Session::flash('alert-code', 'USR002D');
////                    }
////                    return Redirect::route('admin.dashboard');
////
////                } else { // Editar || Remover
////                    $vars = array_merge(Input::all(), array(
////                        'content' => json_encode(Input::get('measures')),
////                        'type' => 'sensor',
////                        'slug' => $slug,
////                        'url' => $url,
////                    ));
////
////                    $sensor_postmeta = array(
////                        "alert_type" => json_encode(Input::get('alert_type')),
////                        "alert_time" => Input::get('alert_time'),
//////                        "alert_num"          => Input::get('alert_num'),
////                        "alert_day" => Input::get('alert_day'),
//////                        "visualization_dash" => 'u1',
////                    );
////                    /*
////
////                    $content = array(
////                        "alert_time"                            => Input::get('alert_time'),
////                        "alert_type"                            => (Input::has('alert_type'))?Input::get('alert_type'):'',
////                        "alert_num"                             => Input::get('alert_num'),
////                        "alert_day"                             => $agora->format('d-m-Y'),
////                        "last_alert"                            => $agora->format('Y-m-d H:i'),
////                        "last_activity"                         => $agora->format('Y-m-d H:i'),
////                        'alerts_count_' . $agora->format('dmY') => 0,
////                        "visualization_dash"                    => 'u1',
////                    );
////                    */
////                    foreach ($sensor_postmeta as $key => $value) {
////                        Postmeta::update_or_insert(array('post_id' => $sensor->post_id, 'key' => $key, 'value' => $value));
////                    }
////
////                    $sensor = Post::update_or_insert($vars);
////
//////                print_r($sensor); exit;
////                    if ($sensor) {
////                        /*
////                        foreach ($vars as $k => $v) {
////                            if ($v)
////                                $postmeta = Postmeta::update_or_insert(array('post_id' => $sensor, 'key' => $k, 'value' => $v));
////                        }
////                        /*
////                        if (Option::get('radio_smtp_send_active') && Input::get('send_email_to_user') == 1) {
////                            Mail::send('emails.user.acess', $vars, function($message) use ($user) {
////                                $message->to($user->email, $user->name)->subject(Option::get('text_emails_user_acess'));
////                            });
////                        }*/
////                        Session::flash('alert-code', 'SEN002S');
////                        $sensor = BaseController::getDataSensors(Post::find($post_id));
////                        $user = User::find($sensor->post_author);
//////                    $authors = User::where('group_id',4)->get(['user_id','name']);
////                        $authors = User::all(['user_id', 'name']);
////                        return View::make('admin.sensors-single',
////                            array('sensor' => $sensor, 'user' => $user, 'title' => 'Editar Sensor', 'authors' => $authors, 'GrupoIndicadores' => Base::$_GRUPOINDICADORES_, 'Indicadores' => Base::$_INDICADORES_));
////
////                    } else {
////                        Session::flash('alert-code', 'USR002D');
////                    }
////                }
////            } else {
////                //store (novo)
////                if (Post::existe_sensor_title(Input::get('title'))) {
////                    Session::flash('alert-code', 'SEN004D');
////                    return Redirect::back()->withInput();
////                }
////
////                //NOVO SENSOR
////                $regras = [
////                    'title' => 'required',
////                    'measures' => 'required',
////                ];
////
////                //executando validação
////                $validacao = Validator::make(Input::all(), $regras);
////
////                //se a validação deu errado
////                if ($validacao->fails()) {
////                    Session::flash('alert-code', 'SEN001D');
////                    return Redirect::back();
////                } else {
////                    $agora = new DateTime('now');
////                    $vars = array_merge(Input::all(), array(
////                        'content' => json_encode(Input::get('measures')),
////                        'status' => 'publish',
////                        'parent' => Auth::id(),
////                        'order' => 0,
////                        'type' => Input::get('type'),
////                        'slug' => Input::get('type') . '-' . $slug,
////                        'url' => URL::route('home') . '/admin/sensores/' . $slug
////                    ));
////                    unset($vars['post_id']); //tirando o post_id = 0
////                    $content = array(
////                        "alert_time" => 0, //acho que nao está sendo usado, vamos investifar e tirar
////                        "alert_type" => '',
////                        "alert_num" => 0,
////                        "alert_day" => $agora->format('d-m-Y'),
////                        "last_alert" => $agora->format('Y-m-d H:i'),
////                        "last_activity" => $agora->format('Y-m-d H:i'),
////                        'alerts_count_' . $agora->format('dmY') => 0,
////                        "visualization_dash" => 'u1',
////                    );
////                    $post_id = Post::update_or_insert($vars);
////                    if ($post_id) {
////                        //Inserindo os alerts
////                        AlertController::inicializaAlertsSensor($post_id, $content);
////                        Session::flash('alert-code', 'SEN001S');
////                    } else {
////                        Session::flash('alert-code', 'SEN001D');
////                    }
////                }
////            }
//        } else if ($action == 'novo') {
//
//            $authors = User::where('group_id', 4)->get(['user_id', 'name']);
//            return View::make('admin.sensors-single',
////                array('title' => 'Novo Sensor','authors' =>$authors, 'GrupoIndicadores' =>ReportController::$GrupoIndicadores));
//                array('title' => 'Novo Sensor', 'authors' => $authors, 'GrupoIndicadores' => Base::$_GRUPOINDICADORES_));
//
//        } else if ($post_id) {
//            $sensor = Post::find($post_id);
//            switch ($action) {
////                case 'delete': //Remover sensor
////                    $post_ids = Post::where('parent', $post_id)->lists('post_id');
////                    foreach ($post_ids as $pid) {
////                        ReportController::removeReport($pid);
////                    }
////                    Post::remove($post_id);
////
////                    //if(ReportController::removeReport($post_id)){
////                    if (Post::removeDataSensor($post_id)) {
////                        Session::flash('alert-code', 'SEN003S');
////                    } else {
////                        Session::flash('alert-code', 'SEN003D');
////                    }
//////                    break;
////                case 'publish':
////                case 'inactive': //Ativar/Desativar
////                    $sensor->status = ($action == 'publish') ? 'inactive' : 'publish';
////                    if ($sensor->save()) {
////                        Session::flash('alert-code', 'SEN002S');
////                    } else {
////                        Session::flash('alert-code', 'SEN002D');
////                    }
////                    break;
////                case 'clear': //Limpar dados do sensor
////                    Session::flash('alert-code', 'SEN005S');
////                    $per_batch = 250;
////                    $total_to_process = SensorLog::where('post_id', '=', $post_id)->count();
//////                    print_r($total_to_process."<br>");
////                    for ($pg = 1; $pg <= $total_to_process; $pg += $per_batch) {
////                        SensorLog::clear($post_id, $per_batch, $pg);
//////                        print_r(SensorLog::clear($post_id,$per_batch,$pg));
////                    }
////                    break;
////                default:
////                    $sensor = Post::find($post_id);
////                    $sensors = BaseController::getDataSensors($sensor);
////
////                    $user = User::find($sensor->post_author);
//////                    $authors = User::where('group_id',4)->get(['user_id','name']);
////                    $authors = User::all(['user_id', 'name']);
////                    return View::make('admin.sensors-single',
////                        array('sensor' => $sensor, 'user' => $user, 'title' => 'Editar Sensor', 'authors' => $authors, 'GrupoIndicadores' => Base::$_GRUPOINDICADORES_, 'Indicadores' => Base::$_INDICADORES_));
////                    break;
//            }
//        }
//
//        $sensor_fields = ['post_id', 'title', 'status', 'active', 'content'];
//        if (Auth::user()->group_id == 1) {
//            $user_fields = ['user_id', 'name', 'email'];
//            $retorno = array_merge($sensor_fields, $user_fields);
//            $sensors = DB::table('posts')->join('users', 'posts.post_author', '=', 'users.user_id')->where('type', '=', 'sensor')->get($retorno);
//        } else {
//            $sensors = DB::table('posts')->where('posts.post_author', '=', Auth::user()->user_id)->where('type', '=', 'sensor')->get();
//        }
//
//        $sensors = BaseController::getDataSensors($sensors);
////        return($sensors[0]->measures_str);exit;
//        return View::make('admin.sensors', array('sensors' => $sensors, 'title' => 'Sensores'));
    }

    /*
    public function test_sensor()
    {
        /*
        $sensor = Post::find($sensor_id);
        $sensors = BaseController::getDataSensors($sensor);
        $user = User::find($sensor->post_author);
        $authors = User::all(['user_id', 'name']);
        $route = 'admin.sensors-single';
        $array_response = [
            'sensor' => $sensor,
            'user' => $user,
            'title' => 'Editar Sensor',
            'authors' => $authors,
            'GrupoIndicadores' => Base::$_GRUPOINDICADORES_,
            'Indicadores' => Base::$_INDICADORES_
        ];

        return View::make($route, $array_response);

    }
    */

    public function teste_report()
    {

//        $ids_sensor = Post::where('type','=','sensor')->where('status','=','publish')->lists('post_id');
//        foreach($ids_sensor as $sensor_id) {}
        $sensor_id = 23;
        $debug = 1;
        $report_id = 71;

        $sensor_id = (Input::has('sensor_id')) ? Input::get('sensor_id') : $sensor_id;
        $data = (Input::has('data')) ? Input::get('data') : '';
        $debug = (Input::has('debug')) ? Input::get('debug') : $debug;
        $report_id = (Input::has('report_id')) ? Input::get('report_id') : $report_id;

//        http://localhost/workana/medisom/teste-report?sensor_id=23&data=02-05-2016_23:04&debug=1
//        http://medisom.com.br/teste-report?sensor_id=10&data=02-05-2016_23:04&debug=1
        $ReportController = new ReportController($sensor_id, $debug, $data, $report_id);
        $data_report = $ReportController->generateReport();
//        return $data_report;

        $Report = Post::getPublishedReportBySensorID($sensor_id);
        $Sensor = Post::find($sensor_id);

        if ($data_report) {

            $User = $ReportController->User;
            $path = asset('public/uploads/LogoMedisom128px.png');
            $type = pathinfo($path, PATHINFO_EXTENSION);
            $logo = file_get_contents($path);

            $options = (object)[
                'filename' => 'amchart.pdf',
                'type_graph' => 'line',
                'category_field' => 'date',
                'colors' => ($ReportController->Colors),
                'logo' => 'data:image/' . $type . ';base64,' . base64_encode($logo)
            ];

            $agora = new DateTime('now');
            Postmeta::update_or_insert(array('post_id' => $sensor_id, 'key' => 'gen_report', 'value' => $agora->format('d/m/Y H:i')));
            return View::make('admin.report-custom-print', array(
                'title' => 'Relatório Customizado',
                'options' => $options,
                'Report' => json_encode($Report),
                'Sensor' => json_encode($Sensor),
                'User' => json_encode($User),
                'Data_report' => $data_report));
        }


    }


}

