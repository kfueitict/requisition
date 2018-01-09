<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Services extends CI_Controller {

    function __construct() {
        parent::__construct();

    }

    public function employees(){

        if($this->input->post('user')=='sec')
        {
            $con=array(
                'job_status='=>'Active'
            );
            if($this->input->post('emp_no'))
            {
                $con=$con+array("emp.emp_no"=>$this->input->post('emp_no'));
            }
            if($this->input->post('dept_id'))
            {
                $con=$con+array("emp.department"=>$this->input->post('dept_id'));
            }
            $image=base_url('uploads/employees/');
            $select_statement=
                "emp.emp_no,concat(emp.title,' ',emp.name) as name,emp.mobile_no,des.title as designation,dept.title as department,emp.department as dept_id,
                concat('$image/',emp.img) as photo";
            $data=join_select_Table_array($select_statement,
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
                ),$con,null,null,true,null
            );

            echo json_encode($data);
        }
    }

    public function departments(){

        if($this->input->post('user')=='sec')
        {

            if($this->input->post('dept_id'))
            {
                $con[]=array("id"=>$this->input->post('dept_id'));
            }else
            {
                $con=null;
            }

            $select_statement=
                "departments.id as dept_id,departments.*";
            $data=join_select_Table_array($select_statement,
                'departments',
                null
                ,$con,'departments.title',null,true,null
            );

            echo json_encode($data);
        }
    }

    public function students(){

        $this->db = $this->load->database('cba', TRUE);
        if($this->input->post('user')=='sec')
        {
            $con=array(
            );
            if($this->input->post('std_reg'))
            {
                $con=$con+array("std.regNumber"=>$this->input->post('std_reg'));
            }
            if($this->input->post('deptID'))
            {
                $con=$con+array("std.deptID"=>$this->input->post('deptID'));
            }
           // $image="http://10.1.0.12/cba/kfueit_coreapp/images/profile_pictures/";
            $select_statement=
                "`regNumber`, 
                concat( `student_firstname`,' ', if( `student_middlename` is null,'',`student_middlename`),' ', if( `student_lastname` is null,'',`student_lastname`)) as name , 
                 `place_of_birth`, `cnic`,  `cell_number`, `residential_address`,
                 ss.student_status_label as status,
                 prg.program_title,
                 dpt.department_title as department";
            $data=join_select_Table_array($select_statement,
                'students std',array(
                    array(
                        'tbl'=>'std',
                        'field'=>'student_isactive',
                        'tbl2'=>'student_status ss',
                        'field2'=>'student_status_id',
                        'type'=>'left'
                    ),
                    array(
                        'tbl'=>'std',
                        'field'=>'deptID',
                        'tbl2'=>'departments dpt',
                        'field2'=>'department_id',
                        'type'=>'left'
                    ),array(
                        'tbl'=>'std',
                        'field'=>'prgmID',
                        'tbl2'=>'programs prg',
                        'field2'=>'program_id',
                        'type'=>'left'
                    )
                ),$con,null,'ss.student_status_id',true,null
            );
            $this->db = $this->load->database('default', TRUE);
            echo json_encode($data);
        }
    }

}
