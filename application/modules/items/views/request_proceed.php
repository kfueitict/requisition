<?php
$this->load->view('include/header');


$req_status=leave_request_status();
foreach (@$leave_transactions as $tr) {
    $next_step = 0;
    if(!empty(@$tr->emp_no_n)){
        $next_step=@$tr->next_step;
    }
}
?>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?php echo @$title ?>
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('leaves') ?>"><i class="fa fa-dashboard"></i> Home</a></li>
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
            <?php ?>

            <div class="box box-info">
                <div class="box-header with-border">
                    <i class="glyphicon glyphicon-list-alt"></i>
                    <h3 class="box-title">Request Details</h3>
                    <button type="button" onclick="window.history.back();" class="btn btn-info pull-right">Back</button>
                </div>

                <div class="box-body">

                    <div class="row">
                        <div class="col-md-2 text-center">
                            <img class="img-bordered" src="<?php echo base_url('uploads/employees/'.@$leave_data->img) ?>"
                                 alt="<?php echo @$leave_data->name ?> Photo not available" style="width: 100%; height: auto">
                            <p class="padt-5"><strong>EMP NO:</strong> <?php echo @$leave_data->emp_no ?></p>
                        </div>
                        <div class="col-md-8 ">
                            <table class="table">
                                <tr>
                                    <th>Employee Name</th><td><?php echo @$leave_data->name ?></td>
                                    <th>Department</th><td><?php echo @$leave_data->department ?></td>
                                </tr>
                                <tr>

                                    <th>Designation</th><td><?php echo @$leave_data->designation ?></td>
                                    <th>Request Date</th><td><?php echo @$leave_data->request_date ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th><td><?php
                                        if(@$leave_data->status==0)
                                        {
                                            echo "<span class='label label-default'>".$req_status[@$leave_data->status]."</span>" ;
                                        }else if(@$leave_data->status==1)
                                        {
                                            echo "<span class='label label-success'>".$req_status[@$leave_data->status]."</span>" ;
                                        }else if(@$leave_data->status==2)
                                        {
                                            echo "<span class='label label-danger'>".$req_status[@$leave_data->status]."</span>" ;
                                        }else if(@$leave_data->status==3)
                                        {
                                            echo "<span class='label label-success'>".$req_status[@$leave_data->status]."</span>" ;
                                        }else if(@$leave_data->status==4) //refer to store
                                        {
                                            echo "<span class='label label-success'>".$req_status[@$leave_data->status]."</span>" ;
                                        }else if(@$leave_data->status==5) //refer to vc
                                        {
                                            echo "<span class='label label-success'>".$req_status[@$leave_data->status]."</span>" ;
                                        }else if(@$leave_data->status==6) //refer to vc
                                        {
                                            echo "<span class='label label-success'>".$req_status[@$leave_data->status]."</span>" ;
                                        }else if(@$leave_data->status==7) //approve by vc
                                        {
                                            echo "<span class='label label-success'>".$req_status[@$leave_data->status]."</span>" ;
                                        }else if(@$leave_data->status==8) //approve by vc
                                        {
                                            echo "<span class='label label-danger'>".$req_status[@$leave_data->status]."</span>" ;
                                        }else if(@$leave_data->status==9) //approve by vc
                                        {
                                            echo "<span class='label label-success'>".$req_status[@$leave_data->status]."</span>" ;
                                        }
                                        ?></td>
                                    <th>Request Initiated by </th><td><?php echo @$leave_data->username ?></td>
                                 </tr>
                          </table>
                        <center>
