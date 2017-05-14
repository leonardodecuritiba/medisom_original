<?php

class ReportController extends BaseController
{

    static public $Colors = ["#FF6600", "#FCD202", "#B0DE09", '#1f77b4', '#aec7e8', '#2ca02c', '#98df8a', '#d62728', '#9467bd', '#c5b0d5', '#ff9896', '#8c564b', '#ff7f0e', '#ffbb78', '#c49c94', '#e377c2', '#f7b6d2', '#7f7f7f', '#c7c7c7', '#bcbd22', '#dbdb8d', '#17becf', '#9edae5'];//Email padrão para execução dos testes, ou seja sempre que $debug != 0
    static public $Bullets = ["round", "square", "triangleUp", "triangleDown", "bubble"];
    public $_EMAIL_PADRAO_TESTE = ['silva.zanin@gmail.com','dfabro@hotmail.com', 'daniel@medisom.com.br'];
    public $PER_BATCH = 5000;
    public $debug;
    public $OPCAO_REPORT;
    public $data_agora;
    public $Report;
//    public $array_nome_indicadores;
    public $Sensor;
    public $emailReport;
    public $data_minimax;
    public $range_indicadores;
    public $range_data_inicial; // Contém em cada índice um valor de datahora inicial e datahora final, que representa o intervalo de horas em cada dia escolhido
    public $range_data_final;
    public $vetor_datas;
    public $intervalo;
    public $repeticao;
    public $data_execucao;
    public $next_calendar;
    public $time_interval;
    public $base;
    public $not_mlog;
    public $dias_da_semana;
    public $graph_options;
    public $indicadoresAcumulado = ['ipa'];
//    static public $DiasDaSemana = array('Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado');
//    static public $DaysOfWeek = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

    function __construct($report_id, $debug = 0, $opcao = 'agendado')
    {
        //Tipo de legenda
        $this->debug = $debug;
        $this->OPCAO_REPORT = $opcao;
        $this->graph_options['category_field'] = 'date';
        $this->graph_options['colors'] = ReportController::$Colors;
        $this->graph_options['bullets'] = ReportController::$Bullets;
        $this->dias_da_semana = Base::$_DIAS_DA_SEMANA_;//ReportController::$DiasDaSemana;
        $this->range_indicadores = Base::$_RANGE_MINIMAX_;
        $this->not_mlog = Base::$_NOT_MLOG_;

        if ($this->OPCAO_REPORT == 'agendado') {
            $this->Report = Post::getPublishedReportByPostID($report_id);

            $this->data_agora = new DateTime('now');

            //Ler a data de execução
            $this->data_execucao = new DateTime($this->Report['Postmeta']->report_exe_calendar);

            // Pegando as configurações do REPORT --------------------------------------
            // Pegar o intervalor diário a ser somado no relatório
            $intervalo['tipo'] = key($this->Report['Postmeta']->report_exe_interval);
            $valor = $this->Report['Postmeta']->report_exe_interval->{key($this->Report['Postmeta']->report_exe_interval)};

            $ini = (object)[
                'hm' => $valor->ini,
                'h' => (int)substr($valor->ini, 0, 2),
                'm' => (int)substr($valor->ini, 3, 2)
            ];
            $fim = (object)[
                'hm' => $valor->fim,
                'h' => (int)substr($valor->fim, 0, 2),
                'm' => (int)substr($valor->fim, 3, 2)
            ];
            $intervalo['valor'] = (object)[
                'inicio' => $ini,
                'final' => $fim,
            ];

            $key = key($this->Report['Postmeta']->report_exe_repetition);
            if ($key == 'diariamente') {
                $option = $this->Report['Postmeta']->report_exe_repetition->{$key};
                $intervalo['resolucao'] = $option['resolution'];
            }
            $this->intervalo = (object)$intervalo;

            //Intervalo escolhido pelo usuário que será usado para soma
            switch ($this->intervalo->tipo) {
                case 'diário':
                    $this->time_interval = 'P1D';
                    break;
                case 'semanal':
                    $this->time_interval = 'P7D';
                    break;
            }

            // Definição das datas de repetição do REPORT --------------------------------------
            if ($this->debug == 1) print_r('$this->intervalo["tipo"] = ' . $this->intervalo->tipo . "<br>");
            if ($this->debug == 1) print_r('$this->intervalo->valor->inicio->hm = ' . $this->intervalo->valor->inicio->hm . "<br>");
            if ($this->debug == 1) print_r('$this->intervalo->valor->final->hm = ' . $this->intervalo->valor->final->hm . "<br>");

        }

    }

    //transforma o nome dos indicadores

    static public function create_or_update_Report($dados)
    {
        $dados['destinatarios'] = ($dados['destinatarios'] != '') ? explode(';', trim($dados['destinatarios'])) : '';
        // Dados do Report (POST)
        $report['post']['post_author'] = $dados['post_author'];
        $report['post']['post_id'] = $dados['post_id'];
        $report['post']['type'] = $dados['type'];
        $report['post']['slug'] = $dados['slug'];
        $report['post']['url'] = $dados['url'];
        $report['post']['title'] = $dados['title'];
        $report['post']['sensor_post_id'] = $dados['sensor_post_id'];
        $report['post']['measures'] = $dados['measures'];

        $report['post']['parent'] = $dados['sensor_post_id'];
        $post = $report['post'];

        $post_id = Post::update_or_insert($post);

        //Postmeta
        $report['postmeta']['sensor_post_id'] = $dados['sensor_post_id'];

        // Dados da repetição e Dados da próxima execução
        $option = strtolower($dados['report_exe_repetition']);
        $time = $dados['report_exe_interval_hora']['fim'];
        $horas = substr($time, 0, 2);
        $minutos = substr($time, 3, 2);
        $agora = new DateTime('now');
        switch ($option) {
            case 'n':
                $n_dias = ($dados['report_exe_options']['n_dias'] != '' && $dados['report_exe_options']['n_dias'] > 0 && $dados['report_exe_options']['n_dias'] <= 90) ? $dados['report_exe_options']['n_dias'] : 1;
                $repetition_interval = 'P' . $n_dias . 'D';
                $start_period = $dados['report_exe_options']['start_period'];
                $repetition[$option] = array(
//                'type'          => $option,
                    'start_period' => $start_period,
                    'n_dias' => $n_dias,
                );
                $prox_data = new DateTime($start_period);
                $prox_data->add(new DateInterval($repetition_interval));
                break;
            case 'mensalmente':
                $repetition_interval = 'P1M';
                $n_dias = ($dados['report_exe_options'][$option] < 10) ? "0" . $dados['report_exe_options'][$option] : $dados['report_exe_options'][$option];
                $repetition[$option] = $n_dias;
                $prox_data = new DateTime($agora->format('Y-m-') . $n_dias);
                $prox_data->setTime($horas, $minutos);
                break;
            case 'semanalmente':
                $repetition_interval = 'P7D';
                //Dia escolhido
                $dia = $dados['report_exe_options'][$option];
                $repetition[$option] = $dia;
//                $prox_data = DateTime::createFromFormat('U', strtotime('last ' . ReportController::$DaysOfWeek[$dia]));
                $prox_data = DateTime::createFromFormat('U', strtotime('last ' . Base::$_DAYS_OF_WEEK_[$dia]));
                $prox_data->setTimeZone(new DateTimeZone('America/Sao_Paulo'));
                $prox_data->setTime($horas, $minutos);
                break;
            case 'diariamente':
                $repetition_interval = 'P1D';
//                $time = $dados['report_exe_options']['time_execution'];
                $resolution = $dados['report_exe_options']['resolution'];
                $repetition[$option] = array(
                    'time_execution' => $time,
                    'resolution' => $resolution,
                );
                $prox_data = clone $agora;
                $prox_data->setTime($horas, $minutos);
                break;
        }

        if ($prox_data < $agora) {
            $prox_data->add(new DateInterval($repetition_interval));
        }
//        print_r($agora);
//        print_r($prox_data);exit;

        $report['postmeta']['report_exe_repetition'] = $repetition;
        $report['postmeta']['report_exe_calendar'] = $prox_data->format('Y-m-d H:i');

        // Dados do intervalo
        $intervalo[$dados['report_exe_interval']] = $dados['report_exe_interval_hora'];
        $report['postmeta']['report_exe_interval'] = $intervalo;
        $report['postmeta']['destinatarios'] = $dados['destinatarios'];

//        return $report['postmeta'];
        $postmeta = json_encode($report['postmeta']);
        $postmeta_id = Postmeta::update_or_insert(array('post_id' => $post_id, 'key' => 'report_execution', 'value' => $postmeta));

        return $post_id;

    }

    static public function getGrupoIndicadoresStr($measures)
    {
//        $Indicador = ReportController::$Indicadores;
//        $GrupoIndicadores = ReportController::$GrupoIndicadores;

        $Indicador = Base::$_INDICADORES_;
        $GrupoIndicadores = Base::$_GRUPOINDICADORES_;

        if (count($measures) > 1) {
            foreach ($measures as $measure) {
                foreach ($GrupoIndicadores as $ind => $grupo_indicador) {
                    if ($measure == $grupo_indicador['indice']) {
                        $nome = NULL;
                        $escala = NULL;
                        foreach ($grupo_indicador['indicadores'] as $indicador) {
                            $nome[] = $Indicador[$indicador]['nome'];
                            $escala[] = $Indicador[$indicador]['escala'];
                        }
                        $v = $grupo_indicador;
                        $v['impressao_individual'] = $nome;
                        $v['escala'] = $escala;
                        $retorno[] = $v;
                        break;
                    }
                }
            }
            return $retorno;
        } else {
            if (is_array($measures)) {
                $measure = $measures[0];
            } else {
                $measure = $measures;
            }
            foreach ($GrupoIndicadores as $ind => $grupo_indicador) {
                if ($measure == $grupo_indicador['indice']) {
                    foreach ($grupo_indicador['indicadores'] as $indicador) {
                        $nome[] = $Indicador[$indicador]['nome'];
                        $escala[] = $Indicador[$indicador]['escala'];
                    }
                    $retorno = $grupo_indicador;
                    $retorno['impressao_individual'] = $nome;
                    $retorno['escala'] = $escala;
                    return $retorno;
                }
            }
        }
    }

