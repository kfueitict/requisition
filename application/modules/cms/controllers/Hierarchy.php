<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hierarchy extends CI_Controller {

   protected  $tbl_hierarchy='hierarchy';

    function __construct()
    {
        parent::__construct();
        is_dr_user();
    }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


    public function index()
	{
        $data['root']=join_select_Table_array('dept.title,dept.id,
        emp.emp_no,emp.title as emp_title,emp.name,
        emp_r.emp_no as emp_no_r,emp_r.title as emp_title_r,emp_r.name as name_r
        ',"$this->tbl_hierarchy hr",array(
            array(
                'tbl'=>'hr',
                'field'=>'dept_id',
                'tbl2'=>'departments dept',
                'field2'=>'id',
                'type'=>null
            ),
            array(
                'tbl'=>'hr',
                'field'=>'hod',
                'tbl2'=>'employees emp',
                'field2'=>'id',
                'type'=>'left'
            ),
            array(
                'tbl'=>'hr',
                'field'=>'r_head',
                'tbl2'=>'employees emp_r',
                'field2'=>'id',
                'type'=>'left'
            )
        ),array(' hr. parent_id is null'));
        $data['hierarchy']=join_select_Table_array('dept.title,dept.id,hr.parent_id,
        emp.emp_no,emp.title as emp_title,emp.name,
        emp_r.emp_no as emp_no_r,emp_r.title as emp_title_r,emp_r.name as name_r
        ',"$this->tbl_hierarchy hr",array(
            array(
                'tbl'=>'hr',
                'field'=>'dept_id',
                'tbl2'=>'departments dept',
                'field2'=>'id',
                'type'=>null
            ),
            array(
                'tbl'=>'hr',
                'field'=>'hod',
                'tbl2'=>'employees emp',
                'field2'=>'id',
                'type'=>'left'
            ),
            array(
                'tbl'=>'hr',
                'field'=>'r_head',
                'tbl2'=>'employees emp_r',
                'field2'=>'id',
                'type'=>'left'
            )
        ),array(' hr. parent_id is not null'));

        $data['departments']=join_select_Table_array('*','departments',null,array(
            "id not in (".join_select_Table_array('dept_id',$this->tbl_hierarchy,null,null,null,null,null,null,true).")"
        ));
        $data['employees']=join_select_Table_array('emp.title,emp_no,emp.name,emp.id,des.bps,des.title as designation,dept.title as department',
            'employees emp',
            array(
                array(
                'tbl'=>'emp',
                'field'=>'designation',
                'tbl2'=>'designations des',
                'field2'=>'id',
                'type'=>null
            ),array(
                'tbl'=>'emp',
                'field'=>'department',
                'tbl2'=>'departments dept',
                'field2'=>'id',
                'type'=>null
            )
            ),array("des.bps >="=>16,'job_status'=>'Active')
        );
        $this->load->view('hierarchy',$data);
	}

    function post(){
        if($this->input->post())
        {
            if($this->input->post('deleteHr'))
            {
                if(delete_db($this->tbl_hierarchy,'dept_id',$this->input->post('deleteHr')))
                {
                    $this->session->set_flashdata('message','Hierarchy Deleted');
                }else
                {
                    $this->session->set_flashdata('message',implode(' ',$this->db->error()));
                }
            }else if($this->input->post('add_dept')){
                $post_data=array(
                    'dept_id'=>$this->input->post('dept'),
                    'parent_id'=>$this->input->post('parent'),
                );
                if(insert_db($this->tbl_hierarchy,$post_data)){
                    $this->session->set_flashdata('message','Hierarchy Level Inserted...');
                }else
                {
                    $this->session->set_flashdata('message',$this->db->errors());
                }
            }else
            if($this->input->post('emp')||$this->input->post('emp')==0)
            {
                $post_data=array(
                    $this->input->post('field')=>$this->input->post('emp')
                );
                if(update_db($this->tbl_hierarchy,'dept_id',$this->input->post('dept'),$post_data)){
                    $this->session->set_flashdata('message','HOD Assigned...');
                }else
                {
                    $this->session->set_flashdata('message',$this->db->errors());
                }
            }

        }
        die;
    }


    public function crud($id=null,$key=null)
    {
        if($this->input->post())
        {

            $postData=array(
                'title'=>$this->input->post('title')
            );
            if($this->input->post('update_id')){

                update_db($this->tbl_Degrees,'id',$this->input->post('update_id'),$postData);
                $this->session->set_flashdata('message','Degree Updated successfully');
                redirect(base_url('cms/degrees'));

            }else
            {
                $slug=slug_genrator($this->input->post('title'),'degrees');
                $postData=$postData+array('slug'=>$slug );
                if(insert_db($this->tbl_Degrees,$postData))
                {
                    $this->session->set_flashdata('message','Degree added successfully');
                    redirect(base_url('cms/degrees'));
                }
            }
        }else
        {
            if($id==null&&$key==null)
            {
                $data['title']='Add Degree';
                $data['button']='Add Degree';
                $data['types']=generic_select('degrees');
                $this->load->view('degree_cu',$data);
            }else if($id!=null&&$key==null)
            {
                $data['title']='Edit Degree';
                $data['button']='Save';
                $data['type']=generic_select_row($this->tbl_Degrees,array('slug'=>$id));

                if(is_array($data['type'])||is_object($data['type']))
                {
                    $this->load->view('degree_cu',$data);

                }else
                    redirectToReffrer();
            }else if($id&&$key=='delete')
            {
                if(delete_db($this->tbl_Degrees,'slug',$id))
                {
                    $this->session->set_flashdata('message','Degree Deleted successfully');
                    redirect('cms/degrees');
                }
            }
        }
    }



}