<!--                            <ul id="useful-links" class="list-inline">-->
                            <div class="row">
                                <div class="col-md-12 center-block">
                                <?php if($isProcur == $this->session->userdata('emp_id') &&   @$leave_data->status == 1) { ?>
<!--                                    <div class="col-md-6">-->
<!--                                    <form id="refervc" action="" method="post">-->
<!--                                        <input type="hidden" name="refer" value="vc">-->
<!--                                        <input type="hidden" name="request_id" value="--><?php //echo @$leave_data->request_id ?><!--">-->
<!--                                        <li style="display: table-cell">-->
<!--                                            <a href="#" onclick="document.getElementById('refervc').submit();">-->
<!--                                                <figure>-->
<!--                                                    <img style="width: 60px; height: auto;vertical-align:middle" src="--><?php //echo base_url('assets/img/vc.png') ?><!--" alt="Refer to VC">-->
<!--                                                    <figcaption><span class="">Refer to VC</span></figcaption>-->
<!--                                                </figure>-->
<!--                                            </a>-->
<!--                                        </li>-->
<!--                                    </form>-->
<!--                                    </div>-->
<!--                                    <div class=" col-md-6">-->
<!--                                    <form id="referstore" action="" method="post">-->
<!--                                        <input type="hidden" name="refer" value="store">-->
<!--                                        <input type="hidden" name="request_id" value="--><?php //echo @$leave_data->request_id ?><!--">-->
<!--                                        <li style="display: table-cell">-->
<!--                                            <a href="#" onclick="document.getElementById('referstore').submit();">-->
<!--                                                <figure>-->
<!--                                                    <img style="width: 60px; height: auto ;vertical-align:middle" src="--><?php //echo base_url('assets/img/store.png') ?><!--" alt="Refer to Store">-->
<!--                                                    <figcaption><span class="">Refer to Store</span></figcaption>-->
<!--                                                </figure>-->
<!--                                            </a>-->
<!--                                        </li>-->
<!--                                    </form>-->
<!--                                    </div>-->
                                <?php } ?>
                                <?php if($isStore == $this->session->userdata('emp_id') &&  @$leave_data->status == 4) { ?>
<!--                                        <form id="returntopro1" action="" method="post">-->
<!--                                            <input type="hidden" name="refer" value="returnprocur">-->
<!--                                            <input type="hidden" name="request_id" value="--><?php //echo @$leave_data->request_id ?><!--">-->
<!--                                            <li style="display: table-cell">-->
<!--                                                <a href="#" onclick="document.getElementById('returntopro').submit();">-->
<!--                                                    <figure>-->
<!--                                                        <img style="width: 60px; height: auto ;vertical-align:middle" src="--><?php //echo base_url('assets/img/vc.png') ?><!--" alt="Return To Procurement">-->
<!--                                                        <figcaption><span class="">Return To Procurement</span></figcaption>-->
<!--                                                    </figure>-->
<!--                                                </a>-->
<!--                                            </li>-->
<!--                                        </form>-->
                                <?php }?>
                                <?php if($isProcur == $this->session->userdata('emp_id') &&  (@$leave_data->status == 5 || @$leave_data->status == 7)) { ?>
<!--                                        <form id="approvebypro" action="" method="post">-->
<!--                                            <input type="hidden" name="refer" value="approvedbypro">-->
<!--                                            <input type="hidden" name="request_id" value="--><?php //echo @$leave_data->request_id ?><!--">-->
<!--                                            <li style="display: table-cell">-->
<!--                                                <a href="#" onclick="document.getElementById('approvebypro').submit();">-->
<!--                                                    <figure>-->
<!--                                                            <img style="width: 60px; height: auto ;vertical-align:middle" src="--><?php //echo base_url('assets/img/approve.png') ?><!--" alt="Refer to Store">-->
<!--                                                        <figcaption><span class="">Approve</span></figcaption>-->
<!--                                                    </figure>-->
<!--                                                </a>-->
<!--                                            </li>-->
<!--                                        </form>-->
                                <?php }?>
                                <?php if(($isVc == $this->session->userdata('emp_id')) &&  (@$leave_data->status == 3)) { ?>
<!--                                    <form id="approvedByViceChancellor" action="" method="post">-->
<!--                                        <input type="hidden" name="refer" value="approvedbyvc">-->
<!--                                        <input type="hidden" name="request_id" value="--><?php //echo @$leave_data->request_id ?><!--">-->
<!--                                        <li style="display: table-cell">-->
<!--                                            <a href="#" onclick="document.getElementById('approvedByViceChancellor').submit();">-->
<!--                                                <figure>-->
<!--                                                    <img style="width: 60px; height: auto ;vertical-align:middle" src="--><?php //echo base_url('assets/img/approve.png') ?><!--" alt="Refer to Store">-->
<!--                                                    <figcaption><span class="">Approved By Vice Chancellor</span></figcaption>-->
<!--                                                </figure>-->
<!--                                            </a>-->
<!--                                        </li>-->
<!--                                    </form>-->
                                <?php }?>
                                </div>
                            </div>
