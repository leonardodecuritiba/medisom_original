<?php

namespace App\Helpers;

class SmsHelper
{
    const _API_LOGIN_       = "Medisom";
    const _API_PWD_         = "Medis902490om";
    const _API_LOGIN_URL_   = "http://app.smsapi.com.br/contas/service.json";
    const _API_SEND_URL_    = "http://app.smsapi.com.br/mensagens/service.json";
    private $smsapi_chave   = '';

    // ******************** FUNCTIONS ******************************
    function __construct()
    {
    }

    public function SMSAPI_initialize()
    {
        exit;
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
//            Option::update_or_insert('smsapi_saldo', $response['retorno']['saldo']);
            return $response;
        } else {
            return false;
        }
    }

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

}
