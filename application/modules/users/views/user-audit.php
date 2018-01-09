<?php $this->load->view('include/header');?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
        <h1>
            <i class="fa fa-user-secret"></i>
            <?php echo @$title?>

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

                    <div class="col-md-3">
                        <label class=" control-label"  for="user_id">User ID</label>
                        <select class="form-control" id="user_id" name="user_id">
                            <option value="">All Users</option>
                            <?php
                            if(is_array(@$user_id)||is_object(@$user_id))
                                foreach(@$user_id as $type)
                                {
                                    $select='';
                                    if(@$_GET['user_id'] ==$type->user_id)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$type->user_id.'"  >'.$type->user_id.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class=" control-label"  for="section">Section</label>
                        <select class="form-control" id="section" name="section">
                            <option value="">All Sections</option>
                            <?php
                            if(is_array(@$sections)||is_object(@$sections))
                                foreach(@$sections as $type)
                                {
                                    $select='';
                                    if(@$_GET['section'] ==$type->section)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$type->section.'"  >'.$type->section.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class=" control-label"  for="action">Action</label>
                        <select class="form-control" id="action" name="action">
                            <option value="">All Action</option>
                            <?php
                            if(is_array(@$actions)||is_object(@$actions))
                                foreach(@$actions as $type)
                                {
                                    $select='';
                                    if(@$_GET['action'] ==$type->action)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$type->action.'"  >'.$type->action.'</option>';
                                }
                            ?>
                        </select>
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
    <th>Date Time</th>
    <th>User</th>
    <th>Section</th>
    <th>Action</th>
    <th>URL</th>
</tr>
</thead>
    <tbody>
    <?php if(is_array(@$audit_data)||is_object(@$audit_data))
    foreach($audit_data as $type)
    {?>
        <tr>

            <td><?php echo date('Y-m-d H:i A',$type->time_string) ?></td>
            <td><?php echo $type->user_id ?></td>
            <td><?php echo $type->section ?></td>
            <td><?php echo $type->action ?></td>
            <td>
                <?php if(empty($type->data))
                {
                    echo $type->url_string;
                }else
                {?>
                    <div class="box collapsed-box">
                        <div class="box-header with-border">
                            <span class="box-title"><?php echo $type->url_string ?></span>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">

                                <div class="col-md-12">
                                    <?php echo $type->data ?>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- ./box-body -->
                    </div>
                    <!-- /.box -->
                <?php } ?>



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
    });
</script>
