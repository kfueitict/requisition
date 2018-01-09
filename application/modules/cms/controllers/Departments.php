<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Departments extends CI_Controller {

   protected  $tbl_Departments='departments';

    function __construct()
    {
        parent::__construct();
        is_dr_user();
    }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */


    public function index()
	{
        $data['departments']=generic_select('departments');
        $this->load->view('dept_listing',$data);
	}

    public function dashboard()
    {
        $this->load->view('dashboard');
    }
    public function upload()
    {
        $callback = 'null';
        $url = '';
        $get = array();

        $qry = $_SERVER['REQUEST_URI'];
        parse_str(substr($qry, strpos($qry, '?') + 1), $get);

        if (!isset($_POST) || !isset($get['CKEditorFuncNum'])) {
            $msg = 'CKEditor instance not defined. Cannot upload image.';
        } else {
            $callback = $get['CKEditorFuncNum'];

            try {

                $config['upload_path'] = './uploads/departments';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']	= '0';
                $config['max_width'] = '0';
                $config['max_height'] = '0';
                $config['encrypt_name'] = true;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if ($this->upload->do_upload('upload')) {

                    $data = array('upload_data' => $this->upload->data());
                    $photo = $data['upload_data']['raw_name'] . $data['upload_data']['file_ext'];
                    $url=base_url('uploads/departments/'.$photo);
                    $msg = "File uploaded successfully to: {$url}";
                }else
                {
                    $msg = $this->upload->display_errors();
                }


            } catch (Exception $e) {
                $url = '';
                $msg = $e->getMessage();
            }
        }

        // Callback function that inserts image into correct CKEditor instance
        $output = '<html><body><script type="text/javascript">' .
            'window.parent.CKEDITOR.tools.callFunction(' .
            $callback .
            ', "' .
            $url .
            '", "' .
            $msg .
            '");</script></body></html>';

        echo $output;
    }

    public function crud($id=null,$key=null)
    {
        if($this->input->post())
        {

            $postData=array(
                'title'=>$this->input->post('title'),
                'description'=>$this->input->post('description')
            );
            if($this->input->post('update_id')){

                update_db($this->tbl_Departments,'id',$this->input->post('update_id'),$postData);
                $this->session->set_flashdata('message','Department Updated successfully');
                redirect(base_url('cms/departments'));

            }else
            {
                $slug=slug_genrator($this->input->post('title'),'departments');
                $postData=$postData+array('slug'=>$slug );
                if(insert_db($this->tbl_Departments,$postData))
                {
                    $id=$this->db->insert_id();
                    $user_departments=getSingle('users','departments','user_id','admin');
                    if(!empty($user_departments))
                    {
                        $user_departments.=",".$id;
                        update_db('users','user_id','admin',array('departments'=>$user_departments));
                    }
                    $this->session->set_flashdata('message','Department added successfully');
                    redirect(base_url('cms/departments'));
                }


            }
        }else
        {
            if($id==null&&$key==null)
            {
                $data['title']='Add Department';
                $data['button']='Add Department';
                $data['types']=generic_select('departments');
                $this->load->view('dept_cu',$data);
            }else if($id!=null&&$key==null)
            {
                $data['title']='Edit Department';
                $data['button']='Save';
                $data['type']=generic_select_row($this->tbl_Departments,array('slug'=>$id));

                if(is_array($data['type'])||is_object($data['type']))
                {
                    $this->load->view('dept_cu',$data);

                }else
                    redirectToReffrer();
            }else if($id&&$key=='delete')
            {
                if(delete_db($this->tbl_Departments,'slug',$id))
                {
                    $this->session->set_flashdata('message','Department Deleted successfully');
                    redirect('cms/departments');
                }
            }
        }
    }

    public function faculty_crud($id=null,$key=null)
    {
        if($this->input->post())
        {
            $config['upload_path'] = './uploads/faculty';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size']	= '0';
            $config['max_width'] = 300;
            $config['max_height'] = 300;
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            $postData=array(
                'title'=>$this->input->post('title'),

                'description'=>$this->input->post('description'),
                'short_description'=>$this->input->post('short_description'),
                'department_id'=>$this->input->post('department'),

            );
            if($_FILES['img']['name']!='')
            {



                if ($this->upload->do_upload('img')) {

                    $data = array('upload_data' => $this->upload->data());
                    $photo = $data['upload_data']['raw_name'] . $data['upload_data']['file_ext'];

                    $postData+=array('img' => $photo);
                    @unlink(FCPATH.'/uploads/faculty/'.$this->input->post('old_img'));
                }
                else
                {

                    $this->session->set_flashdata('message',$this->upload->display_errors());
                    $ref = $this->input->server('HTTP_REFERER', TRUE);
                    redirect($ref, 'location');
                }

            }


            if($this->input->post('update_id')){

                update_db('faculty','id',$this->input->post('update_id'),$postData);
                $this->session->set_flashdata('message','User Updated successfully');
                redirect(base_url('cms/departments/faculty'));

            }else
            {

                if(insert_db('faculty',$postData+array('slug'=> slug_genrator($this->input->post('title'),'faculty'))))
                {
                    $this->session->set_flashdata('message','User added successfully');
                    redirect(base_url('cms/departments/faculty'));
                }
            }
        }else
        {
            if($id==null&&$key==null)
            {
                $data['title']='Add Member';
                $data['button']='Add Member';
                $data['department']=generic_select('departments');
                $this->load->view('fac_cu',$data);
            }else if($id!=null&&$key==null)
            {
                $data['title']='Edit Member';
                $data['button']='Save';
                $data['department']=generic_select('departments');
                $data['user']=generic_select_row('faculty',array('slug'=>$id));
                if(is_array($data['user'])||is_object($data['user']))
                {
                    $this->load->view('fac_cu',$data);

                }else
                    redirectToReffrer();
            }else if($id&&$key=='delete')
            {
                if(delete_db('faculty','slug',$id))
                {
                    $this->session->set_flashdata('message','Member Deleted successfully');
                    redirect(base_url('cms/departments/faculty'));
                }
            }
        }
    }

    public function faculty($id=null,$key=null)
    {

        $data['departments']=join_select_Table_array('faculty.*,departments.title as department','faculty',array(
            array(
                'tbl'=>'faculty',
                'field'=>'department_id',
                'tbl2'=>'departments',
                'field2'=>'id',
                'type'=>'left',
            )
        ));
        $this->load->view('fac_listing',$data);

    }

}
