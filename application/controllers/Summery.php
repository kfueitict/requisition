<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Summery extends CI_Controller
{
    function __construct() {
        parent::__construct();
    }

    public function index()
    {
        $data['task_tbl']="job_type";
        $data['status']=true;
        $emp['faculty'] = $this->get_faculty();
        $emp['staff'] = $this->get_staff();
        $emp['all_emp'] = $this->get_all_emp();

    $this->load->view('admin/print_summery');
    }

    private function get_faculty()
    {
        $data=custom_query("select m.title as dept_name,
                            sum(case when bps=17 AND d.title !='Teaching Assistant' then 1 else 0 end) as B17,
                            sum(case when bps=17 AND d.title ='Teaching Assistant' then 1 else 0 end) as TA,
                            sum(case when bps=18 then 1 else 0 end) as B18,
                            sum(case when bps=19 then 1 else 0 end) as B19,
                            sum(case when bps=19 and is_phd(e.id)=1 then 1 else 0 end) as B19phd,
                            sum(case when bps=19 and is_phd(e.id)=0 then 1 else 0 end) as B19nophd,
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
                         Group by m.title",true);
        return $data;
    }

    private function get_staff()
    {
        $data=custom_query("Select Type,Count(*) as cnt 
                            from 
                            (
                            select 1 as A,
                            case when bps between 1 and 16 then 'Officials BPS 1 to BPS 16' else 'Officers BPS 17 & Above' end as Type
                            from mis_employees e 
                            inner join mis_designations d
                            on d.id= e.designation
                            where is_teaching=0 and job_status='Active'
                            ) as P 
                            Group by Type",true);
        return $data;
    }

    private function get_all_emp()
    {
        $data=custom_query("Select fn_job_type(id) as JobType 
                          ,Sum(Case when is_teaching=1 then 1 else 0 end) as Teaching
                          ,sum(Case when is_teaching=0 then 1 else 0 end)as NonTeaching
                          ,Sum(1) as Total 
                          from mis_employees where job_status='Active'
                          Group by fn_job_type(id)",true);
        return $data;
    }
}