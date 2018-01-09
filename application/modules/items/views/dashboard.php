<?php
$this->load->view('include/header');
?>

<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Dashboard
            <small>Requisition</small>
          </h1>

          <ol class="breadcrumb">
            <li><a href="<?php echo base_url()?>"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="#"><i class="fa fa-calendar-check-o"></i> Requisition </a></li>
            <li class="active">Dashboard</li>
          </ol>
        </section>
    <!-- Main content -->

    <section class="content">
        <?php if($this->session->flashdata('message')||$this->session->flashdata('message-error'))
        {?>
        <div class="row">
            <div class="col-md-12">
                <div class="box-body">
                    <?php if($this->session->flashdata('message'))
                    {?>

                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

                            <h4><i class="icon fa fa-info"></i> Alert!</h4><?php echo $this->session->flashdata('message') ;?>
                        </div>

                    <?php }
                    ?>
                    <?php if($this->session->flashdata('message-error'))
                    {?>

                        <div class="alert alert-error alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                            <?php echo $this->session->flashdata('message-error') ;?>
                        </div>

                    <?php }
                    ?>
                </div>
            </div>
            </div>
            <!-- /.row -->
        <?php }
        ?>
        <section>
            <div class="row">

                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Quick Actions</h3>
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
                                        <ul class="users-list clearfix">
                                            <li>

                                                <a class="users-list-name" href="<?php echo base_url('items/wizard') ?>">
                                                    <img
                                                         src="<?php echo base_url('assets/img/Requirement.png') ?>" alt="Initiate a Request">
                                                    <span class="users-list-date">Initiate a Request</span>
                                                </a>

                                            </li>
                                            <?php if(@$proceed_request > 0) { ?>
                                            <li>
<!--                                                alert("test")-->
                                            </li>
                                            <?php } ?>
                                            <?php if(true) { ?>
                                                <li>

                                                    <a class="users-list-name" href="<?php echo base_url('items/status/in-process') ?>">
                                                        <img
                                                            src="<?php echo base_url('assets/img/pending.png') ?>" alt="Initiate a Request">
                                                        <span class="users-list-date">Vew Pending Requests</span>
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
    </section><!-- /.content -->

      </div><!-- /.content-wrapper -->
      <?php $this->load->view('include/footer'); ?>
<script>
    $("#emptbl").DataTable();
   // $(".select2").select2();
</script>
