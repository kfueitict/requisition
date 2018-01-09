<?php $this->load->view('include/header');?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
        <h1>
            <i class="fa fa-cubes"></i>
            Degrees
            <small><a href="<?php echo base_url('cms/degrees/crud') ?>" class="btn btn-block btn-default btn-xs" ><i class="fa fa-cube"></i> Add New Degree</a></small>
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
    <th>Title</th>
    <th>Action</th>
</tr>
</thead>
    <tbody>
    <?php if(is_array(@$degrees)||is_object(@$degrees))
    foreach($degrees as $type)
    {?>
        <tr>
            <td><?php echo $type->title ?></td>
            <td>
                <a href="<?php echo base_url('cms/degrees/crud/'.$type->slug)  ?>"
                   class=" btn btn-info btn-sm" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                <a
                    onclick="return confirm('Are you sure want to delete?')"
                    href="<?php echo base_url('cms/degrees/crud/' . $type->slug.'/delete'); ?>"
                    class=" btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></a>
            </td>

        </tr>
    <?php }
    ?>

    </tbody>
<tfoot>
<tr>
    <th>Title</th>
    <th>Action</th>
</tr>
</tfoot>
</table>
</div><!-- /.box-body -->
</div><!-- /.box -->
</div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->




<?php $this->load->view('include/footer'); ?>
<script>
    $(function () {
        $("#example1").DataTable();
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
