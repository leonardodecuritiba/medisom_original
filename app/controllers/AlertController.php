<?php

use Carbon\Carbon;

class AlertController extends BaseController
{

    private $Alert;
    private $Post;
    private $SensorLog;
    private $Sensormeta;
    private $User;

    private $indicadores;
    private $radio_smtp_send_active;
    private $radio_sms_send_active;
    private $send_email_sensor;
    private $subject;
    private $send_sms_sensor;
    private $LOG_alert;

    private $todayCount;
    private $date_sensor;
    private $now;
    private $destinos_sms;
    private $sms_send;
    private $sms_init;
    private $n_alert_max;
    //private $t_alert_max;
    private $debug;

    public function __construct($debug = 0)
    {
        $this->debug = $debug;
        $data = new DateTime('now');
        $this->now = new DateTime('now');

        $this->indicadores = Base::$_INDICADORES_;

        $this->radio_smtp_send_active = Option::get('radio_smtp_send_active');
        $this->radio_sms_send_active = Option::get('radio_sms_send_active');
        $this->n_alert_max = Option::get('inactivity_sensor_n_time_set');

        if ($this->n_alert_max == '') {
            Option::update_or_insert('n_alert_max', 3);  //Configuração do número máximo de alertas para inatividade do sensor(pode ser feito pelo admin futuramente)
            $this->n_alert_max = Option::get('n_alert_max');
        }

        $date_sensor = [
            'date_completa' => $data->format('Y-m-d H:i:s'),
            'date_completa_sem_segundo' => $data->format('Y-m-d H:i:00'),
            'date' => $data->format('Y-m-d H:i'),
            'date_reduced' => $data->format('Y-m-d'),
            'data_legivel' => $data->format('d/m/Y H:i:s'),
            'hoje' => $data->format('d-m-Y'),
            'hoje_reduzido' => $data->format('dmY'),
            'agora' => $data->format('H:i'),
            'timestamp' => $data->getTimestamp()
        ];
        $this->date_sensor = (object)$date_sensor;

        if ($this->debug) print_r("<br>");
        if ($this->debug) print_r("------------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br>");
        if ($this->debug) print_r("--------------------------------------------INÍCIO-------------------------------------------------------------------------------------------------------------------------<br>");
        if ($this->debug) print_r("------------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br>");
        if ($this->debug) print_r("GLOBAL:radio_smtp_send_active=" . $this->radio_smtp_send_active . "<br>");
        if ($this->debug) print_r("GLOBAL:radio_sms_send_active=" . $this->radio_sms_send_active . "<br>");
        if ($this->debug) print_r("GLOBAL:inactivity_sensor_n_time_set=" . $this->n_alert_max . "<br>");
        if ($this->debug) print_r("------------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br>");
    }


    public static function sensormeta_ini()
    {

        $sensores = Post::where('type', '=', 'sensor')->get();
        foreach ($sensores as $sensor) {

            $params = [
                'sensor_id' => $sensor->post_id,
                'last_activity' => NULL,
                'last_values' => NULL,
                'alert_count' => 0,
                'alert_day' => NULL
            ];
            $sensormeta = Sensormeta::update_or_insert($params);
            print_r("<br>sensor_id = " . $sensor->post_id . "<br>");
            print_r("sensormeta_id = " . $sensormeta . "<br>");
            print_r("===============<br>");
        }
    }

    public static function inicializaAlertsSensor($sensor_id, $content)
    {
//        return true;
        $last_activity = SensorLog::where('post_id', $sensor_id)->orderBy('created', 'DESC')->first(['created']);
        if (count($last_activity) > 0) {
            $content['last_activity'] = $last_activity->created;
        }
        foreach ($content as $key => $value) {
//            echo $key."=".$value."<bR>";
            Postmeta::update_or_insert(array('post_id' => $sensor_id, 'key' => $key, 'value' => $value));
        }
        return true;
    }

    public static function index()
    {
        $user = Auth::user();
        if ($user->is_admin()) {
            $alerts = $user->alerts_admin();
        } else {
            $alerts = $user->alerts_user();
        }
        $route = 'admin.alerts';
        $array_response = array(
            'action' => 'Meus Alertas',
            'alerts' => $alerts,
            'title' => 'Meus Alertas'
        );
        return View::make($route, $array_response);
    }

    public static function listAll()
    {
        $alerts = Alerts::all();
        $route = 'admin.alerts';
        $array_response = array(
            'action' => 'Todos Alertas',
            'alerts' => $alerts,
            'title' => 'Todos Alertas',
        );
        return View::make($route, $array_response);
    }
    // Route::get('verify-alerts-run', array('as' => 'verify-alerts-run', 'uses' => 'AdminController@run_alert_check'));
    // http://medisom.com.br/verify-alerts-run
    // http://teste.medisom.com.br/verify-alerts-run
    // http://localhost/workana/medisom/verify-alerts-run

