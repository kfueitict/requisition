<?php
    class Faculty extends CI_Controller
    {
        public function index(){

            $data['faculty'] = $this->db->query("select m.title as dept_name,
                                                        sum(case when bps=17 AND d.title !='Teaching Assistant' then 1 else 0 end) as B17,
                                                        sum(case when bps=17 AND d.title ='Teaching Assistant' then 1 else 0 end) as TA,
                                                        sum(case when bps=18 then 1 else 0 end) as B18,
                                                        sum(case when bps=19 then 1 else 0 end) as B19,
                                                        sum(case when bps=20 then 1 else 0 end) as B20,
                                                        sum(case when bps=21 then 1 else 0 end) as B21,
                                                        sum(case when bps=22 then 1 else 0 end) as B22,
                                                        count(*) as total
    			                                     from mis_employees e
    			                                     inner join mis_designations d
    			                                     on d.id= e.designation
    			                                     inner join mis_departments m
    			                                     on m.id = e.department
    			                                     where bps between 17 and 22 and is_teaching=1 and job_status='Active'
    			                                     Group by m.title")
                                                ->result_array();

            $data['staff'] = $this->db->query("Select Type,Count(*) as cnt 
                                                from 
                                                (
                                                select 1 as A,
                                                case when bps between 1 and 16 then 'Officers BPS 17 & Above' else 'Officials BPS 1 to BPS 16' end as Type
                                                from mis_employees e
                                                inner join mis_designations d
                                                on d.id= e.designation
                                                where is_teaching=0 and job_status='Active'
                                                ) as P 
                                                Group by Type")
                                            ->result_array();

            $data['all_emp'] = $this->db->query("Select fn_job_type(id) as JobType 
                                                  ,Sum(Case when is_teaching=1 then 1 else 0 end) as Teaching
                                                  ,sum(Case when is_teaching=0 then 1 else 0 end)as NonTeaching
                                                  ,Sum(1) as Total 
                                                  from mis_employees where job_status='Active'
                                                  Group by fn_job_type(id)")
                                            ->result_array();

            $this->load->view('public/detail', $data);
        }
        
        public function test()
        {
            $this->load->view('public/test.php');
        }

        public function check()
        {
            $data['educational'] = $this->db->query("select faculty.Email, faculty.Contact_No, faculty.Ext,
        								  			 emp_edu.degree, emp_edu.institute, emp_edu.year,
    			                                     emp_edu.city, emp_edu.country
    			                                     from emp_edu
    			                                     join faculty on faculty.ID = emp_edu.faculty_id 
    			                                     where emp_edu.faculty_id=".$id. " ORDER BY faculty_id, emp_edu.ID DESC ")
                ->result_array();
        }

        public function attendance($task='present_emp_officers')
        {
//            $current_date = date("Y-m-d");
            $current_date = '2017-01-20';
//            $prev_date = '2017-01-20';
            $tasks_queries=array(
            'present_emp_officers'=>" and '$current_date'=date(CHECKTIME) and des.bps>16 AND emp.is_teaching=0",
                'present_emp_officers_absent'=>array("tbl.userid is null and emp.job_status='Active' and lv.emp_id is null and des.bps>16 AND emp.is_teaching=0"),
            'present_emp_officers_leaves'=>array("lv.cdate='$current_date' and des.bps<16 AND emp.is_teaching=0"),
            'present_emp_teaching'=>" and '$current_date'=date(CHECKTIME) and des.bps>16 AND emp.is_teaching=1",
            'present_emp_non_gazetted'=>" and '$current_date'=date(CHECKTIME) and des.bps<17 ",
            'today_leaves'=>array('lv.cdate'=>$current_date),
            'today_absent'=>array("tbl.userid is null and emp.job_status='Active' and lv.emp_id is null")
        );
           // $data['desg'] = custom_query("SELECT title FROM mis_designations_tbl where bps >= 17",true);
           
            $data['present']=getAttendance($tasks_queries[$task],"2");
            $data['absent']=getAbsentEmployees($tasks_queries[$task.'_absent'],null,false, $current_date);
            $data['leave']=getEmployeesAreOnLeave($tasks_queries[$task.'_leaves']);
      
//            $this->load->view('public/attendance', $data);
            $this->load->view('public/dashboard_item', $data);
        }


    public function staff_details()
    {
        $data['staff'] = custom_query("select m.title as dept_name,
                            sum(case when bps BETWEEN 1 and 4 then 1 else 0 end) as Bps_1_4,
                            sum(case when bps BETWEEN 5 and 11 then 1 else 0 end) as Bps_5_11,
                            sum(case when bps BETWEEN 12 and 14 then 1 else 0 end) as Bps_12_14,
                            sum(case when bps = 16 then 1 else 0 end) as Bps_16,
                            sum(case when bps=17 and is_teaching=0 then 1 else 0 end) as Bps_17,
                            sum(case when bps=18 and is_teaching=0 then 1 else 0 end) as Bps_18,
                            sum(case when bps=19 and is_teaching=0 then 1 else 0 end) as Bps_19, 
                            sum(case when bps=20 and is_teaching=0 then 1 else 0 end) as Bps_20,
                            sum(case when bps=21 and is_teaching=0 then 1 else 0 end) as Bps_21,
                           
                            count(*) as total
                         from mis_employees e
                         inner join mis_designations d
                         on d.id= e.designation
                         inner join mis_departments m
                         on m.id = e.department
                         where bps between 1 and 22 and job_status='Active'
                         Group by m.title", true);

       $this->load->view('admin/staff_pos_detail', $data);
        // $this->load->view('admin/staff_model', $data);
    }

      
    }
