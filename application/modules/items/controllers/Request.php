<?php

class Request extends CI_Controller {

    protected $dept='';
    protected $emp_id='';

    /**
     * Request constructor.
     */
    function __construct() {

        parent::__construct();
        is_login();
        $this->load->library('html2pdfl');


            //$link1 = 'http://10.1.0.4:9090/erp/products.php';
       // $link2 = 'http://10.1.0.4:9090/erp/stock.php';
       // $returned_content1 = get_data($link1);
     //   $returned_content2 = get_data($link2);

        // Convert JSON string to Array
        //$someArray1 = json_decode($returned_content1, false);
        //$someArray2 = json_decode($returned_content2, false);
        //foreach($someArray1 as $key => $value) {
          //   'Product ID'.$value->m_product_id . ", " . $value->stock . "<br>";
           //}
        //foreach($someArray1 as $key => $value1) {
          //   $value1->m_product_id . ", " . $value1->sku . ", " . $value1->productname . ", " . $value1->categoryname . ", " . $value1->m_product_category_id . ", " . $value1->price .  "<br>";

             /****************************** This line of code will use to insert data using service in product table*****************************************************/
            // $data =custom_query("insert into mis_products values ('" . $value1->m_product_id . "' , '" . $value1->sku . "' , '" . $value1->productname . "' , '" . $value1->m_product_category_id . "' ,'" . $value1->price . "')");

             /****************************** This line of code will use to insert data using service in category table*****************************************************/
            //$data =custom_query("insert into mis_products_category values ('" . $value1->m_product_category_id . "' , '" . $value1->categoryname . "')");
        //}
             // foreach ($someArray2 as $key => $value2){
             //   custom_query('update mis_products set stock ='.$value2->stock. ' where id = '.$value2->m_product_id.'');
             // }

        #getting
        $this->dept=getSingle('users','departments','id',$this->session->userdata('id'));
        if(empty($this->dept))
        {
            $this->dept=-1;
            $this->emp_id=$this->session->userdata('emp_id');
        }
        $ar=explode(',',$this->dept);
        $e_id=null;
        if(!empty($_GET['emp']))
        {
            $e_id=$_GET['emp'];
        }
        else if($this->input->post('employee')){
            $e_id=$this->input->post('employee');
        }
        if($this->dept!=-1 && !empty($e_id))
        {
            $emp_id=getSingle('employees','department','slug',$e_id);
            if(!in_array($emp_id,$ar))
                redirectToReffrer();
            $this->emp_id=getSingle('employees','id','slug',$e_id);
        }
        if($this->dept==-1&&empty($this->emp_id))
            redirectToReffrer();

        if($this->input->post())
        {
            $this->_submit();
        }
    }