    public static function show($alert_id)
    {
        return AlertController::edit($alert_id);
    }



    //----------------------------------------------------------------------------------------------
    //------------------------------------ Funções alertas -----------------------------------------
    //----------------------------------------------------------------------------------------------

    public static function edit($alert_id)
    {
        $Alert = Alerts::find($alert_id);
        $route = 'admin.alerts';
        $array_response = [
            'Alert' => $Alert,
            'title' => 'Editar Alerta',
            'action' => 'editar',
            'sensores' => Auth::user()->sensors_published(),
            'Indicadores' => Base::$_INDICADORES_,
            'Condicoes' => Base::$_ALERT_CONDITIONS_,
            'DiasDaSemana' => Base::$_DIAS_DA_SEMANA_,
            'TiposAlertas' => Base::$_ALERT_TYPES_
        ];
        return View::make($route, $array_response);
    }

    public static function create()
    {
        $route = 'admin.alerts';
        $array_response = [
            'title' => 'Novo Alerta',
            'action' => 'novo',
            'sensores' => Auth::user()->sensors_published(),
            'Indicadores' => Base::$_INDICADORES_,
            'Condicoes' => Base::$_ALERT_CONDITIONS_,
            'DiasDaSemana' => Base::$_DIAS_DA_SEMANA_,
            'TiposAlertas' => Base::$_ALERT_TYPES_
        ];
        return View::make($route, $array_response);
    }

    public static function destroy($alert_id)
    {
        $Alert = Alerts::find($alert_id);
        $Alert->delete();
        //REMOVER TBM OS ALERTMETA
        Session::flash('alert-code', 'ALE003S');
    }

    public static function zerar($sensor_id)
    {
        $hoje = new DateTime();
        $Sensormeta = Sensormeta::where('sensor_id', $sensor_id)
            ->where('alert_day', $hoje->format('Y-m-d'))
            ->first();
        $Sensormeta->alert_count = 0;
        $Sensormeta->save();
        Session::flash('alert-code', 'SEN002S');
        return Redirect::route('admin.sensores.show', $sensor_id);
    }

    public static function status($alert_id)
    {
        $Alert = Alerts::find($alert_id);
        $Alert->status = !$Alert->status;
        $Alert->save();
        Session::flash('alert-code', 'ALE002S');
        return Redirect::route('admin.alertas.index');
    }

    public static function store()
    {
        $data = Input::all();
        $validacao = AlertController::validation($data);

        //se a validação deu errado
        if ($validacao->fails()) {
            Session::flash('alert-code', 'ALE001D');
            return Redirect::back();
        } else {
//            return $data;
            $Alert = new Alerts();
            $Alert->createAlert($data);
//            return $Alert;
            $Alert->save();
            $alert_id = $Alert->save();
            if ($alert_id) {
                Session::flash('alert-code', 'ALE001S');
                return Redirect::route('admin.alertas.index');
            } else {
                Session::flash('alert-code', 'ALE001D');
                return Redirect::back();
            }
        }
    }

    public static function validation($data)
    {
        $regras = [
            'nome' => 'required',
            'sensor_id' => 'required'
        ];
        //NOVO SENSOR
        switch ($data['tipo_alerta']) {
            case 2: //'Sensor Inativo'
                $regras = array_merge($regras, [
                    'tempo_inativo' => 'required',
                ]);
                break;
            case 3: //'Valor de Indicador'
                $regras = array_merge($regras, [
                    'indicador' => 'required',
                    'condicao' => 'required',
                    'horario_inicial' => 'required',
                    'horario_final' => 'required'
                ]);
                break;
        }

        //executando validação
        $validacao = Validator::make($data, $regras);
        return $validacao;
    }

    public static function update($alert_id)
    {
        $data = Input::all();
        $validacao = AlertController::validation($data);

        //se a validação deu errado
        if ($validacao->fails()) {
            Session::flash('alert-code', 'ALE001D');
            return Redirect::back();
        } else {
            $Alert = Alerts::find($alert_id);
            $Alert->updateAlert($data);
            $alert_id = $Alert->update();
//            return $Alert;

            if ($alert_id) {
                Session::flash('alert-code', 'ALE002S');
//                return AlertController::index();
                return Redirect::route('admin.alertas.index');
            } else {
                Session::flash('alert-code', 'ALE002D');
                return Redirect::back();
            }
        }
    }

    public function zera_alert_count()
    {
        $this->Sensormeta->alert_count = 0;
        $this->Sensormeta->save();
    }



    //----------------------------------------------------------------------------------------------
    //------------------------------------ Funções RUN alertas -------------------------------------
    //----------------------------------------------------------------------------------------------

