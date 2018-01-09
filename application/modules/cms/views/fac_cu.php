<?php $this->load->view('include/header');?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo @$title ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('cms/departments') ?>"><i class="fa fa-users"></i>Departments</a></li>
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
                <button type="button" onclick="window.location.href='<?php echo base_url('cms/departments/faculty')?>'" class="btn btn-info pull-right">Back</button>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form id="form1" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" value="<?php echo @$user->id ?>" name="update_id">
                <input type="hidden" id="tbl" value="faculty">
                <div class="box-body">

                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="first_name">Title</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" required=""
                                   value="<?php echo @$user->title ?>"
                                   id="title"
                                   name="title"
                                   placeholder="Title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="first_name">Image (300 X 300)</label>
                        <input type="hidden" name="old_img" value="<?php echo @$user->img ?>">
                        <div class="col-sm-6">
                            <input type="file" class="form-control"

                                   id="img"
                                   name="img"
                                   placeholder="Image">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label required"  for="user_type">Department</label>
                        <div class="col-sm-6">
                            <select class="form-control" required="" id="department" name="department">
                                <option value="">Select Department</option>
                                <?php
                                if(is_array(@$department)||is_object(@$department))
                                foreach(@$department as $type)
                                {
                                    $select='';
                                    if(@$user->department_id==$type->id)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$type->id.'"  >'.$type->title.'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" required=""  for="short_description">Short Description</label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control"
                                   value="<?php echo @$user->short_description ?>"
                                   id="short_description"
                                   name="short_description"
                                   placeholder="Short Description">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="description">Description</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="description" required=""
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
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace( 'description' );
</script>
<script>
    $(document).ready(function(){


        $("#form1").validationEngine(
        );
    });
</script>