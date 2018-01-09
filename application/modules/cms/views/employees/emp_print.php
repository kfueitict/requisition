<style>
    table.page_header {width: 100%; border: none; padding: 2mm; margin-bottom: 20mm }
    table.page_footer {width: 100%; padding: 2mm; margin-top: 30mm}
</style>
<page backtop="35mm" backbottom="12mm">

    <page_header>
        <table class="page_header" cellspacing="0" style="width: 100%; text-align: center; font-size: 14px; padding: 2mm">
            <tr>
                <td style="width: 15%; color: #444444;">
                    <img style="width: 100%;" src="<?php echo MIS_SERVER.'assets/img/logokfuiet.jpg' ?>" alt="Logo"><br>
                </td>
                <td style="width: 85%;">
                    <h3>KHWAJA FAREED UNIVERSITY OF ENGINEERING & INFORMATION TECHNOLOGY</h3>

                    <p><strong>Employee Information</strong></p>
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



<fieldset style="width: 100%; border: solid 1mm #68BC8D; margin: 1mm ;padding-bottom: 8px;  line-height: normal; background: #FFFFFF;">
    <legend style=" background: #FFFFFF; padding: 1; border: solid 1px #3F5493;">Basic Information</legend>
    <table style="width: 98%; border: 1px solid #3F5493" cellspacing="0" align="center">
        <tr>
            <td style="width: 41%; border: 1px solid #3F5493;padding: 5px"><b>Name: </b><?php echo @$user->title ?> <?php echo @$user->name ?></td>
            <td style="width: 41%;border: 1px solid #3F5493;padding: 5px"><b>Father Name: </b><?php echo @$user->father_name ?></td>
            <td style="width: 18%;border: 1px solid #3F5493;padding: 5px; text-align: center" rowspan="5">
                <img width="120" height="120"
                     src="<?php echo MIS_SERVER.'uploads/employees/' . @$user->img ?>"
                     alt="<?php echo @$user->name ?>"
                     >

            </td>
        </tr>
        <tr>
            <td style="width: 40%; border: 1px solid #3F5493;padding: 5px"><b>CNIC: </b><?php echo @$user->cnic ?></td>
            <td style="width: 40%;border: 1px solid #3F5493;padding: 5px"><b>Date of Birth: </b><?php echo @$user->dob ?></td>
        </tr><tr>
            <td style="width: 40%; border: 1px solid #3F5493;padding: 5px"><b>Religion: </b><?php echo @$user->religion?></td>
            <td style="width: 40%;border: 1px solid #3F5493;padding: 5px"><b>Domicile: </b><?php echo @$user->domicile ?></td>
        </tr><tr>
            <td style="width: 40%; border: 1px solid #3F549;padding: 5px"><b>Blood Group: </b><?php echo $user->blood_group ?></td>
            <td style="width: 40%;border: 1px solid #3F5493;padding: 5px"><b>Nationality: </b><?php echo @$user->nationality ?></td>
        </tr>
        <tr>
            <td style="width: 40%; border: 1px solid #3F5493;padding: 5px"><b>Employee No: </b><?php
                echo @$user->emp_no
                ?></td>
            <td style="width: 40%;border: 1px solid #3F5493;padding: 5px"><b>Gender: </b><?php $gender=array(1=>'Male',2=>'Female'); echo @$gender[@$user->gender] ?></td>
        </tr>
    </table>
    <table style="width: 98%; border: 1px solid #3F5493;" cellspacing="0" align="center">
        <tr>
            <td style="width: 50%; border: 1px solid #3F5493;padding: 5px"><b>Phone No: </b><?php echo @$user->phone_no ?></td>
            <td style="width: 50%;border: 1px solid #3F5493;padding: 5px"><b>Mobile No: </b><?php echo @$user->mobile_no ?></td>
        </tr>
        <tr>
            <td style="width: 50%; border: 1px solid #3F5493;padding: 5px"><b>Next of Kin: </b><?php echo @$user->nok ?></td>
            <td style="width: 50%;border: 1px solid #3F5493;padding: 5px"><b>Relation: </b><?php echo @$user->relation ?></td>
        </tr>
        <tr>
            <td style="width: 50%; border: 1px solid #3F5493;padding: 5px"><b>Contact No (Next Of Kin): </b><?php echo @$user->e_phone_no ?></td>
            <td style="width: 50%;border: 1px solid #3F5493;padding: 5px"><b>Passport No: </b><?php echo @$user->passport_no ?></td>
        </tr>
        <tr>
            <td style="width: 50%; border: 1px solid #3F5493;padding: 5px"><b>Email:</b> <?php echo @$user->email ?></td>
            <td style="width: 50%; border: 1px solid #3F5493;padding: 5px"><b>Police Station Name:</b> <?php echo @$user->ps_name ?></td>
        </tr>
        <tr>
            <td colspan="2" style="width: 100%; border: 1px solid #3F5493;padding: 5px"><b>Present Address:</b> <?php echo @$user->present_address ?></td>
        </tr>
        <tr>
            <td colspan="2" style="width: 100%; border: 1px solid #3F5493;padding: 5px"><b>Permanent Address:</b> <?php echo @$user->permanent_address ?></td>
        </tr>
    </table>
    </fieldset>
