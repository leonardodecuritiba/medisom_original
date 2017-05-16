<?php

/**
 *
 */
class Alerts extends Eloquent
{

    protected $table = 'alerts';
    protected $timestamp = false;
    protected $primaryKey = 'alert_id';

    /**
     * [get um ou todos registros salvos]
     * @param  string $key [chave unica]
     * @return [array/string]      [valor ou valores buscados]
     */
    static public function get($reports_id, $key = '', $transformed = 0)
    {
        if ($key != '') {
            $reports = Alerts::where('alert_id', '=', $reports_id)->where('meta_key', '=', $key)->first();
        } else {
            $reports = Alerts::where('alert_id', '=', $reports_id)->get();
        }

        if ($transformed) {
            $reports->meta_value = json_decode($reports->meta_value);
        }
        return $reports;
    }

    public function createAlert($data)
    {
        //acertando o admin
        if (Auth::user()->group_id == 1) {
            $this->attributes['admin_id'] = Auth::user()->user_id;
        } else {
            $this->attributes['admin_id'] = NULL;
        }
        $this->attributes['sensor_id'] = $data['sensor_id'];
        $this->attributes['nome'] = $data['nome'];
        $this->attributes['tipo_alerta'] = $data['tipo_alerta'];
        $this->attributes['condicao'] = NULL;
        $this->attributes['indicador'] = NULL;
        $this->attributes['horario'] = NULL;
        $this->attributes['envio_email'] = isset($data['envio_email']);
        $this->attributes['envio_sms'] = isset($data['envio_sms']);
        $this->destinatarios = $data;

        switch ($this->tipo_alerta) {
            case 2: //'Sensor Inativo'
                $this->condicao = $data;
                $this->horario = $data;
                break;
            case 3: //Valor de Indicador
                $this->attributes['indicador'] = $data['indicador'];
                $this->condicao = $data;
                $this->horario = $data;
                break;
        }

        return $this;
    }

    public function updateAlert($data)
    {
        //acertando o admin
        $this->attributes['sensor_id'] = $data['sensor_id'];
        $this->attributes['nome'] = $data['nome'];
        $this->attributes['tipo_alerta'] = $data['tipo_alerta'];
        $this->attributes['condicao'] = NULL;
        $this->attributes['indicador'] = NULL;
        $this->attributes['horario'] = NULL;
        $this->attributes['envio_email'] = isset($data['envio_email']);
        $this->attributes['envio_sms'] = isset($data['envio_sms']);
        $this->destinatarios = $data;

        switch ($this->tipo_alerta) {
            case 2: //'Sensor Inativo'
                $this->condicao = $data;
                $this->horario = $data;
                break;
            case 3: //Valor de Indicador
                $this->attributes['indicador'] = $data['indicador'];
                $this->condicao = $data;
                $this->horario = $data;
                break;
        }

        return $this;
    }

    public function setDestinatariosAttribute($value)
    {
        if ($value == NULL) {
            $this->attributes['destinatarios'] = $value;
        }

        $envios = ['email', 'sms'];
        foreach ($envios as $envio) {
            if (($this->attributes['envio_' . $envio]) && ($value['destinatarios_' . $envio] != "")) {
                $value['destinatarios'][$envio] = $value['destinatarios_' . $envio];
            }
        }

        if (isset($value['destinatarios'])) {
            $this->attributes['destinatarios'] = json_encode($value['destinatarios']);
        }

        /*
        $env = ['email', 'sms'];
        foreach ($env as $en) {
            if (isset($value[$en])) {
                $dest = str_replace(' ', '', $value[$en]['destinatarios']);
                if (substr($dest, -1) == ';') {
                    $dest = substr($dest, 0, -1);
                }
                if ($dest != '') {
                    $dest = explode(';', $dest);
                }
                $value[$en]['destinatarios'] = $dest;
            }
        }
        */
    }

    public function setCondicaoAttribute($value)
    {
        if ($value == NULL) {
            $this->attributes['destinatarios'] = $value;
        }
        if ($this->tipo_alerta == 2) {
            $condicao['tempo_inativo'] = $value['tempo_inativo'];
        } else {
            $condicao['condicao'] = $value['condicao'];
            if ($value['condicao'] > 1) {
                $condicao['valor'] = $value['valor'];
            } else {
                $condicao['minimo'] = $value['minimo'];
                $condicao['maximo'] = $value['maximo'];
            }
        }

        $this->attributes['condicao'] = json_encode($condicao);
    }

    //GETS

