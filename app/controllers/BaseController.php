<?php


class BaseController extends Controller
{

    const _API_LOGIN_ = "Medisom";
    const _API_PWD_ = "902490";
//    public $smsapi_login = 'Medisom';
//    public $smsapi_senha = '902490';
//    public $smsapi_chave = '';
    const _API_LOGIN_URL_ = "http://app.smsapi.com.br/contas/service.json";
    const _API_SEND_URL_ = "http://app.smsapi.com.br/mensagens/service.json";
    public $scripts;
    public $styles;
    private $smsapi_chave = '';

    static public function setExpense($last_sensormeta, $expense, $now)
    {
        $last_value_date = $last_sensormeta->created_at;
        $last_value = $last_sensormeta->last_values->expense;
        if (($last_value != NULL) || ($expense != NULL)) {
            $last_value = ($last_value != NULL) ? $last_value : 0;
            $expense = ($expense != NULL) ? $expense : 0;
            $expense_acum = $last_value + $expense;
            //diferença em dias
//        $now = \Carbon\Carbon::createFromFormat('Y-d-m H:i','2016-30-10 22:58');
//        $last_value_date = \Carbon\Carbon::createFromFormat('Y-d-m H:i','2016-30-11 00:05');
//        print_r($last_value_date); print_r('<br>'); print_r($now);print_r('<br>'); print_r($last_value_date->isSameDay($now));exit;
            if ($last_value_date->isSameDay($now)) {
                $retorno['expensed'] = $expense_acum;
            } else {
                $retorno['expensed'] = $expense;
            }

            $last_value_date->day(1)->setTime(0, 0); //zerando a hora e o dia, devem cair no mesmo mes
            $now->day(1)->setTime(0, 0);
//        print_r($last_value_date); print_r('<br>'); print_r($now);print_r('<br>'); print_r($last_value_date->isSameDay($now));exit;
            if ($last_value_date->isSameDay($now)) {
                $retorno['expensem'] = $expense;
            } else {
                $retorno['expensem'] = $expense_acum;
            }
        } else {
            $retorno = [
                'expensed' => NULL,
                'expensem' => NULL
            ];
        }
        return $retorno;
    }

    static public function transformWords($removeAcentos = true, $string = '', $params = array(), $transform = 'strtolower')
    {

        $a = array('á', 'â', 'ã', 'ç', 'é', 'ê', 'í', 'ó', 'ô', 'õ', 'ú', 'û', 'ü', 'Á', 'Â', 'Ã', 'Ç', 'É', 'Ê', 'Í', 'Ó', 'Ô', 'Õ', 'Ú', 'Û', 'Ü');

        $b = array('a', 'a', 'a', 'c', 'e', 'e', 'i', 'o', 'o', 'o', 'u', 'u', 'u', 'A', 'A', 'A', 'C', 'E', 'E', 'I', 'O', 'O', 'O', 'U', 'U', 'U');
        if ($removeAcentos) {
            $string = str_ireplace($a, $b, $string);
        }

        if ($params) {
            $string = str_ireplace($params['b'], $params['s'], $string);
        }
        if ($transform) {
            if ($transform == 'ucwords') {
                $string = strtolower($string);
                $string = explode(' ', $string);
                $remove = array('de', 'dos', 'da', 'das', 'e', 'a', 'em', 'na', 'no');
                foreach ($string as $s) {
                    if (in_array($s, $remove)) {
                        $n[] = $s;
                    } else {
                        $n[] = ucfirst($s);
                    }
                }
                $string = implode(' ', $n);
            } else {
                $string = $transform($string);
            }
        }

        return $string;
    }

    static public function dateTransform($date)
    {
        if (substr($date, 4, 1) == '-') {
            $ndate = new DateTime($date);
            return $ndate->format('d/m/Y H:i:s');
        } else if (substr($date, 2, 1) == '/') {
            $ndate = new DateTime($date);
            return $ndate->format('Y-m-d H:i:s');
        }
    }

