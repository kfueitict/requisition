<?php $this->load->view('include/header');?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
        <h1>
            <i class="fa fa-cubes"></i>
            Employees Head Count
            <small><a class="btn btn-success" target="_blank" href="<?php echo base_url().'cms/employees/headcount?dept=all-departments'; ?>">Download All Departments</a></small>

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
    <th>Department</th>
    <th>Headcount</th>
    <th>Regular</th>
    <th>Adhoc</th>
    <th>Action</th>
</tr>
</thead>
    <tbody>
    <?php if(is_array(@$employees)||is_object(@$employees))
    foreach($employees as $type)
    {?>
        <tr>
            <td><?php echo $type->department ?></td>
            <td><?php echo $type->c ?></td>
            <td><?php echo $type->regular ?></td>
            <td><?php echo $type->Adhoc ?></td>
            <td>
                <a target="_blank" href="<?php echo base_url('cms/employees/headcount?dept='.$type->slug)  ?>"
                   class=" btn btn-info btn-sm" title="Download Sheet"><i class="fa fa-book"></i></a>

            </td>

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
        $("#example1").DataTable({
            "paging": true,
            dom: 'Bfrtip',
            "lengthChange": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            ],
            buttons: [
                 'excel'
            ]
        });
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
