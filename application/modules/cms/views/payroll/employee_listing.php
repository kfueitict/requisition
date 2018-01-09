<?php $this->load->view('include/header');?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
        <h1>
            <i class="fa fa-cubes"></i>
            Employees
            <small><a class="btn btn-success" target="_blank" href="<?php echo current_url().'/payroll_sheet'; ?>">Download Payroll Sheet</a></small>
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

                    <div class="col-sm-3">
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


    <form method="post" action="">
        <button type="submit" name="sendmail" value="1" class="btn btn-success margin-bottom">Send Mail</button>
        <table id="example1" class="table table-bordered table-striped">

            <thead>
            <tr>
                <th><input type="checkbox" value="1" id="checkAll"></th>
                <th>Employee No</th>
                <th>Name</th>
                <th>Father Name</th>
                <th>CNIC</th>
                <th>Date of Joining</th>
                <th>Department</th>
                <th>Designation</th>
                <th>Email</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array(@$employees)||is_object(@$employees))
                foreach($employees as $type)
                {?>
                    <tr>
                        <th><input type="checkbox" name="employees[]" value="<?php echo $type->slug ?>"></th>
                        <td><?php echo $type->emp_no ?></td>
                        <td><?php echo $type->name ?></td>
                        <td><?php echo $type->father_name ?></td>
                        <td><?php echo $type->cnic ?></td>
                        <td><?php echo $type->doa ?></td>
                        <td><?php echo $type->department ?></td>
                        <td><?php echo $type->designation ?></td>
                        <td><?php echo $type->email ?></td>
                        <td>
                             <?php
                            if($type->pr_emp==null)
                            {?>
                                <a href="<?php echo base_url('cms/payroll/cru?mode=add&emp='.$type->slug)  ?>"
                                   class=" btn btn-info btn-sm" title="Add Payroll"><i class="fa fa-plus"></i></a>
                            <?php

                            }else
                            {
                                ?>
                                <a target="_blank" href="<?php echo base_url('cms/payroll/cru?mode=edit&payroll='.$type->pr_emp.'&emp='.$type->slug)  ?>"
                                   class=" btn btn-info btn-sm" title="Edit Payroll"><i class="fa fa-pencil-square-o"></i></a>
                                <a href="<?php echo base_url('cms/payroll/cru?mode=pdf&payroll='.$type->pr_emp.'&emp='.$type->slug)  ?>"
                                   class=" btn btn-info btn-sm" title="Download Payroll"><i class="fa fa-file-pdf-o"></i></a>
                                <a href="<?php echo base_url('cms/payroll/sendmail?mode=pdf&payroll='.$type->pr_emp.'&emp='.$type->slug)  ?>"
                                   class=" btn btn-info btn-sm" title="Email"><i class="fa fa-mail-forward"></i></a>
                            <?php
                            }
                            ?>


                        </td>

                    </tr>
                <?php }
            ?>

            </tbody>

        </table>
    </form>

</div><!-- /.box-body -->
</div><!-- /.box -->
</div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->




<?php $this->load->view('include/footer'); ?>
<script>
    function editUser(payroll,emp_slug){
        $.ajax({
            type: 'POST',
            dataType:'JSON',
            url: 'userAction.php',
            data: 'mode=edit&payroll=1&emp=muhammad-sabtain-khan'+id,
            success:function(data){
                $('#idEdit').val(data.id);
                $('#nameEdit').val(data.name);
                $('#emailEdit').val(data.email);
                $('#phoneEdit').val(data.phone);
                $('#editForm').slideDown();
            }
        });
    }
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
    $(function () {

        $("#example1").DataTable(
        );

    });

    $("#checkAll").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));

    });
    //toastr.info('Item Created Successfully.', 'Success Alert', {timeOut: 5000});

</script>