<!--                            </ul>-->
                        </center>
                        </div>
                    </div>
                    <form id="returntopro" action="" method="post">
                    <div class="form-group">
                        <input type="hidden" name="refer" value="returnprocur">
                            <input type="hidden" name="request_id" value="<?php echo @$leave_data->request_id ?>">

                        <table id=".62000" cellpadding="6" cellspacing="1" style="width:100%" border="0" class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
<th></th>
                                <th>Requested Qty</th>
                                <?php if(($isHod != $this->session->userdata('emp_id'))&& ($isProcur != $this->session->userdata('emp_id')) && ($isStore != $this->session->userdata('emp_id')) &&  (@$leave_data->status == 9)) { ?>
                                <th>Approved Quantity</th>
                                <th>Balance Quantity</th>
                                <?php } ?>
                                <?php if($isStore == $this->session->userdata('emp_id')) { ?>
                                    <th>Available Quantity</th>
                                    <th>Balance Quantity</th>
                                <?php } ?>
                                <th>Item Description</th>
                                <?php if($isStore == $this->session->userdata('emp_id')) { ?>
                                <th>Stock</th>
                                <?php }?>
                                <th>Reason</th>
                                <th>Comment</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                          <?php  if (is_array($cartTable) || is_object($cartTable)) {?>
                            <?php foreach($cartTable as $ct) {?>
                                <tr>
                                  <?php if($isStore == $this->session->userdata('emp_id')) { ?>
                                    <td style="width: 5%"><input class="checkRequest"  value="<?php echo $ct->rowid ?>" type="checkbox"><input type="hidden"  name="checkRequest[]" value="<?php echo $ct->rowid ?>"></td>
                                  <?php } else {?>
                                      <td style="width: 5%"><input disabled class="checkRequest"  value="<?php echo $ct->rowid ?>" type="checkbox"><input type="hidden"  name="checkRequest[]" value="<?php echo $ct->rowid ?>"></td>
                                <?php } ?>


                                    <td style="width: 10%">
                                    <?php if(@$leave_data->status==0) { ?>
                                        <input type="text" class="qty form-control" value="<?php echo $ct->qty ?>">
                                    <?php } else { ?>
                                    <label class="qty"><input type="hidden"  name="qty[]" value="<?php echo $ct->qty ?>"><?php echo $ct->qty ?></label>
                                    <?php }?>
                                    </td>
                                <?php if(($isHod != $this->session->userdata('emp_id'))&& ($isProcur != $this->session->userdata('emp_id')) && ($isStore != $this->session->userdata('emp_id')) &&  (@$leave_data->status == 9)) { ?>
                                    <td>
                                        <label class="available_qty"><input type="hidden"  name="available_qty[]" value="<?php echo $ct->available_qty ?>"><?php echo $ct->available_qty ?></label>
                                    </td>
                                    <td>
                                        <label class="balance_qty"><input type="hidden"  name="balance_qty[]" value="<?php echo $ct->balance_qty ?>"><?php echo $ct->balance_qty ?></label>
                                    </td>
                                    <?php }?>
                                    <?php if($isStore == $this->session->userdata('emp_id')) { ?>

                                    <td style="width: 10%">
                                        <input type="number" max="<?php echo $ct->qty ?>" class="availableqty form-control" min="0"  value="<?php echo $ct->available_qty?>" />
                                        <input type="hidden" name="availableqty[]" value="0">
                                    </td>

                                    <td style="width: 10%">
                                        <?php if( $ct->available_qty ==0 ) {?>
                                        <label class="balanceqty"><?php echo $ct->qty ?></label>
                                        <?php } else {?>
                                            <label class="balanceqty"><?php echo $ct->balance_qty ?></label>
                                        <?php } ?>
                                        <input type="hidden"  name="balanceqty[]" value="<?php echo $ct->balance_qty ?>">
                                    </td>
                                <?php } ?>

                                    <td style="width:20%" ><?php echo $ct->name?></td>

                                <?php if($isStore == $this->session->userdata('emp_id')) { ?>
                                    <?php
                                    $da  = get_data('http://10.1.0.4:9090/erp/stock.php?id='.$ct->id);
                                    $json1 = json_decode($da, true);
                                    ?>
                                   <td style="width:15%" ><?php
                                       if(is_null($json1[0]["stock"])){
                                       echo '0';
                                       }else{$json1[0]["stock"];} ?>
                                   </td>
                                    <?php }?>
                                    <td style="width:15%" ><?php echo $ct->reason?></td>

                                 <?php if($leave_data->status==0) { ?>
                                    <td style="width:20%" >
                                        <input class="form-control approveI" value="<?php echo $ct->comment ?>" type="text" />
                                    </td>
                                 <?php } else {?>
                                     <td style="width:20%" ><?php echo $ct->comment ?></td>
                                 <?php }?>

                                    <td style="width:10%"><div style="text-align: center;">

                                        <?php if($leave_data->status==0) { ?>
                                            <a href='#' id="approveItem" required class='btn btn-fill btn-success btn-sm' value="<?php echo $ct->rowid?>" role='button'><i class='fa fa-check'></i></a>
                                            <a href='#'  class='pophov btn btn-fill btn-info btn-sm' data-id="<?php echo $ct->id?>"  value="<?php echo $ct->rowid?>" data-toggle="popover" data-easein="flipBounceXIn" animation="false" data-placement="left" role='button'><i class="fa fa-signal" aria-hidden="true"></i></i></a>
                                        <?php } else {?>
                                            <button id="approveItem" required disabled class='btn btn-fill btn-success btn-sm' value="<?php echo $ct->rowid?>" role='button'><i class='fa fa-check'></i></button>
                                        <?php }?>

                                        <?php if($isStore == $this->session->userdata('emp_id')) { ?>
                                            <a href='#' id="updateCart" class='btn btn-fill btn-info btn-sm' value="<?php echo $ct->rowid?>" role='button'><i class='fa fa-edit'></i></a>
                                            <a href='#' id="deletedb" class='btn btn-fill btn-warning btn-sm' role='button' value="<?php echo $ct->rowid?>"><i class='fa fa-close'></i></a>
                                        <?php }?>

                                        </div>
                                   </td>
<!--                                    <input type="hidden"  name="balanceqty[]" value="--><?php //echo $ct->balanceqty ?><!--">-->
                                </tr>
                            <?php } ?>
                            <?php } ?>
                            </tbody>
                        </table>

                    </div>

                    <div class="form-group">
                        <?php
                        if($this->session->userdata('emp_id')== $next_step)
                        {?>
                            <div class="box ">
                                <div class="box-header with-border">
                                    <i class="fa fa-send"></i>
                                    <h3 class="box-title">Approve</h3>
                                </div>
                                <div class="box-body">
<!--                                    <form id="form1" class="form-horizontal" action="" method="post">-->
                                        <input type="hidden" name="emp_id" value="<?php echo @$emp->id ?>">
                                        <input type="hidden" name="step" value="<?php echo @$c ?>">
                                        <input type="hidden" name="request_id" value="<?php echo @$leave_data->request_id ?>">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"  for="status">Action</label>
                                                <div class="col-sm-6">
                                                    <select class="form-control" name="status" required id="status">
                                                       <?php foreach($DecisionDDL as $decisionid => $decision) {
                                                                echo '<option value="' . $decisionid . '">' . $decision . '</option>';
                                                        } ?>

                                                    </select>
                                                </div>
                                            </div>
<br/><br/>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label"  for="comments">Comments</label>
                                                <div class="col-sm-6">
                                         <textarea class="form-control" id="comments"    name="comments" placeholder="Comments"></textarea>
                                                </div>
                                            </div>
                                        </div><!-- /.box-body -->
                                        <div class="box-footer">
                                            <div class="pull-right">
                                                <button type="reset" class="btn btn-default">Reset</button>
                                                <button type="submit" class="btn btn-success"><?php echo @$button; ?></button>
                                            </div>
                                        </div><!-- /.box-footer -->
<!--                                    </form>-->
                                </div>
                            </div>
                  <?php }?>
                    </div>
                    </form>
                    <?php $this->load->view('leave_history'); ?>
                </div>

            </div><!-- /.box -->
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

