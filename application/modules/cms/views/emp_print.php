<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>KFUEIT MIS | <?php echo @$user->name ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/bootstrap/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url('assets') ?>/bootstrap/css/ionicons.min.css">
    <!-- Ionicons -->
    <!-- Theme style -->
</head>
<body>
<style>
    table {
        counter-reset: rowNumber;
    }

    table tr:not(:first-child) {
        counter-increment: rowNumber;
    }

    table tr td:first-child::after {
        content: counter(rowNumber);
        min-width: 1em;
        margin-right: 0.5em;
    }
</style>
<div class="container" id="container">
<div class="row text-center">

    <div class="col-sm-12">
        <div class="pull-left"> <img width="120"  src="<?php echo base_url('assets/img/logokfuiet.jpg') ?>" alt="kfueit"></div>

        <h3>KHWAJA FAREED UNIVERSITY OF ENGINEERING AND INFORMATION TECHNOLOGY</h3>

        <p><strong>Employee Information</strong></p>
    </div>

</div>
<div class="row ">
    <div class="col-sm-12">
        <div class=" pull-right">
            <img width="150" height="150" style="margin: 10px" src="<?php echo base_url('uploads/employees/' . @$user->img) ?>"
                 alt="<?php echo @$user->name ?>'s photo not available">
        </div>
        <div class="col-sm-4 col-md-5 table-bordered">
            <label class="control-label ">Title:</label>
            <span><?php echo @$user->title ?></span>
        </div>

        <div class="col-sm-5 col-md-5 table-bordered">
            <label class="control-label">Name:</label>
            <span><?php echo @$user->name ?></span>
        </div>
        <div class="col-sm-5 col-md-5 table-bordered">
            <label class="control-label">Father Name:</label>
            <span><?php echo @$user->father_name ?></span>
        </div>
        <div class="col-sm-4 col-md-5 table-bordered">
            <label class="control-label">CNIC:</label>
            <span><?php echo @$user->cnic ?></span>
        </div>
        <div class="col-sm-5 col-md-5 table-bordered">
            <label class="control-label">Cast:</label>
            <span><?php echo @$user->cast ?></span>
        </div>
        <div class="col-sm-4 col-md-5 table-bordered">
            <label class="control-label">Religion:</label>
            <span><?php echo @$user->religion ?></span>
        </div>
        <div class="col-sm-5 col-md-5 table-bordered">
            <label class="control-label ">Blood Group:</label>
            <span><?php echo @$user->blood_group ?></span>
        </div>
        <div class="col-sm-4 col-md-5 table-bordered">
            <label class="control-label">Cults:</label>
            <span><?php echo @$user->cults ?></span>
        </div>
        <div class="col-sm-5 col-md-5 table-bordered">
            <label class="control-label">Mobile No:</label>
            <span><?php echo @$user->mobile_no ?></span>
        </div>
        <div class="col-sm-4 col-md-5 table-bordered">
            <label class="control-label">Phone No:</label>
            <span><?php echo @$user->phone_no ?></span>
        </div>
        <div class="col-sm-5 col-md-5 table-bordered">
            <label class="control-label">Passport No:</label>
            <span><?php echo @$user->passport_no ?></span>
        </div>
        <div class="col-sm-4 col-md-5 table-bordered">
            <label class="control-label">Emergency Contact No:</label>
            <span><?php echo @$user->e_phone_no ?></span>
        </div>


    </div>

</div>
<div class="row">
    <div class="col-sm-12">
        <div class="col-sm-6 table-bordered">
            <label class="control-label">Date of Birth:</label>
            <span><?php echo @$user->dob ?></span>
        </div>
        <div class="col-sm-6 table-bordered">
            <label class="control-label">Biometric ID:</label>
            <span><?php echo @$user->bm_id ?></span>
        </div>
        <div class="col-sm-6 table-bordered">
            <label class="control-label">Job Designation:</label>
            <span><?php echo @$user->des ?></span>
        </div>
        <div class="col-sm-6 table-bordered">
            <label class="control-label">Email:</label>
            <span><?php echo @$user->email ?></span>
        </div>
        <div class="col-sm-6 table-bordered">
            <label class="control-label">Department:</label>
            <span><?php echo @$user->dept ?></span>
        </div>
        <div class="col-sm-6 table-bordered">
            <label class="control-label">Is HOD:</label>
            <span><?php if (@$user->is_hod == 1) echo 'YES'; else echo 'NO' ?></span>
        </div>
        <div class="col-sm-12 table-bordered">
            <label class="control-label">Present Address:</label>
            <span><?php echo @$user->present_address ?></span>
        </div>
        <div class="col-sm-12 table-bordered">
            <label class="control-label">Permanent Address:</label>
            <span><?php echo @$user->permanent_address ?></span>
        </div>
        <div class="col-sm-6 table-bordered">
            <label class="control-label">App Letter No:</label>
            <span><?php echo @$user->app_letter_no ?></span>
        </div>
        <div class="col-sm-6 table-bordered">
            <label class="control-label">BIO Data Form:</label>
            <span><?php if (@$user->bio_data_form == 1) echo 'YES'; else echo 'NO' ?></span>
        </div>
        <div class="col-sm-6 table-bordered">
            <label class="control-label">ERV:</label>
            <span><?php echo @$user->erv ?></span>
        </div>
        <div class="col-sm-6 table-bordered">
            <label class="control-label">Joining Letter No:</label>
            <span><?php echo @$user->joining_letter_no ?></span>
        </div>
        <div class="col-sm-6 table-bordered">
            <label class="control-label">Date of Joining:</label>
            <span><?php echo @$user->doa ?></span>
        </div>
        <div class="col-sm-6 table-bordered">
            <label class="control-label">Type of Job:</label>
            <span><?php echo @$user->job_type ?></span>
        </div>
        <div class="col-sm-6 table-bordered">
            <label class="control-label">Job Status:</label>
            <span><?php echo @$user->job_status ?></span>
        </div>
        <div class="col-sm-6 table-bordered">
            <label class="control-label">Job Status Date:</label>
            <span><?php echo @$user->job_status_date ?></span>
        </div>
        <div class="col-sm-6 table-bordered">
            <label class="control-label">Salary:</label>
            <span><?php echo @$user->salary ?></span>
        </div>
        <div class="col-sm-6 table-bordered">
            <label class="control-label">Police Station Name:</label>
            <span><?php echo @$user->ps_name ?></span>
        </div>
        <div class="col-sm-12 table-bordered">
            <label class="control-label">If any police case:</label>
            <span><?php echo @$user->police_case ?></span>
        </div>
    </div>