    public function run($alerts)
    {
//        $this->debug = 1;
        $agora = Carbon::now();
        $starttimeMASTER = microtime(true);

        foreach ($alerts as $alert) {
            $this->Alert = $alert;
            $sensor_id = $alert->sensor_id;
            $starttime = microtime(true);
            print_r("<br>");
            print_r("-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br>");
            print_r("======================================== Sensor/Alert (" . $sensor_id . " / " . $this->Alert->alert_id . ") ============================================================<br>");
            print_r("NOME: " . $this->Alert->nome . "<br>");
            print_r("TIPO: (" . $this->Alert->tipo_alerta . ") " . $this->Alert->get_tipoAlerta() . "<br>");

            $gate = true; //variável de controle para teste ou não do alerta (na verificação do diahora de funcionamento)

            if ($this->Alert->tipo_alerta > 1) {
                if ($this->debug) print_r("<br>*********** INÍCIO DO TESTE do dia/hora de ativação ***************<br>");
                if ($this->debug) print_r("Agora = " . $agora->toDateTimeString() . "<br>");
                if ($this->debug) print_r("Horário = " . $this->Alert->horario['horario_inicial'] . " - " . $this->Alert->horario['horario_final'] . "<br>");

                $data = [
                    'h_now' => $agora,
                    'h_ini' => Carbon::createFromFormat('H:i', $this->Alert->horario['horario_inicial']),
                    'h_end' => Carbon::createFromFormat('H:i', $this->Alert->horario['horario_final']),
                    'days' => $this->Alert->horario['horario_dias']
                ];
                $gate = self::testeDiaHora($data);
                if ($this->debug) print_r("*********** FIM DO TESTE do dia/hora de ativação ***************<br>");
            }
            if ($gate) {
                if ($this->debug) print_r("<br>INÍCIO DA AVALIAÇÃO<br>");
                //Buscando o POST
                $this->Post = Post::find($sensor_id);
                $this->Sensormeta = Sensormeta::where('sensor_id', $sensor_id)
                    ->where('alert_day', $this->date_sensor->date_reduced)
                    ->first();
                //vamos testar depois
//            $this->Sensormeta = $this->Post->sensormeta->where('alert_day', $this->date_sensor->date_reduced)
//                ->first();
                //se for do tipo inatividade e não existir, então vamos criar um sensormeta para hoje
                if (!count($this->Sensormeta) > 0 || ($this->Alert->tipo_alerta == 2 && !count($this->Sensormeta) > 0)) {
                    $params = [
                        'sensor_id' => $sensor_id,
                        'last_activity' => $agora->format('Y-m-d H:i:00'),
                        'last_values' => NULL,
                        'alert_day' => $agora->format('Y-m-d')
                    ];
                    $this->Sensormeta = Sensormeta::update_or_insert($params);
                }

                if (count($this->Sensormeta) > 0) {
                    //se existir, ou seja se possuir dados
                    if ($this->debug) {
                        print_r("======================================== Alert ==========================================================");
                        print_r('<pre>');
                        print_r($this->Alert->toArray());
                        print_r('</pre>');
                        print_r("======================================== Post ==========================================================");
                        print_r('<pre>');
                        print_r($this->Post->toArray());
                        print_r('</pre>');

                        print_r("===================================== Sensormeta =========================================================");
                        print_r('<pre>');
                        print_r($this->Sensormeta->toArray());
                        print_r('</pre>');
                    }

                    $this->Sensormeta->alert_count; // Número de alertas no dia

                    $last_activity = new DateTime($this->Sensormeta->last_activity);
                    $date_sensor = [
                        'date_completa' => $last_activity->format('Y-m-d H:i:s'),
                        'date_completa_sem_segundo' => $last_activity->format('Y-m-d H:i:00'),
                        'date' => $last_activity->format('Y-m-d H:i'),
                        'date_reduced' => $last_activity->format('Y-m-d'),
                        'data_legivel' => $last_activity->format('d/m/Y H:i:s'),
                        'hoje' => $last_activity->format('d-m-Y'),
                        'hoje_reduzido' => $last_activity->format('dmY'),
                        'dia' => $last_activity->format('d/m/Y'),
                        'hora' => $last_activity->format('H:i'),
                        'timestamp' => $last_activity->getTimestamp()
                    ];
                    $this->date_sensor = (object)$date_sensor;

                    if ($this->debug) print_r("===================================== date_sensor =========================================================");
                    if ($this->debug) print_r('<pre>');
                    if ($this->debug) print_r($this->date_sensor);
                    if ($this->debug) print_r('</pre>');

                    if ($this->Sensormeta->alert_count == "") {
                        if ($this->debug) print_r("******** UPDATE: Sensormeta->alert_count = 0 ***********<BR>");
                        $this->Sensormeta->alert_count = 0;
                        $this->Sensormeta->save();
                    }

                    /* -------------------------------------------------------------------------------------*/
                    /* ------------Início do controle de alertas -------------------------------------------*/
                    /* -------------------------------------------------------------------------------------*/
                    if ($this->debug) print_r("-------------------------------------------------------------------------------------");
                    if ($this->debug) print_r("------------Início do controle de alertas -------------------------------------------");
                    if ($this->debug) print_r("-------------------------------------------------------------------------------------<br>");
                    if ($this->debug) print_r("ALERT:name = " . $this->Alert->nome . "<br>");
                    if ($this->debug) print_r("SENSOR:post_id = " . $this->Post->post_id . "<br>");
                    if ($this->debug) print_r('SENSOR:alerts_count_' . $this->date_sensor->hoje_reduzido . " = " . $this->Sensormeta->alert_count . "<br>");
                    if ($this->debug) print_r('SENSOR:data_legivel = ' . $this->date_sensor->data_legivel . "<br>");

                    if ($this->Sensormeta->alert_count <= $this->n_alert_max) {

                        if ($this->debug) print_r("GLOBAL:radio_smtp_send_active = " . $this->radio_smtp_send_active . "<br>");
                        if ($this->debug) print_r("GLOBAL:radio_sms_send_active = " . $this->radio_sms_send_active . "<br>");
                        if ($this->debug) print_r("ALERT:send_email_sensor = " . $this->Alert->envio_email . "<br>");
                        if ($this->debug) print_r("ALERT:send_sms_sensor = " . $this->Alert->envio_sms . "<br>");
                        if ($this->debug) print_r("---------------------------------------------------------------<br>");

                        //atualizando o envio de email caso já tenha excedido o número de alertas diários (TESTAR)
                        if ($this->Sensormeta->alert_count == $this->n_alert_max) {
                            $this->send_email_sensor = 0;
                            $this->send_sms_sensor = 0;
                        } else {
                            $this->send_email_sensor = $this->radio_smtp_send_active && $this->Alert->envio_email;
                            $this->send_sms_sensor = $this->radio_sms_send_active && $this->Alert->envio_sms;
                        }

                        $alertar = $this->check_alerts($this->Alert->tipo_alerta);
                        if ($this->debug) print_r("---------------------------------------------------------------<br>");

                        if (isset($alertar)) {
                            if ($this->debug) print_r("***************************** ALERTAR (mensagem) *****************************************<br>");


                            if ($this->Alert->admin_id != NULL) { //ISSO QUER DIZER QUE SERÁ ENVIADO UM EMAIL PARA O ADMIN, POIS ESTE É O SEU CRIADOR
                                $this->User = User::find($this->Alert->admin_id);
                                $phone = Usermeta::get($this->User->user_id, 'phones');
                                if ($this->debug) print_r(">ADMIN<br>");
                            } else {
                                $this->User = User::find($this->Post->post_author);
                                $phone = Usermeta::get($this->User->user_id, 'phones');
                                if ($this->debug) print_r(">CLIENTE<br>");
                            }
                            $this->destinos_sms = ($phone != '') ? '55' . str_replace(array(' ', '-', '_', '(', ')'), array(''), $phone) : '';
                            if ($this->debug) print_r('<pre>');
                            if ($this->debug) print_r($alertar);
                            if ($this->debug) print_r('</pre>');
                            if ($this->debug) print_r("-----------------------------------------------------------------<br>");

                            $this->print_log($alertar);
                            foreach ($alertar as $ind => $alert_) {
                                Notification::create($alert_);
                                $msg_log[$ind] = '[' . $this->Post->title . '] ' . $alert_['message'];
                            }

                            if ($this->debug) print_r('<pre>');
                            if ($this->debug) print_r($msg_log);
                            if ($this->debug) print_r('</pre>');


                            $msg_email = (count($msg_log) > 1) ? implode('<br>', $msg_log) : $msg_log[0];
                            if ($this->debug) echo 'msg_log = ';
                            print_r($msg_email);
                            echo "<br>";

                            //envio do alerta
                            if ($this->send_email_sensor || $this->send_sms_sensor) {
                                $this->send_alert($msg_email);
                            } else {
                                if ($this->debug) print_r("Não foi necessário enviar alerta ----------------------------------------------<br>");
                            }
                        } else {
                            $this->print_exception("Não atingiu as condições necessárias em *check_alerts()* para enviar alerta por email/sms");
                        }
                    } else {
                        $this->print_exception("O número máximo de Alertas emitidos por dia foi atingido");
                    }
                } else {
                    $this->print_exception("Sensor sem Sensormeta, ou seja, sem dados na tabela SensoresLog");
                }
            } else {
                $this->print_exception("Alerta fora do horário de funcionamento");
            }

            $endtime = microtime(true);
            if ($this->debug) print_r("Tempo =  " . ($endtime - $starttime) . " ----------------------------------------------<br>");
        }
        $endtime = microtime(true);
        print_r("<br><br>-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br>");
        print_r("-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br>");
        print_r("TempoMASTER =  " . ($endtime - $starttimeMASTER) . " ----------------------------------------------<br>");
    }