    static public function formTreatData($param, $show_fields = true, $return = false)
    {

        $formid = (isset($param['formid']) && $param['formid'] != '') ? $param['formid'] : FALSE;
        $id = (isset($param['id']) && $param['id'] != '') ? $param['id'] : FALSE;
        $name_id = (isset($param['nameid']) && $param['nameid'] != '') ? $param['nameid'] : FALSE;
        $vars = (isset($param['vars']) && $param['vars'] != '') ? json_decode($param['vars']) : FALSE;

        if ($show_fields) {
            if ($formid) {
                echo '<input type="hidden" name="formid" value="' . $formid . '">';
            }
            if ($name_id) {
                if ($id) {
                    echo '<input type="hidden" name="' . $name_id . '" value="' . $id . '">';
                }
            }

            if ($vars) {
                foreach ($vars as $k => $v) {
                    echo '<input type="hidden" name="' . $k . '" value="' . $v . '">';
                }
            }
        }
        if ($return) {
            if ($return == 'array') {
                $vars = json_decode($vars, true);
                return array('formid' => $formid, 'id' => $id, 'name_id' => $name_id, 'vars' => $vars);
            } else if ($return == 'object') {
                return (object)array('formid' => $formid, 'id' => $id, 'name_id' => $name_id, 'vars' => $vars);
            } else if ($return == 'json') {
                $vars = json_decode($vars, true);
                return json_encode(array('formid' => $formid, 'id' => $id, 'name_id' => $name_id, 'vars' => $vars));
            }
        }
    }

