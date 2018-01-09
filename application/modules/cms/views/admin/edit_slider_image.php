<?php echo $this->load->view('include/header'); ?>
<!-- BEGIN CONTAINER -->
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            <?php echo @$title ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('cms/admin/sliderimages') ?>"><i class="fa fa-cubes"></i>Slider Images</a>
            </li>
            <li class="active"><?php echo @$title ?></li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <i class="fa fa-cube"></i>
                <h3 class="box-title"></h3>
                <button type="button" onclick="window.location.href='<?php echo base_url('sliderimages')?>'" class="btn btn-info pull-right">Back</button>
            </div><!-- /.box-header -->
            <!-- form start -->

            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                <input type="hidden" name="update_id" value="<?php echo @$records->id ?>">
                <div class="box-body">
                <div class="control-group ">
                    <label for="img_1" class="control-label">Image</label>

                    <div class="controls">
                        <input type="file" name="img_1" id="img_1"/>
                    </div>
                    <div class="controls">
                        <img src="<?php echo base_url('uploads/slider/' . @$records->img_src); ?>"
                             height="214" width="307" alt="Slider Image"/>
                    </div>

                </div>
                <div class="control-group">
                    <label class="control-label" for="title">Title</label>

                    <div class="controls">
                        <input type="text" class="span6" value="<?php echo @$records->title ?>"
                               name="title" id="title" required=""/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="alt">Alt Text</label>

                    <div class="controls">
                        <input type="text" class="span6" value="<?php echo @$records->alt ?>"
                               name="alt" id="alt" required=""/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="data_description">Description</label>

                    <div class="controls">
                        <input type="text" class="span6"
                               value="<?php echo @$records->data_description ?>"
                               name="data_description" id="data_description"/>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="order">Image Order </label>

                    <div class="controls">
                        <input type="number" class="span6" value="<?php echo @$records->order ?>"
                               name="order" id="order" required=""/>
                    </div>
                </div>
                <div class="control-group ">
                    <label for="status" class="control-label">Status</label>

                    <div class="controls">
                        <input type="checkbox" name="status" id="status"
                               value="1"  <?php if (isset($records) && $records->status) echo 'checked'; ?>>
                    </div>
                </div>
                </div>
                <div class="box-footer">
                <div class="form-actions">
                    <input name="submit" class="btn btn-success" type="submit" value="Save">
                    <input class="btn" type="reset" value="Cancel">
                </div>
                </div>
            </form>
        </div><!-- /.box -->


    </section><!-- /.content -->
</div>
<!-- END CONTAINER -->
<?php echo $this->load->view('include/footer'); ?>
<!---->
<!--<script>-->
<!--    // Replace the <textarea id="editor1"> with a CKEditor-->
<!--    // instance, using default configuration.-->
<!--    CKEDITOR.replace('Description');-->
<!--</script>-->