    static public function testeDiaHora($data)
    {
        //$data['h_ini']
        //$data['h_end']
        //$data['now']
//        print_r($data['h_ini']);
//        print_r($data['h_end']);

        if (!isset($data['days'])) return false;

//        if (in_array($data['h_now']->dayOfWeek, $data['days'])) { //Se não estiver setado o dia da semana, está fora
        $gate = false;
        if ($data['h_ini'] <= $data['h_end']) {
            if (($data['h_ini'] <= $data['h_now']) && ($data['h_now'] < $data['h_end'])) {
                $gate = true;
            }
        } else {
            //significa que é outro dia
            if ($data['h_now'] >= $data['h_ini']) {
                $data['h_end']->add(new DateInterval('P1D'));
                if ($data['h_now'] < $data['h_end']) {
                    $gate = true;
                }
            } else {
                if ($data['h_now'] < $data['h_end']) {
                    $gate = true;
                }
            }
        }

//        dd($data['days']);
        if ($gate) {
            if (!in_array($data['h_now']->dayOfWeek, $data['days'])) {
                return false;
            }
        }
        return $gate;
    }

    public function check_alerts($tipo_alerta)
    {
        $alertar = NULL;
        switch ($tipo_alerta) {
            case 0: // 'Falha de Sensor',
                if ($this->Sensormeta->last_values != NULL) {
                    $alertar = $this->check_alert_fail($this->Sensormeta->last_values);
                }
                break;
            case 1: // 'Falha de Energia',
                if ($this->Sensormeta->last_values != NULL) {
                    $alertar = $this->check_alert_energy($this->Sensormeta->last_values);
                }
                break;
            case 2: // 'Sensor Inativo',
                $alertar = $this->check_alert_inactive();
                break;
            case 3: // 'Valor de Indicador'
                if ($this->Sensormeta->last_values != NULL) {
                    $alertar = $this->check_alert_indicator($this->Sensormeta->last_values);
                }
                break;
        }
        return $alertar;
    }

