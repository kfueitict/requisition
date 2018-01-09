
<?php $this->load->view('include/header'); ?>

<div class="container">
   <div class="row" style="background: #fff">
       <div class="col-md-10 col-md-offset-2">
           <h3>Employee Transfer</h3><hr>
       </div>
   </div>
   <?php 
    $attributes = array('class' => 'transfer_form', 'id' => 'transfer_form');
    echo form_open('transfer/get_record', $attributes);
    
    if( $feedback = $this->session->flashdata('feedback')): 
                $feedback_class = $this->session->flashdata('feedback_class');
       ?>
                    <div class = "row" id="flashMessage">
                        <div class = "col-md-4 col-md-offset-2">
                            <div class = "alert alert-dismissible <?= $feedback_class ?>">
                                <?=  $feedback; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; 
    ?>
    
    <div class="row" style="background: #fff">
        <div class="col-md-9 col-md-offset-2">
         
         <div class="col-md-6">
              <div class="form-group">
                <label for="selecedept">FROM Department</label>
                  <?php
                    if (validation_errors()){
                        echo ' <div id="from_dept_error"><button class="close" data-dismiss="alert"></button><p>'.form_error('selectdept').' </p>';
                    echo '</div>';  
                     }
                    ?>
                    <select class="select2 form-control" name="selectdept" id="selectdept">
                    <option value="">Select Department</option>
                     <?php
                        if(isset($department)){
                            foreach($department as $dept){
                                $select="";
                                $id = $dept['id'];
                                $deptname = ucfirst($dept['title']);
                             
                                if ($this->input->post('selectdept')== $dept['id']) {
                                    $select="selected";
                                    echo "<option $select value=$id>$deptname</option>";
                                }else{
                                    echo "<option value=$id>$deptname</option>";
                                }
                            }
                        }
                        ?>
                    </select>
              </div> 
         </div>
            <div class="col-md-6">
               <div class="form-group">
                    <label for="empname">Employee</label>
                    <?php
                    if (validation_errors()){
                        echo '<div id="empname_error"><button class="close" data-dismiss="alert"></button><p>'.form_error('empname').'</p>';
                        echo '</div>';  
                     }
                    ?>
                        <select name="empname" class="select2 form-control" id="emp_name">
                          <option value="">Select Employee</option>
                          
                     <?php
                        if(isset($employees)){
                            foreach($employees as $emp){
                                $select="";
                                $id = $emp['id'];
                                $empName = ucfirst($emp['name']);
                             
                                if ($this->input->post('empname')== $emp['id']) {
                                    $select="selected";
                                    echo "<option $select value=$id>$empName</option>";
                                }else{
                                    echo "<option value=$id>$empName</option>";
                                }
                            }
                        }
                        ?>
                   </select>
              </div>  
            </div>
        </div>
       </div>
       
        <div class="row" style="background: #fff">
            <div class="col-md-9 col-md-offset-2">
                <div class="col-md-6">
                      <div class="form-group" >
                        <label for="fromdate">Transfer Date</label>
                    <?php
                    if (validation_errors()){
                        echo ' <div id="fromdate_error"><button class="close" data-dismiss="alert"></button><p>'.form_error('fromdate').' </p>';
                    echo '</div>';  
                     }
                    ?>
                        <?php $currdate = date('Y-m-d'); ?>         
                    <div class='input-group date' id='datetimepicker1'>
                        <input type='text' name="fromdate" class="form-control" value="<?= $this->input->post('fromdate'); ?>" placeholder="<?php echo $currdate; ?>"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span> 
                    </div> 
                </div>
             </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="reference">Reference No</label>
                    <?php
                    if (validation_errors()){
                        echo ' <div id="reference_error"><button class="close" data-dismiss="alert"></button><p>'.form_error('reference').' </p>';
                    echo '</div>';  
                     }
                    ?>
                    <input type="text" class="form-control" name="reference" placeholder="Enter reference" value="<?= $this->input->post('reference'); ?>">
                </div> 
            </div>
        </div>  
     </div>           
     <div class="row" style="background: #fff">
         <div class="col-md-9 col-md-offset-2">
          
            <div class="col-md-6">
                 <div class="form-group">
                    <label for="todept">Transfer TO Department</label>
                    <?php
                    if (validation_errors()){
                        echo ' <div id="todept_error"><button class="close" data-dismiss="alert"></button><p>'.form_error('todept').' </p>';
                    echo '</div>';  
                     }
                    ?>
                    
                    <select class="select2 form-control" name="todept" id="todept">
                      <option value="">Select Department</option>
                       <?php 
                        if(isset($department)){
                            foreach($department as $dept){
                                $select = "";
                                $id = $dept['id'];
                                $deptname = ucfirst($dept['title']);
                                if($this->input->post('todept') == $id)
                                {
                                    $select = "selected";
                                    echo "<option $select value=$id>$deptname</option>";
                                }else{
                                    echo "<option $select value=$id>$deptname</option>";
                                }
                            }
                        }
                        ?>
                    </select>
                  </div>
            </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="reference">Remarks</label>
                    <?php
                    if (validation_errors()){
                        echo ' <div id="remarks_error"><button class="close" data-dismiss="alert"></button><p>'.form_error('remarks').' </p>';
                    echo '</div>';  
                     }
                    ?>
                        <input type="text" class="form-control" name="remarks" placeholder="Enter Remarks" value="<?= $this->input->post('remarks'); ?>">
                    </div> 
            </div>
         </div>
     </div>
     <div class="row" style="background: #fff;">
         <div class="col-md-8 col-md-offset-2">
             <button type="submit" class="btn btn-primary" style="margin-bottom: 10px; margin-left: 15px; padding: 8px 30px;">Submit</button>
         </div>
     </div>    
     
    <?php echo form_close(); ?>
</div>
 
<?php $this->load->view('include/footer'); ?>

<script>
$(".select2").select2();

            $(function () {
                 $('#datetimepicker1').datepicker();
            });
    
    $('#from_dept_error').fadeIn('normal').delay(2000).fadeOut('normal');
    $('#empname_error').fadeIn('normal').delay(2000).fadeOut('normal');
    $('#fromdate_error').fadeIn('normal').delay(2000).fadeOut('normal');
    $('#reference_error').fadeIn('normal').delay(2000).fadeOut('normal');
    $('#todept_error').fadeIn('normal').delay(2000).fadeOut('normal');
    $('#remarks_error').fadeIn('normal').delay(2000).fadeOut('normal');
    $('#box').fadeIn('slow').delay(3000).hide(0);
        
</script>