<?php
$this->load->view('include/header');
?>
<style>
    .chart-legend li span{
        display: inline-block;
        width: 12px;
        height: 12px;
        margin-right: 5px;
    }
</style>
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Control panel</small>
          </h1>

          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box-body">
                    <?php if($this->session->flashdata('message'))
                    {?>

                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-info"></i> Alert!</h4>
                            <?php echo $this->session->flashdata('message') ;?>
                        </div>

                    <?php }
                    ?>





                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->

        </div>
     
        <div class="row">

            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-calendar"></i> Quick Actions</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center">
                                    <ul class="leaves">
                                        <li style="margin-right: 11px;">
                                            <a class="" href="<?php echo base_url('items/wizard') ?>">
                                                <img
                                                    src="<?php echo base_url('assets/img/Requirement.png') ?>" alt="Initiate a Request">
                                                <span class="">Initiate a Request</span>
                                            </a>

                                        </li>
                                        <?php if(@$proceed_request > 0) { ?>
                                            <li style="margin-right: 11px;">

                                                <a class="" href="<?php echo base_url('items/request/tasks/pending') ?>">
                                                    <img
                                                        src="<?php echo base_url('assets/img/process_accept.png') ?>" alt="Initiate a Request">
                                                    <span class="">Proceed a Request</span>
                                                </a>

                                            </li>
                                        <?php } ?>

                                        <?php if(true) { ?>
                                            <li>

                                                <a class="" href="<?php echo base_url('items/status/in-process') ?>">
                                                    <img
                                                        src="<?php echo base_url('assets/img/pending.png') ?>" alt="Initiate a Request">
                                                    <span class="">Vew Pending Requests</span>
                                                </a>

                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>

                            </div>


                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <div class="box-footer"></div>
                    </div>
                    <!-- ./box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

    </section>
      </div><!-- /.content-wrapper -->
      <?php $this->load->view('include/footer'); ?>
<script>
   
  

</script>
