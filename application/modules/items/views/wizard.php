<?php
$this->load->view('include/header-without-sidemenu');
?>

<div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Requisition Form
            <small>Items</small>
        </h1>

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="#"><i class="fa fa-calendar-check-o"></i> Items</a></li>
            <li class="active">Request Form</li>
        </ol>
    </section>
    <!-- Main content -->

    <section class="content">
        <button type="button" onclick="window.history.back();" class="btn btn-info pull-right">Back</button>
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">
                <!--      Wizard container        -->
                <div class="wizard-container">

                    <div class="card wizard-card" data-color="orange" id="wizardProfile">
                        <form action="<?php echo base_url('items/request') ?>" method="post"
                              enctype="multipart/form-data">
                            <!--        You can switch ' data-color="orange" '  with one of the next bright colors: "blue", "green", "orange", "red"          -->
                            <div class="wizard-header">
                                <h3>
                                    <b>Initiate a Items Requisition <br>
                                </h3>
                            </div>
                            <div class="wizard-navigation">
                                <ul>
                                    <li><a href="#account" data-toggle="tab">Enter Item Details</a></li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <!-- Item adding to cart Area -->
                                <div class="tab-pane" id="account">
                                    <h4 class="info-text"> Requisition Details </h4>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="hidden" name="emp_id" value="<?php echo @$emp->id ?>">
                                            <input type="hidden" name="step" value="1">
                                            <input type="hidden" name="update_id"
                                                   value="<?php echo @$leave_request->id ?>">
                                            <!-- Fields of users -->

                                            <div class="row">
                                                <div class="form-group">
                                                <div class="col-md-4">


                                                        <label for="leave_type">Categories
                                                            <small>(required)</small>
                                                        </label>
                                                        <select name="item" id="category_ddl" required class="form-control select2" style="width: 100%">
                                                            <?php

                                                            if (is_array(@$list_cat) || is_object(@$list_cat)) {
                                                                if (count(@$list_cat) > 1) {
                                                                    echo "<option value=\"-1\">Select Item</option>";
                                                                }
                                                                foreach ($list_cat as $item) {
                                                                    {
                                                                        echo "<option value='$item->id'> $item->name</option>";
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </select>

                                                </div>
                                                <div class="col-md-4">

                                                        <label for="leave_type">Items
                                                            <small>(required)</small>
                                                        </label>
                                                        <select name="item" id="pro_item" required class="form-control select2" style="width: 100%">


                                                        </select>

                                                </div>
                                                <div class="col-md-4">

                                                        <label for="quantity">Quantity
                                                            <small>(required)</small>
                                                        </label>
                                                        <input type="number" min="1" name="quantity" required
                                                               id="quantity" class="form-control">

                                                </div>
                                            </div>
                                           </div>
                                            <div class="row">
                                                <div class="form-group">
                                                    <div class="col-md-9">
                                                        <label for="reason">Reason
                                                            <small>(required)</small>
                                                        </label>
                                                        <textarea class="form-control" id="reason" required
                                                                  name="reason"
                                                                  placeholder="Max characters 140"
                                                                  maxlength="140"
                                                                  required

                                                        ><?php echo @$leave_request->reason ?></textarea>

                                                    </div>
                                                     <div class="col-md-3">
                                                            <label for="add"></label>
                                                            <input type="button" id="add_item" style="margin-top: 14px;"
                                                                   class="btn btn-finish btn-fill btn-info btn-wd btn-sm"
                                                                   name="add" value="add"/>
                                                    </div>


                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <table cellpadding="6" cellspacing="1" style="width:100%" border="0"
                                                       class=" cart_table table table-hover table-bordered table-striped ">
                                                    <thead>
                                                    <tr>
                                                        <th>Item Description</th>
                                                        <th>QTY</th>
                                                        <th>Reason</th>
                                                        <th>Image</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>


                                                    </tbody>
                                                </table>
                                            </div>

<!--                                            <div class="form-group">-->
<!--                                                <label for="reason">Comments-->
<!--                                                    <small></small>-->
<!--                                                </label>-->
<!--                                                <textarea class="form-control" id="reason"-->
<!--                                                          name="reason"-->
<!--                                                          placeholder="Comments">--><?php //echo @$leave_request->reason ?><!--</textarea>-->
<!--                                            </div>-->
                                            <!--     <strong> Attachments </strong><button type="button" onclick="addAttachment()" class="btn btn-box-tool" ><i class="fa fa-plus"></i> Add</button>
                                                <div id="attachments">
                                                    <div id="attachment-body">
                                                    </div>
                                                </div> -->

                                        </div>
                                    </div>

                                </div>
                                <div class="wizard-footer height-wizard">
                                    <div class="pull-right">
                                        <input type='button' class='btn btn-next btn-fill btn-warning btn-wd btn-sm'
                                               name='next' value='Next'/>
                                        <input type='submit' id="submit_btn"
                                               class='btn btn-finish btn-fill btn-warning btn-wd btn-sm' name='finish'
                                               value='Submit'/>
                                    </div>
                                    <div class="pull-left">
                                        <input type='button' class='btn btn-previous btn-fill btn-default btn-wd btn-sm'
                                               name='previous' value='Previous'/>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div> <!-- wizard container -->
            </div>
        </div><!-- end row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->


<?php $this->load->view('include/footer'); ?>
<script>
    $(".select2").select2();
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd'
    });
    function addAttachment() {
        $("#attachment-body").append('<div class="box">' +
            ' <div class="box-tools pull-right">' +
            '<button type="button" class="btn btn-box-tool" onclick="removeAttachment(this)"><i class="fa fa-times"></i></button>' +
            ' </div>' +
            ' ' +
            '<div class="form-group">' +
            '<label  for="file_title">File Title</label>' +
            '<input type="text" required value="" name="file_title[]" id="file_title" class="form-control">' +
            '</div>' +
            '<div class="form-group">' +
            ' <label  for="file">File</label>' +
            ' <input type="file" required name="file[]" id="file" class="form-control">' +
            ' </div>' +
            '</div>');
    }
    function removeAttachment(f) {
        var div = $(f).parent().parent('div');
        $(div).remove();
    };

    //   $(document).ready(function(){
    //
    //       if($(".cart_table tbody tr").length==1){
    //           $("#submit_btn").prop("disabled",true);
    //       }
    //       else
    //       {
    //           $("#submit_btn").prop("disabled",false);
    //       }
    //
    //   });
</script>
<style>

    #add_item {

        display: block !important;
    }

</style>