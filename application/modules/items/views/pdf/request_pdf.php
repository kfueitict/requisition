<style>
    table.page_header {width: 100%; border: none; padding: 2mm; margin-bottom: 20mm }
    table.page_footer {width: 100%; padding: 2mm; margin-top: 30mm}

    .body td{
        border: 1px solid #000000;
        padding: 5px;
    }.body-emp td{
        border: 0;
        padding: 5px;
    }
    .body th{
        border: 2px solid #000000;
        padding: 5px;
    }
</style>
<?php
$total_days=@getWorkingDays($leave_data->from_date,$leave_data->to_date,array(),0);
$working_days=@getWorkingDays($leave_data->from_date,$leave_data->to_date,@$holidays,true);
$req_status=leave_request_status();
$requested_leaves=array();
?>
<page backtop="35mm" backbottom="12mm">

    <page_header>
        <table class="page_header" cellspacing="0" style="width: 100%; text-align: center; font-size: 14px; padding: 2mm">
            <tr>
                <td style="width: 15%; color: #444444;">
                    <img style="width: 100%;" src="<?php echo MIS_SERVER.'assets/img/logokfuiet.jpg' ?>" alt="Logo"><br>
                </td>
                <td style="width: 85%;">
                    <h3>KHWAJA FAREED UNIVERSITY OF ENGINEERING & INFORMATION TECHNOLOGY</h3>

                    <p><strong>Employee Leave Application</strong></p>
                </td>

            </tr>
        </table>
    </page_header>
    <page_footer>
        <table class="page_footer" style="width: 100%; border: solid 1px black;">
            <tr>
                <td style="text-align: left;    width: 50%">www.kfueit.edu.pk</td>
                <td style="text-align: right;    width: 50%">page [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
    </page_footer>


    <table style="width: 100%; border: 0" cellspacing="0" align="center">
        <tr>
            <td style="width: 50%">Request Initiated by: <?php echo @$leave_data->username ?></td>
            <td style="width: 50%;text-align: right">Employee No: <?php echo @$leave_data->emp_no ?></td>
        </tr>
    </table>
    <table class="body" style="width: 97%; border: solid 1mm #000000;border-radius: 10px" cellspacing="0" align="center">
        <tr>
            <td colspan="3"><h4>Leave Details ( <?php echo $req_status[@$leave_data->status]; ?> )</h4></td>
        </tr>
        <tr style="border: border: 1px solid #3F5493">
            <th style="width: 33%">Leave Type</th>
            <th style="width: 33%">Date</th>
            <th style="width: 33%">No. of Working Days</th>
        </tr>
        <?php
        if(is_array($leave_details)||is_object($leave_details))
        {
            foreach ($leave_details as $lvd)
            {
                $w_d=getWorkingDays($lvd->from_date,$lvd->to_date,@$holidays,true);
                ?>
                <tr style="border: 1px solid #3F5493">
                    <td><?php echo $lvd->title ?></td>
                    <td><?php echo $lvd->from_date.' to '.$lvd->to_date ?></td>
                    <td><?php echo $w_d ?></td>
                </tr>

                <?php
                $requested_leaves[$lvd->title]=$w_d;
            }
        }
        ?>

        <tr>
            <td colspan="3">
                <table class="body-emp" style="width: 100%; border: 0" cellspacing="5" align="center">

                    <tr>
                        <td style="width: 50%"><strong>Name: </strong> <?php echo @$leave_data->name ?></td>
                        <td style="width: 50%"><strong>Designation: </strong> <?php echo @$leave_data->designation ?></td>
                    </tr>
                    <tr>
                        <td style="width: 50%"><strong>Duration of Leave: </strong> <?php echo $leave_data->from_date.' to '.$leave_data->to_date ?></td>
                        <td style="width: 50%"><strong>No. of working Days: </strong> <?php echo $working_days ?></td>
                    </tr>
                    <tr>
                        <td style="width: 100%" colspan="2"><strong>Reason for Leave: </strong>  <?php echo @$leave_data->reason ?></td>
                    </tr>
                    <tr>
                        <td style="width: 100%" colspan="2"><strong>Contact No: </strong> <?php echo @$leave_data->mobile_no ?></td>
                    </tr>
                    <tr>
                        <td style="width: 100%;text-align: right" colspan="2"><strong>Date of Submission: </strong> <?php echo @$leave_data->request_date ?></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <fieldset style="width: 100%; border: solid 1mm #000000; margin: 1mm ;padding: 2px;  line-height: normal; background: #FFFFFF;">
        <legend style=" background: #FFFFFF; padding: 5px; border: solid 1px #000000;">Recommendation by the Reporting Officer/Head of Department/Departmental Head</legend>
        <table class="body-emp" style="width: 100%; border: 0" cellspacing="5" align="center">




                <?php
                if(empty(@$leave_transactions[1]))
                {
                    echo "<tr><td>Request in Process</td></tr>";
                }else
                {
                    $c=1;
                    foreach (@$leave_transactions as $tr) {
                        if($c==2)
                        {
                            echo "<tr><td colspan=\"2\" style=\"width: 100%; text-align: center\"><strong> {$req_status[@$tr->status]}  by</strong></td></tr>";
                            echo "<tr><td><strong>Name:</strong> $tr->emp_no - $tr->name</td>";
                            echo "<td><strong>Designation:</strong> $tr->designation</td></tr>";
                            echo "<tr><td style=\"width: 100%;text-align: right\" colspan=\"2\"><strong>Date of Recommendation: </strong> ".date('Y-m-d',strtotime($tr->transaction_date))."</td></tr>";
                            break;
                        }
                        $c++;
                    }
                }

                    ?>




        </table>

    </fieldset>
    <fieldset style="width: 100%; border: solid 1mm #000000; margin: 1mm ;padding: 2px;  line-height: normal; background: #FFFFFF;">
        <legend style=" background: #FFFFFF; padding: 5px; border: solid 1px #000000;">Employee Leave Register</legend>
        <table class="body" style="width: 100%; text-align: left" cellspacing="0" align="center">

            <tr>
                <th style="width: 30%">Recording / Leave Type</th>
                <?php
                $leaves_types=@$leaves['employees'][0];
                foreach ($leaves_types as $k=>$v)
                {
                    echo "<th>$k</th>";
                }
                ?>
            </tr>
            <tr>
                <th>Previous</th>
                <?php
                $leaves_types=@$leaves['employees'][0];
                foreach ($leaves_types as $k=>$v)
                {
                    $previous=@$leave_balance[$k];
                    if(@$leave_data->status==1 && !empty($requested_leaves[$k]) && ($v-$requested_leaves[$k]>0))
                    {
                        $previous=$v-$requested_leaves[$k];
                    }
                    echo "<th>$previous</th>";
                }

                ?>
            </tr>
            <tr>
                <th>Leave Requested</th>
                <?php
                $leaves_types=@$leaves['employees'][0];
                foreach ($leaves_types as $k=>$v)
                {
                    $r=@$requested_leaves[$k];
                    echo "<th>$r</th>";
                }

                ?>
            </tr>
            <tr>
                <th>Remaining</th>
                <?php
                $leaves_types=@$leaves['employees'][0];
                foreach ($leaves_types as $k=>$v)
                {
                    $r=@$leave_balance[$k];
                    echo "<th>$r</th>";
                }
                ?>
            </tr>

        </table>

    </fieldset>
    <fieldset style="width: 100%; border: solid 1mm #000000; margin: 1mm ;padding: 2px;  line-height: normal; background: #FFFFFF;">
        <legend style=" background: #FFFFFF; padding: 5px; border: solid 1px #000000;">Approval by the Competent Authority</legend>
        <table class="body-emp" style="width: 100%; border: 0" cellspacing="5" align="center">




            <?php
            if($leave_data->status==0)
            {
                echo "<tr><td>Request in Process</td></tr>";
            }else
            {
                foreach (@$leave_transactions as $tr) {
                    if(empty(@$tr->emp_no_n))
                    {
                        echo "<tr><td colspan=\"2\" style=\"width: 100%; text-align: center\"><strong> {$req_status[@$tr->status]}  by</strong></td></tr>";
                        echo "<tr><td><strong>Name:</strong> $tr->emp_no - $tr->name</td>";
                        echo "<td><strong>Designation:</strong> $tr->designation</td></tr>";
                        echo "<tr><td style=\"width: 100%;text-align: right\" colspan=\"2\"><strong>Date : </strong> ".date('Y-m-d',strtotime($tr->transaction_date))."</td></tr>";
                        break;
                    }

                }
            }

            ?>




        </table>

    </fieldset>
</page>
