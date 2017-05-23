<?php


class RunJobsController extends BaseController
{

    //localhost/workana/medisom/verify-reports-run

    static public function run_alert_check($debug = 0)
    {
        $Alerts = Alerts::where('status', '=', 1)->get();

        $AlertController = new AlertController($debug);
        $AlertController->run($Alerts);
        print_r("<br>***** FIM DA CHECAGEM DOS ALERTAS ******<br>");
        return;
    }

    static public function run_report_check($debug = 0)
    {
        //localhost/workana/medisom/verify-reports-run
        set_time_limit(360);
//        $ids_report = Reportmeta::ativos()->lists('reportmeta_id');
        $ids_report = Post::where('type', '=', 'report')->where('status', '=', 'publish')->lists('post_id');
        $data_agora = \Carbon\Carbon::now();
        $time_agora = $data_agora->timestamp;

        if ($debug > 0) print_r("@@@@@@@ CHECAGEM EM DEBUG NÍVEL (" . $debug . ") @@@@@@@<br>");
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

    static public function NEWrun_report_check()
    {
//        $report = Reportmeta::find(1);
//        print_r(json_encode($report));exit;
        set_time_limit(360);
        $ids_report = Reportmeta::ativos()->lists('reportmeta_id');

        $data_agora = \Carbon\Carbon::now();
        $time_agora = $data_agora->timestamp;

        print_r("***** INÍCIO DA CHECAGEM DOS REPORTS (" . $data_agora->format('H:i d/m/Y') . ") ******<br><br>");
        print_r('REPORTS (ID) = ');
        print_r(json_encode($ids_report));
        print_r("<br>___________________________________________________________<br>");
        print_r("___________________________________________________________<br>");

        exit;
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

    static public function NEWrun_alert_check()
    {
        $debug = 0;
        $alerts = Alerts::where('status', '=', 1)->get();
        $AlertController = new AlertController($debug);
        $AlertController->run($alerts);
        print_r("<br>***** FIM DA CHECAGEM DOS ALERTAS ******<br>");
        return;
    }

    static public function run_report_manual()
    {
        $debug = 0;
        set_time_limit(180);
        $ReportController = new ReportController(0, $debug, 'manual');
        return $ReportController->fake_report();
    }
}
