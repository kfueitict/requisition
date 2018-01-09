<?php

/**
 * Created by PhpStorm.
 * User: HP_PC
 * Date: 5/15/2017
 * Time: 10:52 AM
 */
class AuditLog
{
    function log()
    {
        
        $CI =& get_instance();
        /*echo "<pre>";
        print_r($CI->router);
        echo  $CI->router->class;
        echo  '<br>';
        echo $CI->router->method;*/
        $data = array();
        $data['user_id'] = $CI->session->userdata('username');

        // Next up, we want to know what page we're on, use the router class
        $section = $CI->router->class;
        $data['section'] = $section;
        $data['action'] = $CI->router->method;

        // Lastly, we need to know when this is happening
        $data['time_string'] = time();

        // We don't need it, but we'll log the URI just in case
        $data['url_string'] = $_SERVER['REQUEST_URI'];
        if(!empty($_POST)&&$section!='login')
        {
            $data['data']=print_r($_POST,true);
        }
        if(!empty($data['user_id']))
        {
            insert_db('mis_audit_log',$data);
        }
    }
}