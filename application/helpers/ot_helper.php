<?php


function getOvertimeByTbl($whereClass,$holidays,$tbl)
{
    $ci = & get_instance();
    setOvertimeCache();
    $ci->db->cache_on();
    $data= custom_query("
                    SELECT date(CHECKTIME) Date,emp.name NAME,dpt.title DEPARTMENT,des.title DESIGNATION,
                    MIN(IF(CHECKTYPE like '%i%', TIME_FORMAT(`CHECKTIME`, '%H:%i'), NULL)) CHKIN,


                if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                     if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', TIME_FORMAT(`CHECKTIME`, '%H:%i'), NULL)),
                    NULL )
                        from mis_checkinout_manual
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', TIME_FORMAT(`CHECKTIME`, '%H:%i'), NULL))
                    )
                    CHKOUT,





                      CONCAT(FLOOR(round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                       if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout_manual
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      )/60),':',MOD(round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                      if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout_manual
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      ),60),'')

                      INTIME,
                      round(
                      if(DAYOFWEEK(CHECKTIME)=1 or DAYOFWEEK(CHECKTIME)=7 or date(CHECKTIME) in($holidays),round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                       if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout_manual
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      ),round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                       if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout_manual
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      )-if(date(CHECKTIME) BETWEEN '2017-05-28' and '2017-06-26',if(DAYOFWEEK(CHECKTIME)=6,300,360),480))/60,2) OverTIME


                    FROM $tbl chk
                    right OUTER join mis_employees emp on chk.userid=emp.bm_id
                    right OUTER join mis_departments dpt on emp.department=dpt.id
                    right OUTER join mis_designations des on emp.designation=des.id



                    WHERE CHECKTIME < Now() ".$whereClass."
                    GROUP by USERID,date(CHECKTIME)
                    ORDER by CHECKTIME desc
                    ",true);
    $ci->db->cache_off();
    return $data;
}

function getOvertime($user_bm_ids,$date_row=null)
{
    setOvertimeCache();
    $holidays='';
    $ci = & get_instance();
    if(is_array($date_row)||is_object($date_row))
    {
        $holidays=$date_row->holidays;

        $row=$date_row;
    }else
    {
        $row=generic_select_row('payroll_setting',array('id'=>1));
        $holidays=$row->holidays;
    }

    $t=explode(',',$holidays);
    $holidays="'".implode("','",$t)."'";

    $whereClass='';
    $whereClass.=" AND date(CHECKTIME) between '".$row->from_date."' AND '".$row->to_date."'";
    if($user_bm_ids!=null)
    $whereClass.=" AND USERID in( ".$user_bm_ids.") AND status=1";
    else
    $whereClass.=" AND status=1";
    $ci->db->cache_on();
    $data= custom_query("
                select emp.name,emp.slug,emp.bm_id,dpt.title department,des.title designation, (tbl_combine.overtime-tbl_device.overtime) otm,tbl_device.overtime otd,tbl_combine.overtime otc from mis_employees emp
                left join mis_departments dpt on emp.department=dpt.id
                left join mis_designations des on emp.designation=des.id

                    left JOIN (
                    (
                select name,department,slug,bm_id,sum(OverTIME) overtime from
                    (
                    SELECT date(CHECKTIME) Date,emp.name name,emp.slug,emp.bm_id,dpt.title department,
                    MIN(IF(CHECKTYPE like '%i%', TIME_FORMAT(`CHECKTIME`, '%H:%i'), NULL)) CHKIN,


                if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                     if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', TIME_FORMAT(`CHECKTIME`, '%H:%i'), NULL)),
                    NULL )
                        from mis_checkinout
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', TIME_FORMAT(`CHECKTIME`, '%H:%i'), NULL))
                    )
                    CHKOUT,
                    
                      CONCAT(FLOOR(round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                       if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      )/60),':',MOD(round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                      if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      ),60),'')

                      INTIME,
                      round(
                      if(DAYOFWEEK(CHECKTIME)=1 or DAYOFWEEK(CHECKTIME)=7 or date(CHECKTIME) in($holidays),round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                       if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      ),round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                       if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      )-
                      if(date(CHECKTIME) BETWEEN '2017-05-28' and '2017-06-26',if(DAYOFWEEK(CHECKTIME)=6,300,360),480))/60,2
                      ) OverTIME


                    FROM `mis_checkinout` chk
                    right OUTER join mis_employees emp on chk.userid=emp.bm_id
                    right OUTER join mis_departments dpt on emp.department=dpt.id
                    right OUTER join mis_designations des on emp.designation=des.id



                    WHERE CHECKTIME < Now()".$whereClass."
                    GROUP by USERID,date(CHECKTIME)
                    ORDER by CHECKTIME desc
                    ) tbl group by bm_id)
                    ) tbl_device on emp.bm_id=tbl_device.bm_id

                    left JOIN (
                    (
                select name,department,slug,bm_id,sum(OverTIME) overtime from
                    (
                    SELECT date(CHECKTIME) Date,emp.name name,emp.slug,emp.bm_id,dpt.title department,
                    MIN(IF(CHECKTYPE like '%i%', TIME_FORMAT(`CHECKTIME`, '%H:%i'), NULL)) CHKIN,


                if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                     if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', TIME_FORMAT(`CHECKTIME`, '%H:%i'), NULL)),
                    NULL )
                        from mis_checkinout_combine
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', TIME_FORMAT(`CHECKTIME`, '%H:%i'), NULL))
                    )
                    CHKOUT,





                      CONCAT(FLOOR(round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                       if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout_combine
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      )/60),':',MOD(round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                      if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout_combine
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      ),60),'')

                      INTIME,
                      round(
                      if(DAYOFWEEK(CHECKTIME)=1 or DAYOFWEEK(CHECKTIME)=7 or date(CHECKTIME) in($holidays),round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                       if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout_combine
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      ),round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                       if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout_combine
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      )-if(date(CHECKTIME) BETWEEN '2017-05-28' and '2017-06-26',if(DAYOFWEEK(CHECKTIME)=6,300,360),480))/60,2) OverTIME


                    FROM `mis_checkinout_combine` chk
                    right OUTER join mis_employees emp on chk.userid=emp.bm_id
                    right OUTER join mis_departments dpt on emp.department=dpt.id
                    right OUTER join mis_designations des on emp.designation=des.id



                    WHERE CHECKTIME < Now()".$whereClass."
                    GROUP by USERID,date(CHECKTIME)
                    ORDER by CHECKTIME desc
                    ) tbl group by bm_id)
                    ) tbl_combine on emp.bm_id=tbl_combine.bm_id
                    where emp.bm_id in($user_bm_ids)
                    ",null);
    $ci->db->cache_off();
    return $data;

}

