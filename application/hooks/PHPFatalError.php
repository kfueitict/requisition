<?php

class PHPFatalError
{
    public function setHandler() {
        set_error_handler("customError");
    }
    public function _sendEmail($msg){
        $c=&get_instance();
        $c->load->library('email');
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

        $c->email->initialize($config);

        $c->email->clear(true);
        $c->email->to(DEVELOPER_EMAIL);
        $c->email->from('KFUEIT-MIS');
        $c->email->subject('A PHP Error was encountered On MIS');
        $c->email->message(
           $msg
        );

        if(!$c->email->send())
        {
            log_message('error', "mail sending fail to {$c->input->post('to')}");
        }else
        {
            exit;
        }
    }


}
function customError($errno, $errstr) {
    $handler= new PHPFatalError();
    $msg= "<b>Error:</b> [$errno] $errstr<br>";
    $msg.= "Ending Script";
    
    $handler->_sendEmail($msg);

}

function notify(){

    if (($error = error_get_last())) {

        ob_start();
        echo "<pre>";
        var_dump($error);
        echo "</pre>";
        $message = ob_get_clean();
        var_dump($message);exit;
        $this->_sendEmail($message);
    }
}