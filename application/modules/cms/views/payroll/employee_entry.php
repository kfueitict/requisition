<?php $this->load->view('include/header');?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
        <h1>
            <i class="fa fa-cubes"></i>
            Employees
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
<table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
    <th>Name</th>
    <th>Department</th>
    <th>Designation</th>
    <th>Date of Joining</th>
    <th>Salary</th>
    <th>Overtme Amount</th>
</tr>
</thead>
    <tbody>
    <?php if(is_array(@$employees)||is_object(@$employees))
    foreach($employees as $type)
    {?>
        <tr>
            <td><?php echo $type->name ?></td>
            <td><?php echo $type->department ?></td>
            <td><?php echo $type->designation ?></td>
            <td><?php echo $type->doa ?></td>
            <td><?php echo $type->salary ?></td>
            <td><input type="number" class="fields" id="overtime-<?php echo $type->id ?>" value="<?php echo $type->overtime ?>"></td>
        </tr>
    <?php }
    ?>

    </tbody>

</table>
</div><!-- /.box-body -->
</div><!-- /.box -->
</div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->




<?php $this->load->view('include/footer'); ?>
<script>
    $(document).on('change','.fields', function () {
        $(this).addClass('bg-warning');
        var f=this.id.split('-');
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('cms/payroll/entry') ?>",
            data: { emp_id: f[1], field:f[0], value: this.value,fid:this.id }
        })
            .done(function( msg ) {
                $('#'+msg).removeClass('bg-warning');
            });
    });
    $(function () {
        $('#example1').DataTable({
            "paging": true,
            "pageLength": 200
        });
    });
</script>
