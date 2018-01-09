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
                    <?php
                    if(@$emp->bps>16)
                    echo '<p><strong>(PAY BILL FORM FOR "A" CLASS EMPLOYEES) </strong></p>';
                    else
                        echo '<p><strong>(PAY BILL FORM FOR "B&C" CLASS EMPLOYEES) </strong></p>';
                    ?>
                </td>

            </tr>
        </table>
    </page_header>
    <page_footer>
        <table class="page_footer" style="width: 100%;">
            <tr>
                <td style="text-align: center;    width: 100%">www.kfueit.edu.pk</td>
            </tr>
        </table>
    </page_footer>
    <?php
    $total=0;

    ?>
    <table style="width: 100%; border: 1px solid #3F5493;" cellspacing="0" align="center">
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px"><b>1 </b></td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px"><b>Name of Employee </b></td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php echo @$emp->title ?> <?php echo @$emp->name ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px"><b>2 </b></td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px"><b>Designation </b></td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php echo @$emp->designation ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px"><b>3 </b></td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px"><b>Month </b></td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php echo mdate('%F', strtotime($date->to_date)); ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px"><b>4 </b></td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px"><b>Account No </b></td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php echo @$pr->acc_no ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px"><b>5 </b></td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px"><b>Department </b></td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php echo @$emp->department ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px"><b>6 </b></td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px"><b>Salary Register Page No. </b></td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php echo @$pr->salary_reg_page ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px"><b>7 </b></td>
            <td colspan="2" style="width: 35%;font-size: 4mm; border: 1px solid #3F5493;padding: 5px"><b>EMOLUMENTS </b></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">i </td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px">Pay </td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php $total=$total+@$pr->pay; echo number_format(@$pr->pay)  ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">ii </td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px">Senior Post Allowance </td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php $total=$total+@$pr->s_p_a; echo number_format(@$pr->s_p_a);  ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">iii </td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px">House Rent Allowance </td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php $total=$total+@$pr->h_r_a; echo number_format(@$pr->h_r_a);  ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">iv</td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px">Conveyance Allowance </td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php $total=$total+@$pr->conveyance_a; echo number_format(@$pr->conveyance_a);  ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">v </td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px">Qualification Allowance </td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php $total=$total+@$pr->qualification_a; echo number_format(@$pr->qualification_a);  ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">vi </td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px">Entertainment Allowance </td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php $total=$total+@$pr->entertainment_a; echo number_format(@$pr->entertainment_a);  ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">vii </td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px">Univ.Tech.Teaching Allowance</td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php $total=$total+@$pr->teaching_a; echo number_format(@$pr->teaching_a);  ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">viii </td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px">Medical Allowance</td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php $total=$total+@$pr->medical_a; echo number_format(@$pr->medical_a);  ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">ix </td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px">Adhoc Relief Allowance-2010 </td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php $total=$total+@$pr->adhoc_r_a_2010; echo number_format(@$pr->adhoc_r_a_2010);  ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">x </td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px">Adhoc Relief Allowance-2016 </td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php $total=$total+@$pr->adhoc_r_a_2016; echo number_format(@$pr->adhoc_r_a_2016);  ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">xi </td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px">Social Security 30% of Basic Pay</td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php $total=$total+@$pr->social_sec; echo number_format(@$pr->social_sec);  ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">xii </td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px">Extra Duty Allowance</td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php $total=$total+@$pr->extra_duty_allowance; echo number_format(@$pr->extra_duty_allowance);  ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">xiii </td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px">Project Allowance</td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php $total=$total+@$pr->project_allowance; echo number_format(@$pr->project_allowance);  ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">xiv </td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px">Arrears</td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php $total=$total+@$pr->arrears; echo number_format(@$pr->arrears);  ?></td>
        </tr>
        <?php
        if($emp->bps<17)
        {?>
            <tr>
                <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">xv </td>
                <td style="width: 35%; border: 1px solid #3F5493;padding: 5px">Overtime</td>
                <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php $total=$total+@$pr->overtime; echo number_format(@$pr->overtime);  ?></td>
            </tr>
        <?php }
        ?>

        <tr>
            <td colspan="2" style="width: 40%; border: 1px solid #3F5493;padding: 5px"><b>TOTAL EMOLUMENTS/GROSS PAY</b></td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php echo number_format($total);  ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px"><b>8</b> </td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px;font-size: 4mm;" colspan="2"><b>DEDUCTIONS</b></td>
        </tr>
        <tr>
        <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">i </td>
        <td style="width: 35%; border: 1px solid #3F5493;padding: 5px">Income Tax</td>
        <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php $total1=@$pr->income_tax; echo number_format(@$pr->income_tax);  ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">ii </td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px">Transportation Charges</td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php $total1=$total1+@$pr->transportation_charges; echo number_format(@$pr->transportation_charges);  ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">iii </td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px">Recovery</td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php $total1=$total1+@$pr->recovery; echo number_format(@$pr->recovery);  ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px">iv </td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px">Other Deduction</td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php $total1=$total1+@$pr->other_deductions; echo number_format(@$pr->other_deductions);  ?></td>
        </tr>
        <tr>
            <td colspan="2" style="width: 35%; border: 1px solid #3F5493;padding: 5px"><b>TOTAL DEDUCTIONS </b></td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php echo number_format(@$total1);  ?></td>
        </tr>
        <tr>
            <td style="width: 5%; border: 1px solid #3F5493;padding: 5px"><b>9</b> </td>
            <td style="width: 35%; border: 1px solid #3F5493;padding: 5px;font-size: 4mm;"><b>Net Pay</b></td>
            <td style="width: 60%;border: 1px solid #3F5493;padding: 5px"><?php  echo number_format($total-$total1);  ?></td>
        </tr>
        <tr>
            <td colspan="3" style=" border: 1px solid #3F5493;padding: 5px"><b>In Words: </b> <?php
                echo convert_number_to_words($total-$total1);
                ?>  </td>
        </tr>


    </table>
    <p></p>
    <p> System generated document which does not require signature<br>* All amounts are in Pak Rupees<br>* Errors & omissions excepted</p>


    </page>