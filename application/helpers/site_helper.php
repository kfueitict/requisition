<?php

function getSingle($tbl,$field,$id,$value) {
    $result = '';
    $ci = & get_instance();
    $ci->db->select($field);
    $ci->db->where($id, $value);
    $ci->db->limit(1);
    $query = $ci->db->get($tbl);
    if ($query->num_rows() > 0) {
        $result = $query->row($field);
    }else
        $result=0;
    return $result;
}
function custom_query($query,$result_as_array=null)
{
    $ci = & get_instance();
    return $ci->generic_model->custom_query($query,$result_as_array);
}

function generic_select($tbl,$conditions=null,$orderBy=null,$limit=null,$start=0)
{
    $ci = & get_instance();
    return $ci->generic_model->generic_select($tbl,$conditions,$orderBy,$limit,$start);
}

function getDistinct($tbl,$distinctField,$conditions=null,$orderBy=null,$limit=null,$start=0)
{
    $ci = & get_instance();
    return $ci->generic_model->getDistinct($tbl,$distinctField,$conditions,$orderBy,$limit,$start);
}

function tbl_count($tbl,$conditions=null)
{
    $ci = & get_instance();
    return $ci->generic_model->record_count($tbl,$conditions);
}

function generic_select_row($tbl,$conditions=null)
{
    $ci = & get_instance();
    $data=$ci->generic_model->generic_select($tbl,$conditions,null,1);
    if(isset($data[0]))
        return $data[0];
    else
        return null ;
}


function getMaxRec($tbl,$key,$condition=null)
{
    $ci = & get_instance();
    $data=$ci->generic_model->getRec($tbl,$key,$condition);
    return $data;
}

function is_login($type=null,$redirect=true)
{
    $ci=& get_instance();
    if($type==null)
    {
        if($ci->session->userdata('is_logged_in'))
        {
            return true;
        }else
        {
            $ci->session->set_userdata('redirect_to',current_url());
            redirect('login');
        }
    }else
    {
        if($ci->session->userdata('is_logged_in')&& strtolower($ci->session->userdata('user_type'))==strtolower($type))
        {
            return true;
        }else if($redirect)
        {
            $ci->session->set_flashdata('message', 'Access Denied');
            redirect(base_url());

        }else
        {
            return false;
        }
    }

}

function join_select_Table_array($select_data,$frmTbl, $tbl_array_field, $condition=null,$group_by=null,$orderBy=null,$result_as_array=null,$condition_or=null,$return_query=null)
{
    $ci = & get_instance();
    $data=$ci->generic_model->joinselect_arrayTable($select_data,$frmTbl, $tbl_array_field, $condition,$group_by,$orderBy,$result_as_array,$condition_or,$return_query);
    return $data;
}




function is_admin($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&$ci->session->userdata('is_admin'))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}

function is_faculty($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='Faculty'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}
function is_hod($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('is_hod')==1||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}
function is__reportingHead($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('is_r_head')==1||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}

function is_tender($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='Tenders'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}
function is_finance($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='finance'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}
function is_pro($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='PRO'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}
function is_dr_user($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='DR'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}
function is_dr_user_entry($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='dr_entry_emp'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}
function is_dr_user_leave($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='dr_entry_leaves'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}function is_dr_user_payroll($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='dr_payroll'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}
function is_application_viewer($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='Application_viewer'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}
function is_admission_committee($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='Admission_committee'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}


function join_select($select_data, $tbl, $tbl_fild, $join_tbl, $join_fild, $condition=null,$type=null,$group_by=null,$orderBy=null)
{
    $ci = & get_instance();
    $data=$ci->generic_model->joinselect($select_data, $tbl, $tbl_fild, $join_tbl, $join_fild, $condition,$type,$group_by,$orderBy);
    return $data;
}

function redirectToReffrer($msg=null,$var=null)
{
    $ci=& get_instance();
    $v="message";
    if($var!=null)
        $v=$var;
    if($msg!=null)
    {
        $ci->session->set_flashdata($v,$msg);
    }
    $ref = $ci->input->server('HTTP_REFERER', TRUE);
    redirect($ref, 'location');
}

function customRedirect($url,$msg=null,$var=null){
    $ci=& get_instance();
    $v="message";
    if($var!=null)
        $v=$var;
    if($msg!=null)
    {
        $ci->session->set_flashdata($v,$msg);
    }
    redirect($url);
}

