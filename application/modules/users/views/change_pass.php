<?php $this->load->view('include/header');?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo @$title ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
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
                <i class="fa fa-user"></i>
                <h3 class="box-title"></h3>
                <button type="button" onclick="window.location.href='<?php echo base_url()?>'" class="btn btn-info pull-right">Back</button>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form id="form1" class="form-horizontal" action="" method="post">
                <input type="hidden" value="<?php echo @$this->session->userdata('id'); ?>" name="update_id">
                <div class="box-body">

                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="old_password">Password</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control"
                                   id="old_password"
                                   name="old_password"
                                   placeholder="old password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="password">Password</label>
                        <div class="col-sm-6">
                            <input type="password" class="form-control validate[required,minSize[4],equals[con-password]]"
                                   id="password"
                                   name="password"
                                   placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="con-password">Confirm Password</label>
                        <div class="col-sm-6">
                            <input type="password"  class="form-control validate[equals[password]]"
                                   id="con-password"
                                   name="con-password"
                                   placeholder="Confirm Password">
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
    $(document).ready(function(){
        $("#form1").validationEngine(
        );
    });
</script>