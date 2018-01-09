<?php

class cms extends CI_Controller {

    protected $dept='';
    function __construct() {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
        is_login();
        if(!is_admin(false))
        if(is_dr_user_leave(false)||is_dr_user_entry(false))
            redirect(base_url('cms/employees'));
        $this->dept=getSingle('users','departments','id',$this->session->userdata('id'));

    }

    function index() {
        $data['js']=array(
            "plugins/chartjs/Chart.min.js"
        );
        if(!empty($this->dept)){
            $c=custom_query("select count(emp.id) c from mis_employees emp
        right join mis_departments dpt on emp.department=dpt.id
        right join mis_designations des on emp.designation=des.id
        where department in ($this->dept) and bm_id is NULL AND job_status='Active' AND des.bps<17 ");
        }

        if(@$c[0]->c>0 && !$this->session->userdata('userlist')){
            $this->session->set_userdata('userlist',1);
            $this->session->set_flashdata('message',@$c[0]->c." employees of your department not register in biomatric attendance
            <br> Click <a href=".base_url('cms/emp_list').">here </a> to view list
            <br> <span>Note: </span> Please contact in IT
            <p><strong>Note:</strong> If you have any employee which is not coming in any list then please contact in the Office of the Registrar.</p>
            ");
        }

        $data['c']=@$c[0]->c;
        if(is_admin(false))
        {
            $data['emp_stat']=custom_query("select sum(if(gender=1,1,0)) male,sum(if(gender=2,1,0)) female from mis_employees emp
                                          where job_status='Active'")[0];

        }
        $data['proceed_request']=tbl_count('leave_req_transactions',array('proceeded'=>0,'next_step'=>$this->session->userdata('emp_id')));
        $this->load->view('dashboard',$data);
    }

    function emp_list()
    {
        $data['employees']=custom_query("select emp.name,des.title as designation,emp.father_name,emp.cnic,dpt.title as department,doa from mis_employees emp
        right join mis_departments dpt on emp.department=dpt.id
        right join mis_designations des on emp.designation=des.id
        where department in ($this->dept) and bm_id is NULL AND job_status='Active' AND des.bps<17");
        $this->load->view('emp_list',$data);
    }

    function leaves()
    {
        if(!is_admin(false))
        if(!(is_dr_user_payroll(false)||is_dr_user(false)))
        {
            redirectToReffrer();
        }
        if($this->input->post())
        {
            if($this->input->post('type')=='ajax')
            {
                if(update_db('leave_types','slug',$this->input->post('slug'),array('display_order'=>$this->input->post('value'))))
                {
                    echo $this->input->post('slug');
                }
                die();
            }
            $postData=array(
                'title'=>$this->input->post('title'),
                'status_req_ini'=>$this->input->post('status_req_ini'),
                'slug'=>slug_genrator($this->input->post('title'),'leave_types')
            );
            if($this->input->post('update_id'))
            {
                if(update_db('leave_types','id',$this->input->post('update_id'),$postData))
                {
                    $this->session->set_flashdata('message',"Leave Type Updated");
                    redirect(base_url('cms/leaves'));
                }
            }else
            {
                if(tbl_count('leave_types',array('title'=>$this->input->post('title'))))
                {
                    $this->session->set_flashdata('message',"Leave Type Exist");
                    redirect(base_url('cms/leaves'));
                }
                if(insert_db('leave_types',$postData))
                {
                    $this->session->set_flashdata('message',"Leave Type Added");
                    redirect(base_url('cms/leaves'));
                }
            }
        }
        $data['button']='Add';
        if(@$_GET['mod']=='edit')
        {
            $data['leave_edit']=generic_select_row('leave_types',array('slug'=>$_GET['id']));
            $data['button']='Edit';
        }
        if(@$_GET['mod']=='delete')
        {
           if(delete_db('leave_types','slug',$_GET['id']))
           {
               $this->session->set_flashdata('message',"Leave Type Deleted");
               redirect(base_url('cms/leaves'));
           }
        }

        $data['leaves']=generic_select('leave_types');
        $this->load->view('leaves/master_file',$data);

    }

    function countries()
    {
        if(!is_admin(false))
            if(!(is_dr_user_payroll(false)))
            {
                redirectToReffrer();
            }
        if($this->input->post())
        {
            $postData=array(
                'title'=>$this->input->post('title'),
                'status'=>$this->input->post('status'),
                'iso'=>$this->input->post('iso'),
                'iso3'=>$this->input->post('iso3'),
            );
            if($this->input->post('update_id'))
            {
                if(update_db('countries','id',$this->input->post('update_id'),$postData))
                {
                    $this->session->set_flashdata('message',"Country Updated");
                    redirect(base_url('cms/countries'));
                }
            }else
            {
                if(tbl_count('countries',array('title'=>$this->input->post('title'))))
                {
                    $this->session->set_flashdata('message',"Country Exist");
                    redirect(base_url('cms/countries'));
                }
                if(insert_db('countries',$postData))
                {
                    $this->session->set_flashdata('message',"Country Added");
                    redirect(base_url('cms/countries'));
                }
            }
        }
        $data['button']='Add';
        if(@$_GET['mod']=='edit')
        {
            $data['_edit']=generic_select_row('countries',array('id'=>$_GET['id']));
            $data['button']='Edit';
        }
        if(@$_GET['mod']=='delete')
        {
            if(delete_db('countries','id',$_GET['id']))
            {
                $this->session->set_flashdata('message',"County Deleted");
                redirect(base_url('cms/countries'));
            }
        }

        $data['countries']=generic_select('countries');
        $data['title']="Countries";
        $this->load->view('master/countries',$data);

    }

    public function holidays()
    {
        is_dr_user();
        if($this->input->post())
        {
            $data=generic_select_row('payroll_setting',array('id'=>1));
            if(is_array($data)||is_object($data))
            {
                if($this->input->post('weekends'))
                {
                    $field='weekends';
                    $temp=explode(',',$data->weekends);
                    if($this->input->post('key')=='sat')
                    {
                        if($this->input->post('value')=='true')
                            $temp[0]=6;
                        else
                            $temp[0]='*';
                    }elseif($this->input->post('key')=='sun')
                    {
                        if($this->input->post('value')=='true')
                            $temp[1]=0;
                        else
                            $temp[1]='*';
                    }

                }else
                {
                    $field='holidays';
                    $temp=explode(',',$data->holidays);
                    $temp=array_filter($temp);
                    $key = array_search($this->input->post('value'),$temp);
                    if($key!==false){
                        unset($temp[$key]);
                    }else
                    {
                        $temp[]=$this->input->post('value');
                    }
                }

                $postData=array(
                    $field=>implode(',',$temp)
                );
                update_db('payroll_setting','id',1,$postData);

            }else
            {
                if($this->input->post('weekends'))
                {
                    $field='weekends';
                    $temp[0]='*';
                    $temp[1]='*';
                    if($this->input->post('key')=='sat')
                    {
                        if($this->input->post('value')=='true')
                            $temp[0]=6;
                        else
                            $temp[0]='*';
                    }elseif($this->input->post('key')=='sun')
                    {
                        if($this->input->post('value')=='true')
                            $temp[1]=0;
                        else
                            $temp[1]='*';
                    }

                }else
                {
                    $field='holidays';

                    $temp[]=$this->input->post('value');
                }
                $postData=array(
                    'user_id'=>getUserData('id'),
                    $field=>implode(',',$temp)
                );
                if(insert_db('users_availability',$postData))
                {
                    $temp[]=$this->input->post('value');
                }
            }
            if($this->input->post('weekends'))
            {
                $d[]='* * * '.@$temp[0].','.@$temp[1];
                echo json_encode($d);
                exit;
            }
            else
            {
                foreach(@$temp as $tm)
                    $t[]= $tm;//mdate('%d %m %Y',strtotime($tm)) ;
                echo json_encode(@$t);
                exit;
            }

        }
        $data['avail']=generic_select_row('payroll_setting',array('id'=>1));
        $this->load->view('payroll/holidays',$data);
    }






    function check_email() {
        if($this->input->post('email'))
        {
            $email = $this->input->post('email');

            if($this->generic_model->selectwhere('users', 'email', $email)==FALSE)
                echo true;
            else
                echo false;
        }else
        {

            redirect($this->agent->referrer);
        }

    }





}
