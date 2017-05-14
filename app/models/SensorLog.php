<?php

use Carbon\Carbon;

class SensorLog extends Eloquent
{

    public $timestamps = false;
    protected $table = 'sensores_log';
    protected $primaryKey = 'post_id';

    static public function charts()
    {
        //date_default_timezone_set("America/Sao_Paulo");
        $name = Input::get('name');
        $type = Input::get('type');
        $type_report = Input::get('type_report');
        $from = Input::get('from');
        $to = Input::get('to');
        $base = explode(',', Input::get('base'));
        $start = Input::get('start');
        $end = Input::get('end');

        $post_id = Input::get('post_id');
        $sensor = Post::find($post_id);
        $sensor = BaseController::getDataSensors($sensor);

        $now = new DateTime;
        switch ($type_report) {
            case 'ps':
                $interval = 'w';
                $start = new DateTime("01-" . $start);
                $timeConf['start'] = $start->format('Y-m-01 00:00:00');
                $timeConf['end'] = $start->format('Y-m-t 23:59:59');
                break;

            case 'pd':
                $interval = 'd';
                $start = new DateTime($start);
                $t = clone $start;
                $t->modify('-1 day');
                $timeConf['start'] = $t->format('Y-m-d 00:00:00');
                $end = new DateTime($end);
                $timeConf['end'] = $end->format('Y-m-d 23:59:59');
                break;

            case 'se':
                $interval = 'd';
                $mid = new DateTime($start);
                $t = clone $mid;
                $t->modify('-4 day');
                $timeConf['start'] = $t->format('Y-m-d 00:00:00');
                $t = clone $mid;
                $t->modify('+3 day');
                $timeConf['end'] = $t->format('Y-m-d 23:59:59');
//                $timeConf['end'] = $now->format('Y-m-d H:i:s');
                break;

            case 'ph':
                $interval = $end;
                $start = new DateTime($start);
                $t = clone $start;
                $t->modify('-1 day');
                $timeConf['start'] = $t->format('Y-m-d ' . (24 - $end) . ':00:00');
                $t->modify('+2 day');
                $timeConf['end'] = $t->format('Y-m-d 00:00:00');
                break;
            default:
                // Configurando o tempo inicial
                $interval = 'm'; //minutos
                if (($start) && ($type != 'add')) { // porque o add tem outro formato
                    $start = new DateTime($start);
                    $timeConf['start'] = $start->format('Y-m-d 00:00:00');
                } else {
                    $last_day = clone $now;
                    switch ($sensor->visualization_dash) {
                        case 'u1':
                            $last_day->modify('-1 hour');
                            break;
                        case 'u6':
                            $last_day->modify('-6 hour');
                            break;
                        case 'u12':
                            $last_day->modify('-12 hour');
                            break;
                        case 'u24':
                            $last_day->modify('-24 hour');
                            break;
                        default: //h
                            $last_day->setTime(0, 0);
                            break;
                    }
                    $timeConf['start'] = $last_day->format('Y-m-d H:i:00');
                }

                // Configurando o tempo final
                if ($end) {
                    $end = new DateTime($end);
                    $timeConf['end'] = $end->format('Y-m-d 00:00:00');
                } else {
                    $timeConf['end'] = $now->format('Y-m-d H:i:00');
                }
                break;

        }

        switch ($type) {
            case 'media' : {
                $get = DB::table('sensores_log')->where('post_id', $post_id)->whereBetween('created', array($last_day->format('Y-m-d H:i:00'), $now->format('Y-m-d H:i:00')));
                if ($get->count() > 0) {
                    $min = DB::table('sensores_log')->where('post_id', $post_id)->whereBetween('created', array($last_day->format('Y-m-d H:i:00'), $now->format('Y-m-d H:i:00')))->min($name);
                    $max = DB::table('sensores_log')->where('post_id', $post_id)->whereBetween('created', array($last_day->format('Y-m-d H:i:00'), $now->format('Y-m-d H:i:00')))->max($name);
                    $retorno = array(
                        'min' => ($min != NULL) ? $min : '-',
                        'max' => ($max != NULL) ? $max : '-');
                } else {
                    $retorno = array(
                        'min' => '-',
                        'max' => '-');
                }
                echo json_encode($retorno);
                exit;
            }
            case 'full' : {
                $get = DB::table('sensores_log')->where('post_id', $post_id)->whereBetween('created', array($timeConf['start'], $timeConf['end']))->orderBy('created', 'asc');
                $msg_error = "Nenhum registro, utilize o filtro para buscar outros períodos.";
                break;
            }
            case 'add' : {
                $msg_error = 'Nenhum registro no período.';
                if (($start != NULL) && ($start != 'undefined') && ($start != '')) {
                    $start = Carbon::createFromFormat('YmdHis', $start)->format('Y-m-d H:i:00');
                } else {
                    $start = Carbon::now()->format('Y-m-d H:i:00');
                }
                $get = DB::table('sensores_log')->where('post_id', $post_id)->where('created', '>', $start)->orderBy('created', 'asc');
                break;
            }
            default: {
                //Retorno do dashboard
                $get = DB::table('sensores_log')->where('post_id', $post_id)->whereBetween('created', array($timeConf['start'], $timeConf['end']))->orderBy('created', 'asc');
                $msg_error = 'Nenhum registro no período.';
                break;
            }
        }
        if (!($get->count() > 0)) {
            print_r(json_encode(['status' => 0, 'response' => $msg_error]));
            exit;
        }
        $rows = $get->get();
        SensorLog::printing($rows, $base, $interval);
        exit;
    }

