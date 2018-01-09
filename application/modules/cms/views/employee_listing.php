<?php $this->load->view('include/header');?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
        <h1>
            <i class="fa fa-cubes"></i>
            Employees <?php echo @$title?>
            <small><a href="<?php echo base_url('cms/employees/crud') ?>" class="btn btn-block btn-default btn-xs" ><i class="fa fa-cube"></i> Add Employee</a></small>
            <?php
            if(is_dr_user(false))
            {
                ?>
                <small><a class="btn btn-success" target="_blank" href="<?php echo current_url().'?'. $_SERVER['QUERY_STRING'].'&download=csv'; ?>">Download All Fields</a></small>
            <?php
            }
            ?>

        </h1>

</section>

<!-- Main content -->
<section class="content">
<?php if($this->session->flashdata('message'))
{?>
    <div class="box-body">
        <div class="alert alert-success alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
            <?php echo $this->session->flashdata('message') ;?>
        </div>
    </div>
<?php }
?>
<div class="row">
<div class="col-xs-12">

<div class="box">
<div class="box-body">
    <div class="box box-info">
        <div class="box-header with-border">
            <i class="fa fa-filter"></i>
            <h3 class="box-title">Filter</h3>
        </div>

        <form class="form-horizontal">

            <div class="box-body">
                <div class="row">
                <div class="row">
                    <div class="col-md-2">
                        <label class="control-label"  for="title">Title</label>
                        <select class="form-control" name="title" id="title">
                            <?php
                            $titles=array(
                                'Mr.',
                                'Ms.',
                                'Engr.',
                                'Dr.'
                            );
                            echo '<option  value=""  >All Titles</option>';
                            if(is_array(@$titles)||is_object(@$titles))
                                foreach(@$titles as $v)
                                {
                                    $select='';
                                    if(@$_GET['title'] ==$v)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$v.'"  >'.$v.'</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class=" control-label"  for="designation">Job Designation</label>
                        <select class="form-control" id="designation" name="designation">
                            <option value="">All Designations</option>
                            <?php
                            if(is_array(@$designations)||is_object(@$designations))
                                foreach(@$designations as $type)
                                {
                                    $select='';
                                    if(@$_GET['designation'] ==$type->id)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$type->id.'"  >'.$type->title.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="control-label"  for="bps">BPS</label>
                        <select class="form-control" id="bps"
                                name="bps">
                            <option value="">All BPS</option>
                            <?php
                            if(is_array(@$bps)||is_object(@$bps))
                                foreach(@$bps as $type)
                                {
                                    $select='';
                                    if(@$_GET['bps'] ==$type->bps)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$type->bps.'"  >'.$type->bps.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="control-label"  for="bio_data_form">BIO Data Form</label>
                        <select class="form-control" id="bio_data_form"
                                name="bio_data_form">
                            <?php
                            echo '<option  value=""  >All BIO Data Form</option>';
                            $jobs=array(
                                '0'=>'No',
                                '1'=>'Yes'
                            );
                            if(is_array(@$jobs)||is_object(@$jobs))
                                foreach(@$jobs as $k=>$v)
                                {
                                    $select='';
                                    if(@$_GET['bio_data_form']==$k)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$k.'"  >'.$v.'</option>';
                                }
                            ?>
                        </select>
                    </div>


                    <div class="col-sm-1">
                        <label class=" control-label"  for="hod">Is HOD?</label>
                        <input type="checkbox" <?php if(@$_GET['is_hod']==1) echo 'checked' ?> name="is_hod" id="hod" value="1" class="checkbox">
                    </div>
                    <div class="col-sm-2">
                        <label class=" control-label"  for="is_teaching">Is Teaching?</label>
                        <input type="checkbox" <?php if(@$_GET['is_teaching']==1) echo 'checked' ?> name="is_teaching" id="is_teaching" value="1" class="checkbox">
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <label class="control-label"  for="job_type">Type of Job</label>

                            <select class="form-control" id="job_type" name="job_type">
                                <option value="">All Job Type</option>
                                <?php
                                $jobs=array(
                                    'Adhoc'=>'Adhoc',
                                    'Contract'=>'Contract',
                                    'Permanent'=>'Permanent',
                                    'Daily Wages'=>'Daily Wages',
                                    'IPFP'=>'IPFP',
                                );
                                if(is_array(@$jobs)||is_object(@$jobs))
                                    foreach(@$jobs as $k=>$v)
                                    {
                                        $select='';
                                        if(@$_GET['job_type']==$k)
                                            $select='selected';
                                        echo '<option '.$select.' value="'.$v.'"  >'.$k.'</option>';
                                    }
                                ?>
                            </select>

                        </div>
                        <div class="col-sm-2">
                            <label class="control-label"  for="job_status">Job Status</label>

                            <select class="form-control" id="job_status" name="job_status">
                                <option value="">All Job Status</option>
                                <?php
                                $jobs=array(
                                    'Active'=>'Active',
                                    'Resigned'=>'Resigned',
                                    'Terminated'=>'Terminated',
                                    'NCNS'=>'NCNS',
                                    'De Active'=>'De Active',
                                );
                                if(is_array(@$jobs)||is_object(@$jobs))
                                    foreach(@$jobs as $k=>$v)
                                    {
                                        $select='';
                                        if(@$_GET['job_status']==$k||(@$_GET['status']==1&&$k=='Active')||(@$_GET['status']==2&&$k=='De Active'))
                                            $select='selected';
                                        echo '<option '.$select.' value="'.$v.'"  >'.$k.'</option>';
                                    }
                                ?>
                            </select>

                        </div>
                        <div class="col-sm-2">
                            <label class="control-label"  for="department">Department</label>

                            <select class="form-control" id="department" name="department">
                                <option value="">All Department</option>
                                <?php
                                if(is_array(@$department)||is_object(@$department))
                                    foreach(@$department as $type)
                                    {
                                        $select='';
                                        if(@$_GET['department']==$type->id)
                                            $select='selected';
                                        echo '<option '.$select.' value="'.$type->id.'"  >'.$type->title.'</option>';
                                    }
                                ?>
                            </select>

                        </div>
                        <div class="col-sm-3">
                            <label class="control-label"  for="gender">Gender</label>

                            <select class="form-control" id="gender" name="gender">
                                <option value="">All Genders</option>
                                <?php
                                $gender=array(
                                    '1'=>'Male',
                                    '2'=>'Female',
                                );
                                if(is_array(@$gender)||is_object(@$gender))
                                    foreach(@$gender as $k=>$v)
                                    {
                                        $select='';
                                        if(@$_GET['gender']==$k)
                                            $select='selected';
                                        echo '<option '.$select.' value="'.$k.'"  >'.$v.'</option>';
                                    }
                                ?>
                            </select>

                        </div>
                        <div class="col-sm-2">
                            <label class="control-label"  for="erv">ERV</label>
                            <select class="form-control" id="erv"
                                    name="erv">
                                <option value="">All ERV</option>
                                <?php
                                $jobs=array(
                                    'Verified'=>'Verified',
                                    'Not Verified'=>'Not Verified',
                                    'Still in Process'=>'Still in Process'
                                );
                                if(is_array(@$jobs)||is_object(@$jobs))
                                    foreach(@$jobs as $k=>$v)
                                    {
                                        $select='';
                                        if(@$_GET['erv']==$k)
                                            $select='selected';
                                        echo '<option '.$select.' value="'.$k.'"  >'.$v.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                    </div>









                </div>
                <div class="box-footer">


                    <div class="pull-right">
                        <button type="reset" class="btn btn-default">Reset</button>
                        <button type="submit" class="btn btn-success">Apply Filter</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="table-responsive">
<table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
    <th>Employee Number</th>
    <th>Name</th>
    <th>Father Name</th>
    <th>CNIC</th>
    <th>Phone</th>
    <th>Department</th>
    <th>Designation</th>
    <th>BPS</th>
    <th>Job Type</th>
    <th>Photo Status</th>
    <?php
    if(is_dr_user_payroll(false)){
        ?>
        <th>Date of Joining</th>
        <th>Expire Date</th>
    <?php }
    ?>
    <?php if(is_admin(false)){?>
        <th>Email</th>
        <th>Mobile</th>
        <th>Address</th>
        <th>Blood Group</th>
        <th>Biometric ID</th>
    <?php }?>

    <th>Action</th>
</tr>
</thead>
    <tbody>
    <?php if(is_array(@$employees)||is_object(@$employees))
    foreach($employees as $type)
    {?>
        <tr>
            <td>
                <?php
            if(empty($type->emp_no)) {
                ?>
                <input type="number"
                       id="emp_<?php echo $type->slug ?>"

                       value=""

                       class="emp_no">
            <?php
            }else{
                echo $type->emp_no;
            }
                ?>

            </td>
            <td><?php echo @$type->title.' '.$type->name ?></td>
            <td><?php echo $type->father_name ?></td>
            <td><?php echo $type->cnic ?></td>
            <td><?php echo $type->phone_no ?></td>
            <td><?php echo $type->department ?></td>
            <td><?php echo $type->designation ?></td>
            <td><?php echo $type->bps ?></td>
            <td><?php echo $type->job_type ?></td>
            <td>
                <?php
                if(!empty($type->img) && file_exists ( FCPATH.'uploads/employees/'.$type->img  ))
                {?>
                    <span class="label label-success">Available</span>
            <?php }else{
                ?>
                    <span class="label label-default">Not Available</span>
            <?php }
            ?>
            </td>
            <?php
            if(is_dr_user_payroll(false)){
                ?>
                <td><?php echo $type->doa ?></td>
                <td><?php echo $type->expire_date ?></td>
            <?php }
            ?>
            <?php if(is_admin(false)){?>
                <td><?php echo $type->email ?></td>
                <td><?php echo $type->mobile_no ?></td>
                <td><?php echo $type->permanent_address ?></td>
                <td><?php echo $type->blood_group ?></td>
                <td><span class="label-success hidden "><?php echo $type->bm_id ?></span>
                    <img src="<?php echo base_url('uploads/employees/'.$type->img) ?>" width="80" height="80" alt="<?php echo $type->name ?>">
                    <input type="number" id="<?php echo $type->slug ?>" style="width: 80px" value="<?php echo $type->bm_id ?>" class="emp">
                    <input type="text" id="ldap_id__<?php echo $type->slug ?>" style="width: 80px" value="<?php echo $type->ldap_id ?>" class="ldap">
                </td>

            <?php }?>
            <td>
                <a target="_blank" href="<?php echo base_url('cms/employees/crud/'.$type->slug.'/read')  ?>"
                   class=" btn btn-info btn-sm" title="View"><i class="fa fa-book"></i></a>
                <a href="<?php echo base_url('cms/employees/crud/'.$type->slug)  ?>"
                   class=" btn btn-info btn-sm" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                <a
                    onclick="return confirm('Are you sure want to delete?')"
                    href="<?php echo base_url('cms/employees/crud/' . $type->slug.'/delete'); ?>"
                    class=" btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></a>

            </td>

        </tr>
    <?php }
    ?>

    </tbody>

</table>
    </div>
</div><!-- /.box-body -->
</div><!-- /.box -->
</div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->




<?php $this->load->view('include/footer'); ?>
<script>
    $(document).on('change','.emp', function () {
        $(this).addClass('bg-warning');
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('cms/employees/update') ?>",
            data: { slug: this.id, value: this.value }
        })
            .done(function( msg ) {
                $('#'+msg).removeClass('bg-warning');
            });
    });
    $(document).on('change','.ldap', function () {
        $(this).addClass('bg-warning');
        var field= this.id.split('__');
        $.ajax({
                method: "POST",
                url: "<?php echo base_url('cms/employees/generic_update') ?>",
                data: { slug: field[1],field:field[0], value: this.value }
            })
            .done(function( msg ) {
                $('#'+field[0]+"__"+msg).removeClass('bg-warning');
            });
    });
    $(document).on('change','.emp_no', function () {
        $(this).addClass('bg-red-gradient');
        var field=this.id.split('_');
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('cms/employees/update') ?>",
            data: { emp_no:1,slug:field[1] , value: this.value }
        })
            .done(function( msg ) {
                $('#emp_'+msg).removeClass('bg-red-gradient');
            });
    });
    $(function () {
        $("#example1").DataTable({
            "paging": true,
            dom: 'Bfrtip',
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            ],
            buttons: [
                'excel', 'pageLength'
            ]
        });
        $('#example2').DataTable({
            "paging": true,
            dom: 'Bfrtip',
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            ],
            buttons: [
                'excel', 'pageLength'
            ]
        });
    });
</script>
