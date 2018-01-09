<?php $this->load->view('include/header');?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo @$title ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('cms/overtime/employees') ?>"><i class="fa fa-cubes"></i>Employees</a></li>
            <li class="active"><?php echo @$title ?></li>
        </ol>
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
        <div class="box box-info">
            <div class="box-header with-border">
                <i class="fa fa-cube"></i>
                <h3 class="box-title"></h3>
                <button type="button" onclick="window.location.href='<?php echo $_SERVER['HTTP_REFERER']?>'" class="btn btn-info pull-right">Back</button>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form id="form1" class="form-horizontal" action="" method="post">
                <input type="hidden" name="emp_id" id="emp_id" value="<?php echo $row->bm_id ?>">
                <input type="hidden" id="tbl" value="degrees">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="emp_name">Employee Name</label>
                        <div class="col-sm-6">
                            <input required="" type="text" disabled
                                   class="form-control date"
                                   value="<?php echo @$row->name ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="date_time">Date Time</label>
                        <div class="col-sm-6">
                            <input required="" type="text"
                                   class="form-control date"
                                   value=""
                                   id="date_time"
                                   name="date_time">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="CHECKTYPE">CHK Type</label>
                        <div class="col-sm-6">
                            <select name="CHECKTYPE" id="CHECKTYPE" class="form-control">
                                <option value="i">IN</option>
                                <option value="o">OUT</option>
                            </select>
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
        $('#date_time').datetimepicker();
    });
</script>