function getOvertimeByDate($user_bm_ids,$date_row=null)
{
    setOvertimeCache();
    $holidays='';
    $ci = & get_instance();
    if(is_array($date_row)||is_object($date_row))
    {
        $holidays=$date_row->holidays;

        $row=$date_row;
    }else
    {
        $row=generic_select_row('payroll_setting',array('id'=>1));
        $holidays=$row->holidays;
    }

    $t=explode(',',$holidays);
    $holidays="'".implode("','",$t)."'";


    $whereClass='';
    $whereClass.=" AND date(CHECKTIME) between '".$row->from_date."' AND '".$row->to_date."'";
    if($user_bm_ids!=null)
    $whereClass.=" AND USERID in( ".$user_bm_ids.") AND status=1";
    else
    $whereClass.=" AND status=1";
    $ci->db->cache_on();

    $data= custom_query("
                select tbl_combine.Date as Date,
                (tbl_combine.overtime-tbl_device.overtime) otm,tbl_device.overtime otd,tbl_combine.overtime otc 
                from  (
                    (
                select sum(OverTIME) overtime,Date from
                    (
                    SELECT date(CHECKTIME) Date,USERID,
                    MIN(IF(CHECKTYPE like '%i%', TIME_FORMAT(`CHECKTIME`, '%H:%i'), NULL)) CHKIN,

                if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                     if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', TIME_FORMAT(`CHECKTIME`, '%H:%i'), NULL)),
                    NULL )
                        from mis_checkinout
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', TIME_FORMAT(`CHECKTIME`, '%H:%i'), NULL))
                    )
                    CHKOUT,





                      CONCAT(FLOOR(round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                       if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      )/60),':',MOD(round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                      if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      ),60),'')

                      INTIME,
                      round(
                      if(DAYOFWEEK(CHECKTIME)=1 or DAYOFWEEK(CHECKTIME)=7 or date(CHECKTIME) in($holidays),round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                       if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      ),round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                       if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      )- if(date(CHECKTIME) BETWEEN '2017-05-28' and '2017-06-26',if(DAYOFWEEK(CHECKTIME)=6,300,360),480))/60,2) OverTIME


                    FROM `mis_checkinout` chk
                    
                    WHERE CHECKTIME < Now()".$whereClass."
                    GROUP by Date,userid
                    ) tbl group by Date)
                    ) tbl_device

                    left JOIN (
                    (
                select sum(OverTIME) overtime,Date from
                    (
                    SELECT date(CHECKTIME) Date,USERID,
                    MIN(IF(CHECKTYPE like '%i%', TIME_FORMAT(`CHECKTIME`, '%H:%i'), NULL)) CHKIN,


                if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                     if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', TIME_FORMAT(`CHECKTIME`, '%H:%i'), NULL)),
                    NULL )
                        from mis_checkinout_combine
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', TIME_FORMAT(`CHECKTIME`, '%H:%i'), NULL))
                    )
                    CHKOUT,





                      CONCAT(FLOOR(round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                       if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout_combine
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      )/60),':',MOD(round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                      if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout_combine
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      ),60),'')

                      INTIME,
                      round(
                      if(DAYOFWEEK(CHECKTIME)=1 or DAYOFWEEK(CHECKTIME)=7 or date(CHECKTIME) in($holidays),round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                       if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout_combine
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      ),round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                       if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout_combine
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      )-if(date(CHECKTIME) BETWEEN '2017-05-28' and '2017-06-26',if(DAYOFWEEK(CHECKTIME)=6,300,360),480))/60,2) OverTIME


                    FROM `mis_checkinout_combine` chk
                    



                    WHERE CHECKTIME < Now()".$whereClass."
                    GROUP by Date,userid
                  
                    ) tbl group by Date)
                    ) tbl_combine on tbl_device.Date=tbl_combine.Date
                    ",true);
    $ci->db->cache_off();
    return $data;
}

