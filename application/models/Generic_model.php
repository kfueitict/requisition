<?php

class Generic_model extends CI_Model {

    //initialize the path where you want to save your images
    function __construct() {
        parent::__construct();
    }

    function select($tbl) {

        $this->db->select('*');
        $this->db->from($tbl);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function getRec($tbl,$key,$condition=null)
    {
        $this->db->select_max($key);
        if($condition)
            $this->db->where($condition);
        $result= $this->db->get($tbl)->row_array();
        if($result[$key])
        return $result[$key];
        else
            return 1;
    }


    public function generic_select($tbl,$conditions=null,$orderBy=null,$limit=null,$start=0)
    {
        $this->db->select('*');
        if($conditions!=null)
        $this->db->where($conditions);
        if($orderBy!=null)
        $this->db->order_by($orderBy);
        if($limit!=null && is_numeric($limit))
            $query = $this->db->get($tbl,$limit,$start);
        else
            $query = $this->db->get($tbl);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }
    public function record_count($tbl,$conditions=null) {
        if($conditions!=null)
        {
            $this->db->where($conditions);
        }
        $this->db->from($tbl);
        return @$this->db->count_all_results();
    }

    public function getDistinct($tbl,$field,$conditions=null,$orderBy=null,$limit=null,$start=0)
    {
        $this->db->select('*');
        $this->db->distinct();
        $this->db->group_by($field);
        if($conditions!=null)
            $this->db->where($conditions);
        if($orderBy!=null)
            $this->db->order_by($orderBy);
        if($limit!=null && is_numeric($limit))
            $query = $this->db->get($tbl,$limit,$start);
        else
            $query = $this->db->get($tbl);

        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    function selectOrderby($tbl, $fields) {

        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->order_by($fields);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

//reture Single Row in Responce
    function selectwhere($tbl, $field, $id) {

        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->where($field, $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    //reture All Rows in Responce

    function getwhere($tbl, $field, $id) {

        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->where($field, $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    function custom_query($query,$result_as_array)
    {
        $query = $this->db->query($query);
        if(is_bool($query))
            return $query;
        if ($query->num_rows() > 0) {
            if($result_as_array)
                return $query->result_array();
            else
                return $query->result();
        } else {
            return FALSE;
        }
    }

    function getbystatue($tbl) {

        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    function joinselect($select_data, $tbl, $tbl_fild, $join_tbl, $join_fild, $condition=null,$type=null,$group_by=null,$orderBy=null) {
        $this->db->select($select_data);
        $this->db->from($tbl);

        if($type==null)
        $this->db->join($join_tbl, $join_tbl . '.' . $join_fild . '=' . $tbl . '.' . $tbl_fild);
        else
            $this->db->join($join_tbl, $join_tbl . '.' . $join_fild . '=' . $tbl . '.' . $tbl_fild,$type);
        if ($condition!=null)
            $this->db->where($condition);
        if($group_by!=null)
            $this->db->group_by($group_by);
        if($orderBy!=null)
            $this->db->order_by($orderBy);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    function SearchJobs($name)
    {
        $this->db->like('cus_first_name', $name, 'both');
        $this->db->or_like('cus_last_name', $name, 'both');
    }

    function edit_select($tbl, $field, $id) {
        $this->db->select('*');
        $this->db->from($tbl);
        $this->db->where($field, $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        } else {
            return FALSE;
        }
    }

    function page_select($title) {
        $this->db->select('*');
        $this->db->from($this->tbl);
        $this->db->like('page_title', $title);
        $query = $this->db->get();

        if ($query) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    function insert($tbl, $data,$isBatchInsertion) {
        if($isBatchInsertion)
            return $this->db->insert_batch($tbl, $data);
        else
            return $this->db->insert($tbl, $data);
    }


    function update($tbl, $field, $id, $data) {
        
        $this->db->where($field, $id);
      return  $this->db->update($tbl, $data);
    }

    function delete($tbl, $field, $id) {
        $this->db->where($field, $id);
        if ( ! $this->db->simple_query($this->db->get_compiled_delete($tbl)))
        {
            return false; 
        }else
         return  true;

    }

    function check_email_availablity() {
        $email = trim($this->input->post('email'));
        $this->db->select('*');
        $this->db->from($this->tbl);
        $this->db->where('email', $email);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    ////////////////// login ////////////////////

    function login($tbl) {
        $this->db->where('user_id', $this->input->post('email'));
        $this->db->where('password', md5($this->input->post('password')));
        $this->db->where('status', 1);
        $query = $this->db->get($tbl);
        return $query;

    }

    function joinselect_arrayTable($select_data,$frmtbl, $table_array, $condition=null,$group_by=null,$orderBy=null,$result_as_array=null,$condition_or=null,$return_query=null)
    {
        $this->db->select($select_data);
        $this->db->from($frmtbl);
//        $rs = $this->db->get();


        $c=0;

        if(is_array($table_array)||is_object($table_array))
        foreach($table_array as $tbl)
        {

            $tbl2=$tbl['tbl2'];
            $alice2='';
            if(strpos($tbl2,':'))
            {
                $temp=explode(':',$tbl2);

                $tbl2=$temp[0];
                $alice2=$temp[1];
            }else if(strpos($tbl2,' '))
            {
                $temp=explode(' ',$tbl2);

                $tbl2=$temp[0];
                $alice2=$temp[1];
            }
            if($alice2=='')
            {
                $alice2=$tbl['tbl2'];
            }
            if($c==0)
                if($tbl['type']==null)
                    $this->db->join($tbl['tbl2'], $tbl['tbl2'] . '.' . $tbl['field2'] . '=' . $tbl['tbl'] . '.' . $tbl['field']);
                else
                    $this->db->join($tbl2.' '.$alice2, $alice2. '.' .$tbl['field2'] . '=' . $tbl['tbl'] . '.' . $tbl['field'],$tbl['type']);
        }

        if(isset($condition[0]))
        {
            foreach($condition as $t)
            {

                if(isset($t['operator']))
                {
                    if($t['operator']=='||')
                        $this->db->or_where($t['conditions']);
                    elseif($t['operator']=='&&')
                        $this->db->where($t['conditions']);
                }else
                {
                    $this->db->where($t);
                }
            }
        }else
        {
            if ($condition!=null)
                $this->db->where($condition);
        }

        if ($condition_or!=null)
            $this->db->or_where($condition_or);
        if($group_by!=null)
            $this->db->group_by($group_by);
        if($orderBy!=null)
            $this->db->order_by($orderBy);

        if($return_query)
        {
            return $this->db->get_compiled_select();
        }


        $query = $this->db->get();
        if ($query->num_rows() > 0) {

            if($result_as_array)
                return $query->result_array();
            else
                return $query->result();
        } else {

            return FALSE;
        }
    }


    function adminlogin($tbl) {

        $this->db->where('email', $this->input->post('email'));
        $this->db->where('password', md5($this->input->post('password')));
        $this->db->where('status', 1);
        $this->db->where('is_admin', 1);
        $query = $this->db->get($tbl);
        return $query;
    }

    function is_admin($tbl) {

        $this->db->select($this->session->userdata('user_id'));
        $this->db->from($this->tbl);
        $this->db->where('is_admin', 1);
        $query = $this->db->get($tbl);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return FALSE;
        }
    }



}
