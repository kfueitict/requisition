<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class admin extends CI_Controller {

    protected $tbl = 'cms';
    protected $field = 'cms_id';

    function __construct() {
        parent::__construct();

        //is_login_admin();
    }

    public function index() {

        $data['record'] = $this->generic_model->select($this->tbl);
        $this->load->view('admin/page_listing', $data);
    }
    public function setting() {
        $data['title'] = 'Setting';
        $data['page'] = $this->generic_model->selectwhere('setting', 'id', 1);
        $this->load->view('admin/setting', $data);
    }

    public function save_setting() {
        if ($this->input->post()) {
            $data = array(
                $this->input->post('field') => $this->input->post('setting')
            );
            $this->generic_model->update('setting', 'id', 1, $data);
            $this->session->set_flashdata('message', 'Record Update Successfully');
            redirect('cms/admin/setting');
        }
    }

    public function delete($id) {
        if ($this->generic_model->delete($this->tbl, $this->field, $id)) {
            $this->session->set_flashdata('message', 'Record Delete Successfully');
        }
        redirect('cms/admin');
    }

    function check() {
        $result = $this->input->post('email');
        if ($result) {
            echo $this->input->post('email');
        } else {
            echo $this->input->post('email');
        }
    }

    private function set_upload_options()
    {
        //upload an image options
        $config = array();
        $config['allowed_types'] = 'jpeg|png|jpg|gif';
        $config['upload_path'] = './uploads/cms/';
        $config['max_size']      = '0';
        $config['overwrite']     = FALSE;

        return $config;
    }

    function addpage() {

        if ($this->input->post()) {
            $data = array(
                'heading' => $this->input->post('heading'),
                'desc' => $this->input->post('desc'),
                'slug' => $this->input->post('slug'),
                'status' => 1
            );
            $this->load->library('upload');
            if ($_FILES['bg_image']['name'] != '') {
                $random = rand(3, 100);
                $file_name = date('YmdHmi') . $random;
                $ext = pathinfo($_FILES['bg_image']['name'], PATHINFO_EXTENSION);
                $img_file = $file_name .'.'. $ext;

                //$config['file_name'] = $img_file;
                $this->upload->initialize($this->set_upload_options());

                if (!$this->upload->do_upload('bg_image')) {
                    $error = array('error' => $this->upload->display_errors());
                    echo 'Image Error 1';
                    print_r($error);
                    exit;
                }
                $bg_image = $this->upload->data();
                $data+=array('bg_image' => $bg_image['file_name']);
            }
            $name_array = array();
            $files = $_FILES;
            $cpt = count($_FILES['images']['name']);
            for($i=0; $i<$cpt; $i++)
            {
                if($files['images']['name'][$i]!='') {
                    $_FILES['images']['name'] = $files['images']['name'][$i];
                    $_FILES['images']['type'] = $files['images']['type'][$i];
                    $_FILES['images']['tmp_name'] = $files['images']['tmp_name'][$i];
                    $_FILES['images']['error'] = $files['images']['error'][$i];
                    $_FILES['images']['size'] = $files['images']['size'][$i];

                    $this->upload->initialize($this->set_upload_options());
                    if (!$this->upload->do_upload('images')) {
                        $error = array('error' => $this->upload->display_errors());
                        echo 'Image Error';
                        print_r($error);
                        exit;

                    }
                    $data1 = $this->upload->data();
                    $name_array[] = $data1['file_name'];
                }
            }
            $names= implode(',', $name_array);
            if(count($name_array)>0)
                $data+=array('images' => $names);
            if ($this->generic_model->insert($this->tbl, $data)) {
                $this->session->set_flashdata('message', 'Record Add Successfully');
                redirect('cms/admin');
            }
        } else {
            $data['title'] = 'New Page';
            $data['button'] = 'Add';
            $this->load->view('cms/admin/add_edit', $data);
        }
    }

    function delete_img($id,$img,$isBg=null)
    {
        $news=$this->generic_model->selectwhere('cms', 'cms_id', $id);
        if($isBg)
        {
            $data=array('bg_image' => null);
        }else
        {
            $temp=explode(',',$news->images);
            if (($key = array_search($img, $temp)) !== false) {
                unset($temp[$key]);
            }
            $names= implode(',', $temp);
            if(count($temp)>0)
                $data=array('images' => $names);
            else
                $data=array('images' => '');
        }
        @unlink(FCPATH . '/uploads/cms/' . $img);
        $this->generic_model->update($this->tbl, 'cms_id', $id, $data);
        redirect($this->agent->referrer());
    }

    function editpage() {
        $id = $this->uri->segment(4);
        $data['title'] = 'Edit Page';
        $data['button'] = 'Save';
        $data['page'] = $this->generic_model->selectwhere('cms', 'cms_id', $id);
        $this->load->view('cms/admin/add_edit', $data);
        if ($this->input->post()) {
            $data = array(
                'heading' => $this->input->post('heading'),
                'desc' => $this->input->post('desc'),
            );
            $this->load->library('upload');
            if ($_FILES['bg_image']['name'] != '') {
                $random = rand(3, 100);
                $file_name = date('YmdHmi') . $random;
                $ext = pathinfo($_FILES['bg_image']['name'], PATHINFO_EXTENSION);
                $img_file = $file_name .'.'. $ext;

                //$config['file_name'] = $img_file;
                $this->upload->initialize($this->set_upload_options());

                if (!$this->upload->do_upload('bg_image')) {
                    $error = array('error' => $this->upload->display_errors());
                    echo 'Image Error 1';
                    print_r($error);
                    exit;
                }
                $bg_image = $this->upload->data();
                $data+=array('bg_image' => $bg_image['file_name']);
            }
            $img=$this->generic_model->selectwhere('cms', 'cms_id', $id);
            $temp=explode(',',$img->news_images);
            $name_array = array();
            $files = $_FILES;
            $cpt = count($_FILES['images']['name']);
            for($i=0; $i<$cpt; $i++)
            {
                if($files['images']['name'][$i]!='') {
                    $_FILES['images']['name'] = $files['images']['name'][$i];
                    $_FILES['images']['type'] = $files['images']['type'][$i];
                    $_FILES['images']['tmp_name'] = $files['images']['tmp_name'][$i];
                    $_FILES['images']['error'] = $files['images']['error'][$i];
                    $_FILES['images']['size'] = $files['images']['size'][$i];

                    $this->upload->initialize($this->set_upload_options());
                    if (!$this->upload->do_upload('images')) {
                        $error = array('error' => $this->upload->display_errors());
                        echo 'Image Error';
                        print_r($error);
                        exit;

                    }
                    $data1 = $this->upload->data();
                    $name_array[] = $data1['file_name'];
                }
            }
            $name_array=array_merge($name_array, $temp);
            $names= implode(',', $name_array);
            if(count($name_array)>0)
                $data+=array('images' => $names);
            $this->generic_model->update($this->tbl, 'cms_id', $id, $data);
            $this->session->set_flashdata('message', 'Record Update Successfully');
            redirect('cms/admin');
        }
    }

    function sliderimages() {
        $data['title'] = 'Slider Images';
        $data['records'] = $this->generic_model->select('slider_images');
        $this->load->view('admin/slider_images', $data);
    }
    function socialLinks() {
        $data['title'] = 'Social Links';
        $data['records'] = $this->generic_model->select('social_links');
        $this->load->view('admin/social_links', $data);
    }


    public function image_edit($id=null)
    {
        if( $this->input->post())
        {

            $config['upload_path'] = './uploads/slider';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']	= '0';
            $config['max_width'] = '0';
            $config['max_height'] = '0';
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);

            $config['image_library'] = 'gd2';
            $config['create_thumb'] = false;
            $config['maintain_ratio'] = false;
            $config['width']	= 1123;
            $config['height']	= 408;
            $config['quality']	= 100;
            $this->load->library('image_lib');

            $this->upload->initialize($config);

            $isActive = false;

            if ($this->input->post('status'))
                $isActive = true;


            $postdata = array(
                'status' => $isActive,
                'alt' => $this->input->post('alt'),
                'title' => $this->input->post('title'),
                'data_description' => $this->input->post('data_description'),
                'order' => $this->input->post('order')
            );

            if(is_numeric($this->input->post('update_id')))
            {
                if($_FILES['img_1']['name']!='')
                {
                    $temp = $this->generic_model->getWhere('slider_images','id',$id);
                    @unlink(FCPATH.'/uploads/slider/'.$temp[0]->img_src);

                    if ($this->upload->do_upload('img_1')) {

                        $data = array('upload_data' => $this->upload->data());
                        $photo = $data['upload_data']['raw_name'] . $data['upload_data']['file_ext'];
                        $config['source_image'] = $config['upload_path'].'/' . $photo;
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                        $postdata+=array('img_src' => $photo);

                    }
                    else
                    {

                        $this->session->set_flashdata('msg_error',$this->upload->display_errors());
                        $ref = $this->input->server('HTTP_REFERER', TRUE);
                        redirect($ref, 'location');
                    }

                }
                $this->generic_model->update('slider_images', 'id', $this->input->post('update_id'), $postdata);
                $this->session->set_flashdata('msg','Record updated Successfully');
                redirect(base_url('cms/admin/sliderimages'));
            }else
            {
                if($_FILES['img_1']['name']!='') {
                    if ($this->upload->do_upload('img_1')) {

                        $data = array('upload_data' => $this->upload->data());
                        $photo = $data['upload_data']['raw_name'] . $data['upload_data']['file_ext'];
                        $config['source_image'] = $config['upload_path'].'/' . $photo;
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                        $postdata += array('img_src' => $photo);

                    } else {

                        $this->session->set_flashdata('msg_error', $this->upload->display_errors());
                        $ref = $this->input->server('HTTP_REFERER', TRUE);
                        redirect($ref, 'location');
                    }
                }
                $this->generic_model->insert('slider_images',$postdata);
                $this->session->set_flashdata('msg','Record updated Successfully');
                redirect(base_url('cms/admin/sliderimages'));
            }


            $ref = $this->input->server('HTTP_REFERER', TRUE);
            redirect($ref, 'location');

        }
        if( $id==null)
        {
            $data['title'] = 'Add Images';
            $data['update_id'] = '';
            $this->load->view('admin/edit_slider_image', $data);
        }
        elseif(is_numeric($id))
        {
            $data['title'] = 'Edit Images';
            $data['records']= $this->generic_model->selectwhere('slider_images','id',$id);
            $data['update_id'] = $id;
            $this->load->view('admin/edit_slider_image', $data);
        }
    }

    public function social_edit($id=null)
    {
        if( $this->input->post())
        {

            $config['upload_path'] = './uploads/social';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']	= '0';
            $config['max_width'] = '0';
            $config['max_height'] = '0';
            $config['encrypt_name'] = true;
            $this->load->library('upload', $config);

            $config['image_library'] = 'gd2';
            $config['create_thumb'] = false;
            $config['maintain_ratio'] = false;
            $config['width']	= 32;
            $config['height']	= 32;
            $config['quality']	= 100;
            $this->load->library('image_lib');

            $this->upload->initialize($config);

            $isActive = false;

            if ($this->input->post('status'))
                $isActive = true;


            $postdata = array(
                'status' => $isActive,
                'show_in_header' => $this->input->post('show_in_header')?1:0,
                'show_in_site' => $this->input->post('show_in_site')?1:0,
                'show_in_footer' => $this->input->post('show_in_footer')?1:0,
                'alt' => $this->input->post('alt'),
                'title' => $this->input->post('title'),
                'url' => $this->input->post('url'),
                'order' => $this->input->post('order')
            );

            if(is_numeric($this->input->post('update_id')))
            {
                if($_FILES['img_1']['name']!='')
                {
                    $temp = $this->generic_model->getWhere('social_links','id',$id);
                    @unlink(FCPATH.'/uploads/social/'.$temp[0]->img_src);

                    if ($this->upload->do_upload('img_1')) {

                        $data = array('upload_data' => $this->upload->data());
                        $photo = $data['upload_data']['raw_name'] . $data['upload_data']['file_ext'];
                        $config['source_image'] = $config['upload_path'].'/' . $photo;
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                        $postdata+=array('img_src' => $photo);

                    }
                    else
                    {

                        $this->session->set_flashdata('msg_error',$this->upload->display_errors());
                        $ref = $this->input->server('HTTP_REFERER', TRUE);
                        redirect($ref, 'location');
                    }

                }
                $this->generic_model->update('social_links', 'id', $this->input->post('update_id'), $postdata);
                $this->session->set_flashdata('msg','Record updated Successfully');
                redirect(base_url('cms/admin/socialLinks'));
            }else
            {
                if($_FILES['img_1']['name']!='') {
                    if ($this->upload->do_upload('img_1')) {

                        $data = array('upload_data' => $this->upload->data());
                        $photo = $data['upload_data']['raw_name'] . $data['upload_data']['file_ext'];
                        $config['source_image'] = $config['upload_path'].'/' . $photo;
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                        $postdata += array('img_src' => $photo);

                    } else {

                        $this->session->set_flashdata('msg_error', $this->upload->display_errors());
                        $ref = $this->input->server('HTTP_REFERER', TRUE);
                        redirect($ref, 'location');
                    }
                }
                $this->generic_model->insert('social_links',$postdata);
                $this->session->set_flashdata('msg','Record updated Successfully');
                redirect(base_url('cms/admin/socialLinks'));
            }


            $ref = $this->input->server('HTTP_REFERER', TRUE);
            redirect($ref, 'location');

        }
        if( $id==null)
        {
            $data['title'] = 'Add Link';
            $data['update_id'] = '';
            $this->load->view('admin/edit_social_links', $data);
        }
        elseif(is_numeric($id))
        {
            $data['title'] = 'Edit Link';
            $data['records']= $this->generic_model->selectwhere('social_links','id',$id);
            $data['update_id'] = $id;
            $this->load->view('admin/edit_social_links', $data);
        }
    }


    public function deleteSocialLink($id) {

        if (is_numeric($id)) {
            $temp = $this->generic_model->getWhere('social_links','id',$id);
            @unlink(FCPATH.'/uploads/social/'.$temp[0]->img_src);
            $this->generic_model->delete('social_links', 'id', $id);
            $this->session->set_flashdata('message', 'Record Deleted Successfully');
            $ref = $this->input->server('HTTP_REFERER', TRUE);
            redirect($ref, 'location');
        } else {
            $this->session->set_flashdata('message', 'going something wrong...');
            $ref = $this->input->server('HTTP_REFERER', TRUE);
            redirect($ref, 'location');
        }
    }

    public function deleteslideimg($id) {

        if (is_numeric($id)) {
            $temp = $this->generic_model->getWhere('slider_images','id',$id);
            @unlink(FCPATH.'/uploads/slider/'.$temp[0]->img_src);
            $this->generic_model->delete('slider_images', 'id', $id);
            $this->session->set_flashdata('message', 'Record Deleted Successfully');
            $ref = $this->input->server('HTTP_REFERER', TRUE);
            redirect($ref, 'location');
        } else {
            $this->session->set_flashdata('message', 'going something wrong...');
            $ref = $this->input->server('HTTP_REFERER', TRUE);
            redirect($ref, 'location');
        }
    }

    function change()
    {
        $postdata = array(
            $this->input->post('field') => $this->input->post('value')
        );
        $this->generic_model->update($this->input->post('tbl')?$this->input->post('tbl'):'slider_images', 'id', $this->input->post('id'), $postdata);
    }

    public function map() {

        if ($this->input->post()) {

            $data = array(
                $this->input->post('map_title') => $this->input->post($this->input->post('map_title')),
                $this->input->post('map_url') => $this->input->post($this->input->post('map_url'))
            );
            $this->generic_model->update('setting', 'id', 1, $data);
            //$this->session->set_flashdata('message', 'Record Update Successfully');
            echo $this->input->post($this->input->post('map_title')).' Map Update Successfully';
            return;
            //redirect('cms/admin/map');
        }

        $data['title'] = 'Map Setting';
        $data['page'] = $this->generic_model->selectwhere('setting', 'id', 1);
        $this->load->view('admin/map', $data);
    }

    public function slugify($txt=null)
    {
        $text= @$this->input->post('txt');
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
            return 'n-a';
        }
        $tbl='cms';
        if($this->input->post('tbl'))
        {
            $tbl=$this->input->post('tbl');
        }

        if(!isset($this->session->userdata['tbl']))
        {
            $this->session->set_userdata('tbl', $tbl);
        }else
        {
            $tbl=$this->session->userdata('tbl');
        }

        if(!$this->generic_model->selectwhere($tbl, 'slug', $text))
        {
            $this->session->unset_userdata('tbl');
            echo $text;
            //return;
        }else
            $this->slugify($text.'-'.rand(1,999));
    }
}
