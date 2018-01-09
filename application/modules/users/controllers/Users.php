<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

   protected  $tbl_admin_users='users';
   protected  $tbl_types='types';
    function __construct()
    {
        parent::__construct();
        is_admin();
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
        $data['users']=join_select_Table_array($this->tbl_admin_users.'.*,types.title',$this->tbl_admin_users,array(
            array(
                'tbl'=>$this->tbl_admin_users,
                'field'=>'user_type',
                'tbl2'=>'types',
                'field2'=>'id',
                'type'=>'left',
            )
        ));
        $this->load->view('user_listing',$data);
	}

    public function dashboard()
    {
        $this->load->view('dashboard');
    }

    public function crud($id=null,$key=null)
    {
        if($this->input->post())
        {
            $departments= @implode(',',@$_POST['departments']);

            $postData=array(
                'user_id'=>$this->input->post('user_id'),
                'first_name'=>$this->input->post('first_name'),
                'last_name'=>$this->input->post('last_name'),
                'status'=>$this->input->post('status'),
                'email'=>$this->input->post('email'),
                'emp_id'=>$this->input->post('emp_id'),
                'departments'=>$departments,
                'user_type'=>$this->input->post('user_type')
            );
            if($this->input->post('update_id')){
                if($this->input->post('password')!='')
                    $postData+=array('password'=>md5($this->input->post('password')));
                update_db($this->tbl_admin_users,'id',$this->input->post('update_id'),$postData);
                $this->session->set_flashdata('message','User Updated successfully');
                redirect('users');

            }else
            {
                $postData+=array('password'=>md5($this->input->post('password')));
                if(insert_db($this->tbl_admin_users,$postData))
                {
                    $this->session->set_flashdata('message','User added successfully');
                    redirect('users');
                }
            }
        }else
        {
            if($id==null&&$key==null)
            {
                $data['title']='Add User';
                $data['button']='Add User';
                $data['types']=generic_select('types');
                $data['departments']=generic_select('departments');
                $this->load->view('user_cu',$data);
            }else if($id!=null&&$key==null)
            {
                $data['departments']=generic_select('departments');
                $data['title']='Edit User';
                $data['button']='Save';
                $data['types']=generic_select('types');
                $data['user']=generic_select_row($this->tbl_admin_users,array('id'=>$id));
                if(is_array($data['user'])||is_object($data['user']))
                {
                    $this->load->view('user_cu',$data);

                }else
                    redirectToReffrer();
            }else if($id&&$key=='delete')
            {
                if(delete_db($this->tbl_admin_users,'id',$id))
                {
                    $this->session->set_flashdata('message','User Deleted successfully');
                    redirect('users');
                }
            }
        }
    }

    public function types($id=null,$key=null)
    {
        if($this->input->post())
        {
            $postData=array(
                'title'=>$this->input->post('title')
            );
            if($this->input->post('update_id')){

                    update_db('types','id',$this->input->post('update_id'),$postData);
                    $this->session->set_flashdata('message','Type Updated successfully');
                    redirect('users/types');

            }else
            {
                if(insert_db('types',$postData))
                {
                    $this->session->set_flashdata('message','Type added successfully');
                    redirect('users/types');
                }
            }

        }else if($id=='new'){
            $data['title']='New Type';
            $data['button']='Add';
            $this->load->view('type_cu',$data);
        }
        else if($id!=''&&$key=='delete'){
            if(delete_db('types','id',$id))
            {
                $this->session->set_flashdata('message','Type Deleted successfully');
                redirect('users/types');
            }
        }else if($id!=''){
            $data['title']='Edit Type';
            $data['button']='Save';
            $data['type']=generic_select_row('types',array('id'=>$id));

            $this->load->view('type_cu',$data);
        }else
        {
            $data['types']=generic_select('types');
            $this->load->view('type_listing',$data);
        }
    }

    public function audit()
    {
        foreach($_GET as $k=>$v)
        {
            if(!empty($v)) {
                $con[] = array($k => $v);
            }
        }
        $data['audit_data']=join_select_Table_array('*','mis_audit_log',null,@$con);
        $data['sections']=join_select_Table_array('section','audit_log',null,null,'section');
        $data['actions']=join_select_Table_array('action','audit_log',null,null,'action');
        $data['user_id']=join_select_Table_array('user_id','audit_log',null,null,'user_id');


        $data['title']="User Audit";
        $this->load->view('user-audit',$data);
    }
}
