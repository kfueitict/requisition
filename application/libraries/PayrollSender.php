<?php

class PayrollSender {
    function __construct()
    {
        $this->ci=& get_instance();
    }

    public function sendmail($post){
        if($post['employees'])
        {

            $msg='';
            $emp_count=count($post['employees']);
            $c=0;
            $response['msg']='';
            $response['progress']=0;
            $response['status']=0;

            foreach($post['employees'] as $emp)
            {
                $data=$this->_getPayrollData($emp);
                if(is_array($data)||is_object($data))
                {
                    $c++;
                    $res=Payroll_sendmail($data);
                    if($res)
                    {
                        $response['msg']=$response['msg']."Mail sent to {$data['emp']->email} <br>";
                        $response['progress']=$c/$emp_count;
                        payroll_session($response);
                    }
                }
            }
            $response['status']=1;
            payroll_session($response);
    }
    }

    private function _getPayrollData($emp_slug)
    {
        $employees=join_select_Table_array(
            'emp.id,emp.emp_no,emp.name,emp.id,emp.title,emp.email,emp.cnic,dept.title as department,emp.slug,
            emp.bm_id,pr.id as pr_emp,pr.overtime,des.title as designation,des.bps',
            'employees emp',
            array(
                array(
                    'tbl'=>'emp',
                    'field'=>'department',
                    'tbl2'=>'departments dept',
                    'field2'=>'id',
                    'type'=>null
                ),
                array(
                    'tbl'=>'emp',
                    'field'=>'designation',
                    'tbl2'=>'designations des',
                    'field2'=>'id',
                    'type'=>null
                ),array(
                'tbl'=>'emp',
                'field'=>'id',
                'tbl2'=>'payroll_master pr',
                'field2'=>'emp_id',
                'type'=>'left outer'
            )
            ),array('emp.slug'=>$emp_slug)
        );
        $data['emp']=$employees[0];
        $data['date']=generic_select_row('payroll_setting',array('id'=>1));
        $data['pr']=generic_select_row('payroll_master',array('emp_id'=>$data['emp']->id));
        return $data;
    }




} 