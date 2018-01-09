<?php

class Leaves_model {

    function leaves($QueryYear=null,$departments=-1,$emp_no=null){
        $dept=null;
        $el_leave_balance_con=null;
        $el_encashment_con=null;
        $leave_types_conditions=null;
        if($departments==-1)
        {
            $dept='';
        }else
        {
            $dept=" and department in ($departments)";
        }
        if($emp_no!=null)
        {
            $dept.=" and emp.id=$emp_no";
            $leave_types_conditions=array('emp_lv.emp_id'=>$emp_no);
        }

        $tbl="mis_leaves_current_year_view";

        $year=date('y');
        $day=date('d');
        $month=date('m');
        $data['title']="Leave Register for 2017";

        if($QueryYear==2016)
        {
            $tbl="mis_leaves_2016_view";
            $year=16;
            $day=28;
            $month=12;
            $el_leave_balance_con=array("YEAR(date)=2016 $dept");
            $el_encashment_con=array("YEAR(req_date)=2016 $dept");
            $data['title']="Leave Register for 2016";

        }else
        {
            $temp_y=date('Y');
            $el_encashment_con=array("YEAR(req_date)<=$temp_y $dept");
            $el_leave_balance_con=array("YEAR(date)=$temp_y $dept");
            $data['previous_el_balance']=$this->calculate_el_balance(2016,$dept);
        }
        $leave_types= join_select_Table_array('lvt.*','leave_types lvt',
            array(
                array(
                    'tbl'=>'lvt',
                    'field'=>'id',
                    'tbl2'=>$tbl.' emp_lv',
                    'field2'=>'leave_type',
                    'type'=>'right'
                )
            ),$leave_types_conditions,'lvt.id'
        );
        //$emp=generic_select('employees',array('job_status'=>'Active'));
        $emp=join_select_Table_array('*','employees emp',null,array("job_status='Active' $dept"));
        $el_balance=array();
        $cl_balance=array();
        if(is_array($emp)||is_object($emp))
        foreach($emp as $e)
        {
            $cl=0;
            $el=0;
            $i=1;
            $m=date('m');
            if($m==12&&date('d')>16)
                $m=13;

            if($QueryYear==2016)
                $m=13;
            if($year==date('y',strtotime($e->doa)))
            {
                $i=date('m',strtotime($e->doa));
            }
            for(;$i<$m;$i++)
            {
                $cl++;
            }

            if($year==date('y',strtotime($e->doa)))
            {
                if(date('m',strtotime($e->doa))!=$month){
                    $el=$this->calculate_10s(date('d',strtotime($e->doa)));
                    for($i=date('m',strtotime($e->doa))+1;$i<$month;$i++)
                    {
                        $el=$el+3;
                    }
                    $el=$el+$this->calculate_10s_rev($day);
                }else
                {
                    $el=$this->calculate_10s_rev(date('d',strtotime($e->doa)));
                }


            }else
            {
                $el=0;
                for($i=1;$i<$month;$i++)
                {
                    $el=$el+3;
                }
                $el=$el+$this->calculate_10s_rev($day);
            }
            if($el<0)
                $el=0;

            $cl_balance[$e->slug]=$cl;
            $el_balance[$e->slug]=$el;


        }
        $select_statement_outer='0 as CL';
        $select_statement_inner='0 as CL';
        if(is_array($leave_types)||is_object($leave_types))
        {
            $select_statement_outer='';
            $select_statement_inner='';
            foreach($leave_types as $type)
            {
                if(!empty($select_statement_outer))
                {
                    $select_statement_outer.=',';
                }
                if(!empty($select_statement_inner))
                {
                    $select_statement_inner.=',';
                }

                //$select_statement_inner.="if(lv.leave_type=$type->id,SUM(DATEDIFF(to_date,from_date)+1),0) as ".str_replace('-','_',$type->slug);
                //$select_statement_inner.="if(lv.leave_type=$type->id,SUM(TOTAL_WEEKDAYS(to_date,from_date)),0) as ".str_replace('-','_',$type->slug);
                // sandwich rule de-active date
                $rule_date="2017-03-22";
                $select_statement_inner.="
            if(
            lv.leave_type=$type->id ,
                                SUM(
                                     if(from_date>'$rule_date',TOTAL_WEEKDAYS(to_date,from_date),DATEDIFF(to_date,from_date)+1)
                                    ),
                   0
               ) as ".str_replace('-','_',$type->slug);
                $select_statement_outer.="SUM(".str_replace('-','_',$type->slug).") as '$type->title'";
            }
        }
        $data['cl_balance']=$cl_balance;
        $data['el_balance']=$el_balance;
        $inner_query=join_select_Table_array("
            emp.emp_no,emp.name as Name,des.title as Designation,des.bps,dept.title as Department,
            $select_statement_inner
            ,emp.slug
            ",
            'employees emp',
            array(
                array(
                    'tbl'=>'emp',
                    'field'=>'department',
                    'tbl2'=>'departments dept',
                    'field2'=>'id',
                    'type'=>'left'
                )
            ,array(
                'tbl'=>'emp',
                'field'=>'designation',
                'tbl2'=>'designations des',
                'field2'=>'id',
                'type'=>null
            ),
                array(
                    'tbl'=>'emp',
                    'field'=>'id',
                    'tbl2'=>$tbl.' lv',
                    'field2'=>'emp_id',
                    'type'=>'left'
                ),array(
                'tbl'=>'lv',
                'field'=>'leave_type',
                'tbl2'=>'leave_types lvt',
                'field2'=>'id',
                'type'=>'left'
            )
            ),array(
                "job_status='Active' $dept"
            ),'lv.leave_type,emp.id',null,null,null,true
        );
        $data['employees']=custom_query("
            select
            emp_no as Emp_No,Name,Designation,Department,bps,
            $select_statement_outer
            ,slug from ($inner_query) as tbl group by slug
            ",true);

        $el_eaves= join_select_Table_array('emp.slug,FLOOR(count(date)/2) as days','employees emp',array(
            array(
                'tbl'=>'emp',
                'field'=>'id',
                'tbl2'=>'emp_el_leaves',
                'field2'=>'emp_id',
                'type'=>null
            )
        ),$el_leave_balance_con,'emp.id',null);
        $temp=array();
        if(is_array($el_eaves)||is_object($el_eaves))
        foreach($el_eaves as $l)
        {
            $temp[$l->slug]=$l->days;
        }


        $data['el_leaves']=$temp;


        // encashed leaved

        $el_encashed= join_select_Table_array('emp.slug,sum(days) as days','employees emp',array(
            array(
                'tbl'=>'emp',
                'field'=>'id',
                'tbl2'=>'leaves_encashment',
                'field2'=>'emp_id',
                'type'=>null
            )
        ),$el_encashment_con,'emp.id',null);
        $temp=array();
        if(is_array($el_encashed)||is_object($el_encashed))
        foreach($el_encashed as $l)
        {
            $temp[$l->slug]=$l->days;
        }


        $data['el_encashed']=$temp;



        return $data;
    }




    private function calculate_el_balance($year,$dpt)
    {
        $tbl="mis_leaves_current_year_view";

        $el_leave_balance_con=null;
        if($year==2016)
        {
            $tbl="mis_leaves_2016_view";
            $year=16;
            $day=28;
            $month=12;
            $el_leave_balance_con=array("YEAR(date)=2016");
        }
        $leave_types= join_select_Table_array('lvt.*','leave_types lvt',
            array(
                array(
                    'tbl'=>'lvt',
                    'field'=>'id',
                    'tbl2'=>$tbl.' emp_lv',
                    'field2'=>'leave_type',
                    'type'=>'right'
                )
            ),null,'lvt.id'
        );
        $emp=join_select_Table_array('*','employees emp',null,array("job_status='Active' $dpt and doa < '2017-01-01'"));
        $el_balance=array();
        $cl_balance=array();
        foreach($emp as $e)
        {
            $cl=12;
            $el=0;
            if($year==date('y',strtotime($e->doa)))
            {
                $cl=0;
                for($i=date('m',strtotime($e->doa));$i<=12;$i++)
                {
                    $cl++;
                }
            }

            if($year==date('y',strtotime($e->doa)))
            {
                if(date('m',strtotime($e->doa))!=$month){
                    $el=$this->calculate_10s(date('d',strtotime($e->doa)));
                    for($i=date('m',strtotime($e->doa))+1;$i<$month;$i++)
                    {
                        $el=$el+3;
                    }
                    $el=$el+$this->calculate_10s_rev($day);
                }else
                {
                    $el=$this->calculate_10s_rev(date('d',strtotime($e->doa)));
                }


            }else
            {
                $el=0;
                for($i=1;$i<$month;$i++)
                {
                    $el=$el+3;
                }
                $el=$el+$this->calculate_10s_rev($day);
            }
            if($el<0)
                $el=0;

            $cl_balance[$e->slug]=$cl;
            $el_balance[$e->slug]=$el;


        }
        $select_statement_outer='';
        $select_statement_inner='';
        foreach($leave_types as $type)
        {
            if(!empty($select_statement_outer))
            {
                $select_statement_outer.=',';
            }
            if(!empty($select_statement_inner))
            {
                $select_statement_inner.=',';
            }



            //$select_statement_inner.="if(lv.leave_type=$type->id,SUM(DATEDIFF(to_date,from_date)+1),0) as ".str_replace('-','_',$type->slug);
            // sandwich rule de-active date
            $rule_date="2017-03-22";
            $select_statement_inner.="
            if(
            lv.leave_type=$type->id,
                                SUM(
                                     if(from_date>'$rule_date',TOTAL_WEEKDAYS(to_date,from_date),DATEDIFF(to_date,from_date)+1)
                                    ),
                   0
               ) as ".str_replace('-','_',$type->slug);
            $select_statement_outer.="SUM(".str_replace('-','_',$type->slug).") as '$type->title'";
        }
        $data['cl_balance']=$cl_balance;
        $data['el_balance']=$el_balance;
        $inner_query=join_select_Table_array("
            emp.emp_no,emp.name as Name,des.title as Designation,des.bps,dept.title as Department,
            $select_statement_inner
            ,emp.slug
            ",
            'employees emp',
            array(
                array(
                    'tbl'=>'emp',
                    'field'=>'department',
                    'tbl2'=>'departments dept',
                    'field2'=>'id',
                    'type'=>'left'
                )
            ,array(
                'tbl'=>'emp',
                'field'=>'designation',
                'tbl2'=>'designations des',
                'field2'=>'id',
                'type'=>null
            ),
                array(
                    'tbl'=>'emp',
                    'field'=>'id',
                    'tbl2'=>$tbl.' lv',
                    'field2'=>'emp_id',
                    'type'=>'left'
                ),array(
                'tbl'=>'lv',
                'field'=>'leave_type',
                'tbl2'=>'leave_types lvt',
                'field2'=>'id',
                'type'=>'left'
            )
            ),array(
                "job_status='Active' $dpt"
            ),'lv.leave_type,emp.id',null,null,null,true
        );
        $data['employees']=custom_query("
            select
            emp_no as Emp_No,Name,Designation,Department,bps,
            $select_statement_outer
            ,slug from ($inner_query) as tbl group by slug
            ",true);


        $lv_balance=array();

        foreach($data['employees'] as $k=>$v)
        {
            $lv_balance[$v['slug']]=((@$data['el_balance'][$v['slug']])-@$v['EL']);
        }
        return $lv_balance;
    }

    private function calculate_10s($day)
    {
        if($day<=10)
            return 3;
        elseif($day<=20)
            return 2;
        elseif($day<=31)
            return 1;
    }
    private function calculate_10s_rev($day)
    {
        if($day<=10)
            return 1;
        elseif($day<=20)
            return 2;
        elseif($day<=31)
            return 3;
    }


}
