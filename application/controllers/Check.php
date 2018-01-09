<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Check extends CI_Controller {

    function __construct() {
        parent::__construct();

    }

    public function index() {


        $value = $this->input->get('fieldValue');
        $field = $this->input->get('fieldId');
        $tbl=$this->input->get('tbl');
        $update_id=$this->input->get('update_id');
        $res[0] = $field;
        if($update_id!='undefined')
        {
            $data= generic_select($tbl,array('id!='=>$update_id,$field=>$value));
            if(is_array($data)||is_object($data))
            {
                $res[1] = false;
            }else
            {
                $res[1] = true;
            }
        }else if ($this->generic_model->selectwhere($tbl, $field, $value)==FALSE) {
            $res[1] = true;
        } else {
            $res[1] = false;
        }
        echo json_encode($res);

    }

    function emp_contract()
    {

        $con=array(
            'expire_date'=>date("Y-m-d")
        );
        if(!empty($_GET['emp'])&&$_GET['emp']=='all')
            $con=array(
                "expire_date <="=>date("Y-m-d")
            );
        if(!empty($_GET['emp'])&&$_GET['emp']=='next-week')
        {
            $date = strtotime("+7 days", strtotime(date("Y-m-d")));
            $con=array(
                "expire_date <="=>date("Y-m-d", $date)
            );
        }
        $data=join_select_Table_array('con.*,emp.email,emp.name,des.title as designation,emp.doa,emp.cnic',"emp_contract_view con",
            array(
                array(
                    'tbl'=>'con',
                    'field'=>'emp_id',
                    'tbl2'=>'employees emp',
                    'field2'=>'id',
                    'type'=>null,
                ),array(
                'tbl'=>'emp',
                'field'=>'department',
                'tbl2'=>'departments dept',
                'field2'=>'id',
                'type'=>'left'
            )
            ,array(
                'tbl'=>'emp',
                'field'=>'designation',
                'tbl2'=>'designations des',
                'field2'=>'id',
                'type'=>null
            ),array(
                'tbl'=>'con',
                'field'=>'emp_id',
                'tbl2'=>'emp_job_type jt',
                'field2'=>'emp_id',
                'type'=>null
            )
            ),$con+array('job_status'=>'Active','jt.job_type !='=>'Permanent'),null,"con.expire_date"
            );
        if(is_array($data)||is_object($data))
        {
            $html="<HTML><head>
            <title>Employees Contract Expire</title>
            </head>
            <body>
            <h3>Employee's Contract Details</h3>
            <table style='width: 100%; text-align: left' cellspacing='0' cellpadding='3' border='1'>
            <tr>
            <th>Sr.</th>
            <th>Employee Name</th>
            <th>Designation</th>
            <th>CNIC</th>
            <th>Appointment Date</th>
            <th>Contract Period</th>
            <th>Expire Date</th></tr>
            ";
            $c=1;
            foreach($data as $emp)
            {
                $html.="
                <tr>
                <td>$c</td>
                <td>$emp->name</td>
                <td>$emp->designation</td>
                <td>$emp->cnic</td>
                <td>$emp->doa</td>
                <td>$emp->duration</td>
                <td>$emp->expire_date</td>
                </tr>
                ";
                $c++;
            }
            $html.="</body></html>";
            $this->load->library('email');
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

            $this->email->initialize($config);
            $this->email->clear();
            $this->email->to("sabtain.khan@kfueit.edu.pk");
            $this->email->from('mis@kfueit.edu.pk', 'KFUEIT OFFICE OF THE REGISTRAR');
            $this->email->subject("Expired contract");
            $this->email->message(
                $html
            );
            if($this->email->send())
            {
                echo "<script>window.close();</script>";
            }
        }
        echo "<script>window.close();</script>";
    }

    function daily_task(){

        $holidays=getSingle('payroll_setting','holidays','id',1);
        $t=explode(',',$holidays);
        $holidays="'".implode("','",$t)."'";

        $department=join_select_Table_array('*','departments',null);
        $messages=array();
        foreach($department as $dept)
        {
            $hod=generic_select_row('employees',array('department'=>$dept->id,'is_hod'=>1,'job_status'=>'Active'));
            if(is_array($hod)||is_object($hod))
            {
                $date=date('Y-m-d', strtotime(date('Y-m-d') .' -1 day'));
                $whereClass='';
                $whereClass.=" AND date(CHECKTIME) between '".$date."' AND '".$date."'";
                //$whereClass.=" AND date(CHECKTIME) between '2016-12-28' AND '2016-12-28'";
                $whereClass.=" AND dpt.id = ".$dept->id;
                $whereClass.=" AND des.bps <= 16";
                $overtime=getAttendance($whereClass,$holidays);
                $msg='';
                //var_dump($overtime);
                if(is_array($overtime)||is_object($overtime))
                foreach($overtime as $ot)
                {
                    if($ot['OverTIME']>1.5)
                    {
                        $msg.=$ot['NAME'].' '.$ot['DESIGNATION'].' '.$ot['OverTIME'].'hrs %0a';
                    }
                }
                if(!empty($msg)&&!empty($hod->mobile_no))
                {
                    $msg='Overtime Details ('.$date.') %0a'.$msg;
                    $messages[]=array('number'=>validateNumberSMS($hod->mobile_no),'email'=>$hod->email,'message'=>$msg);
                }
            }
        }

        if(count($messages)>0)
        {
            foreach($messages as $m)
            {
                $type = "xml";
                $id   = "kfueit";
                $pass = "khawaja45";
                $lang = "English";
                $mask = "KFUEIT";

                $to = $m['number'];
                $message = $m['message'];
                $message = urlencode($message);

                $data = "id=".$id."&pass=".$pass."&msg=".$message."&to=".$to."&lang=".$lang."&mask=".$mask."&type=".$type;

                $ch = curl_init('http://www.sms4connect.com/api/sendsms.php/sendsms/url');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
               // $result = curl_exec($ch);
                curl_close($ch);
                if(!empty($m['email']))
                {
                    send_email_custom('mis@kfueit.edu.pk','KFUEIT IT Department',$m['email'],'Overtime Details',$m['message']);
                }

            }
        }

    }

    public function getProgress()
    {
        echo json_encode($this->session->userdata('progress'));
    }

    public function sendMail(){
        if($this->input->post())
        {
            $this->load->library('email');
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

            $this->email->initialize($config);

            $this->email->clear(true);
            $this->email->to($this->input->post('to'));
            $this->email->from($this->input->post('from'));
            $this->email->subject($this->input->post('subject'));
            $this->email->message(
                $this->input->post('body')
            );
            log_message('error', "sending mail to {$this->input->post('to')}");
            if($this->email->send())
            {
                log_message('error', "mail sent to {$this->input->post('to')}");
                echo true;
                return;
            }else{
                log_message('error', "mail sending fail to {$this->input->post('to')}");
                echo false;
                return;
            }

        }
    }

    function process_1()
    {
        $this->load->view('test/process');
    }
    function process()
    {
        session_write_close();
        is_login();
        $total = 20;

        // The array for storing the progress.
        $arr_content = array();

        // Loop through process
        for ($i = 1; $i <= $total; $i++) {
            // Calculate the percentation
            $percent = intval($i / $total * 100);

            // Put the progress percentage and message to array.
            $arr_content['percent'] = $percent;
            $arr_content['message'] = $i . " row(s) processed.";

            // Write the progress into file and serialize the PHP array into JSON format.
            // The file name is the session id.
            file_put_contents(FCPATH."uploads/temp/" . session_id() . ".txt", json_encode($arr_content));

            // Sleep one second so we can see the delay
            sleep(1);
        }
        if($this->input->post())
        {

        }else
        {

        }



    }

    function checker()
    {
        header('Content-Type: application/json');

        //  Prepare the file name from the query string.
        // Don't use session_start here. Otherwise this file will be only executed after the process.php execution is done.
        $file = str_replace(".", "", $_GET['file']);
        $file = FCPATH."uploads/temp/" . $file . ".txt";

        // Make sure the file is exist.
        if (file_exists($file)) {
            // Get the content and echo it.
            $text = file_get_contents($file);
            echo $text;

            // Convert to JSON to read the status.
            $obj = json_decode($text);
            // If the process is finished, delete the file.
            if ($obj->percent == 100) {
                unlink($file);
            }
        } else {
            echo json_encode(array("percent" => null, "message" => null));
        }
    }

}
