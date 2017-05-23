<?php

/* Home Application */
Route::any('/', array('as' => 'home', 'uses' => 'HomeController@home'));
Route::any('blog/{slug?}', array('as' => 'blog', 'uses' => 'HomeController@blog'));
Route::get('categoria/{slug?}', array('as' => 'category', 'uses' => 'HomeController@category'));

Route::get('contato', array('as' => 'contact', 'uses' => 'HomeController@contact'));
Route::post('contato', array('before' => 'csrf', 'as' => 'contact', 'uses' => 'HomeController@contact'));

Route::get('orcamento', array('as' => 'orcamento', 'uses' => 'HomeController@orcamento'));
Route::post('orcamento', array('before' => 'csrf', 'as' => 'orcamento', 'uses' => 'HomeController@orcamento'));

Route::get('quem-somos', array('as' => 'about', 'uses' => 'HomeController@about'));
Route::get('produtos-e-servicos', array('as' => 'services', 'uses' => 'HomeController@services'));

Route::any('busca/{search?}', array('as' => 'search', 'uses' => 'HomeController@search'));

Route::any('login/{action?}', array('as' => 'login', 'uses' => 'AdminController@login'));
Route::any('reminder/{action?}/{token?}', array('as' => 'reminder', 'uses' => 'AdminController@reminder_password'));

Route::group(array('before' => 'auth'), function () {

    /*Admin Area*/
    Route::any('admin', array('as' => 'admin.dashboard', 'uses' => 'AdminController@dashboard'));
    Route::get('admin/minha-conta', array('as' => 'admin.myaccount', 'uses' => 'AdminController@myaccount'));
    Route::any('admin/minha-conta/perfil/{action?}', array('as' => 'admin.profile', 'uses' => 'AdminController@profile'));

    Route::any('admin/logout', array('as' => 'admin.logout', 'uses' => 'AdminController@logout'));

    Route::any('admin/pagina/{post_id?}', array('as' => 'admin.pages', 'uses' => 'AdminController@pages'));
    Route::any('admin/blog/{post_id?}/{action?}', array('as' => 'admin.blog', 'uses' => 'AdminController@blog'));

    Route::any('admin/categoria/{term_id?}/{taxonomy?}/{action?}', array('as' => 'admin.terms', 'uses' => 'AdminController@terms'));

    Route::any('admin/banner/{post_id?}/{action?}', array('as' => 'admin.banner', 'uses' => 'AdminController@banner'));

    Route::any('admin/cliente/{post_id?}/{action?}', array('as' => 'admin.client', 'uses' => 'AdminController@client'));

    Route::any('admin/configuracoes', array('as' => 'admin.configs', 'uses' => 'AdminController@configs'));

    Route::any('admin/usuarios/{user_id?}/{action?}', array('as' => 'admin.users', 'uses' => 'AdminController@users'));


    Route::any('admin/permissoes/{group_id?}/{action?}', array('as' => 'admin.groups', 'uses' => 'AdminController@groups'));

    //************************************************************ Relatórios **********************************************************
    Route::any('admin/relatorios/{post_id?}/{type?}', array('as' => 'admin.report', 'uses' => 'AdminController@report'));
    Route::any('admin/relatorio-customizado/{post_id?}/{action?}', array('as' => 'admin.report-custom', 'uses' => 'AdminController@report_custom'));
//    Route::any('admin/relatorio-customizado/{action?}/{post_id?}', array('as' => 'route-admin.reports.manual', 'uses' => 'AdminController@report_custom'));

    //************************************************************ Sensores ************************************************************
    Route::group(['prefix' => 'admin'], function () {
        Route::resource('sensores', 'SensorController');
        Route::patch('sensores/{sensores}', array('as' => 'admin.sensores.update', 'uses' => 'SensorController@update'));
        Route::post('dashboard/sensores/{id}', array('as' => 'admin.sensores.dashboard', 'uses' => 'SensorController@updateDashboard'));
        Route::post('dashboard/period/{id}', array('as' => 'admin.sensores.period_dashboard', 'uses' => 'SensorController@updatePeriodDashboard'));
        Route::get('clear/sensores/{id}', array('as' => 'admin.sensores.clear', 'uses' => 'SensorController@clearSensorLog'));
        Route::get('status/sensores/{id}', array('as' => 'admin.sensores.status', 'uses' => 'SensorController@changeStatus'));
        Route::post('test/sensores/{id}', array('as' => 'admin.sensores.test_sensor', 'uses' => 'SensorController@testSensor'));
        //Route::any('admin/sensores/{sensors_id?}/{action?}', array('as' => 'admin.sensors', 'uses' => 'AdminController@sensors'));
    });

    //************************************************************ Alertas ************************************************************
    Route::group(['prefix' => 'admin'], function () {
        Route::get('notifications', array('as' => 'admin.notifications', 'uses' => 'AdminController@notifications'));
        Route::get('notifications/remover/{id}', array('as' => 'admin.notifications.remove', 'uses' => 'AdminController@destroyNotification'));
    });

    Route::group(['prefix' => 'admin'], function () {
        Route::resource('alertas', 'AlertController');
        Route::get('listar/todos-alertas', array('as' => 'admin.alertas.todos', 'uses' => 'AlertController@listAll'));
        Route::get('status/alertas/{id}', array('as' => 'admin.alertas.status', 'uses' => 'AlertController@status'));
        Route::get('zerar/alertas/{id}', array('as' => 'admin.alertas.zerar', 'uses' => 'AlertController@zerar'));
        //    Route::post('alerts/store', array('as' => 'alerts.store', 'uses' => 'AlertController@store'));
        //    Route::get('alerts/create', array('as' => 'alerts.create', 'uses' => 'AlertController@create'));
        //    Route::get('alerts/{alert_id}/edit', array('as' => 'alerts.edit', 'uses' => 'AlertController@edit'));
        //    Route::post('alerts/{alert_id}/update', array('as' => 'alerts.update', 'uses' => 'AlertController@update'));
        //    Route::get('alerts/{alert_id}/destroy', array('as' => 'alerts.destroy', 'uses' => 'AlertController@destroy'));
        //    Route::any('admin/alerts/log', array('as'=>'admin.alerts.log','uses'=>'AdminController@log_alerts'));
        //    Route::any('admin/alerts', array('as' => 'admin.alerts', 'uses' => 'AdminController@alerts'));
        //    Route::any('admin/alerts/{alert_id?}/{action?}', array('as' => 'admin.alerts', 'uses' => 'AdminController@alerts'));
    });
    Route::any('admin/share/{method?}', array('as' => 'admin.share', 'uses' => 'AdminController@share'));

    //	http://medisom.com.br/categoria/biblioteca-de-conteudos
});


//************************************************************ SCHEDULE JOBS ************************************************************
Route::group(['prefix' => 'cronjobs'], function () {
    Route::get('verify-alerts-run/{debug}', array('as' => 'verify-alerts-run', 'uses' => 'RunJobsController@run_alert_check')); //http://medisom.com.br/cronjobs/verify-alerts-run
    Route::get('verify-reports-run/{debug}', array('as' => 'verify-reports-run', 'uses' => 'RunJobsController@run_report_check')); //http://medisom.com.br/cronjobs/verify-reports-run
});

//************************************************************ Ajax Request ************************************************************
Route::any('json/{action?}/{method?}', array('as' => 'jsonp', 'uses' => 'WsController@jsonp'));
Route::any('sensor', array('as' => 'ws', 'uses' => 'WsController@ws'));

/*Vars disponibilizadas nas views*/
View::share('Ajax', json_encode(
    array(
        'json_url' => URL::route('jsonp'),
        'url_site' => Option::get('url_site'),
        'url_public' => Option::get('url_site') . '/public/',
        'url_views' => Option::get('url_site') . '/app/views/'
    )
));

App::missing(function ($exception) {
    return Response::view('errors.404', array(), 404);
});

//************************************************************ Funções ************************************************************
Route::get('get_hour', function () {
    date_default_timezone_set('America/Sao_Paulo');
    $date = new DateTime();
    return $date->format('YmdHi');
});

//Relatórios
Route::get('get-report/{report_id}/{token}', array('as' => 'get-report', 'uses' => 'AdminController@genPrintableReport'));
Route::get('report-manual', array('as' => 'report-manual', 'uses' => 'AdminController@run_report_manual'));

//Alertas
Route::get('verify-alerts-inicializa', array('as' => 'verify-alerts-inicializa', 'uses' => 'AlertController@inicializaAlerts'));

//Inicialização da tabela sensormeta
Route::get('alerts-sensormeta-ini', array('as' => 'alerts-sensormeta-ini', 'uses' => 'AlertController@sensormeta_ini'));
Route::get('get_indicadores_by_sensorid/{sensorid}', array('as' => 'get_indicadores_by_sensorid', 'uses' => 'AjaxController@get_indicadores_by_sensorid'));
Route::get('get_only_indicadores_by_sensorid/{sensorid}/{option}', array('as' => 'get_only_indicadores_by_sensorid', 'uses' => 'AjaxController@get_only_indicadores_by_sensorid'));

Route::get('sendemail', function () {
    $user_email = 'silva.zanin@gmail.com';
    $user_name = 'Leonardo';
    $mensagem = 'Mensagem de Aviso por GET';
    $subject = 'Email enviado por GET';

    $vars = array(
        'name' => $user_name,
        'msg' => $mensagem,
        'url_site' => URL::route('admin.dashboard')
    );
    Mail::send('emails.user.notify', $vars, function ($message) use ($user_email, $user_name, $subject) {
        $message->to($user_email, $user_name)->subject($subject);
    });

    return "Your email has been sent successfully";
});
Route::get('sendemail-reports', function () {
    $user_email = 'silva.zanin@gmail.com';
    $user_name = 'Leonardo';
    $mensagem = 'Mensagem de Aviso por GET-REPORT';
    $subject = 'Email enviado por GET';

    $vars = array(
        'name' => $user_name,
        'msg' => $mensagem,
        'url_site' => URL::route('admin.dashboard')
    );
    EmailController::set_email('reports');
    Mail::send('emails.user.notify', $vars, function ($message) use ($user_email, $user_name, $subject) {
        $message->to($user_email, $user_name)->subject($subject);
    });

    return "reports - Your email has been sent successfully";
});
Route::get('sendemail-alerts', function () {
    $user_email = 'silva.zanin@gmail.com';
    $user_name = 'Leonardo';
    $mensagem = 'Mensagem de Aviso por GET-ALERTS';
    $subject = 'Email enviado por GET';

    $vars = array(
        'name' => $user_name,
        'msg' => $mensagem,
        'url_site' => URL::route('admin.dashboard')
    );
    EmailController::set_email('alerts');
    Mail::send('emails.user.notify', $vars, function ($message) use ($user_email, $user_name, $subject) {
        $message->to($user_email, $user_name)->subject($subject);
    });

    return "alerts - Your email has been sent successfully";
});

Route::get('send-sms-test', function () {
    $user = User::find(1);


    $destino = '55' . $user->usermeta('', $key = 'phones');
    $mensagem = 'Mensagem de teste enviado por SMS para ' . $user->name;

    echo "enviando sms!<br>";
    echo "mensagem: " . $mensagem . "!<br>";
    echo "destinos:";

    print_r('<pre>');
    print_r($destino);
    print_r('</pre>');

    $BaseController = new BaseController();
    $sms_init = $BaseController->SMSAPI_initialize();
    echo "<br>-- SMSAPI_initialize --";
    print_r('<pre>');
    print_r($sms_init);
    print_r('</pre>');

    exit;

    echo "<br>-- SMSAPI_initialize --";
    $sms_send = $BaseController->SMSAPI_enviar($destino, $mensagem);
    print_r('<pre>');
    print_r($sms_send);
    print_r('</pre>');

    return "Your SMS has been sent successfully";
});

//************************************************************ REMOVER ************************************************************
/*
Route::get('teste-report-print', function () {
    $pdf = App::make('dompdf');
    $pdf->loadHTML('<h1>Test</h1>');
    return $pdf->stream();
});
*/
//Route::get('teste-report', array('as' => 'teste.report', 'uses' => 'AdminController@teste_report'));
//Route::get('teste-phantomjs', array('as' => 'teste.phantomjs', 'uses' => 'PDFWriter@teste_phantom_js'));
//Route::post('receive-pdf', array('as' => 'receive-pdf', 'uses' => 'BaseController@receivePdf'));
//Route::post('save-image', array('as' => 'save-image', 'uses' => 'BaseController@saveImage'));
//Route::get('run-verify-alerts',array('as'=>'run-verify-alerts', 'uses'=> 'AlertController@run'));
//Route::get('verify-alerts-run',array('as'=>'verify-alerts-run', 'uses'=> 'AlertController@run'));
/*
Route::get('test_alert_hour/{hour}', function ($hour) {
    //Lógica da hora
    $hora_atual = $hour;

    //Mesmo dia
    $horario[0] = [
        'horario_inicial' => '06:00',
        'horario_final' => '09:00',
        'horario_dias' => ['0', '1', '2'],
    ];

    //Dias diferentes
    $horario[1] = [
        'horario_inicial' => '22:00',
        'horario_final' => '02:00',
        'horario_dias' => ['3', '5'],
    ];

    //Dias diferentes
    $horario[2] = [
        'horario_inicial' => '22:00',
        'horario_final' => '02:00',
        'horario_dias' => ['2', '4', '5'],
    ];

    $hours['h_now'] = \Carbon\Carbon::createFromFormat('H:i', $hora_atual);
    echo 'AGORA: ' . $hours['h_now']->format('H:i d/m/Y') . '<BR>';
    echo 'DIA: ' . Base::getDiasByKeysStr($hours['h_now']->dayOfWeek) . '<BR>';
    echo '------------------------------------<bR><bR>';

    foreach ($horario as $ind => $h) {
        $alerta[$ind] = [
            'horario_inicial' => \Carbon\Carbon::createFromFormat('H:i', $h['horario_inicial']),
            'horario_final' => \Carbon\Carbon::createFromFormat('H:i', $h['horario_final']),
            'horario_dias' => $h['horario_dias'],
        ];

        $hours['h_ini'] = $alerta[$ind]['horario_inicial'];
        $hours['h_end'] = $alerta[$ind]['horario_final'];
        $hours['days'] = $alerta[$ind]['horario_dias'];

        echo '---------- ALERTA ' . $ind . ' -----------<BR>';
        echo 'INÍCIO: ' . $hours['h_ini']->format('H:i d/m/Y') . '<BR>';
        echo 'FIM: ' . $hours['h_end']->format('H:i d/m/Y') . '<BR>';
        echo 'DIAS: ' . implode('; ', Base::getDiasByKeysStr($hours['days'])) . '<BR>';

        if (AlertController::testeDiaHora($hours)) {
            echo "*** ENVIAR ALERTA ***<bR>";
        }

        echo '------------------------------------<bR><bR>';
    }
});
*/
