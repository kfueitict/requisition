<?php

class Items extends CI_Controller {

    protected $dept='';
    protected $emp_id=null;

    function __construct() {

        parent::__construct();
        //$this->output->enable_profiler(TRUE);
        is_login();
        $this->load->model('cms/leaves_model');
        $this->dept=getSingle('users','departments','id',$this->session->userdata('id'));
        if(empty($this->dept))
        {
            $this->dept=-1;
            $this->emp_id=$this->session->userdata('emp_id');
        }else
        {
            if($this->session->userdata('emp_id'))
            $this->emp_id = $this->session->userdata('emp_id');
        }

        if($this->dept==-1 && empty($this->emp_id))
            redirectToReffrer();
    }

    function index() {
        $this->load->view('dashboard');
    }

    public function getCart(){
        $this->load->view('cart_items');
    }

    public function status($parm){

        $statusArray=array(
            "in-process"=>0,
            "approved"=>1,
            "rejected"=>2,
            "in-procurement"=>3,
            "partial-approved"=>9,

        );
        $statusArrayTitle=array(
            "in-process"=>"Requests in Process",
            "approved"=>"Approved Requests",
            "rejected"=>"Rejected Requests",
            "in-procurement"=>"In Procurement",
            "partial-approved"=> "Partial Approved Requests"
        );
        if(isset($statusArray[$parm])){
            $data['title']= $statusArrayTitle[$parm];
            if($this->dept==-1)
            {
                $conditions=array('emp_id'=>$this->session->userdata('emp_id'),'leave_req.status'=>$statusArray[$parm]);
            }
            else
            {
                $conditions=array(" emp.department in ($this->dept) and leave_req.status=$statusArray[$parm]");
            }
            $data['leaves']=join_select_Table_array('emp.slug,emp.name,emp.emp_no,leave_req.id,request_date,locked','leave_req',array(
                array(
                    'tbl'=>'leave_req',
                    'field'=>'emp_id',
                    'tbl2'=>'employees emp',
                    'field2'=>'id',
                    'type'=>null,
                )
            ),$conditions,null,null,null,null,null);

            $this->load->view('leave_listing',$data);
        }else
        {
            redirectToReffrer('Invalid input','message-error');
        }
    }
    public function ispartial($parm){

        $statusArray=array(
            "partial-approved"=>1,

        );
        $statusArrayTitle=array(
            "partial-approved"=> "Partial Approved Requests"
        );
        if(isset($statusArray[$parm])){
            $data['title']= $statusArrayTitle[$parm];
            if($this->dept==-1)
            {
                $conditions=array('emp_id'=>$this->session->userdata('emp_id'),'leave_req.ispartial'=>$statusArray[$parm]);
            }
            else
            {
                $conditions=array(" emp.department in ($this->dept) and leave_req.ispartial=$statusArray[$parm]");
            }
            $data['leaves']=join_select_Table_array('emp.slug,emp.name,emp.emp_no,leave_req.id,request_date,locked','leave_req',array(
                array(
                    'tbl'=>'leave_req',
                    'field'=>'emp_id',
                    'tbl2'=>'employees emp',
                    'field2'=>'id',
                    'type'=>null,
                )
            ),$conditions,null,null,null,null,null);

            $this->load->view('leave_listing',$data);
        }else
        {
            redirectToReffrer('Invalid input','message-error');
        }
    }
    public function wizard()
    {
        $data['css']=array(
            "plugins/wizard/css/gsdk-bootstrap-wizard.css",
            "plugins/select2/select2.min.css",
        );
        $data['js']=array(
            "plugins/wizard/js/gsdk-bootstrap-wizard.js",
            "plugins/wizard/js/jquery.validate.min.js",
            "plugins/select2/select2.full.min.js",
        );

//        $this->load->library('parser');
//        $ar = "array(4) { [0]=> array(2) { [\"id\"]=> string(9) \"Sales Tax\" [\"c_elementvalue_id\"]=> string(7) \"1000646\" } [1]=> array(2) { [\"id\"]=> string(10) \"Income Tax\"[\"c_elementvalue_id\"]=> string(7) \"1000647\"} [2]=> array(2) { [\"id\"]=> string(8) \"Security\" [\"c_elementvalue_id\"]=> string(7) \"1000649\" } [3]=> array(2) { [\"id\"]=> string(3) \"PST\" [\"c_elementvalue_id\"]=> string(7) \"1000648\" } }";
//        $this->parser->parse('wizard',$ar);
//        var_dump( $this->parser->parse($ar));
//        exit;



        $emp_criteria=array('job_status'=>'Active');
        if($this->dept!=-1 && empty($this->emp_id))
        {
            $emp_criteria=array(" job_status='Active' and  emp.department in($this->dept)");
        }else if(!empty($this->emp_id))
        {
            $emp_criteria=$emp_criteria+array('emp.id'=>$this->emp_id);
        }
        $data['employees']=join_select_Table_array('emp.title,emp.slug,emp_no,emp.name,emp.id,des.bps,des.title as designation,dept.title as department',
            'employees emp',
            array(
                array(
                    'tbl'=>'emp',
                    'field'=>'designation',
                    'tbl2'=>'designations des',
                    'field2'=>'id',
                    'type'=>null
                ),array(
                'tbl'=>'emp',
                'field'=>'department',
                'tbl2'=>'departments dept',
                'field2'=>'id',
                'type'=>null
            )
            ),$emp_criteria
        );

        $data['list_cat']=generic_select('products_category');

        $this->load->view('wizard',$data);
    }

