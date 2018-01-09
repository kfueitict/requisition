<?php $this->load->view('include/header');?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo @$title ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('cms/happening') ?>"><i class="fa fa-users"></i>Happening</a></li>
            <li class="active"><?php echo @$title ?></li>
        </ol>
    </section>
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
    <!-- Main content -->
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <i class="fa fa-user"></i>
                <h3 class="box-title"></h3>
                <button type="button"
                        onclick="window.location.href='<?php echo base_url('cms/happening')?>'" class="btn btn-info pull-right">Back</button>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form id="form1" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" value="<?php echo @$user->id ?>" name="update_id">
                <input type="hidden" id="tbl" value="faculty">
                <div class="box-body">

                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="first_name">Title</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control"
                                   value="<?php echo @$user->title ?>"
                                   id="title"
                                   name="title"
                                   placeholder="Title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="first_name">Short Description</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control"
                                   value="<?php echo @$user->short_description ?>"
                                   id="short_description"
                                   name="short_description"
                                   placeholder="short description">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="first_name">Display Order</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control"
                                   value="<?php echo @$user->order ?>"
                                   id="order"
                                   name="order"
                                   placeholder="Display Order">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Status</label>
                        <div class="radio">
                            <label for="status-active">Active
                                <input type="radio" id="status-active" name="status" class="minimal" value="1" checked>
                            </label>
                            <label for="status-block">Block
                                <input type="radio" id="status-block" name="status" class="minimal-red" value="0">
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="first_name">Image</label>
                        <input type="hidden" name="old_img" value="<?php echo @$user->img ?>">
                        <div class="col-sm-6">
                            <input type="file" class="form-control"

                                   id="img"
                                   name="img"
                                   placeholder="Image">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="first_name">Alt Text</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control"
                                   value="<?php echo @$user->alt ?>"
                                   id="alt"
                                   name="alt"
                                   placeholder="Alt Text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="description">Description</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="description"
                                      name="description"
                                      placeholder="Description"><?php echo @$user->description ?></textarea>


                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-success"><?php echo @$button ?></button>
                        </div>
                </div><!-- /.box-footer -->
            </form>
        </div><!-- /.box -->


    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php $this->load->view('include/footer'); ?>
<script>
    CKEDITOR.replace('description', {toolbar : 'Full',filebrowserImageUploadUrl : BASE_URL+'/cms/happening/upload'});
</script>
<script>
    $(document).ready(function(){


        $("#form1").validationEngine(
        );
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