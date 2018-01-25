<?php
$this->load->view('include/header');
?>
<style>
    tr.approvedbyhod {
        background-color: rgba(150,255,100,0.5) !important;
    }

    tr.approvedbypro {
        background-color: rgba(100,255,100,0.5) !important;
    }
    tr.approved {
        background-color: rgba(243, 255, 100, 0.5) !important;
    }
    tr.rejected {
        background-color: rgba(252, 9, 61,0.16) !important;
    }


</style>
<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo @$title ?>
          </h1>

          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Requisition Listing</li>
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
        <?php if($this->session->flashdata('message-error'))
        {?>
            <div class="box-body">
                <div class="alert alert-error alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                    <?php echo $this->session->flashdata('message-error') ;?>
                </div>
            </div>
        <?php }
        ?>

        <section>
            <div class="box">
                <div class="box-body">
                    <form method="post" action="<?php echo base_url('items/request') ?>">
                        <input type="hidden" name="step" value="task_listing">
                        <input type="hidden" name="emp_id" value="<?php echo $this->session->userdata('emp_id') ?>">
<!--                        --><?php //if(@$type=='pending') { ?>
<!--                    <div class="mailbox-controls">-->
<!--                        <!-- Check all button -->
<!--                        <button type="button" class="btn btn-default btn-lg checkbox-toggle"><i class="fa fa-square-o"></i>-->
<!--                        </button>-->
<!--                        <div class="btn-group">-->
<!--                            <button type="submit" name="status" value="1" class="btn btn-default btn-lg"><i class="fa fa-check"></i> Approve</button>-->
<!--                            <button type="submit" name="status" value="2" class="btn btn-default btn-lg"><i class="fa fa-ban"></i> Reject</button>-->
<!--                        </div>-->
<!--                        <!-- /.btn-group -->
<!--                        <div class="pull-right">-->
<!---->
<!--                            <div class="btn-group">-->
<!--                                <button type="button" onclick="window.history.back();" class="btn btn-info pull-right">Back</button>-->
<!--                            </div>-->
<!--                            <!-- /.btn-group -->
<!--                        </div>-->
<!--                        <!-- /.pull-right -->
<!--                    </div>-->
<!--                        --><?php //} ?>
                    <div class="table-responsive">
                <table id="leaves" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <?php if(@$type=='pending') { ?>
<!--                        <th>-->
<!--                            </th>-->
                        <?php } ?>
                        <th>Request Date</th>
                        <th>Employee</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody class="tbl-rows">
                    <?php
                    $status=array(
                        0=>'pending',
                        1=>'approvedbyhod',
                        2=>'rejected',
                        3=>'refertovc',
                        4=>'refertostore',
                        5=>'returntoproc',
                        6=>'approvedbypro',
                        7=>'approvedbyvc',
                        8=>'rejectedbyvc',
                        9=>'partialapproved',
                        10=>'verifiedandclosed',
                        11=>'withdraw'
                    );
                    if(is_array(@$leaves)||is_object(@$leaves))
                        foreach($leaves as $lv)
                        {?>
                            <tr class="<?php echo $status[$lv->status] ?>">
                                <td><?php echo $lv->request_date ?></td>
                                <td><?php echo $lv->emp_no ?>-<?php echo $lv->name ?> (<?php echo $lv->department ?>)</td>
                                <td>
                                    <a href="<?php echo base_url('items/request/ru/step/'.$lv->id) ?>" class=" btn btn-info btn-sm" title="Take Action"><i class="glyphicon glyphicon-check"></i></a>
<!--<a href="--><?php //echo base_url('Items/history/'.$lv->id) ?><!--" data-reqid='--><?php //echo $lv->id ?><!--' class="modalPop btn btn-info btn-sm" data-toggle="modal" data-target="#myModal" title="History"><i class="glyphicon glyphicon-plus"></i></a>-->
                                    <!-- Link trigger modal -->
                                    <a href="<?php echo base_url('Items/history/'.$lv->emp_id) ?>" data-toggle="modal" data-target="#myModal" data-remote="false" class="btn btn-info btn-sm" >
                                        <i class="fa fa-line-chart"></i>
                                    </a>


                                    <?php if(($status[$lv->status] =='approved') && ($isPro == $this->session->userdata('emp_id'))) { ?>
                                    <a href="<?php echo base_url('items/request/ru/step/'.$lv->id) ?>?download=pdf" class=" btn btn-info btn-sm" title="Download RFQ"><i class="glyphicon glyphicon-list-alt"></i></a>
                                    <?php } else {?>
                                    <a  href="<?php echo base_url('items/request/ru/step/'.$lv->id) ?>?download=pdf" role='button' class=" btn btn-info btn-sm" title="Download RFQ" style="display: none" ><i class="glyphicon glyphicon-list-alt"></i></a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php }
                    ?>

                    </tbody>

                </table>
            </div>
                    </form>
            </div>
            </div>

        </section>

<!--        --><?php
//        echo @$previous_el_balance[$emp->slug]."<br>";
//        echo @$leaves["cl_balance"][$emp->slug]."<br>";
//        echo @$leaves["el_balance"][$emp->slug]."<br>";
//        echo @$leaves["el_leaves"][$emp->slug]."<br>";
//        echo @$leaves["employees"][0]["CL"]."<br>";
//        echo @$leaves["employees"][0]["EL"]."<br>";
//        echo @$leaves["employees"][0]["short Leave"]."<br>";
//
//        ?>


    </section><!-- /.content -->

      </div><!-- /.content-wrapper -->


<!-- Modal -->
<!-- Default bootstrap modal example -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">History</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<!--                <button type="button" class="btn btn-primary">Save changes</button>-->
            </div>
        </div>
    </div>
</div>
      <?php $this->load->view('include/footer'); ?>
<script>
    $("#leaves").DataTable();
</script>
<script>
    $(function () {
        //Enable iCheck plugin for checkboxes
        //iCheck for checkbox and radio inputs
        $('.mailbox-messages input[type="checkbox"]').iCheck({
            checkboxClass: 'icheckbox_flat-blue',
            radioClass: 'iradio_flat-blue'
        });

        //Enable check and uncheck all functionality
        $(".checkbox-toggle").click(function () {
            var clicks = $(this).data('clicks');
            if (clicks) {
                //Uncheck all checkboxes
                $(".tbl-rows input[type='checkbox']").iCheck("uncheck");
                $(".fa", this).removeClass("fa-check-square-o").addClass('fa-square-o');
            } else {
                //Check all checkboxes
                $(".tbl-rows input[type='checkbox']").iCheck("check");
                $(".fa", this).removeClass("fa-square-o").addClass('fa-check-square-o');
            }
            $(this).data("clicks", !clicks);
        });

        //Handle starring for glyphicon and font awesome
        $(".mailbox-star").click(function (e) {
            e.preventDefault();
            //detect type
            var $this = $(this).find("a > i");
            var glyph = $this.hasClass("glyphicon");
            var fa = $this.hasClass("fa");

            //Switch states
            if (glyph) {
                $this.toggleClass("glyphicon-star");
                $this.toggleClass("glyphicon-star-empty");
            }

            if (fa) {
                $this.toggleClass("fa-star");
                $this.toggleClass("fa-star-o");
            }
        });
    });
</script>
