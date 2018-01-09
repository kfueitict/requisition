<?php
$total_days=@getWorkingDays($leave_data->from_date,$leave_data->to_date,array(),0);
$working_days=@getWorkingDays($leave_data->from_date,$leave_data->to_date,@$holidays,true);
?>
<div class="box collapsed-box">
    <div class="box-header with-border">
        <h3 class="box-title">No Of Days <small><?php echo $total_days ?></small></h3>

        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">

            <div class="col-md-12">
                <p class="text-center">
                    <strong> Working Days (<?php echo $working_days ?>)</strong>
                </p>

                <?php
                if(is_array($leave_details)||is_object($leave_details))
                {
                    foreach ($leave_details as $lvd)
                    {
                       // var_dump($lvd);
                        $bar_color="progress-bar-red";
                        if($lvd->paid_status=='paid' && $lvd->leave_type==1)
                        {
                            $bar_color="progress-bar-aqua";
                        }else if($lvd->paid_status=='paid' && $lvd->leave_type==2)
                        {
                            $bar_color="progress-bar-green";
                        }else if($lvd->paid_status=='paid')
                        {
                            $bar_color="progress-bar-yellow";
                        }
                        $w_d=getWorkingDays($lvd->from_date,$lvd->to_date,@$holidays,true);
                        ?>

                        <div class="progress-group">
                            <span class="progress-text"><?php echo $lvd->title." ($lvd->paid_status)" ?></span>
                            <span class="progress-number"><b>
                                    <?php echo $w_d ?>
                                </b>
                                /<?php echo $working_days ?></span>

                            <div class="progress sm">
                                <div class="progress-bar <?php echo $bar_color ?>" style="width: <?php echo round($w_d/$working_days*100,2) ?>%"></div>
                            </div>
                        </div>

                        <?php
                    }
                }
                ?>



            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- ./box-body -->
</div>
<!-- /.box -->