<?php $this->load->view('include/footer'); ?>
<style>
    <style type="text/css">
    .bs-example{
        margin: 150px 50px;
    }
    /* Styles for custom popover template */
    .popover-footer{
        padding: 6px 14px;
        background-color: #f7f7f7;
        border-top: 1px solid #ebebeb;
        text-align: right;
    }
</style>

<script type="text/javascript">
    $(document).ready(function() {
//        $(document).on("click", ".popover-footer .btn", function () {
//            $(this).parents(".popover").popover('hide');
//        });
//        $('.popover-content').slimScroll();
//       $(document).on("click",".pophov", function() {
//           setTimeout(function () {
//               $('.pophov').popover('hide');
//           }, 2000);
//           $itemid = $(this).attr('data-id');
//           $obj = $(this);
//           $.ajax({
//               url: "<?php //echo base_url('/Items/popDetail'); ?>//",
//               method: "POST",
//               data: {idnumber: $itemid},
//               success: function ($result) {
//                   console.log($result);
//                   $obj.attr("data-content", $result);
//                   $('[data-toggle="popover"]').popover({
//                       placement: 'left',
//                       html: true,
//                       template: '<div class="popover"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div><div class="popover-footer"><a href="#" class="btn btn-info btn-sm">Close</a></div></div>'
//                   });
//
//               },
//               error: function (result) {
//                   console.log('Contact to IT Department')
//               }
//           });
//       });
        $(".pophov").popover({ trigger: "manual" , html: true, animation:false})
            .on("mouseenter", function () {
                var _this = this;
                $itemid = $(this).attr('data-id');
           $obj = $(this);
           $.ajax({
               url: "<?php echo base_url('/Items/popDetail'); ?>",
               method: "POST",
               data: {idnumber: $itemid},
               success: function ($result) {
                   console.log($result);
                   $obj.attr("data-content", $result);
                   $('[data-toggle="popover"]').popover({
                       placement: 'left',
                       html: true,
                       template: '<div class="popover"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div><div class="popover-footer"><a href="#" class="btn btn-info btn-sm">Close</a></div></div>'
                   });
                   $($obj).popover("show");
                   $(".popover").on("mouseleave", function () {
                       $(_this).popover('hide');
                   });
               },
               error: function (result) {
                   console.log('Contact to IT Department')
               }
           });

            }).on("mouseleave", function () {
            var _this = this;
            setTimeout(function () {
                if (!$(".popover:hover").length) {
                    $(_this).popover("hide");
                }
            }, 300);
        });
   });


</script>