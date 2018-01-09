<?php
class MY_Log extends CI_Log
{

    function MY_Log(){

        parent::__construct();
    }

    function write_log($level = 'error', $msg, $php_error = FALSE){

        $result = parent::write_log($level, $msg, $php_error);
        if ($result == TRUE && strtoupper($level) == 'ERROR') {

            $this->CI =& get_instance();
            $message = "An error occurred: <br>";
            $message .= $level.' - '.date($this->_date_fmt). ' --> '.$msg."<br>";
            $message .= 'URL ---> '.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']."<br>";
            $message .= 'IP ---> '.$_SERVER['REMOTE_ADDR']."<br>";
            $message .= 'HTTP_USER_AGENT ---> '.$_SERVER['HTTP_USER_AGENT']."<br>";
            $message .= 'HTTP_REFERER ---> '.$_SERVER['HTTP_REFERER']."<br>";
            $message .= 'USER ---> '.@$this->CI->session->userdata('username')."<br>";

            $this->CI->load->library('email');
            $config = Array(
                'protocol' => "smtp",
                'smtp_host' => "mail.kfueit.edu.pk",
                'smtp_port' => 25,
                'smtp_user' => "finance.department",
                'smtp_pass' => "pass@1234abc",
                'mailtype' => "html",
                'charset' => "iso-8859-1",
                'wordwrap' => TRUE
            );
            $this->CI->email->initialize($config);
            $from_email="developer.notifier@kfueit.edu.pk";
            $to_email=DEVELOPER_EMAIL;
            $subject = 'An error has occurred '.APPLICATION;

            $this->CI->email->from($from_email, "KFUEIT");
            $this->CI->email->to($to_email);
            $this->CI->email->subject($subject);
            $this->CI->email->message($message);
            $this->CI->email->send();

        }

        return $result;

    }
}