function IsNotEmpty($field){
    return !(trim($field)===''||$field===null||$field=='0000-00-00'||$field=='0');
}
function slug_genrator($txt,$tbl)
{
    $ci = & get_instance();
    $text= $txt;
    // replace non letter or digits by -
    if($txt!=null)
    {
        $text= $txt;
    }
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

    // trim
    $text = trim($text, '-');

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // lowercase
    $text = strtolower($text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    if (empty($text))
    {
        $text= 'n-a';
    }

    if($ci->generic_model->selectwhere($tbl, 'slug', $text))
    {
        $text=slug_genrator($text.'-'.rand(1,999),$tbl);
    }
    return $text;


}

function insert_db($tbl,$data,$isBatchInsertion=null)
{
    $ci= &get_instance();
    if($ci->generic_model->insert($tbl, $data,$isBatchInsertion))
        return true;
    else
        return false;
}


function update_db($tbl,$id,$id_value,$data)
{
    $ci= &get_instance();
    return $ci->generic_model->update($tbl,$id,$id_value,$data);
}
function delete_db($tbl,$key,$value)
{
    $c=  & get_instance();
    return $c->generic_model->delete($tbl,$key,$value);
}
function send_email_custom($from_email,$from_name,$to_email,$subject,$message)
{
    $c= & get_instance();
    $c->load->library('email');
    $config = Array(
        'protocol' => "smtp",
        'smtp_host' => "mail.kfueit.edu.pk",
        'smtp_port' => 25,
        'smtp_user' => "finance.department",
        'smtp_pass' => "pass@1234abc",
        'mailtype' => "html",
        'charset' => "iso-8859-1",
        'wordwrap' => TRUE
    );
    $c->email->initialize($config);

    $this->email->clear();
    $c->email->from($from_email, $from_name);
    $c->email->to($to_email);
    $c->email->subject($subject);
    $c->email->message($message);

    if ( $c->email->send())
    {
        return 1;
    }else{
        return 0;
    }

}
function send_application_email($from_email,$from_name,$app_no,$subject)
{
    $c= & get_instance();
    if(substr($app_no,0,1)==="M")
        $tbl="app_master";
    else
        $tbl="app_engineering";
    $data['row']= generic_select_row($tbl,array('app_no'=>$app_no));
    $data['details']= generic_select($tbl.'_details',array('app_id'=>$data['row']->id));

    @$email='<h2>Congratulation! <small>Application submitted successfully</small></h2>
<p><strong>Application No: </strong>'.$app_no.'</p>
<p>You can print application and bank voucher from <a href="'.base_url('admissions/applications?app-no='.$app_no.'cnic='.$data['row']->cnic).'">here</a></p>';
    $c->load->library('email');
    $config = array (
        'mailtype' => 'html',
        'charset'  => 'utf-8',
        'priority' => '1'
    );
    $c->email->initialize($config);


    $c->email->from($from_email, $from_name);
    $c->email->to($data['row']->email);
    $c->email->subject($subject);
    $c->email->message($email);

    if ( $c->email->send())
    {
        return 1;
    }else{
        return 0;
    }

}
function generate_anchor($class=null,$href=null,$title,$target=null)
{
    $c='';
    $h='';
    $tar='';
    if($class)
        $c='class="'.$class.'" ';
    if($href)
        $h='href="'.SITE_URL.$href.'" ';
    if($target)
        $tar='target="'.$target.'" ';

    return '<a '.$c.$h.$tar.'>'.$title.'</a>';
}
function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'fourty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }

    return $string;
}

function getWorkingDays($startDate,$endDate,$holidays,$weekendOff=true)
{
    if($weekendOff)
        $workingDays = [1, 2, 3, 4, 5]; # date format = N (1 = Monday, ...)
    else
        $workingDays = [1, 2, 3, 4, 5,6,7]; # date format = N (1 = Monday, ...)

    $holidayDays = $holidays; # variable and fixed holidays

    $from = new DateTime($startDate);
    $to = new DateTime($endDate);
    $to->modify('+1 day');
    $interval = new DateInterval('P1D');
    $periods = new DatePeriod($from, $interval, $to);

    $days = 0;
    foreach ($periods as $period) {
        if (!in_array($period->format('N'), $workingDays)) continue;
        if (in_array($period->format('Y-m-d'), @$holidayDays)) continue;
        if (in_array($period->format('*-m-d'), @$holidayDays)) continue;
        $days++;
    }
    return $days;
}