    private function _submit()
    {
        if($this->input->post('step')==1){
            $emp = generic_select_row('employees',array('id'=>$this->session->userdata('emp_id')));

            $hod = $this->_findImmediateHOD($emp->department);
            if($hod == $this->session->userdata('emp_id')) {
                $hod = $this->_findImmediateHOD($this->_findParentDept($this->_findDepartmentId($this->session->userdata('emp_id'))));
            }
            if ($this->input->post())
            {
                $req_data = array(
                    'emp_id'=> $emp->id,
                    'username' => $this->session->userdata('username'),
                    'status' => 0,
                    'request_date' => date("Y-m-d H:i:s"),
                    'reason' => $this->input->post_get('reason')
                );
            }
//            if($emp->id==$hod && $hod!=448)
//            {
//                //$hod=$this->_findImmediateReportingHead($this->_findParentDept($emp->department),true);
//                $hod=448;// if applicant is HOD then request forward to VC direct
//            }
//            else
//            {
//                $hod=$this->_findImmediateReportingHead($emp->department,true);
//
//                if($emp->id==$hod)
//                {
//                    $hod=$this->_findImmediateHOD($emp->department);
//                }
//                else
//                {}
//            }
            if(insert_db('leave_req',$req_data)){
                $id = $this->db->insert_id();
              //  print_r($this->cart->contents());exit;
                foreach($this->cart->contents() as $value)
                {
                    $value = array(
                        'req_id' => $id,
                        'id'      => $value['id'],
                        'qty'     =>  $value['qty'],
                        'balance_qty'     =>  $value['qty'],
                        'price'   => $value['price'],
                        'name'    => $value['name'],
                        'coupon'  => 'XMAS-50OFF',
                        'rowid' => $value['rowid'],
                        'reason' => $value['options']['i_reason']
                      );

                    $this->cart->update($value);

                    insert_db('leave_req_body',$value);

                    $value = array(
                        'qty'     =>  0,
                        'rowid' => $value['rowid'],
                    );
                    $this->cart->update($value);
                }

                $postData=[
                    'req_id'=>$id,
                    'transaction_date' => date("Y-m-d H:i:s"),
                    'emp_id' => $this->session->userdata('emp_id'),
                    'comments' => $this->input->post('reason'),
                    'username'=>$this->session->userdata('username'),
                    'next_step'=>$hod
                ];
                if(insert_db('leave_req_transactions',$postData))
                {
                    //send email notification to applicant and next authority
                    //Temp Disapled
                    send_email_applicant($id);
                   send_email_next_authority($id);
                  customRedirect('items','Item(s) Requisition has been submitted successfully');
                }
                else
                {
                    delete_db('leave_req','id',$id);
                    redirectToReffrer(implode(' ',$this->db->errors()),'message-error');
                }

            }else
            {
                redirectToReffrer(implode(' ',$this->db->errors()),'message-error');
            }
        }
        else if($this->input->post('step')=='task_listing')
        {
            if(!$this->input->post('req_id')== '') {

                foreach ($this->input->post('req_id') as $rq_id) {

                    $data = array(
                        'request_id' => $rq_id,
                        'comments' => '',
                        'status' => $this->input->post('status')
                    );
                    $post_result = $this->_submit_request($data);

                    if ($post_result['status'] == false) {
                        customRedirect('items/request/tasks/pending', $post_result['msg'], 'message-error');
                    } else {
                        customRedirect('items/request/tasks/pending', 'Request(s) Proceeded Successfully');
                    }
                }
            }else{

                customRedirect('items/request/tasks/pending','Please select at least one request.','message-error');
            }
            //customRedirect('items','Request(s) Proceeded Successfully');
        }
        else if($this->input->post('step')==''||$this->input->post('step'))
            {
                 $data=array(
                    'request_id'=> $this->input->post('request_id'),
                    'comments'  => $this->input->post('comments'),
                    'status'    => $this->input->post('status')
                );
                $post_result = $this->_submit_request($data);
                if($post_result['status']==false)
                {
                    customRedirect('items',$post_result['msg'],'message-error');
                }
                customRedirect('items/request/tasks/completed',$post_result['msg']);
            }
     }