    static public function printing($rows, $base, $interval)
    {
        $Indicadores = Base::$_INDICADORES_;
        if (count($rows)) {
            $JSONretorno = array();
            switch ($interval) {
                case 'w':
                    $max_interval = 60 * 60 * 24 * 7;
                    break;
                case 'd':
                    $max_interval = 60 * 60 * 24;
                    break;
                case 'm':
                    $max_interval = 60;
                    break;
                default: //horas
                    $max_interval = (int)$interval * 60 * 60;
                    break;
            }
            $tini = strtotime($rows[0]->created) - 1;
            $tend = $tini + $max_interval;
            $nbase = count($base);

            //pegando os nomes reais dos indicadores
            foreach ($base as $b) {
                $display_indicadores[] = $Indicadores[$b]['nome'] . " (" . $Indicadores[$b]['escala'] . ")";
            }
            for ($i_row = 0; $i_row < count($rows); $i_row++) {
                $row = $rows[$i_row];
                if ($interval == 'm') {
                    $retorno_aux = array();
                    $retorno_aux["display_name"] = implode(',', $display_indicadores);
                    $retorno_aux["category"] = implode(',', $base);
                    $retorno_aux["count"] = $nbase;
                    $retorno_aux["date"] = $row->created;

                    for ($i = 0; $i < $nbase; $i++) {
                        $retorno_aux["value" . $i] = $row->{$base[0]};
                    }
                    $JSONretorno[] = $retorno_aux;
                } else {
                    $jstime = strtotime($row->created);
                    while ($jstime >= $tini && $jstime <= $tend) {
                        $row_soma[] = $row;
                        $i_row++;
                        $row = $rows[$i_row];
                        $jstime = strtotime($row->created);
                    }
                    $retorno_aux = array();
                    $retorno_aux["display_name"] = implode(',', $display_indicadores);
                    $retorno_aux["category"] = implode(',', $base);
                    $retorno_aux["count"] = count($base);
                    $retorno_aux["date"] = $row->created;
                    if ($retorno_aux["date"] != NULL) {
                        foreach ($row_soma as $r) {
                            for ($i = 0; $i < count($base); $i++) {
                                $retorno_aux["value" . $i] += pow(10, ($r->{$base[0]} / 10));
                            }
                        }
                        for ($i = 0; $i < count($base); $i++) {
                            $retorno_aux["value" . $i] = round(log10($retorno_aux["value" . $i] / count($row_soma)) * 10, 2);
                        }
                        $JSONretorno[] = $retorno_aux;
                    }

                    $tini += $max_interval;
                    $tend += $max_interval;
                }
                $retorno = [
                    'status' => 1,
                    'response' => ($JSONretorno)
                ];
            }
        } else {
            $retorno = [
                'status' => 0,
                'response' => 'Nenhum registro no período'
            ];
        }
        print_r(json_encode($retorno));
    }

    static public function clear($post_id, $init, $end)
    {
        return SensorLog::where('post_id', '=', $post_id)->take($init)->offset($end)->delete();
    }

}