</div>
<?php if(@$user->job_type!=='Permanent'){
if(isset($details_c)) {
    if (is_array(@$details_c) || is_object(@$details_c)){
    ?>
    <div class="row">

        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3>Contract Details</h3>
                </div>
                <div class="box-body">
                    <table id="tbl-services" class="table table-bordered">
                        <tbody id="s-body">
                        <tr>
                            <th >Sr.</th>
                            <th width="30%">Duration (Months)</th>
                            <th width="30%">Expire Date</th>
                            <th width="40%">Reference</th>
                        </tr>
                        <?php
                        if(isset($details_c)) {
                            if (is_array(@$details_c) || is_object(@$details_c))
                                foreach ($details_c as $detail) {
                                    echo '<tr>
<td></td>
<td>' . @$detail->duration . '</td>
<td>' . @$detail->exp_date . '</td>
<td>' . @$detail->reference . '</td>
</tr>';
                                }
                        }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php
}}}
if (isset($details)) {
if (is_array(@$details) || is_object(@$details)){
?>
    <div class="row">

        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3>Education Details</h3>
                </div>
                <div class="box-body">
                    <table id="tbl-services" class="table table-bordered">
                        <tbody id="s-body">
                        <tr>
                            <th>Sr.</th>
                            <th width="25%">Degree/Certificate</th>
                            <th width="25%">Institute</th>
                            <th>Year</th>
                            <th>Roll No</th>
                            <th>Certificate No.</th>
                            <th>Total Marks/CGPA</th>
                            <th>Obtained Marks/CGPA</th>
                        </tr>
                        <?php
                        if (isset($details)) {
                            if (is_array(@$details) || is_object(@$details))
                                foreach ($details as $detail) {
                                    echo '<tr>
<td></td>
<td>' . $detail->degreet . '</td>
<td>' . $detail->boardt . '</td>
<td>' . $detail->year . '</td>
<td>' . $detail->roll_no . '</td>
<td>' . $detail->certificate_no . '</td>
<td>' . ($detail->total_marks + 0) . '</td>
<td>' . ($detail->obtained_marks + 0) . '</td>
</tr>';
                                }
                        }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php
}
}
if (isset($details_e)) {
if (is_array(@$details_e) || is_object(@$details_e))
{
?>
    <div class="row">

        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3>Police/Army/Govt. Experience</h3>
                </div>
                <div class="box-body">
                    <table id="tbl-services" class="table table-bordered">
                        <tbody id="s-body">
                        <tr>
                            <th>Sr.</th>
                            <th width="25%">Job Designation</th>
                            <th width="25%">Employer</th>
                            <th>From Date</th>
                            <th>To Date</th>
                        </tr>
                        <?php
                        if (isset($details_e)) {
                            if (is_array(@$details_e) || is_object(@$details_e))
                                foreach ($details_e as $detail) {
                                    echo '<tr>
<td></td>
<td>' . $detail->designationt . '</td>
<td>' . $detail->employert . '</td>
<td>' . $detail->from_date . '</td>
<td>' . $detail->to_date . '</td>
</tr>';
                                }
                        }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php
}
}
?>





</div>
<!-- /.login-box -->

<!-- jQuery 2.1.4 -->
<script src="<?php echo base_url('assets') ?>/plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!-- Bootstrap 3.3.5 -->
<script src="<?php echo base_url('assets') ?>/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets') ?>/plugins/iCheck/icheck.min.js"></script>
</body>
</html>