    /**
     * @param $data
     */
    private function _submit_request($data)
    {
        $emp= generic_select_row('employees',array('id'=>$this->session->userdata('emp_id')));
        $applicant=join_select_Table_array('designations.bps,emp.department','employees emp',array(
            array(
                'tbl'=>'emp',
                'field'=>'id',
                'tbl2'=>'leave_req',
                'field2'=>'emp_id',
                'type'=>null,
            ),array(
                'tbl'=>'emp',
                'field'=>'designation',
                'tbl2'=>'designations',
                'field2'=>'id',
                'type'=>null,
            )
        ),array('leave_req.id'=>$data['request_id']),null,null,null,null,null);
        $active_req_transaction=generic_select('leave_req_body',array('req_id'=>$data['request_id']));
        $applicant_department=$applicant[0]->department;
        $is_hod= tbl_count('hierarchy',array('dept_id'=>$applicant_department,'hod'=>$emp->id));
        $is_hod_24= tbl_count('hierarchy',array('dept_id'=>24,'hod'=>$emp->id));
        $hod = $this->_findImmediateHOD($emp->department);
        $dept_parent = $this->_findParentDept($emp->department);
        $hod_parent = $this->_findImmediateHOD($dept_parent);
        $user_dept = $this->_findDepartmentId($emp->id);

        if($this->_findImmediateHOD($user_dept) == $this->session->userdata('emp_id'))
        { $res= '';
             if ($data['status'] == 1) {
                     $postData=array(
                     'req_id'=>$data['request_id'],
                     'transaction_date' => date("Y-m-d H:i:s"),
                     'emp_id' => $this->session->userdata('emp_id'),
                     'comments' => $data['comments'],
                     'status' => $data['status'],
                     'proceeded' => 0,
                     'username' => $this->session->userdata('username'),
                     'next_step' => $hod_parent,
                    );
                update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 1));
                //update_db('leave_req_body', 'req_id', $data['request_id'],array('comment' <= "Recommanded"));
                insert_db('leave_req_transactions', $postData);
                update_db('leave_req', 'id', $data['request_id'], array('status' => $data['status']));

                send_email_applicant($data['request_id']);
                send_email_next_authority($data['request_id']);
                customRedirect('items/request/tasks/pending','Request has been Recommended By Manager/HOD.');

            }
             else if($data['status'] == 2){
                        $postData=array(
                    'req_id'=>$data['request_id'],
                    'transaction_date' => date("Y-m-d H:i:s"),
                    'emp_id' => $this->session->userdata('emp_id'),
                    'comments' => $data['comments'],
                    'status' => $data['status'],
                     'proceeded' => 0,
                    'username'=>$this->session->userdata('username'),
                    'next_step'=>-1,
                    );
                update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 1));
                //update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 0 , 'status' =>0 ));
                insert_db('leave_req_transactions', $postData);
                update_db('leave_req', 'id', $data['request_id'],array('status' => $data['status']));
                customRedirect('items/request/tasks/pending','Request has been rejected..','message-error');

                send_email_applicant($data['request_id']);
                send_email_next_authority($data['request_id']);

            }
             else if($data['status'] == 3){

                 //refer to vice chancellor by procurement for approval
                    $postData = array(
                         'req_id' => $data['request_id'],
                         'transaction_date' => date("Y-m-d H:i:s"),
                         'emp_id' => $this->session->userdata('emp_id'),
                         'status' => $data['status'],
                         'proceeded' => 0,
                         'username' => $this->session->userdata('username'),
                         'next_step' => $this->_findImmediateHOD(66),
                     );
                     update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 1));
                     insert_db('leave_req_transactions', $postData);
                     update_db('leave_req', 'id', $data['request_id'], array('status' => $data['status']));

                     send_email_next_authority($data['request_id']);
                     customRedirect('items/request/tasks/pending', 'Requisition Successfully refer to Vice Chancellor.');
             }
             else if($data['status'] == 4){

                 $postData=array(
                     'req_id'=>$data['request_id'],
                     'transaction_date' => date("Y-m-d H:i:s"),
                     'emp_id' => $this->session->userdata('emp_id'),
                     'status' => 4,
                     'proceeded'=>0,
                     'username'=>$this->session->userdata('username'),
                     'next_step'=>$this->_findImmediateHOD(67),
                 );

                 update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 1));
                 insert_db('leave_req_transactions', $postData);
                 update_db('leave_req', 'id', $data['request_id'], array('status' => 4));

                 send_email_next_authority($data['request_id']);
                 customRedirect('items/request/tasks/pending','Requisition Successfully refer to Store.');

             }
             else if($data['status'] == 5){
                 $isPartial = false;
                 $avai = $_POST["availableqty"];
                 $bal = $_POST["balanceqty"];
                 $checkRequest = $_POST["checkRequest"];

                 for($i=0;$i<count($avai);$i++)
                 {
                     $isPartial = false;
                     if($bal[$i]>0){
                         $isPartial = true;
                     }
                     $postData=array(
                         'available_qty'=>$avai[$i],
                         'balance_qty'=>$bal[$i],
                         'ispartial'=>$isPartial
                     );

                     $ids =  $checkRequest[$i];
                     if(update_db('mis_leave_req_body', 'rowid',$ids ,$postData)){
                         $postData1=array(
                             'req_id'=> $data['request_id'],
                             'transaction_date' => date("Y-m-d H:i:s"),
                             'emp_id' => $this->session->userdata('emp_id'),
                             'status' => 5,
                             'username'=>$this->session->userdata('username'),
                             'next_step'=>$this->_findImmediateHOD(20),
                             'proceeded' => 0,
                         );
                         if($isPartial){
                             update_db('leave_req', 'id', $data['request_id'], array('status' => 5,'ispartial'=>$isPartial));
                             update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 1));
                             insert_db('leave_req_transactions',$postData1);
                         }
                         else{
                             update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 1));
                             insert_db('leave_req_transactions',$postData1);

                         }
                     };
                 }

                    send_email_applicant_for_delivery($data['request_id']);
                    send_email_next_authority($data['request_id']);
                    customRedirect('items/request/tasks/pending','Requisition successfully verify & return to procurement  .','message-success');
             }
             else if($data['status'] == 6){

                 // print_r("approvedbypro"); exit;
                 $postData=array(
                     'req_id'=>$data['request_id'],
                     'transaction_date' => date("Y-m-d H:i:s"),
                     'emp_id' => $this->session->userdata('emp_id'),
                     'status' => 6,
                     'proceeded'=>0,
                     'username'=>$this->session->userdata('username'),
                     'next_step'=>-1,
                 );

                 update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 1));
                 insert_db('leave_req_transactions', $postData);
                 update_db('leave_req', 'id', $data['request_id'], array('status' => 9));

                 send_email_applicant($data['request_id']);
                 send_email_next_authority($data['request_id']);
                 customRedirect('items/request/tasks/completed','Requisition Successfully approved by Procurement.');
             }
             else if($data['status'] == 7){

                     $postData = array(
                         'req_id' => $data['request_id'],
                         'transaction_date' => date("Y-m-d H:i:s"),
                         'emp_id' => $this->session->userdata('emp_id'),
                         'status' => 7,
                         'proceeded' => 0,
                         'username' => $this->session->userdata('username'),
                         'next_step' => $this->_findImmediateHOD(20),
                     );

                     update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 1));
                     insert_db('leave_req_transactions', $postData);
                     update_db('leave_req', 'id', $data['request_id'], array('status' => 7));

                     customRedirect('items/request/tasks/pending', 'Requisition Successfully approved by Vice Chancellor.');
             }
             else if($data['status'] == 8){
                 $postData = array(
                     'req_id' => $data['request_id'],
                     'transaction_date' => date("Y-m-d H:i:s"),
                     'emp_id' => $this->session->userdata('emp_id'),
                     'status' => 8,
                     'proceeded' => 0,
                     'username' => $this->session->userdata('username'),
                     'next_step' => -1,
                 );

                 update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 1));
                 insert_db('leave_req_transactions', $postData);
                 update_db('leave_req', 'id', $data['request_id'], array('status' => 8));

                 customRedirect('items/request/tasks/pending', 'Requisition Rejected by Vice Chancellor.');
             }
        }

        if($this->_findImmediateHOD(20) == $this->session->userdata('emp_id') || $this->_findImmediateHOD(67) == $this->session->userdata('emp_id')) {

             //refer to vice chancellor by procurement for approval
            if ($this->input->post('refer') == 'vc') {
//                print_r("vc"); exit;
                $postData=array(
                    'req_id'=> $data['request_id'],
                    'transaction_date' => date("Y-m-d H:i:s"),
                    'emp_id' => $this->session->userdata('emp_id'),
                    // 'comments' => $data['comments'],
                    'status' => 3,
                    'proceeded' => 0,
                    'username'=>$this->session->userdata('username'),
                    'next_step'=>$this->_findImmediateHOD(66),
                );
                update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 1));
               // update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 0 , 'status' =>0 ));
                insert_db('leave_req_transactions', $postData);
               // update_db('mis_leave_req', 'id', $data['request_id'], array('status' => 3));
                //Temp Disapled
                send_email_next_authority($data['request_id']);
                customRedirect('items/request/tasks/pending','Requisition Successfully refer to Vice Chancellor.');
            }
             //refer to store by procurement
            else if($this->input->post('refer')=='store'){
              //  print_r("store"); exit;
                $postData=array(
                    'req_id'=>$data['request_id'],
                    'transaction_date' => date("Y-m-d H:i:s"),
                    'emp_id' => $this->session->userdata('emp_id'),
                    // 'comments' => $data['comments'],
                    'status' => 4,
                    'proceeded'=>0,
                    'username'=>$this->session->userdata('username'),
                    'next_step'=>$this->_findImmediateHOD(67),
                );
                update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 1));
               // update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 0 , 'status' =>0 ));
                insert_db('leave_req_transactions', $postData);
               // update_db('mis_leave_req', 'id', $data['request_id'], array('status' => 4));
                //Temp Disapled
                send_email_next_authority($data['request_id']);
                customRedirect('items/request/tasks/pending','Requisition Successfully refer to Store.');
            }
            //retrun to procurement by store afeter check available balance
            else if($this->input->post('refer')=='returnprocur'){

                $avai = $_POST["availableqty"];
                $bal = $_POST["balanceqty"];
                $checkRequest = $_POST["checkRequest"];
                for($i=0;$i<count($checkRequest);$i++)
                 {

                    $postData=array(
                        'available_qty'=>$avai[$i],
                        'balance_qty'=>$bal[$i]
                    );
                    $ids =  $checkRequest[$i];
                    if(update_db('mis_leave_req_body', 'rowid',$ids ,$postData)){

                        $postData1=array(
                            'req_id'=> $data['request_id'],
                            'transaction_date' => date("Y-m-d H:i:s"),
                            'emp_id' => $this->session->userdata('emp_id'),
                            // 'comments' => $data['comments'],
                            'status' => 5,
                            'username'=>$this->session->userdata('username'),
                            'next_step'=>$this->_findImmediateHOD(20),
                            'proceeded' => 0,
                        );

                        update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 1));
                      //  update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 0 , 'status' =>0 ));
                        insert_db('mis_leave_req_transactions',$postData1);
                       // update_db('mis_leave_req', 'id', $data['request_id'], array('status' => 5));
                    };

                }


                //Temp Disapled
                send_email_next_authority($data['request_id']);
                customRedirect('items/request/tasks/pending','Requisition successfully verify & return to procurement  .','message-success');
            }
                        //approved by procurement
            else if($this->input->post('refer')=='approvedbypro'){

                $postData=array(
                    'req_id'=>$data['request_id'],
                    'transaction_date' => date("Y-m-d H:i:s"),
                    'emp_id' => $this->session->userdata('emp_id'),
                    'status' => 6,
                    'proceeded'=>0,
                    'username'=>$this->session->userdata('username'),
                    'next_step'=>-1,
                );
                update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 1));
               //update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 0 , 'status' =>0 ));
                insert_db('leave_req_transactions', $postData);
              //  update_db('mis_leave_req', 'id', $data['request_id'], array('status' => 1));

                //Temp Disapled
                send_email_applicant($data['request_id']);
                send_email_next_authority($data['request_id']);
                customRedirect('items/request/tasks/pending','Requisition Successfully approved by Procurement.');
            }
        }

        //approved by vic chancellor to procurement to further action
        if($this->_findImmediateHOD(66) == $this->session->userdata('emp_id')  ) {
            if($this->input->post('refer')=='approvedbyvc'){
                $postData=array(
                    'req_id'=>$data['request_id'],
                    'transaction_date' => date("Y-m-d H:i:s"),
                    'emp_id' => $this->session->userdata('emp_id'),
                    'status' => 7,
                    'proceeded'=>0,
                    'username'=>$this->session->userdata('username'),
                    'next_step'=>$this->_findImmediateHOD(20),
                );
                update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 1));
              //  update_db('leave_req_transactions', 'req_id', $data['request_id'], array('proceeded' => 0 , 'status' =>0 ));
                insert_db('leave_req_transactions', $postData);
               // update_db('mis_leave_req', 'id', $data['request_id'], array('status' => 7));
                customRedirect('items/request/tasks/pending','Requisition Successfully approved by Vice Chancellor.');
            }
        }

    }

    /**
     * @param $dept_id
     * @return bool
     */
    private function _findParentDept($dept_id)
    {
        $dept_id=generic_select_row('hierarchy',array('dept_id'=>$dept_id));
        if(empty($dept_id))
            return false;
        if(is_array($dept_id)||is_object($dept_id))
        {
            return $dept_id->parent_id;
        }
        return false;
    }

    /**
     *
     */
    function index() {
        $data['title']="Submit Item(s) Requisition";
        $data['button']="Submit";
        if(!empty($_GET['emp']))
        {
            $emp=generic_select_row('employees',array('slug'=>$_GET['emp']));
        }else
        {
            $emp=generic_select_row('employees',array('id'=>$this->session->userdata('emp_id')));
        }
        if(empty($emp))
        {
            redirectToReffrer('Select a employee','message-error');
        }


        $data['emp']=$emp;
        $data['step']=1;
        $data['title']="Submit Leave Request ($emp->title $emp->name)";
        $data['button']="Submit";
        $this->load->view('request',$data);
    }

    /**
     * @param $type
     * @param $id
     */
    public function ru($type, $id)
    {

        if($type=='view')
        {
            $data['title']="View Item Request";
            $data['button']="View";
            $data['view_mode']=true;
            $data['leave_types']=generic_select('leave_types');
            $data['leave_request']=generic_select_row('leave_req',array('id'=>$id));
            $this->load->view('request',$data);
        }
        elseif($type=='edit')
        {
            $data['title']="Edit Leave Request";
            $data['button']="Update";
            $data['view_mode']=false;
            $data['step']=1;
            $data['leave_types']=generic_select('leave_types');
            $data['leave_request']=generic_select_row('leave_req',array('id'=>$id));
            $this->load->view('request',$data);
        }
        else if($type=='step')
        {

            try {
                if (!$this->_validateUserLeaves($id)) {
                    redirectToReffrer('Something went wrong. contact in IT Department', 'message-error');
                }

                $data['leave_data'] = join_select_Table_array(
                    'req.*,emp.name,emp.img,emp.emp_no,emp.mobile_no,dept.title as department,des.title as designation,req.id as request_id,req.status', 'leave_req req', array(
                    array(
                        'tbl' => 'req',
                        'field' => 'id',
                        'tbl2' => 'leave_req_transactions trns',
                        'field2' => 'req_id',
                        'type' => null
                    ),
                    array(
                        'tbl' => 'req',
                        'field' => 'emp_id',
                        'tbl2' => 'employees emp',
                        'field2' => 'id',
                        'type' => null
                    ), array(
                        'tbl' => 'emp',
                        'field' => 'department',
                        'tbl2' => 'departments dept',
                        'field2' => 'id',
                        'type' => null
                    ), array(
                        'tbl' => 'emp',
                        'field' => 'designation',
                        'tbl2' => 'designations des',
                        'field2' => 'id',
                        'type' => null,
                    )), array('req.id' => $id),null,null,null,null,null)[0];

                if (is_array($data['leave_data']) || is_object($data['leave_data'])) {
                    $data['leave_transactions'] = join_select_Table_array(
                        'emp.name,emp.emp_no,dept.title as department,trns.next_step,des.title as designation,
                         emp_next.name as name_n,emp_next.emp_no as emp_no_n,comments,dept_next.title as department_n,trns.status,transaction_date',
                        'leave_req_transactions trns', array(
                        array(
                            'tbl' => 'trns',
                            'field' => 'emp_id',
                            'tbl2' => 'employees emp',
                            'field2' => 'id',
                            'type' => null
                        ), array(
                            'tbl' => 'trns',
                            'field' => 'next_step',
                            'tbl2' => 'employees emp_next',
                            'field2' => 'id',
                            'type' => 'left'
                        ), array(
                            'tbl' => 'emp_next',
                            'field' => 'department',
                            'tbl2' => 'departments dept_next',
                            'field2' => 'id',
                            'type' => 'left'
                        ), array(
                            'tbl' => 'emp',
                            'field' => 'department',
                            'tbl2' => 'departments dept',
                            'field2' => 'id',
                            'type' => null
                        ), array(
                            'tbl' => 'emp',
                            'field' => 'designation',
                            'tbl2' => 'designations des',
                            'field2' => 'id',
                            'type' => null
                        )
                    ), array('trns.req_id' => $data['leave_data']->request_id),null,'transaction_date asc', null, null,null
                    );

                    $data["cartTable"] =  generic_select('leave_req_body',array('req_id'=>$id));


                    $emp_row = generic_select_row('employees', array('id' => $data['leave_data']->emp_id));

                    $data['isStore'] = $this->_findImmediateHOD(67);

                    $data['isProcur'] = $this->_findImmediateHOD(20);

                    $data['isHod'] = $this->_findImmediateHOD($this->_findDepartmentId($this->session->userdata('emp_id')));

                    $data['isVc'] = $this->_findImmediateHOD(66);

                    $data['proItems'] = generic_select('leave_req_body',array('req_id'=>$id,'balance_qty >'=>0));


                    if($data['isHod'] == $this->session->userdata('emp_id') ){

                        $data["DecisionDDL"] = array('' => 'Select Action','1' => 'Recommend Request', '2' => 'Reject Request');
                    }
                    if($data['isProcur'] == $this->session->userdata('emp_id') ){

                        $data["DecisionDDL"] = array('' => 'Select Action','3' => 'Refer to Vice Chancellor ', '6' => 'Recommend Request / Approve Request ');
                    }
                    if($data['isVc'] == $this->session->userdata('emp_id') ){

                        $data["DecisionDDL"] = array('' => 'Select Action','7' => 'Approve ', '8' => 'Reject');
                    }
                    if($data['isStore'] == $this->session->userdata('emp_id') ){

                        $data["DecisionDDL"] = array('' => 'Select Action','5' => 'Verify & Retrn to Procurement ');
                    }
                    $proAction =  generic_select_row('mis_leave_req ',array('id'=> $id));
                    if($proAction->status == 7){
                        if($data['isStore'] == $this->session->userdata('emp_id') ){

                            $data["DecisionDDL"] = array('' => 'Select Action','6' => 'Approve ');
                        }
                    }
                    if(!empty($_GET['download']) && $_GET['download']=='pdf')
                    {

                        session_write_close();
                        ob_start();
                        $this->load->view('pdf/requisition_pdf',$data);
                        $content = ob_get_clean();
                        $html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8');
                        $html2pdf->writeHTML($content);
                        $html2pdf->Output(FCPATH.'uploads/requisition/item_request.pdf','F');
                        header('Content-Disposition: attachment;filename="item_request".pdf');
                        echo file_get_contents(FCPATH.'uploads/requisition/item_request.pdf');

                        // echo file_get_contents(FCPATH."uploads/Requisition/{$emp_row->emp_no}_item_request.pdf");

                        customRedirect('items/request/tasks/completed','RFQ file downloaded Successfully.');
                    }
                    else {

                        $data['title'] = "Requisition Status";
                        $data['button'] = "Submit";
                        $this->load->view('request_proceed', $data);
                    }
                }
                else {

                }
            }
            catch(exception $ex){


            }
        }
        else{
            redirectToReffrer('Invalid Input','message-error');
        }
    }

    /**
     * @param $leave_request_id
     * @return bool
     */

    private function _validateUserLeaves($leave_request_id)
    {
        if(!empty($_GET['emp']))
        {
            $row=generic_select_row('leave_req',array('emp_id'=>$this->emp_id,'id'=>$leave_request_id));
        }
        else
        {
            $row=generic_select_row('leave_req',array('emp_id'=>$this->session->userdata('emp_id'),'id'=>$leave_request_id));
        }
        if(is_array($row)||is_object($row))
            return true;
        $row=generic_select_row('leave_req_transactions',array('next_step'=>$this->session->userdata('emp_id'),'req_id'=>$leave_request_id));
        if(is_array($row)||is_object($row))
            return true;

        return false;
    }

    /**
     * @param $type
     */
    public function tasks($type)
    {
        //is_hod();
        $data['type']=$type;
        if($type=='pending'){
            $data['isPro'] = $this->_findImmediateHOD(20);
            $data['title']="Requests awaiting for your action";
            $data['leaves']=join_select_Table_array(
                'req.*,emp.name,emp.emp_no,dept.title as department','leave_req req',array(
                    array(
                        'tbl'=>'req',
                        'field'=>'id',
                        'tbl2'=>'leave_req_transactions trns',
                        'field2'=>'req_id',
                        'type'=>null
                    ),
                    array(
                        'tbl'=>'req',
                        'field'=>'emp_id',
                        'tbl2'=>'employees emp',
                        'field2'=>'id',
                        'type'=>null
                    ),array(
                        'tbl'=>'emp',
                        'field'=>'department',
                        'tbl2'=>'departments dept',
                        'field2'=>'id',
                        'type'=>null
                    )
                ),array('trns.next_step'=>$this->session->userdata('emp_id'),'proceeded'=>0,'req.ispartial'=>0));
        }else if($type=='partial'){

            $data['isPro'] = $this->_findImmediateHOD(20);
            $data['title']="Partial Request Completed so far";
         $data['leaves']=join_select_Table_array(
                'req.*,emp.name,emp.emp_no,dept.title as department','leave_req req',array(
                array(
                    'tbl'=>'req',
                    'field'=>'id',
                    'tbl2'=>'leave_req_transactions trns',
                    'field2'=>'req_id',
                    'type'=>null
                ),
                array(
                    'tbl'=>'req',
                    'field'=>'emp_id',
                    'tbl2'=>'employees emp',
                    'field2'=>'id',
                    'type'=>null
                ),array(
                    'tbl'=>'emp',
                    'field'=>'department',
                    'tbl2'=>'departments dept',
                    'field2'=>'id',
                    'type'=>null

                )
            ),array('trns.next_step'=>$this->session->userdata('emp_id'),'proceeded'=>0,'req.ispartial'=>1)
            );
        }else if($type=='completed'){
            $data['isPro'] = $this->_findImmediateHOD(20);
            $data['title']="Request Completed so far";
            $data['leaves']=join_select_Table_array(
                'req.*,emp.name,emp.emp_no,dept.title as department','leave_req req',array(
                    array(
                        'tbl'=>'req',
                        'field'=>'id',
                        'tbl2'=>'leave_req_transactions trns',
                        'field2'=>'req_id',
                        'type'=>null
                    ),
                    array(
                        'tbl'=>'req',
                        'field'=>'emp_id',
                        'tbl2'=>'employees emp',
                        'field2'=>'id',
                        'type'=>null
                    ),array(
                        'tbl'=>'emp',
                        'field'=>'department',
                        'tbl2'=>'departments dept',
                        'field2'=>'id',
                        'type'=>null
                    )
                ),array(" req_id in (".join_select_Table_array('req_id','leave_req_transactions',null,
                        array('next_step'=>$this->session->userdata('emp_id'),'proceeded'=>1),null,null,null,null,true).") and trns.status<>0  "),'req_id'
            );
        }

        $this->load->view('task_listing',$data);
    }

    /**
     * @return bool
     */
    public function test()
    {

        return true;
    }

    /**
     * @return array
     */
    private function _doupload()
    {
        $attachments=array();
        if(!empty($_FILES))
        {
            $config['upload_path'] = './uploads/leaves';
            $config['allowed_types'] = 'gif|jpg|png|pdf';
            $config['max_size']	= '0';
            $config['max_width'] = '0';
            $config['max_height'] = '0';
            $this->load->library('upload', $config);
            $files=$_FILES;
            $userfile='file';
            $userfile_temp='temp';
            $file_counter=count($_FILES[$userfile]['name']);
            for($i=0;$i<$file_counter;$i++)
            {
                $_FILES[$userfile_temp]['name']= $files[$userfile]['name'][$i];
                $_FILES[$userfile_temp]['type']= $files[$userfile]['type'][$i];
                $_FILES[$userfile_temp]['tmp_name']= $files[$userfile]['tmp_name'][$i];
                $_FILES[$userfile_temp]['error']= $files[$userfile]['error'][$i];
                $_FILES[$userfile_temp]['size']= $files[$userfile]['size'][$i];
                if($_FILES[$userfile_temp]['name']!='')
                {
                    $config['file_name'] = strtolower($this->input->post('file_title')[$i]);
                    $config['overwrite']= false;
                    $this->upload->initialize($config);
                    if ($this->upload->do_upload($userfile_temp)) {

                        $data = array('upload_data' => $this->upload->data());
                        $file_name = $data['upload_data']['file_name'];

                        $attachments[]=array(
                            'file_name' => $file_name,
                            'file_title' => $this->input->post('file_title')[$i],
                        );

                    }
                    else
                    {
                        if(!empty($attachments))
                        {
                            foreach ($attachments as $at)
                            {
                                @unlink("./uploads/leaves/{$at['file_name']}");
                            }
                        }
                        $this->session->set_flashdata('message-error',$this->upload->display_errors());
                        $ref = $this->input->server('HTTP_REFERER', TRUE);
                        redirect($ref, 'location');
                    }

                }

            }
        }
        return $attachments;
    }

    /**
     * @param $dept
     * @return bool
     */
    private function _findImmediateHOD($dept)
    {
        $hod=generic_select_row('hierarchy',array('dept_id'=>$dept));

        if(is_array($hod)||is_object($hod))
        {
            return $hod->hod;
        }
        return false;
    }

    /**
     * @param $dept
     * @param bool $lookForward
     * @return bool
     */
    private function _findImmediateReportingHead($dept, $lookForward=false)
    {
        $hod=generic_select_row('hierarchy',array('dept_id'=>$dept));

        if(is_array($hod)||is_object($hod))
        {
            if(empty($hod->r_head) && $lookForward)
            {
                return $hod->hod;
            }else
                return $hod->r_head;
        }
        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    private function _findDepartmentId($id)
    {
        $hod=generic_select_row('hierarchy',array('hod'=>$id));

        if(is_array($hod)||is_object($hod))
        {
            return $hod->dept_id;
        }
        return false;
    }

}
// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
//get content from service
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