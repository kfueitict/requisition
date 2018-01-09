<?php
    class Employee extends CI_Model
    {
       public function get_departments()
       {
           $query = $this->db->select('id, title')
                            ->from('departments')
                            ->get()
                            ->result_array();
           if($query > 0)
           {
               return $query;
           }
           else{
               return false;
           }
       }
       
       public function get_employees()
       {
           $query = $this->db->select('id, name')
                           ->from('employees')
                           ->get()
                           ->result_array();
           if($query > 0)
           {
               return $query;
           }
           else{
               return false;
           }
       }
        
        public function get_employee($num)
        {
            $query = $this->db->select('id, name')
                                ->from('employees')
                                ->where('department', $num)
                                ->where('job_status', 'Active')
                                ->get();
            if( $this->db->affected_rows() > 0 ){
				return $query->result_array();
            }
			else{
				return FALSE;
            }
        }
        
//        transfer employee model method
        public function save_record($empid, $fromdept, $ref, $date, $todept, $remarks)
        {
            $data = array(
                        'emp_id' => $empid,
                        'transfer_date' => $date,
                        'reference' => $ref,
                        'from_department' => $fromdept,
                        'to_department' => $todept,
                        'remarks' => $remarks,
                        );
            $result = $this->db->insert( 'emp_dept_transfer',$data  );
            if($result > 0)
                return true;
            else
                return false;
        }
        
        
        public function get_faculty()
        {
            $status = 'Active';
            $startscale = 17;
            $endscale = 22;
            $bps = 'bps';
            $this->db->select('m.title as dept_name,
                            sum(case when bps=17 AND d.title !="Teaching Assistant" then 1 else 0 end) as B17,
                            sum(case when bps=17 AND d.title ="Teaching Assistant" then 1 else 0 end) as TA,
                            sum(case when bps=18 then 1 else 0 end) as B18,
                            sum(case when bps=19 then 1 else 0 end) as B19,
                            sum(case when bps=20 then 1 else 0 end) as B20,
                            sum(case when bps=21 then 1 else 0 end) as B21,
                            sum(case when bps=22 then 1 else 0 end) as B22,
                            count(*) as total');
            $this->db->from('employees e'); 
            $this->db->join('designations d', 'd.id= e.designation', 'inner');
            $this->db->join('departments m', 'm.id = e.department', 'inner');
            $this->db->where('e.is_teaching IS NOT NULL', null, true );
            $this->db->where('d.bps >=', $startscale );
            $this->db->where('d.bps <=', $endscale );
            $this->db->where('e.job_status >=', $status ); 
            $query = $this->db->get(); 
            if($query->num_rows() != 0)
            {
                return $query->result_array();
            }
            else
            {
                return false;
            }
        }
        
        
        public function get_staff()
        {
             $staff = $this->db->query(" Select Type,Count(*) as cnt 
                                        from 
                                        (
                                        select 1 as A,
                                        case when bps between 1 and 16 then 'Officers BPS 17 & Above' else 'Officials BPS 1 to BPS 16' end as Type
                                        from mis_employees e
                                        inner join mis_designations d
                                        on d.id= e.designation
                                        where is_teaching=0 and job_status='Active'
                                        ) as P 
                                        Group by Type ")
                                    ->result_array();
            return $staff;
        }
    
        public function get_all_emp()
        {
            $status = 'Active';
            $startscale = 17;
            $endscale = 22;
            $bps = 'bps';
            $this->db->select('fn_job_type(id) as JobType 
                                              ,Sum(Case when is_teaching=1 then 1 else 0 end) as Teaching
                                              ,sum(Case when is_teaching=0 then 1 else 0 end)as NonTeaching
                                              ,Sum(1) as Total');
                    $this->db->from('employees e'); 
                    $this->db->where('e.job_status >=', $status );
                    $this->db->group_by('fn_job_type(id)');
                    $query = $this->db->get(); 
            if($query->num_rows() != 0)
            {
                return $query->result_array();
            }
            else
            {
                return false;
            }
        }
        
        public function get_transfer_record()
        {
            $e_id = 94;
            $this->db->select('m.title as from_dept, m2.title as to_dept, t.transfer_date, t.reference, t.remarks');
            $this->db->from('emp_dept_transfer t');
            $this->db->join('departments m', 'm.id = t.from_department', 'inner');
            $this->db->join('departments m2', 'm2.id = t.to_department', 'inner');
            $this->db->where('t.emp_id', $e_id); 
            $query = $this->db->get(); 
            if($query->num_rows() >= 0)
            {
                return $query->result_array();
            }
            else
            {
                return false;
            }
        }
    }
    ?>

