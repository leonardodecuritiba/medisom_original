<?php


class RunJobsController extends BaseController
{

    //localhost/workana/medisom/verify-reports-run
    static public function run_report_check()
    {
//        $report = Reportmeta::find(1);
//        print_r(json_encode($report));exit;
        $debug = 0;
        set_time_limit(360);
        $ids_report = Reportmeta::ativos()->lists('reportmeta_id');
        $data_agora = \Carbon\Carbon::now();
        $time_agora = $data_agora->timestamp;

        print_r("***** INÍCIO DA CHECAGEM DOS REPORTS (" . $data_agora->format('H:i d/m/Y') . ") ******<br><br>");
        print_r('REPORTS (ID) = ');
        print_r(json_encode($ids_report));
        print_r("<br>___________________________________________________________<br>");
        print_r("___________________________________________________________<br>");

        if ($debug > 0) {
            print_r("****** CHECAGEM EM TESTE ******<br>");
            print_r("___________________________________________________________<br><br>");
        }
//        $ids_report = [ 1,2,3,4,5,6,7,8,9,10 ];
//        $ids_report = [ 13, 14, 15, 16 ];
//        $ids_report = [ 13 ];
        $ids_report = [17, 18, 19, 20];
        $ids_report = [17];
        foreach ($ids_report as $report_id) {
            $report = Reportmeta::find($report_id);
            print_r("Name = " . $report->title . " (" . $report_id . ")<br>");
            print_r("Next Execution = " . $report->next_execution . "<br>");
            //ler data
            $time_report = strtotime($report->next_execution);
            //testar se já chegou o prazo de geração
            if ($time_report < $time_agora) {
                print_r("RODAR: " . $report->title . "<br>");
                $ReportController = new ReportController($report_id, $debug, 'agendado');

                //aqui vamos apenas guardar no banco
                //na primeira vez, guardar os dados do report no banco: contendo
                //Mandar um link com referência a essa tupla do banco para que possamos gerar um relatório pela primeira vez
                $flag_email_report = $ReportController->run('report'); //retorna o reports_id

                print_r("******* flag_email_report = " . $flag_email_report . "<br>");

//                exit;
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

    static public function run_report_manual()
    {
        set_time_limit(180);
        $debug = 0;
        $ReportController = new ReportController(0, $debug, 'manual');
        return $ReportController->fake_report();
    }

    static public function run_alert_check()
    {
        $alerts = Alerts::where('status', '=', 1)->get();
        $AlertController = new AlertController(0);
        $AlertController->run($alerts);
        print_r("<br>***** FIM DA CHECAGEM DOS ALERTAS ******<br>");
        return;
    }
}