    static public function genPrintableReport($report_id, $token)
    {

        $meta_key = Crypt::decrypt($token);
        $report = Reports::get($report_id, $meta_key, 1);


        //INSERIR NA CRIAÇÃO DO RELATÓRIO
        $Postmeta = Postmeta::find($report->postmeta_id);
        $Author = $Postmeta->post->owner->name . ' (' . $Postmeta->post->owner->email . ")";
        //---------------------------------

        foreach ($report->meta_value->data as $dt) {
            if ($dt->total > 0) {
                $REPORT_DATA['data_report'][] = $dt;
            }
        }

        $REPORT_DATA['data_report'] = json_encode($REPORT_DATA['data_report']); //DADOS A SEREM IMPRESSOS
        $REPORT_DATA['medias'] = json_encode($report->meta_value->minimax); //MÉDIAS DOS DADOS A SEREM IMPRESSOS

        $_DATA_REPORT_ = $report->meta_value->dados_report;
        $hora_criacao = $report->meta_key;

        //Report text
        $REPORT_PDF['header'] = "www.medisom.com.br - Relatório Agendado - Criado em: " . $hora_criacao; //CABEÇALHO COM HORA
        $REPORT_PDF['nome'] = $_DATA_REPORT_->nome; //NOME DO RELATÓRIO
        $REPORT_PDF['id'] = $_DATA_REPORT_->id; //ID DO REPORT (SE HOUVER SENÃO '-')
        $REPORT_PDF['titulo'] = "Relatório Agendado - " . $_DATA_REPORT_->tipo; //TÍTULO DO RELATÓRIO
        $REPORT_PDF['sensor_nome'] = $_DATA_REPORT_->sensor_nome; //NOME DO SENSOR

        $REPORT_PDF['author'] = $Author; //NOME DO AUTOR DO RELATÓRIO

        $REPORT_PDF['indicadores'] = $_DATA_REPORT_->indicadores; //INDICADORES DO RELATÓRIO
        $REPORT_PDF['periodo'] = 'De ' . $_DATA_REPORT_->range_inicial . ' a ' . $_DATA_REPORT_->range_final; //PERÍODO DO RELATÓRIO
        $REPORT_PDF['tipo'] = $_DATA_REPORT_->tipo; //TIPO DO RELATÓRIO
        $REPORT_PDF['intervalo'] = $_DATA_REPORT_->intervalo_inicial . '/' . $_DATA_REPORT_->intervalo_final; //INTERVALO DO RELATÓRIO
        $REPORT_PDF['logo_medisom'] = $_DATA_REPORT_->logo_medisom; //LOGO MEDISOM
        $REPORT_PDF['logo_cliente'] = $_DATA_REPORT_->logo_cliente; //LOGO DO CLIENTE MEDISOM
        $REPORT_PDF['filename'] = $_DATA_REPORT_->filename; //NOME DO ARQUIVO A SER IMPRESSO

        //Report options
        $REPORT_OPTIONS['category_field'] = $report->meta_value->graph_options->category_field;
        $REPORT_OPTIONS['colors'] = json_encode($report->meta_value->graph_options->colors);
        $REPORT_OPTIONS['graph'] = $report->meta_value->graph_options->graph;

        $retorno = [
            'OPTIONS' => $REPORT_OPTIONS,
            'PDF' => $REPORT_PDF,
            'DATA' => $REPORT_DATA,
        ];
        return $retorno;
    }

    static public function removeReport($post_id)
    {
        $Postmeta = Postmeta::where('post_id', $post_id)->first();
        //remover reports
        Reports::where('postmeta_id', $Postmeta->postmeta_id)->delete();
        //remover postmeta
        $Postmeta->delete();
        //remover post
        Post::remove($post_id);
        return 1;
    }

    static public function transformNomeGrupoIndicadores($indicadores)
    {
        if (count($indicadores) > 1) {
            foreach ($indicadores as $i => $indicador) {
                foreach (Base::$_GRUPOINDICADORES_ as $key => $ind) {
                    if ($indicador == $ind['indice']) {
                        $retorno[$i] = $ind['impressao'];
                    }
                }
            }
        } else {
            if (is_array($indicadores)) $indicadores = $indicadores[0];
            foreach (Base::$_GRUPOINDICADORES_ as $key => $ind) {
                if ($indicadores == $ind['indice']) {
                    $retorno = $ind['impressao'];
                }
            }
        }
        return $retorno;
    }

    function send_email_reminder_report($flag_email_report)
    {

        $emails = $this->Report["Postmeta"]->destinatarios;
        $user_email = $this->Report["User"]->email;
        $user_name = $this->Report["User"]->name;

        $indicadores = $this->emailReport->dados_report['indicadores'];
        $tabela_cabecalho = '
        <div>
            <span style="font-weight: bold;">ID: </span>' . $this->emailReport->dados_report['id'] . '<br>
            <span style="font-weight: bold;">Nome do Relatório: </span>' . $this->emailReport->dados_report['nome'] . '<br>
            <span style="font-weight: bold;">Sensor: </span>' . $this->emailReport->dados_report['sensor_nome'] . '<br>
            <span style="font-weight: bold;">Indicadores: </span>' . $indicadores . '<br>
            <span style="font-weight: bold;">Período: </span>De ' . $this->emailReport->dados_report['range_inicial'] . ' a ' . $this->emailReport->dados_report['range_final'] . '<br>
            <span style="font-weight: bold;">Tipo: </span>' . $this->emailReport->dados_report['tipo'] . '<br>
            <span style="font-weight: bold;">Intervalo: </span>' . $this->emailReport->dados_report['intervalo_inicial'] . '/' . $this->emailReport->dados_report['intervalo_final'] . '<br>        
        </div>';

        $tabela_valores = '
        <table border="1px">
            <tr>
                <td width="200px" style="font-weight: bold;">Indicador(es)</td>
                <td width="200px" style="font-weight: bold;">Mínimo (dB)</td>
                <td width="200px" style="font-weight: bold;">Máximo (dB)</td>
                <td width="200px" style="font-weight: bold;">Média (dB)</td>
            </tr>';
        foreach ($this->data_minimax as $minimax) {
            $data_min = new DateTime($minimax->data_min);
            $data_max = new DateTime($minimax->data_max);
            $tabela_valores .= '<tr>                
                    <td>' . $minimax->base . '</td>
                    <td>' . $minimax->min . ' (' . $data_min->format('d/m/Y H:i') . ')</td>
                    <td>' . $minimax->max . ' (' . $data_max->format('d/m/Y H:i') . ')</td>
                    <td>' . $minimax->med . '</td>
                </tr>';
        }
        $tabela_valores .= '</table>';

        if ($flag_email_report) {
            $link_report = route('get-report', [$this->emailReport->reports_id, $this->emailReport->token_email]);
            $mensagem = 'Seu relatório já está pronto:<br>
                ' . $tabela_cabecalho . '<br><br>                
                ' . $tabela_valores . '<br><br>
                Para visualizá-lo, por favor <a href="' . $link_report . '">Clique aqui</a>.<br>';

            echo $link_report;
        } else {
            $mensagem = 'Não existem informações referentes ao período selecionado:<br>
                ' . $tabela_cabecalho . '<br>';
        }


        $subject = 'Alerta de Relatório Agendado - Medisom';
        $vars = array(
            'name' => $user_name,
            'msg' => $mensagem,
            'url_site' => URL::route('admin.dashboard')
        );

        if ($this->debug != 0) {
            $emails = $this->_EMAIL_PADRAO_TESTE;
        } else {
            if ($emails != '') {
                array_push($emails, $user_email);
            } else {
                $emails = $user_email;
            }
        }

        $email_data = [
            'vars' => $vars,
            'user_name' => $user_name,
            'subject' => $subject,
            'emails' => $emails
        ];
        $retorno = EmailController::send_email_reminder_report($email_data);
//        return;
        return $retorno;
    }

    function soma_indicadores($vetor_datas, $i, $indicador)
    {
        $retorno = [
            'valor' => 0,
            'cont' => 0,
        ];
        foreach ($vetor_datas as $ivet => $data) {
            $valor = $data['valores'][$i]['valor'];

            //Verificando os máx/mín
            if (!in_array($indicador, Base::$_NOT_RANGE_)) {
                $min = $this->range_indicadores['default']['min'];
                $max = $this->range_indicadores['default']['max'];
            } else {
                $min = $this->range_indicadores[$indicador]['min'];
                $max = $this->range_indicadores[$indicador]['max'];
            }
//                            echo 'indicador: ' . $indicador . '; min: ' . $min . '; max: ' . $max . '; valor: ' . $valor . '<br>';

            //aqui vão os valores que estão dentro do range, se estiverem fora não irão ser somados,
            if (($valor > $min) && ($valor < $max)) {
                if (!in_array($indicador, $this->not_mlog)) {
                    $retorno['valor'] += pow(10, ($valor / 10));
                    $retorno['cont']++;
                } else {
                    $retorno['valor'] += $valor;
                    $retorno['cont']++;
                }
            }
        }
        return $retorno;
    }

    function run($opcao = 'report')
    {
//        print_r($this->Report);exit;
        $retorno = 0;
        if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");
        if ($this->debug == 1) print_r("INÍCIO DO REPORT ----------------------------------------------<br>");
        if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");
        if ($this->debug == 1) print_r('data_agora = ' . $this->data_agora->format('d/m/Y H:i') . "<br>");
        if ($this->debug == 1) print_r('indicadores = ' . $this->Report['Post']->content . "<br>");
        if ($this->debug == 1) print_r("data_execucao = " . $this->data_execucao->format('d/m/Y H:i') . "<br>");
        if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");

        // base contém o número de indicadores do report
        $this->base = json_decode($this->Report['Post']->content);

        //Setando o Range de data (dia) inicial e final do relatório será agendado
        $this->setRangeData();

        //Setando o Vetor de datas (dia) inicial e final do relatório será agendado
        $this->setVetorDatas();

        //Fazer busca no banco de dados dos dados desse range
        $the_query = DB::table('sensores_log')->where('post_id', $this->Report['Sensor']->post_id)->whereBetween('created', array($this->range_data_inicial->format('Y-m-d H:i:00'), $this->range_data_final->format('Y-m-d H:i:00')))->orderBy('created', 'ASC');
        $total_rows = $the_query->count();

        if ($this->debug == 1) print_r('$total_rows = ' . $total_rows . "<br>");
        if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");

        if ($total_rows > 0) {
            $this->contagem($total_rows, $the_query);

            $JSONreport['data'] = $this->montaRetorno();
            if (count($JSONreport['data']) > 0) {

                $JSONreport['minimax'] = $this->calculaMiniMax(); //contem minimo, maximo (com suas posioes) e a média,
                $JSONreport['graph_options'] = $this->graph_options;

                $retorno = $JSONreport;

                if ($opcao == 'report') {

                    $JSONreport['tipo'] = 'data';
                    $JSONreport['dados_report'] = $this->get_dados_report('report');

                    $report = [
                        'postmeta_id' => $this->Report['Postmeta']->postmeta_id,
                        'meta_key' => $this->data_agora->format('d/m/Y H:i'),
                        'meta_value' => json_encode($JSONreport)
                    ];
                    $this->emailReport = (object)[
                        'reports_id' => Reports::update_or_insert($report),
                        'token_email' => Crypt::encrypt($report['meta_key']),
                        'dados_report' => $JSONreport['dados_report'],
                    ];

                    if ($this->debug == 1) print_r("-----------------JSONreport------------------------------<br>");
                    if ($this->debug == 1) print_r($JSONreport);
                    if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");
                    $retorno = 1;
                    //retorna o reports_id e o token para ser enviado por email
                } else {
                    return 0;
                }
            }
        }

        //atualizar próxima geração
        if ($this->debug == 0) {
            $this->updateNextCalendar();
        }
        return $retorno;
    }

