<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    protected $tbl = 'users';
    protected $field = 'id';

    function __construct() {
        parent::__construct();

        $this->load->library('Auth_ldap');
        $this->auditlog = $this->config->item('auditlog');

    }
    private function _audit($msg){
        $date = date('Y/m/d H:i:s');
        if( ! file_put_contents($this->auditlog, $date.": ".$msg."\n",FILE_APPEND)) {
            log_message('info', 'Error opening audit log '.$this->auditlog);
            return FALSE;
        }
        return TRUE;
    }

    public function index() {
    if($this->session->userdata('is_logged_in'))
    {
        redirect(base_url('cms'));
    }
        if ($this->input->post())
        {
            $result = $this->generic_model->login('users');
            if ($result->num_rows() > 0)
            {
                foreach ($result->result() as $row) {
                    if(!empty($row->emp_id))
                    $emp_id=getSingle('employees','id','emp_no',$row->emp_id);
                    $data = array(
                        'id' => $row->id,
                        'emp_id' => @$emp_id,
                        'username' => $row->user_id,
                        'joining_date' => $row->created_date,
                        'user_name' => $row->first_name . ' ' . $row->last_name,
                        'email' => $row->email,
                        'is_logged_in' => TRUE,
                        'is_admin' => $row->user_type==getSingle('types','id','title','admin')?1:0,
                        'is_hod' => getSingle('hierarchy','hod','hod',@$emp_id)?1:0,
                        'is_r_head' => getSingle('hierarchy','r_head','r_head',@$emp_id)?1:0,
                        'user_type' => getSingle('types','title','id',$row->user_type)
                    );
                    
                    $this->session->set_userdata($data);
                    $this->_audit("Successful login:System User (".$row->user_id.") from ".$this->input->ip_address());
                    redirect(base_url('cms'));

                }
            } else {
				$this->session->set_flashdata('message', 'Invalid User ID or Password. Try Again');
                      redirect('login');
                if( $this->auth_ldap->login(
                    $this->input->post('email'),
                    $this->input->post('password')))
                {
                    $row=generic_select_row('employees',array('ldap_id'=>$this->input->post('email')));
                    if(is_array($row)||is_object($row))
                    {
                        $hod=getSingle('hierarchy','hod','hod',$row->id);
                        $system_user=getSingle('users','id','user_id',$this->input->post('email'));
                        $id=-1;

                        if(!empty($system_user))
                        {
                            $id=$system_user;
                            if($hod)
                            {
                                $postData=array(
                                    'departments'=>$row->department
                                );
                            }else
                            {
                                $postData=array(
                                    'departments'=>null
                                );
                            }

                            update_db('users','id',$id,$postData);

                        }else
                        {
                            $postData=array(
                                'user_id'=>$this->input->post('email'),
                                'first_name'=>$row->name,
                                'last_name'=>'',
                                'status'=>0,
                                'email'=>$this->input->post('email').'@kfueit.edu.pk',
                            );
                            if($hod)
                            {
                                $postData=$postData+array(
                                        'departments'=>$row->department
                                    );
                            }
                            if(insert_db('users',$postData))
                            {
                                $id=$this->db->insert_id();
                            }
                        }
                        $data = array(
                            'id' => $id,
                            'ldap' => true,
                            'emp_id' => $row->id,
                            'username' => $this->input->post('email'),
                            'joining_date' => $row->doa,
                            'user_name' => $row->title . ' ' . $row->name,
                            'email' => $row->email,
                            'is_logged_in' => TRUE,
                            'is_admin' => 0,
                            'is_hod' => $hod?1:0,
                            'is_r_head' => getSingle('hierarchy','r_head','r_head',$row->id)?1:0,
                            'user_type' => 'Employee'
                        );
                        $this->session->set_userdata($data);
                        redirect(base_url('cms'));
                    }else
                    {
                        $this->session->set_flashdata('message', 'Your official email id not updated yet. Please contact in DR office');
                        redirect('login');
                    }
                }else
                {
                        $this->session->set_flashdata('message', 'Invalid User ID or Password. Try Again');
                      redirect('login');
                }



            }
        } else {
            $this->load->view('users/login');
        }
    }

    function logout() {
        $data = array(
            'id' => null,
            'ldap' => null,
            'emp_id' => null,
            'username' => null,
            'joining_date' => null,
            'user_name' => null,
            'email' => null,
            'is_logged_in' => null,
            'is_admin' => null,
            'is_hod' => null,
            'is_r_head' => null,
            'user_type' => null
        );
        $this->session->unset_userdata($data);
        $this->session->sess_destroy();
        $this->session->unset_userdata('redirect_to');
        redirect();
    }

    function changePass()
    {
        if(@$this->session->userdata('ldap'))
        {
            $this->session->set_flashdata('message','Sorry, you can not change password because you are login from LDAP.');
            redirectToReffrer();
        }
        is_login();
        if($this->input->post())
        {
            if(tbl_count('users',array(
                'id'=>$this->session->userdata('id'),
                'password'=>md5($this->input->post('old_password')),
            )))
            {
                update_db('users','id',$this->session->userdata('id'),array('password'=>md5($this->input->post('password'))));
                $this->session->set_flashdata('message','Password Updated');
                redirectToReffrer();
            }else
            {
                $this->session->set_flashdata('message','Old password not correct');
                redirectToReffrer();
            }
        }else
        {
            $data['title']='Change Password';
            $data['button']='Update';
            $this->load->view('change_pass',$data);
        }
    }


}
