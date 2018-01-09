<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

if(!function_exists('faculty_access($redirect=true)'))
{
	function faculty_access($redirect=true)
	{
		$ci = get_instance();
		$logged_in = $ci->session->userdata('is_logged_in');
		$isAdmin = $ci->session->userdata('is_admin');
		
		if($logged_in || $isAdmin)
		{
			$scale = $ci->session->userdata('bps');
			$isteaching = $ci->session->userdata('isteaching');
			if(trim($scale) >= 19 && trim($is_teaching) == 1)
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
}

if(!function_exists('vc_access($redirect=true)'))
{
	function vc_access($redirect=true)
	{
		$ci = get_instance();
		$logged_in = $ci->session->userdata('is_logged_in');
		$isAdmin = $ci->session->userdata('is_admin');
		
		if($logged_in || $isAdmin)
		{
			$empid = $ci->session->userdata('emp_id');
			if($empid == 448)
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
}

if(!function_exists('librarian_access($redirect=true)'))
{
	function librarian_access($redirect=true)
	{
		$ci = get_instance();
		$logged_in = $ci->session->userdata('is_logged_in');
		$isAdmin = $ci->session->userdata('is_admin');
		if($logged_in || $isAdmin)
		{
			$dsg = $ci->session->userdata('desig');
			if(trim($dsg) == "Librarian")
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
}

if(!function_exists('select_statement($tbl,$conditions=null,$orderBy=null,$limit=null,$start=0)'))
{
function select_statement($tbl,$conditions=null,$orderBy=null,$limit=null,$start=0)
{
    $ci = & get_instance();
	$ci->load->model('Dailywages_model', 'daily');
    return $ci->daily->select_stmt($tbl,$conditions,$orderBy,$limit,$start);
}
}

