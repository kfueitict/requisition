<?php
$this->load->view('include/header-without-sidemenu');
?>

<div class="content-wrapper" xmlns="http://www.w3.org/1999/html">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Leaves Encashment Form
            <small>Earn Leaves</small>
          </h1>

          <ol class="breadcrumb">
            <li><a href="<?php echo base_url()?>"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="<?php echo base_url('cms/employees/leaves_encashment/listing')?>"><i class="fa fa-user"></i> Employees</a></li>
            <li class="active">Leaves Encashment</li>
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
                        <form action="" method="post" enctype="multipart/form-data">

                            <div class="wizard-header">
                                <h3>
                                    <b>Earned Leave Encashment<b>
                                </h3>
                            </div>

                            <div class="wizard-navigation">
                                <ul>
                                    <li><a href="#employee" data-toggle="tab">Select Employees</a></li>
                                    <li><a href="#account" data-toggle="tab">No of Leave</a></li>
                                </ul>

                            </div>

                            <div class="tab-content">
                                <div class="tab-pane" id="employee">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php if($this->session->flashdata('message')||$this->session->flashdata('message-error'))
                                            {?>
                                                <?php if($this->session->flashdata('message'))
                                            {?>

                                                <div class="alert alert-info alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
                                                    <?php echo $this->session->flashdata('message') ;?>

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
                                            <?php } ?>
                                            <div class="form-group" >
                                                <label for="emp_id">Name <small>(required)</small></label>
                                                <select name="emp_id" required id="emp_id" class="form-control select2" style="width: 100%">
                                                    <option value="">Select Employee</option>
                                                    <?php
                                                    if(is_array(@$employees)||is_object(@$employees))
                                                    {
                                                        foreach ($employees as $emp){
                                                            {
                                                                echo "<option value='$emp->id'>$emp->emp_no - $emp->title $emp->name</option>";
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="tab-pane" id="account">

                                    <div class="row">
                                        <div class="col-md-12">

                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <label for="days">Days <small>(required)</small></label>
                                                    <input type="number" min="1" required value="" name="days" id="days" class="form-control">

                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">

                                                    <label for="amount">Amount</label>
                                                    <input type="number" value="" name="amount" id="amount" class="form-control">

                                                </div>

                                            </div>




                                            <div class="col-md-12">
                                            <div class="form-group">
                                                <label  for="comments">Comments</label>
                                                <textarea class="form-control" id="comments"
                                                          name="comments"
                                                          placeholder="Comments"><?php echo @$leave_request->reason ?></textarea>
                                            </div>
                                            </div>
                                            <div class="col-md-12">
                                            <strong> Attachments </strong><button type="button" onclick="addAttachment()" class="btn btn-box-tool" ><i class="fa fa-plus"></i> Add</button>
                                            <div id="attachments">
                                                <div id="attachment-body">


                                                </div>


                                            </div>
                                            </div>



                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="wizard-footer height-wizard">
                                <div class="pull-right">
                                    <input type='button' class='btn btn-next btn-fill btn-warning btn-wd btn-sm' name='next' value='Next' />
                                    <input type='submit' class='btn btn-finish btn-fill btn-warning btn-wd btn-sm' name='finish' value='Finish' />

                                </div>

                                <div class="pull-left">
                                    <input type='button' class='btn btn-previous btn-fill btn-default btn-wd btn-sm' name='previous' value='Previous' />
                                </div>
                                <div class="clearfix"></div>
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
        format:'yyyy-mm-dd'
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
            '</div>' );
    }
    function removeAttachment(f) {
        var div= $(f).parent().parent('div');
        $(div).remove();
        console.log(div);
    }

</script>