function getNoOfDaysPresent($user_bm_ids,$date_row=null)
{
    setOvertimeCache();
    $holidays='';
    $ci = & get_instance();
    if(is_array($date_row)||is_object($date_row))
    {
        $holidays=$date_row->holidays;

        $row=$date_row;
    }else
    {
        $row=generic_select_row('payroll_setting',array('id'=>1));
        $holidays=$row->holidays;
    }


    $t=explode(',',$holidays);
    $holidays="'".implode("','",$t)."'";


    $whereClass='';
    $whereClass.=" AND date(CHECKTIME) between '".$row->from_date."' AND '".$row->to_date."'";
    $whereClass.=" AND USERID in( ".$user_bm_ids.")";
    $whereClass.=" AND date(CHECKTIME) not in( ".$holidays.")";
    $ci->db->cache_on();
    $data= custom_query("
    select tbl.userid as bm_id,count(tbl.userid) as days from
                      ( SELECT userid FROM mis_checkinout_combine
                      WHERE DAYOFWEEK(CHECKTIME) between 2 and 6
                      $whereClass
                      GROUP BY date(CHECKTIME),USERID) as tbl
    GROUP by tbl.userid
    ",null);
    $ci->db->cache_off();
    return $data;
}

function calculateTax($salary,$is_teaching=0)
{
    $tax=0;
    $anual_salary= $salary*12;
    if($anual_salary<=400000)//1
    {
        return $tax;
    }elseif($anual_salary<=500000)//2
    {
        $tax= ($anual_salary-400000)*.02;
    }elseif($anual_salary<=750000)//3
    {
        $tax= (($anual_salary-500000)*.05)+2000;
    }elseif($anual_salary<=1400000)//4
    {
        $tax= (($anual_salary-750000)*.1)+14500;
    }elseif($anual_salary<=1500000)//5
    {
        $tax= (($anual_salary-1400000)*.125)+79500;
    }elseif($anual_salary<=1800000)//6
    {
        $tax= (($anual_salary-1500000)*.15)+92000;
    }elseif($anual_salary<=2500000)//7
    {
        $tax= (($anual_salary-1800000)*.175)+137000;
    }elseif($anual_salary<=3000000)//8
    {
        $tax= (($anual_salary-2500000)*.2)+259500;
    }elseif($anual_salary<=3500000)//9
    {
        $tax= (($anual_salary-3000000)*.225)+359500;
    }elseif($anual_salary<=4000000)//10
    {
        $tax= (($anual_salary-3500000)*.25)+472000;
    }elseif($anual_salary<=7000000)//11
    {
        $tax= (($anual_salary-4000000)*.275)+597000;
    }else //12
    {
        $tax= (($anual_salary-7000000)*.3)+597000;
    }
    $tax=$tax/12;
    if($is_teaching)
        $tax=($tax-($tax*.4));

    return round(($tax),0);
}

function getAttendance($whereClass,$holidays)
{
    setOvertimeCache();
    $ci= & get_instance();
    $ci->db->cache_on();
    $data=custom_query("
                    SELECT date(CHECKTIME) Date,emp.bm_id ID,emp.name NAME,dpt.title DEPARTMENT,des.title DESIGNATION,status as STATUS,
                  MIN(IF(CHECKTYPE like '%i%', TIME_FORMAT(`CHECKTIME`, '%H:%i'), NULL)) CHKIN,


                if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                     if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', TIME_FORMAT(`CHECKTIME`, '%H:%i'), NULL)),
                    NULL )
                        from mis_checkinout_combine
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', TIME_FORMAT(`CHECKTIME`, '%H:%i'), NULL))
                    )
                    CHKOUT,



                      CONCAT(FLOOR(round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                       if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout_combine
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      )/60),':',MOD(round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                      if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout_combine
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      ),60),'')

                      INTIME,
                      round(
                      if(DAYOFWEEK(CHECKTIME)=1 or DAYOFWEEK(CHECKTIME)=7 or date(CHECKTIME) in($holidays),round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                       if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout_combine
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      ),round(
                      TIMESTAMPDIFF(MINUTE,
                    MIN(IF(CHECKTYPE like '%i%',`CHECKTIME`, NULL )),
                    if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    (
                    SELECT
                       if(
                    MIN(IF(CHECKTYPE like '%i%', `CHECKTIME`, NULL))>
                    MAX(IF(CHECKTYPE like '%o%', CHECKTIME, NULL)),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL)),
                    NULL )

                        from mis_checkinout_combine
                        where date(CHECKTIME)= date(DATE_ADD(chk.CHECKTIME,INTERVAL 1 DAY))
                        AND USERID=chk.USERID

                    ),
                    MAX(IF(CHECKTYPE like '%o%', `CHECKTIME`, NULL))
                    )
                    )
                      )-if(date(CHECKTIME) BETWEEN '2017-05-28' and '2017-06-26',if(DAYOFWEEK(CHECKTIME)=6,300,360),480))/60,2) OverTIME


                    FROM `mis_checkinout_combine` chk
                    left join mis_employees emp on chk.userid=emp.bm_id
                    right OUTER join mis_departments dpt on emp.department=dpt.id
                    right OUTER join mis_designations des on emp.designation=des.id
                    WHERE CHECKTIME <= Now() ".$whereClass." 
                    GROUP by USERID,date(CHECKTIME)
                    ORDER by CHECKTIME desc
                    ",true);
    if((is_array($data)||is_object($data)))
    {
        $data=setMissingDate($data);
    }
    $ci->db->cache_off();
    return $data;
}

function setMissingDate($data)
{

    foreach($data as $k)
    {
        $dateArray[]=$k['Date'];
    }
    $v="'".implode("','",$dateArray)."'";
    $whereClass=" cdate <= date(Now()) and cdate not in($v) ";
    if((!empty($_GET['from_date']))&&(!empty($_GET['to_date'])))
    {
        $whereClass.=" AND cdate between '".$_GET['from_date']."' AND '".$_GET['to_date']."'";
    }else if((!empty($_GET['from_date']))||(!empty($_GET['to_date'])))
    {
        if(!empty($_GET['to_date']))
        {
            $whereClass.=" AND cdate <= '".$_GET['to_date']."'";
        }
        if(!empty($_GET['from_date']))
        {
            $whereClass.=" AND cdate >= '".$_GET['from_date']."'";
        }
    }else
    {
        return $data;
    }
    $missing_date=custom_query("
    select cdate Date, '' as ID,'' as NAME,'' as DEPARTMENT, '' as DESIGNATION,'absent' as STATUS, '' as CHKIN,
    '' as CHKOUT, '' as INTIME,'' as OverTIME
    from  mis_calander  WHERE $whereClass ",true);
    if(is_array($missing_date)||is_object($missing_date))
    foreach ($missing_date as $date)
    {
        $data[]=$date;
    }
    $data=array_orderby($data,'Date',SORT_DESC);
    return $data;
}

function array_orderby()
{
    $args = func_get_args();
    $data = array_shift($args);
    foreach ($args as $n => $field) {
        if (is_string($field)) {
            $tmp = array();
            foreach ($data as $key => $row)
                $tmp[$key] = $row[$field];
            $args[$n] = $tmp;
        }
    }
    $args[] = &$data;
    call_user_func_array('array_multisort', $args);
    return array_pop($args);
}


function validateNumberSMS($number)
{
    $number=str_replace('-','',$number);
    $number=str_replace(' ','',$number);
    if($number[0]==0)
        $number=substr($number,1);
    $number='92'.$number;
    return $number;
}

function setOvertimeCache(){
    $c=& get_instance();
    
    //$t=tbl_count('setting',array('s_key'=>'ot_rows','s_value'=>1));
    if(@$t==1)
    {
        $c->db->cache_delete_all();
        update_db('setting','s_key','ot_rows',array('s_value'=>0));
    }
}