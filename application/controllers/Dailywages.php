<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dailywages extends CI_Controller {
		
		function __construct() {
			parent::__construct();
		}
		
		public function index()
		{
			$data['css'] = array(
                "plugins/select2/select2.min.css",
            );
            $data['js'] = array(
                "plugins/select2/select2.full.min.js",
            );
		$data['countries']=select_statement('countries');
        	$data['title']="Countries";
			$data['districts']=select_statement('cities');
        	$data['title']="Domicile";
			$data['department']=select_statement('departments');
        	$data['title']="Domicile";
			$data['degrees']=select_statement('degrees');
        	$data['title']="Degree";
			$data['boards']=select_statement('boards');
        	$data['title']="Boards";
			$data['designations']=select_statement('designations_tbl');
        	$data['title']="Designations";
			$data['employers']=select_statement('employers');
        	$data['title']="Employers";
		
			$this->load->view('admin/daily_wages', $data);
			
		}
        
        
    public function emp_no($is_teaching,$bpsIn)
    {
        $where="'%'";
        if(empty($bpsIn))
        {
            $where="4".date("y")."%";
            $emp_prefix="4".date("y")."000";
        }else{
            $bps=str_pad($bpsIn,2,0,STR_PAD_LEFT);
            if($is_teaching)
            {
                $where="2$bps%";
                $emp_prefix="2$bps"."000";
            }elseif($bpsIn>16)
            {
                $where="1$bps%";
                $emp_prefix="1$bps"."000";
            }elseif($bpsIn<17)
            {
                $where="3$bps%";
                $emp_prefix="3$bps"."000";
            }
            else{
                die("Invalid Input");
            }
        }

        $emp_no= custom_query("select if(max(emp_no),max(emp_no),$emp_prefix)+1 as emp_no from mis_emp_daily_wages where emp_no like '$where'")[0];
        return $emp_no->emp_no;
    }
        
		
		public function rec_request($value='')
        {
            if(!is_admin(false))
                if(is_dr_user_leave(false))
                    redirectToReffrer();
            if($this->input->post()) {
                if (!is_admin(false))
                    if (is_dr_user_payroll(false))
                        redirectToReffrer();
                $config['upload_path'] = './uploads/dailywages';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '0';
                $config['max_width'] = '0';
                $config['max_height'] = '0';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                $postData = array(
                    'title' => $this->input->post('title'),
                    'name' => $this->input->post('name'),
                    'father_name' => $this->input->post('father_name'),
                    'eci' => $this->input->post('E_C_No'),
                    'designation' => $this->input->post('job_designation'),
                    'gender' => $this->input->post('gender'),
                    'nationality' => $this->input->post('nationality'),
                    'religion' => $this->input->post('religion'),
                    'domicile' => $this->input->post('domicile'),
                    'cnic' => $this->input->post('cnic'),
                    'blood_group' => $this->input->post('blood_group'),
                    'mobile_no' => $this->input->post('mobile_no'),
                    'phone_no' => $this->input->post('phone_no'),
                    'doa' => $this->input->post('joining_date'),
                    'present_address' => $this->input->post('present_address'),
                    'permanent_address' => $this->input->post('permanent_address'),
                    'app_letter_no' => $this->input->post('app_letter_no'),
                    'job_type' => $this->input->post('job_type'),
                    'dob' => $this->input->post('dob'),
                    'job_status'=>$this->input->post('job_status'),
                    'job_status_date'=>$this->input->post('job_status_date'),
                    'salary'=>$this->input->post('salary'),
                    'salary_remarks'=>$this->input->post('salary_remarks'),
                    'remarks'=>$this->input->post('remarks'),
                    'department'=>$this->input->post('department'),
                    'ps_name'=>$this->input->post('ps_name'),
                    'org_name'=>$this->input->post('org_name'),
                    'org_phone'=>$this->input->post('org_phone'),
                );
                $emp_no = "";
                $is_teaching=false;
                $slug = slug_genrator($this->input->post('name'), 'emp_daily_wages');
                $postData = $postData + array('slug' => $slug);
                
                 $emp_no=$this->emp_no(0,"");
                if($emp_no)
                    $postData=$postData+array('emp_no'=>$emp_no);
                
                if ($_FILES['img']['name'] != '' && !empty($emp_no)) {
                    $config['file_name'] = $emp_no;
                    $config['overwrite'] = true;
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload('img')) {

                        $data = array('upload_data' => $this->upload->data());
                        $photo = $data['upload_data']['file_name'];

                        $postData += array('img' => $photo);

                    } else {
                        $this->session->set_flashdata('message', $this->upload->display_errors());
                        $ref = $this->input->server('HTTP_REFERER', TRUE);
                        redirect($ref, 'location');
                    }
                }
            
                    if(insert_db('emp_daily_wages',$postData))
                    {
                        $id=$this->db->insert_id();
                        $postDetail=array();

                        for($i=0;$i<count($this->input->post('degree'));$i++)
                        {
                            if(!($this->input->post('roll_no')[$i]==''
                                &&$this->input->post('certificate_no')[$i]==''&&
                                $this->input->post('year')[$i]==''&&
                                $this->input->post('total_marks')[$i]==''&&
                                $this->input->post('obtained_marks')[$i]=='')) {
                                $degree=$this->input->post('degree')[$i];
                                $board=$this->input->post('board')[$i];
                                if($this->input->post('other_degree_'.($i+1)))
                                {
                                    $row=generic_select_row('degrees',array('title'=>$this->input->post('other_degree_'.($i+1))));
                                    if(is_array($row)||is_object($row))
                                    {
                                        $degree=$row->id;
                                    }else
                                    {
                                        $postData1=array(
                                            'title'=>$this->input->post('other_degree_'.($i+1))
                                        );
                                        $slug=slug_genrator($this->input->post('other_degree_'.($i+1)),'degrees');
                                        $postData1=$postData1+array('slug'=>$slug );
                                        if(insert_db('degrees',$postData1))
                                        {
                                            $degree=$this->db->insert_id();
                                        }
                                    }
                                }
                                if($this->input->post('other_board_'.($i+1)))
                                {
                                    $row=generic_select_row('boards',array('title'=>$this->input->post('other_board_'.($i+1))));
                                    if(is_array($row)||is_object($row))
                                    {
                                        $board=$row->id;
                                    }else
                                    {
                                        $postData1=array(
                                            'title'=>$this->input->post('other_board_'.($i+1))
                                        );
                                        $slug=slug_genrator($this->input->post('other_board_'.($i+1)),'boards');
                                        $postData1=$postData1+array('slug'=>$slug );
                                        if(insert_db('boards',$postData1))
                                        {
                                            $board=$this->db->insert_id();
                                        }
                                    }
                                }
                                $postDetail[$i] = array(
                                    'board' => $board,
                                    'degree' => $degree,
                                    'roll_no' => $this->input->post('roll_no')[$i],
                                    'certificate_no' => $this->input->post('certificate_no')[$i],
                                    'year' => $this->input->post('year')[$i],
                                    'total_marks' => $this->input->post('total_marks')[$i],
                                    'obtained_marks' => $this->input->post('obtained_marks')[$i],
                                    'emp_id' => $id
                                );
                            }
                        }
                        if(count($postDetail)>0)
                            insert_db('mis_dailywages_edu',$postDetail,true);
                        $postDetailE=array();
                    for($i=0;$i<count($this->input->post('contract_type'));$i++)
                    {
                        if(!($this->input->post('months')[$i]==''
                            ||$this->input->post('exp_date')[$i]=='')) {

                            $postDetailE[$i] = array(
                                'duration' => $this->input->post('months')[$i],
                                'exp_date' => $this->input->post('exp_date')[$i],
                                'reference' => $this->input->post('reference')[$i],
                                'contract_type' => $this->input->post('contract_type')[$i],
                                'contract_date' => $this->input->post('contract_date')[$i],
                                'emp_id' => $id
                            );
                        }
                    }
                    if(count($postDetailE)>0)
                        insert_db('dailywages_contract',$postDetailE,true);

                        $this->session->set_flashdata('message','Employee added successfully');
                        redirect('dailywages/all_employee');
                    }else{
                         }
                }
            }
	public function all_employee()
    	{
        $select_statement=
            'emp.name,emp.phone_no,des.title as designation,emp.father_name,emp.img,emp.title,emp.doa,
             contract.expire_date,emp.permanent_address,emp.blood_group,
             emp.cnic,dept.title as department,emp.slug,emp.id,
             des.bps,emp.emp_no,des.bps,emp.mobile_no';
        $view='employee_listing';
        $result_as_array=false;

	$data['employees'] = $this->getRecord();        
        $this->load->view('admin/all_dailywages_emp.php',$data);
    		}
	private function get_basetbldata($select_statement)
    	{
        	$data=custom_query("SELECT wages.emp_no, wages.name, wages.father_name, wages.cnic, wages.phone_no, wages.designation, wages.img,
                                    wages.doa, wages.slug, board.title as board, degree.title as degree,
                                     contract.contract_type as type, 
                                    dept.title as empdept
                                  ,contract.duration as Duration
                                  from mis_emp_daily_wages wages
                                  left join mis_dailywages_edu edu on wages.id = edu.emp_id
                                  left join mis_boards board on board.id = edu.board
                                  left join mis_degrees degree on degree.id = edu.emp_id
                                  left join mis_dailywages_contract contract on contract.emp_id = wages.id
                                  left join mis_departments dept on dept.id = wages.department",true);
        return $data;
    	}
	private function getRecord()
    	{
        	$data=custom_query("SELECT wages.emp_no, wages.name, wages.father_name, wages.cnic, wages.phone_no, wages.designation, wages.img,
                                    	wages.doa, dept.title as deptname
                                  	from mis_emp_daily_wages wages
                                  	join mis_departments dept on dept.id=wages.department",true);
        return $data;
    	}
     
	}