<fieldset style="width: 100%; border: solid 1mm #68BC8D; margin: 1mm ;padding-bottom: 8px; line-height: normal; background: #FFFFFF;">
    <legend style=" background: #FFFFFF; padding: 1; border: solid 1px #3F5493;">Job Information</legend>
    <table style="width: 98%; border: 1px solid #3F5493;" cellspacing="0" align="center">
        <tr>
            <td style="width: 50%; border: 1px solid #3F5493;padding: 5px"><b>Job Designation:</b> <?php echo @$user->des." (BPS-$user->bps)" ?></td>
            <td style="width: 50%;border: 1px solid #3F5493;padding: 5px"><b>Is HOD:</b> <?php if (@$user->is_hod == 1) echo 'YES'; else echo 'NO' ?></td>
        </tr>
        <tr>
            <td style="width: 50%; border: 1px solid #3F5493;padding: 5px"><b>Department:</b> <?php echo @$user->dept ?></td>
            <td style="width: 50%;border: 1px solid #3F5493;padding: 5px"><b>Type of Job:</b> <?php if(!(is_array($cont_data)||is_object($cont_data))) $job_status= @$user->job_type; else $job_status=$cont_data->contract_type; echo $job_status ?></td>
        </tr>
        <tr>
            <td style="width: 50%; border: 1px solid #3F5493;padding: 5px"><b>App Letter No:</b> <?php echo @$user->app_letter_no ?></td>
            <td style="width: 50%;border: 1px solid #3F5493;padding: 5px"><b>Joining Letter No:</b> <?php echo @$user->joining_letter_no ?></td>
        </tr>
        <tr>
            <td style="width: 50%; border: 1px solid #3F5493;padding: 5px"><b>Date of Joining:</b> <?php echo @$user->doa ?></td>
            <td style="width: 50%;border: 1px solid #3F5493;padding: 5px"><b>Job Status:</b> <?php  echo @$user->job_status ?></td>
        </tr>
        <tr>
            <td style="width: 50%; border: 1px solid #3F5493;padding: 5px"><b>BIO Data Form:</b> <?php if (@$user->bio_data_form == 1) echo 'YES'; else echo 'NO' ?></td>
            <td style="width: 50%;border: 1px solid #3F5493;padding: 5px"><b>ERV:</b> <?php echo @$user->erv ?></td>
        </tr>
        <tr>

            <td style="width: 50%;border: 1px solid #3F5493;padding: 5px"><b>Biometric ID:</b> <?php echo @$user->bm_id ?></td>
            <td style="width: 50%;border: 1px solid #3F5493;padding: 5px"><b>Salary:</b> <?php if(@$job_status!=='Permanent') echo $job_status;else @$user->bps  ?></td>
        </tr>
    </table>
    </fieldset>
<?php
//if(@$job_status!=='Permanent')
if(true)
{
    if(isset($details_c)) {
        if (is_array(@$details_c) || is_object(@$details_c)){
            ?>
            <fieldset style="width: 100%; border: solid 1mm #68BC8D; margin: 1mm ;padding-bottom: 8px;  line-height: normal; background: #FFFFFF;">
                <legend style=" background: #FFFFFF; padding: 1; border: solid 1px #3F5493;">Contract Information</legend>
                <table style="width: 98%; border: 1px solid #3F5493;" cellspacing="0" align="center">
                    <tr>
                        <th style="width: 5%; border: 1px solid #3F5493;padding: 5px">Sr.</th>
                        <th style="width: 20%; border: 1px solid #3F5493;padding: 5px">Contract Type</th>
                        <th style="width: 15%; border: 1px solid #3F5493;padding: 5px">Contract Date</th>
                        <th style="width: 15%; border: 1px solid #3F5493;padding: 5px">Expire Date</th>
                        <th style="width: 10%; border: 1px solid #3F5493;padding: 5px">Duration (Months)</th>
                        <th style="width: 35%; border: 1px solid #3F5493;padding: 5px">Reference</th>
                    </tr>
                    <?php
                    $c=1;
                    if(isset($details_c)) {
                        if (is_array(@$details_c) || is_object(@$details_c))
                            foreach ($details_c as $detail) {
                                echo '<tr>
                                        <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">'.$c++.'</td>
                                            <td style="width: 20%;border: 1px solid #3F5493;padding: 5px">' . @$detail->contract_type . '</td>
                                            <td style="width: 15%;border: 1px solid #3F5493;padding: 5px">' . @$detail->contract_date . '</td>
                                            <td style="width: 15%;border: 1px solid #3F5493;padding: 5px">' . @$detail->exp_date . '</td>
                                            <td style="width: 10%;border: 1px solid #3F5493;padding: 5px">' . @$detail->duration . '</td>
                                            <td style="width: 35%;border: 1px solid #3F5493;padding: 5px">' . @$detail->reference . '</td>
                                            </tr>';
                            }
                    }?>
                </table>
            </fieldset>
        <?php
        }}}