    function addToCart()
    {
      try
        {
            $data = array(
                'id'      => $this->input->post('item_id'),
                'qty'     => $this->input->post('item_count'),
                'price'   => 40.95,
                'name'    => $this->input->post('item_name'),
                'options' => array('i_reason' => $this->input->post('reason'))
            );

            $rid =  $this->cart->insert($data);
            echo $this->getCartItems();
        }
        catch(Exception $x){

       echo "error132";
      }
    }

    function getCartItemsReady(){

          echo $this->getCartItems();
    }

    function getCartItems(){

           $i = 1;
           $result='';

             foreach ($this->cart->contents() as $k=>$items):

                $result.= form_hidden($i.'[rowid]', $items['rowid']);

                $result.="<tr><td  style='width:35%'><p>".$items['name']."</p></td>";
                  $result.="<td  style='width: 5px!important;'>"
                .form_input(array('name' => $i.'[qty]', 'value' => $items['qty'], 'maxlength' => '4', 'size' => '1','type' => 'number', 'class'=> 'qty form-control','id'=> $items['rowid']))
                ."</td>";

                        if ($this->cart->has_options($items['rowid']) == TRUE):
                            $result.="<td style='width:20%'>";

                            foreach ($this->cart->product_options($items['rowid'])  as $option_name => $option_value):

                               $result.="<span>".$option_value."</span>";

                            endforeach;
                            $result.="</td>";
                        endif;
$pic ='';

                            $da = get_data('http://10.1.0.4:9090/erp/products.php');
                            $json1 = json_decode($da, true);
                            $arraryValue = array_search($items['id'], array_column($json1, 'm_product_id'));
                            $pic = $json1[$arraryValue]['sku'];

                            if($pic != '') {
                                //$result .= "<td style='width='30%'><img style=\"height: 35px;width: 35px;\" src='" . base_url() . "assets/products/" . $pic . ".png'  /></td>";
                                $result .= "<td style='width='30%'><a class=\"fancybox\" href='" . base_url() . "assets/products/" . $pic . ".png' data-fancybox-group=\"gallery\" ><img data-fancybox-group=\"thumb\" style=\"height: 35px;width: 35px;\" src='" . base_url() . "assets/products/" . $pic . ".png'  /></a></td>";
}                            else{
                                // $result .= "<td style='width='30%'><img style=\"height: 35px;width: 35px;\" src='" . base_url() . "assets/products/logokfuiet.jpg'  /></td>";
                                $result .= "<td style='width='30%'><a class=\"fancybox\" href='" . base_url() . "assets/products/logokfuiet.jpg' data-fancybox-group=\"gallery\" ><img style=\"height: 35px;width: 35px;\" src='" . base_url() . "assets/products/logokfuiet.jpg'  /></a></td>";
                             }

//                        if ($items['options']['i_reason']==NULL || $items['options']['i_reason']==""):
//                            $result.="<td>";
//                            $result.="<span>".$items['options']['i_reason']."</span>";
//                            $result.="</td>";
//                            endif;

                   $result.="<td style='width:10%'><div class='text-center'><a href='#' id='updateCart' class='btn  btn-fill btn-info btn-sm' value=".$items['rowid']." role='button'><i class='fa fa-edit'></i></a>
                             <a href='#' id='deleteCart' class='btn  btn-fill btn-warning btn-sm' role='button' value=".$items['rowid']." ><i class='fa fa-close'></i></a><div></td>";
                $i++;

            endforeach;

    return $result;
    
 }

