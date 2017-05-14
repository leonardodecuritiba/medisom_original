<?php

class EmailController extends BaseController
{

    static public function send_email_reminder_report($email_data)
    {
        $vars = $email_data['vars'];
        $user_name = $email_data['user_name'];
        $subject = $email_data['subject'];
        $emails = $email_data['emails'];
        EmailController::set_email('reports');

        Mail::send('emails.user.report', $vars, function ($message) use ($user_name, $subject, $emails) {
            $message->to($emails);
            $message->subject($subject);
        });
        $msg = "*** email enviado para: " . json_encode($emails) . "!<br>";
        echo $msg;
        Log::info($msg);
        return 1;
    }

    static public function set_email($type)
    {
        switch ($type) {
            case 'reports':
            case 'alerts':
                $name = Option::get('text_smtp_' . $type . '_usuario');
                $email = Option::get('text_smtp_' . $type . '_email');
                $pwd = Option::get('text_smtp_' . $type . '_senha');
                Config::set('mail.username', $email);
                Config::set('mail.password', $pwd);
                Config::set('mail.from', ['address' => $email, 'name' => $name]);
                break;
        }
        return;
//        return $backup;
    }

    static public function send_email_alert($email_data)
    {
        $vars = $email_data['vars'];
        $user_name = $email_data['user_name'];
        $subject = $email_data['subject'];
        $emails = $email_data['emails'];
        EmailController::set_email('alerts');

        Mail::send('emails.user.notify', $vars, function ($message) use ($user_name, $subject, $emails) {
            $message->to($emails);
            $message->subject($subject);
        });
        $msg = "*** email enviado para: " . json_encode($emails) . "!<br>";
        echo $msg;
        Log::info($msg);
        return 1;
    }

    static public function send_email_user_register($email_data)
    {
        $vars = $email_data['vars'];
        $user = $email_data['user'];

        Mail::send('emails.user.register', $vars, function ($message) use ($user) {
            $message->to($user->email, $user->name)->subject(Option::get('text_emails_user_register'));
        });
        return 1;
    }

    static public function send_email_user_share($email_data)
    {
        $vars = $email_data['vars'];
        $user = $email_data['user'];
        $image = $email_data['image'];

        Mail::send('emails.user.compartilhar', $vars, function ($message) use ($user, $image) {
            $message->to($user->email, $user->name)->subject(Option::get('text_emails_user_compartilhar'));
            $message->attach('public/uploads/share/' . $image);
        });
        return 1;
    }

    static public function send_email_user_share_mail($email_data)
    {
        $vars = $email_data['vars'];
        $image = $email_data['image'];
        $mail = $email_data['mail'];

        Mail::send('emails.user.compartilhar-por-email', $vars, function ($message) use ($mail, $image) {
            $message->to($mail)->subject(Option::get('text_emails_user_compartilhar-por-email'));
            $message->attach('public/uploads/share/' . $image);
        });
        return 1;
    }

    static public function send_email_contact($email_data)
    {
        $vars = $email_data;
        Mail::send('emails.user.contato', $vars, function ($message) {
            $message->to(Option::get('text_contato_email'), Option::get('text_smtp_nome'))->subject(Option::get('text_emails_user_contato'));
        });
        return 1;
    }

    static public function send_email_estimate($email_data)
    {
        $vars = $email_data;
        Mail::send('emails.user.orcamento', $vars, function ($message) {
            $message->to(Option::get('text_smtp_email'), Option::get('text_smtp_nome'))->subject(Option::get('text_emails_user_orcamento'));
        });
        return 1;
    }

    static public function send_email_reminder_password($email_data)
    {

        $email_data['url_site'] = URL::route('admin.dashboard');
        $email = $email_data['email'];
        $subject = $email_data['titulo'];

        Mail::send('emails.auth.reminder', $email_data, function ($message) use ($subject, $email) {
            $message->to($email);
//            $message->to($user_email, $user_name);
            $message->subject($subject);
        });

        return 1;

    }

}