if (isset($details)) {
    if (is_array(@$details) || is_object(@$details)){
        ?>
        <fieldset style="width: 100%; border: solid 1mm #68BC8D; margin: 1mm ;padding-bottom: 8px; line-height: normal; background: #FFFFFF;">
            <legend style=" background: #FFFFFF; padding: 1; border: solid 1px #3F5493;">Education Information</legend>
            <table style="width: 98%; border: 1px solid #3F5493;" cellspacing="0" align="center">
                <tr>
                    <th style="width: 3%; border: 1px solid #3F5493;padding: 5px">Sr.</th>
                    <th style="width: 20%; border: 1px solid #3F5493;padding: 5px">Degree/Certificate</th>
                    <th style="width: 30%; border: 1px solid #3F5493;padding: 5px">Institute</th>
                    <th style="width: 7%; border: 1px solid #3F5493;padding: 5px">Year</th>
                    <th style="width: 10%; border: 1px solid #3F5493;padding: 5px">Roll No</th>
                    <th style="width: 10%; border: 1px solid #3F5493;padding: 5px">Certifi-
                        cate No.</th>
                    <th style="width: 10%; border: 1px solid #3F5493;padding: 5px">Total
                        Marks / CGPA</th>
                    <th style="width: 10%; border: 1px solid #3F5493;padding: 5px">Obtained
                        Marks / CGPA</th>
                </tr>
                <?php
                $c=1;
                if(isset($details)) {
                    if (is_array(@$details) || is_object(@$details))
                        foreach ($details as $detail) {
                            echo '<tr>
<td style="width: 3%; border: 1px solid #3F5493;padding: 5px">'.$c++.'</td>
<td style="width: 20%;border: 1px solid #3F5493;padding: 5px">'.$detail->degreet.'</td>
<td style="width: 30%;border: 1px solid #3F5493;padding: 5px">'.$detail->boardt.'</td>
<td style="width: 7%; border: 1px solid #3F5493;padding: 5px">'.$detail->year.'</td>
<td style="width: 10%;border: 1px solid #3F5493;padding: 5px">'.wordwrap($detail->roll_no, 7, '<br />', true).'</td>
<td style="width: 10%;border: 1px solid #3F5493;padding: 5px;">'.wordwrap($detail->certificate_no, 7, '<br />', true).'</td>
<td style="width: 10%;border: 1px solid #3F5493;padding: 5px">'.($detail->total_marks + 0).'</td>
<td style="width: 10%;border: 1px solid #3F5493;padding: 5px">'.($detail->obtained_marks + 0) .'</td>
</tr>';
                        }
                }?>
            </table>
        </fieldset>

    <?php
    }
}
if (isset($details_e)) {
    if (is_array(@$details_e) || is_object(@$details_e))
    {
        ?>
        <fieldset style="width: 100%; border: solid 1mm #68BC8D; margin: 1mm ;padding-bottom: 8px; line-height: normal; background: #FFFFFF;">
            <legend style=" background: #FFFFFF; padding: 1; border: solid 1px #3F5493;">Police/Army/Govt. Experience Information</legend>
            <table style="width: 98%; border: 1px solid #3F5493;" cellspacing="0" align="center">
                <tr>
                    <th style="width: 5%; border: 1px solid #3F5493;padding: 5px">Sr.</th>
                    <th style="width: 26%; border: 1px solid #3F5493;padding: 5px">Job Designation</th>
                    <th style="width: 45%; border: 1px solid #3F5493;padding: 5px">Employer</th>
                    <th style="width: 12%; border: 1px solid #3F5493;padding: 5px">From Date</th>
                    <th style="width: 12%; border: 1px solid #3F5493;padding: 5px">To Date</th>
                </tr>
                <?php
                $c=1;
                if(isset($details_e)) {
                    if (is_array(@$details_e) || is_object(@$details_e))
                        foreach ($details_e as $detail) {
                            echo '<tr>
<td style="width: 5%; border: 1px solid #3F5493;padding: 5px">'.$c++.'</td>
<td style="width: 26%;border: 1px solid #3F5493;padding: 5px">' . $detail->designationt . '</td>
<td style="width: 45%;border: 1px solid #3F5493;padding: 5px">' . $detail->employert . '</td>
<td style="width: 12%;border: 1px solid #3F5493;padding: 5px">' . $detail->from_date . '</td>
<td style="width: 12%;border: 1px solid #3F5493;padding: 5px">' . $detail->to_date . '</td>
</tr>';
                        }
                }?>
            </table>
        </fieldset>

    <?php
    }
}
?>







</page>
