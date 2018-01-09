<?php $this->load->view('include/header');?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
        <h1>
            <i class="fa fa-users"></i>
            Users
            <small><a href="<?php echo base_url('users/crud') ?>" class="btn btn-block btn-default btn-xs" ><i class="fa fa-user"></i> Add New User</a></small>
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
    <th>Created Date</th>
    <th>User ID</th>
    <th>User Name</th>
    <th>Email</th>
    <th>Type</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>
    <tbody>
    <?php
    if(is_array(@$users)||is_object(@$users))
    foreach($users as $user)
    {
        ?>
        <tr>
            <td><?php echo $user->created_date ?></td>
            <td><?php echo $user->user_id ?></td>
            <td><?php echo $user->first_name.' '.$user->last_name ?></td>
            <td><?php echo $user->email ?></td>
            <td><?php echo $user->title ?></td>
            <td>
                <?php if($user->status) { ?>
                <span class="label label-success">Active</span>
                <?php }else{
                    echo '<span class="label label-danger">Block</span>';
                }?>

            </td>
            <td>
                <a href="<?php echo base_url('users/crud/'.$user->id)  ?>"
                   class=" btn btn-info btn-sm" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                <a
                    onclick="return confirm('Are you sure want to delete?')"
                    href="<?php echo base_url('users/crud/' . $user->id.'/delete'); ?>"
                    class=" btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
    <?php }
    ?>
    </tbody>
<tfoot>
<tr>
    <th>Created Date</th>
    <th>User ID</th>
    <th>User Name</th>
    <th>Email</th>
    <th>Type</th>
    <th>Status</th>
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
