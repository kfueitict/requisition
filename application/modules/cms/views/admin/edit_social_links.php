<?php echo $this->load->view('admin/header'); ?>
<!-- BEGIN CONTAINER -->
<div id="container" class="row-fluid">

    <!-- BEGIN PAGE -->  
    <div id="main-content">
        <!-- BEGIN PAGE CONTAINER-->
        <div class="container-fluid">
            <!-- BEGIN PAGE HEADER-->   
            <div class="row-fluid">
                <div class="span12">
                    <h3 class="page-title"> <?php echo $title; ?> </h3>
                    <!-- BEGIN VALIDATION STATES-->
                    <div class="widget">
                        <div class="widget-title">
                            <h4><i class="icon-tasks"></i> <?php echo $title; ?> </h4>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"></a>
                                <a href="#portlet-config" data-toggle="modal" class="config"></a>
                                <a href="javascript:;" class="reload"></a>
                                <a href="javascript:;" class="remove"></a>
                            </div>
                        </div>
                        <div class="widget-body form">
                            <?php if ($this->session->flashdata('msg')) { ?>
                                <div class='alert alert-success'>
                                    <button class='close' data-dismiss='alert'>×</button><?php echo $this->session->flashdata('msg'); ?>
                                </div>
                            <?php } ?>
                            <?php if ($this->session->flashdata('msg_error')) { ?>
                                <div class='alert alert-error'>
                                    <button class='close' data-dismiss='alert'>×</button><?php echo $this->session->flashdata('msg_error'); ?>
                                </div>
                            <?php } ?>
                            <!-- BEGIN FORM id="signupForm" -->
                            <form class="cmxform form-horizontal"  method="post" enctype="multipart/form-data">
                                <input type="hidden" name="update_id" value="<?php echo @$records->id ?>">

                                <div class="control-group ">
                                    <label for="img_1" class="control-label">Image</label>
                                    <div class="controls">
                                        <input type="file" name="img_1" id="img_1" />
                                    </div>
                                    <div class="controls">
                                        <img src="<?php echo base_url('uploads/slider/' . @$records->img_src); ?>" height="214" width="307" alt="Slider Image" />
                                    </div>

                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="title">Image Title</label>
                                    <div class="controls">
                                        <input type="text" class="span6" value="<?php echo @$records->title ?>" name="title" id="title" required=""/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="alt">Alt Text</label>
                                    <div class="controls">
                                        <input type="text" class="span6" value="<?php echo @$records->alt ?>" name="alt" id="alt" required=""/>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="url">Url</label>
                                    <div class="controls">
                                        <input type="text" class="span6" value="<?php echo @$records->url ?>" required="" name="url" id="url"/>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="order">Image Order </label>
                                    <div class="controls">
                                        <input type="number" class="span6" value="<?php echo @$records->order ?>" name="order" id="order" required=""/>
                                    </div>
                                </div>  
                                <div class="control-group ">
                                    <label for="status" class="control-label">Status</label>
                                    <div class="controls">
                                        <input type="checkbox" name="status" id="status" value="1"  <?php if (isset($records) && $records->status) echo 'checked'; ?>>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label for="status" class="show_in_header">Show in Header</label>
                                    <div class="controls">
                                        <input type="checkbox" name="show_in_header" id="show_in_header" value="1"
                                            <?php if (isset($records) && $records->show_in_header) echo 'checked'; ?>>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label for="status" class="show_in_site">Show in Site</label>
                                    <div class="controls">
                                        <input type="checkbox" name="show_in_site" id="show_in_site" value="1"
                                            <?php if (isset($records) && $records->show_in_site) echo 'checked'; ?>>
                                    </div>
                                </div>
                                <div class="control-group ">
                                    <label for="status" class="show_in_footer">Show in Footer</label>
                                    <div class="controls">
                                        <input type="checkbox" name="show_in_footer" id="show_in_footer" value="1"
                                            <?php if (isset($records) && $records->show_in_footer) echo 'checked'; ?>>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <input name="submit" class="btn btn-success" type="submit" value="Save">
                                    <input class="btn" type="reset" value="Cancel">
                                </div>

                            </form>
                            <!-- END FORM-->
                        </div>
                    </div>
                    <!-- END VALIDATION STATES-->
                </div>
            </div>
            <!-- END PAGE HEADER-->





            <!-- END PAGE CONTENT-->         
        </div>
        <!-- END PAGE CONTAINER-->
    </div>
    <!-- END PAGE -->  
</div>
<!-- END CONTAINER -->
<?php echo $this->load->view('admin/footer'); ?>

<script>
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('Description');
</script>