<?php

error_reporting(0);

class WsController extends BaseController
{
    /**
     * [jsonp trata dados recebidos via JSON retornando sua solicitaçao]
     * @param  string $method [metodo a ser buscado]
     * @param  string $action [acao a ser tomada]
     * @return json           [dados ]
     */
    public function jsonp($method = '', $action = 'get')
    {
        //Descomentar depois
//        if (Request::ajax()) {
        $action = str_replace('-', '_', $action);
        $toJson = array('get_meta', 'update_meta');

        $result = $method::$action(Input::all());

        $code = ($result) ? 200 : 301;
        if (!in_array($action, $toJson)) {
            if (is_array($result)) {
                return Response::json($result, $code)->setCallback(Input::get('callback'));
            } else {
                return Response::json(array($result), $code)->setCallback(Input::get('callback'));
            }
        }
//            else {
//            }
//        }
    }

    public function ws()
    {
        //http://medisom.com.br/sensor?nome=MSOM&sensor_id=171&laeq=150&lceq=40.0&la90=47.9&la50=45.3&la10=41.3&lamax=58.2&lamin=41.0&tempo_leq=5&alarme_set=55&ipa=90&failover=1
//        $nome = Input::get('nome'); //(string) 1 MSOM só pra indicar que é uma strig do nosso sistema
//        $cliente_id = Input::get('cliente_id'); //(int) 2 ID do cliente
        $sensor_id = Input::get('sensor_id'); //(int) 3 ID do sensor do cliente
        $now = \Carbon\Carbon::now();
        $created = $now->format('Y-m-d H:i:00');
        $last_update = Postmeta::getByMetaKeyValue($sensor_id, 'last_activity', $created)
            ->first();
        if (count($last_update) == 0) {

            $last_sensormeta = Sensormeta::where('sensor_id', $sensor_id)->orderBy('last_activity', 'desc')->first();
            $indicadores['laeq'] = Input::get('laeq'); //(int) 5 55.8  LAeq
            $indicadores['lceq'] = Input::get('lceq'); //(int) 6- 58.2   LCeq
            $indicadores['la90'] = Input::get('la90'); //(int) 7- LA90
            $indicadores['la50'] = Input::get('la50'); //(int) 8-  LA50
            $indicadores['la10'] = Input::get('la10'); //(int) 9- LA10
            $indicadores['lamax'] = Input::get('lamax'); //(int) 10- LAmax
            $indicadores['lamin'] = Input::get('lamin'); //(int) 11- LAmin
            $indicadores['time_leq'] = Input::get('tempo_leq'); //(int) 12- Tempo de Leq
            $indicadores['alarm_set'] = Input::get('alarme_set'); //(int) 13- Alarm Set - nível do alarme
            $indicadores['ipa'] = Input::get('ipa'); //(int) 14- Contador de alarme (IPA)
            $indicadores['ilum'] = Input::has('ilum') ? ((Input::get('ilum') == '@') ? NULL : Input::get('ilum')) : NULL; //(decimal) 10,1- Iluminação(ilum)
            $indicadores['temp'] = Input::has('temp') ? ((Input::get('temp') == '@') ? NULL : Input::get('temp')) : NULL; //(decimal) 10,1- Temperatura(temp)
            $indicadores['umid'] = Input::has('umid') ? ((Input::get('umid') == '@') ? NULL : Input::get('umid')) : NULL; //(decimal) 10,1- Umidade(umid)
            $indicadores['temp_i'] = Input::has('temp_i') ? Input::get('temp_i') : NULL; //(decimal) - Temperatura Interna(temp_i)
            $indicadores['ipaporcento'] = Input::has('ipaporcento') ? Input::get('ipaporcento') : NULL; //(decimal) - IPA por cento (ipaporcento)
            $indicadores['power'] = Input::get('power'); //(int) 11- Potência Elétrica (fase 1)
            $indicadores['expense'] = Input::get('expense'); //(int) 11- Consumo de Energia Elétrica (hora)
            $expense = BaseController::setExpense($last_sensormeta, $indicadores['expense'], $now);
            $indicadores['expensed'] = $expense['expensed'];//(int) 11- Consumo de Energia Elétrica (diário)
            $indicadores['expensem'] = $expense['expensem']; //(int) 11- Consumo de Energia Elétrica (mês)
            $indicadores['water'] = Input::get('water'); //(decimal) 10,1 - Consumo de Água
            $indicadores['failover'] = (Input::has('failover') && (Input::get('failover') != NULL)) ? Input::get('failover') : 0; //(int) 15- falha de sensor por falta de energia
            $indicadores['failenergy'] = (Input::has('failenergy') && (Input::get('failenergy') != NULL)) ? Input::get('failenergy') : 0; //(int) 15- falha de sensor por falta de energia

            $sensor_data = array(
                'post_id' => $sensor_id,
                'created' => $created,
                'laeq' => $indicadores['laeq'],
                'lceq' => $indicadores['lceq'],
                'la90' => $indicadores['la90'],
                'la50' => $indicadores['la50'],
                'la10' => $indicadores['la10'],
                'lamax' => $indicadores['lamax'],
                'lamin' => $indicadores['lamin'],
                'time_leq' => $indicadores['time_leq'],
                'alarm_set' => $indicadores['alarm_set'],
                'ipa' => $indicadores['ipa'],
                'ilum' => $indicadores['ilum'],
                'temp' => $indicadores['temp'],
                'umid' => $indicadores['umid'],
                'temp_i' => $indicadores['temp_i'],
                'ipaporcento' => $indicadores['ipaporcento'],
                'power' => $indicadores['power'],
                'expense' => $indicadores['expense'],
                'expensed' => $indicadores['expensed'],
                'expensem' => $indicadores['expensem'],
                'water' => $indicadores['water'],
                'failover' => $indicadores['failover'],
                'failenergy' => $indicadores['failenergy']
            );
            DB::table('sensores_log')->insert($sensor_data);
            //Agora vamos atualizar o sensor atual
            Postmeta::update_or_insert(array('post_id' => $sensor_id, 'key' => 'last_activity', 'value' => $created));

            //Finalizando, respondendo com o retorno das ids dos sensores para o equipamento
//            $ids_sensors = Post::list_id_active_sensors();
//            $retorno = NULL;
//            foreach ($ids_sensors as $id) {
//                $retorno .= "sensor_id=" . $id . ";sdcard=1\n";
//            }
            $retorno = "sensor_id=" . $sensor_id . ";sdcard=1\n";

            if ($_SERVER['SERVER_NAME'] != 'teste.medisom.com.br') {
                echo $retorno;


                //Atualizar a sensormeta
                $params = [
                    'sensor_id' => $sensor_id,
                    'last_activity' => $created,
                    'last_values' => $indicadores,
                    'alert_day' => $now->format('Y-m-d')
                ];

                $Sensormeta = Sensormeta::update_or_insert($params);
//                print_r('<pre>');
//                print_r($Sensormeta);
//                print_r('</pre>');
//
//                exit;

                //------------------------------------- SEND TO TEST BASE ---------------------------------------------------
                DB::connection('db_teste')->table('sensores_log')->insert($sensor_data);
                //------------------------------------- SEND TO TEST BASE ---------------------------------------------------
                $count = DB::connection('db_teste')->table('postmeta')->where('post_id', $sensor_id)
                    ->where('meta_key', 'last_activity')
                    ->count();
                if ($count > 0) {
                    DB::connection('db_teste')->table('postmeta')->where('post_id', $sensor_id)
                        ->where('meta_key', 'last_activity')
                        ->update(['meta_value' => $created]);
                } else {
                    DB::connection('db_teste')->table('postmeta')
                        ->insert([
                            'post_id' => $sensor_id,
                            'meta_key' => 'last_activity',
                            'meta_value' => $created
                        ]);
                }

                //------------------------------------- SEND TO TEST BASE ---------------------------------------------------
                $count = DB::connection('db_teste')->table('sensormeta')->where('sensor_id', $params['sensor_id'])
                    ->where('alert_day', $params['alert_day'])
                    ->count();
                if ($count > 0) {
                    DB::connection('db_teste')->table('sensormeta')->where('sensor_id', $params['sensor_id'])
                        ->where('alert_day', $params['alert_day'])
                        ->update([
                            'last_activity' => $params['last_activity'],
                            'last_values' => json_encode($params['last_values']),
                            'alert_day' => $params['alert_day']
                        ]);
                } else {
                    DB::connection('db_teste')->table('sensormeta')
                        ->insert([
                            'sensor_id' => $params['sensor_id'],
                            'alert_count' => 0,
                            'last_activity' => $params['last_activity'],
                            'last_values' => json_encode($params['last_values']),
                            'alert_day' => $params['alert_day']
                        ]);
                }
            }

        } else {
            echo 'SensorLog already been updated at: ' . $created;
        }

        exit;
    }

}
