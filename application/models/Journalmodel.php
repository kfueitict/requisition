<?php
    class Journalmodel extends CI_Model
    {
        public function get_journal()
        {
            $query = $this->db->select('*')
                                ->from('journal_tbl')
                                ->get()
                                ->result_array();
            return $query;
        }
        
        public function filter_journal($j_Name)
        {
            $sql = $this->db->select('drn, title, status')
							->from( 'add_paper' )
							->where( 'title', $j_Name )
							->get();
            
			if( $this->db->affected_rows() > 0 ){
				return $this->db->affected_rows();
            }
			else{
				return FALSE;
            }
        }
        
        public function save_journal($j_Name, $username)
        {
           $submt_time = date('Y-m-d H:i:s');
                
            $data = array(
                        'title' => $j_Name,
                        'date' => $submt_time,
                        'log' => $username, 
                        );
            $result = $this->db->insert( 'journal_tbl',$data  );
            if($result > 0)
                return true;
            else
                return false; 
        }
        
        public function save_res_paper($d_resNo, $jName, $status, $username)
        {
            $d_time = date('Y-m-d H:i:s');
                
            $data = array(
                        'drn' => $d_resNo,
                        'title' => $jName,
                        'req_date' => $d_time,
                        'status' => $status,
                        'req_log' => $username,
                        );
            $result = $this->db->insert( 'add_paper',$data  );
            if($result > 0)
                return true;
            else
                return false;
        }
        
        public function getallreq()
        {
            $result =  $this->db->select('*')
                                    ->from('add_paper')
                                    ->where('status', 'pending')
                                    ->get()
                                    ->result_array();
            return $result;
        }
        
        public function getfilter_record($num)
        {
          $result =  $this->db->select('*')
                                    ->from('add_paper')
                                    ->where('status', $num)
                                    ->get()
                                    ->result_array();
            return $result;
        }
        
        public function save_file($postID, $date_time, $status, $url, $username)
        {
           $data = array(
                        'active_date' => $date_time,
                        'status' => $status,
                        'file' => $url,
                        'file_upload_log' => $username,
                        ); 
                    $this->db->where('drn', $postID);
               if( $this->db->update('add_paper', $data))
               {
                   return $this->db->affected_rows();
               }
                else{
                    return false;
                }
        }
        
        public function get_download_files()
        {
            $query = $this->db->select('drn, title, active_date, file')
                                ->from('add_paper')
                                ->where('status', 'active')
                                ->get()
                                ->result_array();
            return $query;
        }
        
    public function check_drn( $num )
	{
		$sql = $this->db->select('drn, title, status')
							->from( 'add_paper' )
							->where( 'drn', $num )
							->get();

			if( $this->db->affected_rows() > 0 ){
				return $sql->result_array();
            }
			else{
				return FALSE;
            }
	   }
        
        public function validate($username, $password)
        {
            $query = $this->db->select('ID, UserName, type')
                             ->from( 'login_tbl' )
                             ->where( ['UserName'=>$username, 'Password'=>$password] )
                             ->get();

                      if( $query->num_rows() ){
                       return $query->result();
                      }
                    else{
                        return false;
                    }
        }
        
        public function count_record($tbl, $field_name, $field_val)
        {
            $query = $this->db->select('*')
                                ->from($tbl)
                                ->where($field_name, $field_val)
                                ->get()
                                ->num_rows();
            return $query;
        }
        
        public function get_usertype($id)
        {
            $status = 'Active';
            $scale = 17;
            $bps = 'bps';
            $this->db->select(' m.title as dept_name, d.title as designation, d.bps as scale, e.name as name, e.is_teaching as teaching');
            $this->db->from('employees e'); 
            $this->db->join('designations d', 'd.id= e.designation', 'inner');
            $this->db->join('departments m', 'm.id = e.department', 'inner');
            $this->db->where('e.emp_no',$id );
            $this->db->where('d.bps >=', $scale );
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
		
		public function select_stmt($tbl,$conditions,$orderBy,$limit,$start)
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
           		return $query->result_array();
        	} else {
            	return FALSE;
        	}
		}
        
        
    }