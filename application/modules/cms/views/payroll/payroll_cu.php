<?php $this->load->view('include/header');?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo @$title ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('cms/payroll') ?>"><i class="fa fa-cubes"></i>Payroll</a></li>
            <li class="active"><?php echo @$title ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <i class="fa fa-money"></i>
                <h3 class="box-title"></h3>
                <button type="button" onclick="window.location.href='<?php echo base_url('cms/payroll')?>'" class="btn btn-info pull-right">Back</button>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="" method="post">
                <input type="hidden" name="update_id" id="update_id" value="<?php echo @$pr->id ?>">
                <input type="hidden" name="emp_id" id="emp_id" value="<?php echo @$emp->id ?>">
                <input type="hidden" id="tbl" value="payroll_master">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="acc_no">Acc No</label>
                        <div class="col-sm-6">
                            <input type="text"
                                   class="form-control"
                                   value="<?php echo @$pr->acc_no ?>"
                                   id="acc_no"
                                   name="acc_no">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="salary_reg_page">Salary Reg. Page</label>
                        <div class="col-sm-6">
                            <input  type="text"
                                   class="form-control"
                                   value="<?php echo @$pr->salary_reg_page ?>"
                                   id="salary_reg_page"
                                   name="salary_reg_page">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="pay">Pay</label>
                        <div class="col-sm-6">
                            <input  type="number"
                                   class="form-control"
                                   value="<?php echo @$pr->pay ?>"
                                   id="pay"
                                   name="pay">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="s_p_a">Senior Post Allowance</label>
                        <div class="col-sm-6">
                            <input  type="number"
                                   class="form-control"
                                   value="<?php echo @$pr->s_p_a ?>"
                                   id="s_p_a"
                                   name="s_p_a">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="h_r_a">House Rent Allowance</label>
                        <div class="col-sm-6">
                            <input  type="number"
                                   class="form-control"
                                   value="<?php echo @$pr->h_r_a ?>"
                                   id="h_r_a"
                                   name="h_r_a">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="conveyance_a">Conveyance Allowance</label>
                        <div class="col-sm-6">
                            <input  type="number"
                                   class="form-control"
                                   value="<?php echo @$pr->conveyance_a ?>"
                                   id="conveyance_a"
                                   name="conveyance_a">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="qualification_a">Qualification Allowance</label>
                        <div class="col-sm-6">
                            <input  type="number"
                                   class="form-control"
                                   value="<?php echo @$pr->qualification_a ?>"
                                   id="qualification_a"
                                   name="qualification_a">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="entertainment_a">Entertainment Allowance</label>
                        <div class="col-sm-6">
                            <input  type="number"
                                   class="form-control"
                                   value="<?php echo @$pr->entertainment_a ?>"
                                   id="entertainment_a"
                                   name="entertainment_a">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="teaching_a">Univ.Tech.Teaching Allowance</label>
                        <div class="col-sm-6">
                            <input  type="number"
                                   class="form-control"
                                   value="<?php echo @$pr->teaching_a ?>"
                                   id="teaching_a"
                                   name="teaching_a">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="medical_a">Medical Allowance</label>
                        <div class="col-sm-6">
                            <input  type="number"
                                   class="form-control"
                                   value="<?php echo @$pr->medical_a ?>"
                                   id="medical_a"
                                   name="medical_a">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="adhoc_r_a_2010">Adhoc Relief Allowance-2010</label>
                        <div class="col-sm-6">
                            <input  type="number"
                                   class="form-control"
                                   value="<?php echo @$pr->adhoc_r_a_2010 ?>"
                                   id="adhoc_r_a_2010"
                                   name="adhoc_r_a_2010">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="adhoc_r_a_2016">Adhoc Relief Allowance-2016</label>
                        <div class="col-sm-6">
                            <input  type="number"
                                   class="form-control"
                                   value="<?php echo @$pr->adhoc_r_a_2016 ?>"
                                   id="adhoc_r_a_2016"
                                   name="adhoc_r_a_2016">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="social_sec">Social Security 30% of Basic Pay</label>
                        <div class="col-sm-6">
                            <input  type="number"
                                   class="form-control"
                                   value="<?php echo @$pr->social_sec ?>"
                                   id="social_sec"
                                   name="social_sec">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="extra_duty_allowance">Extra Duty Allowance</label>
                        <div class="col-sm-6">
                            <input  type="number"
                                    class="form-control"
                                    value="<?php echo @$pr->extra_duty_allowance ?>"
                                    id="extra_duty_allowance"
                                    name="extra_duty_allowance">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="project_allowance">Project Allowance</label>
                        <div class="col-sm-6">
                            <input  type="number"
                                    class="form-control"
                                    value="<?php echo @$pr->project_allowance ?>"
                                    id="project_allowance"
                                    name="project_allowance">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="arrears">Arrears</label>
                        <div class="col-sm-6">
                            <input  type="number"
                                   class="form-control"
                                   value="<?php echo @$pr->arrears ?>"
                                   id="arrears"
                                   name="arrears">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="income_tax">Income Tax</label>
                        <div class="col-sm-6">
                            <input  type="number"
                                   class="form-control"
                                   value="<?php echo @$pr->income_tax ?>"
                                   id="income_tax"
                                   name="income_tax">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="transportation_charges">Transportation Charges</label>
                        <div class="col-sm-6">
                            <input  type="number"
                                   class="form-control"
                                   value="<?php echo @$pr->transportation_charges ?>"
                                   id="transportation_charges"
                                   name="transportation_charges">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="recovery">Recovery</label>
                        <div class="col-sm-6">
                            <input  type="number"
                                   class="form-control"
                                   value="<?php echo @$pr->recovery ?>"
                                   id="recovery"
                                   name="recovery">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="transport_charges">Transport Charges</label>
                        <div class="col-sm-6">
                            <input  type="number"
                                    class="form-control"
                                    value="<?php echo @$pr->transport_charges ?>"
                                    id="transport_charges"
                                    name="transport_charges">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="other_deductions">Other Deduction</label>
                        <div class="col-sm-6">
                            <input  type="number"
                                    class="form-control"
                                    value="<?php echo @$pr->other_deductions ?>"
                                    id="other_deductions"
                                    name="other_deductions">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="remarks">Remarks</label>
                        <div class="col-sm-6">
                            <input  type="text"
                                   class="form-control"
                                   value="<?php echo @$pr->remarks ?>"
                                   id="remarks"
                                   name="remarks">
                        </div>
                    </div>

                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-success"><?php echo @$button; ?></button>
                        </div>
                </div><!-- /.box-footer -->
            </form>
        </div><!-- /.box -->


    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php $this->load->view('include/footer'); ?>

<script>
    $(document).ready(function(){

    });
</script>
<script>
    $(function () {
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
    });
</script>