    function setRangeData()
    {
        // Pegar o intervalo de repetição do relatório
        $this->repeticao = key($this->Report['Postmeta']->report_exe_repetition);
        $repeticao_option = $this->Report['Postmeta']->report_exe_repetition->{key($this->Report['Postmeta']->report_exe_repetition)};

        if ($this->debug == 1) print_r('repeticao = ' . $this->repeticao . "<br>");

        if ($this->repeticao == 'diariamente') {
            if ($this->debug == 1) print_r('repeticao_option[time_execution] = ' . $repeticao_option['time_execution'] . "<br>");
            if ($this->debug == 1) print_r('repeticao_option[resolution] = ' . $repeticao_option['resolution'] . "<br>");
        } else if ($this->repeticao == 'n') {
            if ($this->debug == 1) print_r('repeticao_option[start_period] = ' . $repeticao_option['start_period'] . "<br>");
            if ($this->debug == 1) print_r('repeticao_option[n_dias] = ' . $repeticao_option['n_dias'] . "<br>");
        } else {
            if ($this->debug == 1) print_r('repeticao_option = ' . $repeticao_option . "<br>");
        }

        $time = '';
        switch ($this->repeticao) {
            case 'n':
                $this->repetition_interval = 'P' . $repeticao_option['n_dias'] . 'D';

                // Geração da data (dia) de início do relatório (dia anterior)
                $this->range_data_inicial = DateTime::createFromFormat('d-m-Y', $repeticao_option['start_period']);

                // $this->range_data_inicial é a data (dia) de início do relatório
                $this->range_data_inicial->setTime($this->intervalo->valor->inicio->h, $this->intervalo->valor->inicio->m);
                $this->range_data_inicial->add(new DateInterval($this->repetition_interval));

                break;
            case 'diariamente':
                $this->repetition_interval = 'P1D';

                // $this->range_data_inicial é a data (dia) de início do relatório
                $this->range_data_inicial = clone $this->data_execucao;
                $this->range_data_inicial->setTime($this->intervalo->valor->inicio->h, $this->intervalo->valor->inicio->m);

                //Se a hora de inicio for maior que a hora de fim,
                // isso quer dizer que a hora de início se refere ao dia anterior
                if (strtotime($this->intervalo->valor->inicio->hm) > strtotime($this->intervalo->valor->final->hm)) {
                    $this->range_data_inicial->sub(new DateInterval('P1D'));
                }

                // Geração da data (dia) de início do relatório (dia anterior)
                $this->range_data_final = clone $this->data_execucao;
                $this->range_data_final->setTime($this->intervalo->valor->final->h, $this->intervalo->valor->final->m);

                //hora para ser usada na próxima execução
                $time = $repeticao_option['time_execution'];
                break;
            case 'mensalmente':
                $this->repetition_interval = 'P1M';

                // Mensalmente, entao o relatório é sempre gerado com base no mês anterior
                // sendo que a opção é o dia do mês que o relatório irá ser gerado

                // Geração da data (dia) de início do relatório
                $this->range_data_inicial = clone $this->data_execucao;
                $this->range_data_inicial->setTime($this->intervalo->valor->inicio->h, $this->intervalo->valor->inicio->m);
                $this->range_data_inicial->sub(new DateInterval($this->repetition_interval));

                //Se a hora de inicio for maior que a hora de fim, isso quer dizer que a hora de início se refere ao dia anterior
                if (strtotime($this->intervalo->valor->inicio->hm) > strtotime($this->intervalo->valor->final->hm)) {
                    $this->range_data_inicial->sub(new DateInterval('P1D'));
                    $this->range_data_inicial->setTime($this->intervalo->valor->inicio->h, $this->intervalo->valor->inicio->m);
                }

                // $this->range_data_final é a data (dia) de finalização do relatório
                $this->range_data_final = clone $this->data_execucao;

//                $report_data_inicial = $this->range_data_final->format('Y-m-').$repeticao_option;

                //hora para ser usada na próxima execução
                $time = $this->intervalo->valor->final->hm;
                break;
            case 'semanalmente':
                $this->graph_options['category_field'] = 'date-name';
                $this->rotateDiasDaSemana($repeticao_option);
                $this->repetition_interval = 'P6D';

                // Geração da data (dia) de início do relatório
                $this->range_data_inicial = clone $this->data_execucao;
                $this->range_data_inicial->setTime($this->intervalo->valor->inicio->h, $this->intervalo->valor->inicio->m);
                $this->range_data_inicial->sub(new DateInterval($this->repetition_interval));

                //Se a hora de inicio for maior que a hora de fim, isso quer dizer que a hora de início se refere ao dia anterior
                if (strtotime($this->intervalo->valor->inicio->hm) > strtotime($this->intervalo->valor->final->hm)) {
                    $this->range_data_inicial->sub(new DateInterval('P1D'));
                    $this->range_data_inicial->setTime($this->intervalo->valor->inicio->h, $this->intervalo->valor->inicio->m);
                }

                // $this->range_data_final é a data (dia) de finalização do relatório
                $this->range_data_final = clone $this->data_execucao;

                //hora para ser usada na próxima execução
                $time = $this->intervalo->valor->final->hm;

                /*
                $report_data_inicial = strtotime('last '.$this->dias_da_semana[$repeticao_option]);
                $this->range_data_inicial = DateTime::createFromFormat('U', $report_data_inicial);

                // $this->range_data_inicial é a data (dia) de início do relatório
                $this->range_data_inicial->setTimeZone(new DateTimeZone('America/Sao_Paulo'));

                //hora para ser usada na próxima execução
                $time = $this->intervalo->valor->final->hm;

                */
                break;
        }

        /*
        // $this->range_data_final é a data (dia) de finalização do relatório
        $this->range_data_final = clone $this->range_data_inicial;
        $this->range_data_final->setTime($this->intervalo->valor->final->h, $this->intervalo->valor->final->m);
        if($this->repeticao != 'diariamente'){
            $this->range_data_inicial->sub(new DateInterval($this->repetition_interval));
        }
        $this->range_data_inicial->setTime($this->intervalo->valor->inicio->h, $this->intervalo->valor->inicio->m);

        //se a hora de inicio for maior que a hora fim, isso significa que e periodo noturno
        if($this->intervalo->valor->inicio->h > $this->intervalo->valor->final->h){
            $this->range_data_inicial->sub(new DateInterval('P1D'));
        }
        */
        if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");
        if ($this->debug == 1) print_r('$this->range_data_inicial = ' . $this->range_data_inicial->format('d/m/Y H:i') . "<br>");
        if ($this->debug == 1) print_r('$this->range_data_final = ' . $this->range_data_final->format('d/m/Y H:i') . "<br>");
        //Próxima data em que o relatório será agendado

        //hora para ser usada na próxima execução
        if ($this->repeticao != 'n') {
            $this->setNextCalendar($time);
            if ($this->debug == 1) print_r('$this->next_calendar = ' . $this->next_calendar->format('d/m/Y H:i') . "<br>");
        }
        if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");

    }

    function rotateDiasDaSemana($dia_inicio)
    {
        if ($dia_inicio > 0) {
            $first = $this->dias_da_semana;
            $second = array();
            //pegar os elementos de INICIO até FIM
            for ($i = $dia_inicio; $i < sizeof($first); $i++) {
                array_push($second, $first[$i]); //set the pointer to the last element and add it to the second array
            }
            //AGORA pegar os elementos de O até INICIO
            for ($i = 0; $i < $dia_inicio; $i++) {
                array_push($second, $first[$i]); //set the pointer to the last element and add it to the second array
            }
//        print_r($first); print "<br />";
//        print_r($second);
            $this->dias_da_semana = $second;
        }
    }

    function setNextCalendar()
    {

        //Próxima data em que o relatório será agendado
        $this->next_calendar = clone $this->range_data_final;
        /*
        if($time != ""){
            $this->next_calendar->setTime(substr($time, 0, 2), substr($time, 3, 2));
        } else {
            $this->next_calendar->setTime(23,59);
        }
        */
        $this->next_calendar->add(new DateInterval($this->repetition_interval));
    }

    function setVetorDatas()
    {
        $this->vetor_datas = [];

        switch ($this->repeticao) {
            case 'diariamente' :
                switch ($this->intervalo->resolucao) {
                    case 'minuto' :
                        //Tipo de gráfico por barras
                        $resolucao = 'PT1M';
                        $this->graph_options['graph'] = 'line';
                        break;
                    case 'hora':
                        //Tipo de gráfico por barras
                        $resolucao = 'PT1H';
                        $this->graph_options['graph'] = 'line';
                        break;
                    case 'intervalo':
                        //Tipo de gráfico por barras
                        $resolucao = 'P1D';
                        $this->graph_options['graph'] = 'bar';
                        break;
                }
                break;
            case 'semanalmente':
                $resolucao = 'P1D';
                //Tipo de gráfico por barras
                $this->graph_options['graph'] = 'bar';
                break;
            case 'mensalmente':
                $resolucao = 'P1D';
                //Tipo de gráfico por barras
                $this->graph_options['graph'] = 'line';
                break;
        }


        if ($this->debug == 1) print_r('resolucao = ' . $resolucao . "<br>");
        if ($this->debug == 1) print_r('graph = ' . $this->graph_options['graph'] . "<br>");

        $daterange = new DatePeriod($this->range_data_inicial, new DateInterval($resolucao), $this->range_data_final);

        $ix = 0;

//        for ($cont = clone $this->range_data_inicial; $cont <= $this->range_data_final; $cont->add(new DateInterval($resolucao))) {
        foreach($daterange as $cont){
            $ix++;
            if ($this->repeticao == 'diariamente') {
                //inicial
                $inicio['data'] = $cont->format('Y-m-d H:i');
                $inicio['timestamp'] = $cont->getTimestamp();

                //final
                $cont_fim = clone $cont;

                //se a hora de inicio for maior que a hora fim, isso significa que e periodo noturno
                //SE FOR MINUTO A MINUTO, NAO HÁ INTERVALO
                if ($this->intervalo->resolucao != 'minuto') {
                    if ($this->intervalo->resolucao == 'intervalo') {
                        if (($this->intervalo->valor->inicio->h > $this->intervalo->valor->final->h)) {
                            $cont_fim->add(new DateInterval('P1D'));
                        }
                        $cont_fim->setTime($this->intervalo->valor->final->h, $this->intervalo->valor->final->m);
                    } else {
                        $cont_fim->add(new DateInterval($resolucao));
                    }
                }


                $fim['data'] = $cont_fim->format('Y-m-d H:i');
                $fim['timestamp'] = $cont_fim->getTimestamp();

            } else {
                //inicial
                $cont->setTime($this->intervalo->valor->inicio->h, $this->intervalo->valor->inicio->m);
                $inicio['data'] = $cont->format('Y-m-d H:i');
                $inicio['timestamp'] = $cont->getTimestamp();

                //final
                $cont_fim = clone $cont;
                //se a hora de inicio for maior que a hora fim, isso significa que e periodo noturno
                if ($this->intervalo->valor->inicio->h > $this->intervalo->valor->final->h) {
                    $cont_fim->add(new DateInterval('P1D'));
                }
                $cont_fim->setTime($this->intervalo->valor->final->h, $this->intervalo->valor->final->m);
                $fim['data'] = $cont_fim->format('Y-m-d H:i');
                $fim['timestamp'] = $cont_fim->getTimestamp();
            }


            for ($i = 0; $i < count($this->base); $i++) {
                $valores[$i]['base'] = strtolower($this->base[$i]);
                $valores[$i]['valor'] = NULL;
                $valores[$i]['cont'] = 0;
            }

            $var = [
                'inicio' => (object)$inicio,
                'fim' => (object)$fim,
                'valores' => $valores,
            ];
            $this->vetor_datas[] = $var;

//            if($this->debug) echo '<br>('.$ix.') horario: '.$inicio['data'].'/'.$fim['data'];
        }
//        PRINT_R($this->vetor_datas);EXIT;
    }