    public function setHorarioAttribute($value)
    {
        $this->attributes['horario'] = json_encode([
            'horario_inicial' => $value['horario_inicial'],
            'horario_final' => $value['horario_final'],
            'horario_dias' => (isset($value['horario_dias'])) ? $value['horario_dias'] : NULL
        ]);
    }

    public function getCondicaoAttribute($value)
    {
        switch ($this->tipo_alerta) {
            case 2:
                $condicao = json_decode($value);
                $retorno = [
                    'tempo_inativo' => $condicao->tempo_inativo,
                    'print' => 'Tempo de inatividade: ' . $condicao->tempo_inativo . ' minutos'
                ];
                break;
            case 3:
                $condicao = json_decode($value);
                $retorno['condicao'] = [
                    'indice' => $condicao->condicao,
                    'valor' => Base::$_ALERT_CONDITIONS_[$condicao->condicao]];
                if ($condicao->condicao > 1) {
                    $retorno['valores'] = $condicao->valor;
                    $retorno["print"] = $retorno['condicao']['valor'] . ": " . $retorno['valores'];
                } else {
                    $retorno['valores'] = ['minimo' => $condicao->minimo, 'maximo' => $condicao->maximo];
                    $retorno["print"] = $retorno['condicao']['valor'] . " de: " . implode(' a ', $retorno['valores']);
                }
                break;
            default:
                $retorno["print"] = '-';
                break;
        }
        return $retorno;
        /*
        $condicao['condicao'] = $value['condicao'];
        if ($value['condicao'] > 1) {
            $condicao['valor'] = $value['valor'];
        } else {
            $valores = explode(' / ',$value['valores']);
            if($valores[0]>$valores[1]){
                $condicao['minimo'] = $valores[0];
                $condicao['maximo'] = $valores[1];
            } else {
                $condicao['minimo'] = $valores[1];
                $condicao['maximo'] = $valores[0];
            }
        }
        */
    }

    public function getIndicadorAttribute($value)
    {
        if ($value == NULL) { //se for nullo quer dizer q é alerta de inatividade
            $retorno['valor'] = NULL;
            $retorno["print"] = '-';
        } else {
            $print = Base::$_INDICADORES_[$value];
            $retorno['valor'] = $value;
            $retorno["print"] = $print['nome'] . ' (' . $print['escala'] . ')';
        }
        return $retorno;
    }

    public function getHorarioAttribute($value)
    {
        $horario = json_decode($value);
        if ($horario == NULL) { //se for nullo quer dizer q é alerta de falha (funciona o tempo inteiro)
            $retorno['horario_inicial'] = NULL;
            $retorno['horario_final'] = NULL;
            $retorno['horario_dias'] = NULL;
            $retorno['print'] = '-';
        } else { // senão é de inatividade ou de valor de indicador
            $retorno['horario_inicial'] = $horario->horario_inicial;
            $retorno['horario_final'] = $horario->horario_final;
            $retorno['horario_dias'] = $horario->horario_dias;
            $retorno['print'] = 'Inicial: ' . $horario->horario_inicial . '; ' . 'Final: ' . $horario->horario_final . '; ' .
                Base::getDiasByKeysStr($horario->horario_dias);
        }
        return $retorno;
    }

    public function get_destinatarios($type)
    {
        $retorno['valores'] = NULL;
        $retorno['print'] = NULL;
        if ($this->attributes['destinatarios'] != NULL) {
            $destinatarios = json_decode($this->attributes['destinatarios']);
            if (isset($destinatarios->{$type})) {
                $retorno['valores'] = explode(';', str_replace(' ', '', $destinatarios->{$type}));
                $retorno['print'] = implode('; ', $retorno['valores']);
            }
        }

        return (object)$retorno;
    }


    public function get_tipoAlerta()
    {
        return Base::$_ALERT_TYPES_[$this->attributes['tipo_alerta']];
    }

    public function admin()
    {
        return $this->belongsTo('User', 'admin_id', 'user_id');
    }

    public function sensor()
    {
        return $this->belongsTo('Post', 'sensor_id', 'post_id');
    }

    public function author_name()
    {
        if ($this->admin_id != NULL) {
            $name = $this->admin->name . ' (Admin)';
        } else {
            $owner = User::find($this->sensor['post_author']);
            $name = $owner['name'];
        }
        return $name;
    }

    public function sensor_author($user_id)
    {
        return $this->belongsTo('Post', 'sensor_id', 'post_id')->where('post_author', $user_id);
    }

    public function author($user_id)
    {
        return User::find($user_id);
    }

}