<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Designations extends CI_Controller {

   protected  $tbl_Departments='designations_tbl';

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
        $data['designations']=generic_select('designations_tbl');
        $this->load->view('desg_listing',$data);
	}

    public function dashboard()
    {
        $this->load->view('dashboard');
    }


    public function crud($id=null,$key=null)
    {
        if($this->input->post())
        {

            $postData=array(
                'title'=>$this->input->post('title'),
                'bps'=>$this->input->post('bps')
            );
            if($this->input->post('update_id')){

                update_db($this->tbl_Departments,'id',$this->input->post('update_id'),$postData);
                $parent_id=$this->input->post('update_id');
                $postDetail=null;
                for($i=0;$i<count($this->input->post('heading'));$i++)
                {
                    if(!(
                        $this->input->post('heading')[$i]==''
                    )) {

                        $slug=slug_genrator($this->input->post('heading')[$i],'designations_tbl');
                        $postDetail[] = array(
                            'slug' =>$slug,
                            'title' => $this->input->post('heading')[$i],
                            'genders' => $this->input->post('genders')[$i],
                            'bps' => $this->input->post('ad_bps')[$i],
                            'parent_id'=>$parent_id
                        );
                    }
                }
                if(count($postDetail)>0)
                {
                    insert_db('designations_tbl',$postDetail,true);
                }
                $this->session->set_flashdata('message','Designation Updated successfully');
                redirect(base_url('cms/designations'));

            }else
            {
                $slug=slug_genrator($this->input->post('title'),'designations_tbl');
                $postData=$postData+array('slug'=>$slug );
                if(insert_db($this->tbl_Departments,$postData))
                {
                    $this->session->set_flashdata('message','Designation added successfully');
                    redirect(base_url('cms/designations'));
                }
            }
        }else
        {
            if($id==null&&$key==null)
            {
                $data['title']='Add Designation';
                $data['button']='Add Designation';
                $data['types']=generic_select('designations_tbl');
                $this->load->view('desg_cu',$data);
            }else if($id!=null&&$key==null)
            {
                $data['title']='Edit Designation';
                $data['button']='Save';
                $data['type']=generic_select_row($this->tbl_Departments,array('slug'=>$id));
                $data['additional_bps']=join_select_Table_array('*','designations_tbl',null,array("parent_id"=>$data['type']->id));

                if(is_array($data['type'])||is_object($data['type']))
                {
                    $this->load->view('desg_cu',$data);

                }else
                    redirectToReffrer();
            }else if($id&&$key=='delete')
            {
                if(delete_db($this->tbl_Departments,'slug',$id))
                {
                    $this->session->set_flashdata('message','Designation Deleted successfully');
                    redirect('cms/designations');
                }
            }
        }
    }

    public function additional_bps(){
        if(empty($_POST['designation']))
        {
            echo "<option value=''>NA</option>";
            die;
        }
        $response="<option value=''>NA</option>";
        $rows=join_select_Table_array('*','designations_tbl',null,array(
            "parent_id={$_POST['designation']} and (genders={$_POST['gender']} or genders=0)"
        ));
        if(is_array($rows)||is_object($rows))
        {
            $response="<option value=''>Select Additional BPS</option>";
            foreach($rows as $row)
            {
                $response.="<option value='$row->id'>$row->bps-$row->title</option>";
            }
        }

        echo $response;die;

    }



}
