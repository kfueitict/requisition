<?php $this->load->view('include/header');?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo @$title ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('cms/overtime') ?>"><i class="fa fa-cubes"></i>Overtime</a></li>
            <li class="active"><?php echo @$title ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <i class="fa fa-cube"></i>
                <h3 class="box-title"></h3>
                <button type="button" onclick="window.location.href='<?php echo base_url('cms/overtime')?>'" class="btn btn-info pull-right">Back</button>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form id="form1" class="form-horizontal" action="" method="post">
                <input type="hidden" name="row_id" id="row_id" value="<?php echo $row->id ?>">

                <div class="box-body">

                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="date_time">From Date</label>
                        <div class="col-sm-6">
                            <input required="" type="text"
                                   class="form-control datepicker"
                                   value="<?php echo @$row->from_date ?>"
                                   id="from_date"
                                   name="from_date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="date_time">To Date</label>
                        <div class="col-sm-6">
                            <input required="" type="text"
                                   class="form-control datepicker"
                                   value="<?php echo @$row->to_date ?>"
                                   id="to_date"
                                   name="to_date">
                        </div>
                    </div>




                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-success"><?php echo @$button; ?></button>
                        </div>
                </div><!-- /.box-footer -->
            </form>
        </div><!-- /.box -->


    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php $this->load->view('include/footer'); ?>
<script type="text/javascript">
    $(function () {
        $('.datepicker').datepicker(
            {
                format:'yyyy-mm-dd'
            }
        );
    });

</script>