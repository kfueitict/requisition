<?php
$total_days=@getWorkingDays($leave_data->from_date,$leave_data->to_date,array(),0);
$working_days=@getWorkingDays($leave_data->from_date,$leave_data->to_date,@$holidays,true);
?>
<div class="box collapsed-box">
    <div class="box-header with-border">
        <h3 class="box-title"> <i class="fa fa-history"></i> Request History</h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box box-body">
        <?php

        $c=1;

        foreach (@$leave_transactions as $tr)
        {
            ?>

            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h4 class="bg-gray pada-4">Step <?php echo $c++; ?></h4>
                    <div class="box bg-light-blue-gradient">
                        <table class="table">
                            <tr><th>Date</th><td><?php echo @$tr->transaction_date ?></td></tr>
                            <tr><th>Taken by</th><td><?php echo @$tr->emp_no.' - '.@$tr->name ?></td></tr>
                            <tr><th>Department</th><td><?php echo @$tr->department ?></td></tr>
                            <tr><th>Comments</th><td><?php echo @$tr->comments ?></td></tr>
                            <tr><th>Action</th><td><?php echo @$req_status[@$tr->status] ?></td></tr>
                        </table>
                        <?php if(!empty(@$tr->emp_no_n)){

                            ?>
                            <h4>Sent to</h4>
                            <table class="table">
                                <tr><th>Name</th><td><?php echo @$tr->emp_no_n.' - '.@$tr->name_n ?></td></tr>
                                <tr><th>Department</th><td><?php echo @$tr->department_n ?></td></tr>
                            </table>
                        <?php } ?>
                    </div>
                </div>
            </div>

        <?php }
        ?>
    </div>
</div>
<!-- /.box -->