    //----------------------------------------------------------------------------------------------
    //------------------------------------ Funções CHECK alertas -----------------------------------
    //----------------------------------------------------------------------------------------------

    public function check_alert_fail($valores_indicador)
    {
        //Alerta Falha de Sensor (definição): É quando um Sensor (APARELHO) apresenta algum tipo de falha interna,
        // erro de circuito, falha de algum sensor (não importa qual), falha eletrônica, etc.
        // Nesse caso ele fica transmitindo o indicador failover=1 e os demais indicadores = NULL
        $alertar = NULL;
        if ($valores_indicador->failover == 1) {
            echo "**************************************<br>";
            echo "******* ALERTA FALHA DE SENSOR *******<br>";
            echo "**************************************<br>";
            echo 'failover = ' . $valores_indicador->failover . "<br>";

            $mensagem = [
                'title' => 'Alarme - Falha do Sensor',
                'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
                'body' => 'Houve uma falha no Sensor, isto acontece quando um Sensor apresenta algum tipo de falha interna, erro de circuito, 
                falha de algum sensor interno, falha eletrônica, remoção do microfone.',
            ];

            $alertar[] = [
                'sensor_id' => $this->Alert->sensor_id,
                'type' => 'danger',
                'title' => $mensagem['title'],
                'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
                'date' => \Carbon\Carbon::now(),
            ];
        }
        if ($this->send_email_sensor) {
            $this->subject = Option::get('text_emails_user_notify_alert_fail');
        }
        return $alertar;
    }

    public function check_alert_energy($valores_indicador)
    {
        // Alerta Falha de Energia (definição): É quando um sensor (APARELHO) detecta que faltou enegia (alimentação)
        // ele começa a transmitir o indicador failenergy=1, e transmiti os demais indicadores  normalmente,
        // enquanto ainda tem bateria.
        $alertar = NULL;
        if ($valores_indicador->failenergy == 1) {
            echo "**************************************<br>";
            echo "******* ALERTA FALHA DE ENERGIA *******<br>";
            echo "**************************************<br>";
            echo 'failenergy = ' . $valores_indicador->failenergy . "<br>";

            $mensagem = [
                'title' => 'Alarme - Falha de Energia do Sensor',
                'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
                'body' => 'Foi detectada uma queda de energia no Sensor.',
            ];

            $alertar[] = [
                'sensor_id' => $this->Alert->sensor_id,
                'type' => 'danger',
                'title' => $mensagem['title'],
                'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
                'date' => \Carbon\Carbon::now(),
            ];
        }
        if ($this->send_email_sensor) {
            $this->subject = Option::get('text_emails_user_notify_alert_energy');
        }
        return $alertar;
    }