    function contagem($total_rows, $the_query)
    {
        if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");
        if ($this->debug == 1) print_r(" ---------------------- contagem() ------------------------<br>");
        if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");

        $per_batch = $this->PER_BATCH;
        $num_batches = ceil($total_rows / $per_batch);
        $resolucao = (isset($this->intervalo->resolucao)) ? $this->intervalo->resolucao : 'default';

        for ($page = 0; $page < $num_batches; $page++) {
            $offset = ($page * $per_batch);
            $rows = $the_query->limit($per_batch)->offset($offset)->get();
            $nrows = count($rows);

            if ($this->debug == 1) print_r("resolucao = " . $resolucao . "<br>");
            if ($this->debug == 1) print_r("offset = " . $offset . "<br>");
            if ($this->debug == 1) print_r('count(rows) = ' . $nrows . "<br>");
            if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");
            if ($this->debug == 1) print_r("---------- Começo do LAÇO FOR ----------------------<br>");
            if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");

            // Aqui vamos fazer a contagem diárias dos valores retornados nas rows
            $controlX = 0;
            $JSONretorno = array();

            if ($resolucao == 'minuto') {
                if ($this->debug == 3) print_r("--------------- POR MINUTO ------------------------------");
                for ($i_row = 0; $i_row < $nrows; $i_row++) {
                    $row = $rows[$i_row];

                    $timestamp_row = strtotime($row->created);
                    if ($this->debug == 3) print_r("<br>---------------DIA - " . $row->created . " ------------------------------<br>");
                    // Aqui vamos fazer a contagem diárias dos valores retornados nas rows
                    foreach ($this->vetor_datas as $ivet => $dia_cont) {
                        if ($this->debug == 3) echo 'dia_cont: ' . json_encode($dia_cont) . "<br>";

                        if (($timestamp_row >= $dia_cont['inicio']->timestamp) && ($timestamp_row <= $dia_cont['fim']->timestamp)) {

                            if ($this->debug == 3) print_r("---------------BASE - " . count($this->base) . " ------------------------------<br>");

                            for ($i = 0; $i < count($this->base); $i++) {
                                $indicador = strtolower($this->base[$i]);
                                $valor = $row->{$indicador};
                                if (($valor != NULL) && ($valor != '')) {
                                    $this->vetor_datas[$ivet]["valores"][$i]['valor'] = $valor;
                                    $this->vetor_datas[$ivet]["valores"][$i]['cont']++;
                                    if ($this->debug == 3) echo 'ti: ' . $dia_cont['inicio']->timestamp . '; tr: ' . $timestamp_row . '; tf: ' . $dia_cont['fim']->timestamp . '; i: ' . $indicador . '; v: ' . $valor . '<br>';
                                } else {
                                    if ($this->debug == 3) echo 'ti: ' . $dia_cont['inicio']->timestamp . '; tr: ' . $timestamp_row . '; tf: ' . $dia_cont['fim']->timestamp . '; i: ' . $indicador . '; v: NULL <br>';
                                }
                            }
                            if ($this->debug == 3) print_r("-------------------------------------------------<br>");
                        }
                    }
                }
            } else {
                for ($i_row = 0; $i_row < $nrows; $i_row++) {
                    $row = $rows[$i_row];
                    $timestamp_row = strtotime($row->created);
//                    print_r("---------------DIA - " . $row->created . " ------------------------------<br>");
                    // Aqui vamos fazer a contagem diárias dos valores retornados nas rows
                    foreach ($this->vetor_datas as $ivet => $dia_cont) {
//                        if ($this->debug == 2) echo 'ti: '.$dia_cont['inicio']->timestamp.'; tr: '.$timestamp_row.'; tf: '.$dia_cont['fim']->timestamp.'<br>';
                        if (($timestamp_row >= $dia_cont['inicio']->timestamp) && ($timestamp_row <= $dia_cont['fim']->timestamp)) {
//                            print_r("---------------BASE - " . $row->created . " ------------------------------<br>");
                            for ($i = 0; $i < count($this->base); $i++) {

                                $indicador = strtolower($this->base[$i]);
                                $valor = $row->{$indicador};

                                //Verificando os máx/mín
                                if (!in_array($indicador, Base::$_NOT_RANGE_)) {
                                    $min = $this->range_indicadores['default']['min'];
                                    $max = $this->range_indicadores['default']['max'];
                                } else {
                                    $min = $this->range_indicadores[$indicador]['min'];
                                    $max = $this->range_indicadores[$indicador]['max'];
                                }
                                if ($this->debug == 3) echo 'indicador: ' . $indicador . '; min: ' . $min . '; max: ' . $max . '; valor: ' . $valor . '<br>';

                                //aqui vão os valores que estão dentro do range, se estiverem fora não irão ser somados,
                                if (($valor > $min) && ($valor < $max)) {
                                    if (!in_array($indicador, $this->not_mlog)) {
                                        $this->vetor_datas[$ivet]["valores"][$i]['valor'] += pow(10, ($valor / 10));
                                        $this->vetor_datas[$ivet]["valores"][$i]['cont']++;
                                    } else {
                                        $this->vetor_datas[$ivet]["valores"][$i]['valor'] += $valor;
                                        $this->vetor_datas[$ivet]["valores"][$i]['cont']++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        //SÓ MOSTRAR
        if ($this->debug == 2) {
            print_r("-------------------------------------------------------------------------------------------<br>");
            foreach ($this->vetor_datas as $ivet => $dia_cont) {
                echo '[' . $ivet . ']' . json_encode($dia_cont) . "<br>";
                for ($i = 0; $i < count($this->base); $i++) {
                    echo 'v: ' . json_encode($dia_cont["valores"][$i]['cont']) . "<br>";
                }
                print_r("---------------------<br>");
            }
        }

        //EXCLUIR VALORES NULOS
        if ($this->debug == 2) print_r("---------------------------------------------------------------------<br>");
        foreach ($this->vetor_datas as $ivet => $dia_cont) {
            if ($this->debug == 2) echo '[' . $ivet . ']' . json_encode($dia_cont) . "<br>";
            for ($i = 0; $i < count($this->base); $i++) {
                if ($dia_cont["valores"][$i]['cont'] == NULL) {
                    unset($this->vetor_datas[$ivet]);
                }
            }
        }

        if ($this->debug == 2) {
            print_r("-------------------------------------------------------------------------------------------<br>");
            foreach ($this->vetor_datas as $ivet => $dia_cont) {
                echo '[' . $ivet . ']' . json_encode($dia_cont) . "<br>";
            }
        }

//        EXIT;
        if ($resolucao != 'minuto') {
            //Fazendo a média logarítmica
            $this->calculaMedia();
        }
    }

    function calculaMedia()
    {
//        print_r($this->vetor_datas);
        if ($this->debug == 3) print_r("---------------------------------------------------------------<br>");
        if ($this->debug == 3) print_r("-----------------calculaMedia()-------------------------------<br>");
        for ($i = 0; $i < count($this->base); $i++) {
            foreach ($this->vetor_datas as $ivet => $dia_cont) {
                $_BASE_ATUAL_ = strtolower($this->vetor_datas[$ivet]["valores"][$i]["base"]);
                $_VALOR_ = $this->vetor_datas[$ivet]["valores"][$i]['valor'];
                $_CONT_ = $this->vetor_datas[$ivet]["valores"][$i]['cont'];

                if ($this->debug == 3) print_r("valor = " . $_VALOR_ . "; cont = " . $_CONT_ . "<br>");
                if ($this->debug == 3) print_r("base = " . $_BASE_ATUAL_ . "; not_mlog = " . implode(', ', $this->not_mlog) . "<br>");

                if ($_CONT_ > 0) {
                    if (!in_array($_BASE_ATUAL_, $this->not_mlog)) {
                        $this->vetor_datas[$ivet]["valores"][$i]['valor'] = round(log10($_VALOR_ / $_CONT_) * 10, 2);
                    } else {
                        $this->vetor_datas[$ivet]["valores"][$i]['valor'] = round(($_VALOR_ / $_CONT_), 2);
                    }
                }
            }
        }
//        print_r($this->vetor_datas); exit;
        if ($this->debug == 3) print_r("-----------------/calculaMedia()-------------------------------<br>");
    }

    function montaRetorno()
    {
        //MONTAR O RETORNO
        $JSONretorno = array();
        foreach ($this->vetor_datas as $ivet => $dia_cont) {
            $retorno_aux = array();
            $retorno_aux["count"] = count($this->base);
            if ($retorno_aux["count"] > 1) {
//                $retorno_aux["category"] = implode(',', $this->transformNomeIndicador($this->base));
                $retorno_aux["category"] = implode(',', ReportController::transformNomeIndicador($this->base));
            } else {
//                $retorno_aux["category"] = ReportController::$Indicadores[$this->base[0]]['nome'];
                $retorno_aux["category"] = Base::$_INDICADORES_[$this->base[0]]['nome'];
            }
            $retorno_aux["date"] = $this->vetor_datas[$ivet]['fim']->data;
            $retorno_aux["total"] = $this->vetor_datas[$ivet]["valores"][0]['cont'];

            if ($this->repeticao == 'semanalmente' || $this->repeticao == 'dias_da_semana')
                $retorno_aux["date-name"] = $this->dias_da_semana[$ivet];

            if ($this->repeticao == 'hora')
                $retorno_aux["hour"] = substr($this->vetor_datas[$ivet]['inicio']->data, 11, 5);

            if ($this->repeticao == 'semanal') {
                $retorno_aux["date-name"] = ($ivet + 1) . 'ª';
            }

            for ($i = 0; $i < count($this->base); $i++) {
                $retorno_aux["value" . $i] = $this->vetor_datas[$ivet]["valores"][$i]['valor'];
            }
            $JSONretorno[] = $retorno_aux;
        }

        return $JSONretorno;
    }

    static public function transformNomeIndicador($indicadores)
    {
        if (count($indicadores) > 1) {
            foreach ($indicadores as $i => $value) {
//                $indicadores[$i] = ReportController::$Indicadores[$value]['nome'];
                $indicadores[$i] = Base::$_INDICADORES_[$value]['nome'];
            }
        } else {
            if (is_array($indicadores)) $indicadores = $indicadores[0];
//            $indicadores = ReportController::$Indicadores[$indicadores]['nome'];
            $indicadores = Base::$_INDICADORES_[$indicadores]['nome'];
        }
        return $indicadores;
    }

    function calculaMiniMax()
    {
        $Indicadores = Base::$_INDICADORES_;
//        print_r($this->vetor_datas);
        if ($this->debug == 4) print_r("---------------------------------------------------------------<br>");
        if ($this->debug == 4) print_r("-----------------calculaMiniMax()-------------------------------<br>");

        if ($this->debug == 4) print_r(json_encode($this->base) . '<br>');
        $MiniMaxMed = [];
        for ($i = 0; $i < count($this->base); $i++) {
            $indicador = $this->base[$i];
            if ($this->debug == 4) print_r("base = " . $indicador . "; media = " . (in_array($indicador, $this->not_mlog) ? 'aritmetica' : 'log') . "<br>");

            //*********** VERSÃO ANTIGA ***********
            /*
            $_VALORES_ = [];
            foreach ($this->vetor_datas as $ivet => $dia_cont) {
                $_VALORES_[$ivet] = $this->vetor_datas[$ivet]["valores"][$i]['valor'];
            }

            if ($this->debug == 4) print_r("_VALORES_ = " . implode(', ', $_VALORES_) . "<br>");

            //CALCULAR A MÉDIA
            $MEDIA      = 0;
            $CONT       = 0;
            $ACUMULADO  = 0;
            foreach ($_VALORES_ as $ivalor => $valor) {
                //Verificando os máx/mín
                if (!in_array($indicador, Base::$_NOT_RANGE_)) {
                    $min = $this->range_indicadores['default']['min'];
                    $max = $this->range_indicadores['default']['max'];
                } else {
                    $min = $this->range_indicadores[$indicador]['min'];
                    $max = $this->range_indicadores[$indicador]['max'];
                }
                if ($this->debug == 4) print_r("_VALORES_ = " . implode(', ', $_VALORES_) . "<br>");
//                EXIT;

                //aqui vão os valores que estão dentro do range, se estiverem fora não irão ser somados,
                if (($valor >= $min) && ($valor <= $max)) {
                    $CONT++;
                    if ($this->debug == 4) echo $CONT . ': DENTRO(' . $ivalor . ') - indicador: ' . $indicador . '; min: ' . $min . '; max: ' . $max . '; valor: ' . $valor . '<br>';
                    if (!in_array($indicador, $this->not_mlog)) {
                        $MEDIA += pow(10, ($valor / 10));
                    } else {
                        $MEDIA += $valor;
                    }
                } else {
                    if ($this->debug == 4) echo $CONT . ': FORA(' . $ivalor . ') - indicador: ' . $indicador . '; min: ' . $min . '; max: ' . $max . '; valor: ' . $valor . '<br>';
                }
            }
            */

            //*********** NOVA VERSÃO ***********
            //Verificando os máx/mín
            if (!in_array($indicador, Base::$_NOT_RANGE_)) {
                $min = $this->range_indicadores['default']['min'];
                $max = $this->range_indicadores['default']['max'];
            } else {
                $min = $this->range_indicadores[$indicador]['min'];
                $max = $this->range_indicadores[$indicador]['max'];
            }

            $_VALORES_ = [];
            //CALCULAR A MÉDIA
            $MEDIA = 0;
            $CONT = 0;
            $ACUMULADO = 0;
            $ACUMULADO_PERCENTUAL = 0;

            foreach ($this->vetor_datas as $ivet => $dia_cont) {
                $_VALORES_[$ivet] = $this->vetor_datas[$ivet]["valores"][$i]['valor'];

                $valor = $_VALORES_[$ivet];
                $ivalor = $ivet;

                //aqui vão os valores que estão dentro do range, se estiverem fora não irão ser somados,
                if (($valor >= $min) && ($valor <= $max) && ($valor != NULL) && ($valor != "")) {
                    $CONT++;
                    if ($this->debug == 4) echo $CONT . ': DENTRO(' . $ivalor . ') - indicador: ' . $indicador . '; min: ' . $min . '; max: ' . $max . '; valor: ' . $valor . '<br>';
                    if (!in_array($indicador, $this->not_mlog)) {
                        $MEDIA += pow(10, ($valor / 10));
                    } else {
                        $MEDIA += $valor;
                    }
                } else {
                    if ($this->debug == 4) echo $CONT . ': FORA(' . $ivalor . ') - indicador: ' . $indicador . '; min: ' . $min . '; max: ' . $max . '; valor: ' . $valor . '<br>';
                }
            }
            if ($this->debug == 4) print_r("_VALORES_ = " . implode(', ', $_VALORES_) . "<br>");

            //ESSA CONTA NÃO ESTÁ CORRETA POIS N_VALORES NÃO ESTÁ CONTABILIZANDO SOMENTE OS VALORES, ESTÁ CONTABILIZANDO NULLS TBM
            //VER O PERÍODO (GINASTICO 1 - LCEQ - ALARM SET - IPA / POR MINUTO / 24/10-24/10 / 21:00 - 02:00
            if (in_array($indicador, $this->indicadoresAcumulado)) {
                $ACUMULADO = $MEDIA;
                $N_VALORES = count($_VALORES_);
                if ($N_VALORES > 0) { //DESCOBRIR PORQUE ESTÁ COM ZERO?
                    $ACUMULADO_PERCENTUAL = round(($ACUMULADO / ($N_VALORES * 60)) * 100, 2);// = XX.X %
                }
                //(ACUMULADO / (N_VALORES x 60)) x 100 = XX.X %
            }

            if ($this->debug == 4) echo 'CONT: ' . $CONT . '; MEDIA: ' . $MEDIA . '; ACUMULADO: ' . $ACUMULADO . '<br>';


            //se CONT>0, isto é, se tiver valores a serem contabilizados e dentro do range
            if ($CONT > 0) {
                //aqui VAI SER FEITA A MÉDIA
                if (!in_array($indicador, $this->not_mlog)) {
                    $MEDIA = round(log10($MEDIA / $CONT) * 10, 2);
                } else {
                    if ($this->debug == 4) echo ' * média aritmética * <br>';
                    $MEDIA = round(($MEDIA / $CONT), 2);
                }
                if ($this->debug == 4) echo 'CONT: ' . $CONT . '; MEDIA: ' . $MEDIA . '<br>';

                $pos = array_keys($_VALORES_);
                $x = 0; //primeiro indice do vetor

                if ($this->debug == 4) echo 'pos: ' . json_encode($pos) . '<br>';

                //Enquanto o valor estiver fora da faixa "aceitável", percorra o vetor para encontrar o mínimo/máximo
                if ($this->debug == 4) echo '------------------------------------------------------<br>';
                while (
                    ($_VALORES_[$pos[$x]] < $min) ||
                    ($_VALORES_[$pos[$x]] > $max) ||
                    ($_VALORES_[$pos[$x]] == NULL) ||
                    ($_VALORES_[$pos[$x]] == "")
                ) $x++;
                $MIN = $_VALORES_[$pos[$x]];
                if ($this->debug == 4) echo '**********MINIMO ATUAL: _VALORES_[' . $pos[$x] . ']: ' . $MIN . '<br>';
                $x++;

                for (; $x < count($_VALORES_); $x++) {
                    if ($this->debug == 4) echo '_VALORES_[' . $pos[$x] . ']: ' . $_VALORES_[$pos[$x]] . '<br>';
                    if (($_VALORES_[$pos[$x]] < $MIN) && ($_VALORES_[$pos[$x]] != NULL) && ($_VALORES_[$pos[$x]] != "")) {
                        $MIN = $_VALORES_[$pos[$x]];
                        if ($this->debug == 4) echo '*********NOVO MÍNIMO: _VALORES_[' . $pos[$x] . ']: ' . $_VALORES_[$pos[$x]] . '<br>';
                    }
                }

                $MAX = max($_VALORES_);

                $imin = array_search($MIN, $_VALORES_);
                $imax = array_search($MAX, $_VALORES_);

                $MiniMaxMed[$i] = (object)[
                    'indice' => $indicador,
                    'base' => $Indicadores[$indicador]['nome'],
                    'escala' => $Indicadores[$indicador]['escala'],
                    'min' => $MIN,
                    'data_min' => $this->vetor_datas[$imin]['inicio']->data . ':00', //PARA FUNCIONAR NO JAVASCRIPT
                    'max' => $MAX,
                    'data_max' => $this->vetor_datas[$imax]['inicio']->data . ':00',
                    'med' => $MEDIA,
                    'acum' => $ACUMULADO,
                    'acum_p' => $ACUMULADO_PERCENTUAL,
                ];

                if ($this->debug == 4) echo '------------------------------------------------------<br>';
                if ($this->debug == 4) echo '_VALORES_[' . $imin . ']: ' . $MIN . '<br>';
                if ($this->debug == 4) echo '_VALORES_[' . $imax . ']: ' . $MAX . '<br>';
                if ($this->debug == 4) echo '------------------------------------------------------<br>';
                if ($this->debug == 4) print_r("MiniMaxMed = " . json_encode($MiniMaxMed[$i]) . "<br>");
                if ($this->debug == 4) print_r("------------------------------------------------<br>");
            }
        }

        if ($this->debug == 4) print_r("-----------------/calculaMiniMax()-------------------------------<br>");
        $this->data_minimax = $MiniMaxMed;
//        print_r($this->vetor_datas);
//        print_r($MiniMaxMed);
//        exit;
        return $MiniMaxMed;
    }

    public function get_dados_report($type = 'report')
    {
        // guardar no banco
        //NOME DO RELATORIO, SENSOR, INDICADORES, PERÍODO, TIPO, INTERVALO, MÁX-MIN-MÉD, DADOS
//                $indicadores = json_encode($this->transformNomeIndicador(json_decode($this->Report['Post']->content)));
        $indicadores = ReportController::transformNomeIndicador(json_decode($this->Report['Post']->content));


        if ($type == 'report') {
            $titulo = 'Relatório Agendado';
            $tipo = key($this->Report['Postmeta']->report_exe_repetition);
            switch ($tipo) {
                case 'diariamente':
                    $tipo . " (Por " . $this->intervalo->resolucao . ")";
                    break;
                case 'dias_da_semana':
                    $tipo = 'Dias da Semana';
                    break;
            }
            $author_id = Post::find($this->Report['Post']->parent)->post_author;
            $nome = $this->Report['Post']->title;
            $id = $this->Report['Post']->post_id;
            $sensor_nome = $this->Report['Sensor']->title;
        } else {
            $titulo = 'Relatório Manual';
            $Sensor = Post::find($this->Report['Sensor']->post_id);
            switch ($this->repeticao) {
                case 'semanal':
                    $tipo = 'Semanal';
                    break;
                case 'diario':
                    $tipo = 'Diário';
                    break;
                case 'dias_da_semana':
                    $tipo = 'Dias da Semana';
                    break;
                case 'detalhado':
                    $tipo = 'Detalhado';
                    break;
                case 'periodo':
                    $tipo = 'Período' . " (Por " . $this->intervalo->resolucao . ")";
                    break;
                default :
                    $tipo = ucfirst($this->repeticao) . (($this->repeticao == 'periodo') ? " (Por " . $this->intervalo->resolucao . ")" : "");
                    break;
            }
            $author_id = $Sensor->post_author;
            $nome = 'Relatório Manual';
            $id = '#';
            $sensor_nome = $Sensor->title;
        }
        $User_author = User::find($author_id);
        $Author = User::find($author_id)->name . ' (' . $User_author->email . ")";

        $logos = BaseController::getLogosReport($author_id);
        $hora_criacao = Carbon\Carbon::now();
        /*
        //imagens
        $tamanho_medisom = 25;
        $tamanho_cliente = 50;

        //logo da Medisom
        $path_logo_medisom = asset('public/uploads/LogoMedisom128px.png');
        $logo_size = getimagesize($path_logo_medisom);
        $logo_size = [BaseController::imageResizeNewWidth($logo_size, $tamanho_medisom), $tamanho_medisom];
        $type = pathinfo($path_logo_medisom, PATHINFO_EXTENSION);
        $logo_medisom = [
            'url' => 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents($path_logo_medisom)),
            'size' => $logo_size
        ];

        //logo do Cliente
        $author_id = Post::find($this->Report['Post']->parent)->post_author;
        $logo_cliente = Usermeta::get_by($author_id, 'logo_cliente');
        $path_logo_cliente = ($logo_cliente != '') ? asset('public/uploads/docs-cadastro/id-' . $author_id . '/' . $logo_cliente->meta_value) : $path_logo_medisom;
        $logo_size = getimagesize($path_logo_cliente);
        $logo_size = [BaseController::imageResizeNewWidth($logo_size, $tamanho_cliente), $tamanho_cliente];
        $type = pathinfo($path_logo_cliente, PATHINFO_EXTENSION);
        $logo_cliente = [
            'url' => 'data:image/' . $type . ';base64,' . base64_encode(file_get_contents($path_logo_cliente)),
            'size' => $logo_size
        ];
        */

        $dados_report = [
            'header' => "www.medisom.com.br - Relatório Manual - Criado em: " . $hora_criacao->format('H:i - d/m/Y'),//CABEÇALHO COM HORA
            'nome' => $nome, //NOME DO RELATÓRIO
            'titulo' => $titulo . " - " . $tipo, //TÍTULO DO RELATÓRIO
            'logo_medisom' => $logos['medisom'], //LOGO MEDISOM
            'logo_cliente' => $logos['cliente'], //LOGO DO CLIENTE MEDISOM
            'filename' => 'medisom.pdf',
            'id' => $id, //ID DO REPORT (SE HOUVER SENÃO '-')
            'sensor_nome' => $sensor_nome, //NOME DO SENSOR
            'author' => $Author, //NOME DO SENSOR
            'indicadores' => (count($indicadores) > 1) ? implode(', ', ($indicadores)) : $indicadores, //INDICADORES DO RELATÓRIO
            'range_inicial' => $this->range_data_inicial->format('d/m/Y'),
            'range_final' => $this->range_data_final->format('d/m/Y'),
            'periodo' => 'De ' . $this->range_data_inicial->format('d/m/Y') . ' a ' . $this->range_data_final->format('d/m/Y'), //PERÍODO DO RELATÓRIO
            'tipo' => $tipo,
            'intervalo_inicial' => $this->intervalo->valor->inicio->hm,
            'intervalo_final' => $this->intervalo->valor->final->hm,
            'intervalo' => $this->intervalo->valor->inicio->hm . '/' . $this->intervalo->valor->final->hm, //INTERVALO DO RELATÓRIO
        ];
        return $dados_report;
    }

    function updateNextCalendar()
    {
//      Atualizar próxima geração
        $dt = $this->next_calendar;
        $this->Report['Postmeta']->report_exe_calendar = $dt->format('Y-m-d H:i');
        if ($this->debug == 0) {
            Post::updatePublishedReport($this->Report);
        }
        $this->Report['Postmeta']->report_exe_calendar = $dt;
        return;
    }

    function fake_report()
    {
        /* ===========================================================*/
        /* ========================CONSTRUTOR=========================*/
        /* ===========================================================*/
        $data = Input::all();

//        if($data["type_report"]=='periodo'){
//            return 0;
//        }

        if ($this->debug == 1) print_r($data);

        if (!isset($data['measures'])) {
            $retorno = [
                'status' => 0,
                'response' => 'Por favor, escolha pelo menos um indicador.'];
            return json_encode($retorno);
        }
        $Post = (object)[
            'content' => json_encode($data['measures']),
        ];
        $Sensor = (object)[
            'post_id' => $data['sensor_id'],
        ];
        $this->Report = [
            'Post' => $Post,
            'Sensor' => $Sensor,
        ];
        $this->data_agora = new DateTime('now');

        // base contém o número de indicadores do report
        $this->base = json_decode($this->Report['Post']->content);

        // Tipo de repetição
        $this->repeticao = $data["type_report"];

        //Ler a data de execução - isto é, a data final
        if ($this->repeticao == 'detalhado') {
            $this->data_execucao = new DateTime($data["data_detalhado"]);
        } else {
            $this->data_execucao = new DateTime($data["data_final"]);
        }

        // Pegando as configurações do REPORT --------------------------------------
        // Pegar o intervalor diário a ser somado no relatório
        $intervalo['resolucao'] = 'minuto';

        // Definindo o intervalo (a hora inicial e a hora final)
        switch ($this->repeticao) {
            case 'periodo':
                $intervalo['resolucao'] = $data['resolucao'];
                $ini = (object)[
                    'hm' => $data["hora_inicial"],
                    'h' => (int)substr($data["hora_inicial"], 0, 2),
                    'm' => (int)substr($data["hora_inicial"], 3, 2)
                ];
                $fim = (object)[
                    'hm' => $data["hora_final"],
                    'h' => (int)substr($data["hora_final"], 0, 2),
                    'm' => (int)substr($data["hora_final"], 3, 2)
                ];
                break;
            case 'semanal':
            case 'diario':
                $intervalo['resolucao'] = 'semana';
                $ini = (object)[
                    'hm' => $data["hora_inicial"],
                    'h' => (int)substr($data["hora_inicial"], 0, 2),
                    'm' => (int)substr($data["hora_inicial"], 3, 2)
                ];
                $fim = (object)[
                    'hm' => $data["hora_final"],
                    'h' => (int)substr($data["hora_final"], 0, 2),
                    'm' => (int)substr($data["hora_final"], 3, 2)
                ];
                break;
            case 'hora':
                $intervalo['resolucao'] = 'hora';
            case 'dias_da_semana':
                $ini = (object)[
                    'hm' => $data["hora_inicial"],
                    'h' => (int)substr($data["hora_inicial"], 0, 2),
                    'm' => (int)substr($data["hora_inicial"], 3, 2)
                ];
                $fim = (object)[
                    'hm' => $data["hora_final"],
                    'h' => (int)substr($data["hora_final"], 0, 2),
                    'm' => (int)substr($data["hora_final"], 3, 2)
                ];
                break;
            default:
                $data["hora_inicial"] = '00:00';
                $data["hora_final"] = '23:59';
                $ini = (object)[
                    'hm' => $data["hora_inicial"],
                    'h' => (int)substr($data["hora_inicial"], 0, 2),
                    'm' => (int)substr($data["hora_inicial"], 3, 2)
                ];
                $fim = (object)[
                    'hm' => $data["hora_final"],
                    'h' => (int)substr($data["hora_final"], 0, 2),
                    'm' => (int)substr($data["hora_final"], 3, 2)
                ];
                break;
        }
        $intervalo['valor'] = (object)[
            'inicio' => $ini,
            'final' => $fim,
        ];

        $this->intervalo = (object)$intervalo;
        $this->time_interval = 'P1D';

//        dd($this->intervalo);
        //Variações a serem consideradas
//        $this->not_range = Base::$_NOT_RANGE_;
//        $this->range_indicadores = ReportController::$RangeMinMax;
        $this->range_indicadores = Base::$_RANGE_MINIMAX_;
        $Indicadores = Base::$_INDICADORES_;

        // Definição das datas de repetição do REPORT --------------------------------------
        if ($this->debug == 1) print_r("<br>");
        if ($this->debug == 1) print_r('$this->intervalo->resolucao = ' . $this->intervalo->resolucao . "<br>");
        if ($this->debug == 1) print_r('$this->intervalo->valor->inicio->hm = ' . $this->intervalo->valor->inicio->hm . "<br>");
        if ($this->debug == 1) print_r('$this->intervalo->valor->final->hm = ' . $this->intervalo->valor->final->hm . "<br>");

        /* ===========================================================*/
        /* ========================CONSTRUTOR=========================*/
        /* ===========================================================*/

        /* ===========================================================*/
        /* ============================RUN============================*/
        /* ===========================================================*/
        $retorno = 0;
        if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");
        if ($this->debug == 1) print_r("INÍCIO DO REPORT ----------------------------------------------<br>");
        if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");
        if ($this->debug == 1) print_r('data_agora = ' . $this->data_agora->format('d/m/Y H:i') . "<br>");
        if ($this->debug == 1) print_r("data_execucao = " . $this->data_execucao->format('d/m/Y H:i') . "<br>");
        if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");
//        exit;

        //Setando o Range de data (dia) inicial e final do relatório será agendado
        /* ===========================================================*/
        /* ============================setRangeData============================*/
        /* ===========================================================*/

        switch ($this->repeticao) {
            case 'periodo':

                // $this->range_data_inicial é a data (dia) de início do relatório
                $this->range_data_inicial = DateTime::createFromFormat('d-m-Y', $data['data_inicial']);
                $this->range_data_inicial->setTime($this->intervalo->valor->inicio->h, $this->intervalo->valor->inicio->m);

                //Se a hora de inicio for maior que a hora de fim,
                // isso quer dizer que a hora de início se refere ao dia anterior
                if (strtotime($this->intervalo->valor->inicio->hm) > strtotime($this->intervalo->valor->final->hm)) {
                    $this->range_data_inicial->sub(new DateInterval('P1D'));
                }

                // Geração da data (dia) de final do relatório
                $this->range_data_final = DateTime::createFromFormat('d-m-Y', $data['data_final']);
                $this->range_data_final->setTime($this->intervalo->valor->final->h, $this->intervalo->valor->final->m);

                break;
            case 'detalhado':

                // $this->range_data_inicial é a data (dia) de início do relatório
                $this->range_data_inicial = $this->data_execucao;
                $this->range_data_inicial->setTime($this->intervalo->valor->inicio->h, $this->intervalo->valor->inicio->m);

                // Geração da data (dia) de início do relatório (dia anterior)
                $this->range_data_final = clone $this->data_execucao;
                $this->range_data_final->setTime($this->intervalo->valor->final->h, $this->intervalo->valor->final->m);

                break;
            case 'diario':
                // $this->range_data_inicial é a data (dia) de início do relatório
                $this->range_data_inicial = DateTime::createFromFormat('d-m-Y', $data['data_inicial']);
                $this->range_data_inicial->setTime($this->intervalo->valor->inicio->h, $this->intervalo->valor->inicio->m);

                //Se a hora de inicio for maior que a hora de fim,
                // isso quer dizer que a hora de início se refere ao dia anterior
                if (strtotime($this->intervalo->valor->inicio->hm) > strtotime($this->intervalo->valor->final->hm)) {
                    $this->range_data_inicial->sub(new DateInterval('P1D'));
                }

                // Geração da data (dia) de início do relatório (dia anterior)
                $this->range_data_final = DateTime::createFromFormat('d-m-Y', $data['data_final']);
                $this->range_data_final->setTime($this->intervalo->valor->final->h, $this->intervalo->valor->final->m);

                break;
            case 'hora':
                $this->graph_options['category_field'] = 'hour';
                // $this->range_data_inicial é a data (dia) de início do relatório
                $this->range_data_inicial = DateTime::createFromFormat('d-m-Y', $data['data_inicial']);
                $this->range_data_inicial->setTime($this->intervalo->valor->inicio->h, $this->intervalo->valor->inicio->m);

                //Se a hora de inicio for maior que a hora de fim,
                // isso quer dizer que a hora de início se refere ao dia anterior
                if (strtotime($this->intervalo->valor->inicio->hm) > strtotime($this->intervalo->valor->final->hm)) {
                    $this->range_data_inicial->sub(new DateInterval('P1D'));
                }

                // Geração da data (dia) de início do relatório (dia anterior)
                $this->range_data_final = DateTime::createFromFormat('d-m-Y', $data['data_final']);
                $this->range_data_final->setTime($this->intervalo->valor->final->h, $this->intervalo->valor->final->m);

                break;
            case 'semanal':
                $this->graph_options['category_field'] = 'date-name';
                // $this->range_data_inicial é a data (dia) de início do relatório
                $this->range_data_inicial = DateTime::createFromFormat('d-m', '01-' . ($data["mes"] + 1));
                $this->range_data_inicial->setTime($this->intervalo->valor->inicio->h, $this->intervalo->valor->inicio->m);

                //Se a hora de inicio for maior que a hora de fim,
                // Geração da data (dia) de início do relatório (dia anterior)
                $this->range_data_final = clone $this->range_data_inicial;
                $this->range_data_final->modify('last day of this month');
                $this->range_data_final->setTime($this->intervalo->valor->final->h, $this->intervalo->valor->final->m);
                // isso quer dizer que a hora de início se refere ao dia anterior
                if (strtotime($this->intervalo->valor->inicio->hm) > strtotime($this->intervalo->valor->final->hm)) {
                    $this->range_data_inicial->sub(new DateInterval('P1D'));
                }
                break;
            case 'dias_da_semana':
                $this->graph_options['category_field'] = 'date-name';
                // $this->range_data_inicial é a data (dia) de início do relatório
                $this->range_data_inicial = DateTime::createFromFormat('d-m-Y', $data['data_inicial']);
                $this->range_data_inicial->setTime($this->intervalo->valor->inicio->h, $this->intervalo->valor->inicio->m);

                //Se a hora de inicio for maior que a hora de fim,
                // isso quer dizer que a hora de início se refere ao dia anterior
                if (strtotime($this->intervalo->valor->inicio->hm) > strtotime($this->intervalo->valor->final->hm)) {
                    $this->range_data_inicial->sub(new DateInterval('P1D'));
                }

                // Geração da data (dia) de início do relatório (dia anterior)
                $this->range_data_final = DateTime::createFromFormat('d-m-Y', $data['data_final']);
                $this->range_data_final->setTime($this->intervalo->valor->final->h, $this->intervalo->valor->final->m);

                break;
        }

        if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");
        if ($this->debug == 1) print_r('$this->range_data_inicial = ' . $this->range_data_inicial->format('d/m/Y H:i') . "<br>");
        if ($this->debug == 1) print_r('$this->range_data_final = ' . $this->range_data_final->format('d/m/Y H:i') . "<br>");
        //Próxima data em que o relatório será agendado
        if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");

        /* ===========================================================*/
        /* ============================setRangeData============================*/
        /* ===========================================================*/


        /* ===========================================================*/
        /* ============================setVetorDatas============================*/
        /* ===========================================================*/
        //Setando o Vetor de datas (dia) inicial e final do relatório será agendado
//        $this->setVetorDatas();
//        print_r($this->vetor_datas);exit;
        $this->vetor_datas = [];

        switch ($this->repeticao) {
            case 'periodo':
                //Tipo de gráfico por linhas
                if ($this->intervalo->resolucao == 'minuto') {
                    $resolucao = 'PT1M';
                } else {
                    $resolucao = 'PT1H';
                }
                $this->graph_options['graph'] = 'line';
                break;
            case 'detalhado':
                //Tipo de gráfico por barras
                $resolucao = 'PT1M';
                $this->graph_options['graph'] = 'line';
                break;
            case 'diario':
                //Tipo de gráfico por barras
                $resolucao = 'P1D';
                $this->graph_options['graph'] = 'bar';
                break;
            case 'hora' :
                //Tipo de gráfico por barras
                $resolucao = 'PT1H';
                $this->graph_options['graph'] = 'bar';
                break;
            case 'semanal' :
                //Tipo de gráfico por barras
                $resolucao = 'P7D';
                $this->graph_options['graph'] = 'bar';
                break;
            case 'dias_da_semana' :
                //Tipo de gráfico por barras
                $resolucao = 'P1D';
                $this->graph_options['graph'] = 'bar';
                break;
        }

        if ($this->repeticao != 'semanal') {

            $daterange = new DatePeriod($this->range_data_inicial, new DateInterval($resolucao), $this->range_data_final);
            $ix = 0;
            //for ($cont = clone $this->range_data_inicial; $cont <= $this->range_data_final; $cont->add(new DateInterval($resolucao))) {
            foreach($daterange as $cont){


                $fim = NULL;
                $valores = NULL;

                //inicial
                $inicio['data'] = $cont->format('Y-m-d H:i');
                $inicio['timestamp'] = $cont->getTimestamp();
                //final
                $cont_fim = clone $cont;

                switch ($this->repeticao) {
                    case 'detalhado':
                        //se a hora de inicio for maior que a hora fim, isso significa que e periodo noturno
                        //SE FOR MINUTO A MINUTO, NAO HA INTERVALO
                        if ($this->intervalo->resolucao != 'minuto') {
                            if ($this->intervalo->valor->inicio->h > $this->intervalo->valor->final->h) {
                                $cont_fim->add(new DateInterval('P1D'));
                            }
                            $cont_fim->add(new DateInterval($resolucao));
                        }
                        break;
                    case 'periodo':
                        //final
                        $cont_fim->add(new DateInterval($resolucao));
                        if ($this->intervalo->valor->inicio->h > $this->intervalo->valor->final->h) {
                            $cont_fim->add(new DateInterval($resolucao));
                        }
                        //se a hora de inicio for maior que a hora fim, isso significa que e periodo noturno
                        //SE FOR MINUTO A MINUTO, NAO HA INTERVALO
                        break;
                    case 'diario':
                        //final
                        $cont_fim->setTime($this->intervalo->valor->final->h, $this->intervalo->valor->final->m);
                        if ($this->intervalo->valor->inicio->h > $this->intervalo->valor->final->h) {
                            $cont_fim->add(new DateInterval('P1D'));
                        }
                        //se a hora de inicio for maior que a hora fim, isso significa que e periodo noturno
                        //SE FOR MINUTO A MINUTO, NAO HA INTERVALO
                        break;
                    case 'hora':
                        //final
                        $cont_fim->add(new DateInterval($resolucao));
                        if ($this->intervalo->valor->inicio->h > $this->intervalo->valor->final->h) {
                            $cont_fim->add(new DateInterval($resolucao));
                        }
                        //se a hora de inicio for maior que a hora fim, isso significa que e periodo noturno
                        //SE FOR MINUTO A MINUTO, NAO HA INTERVALO
                        break;
                    case 'dias_da_semana':
                        //final
                        $cont_fim->setTime($this->intervalo->valor->final->h, $this->intervalo->valor->final->m);
                        if ($this->intervalo->valor->inicio->h > $this->intervalo->valor->final->h) {
                            $cont_fim->add(new DateInterval('P1D'));
                        }
                        //se a hora de inicio for maior que a hora fim, isso significa que e periodo noturno
                        //SE FOR MINUTO A MINUTO, NAO HA INTERVALO
                        break;
                }

                $fim['data'] = $cont_fim->format('Y-m-d H:i');
                $fim['timestamp'] = $cont_fim->getTimestamp();

                for ($i = 0; $i < count($this->base); $i++) {
                    $valores[$i]['base'] = $this->base[$i];
                    $valores[$i]['valor'] = 0;
                    $valores[$i]['cont'] = 0;
                }

                $var = [
                    'inicio' => (object)$inicio,
                    'fim' => (object)$fim,
                    'valores' => $valores,
                ];
                $this->vetor_datas[] = $var;
            }
        } else {
            $interval = new DateInterval('P1D');
            $dateRange = new DatePeriod($this->range_data_inicial, $interval, $this->range_data_final);

            $weekNumber = 1;
            $weeks = array();
            foreach ($dateRange as $date) {
                $weeks[$weekNumber][] = $date;
                if ($date->format('w') == 6) {
                    $weekNumber++;
                }
            }
            foreach ($weeks as $week) {
                $n = count($week) - 1;
                $valores = NULL;

                for ($i = 0; $i < count($this->base); $i++) {
                    $valores[$i]['base'] = $this->base[$i];
                    $valores[$i]['valor'] = 0;
                    $valores[$i]['cont'] = 0;
                }

                $week[$n]->setTime($this->intervalo->valor->final->h, $this->intervalo->valor->final->m);
                $inicio = [
                    'data' => $week[0]->format('Y-m-d H:i'),
                    'timestamp' => $week[0]->getTimestamp()
                ];
                $fim = [
                    'data' => $week[$n]->format('Y-m-d H:i'),
                    'timestamp' => $week[$n]->getTimestamp()
                ];
                $var = [
                    'inicio' => (object)$inicio,
                    'fim' => (object)$fim,
                    'valores' => $valores,
                ];
                $this->vetor_datas[] = $var;
            }
        }

//        print_r($this->vetor_datas);exit;
        /* ===========================================================*/
        /* ============================setVetorDatas============================*/
        /* ===========================================================*/


        //Fazer busca no banco de dados dos dados desse range
        $the_query = DB::table('sensores_log')->where('post_id', $this->Report['Sensor']->post_id)->whereBetween('created', array($this->range_data_inicial->format('Y-m-d H:i:00'), $this->range_data_final->format('Y-m-d H:i:00')))->orderBy('created', 'ASC');
        $total_rows = $the_query->count();

        if ($this->debug == 1) print_r('$total_rows = ' . $total_rows . "<br>");
        if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");
        if ($total_rows > 0) {
//            return ($this->Report);
            $this->contagem($total_rows, $the_query);

//            print_r($this->vetor_datas);
            if ($this->repeticao == 'dias_da_semana') {
                foreach ($this->vetor_datas as $ivet => $data) {
                    $dow = date("w", $data['fim']->timestamp);
                    $diasSemana[$dow][] = $data;
                }
//                print_r($diasSemana);
                foreach ($diasSemana as $ivet => $data) {
                    for ($i = 0; $i < count($this->base); $i++) {

                        $_BASE_ATUAL_ = $this->base[$i];
                        $novoValor = 0;
                        $novoCont = 0;
                        //somar
                        foreach ($data as $id => $dt) {
                            $indicador = $_BASE_ATUAL_;
                            $valor = $dt['valores'][$i]['valor'];

                            //Verificando os máx/mín
                            if (!in_array($indicador, Base::$_NOT_RANGE_)) {
                                $min = $this->range_indicadores['default']['min'];
                                $max = $this->range_indicadores['default']['max'];
                            } else {
                                $min = $this->range_indicadores[$indicador]['min'];
                                $max = $this->range_indicadores[$indicador]['max'];
                            }
//                            echo 'indicador: ' . $indicador . '; min: ' . $min . '; max: ' . $max . '; valor: ' . $valor . '<br>';

                            //aqui vão os valores que estão dentro do range, se estiverem fora não irão ser somados,
                            if (($valor > $min) && ($valor < $max)) {
                                if (!in_array($indicador, $this->not_mlog)) {
                                    $novoValor += pow(10, ($valor / 10));
                                    $novoCont++;
                                } else {
                                    $novoValor += $valor;
                                    $novoCont++;
                                }
                            }
                        }

                        $_VALOR_ = $novoValor;
                        $_CONT_ = $novoCont;
//                        print_r("valor = ".$_VALOR_."; cont = ".$_CONT_."<br>");

                        if ($_CONT_ > 0) {
                            if (!in_array($_BASE_ATUAL_, $this->not_mlog)) {
                                $novoValor = round(log10($_VALOR_ / $_CONT_) * 10, 2);
                            } else {
                                $novoValor = round(($_VALOR_ / $_CONT_), 2);
                            }
                        }
                        $diasSemana[$ivet] = $data[0];
                        $diasSemana[$ivet]['valores'][$i]['valor'] = $novoValor;
                        $diasSemana[$ivet]['valores'][$i]['cont'] = $_CONT_;
                    }
                }
//                print_r($diasSemana); exit;
                $this->vetor_datas = $diasSemana;
            } else if ($this->repeticao == 'hora') {
                $time_interval_pt1h = new DateInterval('PT1H');
                //criar um vetor só de horas
                $inicio = clone $this->range_data_final;
                $fim = clone $inicio;
                $inicio->setTime(0, 0);
                $daterange = new DatePeriod($inicio, $time_interval_pt1h, $fim);

//                print_r('inicio = ' . $inicio->format("Y-m-d H:i") ."<br>");
//                print_r('fim = ' . $fim->format("Y-m-d H:i") ."<br>");

                foreach ($daterange as $dt) {
                    $dt_end = clone $dt;
                    $dt_end->add($time_interval_pt1h);
                    $vetor_datas[] = [
                        'inicio' => (object)[
                            'data' => $dt->format("Y-m-d H:i"),
                            'timestamp' => $dt->getTimestamp()
                        ],
                        'fim' => (object)[
                            'data' => $dt_end->format("Y-m-d H:i"),
                            'timestamp' => $dt_end->getTimestamp()
                        ],
                        'valores' => [],
                    ];
                    $vetor_horas[] = (object)[
                        'inicio' => $dt->format("H:i"),
                        'inicio_h' => $dt->format("H"),
                        'inicio_m' => $dt->format("i"),
                        'fim' => $dt_end->format("H:i"),
                        'fim_h' => $dt_end->format("H"),
                        'fim_m' => $dt_end->format("i"),
                    ];
                }

                //varrer o vetor_datas e somar todo mundo com mesma hora
                foreach ($vetor_horas as $iv => $hora) {
                    for ($i = 0; $i < count($this->base); $i++) {
                        $_BASE_ATUAL_ = $this->base[$i];
                        $indicador = $_BASE_ATUAL_;
                        $novoValor = 0;
                        $novoCont = 0;
                        foreach ($this->vetor_datas as $ivet => $data) {

                            $inicio_t = new DateTime($data['inicio']->data);
                            $inicio_t->setTime($hora->inicio_h, $hora->inicio_m);
                            $it = $inicio_t->getTimestamp();

                            $fim_t = clone $inicio_t;
                            $fim_t->add($time_interval_pt1h);
                            $ft = $fim_t->getTimestamp();

//                            echo '--ivet: ' . $ivet . '<br>';
//                            echo 'this->vetor_datas->inicio: ' . $data['inicio']->data . '; fim: ' . $data['fim']->data . '<br>';
//                            echo 'hora->inicio: ' . $inicio_t->format('Y-m-d H:i') . '; fim: ' . $fim_t->format('Y-m-d H:i') . '<br>';

                            if (($it <= $data['inicio']->timestamp) && ($ft >= $data['fim']->timestamp)) {
//                                echo '_____________________________________________________<br>';
//                                echo 'this->vetor_datas->inicio: ' . $data['inicio']->timestamp . '; fim: ' . $data['fim']->timestamp . '<br>';
//                                echo 'hora->inicio: ' . $it . '; fim: ' . $ft . '<br>';

                                $valor = $data['valores'][$i]['valor'];

                                //Verificando os máx/mín
                                if (!in_array($indicador, Base::$_NOT_RANGE_)) {
                                    $min = $this->range_indicadores['default']['min'];
                                    $max = $this->range_indicadores['default']['max'];
                                } else {
                                    $min = $this->range_indicadores[$indicador]['min'];
                                    $max = $this->range_indicadores[$indicador]['max'];
                                }

                                //aqui vão os valores que estão dentro do range, se estiverem fora não irão ser somados,
                                if (($valor > $min) && ($valor < $max)) {
                                    if (!in_array($indicador, $this->not_mlog)) {
                                        $novoValor += pow(10, ($valor / 10));
                                        $novoCont++;
                                    } else {
                                        $novoValor += $valor;
                                        $novoCont++;
                                    }
                                }
//                                echo 'indicador: ' . $indicador . '; min: ' . $min . '; max: ' . $max . '; valor: ' . $valor . '; cont: '.$novoCont.'<br>';
//                                echo '_____________________________________________________<br>';
                            }
                        }

                        $_VALOR_ = $novoValor;
                        $_CONT_ = $novoCont;

//                        print_r("_VALOR_ = ".$_VALOR_."; _CONT_ = ".$_CONT_."<br>");

                        //fazer a média
                        if ($_CONT_ > 0) {
                            if (!in_array($_BASE_ATUAL_, $this->not_mlog)) {
                                $novoValor = round(log10($_VALOR_ / $_CONT_) * 10, 2);
                            } else {
                                $novoValor = round(($_VALOR_ / $_CONT_), 2);
                            }
                        }

//                        print_r("novoValor = ".$novoValor."; cont = ".$_CONT_."<br>");

                        $vetor_datas[$iv]['valores'][$i]['base'] = $indicador;
                        $vetor_datas[$iv]['valores'][$i]['valor'] = $novoValor;
                        $vetor_datas[$iv]['valores'][$i]['cont'] = $_CONT_;
                    }
                }
                $this->vetor_datas = $vetor_datas;
            }

//            PRINT_R($this->vetor_datas);EXIT;

            $JSONreport['data'] = $this->montaRetorno();
            $JSONreport['minimax'] = $this->calculaMiniMax(); //contem minimo, maximo (com suas posioes) e a média,
            $JSONreport['graph_options'] = $this->graph_options;
            $JSONreport['tipo'] = 'data';
            $JSONreport['dados_report'] = $this->get_dados_report('manual');
            $retorno = [
                'status' => 1,
                'response' => $JSONreport];

        } else {
            $retorno = [
                'status' => 0,
                'response' => 'Nenhum registro, utilize o filtro para buscar outros períodos.'];
        }
        return json_encode($retorno);
    }

    function generateReport()
    {
        //Ler a data de execução
        if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");
        if ($this->debug == 1) print_r('data_agora = ' . $this->data_agora->format('d/m/Y H:i') . "<br>");
        if ($this->debug == 1) print_r("data_primeira_execucao = " . $this->data_execucao->format('d/m/Y H:i') . "<br>");

        //Teste se a data da primeira execução é menor que agora,
        // Se sim: iremos disparar a rotina de geração de relatório
        // Senão: significa que ainda não devemos gerar o relatório

        if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");
        if ($this->debug == 1) print_r("INÍCIO DO REPORT ----------------------------------------------<br>");
        if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");

        // base contém o número de indicadores do report
        $this->base = json_decode($this->Report['Post']->content);

        //Setando o Range de data (dia) inicial e final do relatório será agendado
        $this->setRangeData();

        //Setando o Vetor de datas (dia) inicial e final do relatório será agendado
        $this->setVetorDatas();
//            print_r($this->vetor_datas);exit;

        //Fazer busca no banco de dados dos dados desse range
        $the_query = DB::table('sensores_log')->where('post_id', $this->Report['Sensor']->post_id)->whereBetween('created', array($this->range_data_inicial->format('Y-m-d H:i:00'), $this->range_data_final->format('Y-m-d H:i:00')))->orderBy('created', 'ASC');
        $total_rows = $the_query->count();

        if ($this->debug == 1) print_r('$total_rows = ' . $total_rows . "<br>");
        if ($this->debug == 1) print_r("---------------------------------------------------------------<br>");


//            print_r($this->vetor_datas);exit;
        if ($total_rows > 0) {
//            return ($this->Report);

//            exit;
            $this->contagem($total_rows, $the_query);
            $JSONreport['tipo'] = 'data';
            $JSONreport['dados_report'] = [
                'titulo' => $this->Report['Post']->title,
                'sensor_nome' => $this->Report['Sensor']->title,
                'indicadores' => $this->Report['Post']->content,
                'range_inicial' => $this->range_data_inicial->format('d/m/Y'),
                'range_final' => $this->range_data_final->format('d/m/Y'),
                'tipo' => ucfirst($this->intervalo->tipo),
                'intervalo_inicial' => $this->intervalo->valor->inicio->hm,
                'intervalo_final' => $this->intervalo->valor->final->hm,
            ];

            $JSONreport['data'] = $this->montaRetorno();
            $JSONreport['minimax'] = $this->calculaMiniMax(); //contem minimo, maximo (com suas posioes) e a média,

            // guardar no banco
            //NOME DO RELATORIO, SENSOR, INDICADORES, PERÍODO, TIPO, INTERVALO, MÁX-MIN-MÉD, DADOS


            $report = [
                'postmeta_id' => $this->Report['Postmeta']->postmeta_id,
                'meta_key' => $this->data_agora->format('m-d-Y H:i'),
                'meta_value' => json_encode($JSONreport)
            ];

            $Reports = Reports::update_or_insert($report);
//            print_r($Reports);
//            exit;
            return ($JSONreport);

        } else {
            return 0;
        }


    }
}