    static public function getLogosReport($author_id)
    {
        //imagens
        $logo_medisom['tamanhomax'] = 25;
        $logo_cliente['tamanhomax'] = 50;

        //logo da Medisom
        $logo_medisom['path'] = asset('public/uploads/LogoMedisom128px.png');
        $logo_medisom['size'] = getimagesize($logo_medisom['path']);

        $logo_medisom['size'] = [self::imageResizeNewWidth($logo_medisom['size'], $logo_medisom['tamanhomax']), $logo_medisom['tamanhomax']];
        $logo_medisom['type'] = pathinfo($logo_medisom['path'], PATHINFO_EXTENSION);
        $logos['medisom'] = [
            'url' => 'data:image/' . $logo_medisom['type'] . ';base64,' . base64_encode(file_get_contents($logo_medisom['path'])),
            'size' => $logo_medisom['size']
        ];

        //logo do Cliente
        $lg_cliente = Usermeta::get_by($author_id, 'logo_cliente');
        if (($lg_cliente == NULL) || ($lg_cliente->meta_value == '')) {
            $logo_cliente = $logo_medisom;
        } else {
            $logo_cliente['path'] = ($lg_cliente != '') ? asset('public/uploads/docs-cadastro/id-' . $author_id . '/' . $lg_cliente->meta_value) : '';
            $logo_cliente['size'] = ($logo_cliente['path'] != '') ? getimagesize($logo_cliente['path']) : false;
            $logo_cliente['size'] = [self::imageResizeNewWidth($logo_cliente['size'], $logo_cliente['tamanhomax']), $logo_cliente['tamanhomax']];
            $logo_cliente['type'] = pathinfo($logo_cliente['path'], PATHINFO_EXTENSION);
        }

        $logos['cliente'] = [
            'url' => 'data:image/' . $logo_cliente['type'] . ';base64,' . base64_encode(file_get_contents($logo_cliente['path'])),
            'size' => $logo_cliente['size']
        ];
        return $logos;
    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    static public function imageResizeNewWidth($size, $new_height)
    {
        $width = $size[0];
        $height = $size[1];
        $new_width = ($new_height * $width) / $height;

//        print_r($new_width);
//        print_r('<br>');
        return round($new_width);
    }

    static public function getDataSensors($sensors)
    {

        $hoje = new DateTime();
//        $_INDICADORES_ = ReportController::$Indicadores;
//        $GrupoIndicadores = ReportController::$GrupoIndicadores;
        if (count($sensors) > 0) {
            if (count($sensors) > 1) {

                foreach ($sensors as $key => $sensor) {
                    $sensor->{'measures'} = json_decode($sensor->content);
                    $measures_str = ReportController::getGrupoIndicadoresStr($sensor->measures);
                    $Sensormeta = Sensormeta::where('sensor_id', $sensor->post_id)
                        ->where('alert_day', $hoje->format('Y-m-d'))
                        ->first();
//                    print_r($Sensormeta);
//                    print_r($sensor->last_sensormeta());
//                    print_r($Sensormeta);
//                    print_r('<br>');exit;

                    $sensor->{'measures_str'} = $measures_str;
                    if (count($Sensormeta) > 0) {
                        $last_activity = new DateTime($Sensormeta->last_activity);
                        /*
                                                print_r($measures_str);exit;
                                                echo $sensor->post_id;
                                                $sensor->{'alert_type'} = json_decode(Postmeta::get_by($sensor->post_id, 'alert_type')->meta_value);
                                                $sensor->{'alert_type_str'} = ($sensor->alert_type != '') ? implode(', ', $sensor->alert_type) : '';
                                                $sensor->{'alert_time'} = Postmeta::get_by($sensor->post_id, 'alert_time')->meta_value;

                                                $sensor->{'alert_num'} = Postmeta::get_by($sensor->post_id, 'alert_num')->meta_value;
                                                $sensor->{'alert_day'} = Postmeta::get_by($sensor->post_id, 'alert_day')->meta_value;
                                                $sensor->{'last_alert'} = Postmeta::get_by($sensor->post_id, 'last_alert')->meta_value;
                                                $sensor->{'last_activity'} = BaseController::dateTransform(Postmeta::get_by($sensor->post_id, 'last_activity')->meta_value);
                                                $sensor->{'visualization_dash'} = Postmeta::get_by($sensor->post_id, 'visualization_dash')->meta_value;
                                        */
                        $sensor->{'alert_num'} = $Sensormeta->alert_count;
                        $sensor->{'alert_day'} = $Sensormeta->alert_day;
                        $sensor->{'last_alert'} = $last_activity->format('Y-m-d H:i:s');
                        $sensor->{'last_activity'} = $last_activity->format('d/m/Y H:i:s');
                        $sensor->{'visualization_dash'} = Postmeta::get_by($sensor->post_id, 'visualization_dash')->meta_value;
                    } else {
                        $sensor->{'alert_num'} = '-';
                        $sensor->{'alert_day'} = '-';
                        $sensor->{'last_alert'} = '-';
                        $sensor->{'last_activity'} = '-';
                        $sensor->{'visualization_dash'} = 'u1';
                    }
                    $sensors[$key] = $sensor;
                }
            } else {
                $sensor = (empty($sensors[0])) ? $sensors : $sensors[0];
                $sensor->{'measures'} = json_decode($sensor->content);
                $measures_str = ReportController::getGrupoIndicadoresStr($sensor->measures);
                $Sensormeta = Sensormeta::where('sensor_id', $sensor->post_id)
                    ->where('alert_day', $hoje->format('Y-m-d'))
                    ->first();
                $sensor->{'measures_str'} = $measures_str;
                if (count($Sensormeta) > 0) {
                    $last_activity = new DateTime($Sensormeta->last_activity);
                    /*
                                            print_r($measures_str);exit;
                                            echo $sensor->post_id;
                                            $sensor->{'alert_type'} = json_decode(Postmeta::get_by($sensor->post_id, 'alert_type')->meta_value);
                                            $sensor->{'alert_type_str'} = ($sensor->alert_type != '') ? implode(', ', $sensor->alert_type) : '';
                                            $sensor->{'alert_time'} = Postmeta::get_by($sensor->post_id, 'alert_time')->meta_value;

                                            $sensor->{'alert_num'} = Postmeta::get_by($sensor->post_id, 'alert_num')->meta_value;
                                            $sensor->{'alert_day'} = Postmeta::get_by($sensor->post_id, 'alert_day')->meta_value;
                                            $sensor->{'last_alert'} = Postmeta::get_by($sensor->post_id, 'last_alert')->meta_value;
                                            $sensor->{'last_activity'} = BaseController::dateTransform(Postmeta::get_by($sensor->post_id, 'last_activity')->meta_value);
                                            $sensor->{'visualization_dash'} = Postmeta::get_by($sensor->post_id, 'visualization_dash')->meta_value;
                                    */
                    $sensor->{'alert_num'} = $Sensormeta->alert_count;
                    $sensor->{'alert_day'} = $Sensormeta->alert_day;
                    $sensor->{'last_alert'} = $last_activity->format('Y-m-d H:i:s');
                    $sensor->{'last_activity'} = $last_activity->format('d/m/Y H:i:s');
                    $sensor->{'visualization_dash'} = Postmeta::get_by($sensor->post_id, 'visualization_dash')->meta_value;
                } else {
                    $sensor->{'alert_num'} = '-';
                    $sensor->{'alert_day'} = '-';
                    $sensor->{'last_alert'} = '-';
                    $sensor->{'last_activity'} = '-';
                    $sensor->{'visualization_dash'} = 'u1';
                }
                /*
                [alert_num] => 0
                [alert_day] => 30-08-2016
                [last_alert] => 2016-08-29 04:02
                [last_activity] => 05/10/2016 15:06:03
                [visualization_dash] => u1
                */
                if (empty($sensors[0])) {
                    $sensors = $sensor;
                } else {
                    $sensors[0] = $sensor;
                }
                //            print_r($sensors); exit;
            }
        }
        return $sensors;
    }

    static public function randomPass($length = 6, $token = false, $binary = false, $maiucula = true, $minuscula = true, $number = true)
    {

        $key = (Option::get('api_key')) ? Option::get('api_token') : '';

        $min = ($minuscula) ? 'abcdefghijklmnopqrstuvwxyz' : '';
        $mai = ($maiucula) ? 'ABCDEFGHIJLKMNOPQRSTUVXZY' : '';
        $num = ($number) ? '1234567890' : '';

        $secret_key = $key . $min . $mai . $num;

        for ($encrypt = '', $cl = strlen($secret_key) - 1, $i = 0; $i < $length; $encrypt .= $secret_key[mt_rand(0, $cl)], ++$i)
            ;

        if ($token)
            $encrypt = hash_hmac('sha1', $encrypt, $key, $binary);

        return $encrypt;
    }

    static public function upload_image($file, $post)
    {
        $ext = $file->getClientOriginalExtension();
        $destinationPath = public_path() . '/uploads';
        $filename = md5(time()) . '.' . $ext;
        $upload_success = $file->move($destinationPath, $filename);
        if ($upload_success) {
            return Postmeta::update_or_insert(array('post_id' => $post->post_id, 'key' => 'image_default', 'value' => $filename));
        }
        return NULL;
    }

    /**
     * do_token cria um token
     * @param  integer $length tamanho do token
     * @param  boolean $binary token é binario
     * @return string          token gerado
     */
    public function do_token($length = 6, $token = false, $binary = false, $maiucula = true, $minuscula = true, $number = true)
    {
        $key = (Option::get('api_key')) ? Option::get('api_token') : '';

        $min = ($minuscula) ? 'abcdefghijklmnopqrstuvwxyz' : '';
        $mai = ($maiucula) ? 'ABCDEFGHIJLKMNOPQRSTUVXZY' : '';
        $num = ($number) ? '1234567890' : '';

        $secret_key = $key . $min . $mai . $num;

        for ($encrypt = '', $cl = strlen($secret_key) - 1, $i = 0; $i < $length; $encrypt .= $secret_key[mt_rand(0, $cl)], ++$i)
            ;

        if ($token)
            $encrypt = hash_hmac('sha1', $encrypt, $key, $binary);

        return $encrypt;
    }

    /**
     * [enqueue_scripts description]
     * @param  string $src [description]
     * @param  string $name [description]
     * @param  string $version [description]
     * @param  boolean $admin [description]
     * @param  boolean $footer [description]
     * @return [type]           [description]
     */
    public function enqueue_scripts($src = '', $name = '', $version = '', $admin = false, $footer = true)
    {
        $this->scripts[] = array(
            'src' => $src,
            'name' => $name,
            'version' => $version,
            'admin' => $admin,
            'footer' => $footer
        );
    }

    /**
     * [enqueue_styles description]
     * @param  string $href [description]
     * @param  string $name [description]
     * @param  string $version [description]
     * @param  boolean $admin [description]
     * @param  boolean $footer [description]
     * @return [type]           [description]
     */
    public function enqueue_styles($href = '', $name = '', $version = '', $admin = false, $footer = true)
    {
        $this->styles[] = array(
            'href' => $href,
            'name' => $name,
            'version' => $version,
            'admin' => $admin,
            'footer' => $footer
        );
    }

    /**
     * [get_enqueue_scripts description]
     * @param  boolean $admin [description]
     * @param  boolean $footer [description]
     * @return [type]          [description]
     */
    public function get_enqueue_scripts($admin = false, $footer = true)
    {
        if (count($this->scripts) > 0) {
            foreach ($this->scripts as $script) {
                if ($scripts['admin'] == $admin && $script['footer'] == $footer) {
                    echo '<script src="' . $scripts['src'] . '"></script>
					';
                }
            }
        }
    }

    /**
     * [get_enqueue_styles description]
     * @param  boolean $admin [description]
     * @param  boolean $footer [description]
     * @return [type]          [description]
     */
    public function get_enqueue_styles($admin = true, $footer = false)
    {

        if (count($this->styles) > 0) {
            foreach ($this->styles as $style) {
                if ($style['admin'] == $admin && $style['footer'] == $footer) {
                    echo '<link href="' . $style['href'] . '">';
                }
            }
        }
    }

    public function calculateDistanceMaps($start, $finish)
    {

        $theta = $start[1] - $finish[1];
        $distance = (sin(deg2rad($start[0])) * sin(deg2rad($finish[0]))) + (cos(deg2rad($start[0])) * cos(deg2rad($finish[0])) * cos(deg2rad($theta)));
        $distance = acos($distance);
        $distance = rad2deg($distance);
        $distance = $distance * 60 * 1.1515;

        return round($distance * 1.609, 2);
    }

    public function SMSAPI_initialize()
    {
        //login
        $dados = [
            'acao' => 'login',
            'usuario' => self::_API_LOGIN_,
            'senha' => self::_API_PWD_
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::_API_LOGIN_URL_);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch), true);
        if ($response['retorno']['codigo'] == 0) {
            $this->smsapi_chave = $response['retorno']['chave'];
            Option::update_or_insert('smsapi_saldo', $response['retorno']['saldo']);
            return $response;
        } else {
            return false;
        }
    }

    // ******************** FUNCTIONS ******************************

    public function SMSAPI_enviar($destinos, $texto)
    {
        if (!is_array($destinos))
            $destinos = array($destinos);

        if (strlen($texto) > 160)
            $texto = substr($texto, 0, 160);

        $dados = [
            'acao' => 'enviar',
            'destinos' => json_encode($destinos),
            'texto' => $texto,
            'chave' => $this->smsapi_chave
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::_API_SEND_URL_);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dados);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $retorno = curl_exec($ch);
        $response = json_decode($retorno, true);

        return $response;
    }

    function SMSAPI_startup()
    {

    }

    function SMSAPI_beforeRender()
    {

    }

    function SMSAPI_beforeRedirect()
    {

    }

    function SMSAPI_shutdown()
    {

    }

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }
}