    public function check_alert_inactive()
    {
        // Alerta Sensor Inativo (definição): É quando um sensor (APARELHO) ficar por um determinado periodo de tempo sem transmitir dados para o sistema.
        // No meu alerta deve ter uma caixa para selecionar Alerta de inatividade e um firulinha para escolher o periodo toleravel ( de 1 a 240 minutos)
        $alertar = NULL;
        $tempo_inativo = $this->Alert->condicao['tempo_inativo'] * 60; //(tempo configurado em segundos)
        $tempo_diff = $this->now->getTimestamp() - $this->date_sensor->timestamp; //(Diferença em segundos)

        if ($tempo_diff > $tempo_inativo) {
            echo "***************************************<br>";
            echo "***** ALERTA DE SENSOR INATIVO *****<br>";
            echo 'last_activity = ' . $this->date_sensor->data_legivel . "<br>";
            echo('now = ' . $this->now->format('d/m/Y H:i:s') . "<br>");
            echo('conf (s): ' . $tempo_inativo . "<br>");
            echo('diff (s): ' . $tempo_diff . "<br>");
            echo "***************************************<br>";

            $mensagem = [
                'title' => 'Alarme - Sensor Inativo',
                'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
                'body' => 'Última atividade do Sensor foi detectada',
            ];

            $alertar[] = [
                'sensor_id' => $this->Alert->sensor_id,
                'type' => 'danger',
                'title' => $mensagem['title'],
                'message' => $mensagem['body'] . ' em ' . $mensagem['instante'],
                'date' => \Carbon\Carbon::now(),
            ];
        }
        if ($this->send_email_sensor) {
            $this->subject = Option::get('text_emails_user_notify_alert_inactive');
        }
        return $alertar;
    }