    /**Update Card item in requisition stat*/
    function updateCart(){

     $row = $this->input->post('rownumber');
     $value  = $this->input->post('value');
     $data = array(
         'rowid' =>  $row,
         'qty'   => $value
     );
     $this->cart->update($data);
        echo 'success';
    }

    function approveItem(){
     $row = $this->input->post('rownumber');
     $value  = $this->input->post('value');
     $appr  = $this->input->post('approve');

     $data = array(
         'rowid' =>  $row,
         'qty'   => $value,
         'comment'   => $appr
     );

    try {
        update_db('leave_req_body', 'rowid', $row,$data);
        echo 'success';
    }
        catch (exception $ex){
            echo 'error';
        }
    }

    function popDetail(){
      $id  = $this->input->post('idnumber');
      //$id  = '50014';
      try {

            $whereClass ="where id in( ".$id.")";
            $res =  custom_query("select t1.name,t2.request_date ,t1.qty as qty, t2.status from mis_leave_req_body as t1 inner join mis_leave_req as t2 on t1.req_id = t2.id where t1.id = $id" , true);

            $table = '<table class="table table-sm"><thead><tr><th>Name</th><th>Date</th><th>Qty</th><th>Status</th></tr></thead><tbody>';

            foreach ($res as $re){
                if($re['status'] == 1){
                    $status = '<span class="label label-success">Approved</span>';
                }else
                {
                    $status = '<span class="label label-danger">In Process</span>';
                }

                $table .='<tr><th scope="row">'.$re['name'].'</th><td>'.$re['request_date'].'</td><td>'.$re['qty'].'</td><td>'.$status.'</td></tr>';
            }

            $table .='</tbody></table>';


            echo $table;
          }
       catch (exception $ex){
            echo 'error';
          }
    }

    /**
     * @param $id
     */
    function history($id){
        try {
             $whereclass = "where emp_id = " .$id;
            $res =  custom_query("SELECT username,emp_id,request_date,reason,status  FROM `mis_leave_req` $whereclass order by request_date desc" , true);


            $table = '<table class="table table-bordered table-responsive"><thead><tr><th>Name</th><th>Date</th><th>Reason</th><th>Status</th></tr></thead><tbody>';
            foreach ($res as $re){
                if($re['status'] == 1){
                    $status = '<span class="label label-success">Approved</span>';
                }else
                {
                    $status = '<span class="label label-danger">In Process</span>';
                }

                $table .='<tr><th scope="row">'.$re['username'].'</th><td>'.$re['request_date'].'</td><td>'.$re['reason'].'</td><td>'.$status.'</td></tr>';
            }

            $table .='</tbody></table>';


            echo $table;
        }
        catch (exception $ex){
            echo 'error';
        }
    }

    /**
     *This function will delete items from db to facilitate hods to make update in request
     */
    function deleteItem(){

        $row = $this->input->post('rownumber');
        $data = array(
            'rowid' =>  $row,
            'qty'   => 0,
        );
        if($this->cart->update($data) == 1){

            echo 'success';
        }
        else{
            echo 'error';
        }
    }

   public function getProducts(){
        $catid = $this->input->post('category_id');
        $data['cat_query'] = generic_select('products',array('catid'=>$catid));
        $ret = json_encode($data);
        echo $ret;
    }
    //get content from service
}

    function get_data($url) {

        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }