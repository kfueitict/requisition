<?php
    class Transfer extends CI_Controller
    {
        public function __construct()
         {
//              pantum
//              pm6600nw
            parent::__construct();
            $this->load->library('form_validation');
            $this->load->model('Employee', 'emp');
         
            if(!(is_dr_user(false)||is_dr_user_entry(false)))
            {
                redirectToReffrer();
            }
         }
		
        public function index()
        {
            $data['css'] = array(
                "plugins/select2/select2.min.css",
            );
            $data['js'] = array(
                "plugins/select2/select2.full.min.js",
            );
            
            $data['department'] = $this->emp->get_departments();
            $data['employees'] = $this->emp->get_employees();
            $this->load->view('admin/transfer_emp', $data);
           
        }
        
        private function search_employee()
        {
            $num  = $_POST['empid'];
            $result = $this->emp->get_employee($num);
            if(is_array($result) || is_object($result))
            {
                return json_encode($result); 
            }else{
                $result['status'] = false;
				$result['msg'] = "Record not found";
				return json_encode($result);
            }
        }
        
        public function filter_employee()
        {
              $output = $this->search_employee();
              $this->output->set_output($output);
		}
        
        public function get_record()
        {
            $this->form_validation->set_rules('selectdept', 'Department id', 'required|numeric');
            $this->form_validation->set_rules('empname', 'Employee', 'required|numeric');
            $this->form_validation->set_rules('fromdate', 'From date', 'required');
            $this->form_validation->set_rules('reference', 'Reference', 'required');
            $this->form_validation->set_rules('todept', 'Department', 'required|numeric');
            $this->form_validation->set_rules('remarks', 'Remarks', 'required');
            $this->form_validation->set_error_delimiters( '<p class="text-danger">', '</p>' );
            if( !$this->form_validation->run() )
            {
                    $this->index();    
            }else{
                $fromdept = $this->input->post('selectdept');
                $empid = $this->input->post('empname');
                $fromdate = $this->input->post('fromdate');
                $ref = $this->input->post('reference');
                $todept = $this->input->post('todept');
                $remarks = $this->input->post('remarks');
                
                $date = date('Y-m-d',strtotime($fromdate));
                $result = $this->emp->save_record($empid, $fromdept, $ref, $date, $todept, $remarks);
                
                if($result > 0)
                {
                    $this->session->set_flashdata('feedback', 'Record Inserted Successfully');
                    $this->session->set_flashdata('feedback_class', 'alert-success');
                    return redirect('transfer');
                }else{
                    $this->session->set_flashdata('feedback', 'Fail Insert Record!');
                    $this->session->set_flashdata('feedback_class', 'alert-danger');
                    return redirect('transfer');
                }
            } 
        }
    }