    public function check_alert_indicator($valores_indicador)
    {
        $alertar = NULL;
        $condicao = $this->Alert->condicao['condicao'];
        $valores = $this->Alert->condicao['valores'];
        $indicador = $this->Alert->indicador["valor"];
        $nome_indicador = $this->indicadores[$indicador]['nome'];
        $escala_indicador = $this->indicadores[$indicador]['escala'];
        $valor_indicador = $valores_indicador->{$indicador};

//        dd($nome_indicador);
        echo "***************************************<br>";
        echo "**** ALERTA DE VALOR DO SENSOR  ****<br>";
        echo "***************************************<br>";
        if ($this->debug) echo $indicador . ': ' . $valor_indicador . '<br>';
        if ($this->debug) print_r("condicoes:");
        if ($this->debug) print_r("<pre>");
        if ($this->debug) print_r($condicao);
        if ($this->debug) print_r("</pre>");
        if ($this->debug) print_r("condicoes - valores: " . (json_encode($valores)) . "<br>");

        // checagem do alerta
        switch ($condicao['indice']) {
            case 0: //'0' => 'Dentro da faixa',
//                echo 'CONDIÇÃO: Dentro da faixa <br>';
                if (($valor_indicador >= $valores['minimo']) && ($valor_indicador <= $valores['maximo'])) {
                    $mensagem = [
                        'title' => 'Alarme - Limite Atingido',
                        'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
                        'body' => "Indicador: " . $nome_indicador . " = " . $valor_indicador . $escala_indicador . "; " . $condicao['valor'] . " entre: " . implode($escala_indicador . ' e ', $valores) . '.',
                    ];

                    $alertar[] = [
                        'sensor_id' => $this->Alert->sensor_id,
                        'type' => 'danger',
                        'title' => $mensagem['title'],
                        'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
                        'date' => \Carbon\Carbon::now(),
                    ];
                }
                break;
            case 1: //'1' => 'Fora da faixa',
//                echo 'CONDIÇÃO: Fora da faixa <br>';
                if (($valor_indicador < $valores['minimo']) || ($valor_indicador > $valores['maximo'])) {
                    $mensagem = [
                        'title' => 'Alarme - Limite Atingido',
                        'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
                        'body' => "Indicador: " . $nome_indicador . " = " . $valor_indicador . $escala_indicador . "; " . $condicao['valor'] . " entre: " . implode($escala_indicador . ' e ', $valores) . '.',
                    ];

                    $alertar[] = [
                        'sensor_id' => $this->Alert->sensor_id,
                        'type' => 'danger',
                        'title' => $mensagem['title'],
                        'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
                        'date' => \Carbon\Carbon::now(),
                    ];
                }
                break;
            case 2: //'2' => 'Igual a',
//                echo 'CONDIÇÃO: Igual a <br>';
                if ($valor_indicador == $valores) {
                    $mensagem = [
                        'title' => 'Alarme - Limite Atingido',
                        'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
                        'body' => "Indicador: " . $nome_indicador . " = " . $valor_indicador . $escala_indicador . "; " . $condicao['valor'] . ": " . $valores . $escala_indicador . '.',
                    ];

                    $alertar[] = [
                        'sensor_id' => $this->Alert->sensor_id,
                        'type' => 'danger',
                        'title' => $mensagem['title'],
                        'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
                        'date' => \Carbon\Carbon::now(),
                    ];
                }
                break;
            case 3: //'3' => 'Diferente de',
//                echo 'CONDIÇÃO: Diferente de <br>';
                if ($valor_indicador != $valores) {
                    $mensagem = [
                        'title' => 'Alarme - Limite Atingido',
                        'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
                        'body' => "Indicador: " . $nome_indicador . " = " . $valor_indicador . $escala_indicador . "; " . $condicao['valor'] . ": " . $valores . $escala_indicador . '.',
                    ];

                    $alertar[] = [
                        'sensor_id' => $this->Alert->sensor_id,
                        'type' => 'danger',
                        'title' => $mensagem['title'],
                        'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
                        'date' => \Carbon\Carbon::now(),
                    ];
                }
                break;
            case 4: //'4' => 'Maior que',
//                echo 'CONDIÇÃO: Maior que <br>';
                if ($valor_indicador > $valores) {
                    $mensagem = [
                        'title' => 'Alarme - Limite Atingido',
                        'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
                        'body' => "Indicador: " . $nome_indicador . " = " . $valor_indicador . $escala_indicador . "; " . $condicao['valor'] . ": " . $valores . $escala_indicador . '.',
                    ];

                    $alertar[] = [
                        'sensor_id' => $this->Alert->sensor_id,
                        'type' => 'danger',
                        'title' => $mensagem['title'],
                        'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
                        'date' => \Carbon\Carbon::now(),
                    ];
                }
                break;
            case 5: //'5' => 'Maior ou igual a',
//                echo 'CONDIÇÃO: Maior ou igual a <br>';
                if ($valor_indicador >= $valores) {
                    $mensagem = [
                        'title' => 'Alarme - Limite Atingido',
                        'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
                        'body' => "Indicador: " . $nome_indicador . " = " . $valor_indicador . $escala_indicador . "; " . $condicao['valor'] . ": " . $valores . $escala_indicador . '.',
                    ];

                    $alertar[] = [
                        'sensor_id' => $this->Alert->sensor_id,
                        'type' => 'danger',
                        'title' => $mensagem['title'],
                        'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
                        'date' => \Carbon\Carbon::now(),
                    ];
                }
                break;
            case 6: //'6' => 'Menor que',
//                echo 'CONDIÇÃO: Menor que <br>';
                if ($valor_indicador < $valores) {
                    $mensagem = [
                        'title' => 'Alarme - Limite Atingido',
                        'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
                        'body' => "Indicador: " . $nome_indicador . " = " . $valor_indicador . $escala_indicador . "; " . $condicao['valor'] . ": " . $valores . $escala_indicador . '.',
                    ];

                    $alertar[] = [
                        'sensor_id' => $this->Alert->sensor_id,
                        'type' => 'danger',
                        'title' => $mensagem['title'],
                        'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
                        'date' => \Carbon\Carbon::now(),
                    ];
                }
                break;
            case 7: //'7' => 'Menor ou igual a'
//                echo 'CONDIÇÃO: Menor ou igual a <br>';
                if ($valor_indicador <= $valores) {
                    $mensagem = [
                        'title' => 'Alarme - Limite Atingido',
                        'instante' => $this->now->format('H:i') . ' de ' . $this->now->format('d/m/Y'),
                        'body' => "Indicador: " . $nome_indicador . " = " . $valor_indicador . $escala_indicador . "; " . $condicao['valor'] . ": " . $valores . $escala_indicador . '.',
                    ];

                    $alertar[] = [
                        'sensor_id' => $this->Alert->sensor_id,
                        'type' => 'danger',
                        'title' => $mensagem['title'],
                        'message' => $mensagem['body'] . ' Em ' . $mensagem['instante'],
                        'date' => \Carbon\Carbon::now(),
                    ];
                }
                break;
        }

        if ($this->send_email_sensor) {
            $this->subject = Option::get('text_emails_user_notify_alert_indicator');
        }
        return $alertar;
    }

    public function print_log($data)
    {
        if ($this->debug) {
            print_r('<pre>');
            print_r($data);
            print_r('</pre>');
        }
    }

    public function send_alert($msg)
    {
        if ($this->debug) print_r("------------------EMAIL-SMS-----------------------------<br>");
        if ($this->debug) print_r("EMAIL:Envio= " . (($this->send_email_sensor) ? 'Habilitado' : 'Desabilidado') . "<br>");
        if ($this->debug) print_r("SMS:Envio= " . (($this->send_sms_sensor) ? 'Habilitado' : 'Desabilidado') . "<br>");
        if ($this->debug) print_r("---------------------------------------------------------<br>");

        if ($this->send_email_sensor) {
            if ($this->debug) print_r("enviar_email: ");
            $this->send_email($msg, $this->subject);
        }

        if ($this->send_sms_sensor) {
            if ($this->debug) print_r("enviar_sms: ");
            $this->send_sms($msg);
        }

        //update do contador de alertas
        if ($this->debug) print_r("*** Dont update alert count<br>");
        if (!$this->debug) $this->update_alert_count();
        if ($this->debug) print_r("---------------------------------------------------------------<br>");
    }

