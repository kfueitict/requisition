<?php
function send_email_applicant($leave_req_id)
{
    $c= & get_instance();
    $c->load->library('email');
    $leave_request=generic_select_row('leave_req',array('id'=>$leave_req_id));
    $emp=getEmployee(array('emp.id'=>$leave_request->emp_id));
    $data['mail_body']=array(
        'Request Date'=>$leave_request->request_date,
        'Reason'=>$leave_request->reason,
        'Request Status'=>leave_request_status($leave_request->status),
    );
    if($leave_request->status==0){

            $data['message']="Your Requisition proceeded to Next Authority";
    }
    else if($leave_request->status==1)
    {
        $data['message']="The below Requisition has been recommanded by Manager/Head of Department.";
    }
    else if($leave_request->status==2){
        $data['message']="The below Requisition has been rejected.";
    }
    else if($leave_request->status==6){
        $data['message']="The below Requisition has been approved by Procurement.";
    }
    $data['applicant']="$emp->title $emp->name";


    $message=$c->load->view('email-templates/leaves/leave_request',$data,true);
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
    $c->email->from('hr@kfueit.edu.pk', 'PROCUREMENT KFUEIT');
    $c->email->to($emp->email);
    $c->email->subject('Requisition Notification');
    $c->email->message($message);

    if ( $c->email->send())
    {
        return 1;
    }else{
        return 0;
    }

}

function send_email_next_authority($leave_req_id)
{
    $c= & get_instance();
    $c->load->library('email');
    $leave_request=generic_select_row('leave_req',array('id'=>$leave_req_id));
    $emp=getEmployee(array('emp.id'=>$leave_request->emp_id));
    $leave_request_t=generic_select_row('leave_req_transactions',array('req_id'=>$leave_req_id,'proceeded'=>0));
    $next_auth=getEmployee(array('emp.id'=>$leave_request_t->next_step));
    $whereComplete = "where req_id =$leave_req_id and balance_qty > 0"; //Items Not Available in Store
    $data['leave_partial_approved_RFQ']=custom_query("select * from `mis_leave_req_body` $whereComplete",true);

    $data['mail_body']=array(
        'Employee No'=>$emp->emp_no,
        'Employee Name'=>$emp->title.' '.$emp->name,
        'Department'=>$emp->department,
        'Designation'=>$emp->designation,
        'Request Date'=>$leave_request->request_date,
        'Reason'=>$leave_request->reason,
        'Request Status'=>leave_request_status($leave_request->status),
    );
    $data['message']="The Requisition of the below employee is pending for approval";
    $data['applicant']="$next_auth->title $next_auth->name";

    $message=$c->load->view('email-templates/leaves/leave_request',$data,true);

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
    $c->email->from('hr@kfueit.edu.pk', 'PROCUREMENT KFUEIT');
    $c->email->to($next_auth->email);
    $c->email->subject('Requisition Notification');
    $c->email->message($message);

    if ( $c->email->send())
    {
        return 1;

    }else{
        return 0;
    }

}

function send_email_applicant_for_delivery($leave_req_id)
{
    $c= & get_instance();
    $c->load->library('email');
    $leave_request=generic_select_row('leave_req',array('id'=>$leave_req_id));
    $wherePartial = "where req_id =$leave_req_id and balance_qty >= 0"; //Items Available in Store
    $whereComplete = "where req_id =$leave_req_id and balance_qty > 0"; //Items Not Available in Store
    $data['leave_partial_approved']=custom_query("select * from `mis_leave_req_body` $wherePartial",true);
    $data['leave_partial_approved_RFQ']=custom_query("select * from `mis_leave_req_body` $whereComplete",true);
    $emp=getEmployee(array('emp.id'=>$leave_request->emp_id));
    $data['mail_body']=array(
        'Request Date'=>$leave_request->request_date,
        'Reason'=>$leave_request->reason,
        'Request Status'=>leave_request_status($leave_request->status),
    );
    if($leave_request->status==6){
        $data['message']="The below Requisition has been partial approved by Store.";
    }
    $data['applicant']="$emp->title $emp->name";


    $message=$c->load->view('email-templates/leaves/leave_request',$data,true);

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
    $c->email->from('hr@kfueit.edu.pk', 'PROCUREMENT KFUEIT');
    $c->email->to($emp->email);
    $c->email->subject('Requisition has been partially approved');
    $c->email->message($message);

    if ( $c->email->send())
    {
        return 1;
    }else{
        return 0;
    }

}

function leave_request_status($status=null)
{
    $req_status=array(
        0=>'In Process',
        1=>'Request Recommended By Manager/HOD ',
        2=>'Request Rejected ',
        3=>'Refer to Vice Chancellor',
        4=>'Refer to Store',
        5=>'Verify & Return to Procurement',
        6=>'Approved & Ready for RFQ',
        7=>'Approved By Worthy vice Chancellor',
        8=>'Rejected By Worthy vice Chancellor',
        9=> 'Request Approved',
        10=>'Verified & Closed Request',
        11=>'Request Withdrawn'

    );
    if($status==null)
        return $req_status;
    else
        return $req_status[$status];
};

function getEmployee($Conditions,$select_statement=null,$returnArray=false)
{
    if($select_statement==null){
        $select_statement="emp.id, `name`, emp.slug, `father_name`, `cast`, `religion`, `cults`, `dob`, `age`, `present_address`, 
    `permanent_address`, `cnic`, `passport_no`, `mobile_no`, `ps_name`, `org_name`, `org_phone`, dept.title as `department`, jt.`job_type`, 
    `doa`, `experience`, `edu_details`, `police_case`, `img`, des.title as `designation`, `expire`, emp.title, `blood_group`, `email`, `phone_no`, 
    `e_phone_no`, `app_letter_no`, `bio_data_form`, `joining_letter_no`, `salary`, `erv`, `job_status`, `job_status_date`, `is_hod`, 
    `bm_id`, `nok`, `relation`, `is_teaching`, `gender`, `emp_no`";
    }

    return join_select_Table_array($select_statement,
        'employees emp',
        array(
            array(
                'tbl'=>'emp',
                'field'=>'department',
                'tbl2'=>'departments dept',
                'field2'=>'id',
                'type'=>'left'
            ),array(
            'tbl'=>'emp',
            'field'=>'id',
            'tbl2'=>'emp_contract_view contract',
            'field2'=>'emp_id',
            'type'=>'left'
        ),
            array(
                'tbl'=>'emp',
                'field'=>'id',
                'tbl2'=>'emp_job_type jt',
                'field2'=>'emp_id',
                'type'=>'left'
            )
        ,array(
            'tbl'=>'emp',
            'field'=>'designation',
            'tbl2'=>'designations des',
            'field2'=>'id',
            'type'=>null
        )
        ),$Conditions,null,null,$returnArray,null
    )[0];
}