    //----------------------------------------------------------------------------------------------
    //------------------------------------ Funções CHECK alertas -----------------------------------
    //----------------------------------------------------------------------------------------------

    public function send_email($msg, $subject)
    {
        $user_email = $this->User->email;
        $user_name = $this->User->name;
        $emails = $this->Alert->get_destinatarios('email')->valores;

        if ($emails != NULL) {
            array_push($emails, $user_email);
        } else {
            $emails = $user_email;
        }

//        dd($emails);
        $vars = array(
            'name' => $user_name,
            'msg' => $msg,
            'url_site' => URL::route('admin.dashboard')
        );

        $email_data = [
            'vars' => $vars,
            'user_name' => $user_name,
            'subject' => $subject,
            'emails' => $emails,
        ];

        $retorno = EmailController::send_email_alert($email_data);
        $emails = (count($emails) > 1) ? implode('; ', $emails) : $emails;
    }

    public function send_sms($msg)
    {
        $user_sms = $this->destinos_sms;
        $destinatarios = json_decode($this->Alert->destinatarios);
        $destinos_sms = '';
        if (isset($destinatarios->sms)) {
            $destinos_sms = explode(';', str_replace(' ', '', $destinatarios->sms));
        }
        if ($destinos_sms != '') {
            foreach ($destinos_sms as $ind => $d_sms) {
                $destinos_sms[$ind] = ($d_sms != '') ? '55' . str_replace(array(' ', '-', '_', '(', ')'), array(''), $d_sms) : '';
            }
            array_push($destinos_sms, $user_sms);
        } else {
            $destinos_sms = $user_sms;
        }
        $this->destinos_sms = $destinos_sms;

        if ($this->destinos_sms != '') {
            if ($this->debug) echo "enviando sms!<br>";
            $this->sms_init = $this->SMSAPI_initialize();
            $this->sms_send = $this->SMSAPI_enviar($this->destinos_sms, $msg);
            if ($this->debug) {
                echo '<br>sms_init:';
                print_r('<pre>');
                print_r($this->sms_init);
                print_r('</pre>');
                echo 'sms_send:';
                print_r('<pre>');
                print_r($this->sms_send);
                print_r('</pre>');
                echo "mensagem: " . $msg . "<br>";
                echo "destinos:<br>";
                print_r('<pre>');
                print_r($this->destinos_sms);
                print_r('</pre>');
            }
            $dataSms = [
                'api_sms' => $this->sms_send,
                'mensagem' => $msg,
            ];
            $msg = "*** sms enviado: " . json_encode($dataSms) . "!<br>";
            Log::info($msg);
        }
        echo "<br>***SMS enviado!<br>";
    }

    public function update_alert_count()
    {
        $this->Sensormeta->alert_count++;
        if ($this->debug) print_r("---------------------------------------------------------------<br>");
        if ($this->debug) print_r("update_alert_count = " . $this->Sensormeta->alert_count . "<br>");
        if ($this->debug) print_r("---------------------------------------------------------------<br>");
        $this->Sensormeta->save();
    }

    private function print_exception($message)
    {
        print_r("<br>********** EXCEPTION: " . $message . " ************************************<br>");
    }


    //REMOVER (FUNÇÃO INATIVADA EM 27/10/2016)
    //VAMOS CRIAR UMA TABELA chamada alertmeta ??? talvez
//
//    public function update_log($new_log)
//    {
//
//        exit;
//        Notification::create([
//            'sensor_id' => $this->Alert->sensor_id,
//            'type'      => 'danger',
//            'title'     => 'Alarme - Limite Atingido',
//            'message'   => 'Indicador: Nível de Pressão Sonora Pico = 126dB; Maior que: 120dB. Alarme emitido às 23:00 de 22/05/2017',
//            'date'      => \Carbon\Carbon::now(),
//        ]);
//
//        if ($this->debug) print_r("<br>Escrever log_alert-------------------------------------------------<br>");
//
//        $old_log = json_decode(Option::get('log_alert_' . $this->Post->post_author), true);
//
//        if (is_array($old_log)) {
//            $new_log = (count($old_log)) ? array_merge($new_log, $old_log) : $new_log;
//        }
////        dd($new_log);
//        //$log_alert = array_unique($log_alert);
//        Option::update_or_insert('log_alert_' . $this->Post->post_author, json_encode($new_log));
//
//        //atualização do log_all
//        $old_log_all = json_decode(Option::get('log_alert_all'), true);
//        $old_log_all = (count($old_log_all)) ? array_merge($new_log, $old_log_all) : $new_log;
//        Option::update_or_insert('log_alert_all', json_encode($old_log_all));
//
//        return;
//    }
}
