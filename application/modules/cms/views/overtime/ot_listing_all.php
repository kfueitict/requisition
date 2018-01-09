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

                    <p><strong>Employee Attendance Sheet</strong></p>
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



    <fieldset style="width: 100%; border: solid 1mm #68BC8D;padding-bottom: 8px;  line-height: normal; background: #FFFFFF;">
        <legend style=" background: #FFFFFF; padding: 1; border: solid 1px #3F5493;">Filtration</legend>

        <table style="width: 98%; border: 1px solid #3F5493;" cellspacing="0" align="center">
            <tr>
                <td style="width: 50%; border: 1px solid #3F5493;padding: 5px"><b>From Date: </b><?php echo @$_GET['from_date'] ?></td>
                <td style="width: 50%;border: 1px solid #3F5493;padding: 5px"><b>To Date: </b><?php echo @$_GET['to_date'] ?></td>
            </tr>
            <tr>
                <td colspan="2" style="width: 100%; border: 1px solid #3F5493;padding: 5px"><b>Department: </b><?php echo @$dept ?></td>
            </tr>

        </table>
    </fieldset>
    <br>
    <table style="width: 100%; border: 1px solid #3F5493;" cellspacing="0" align="center">

        <tr>
            <th style="width: 12%; border: 1px solid #3F5493;padding: 5px">Date</th>
            <th style="width: 30%; border: 1px solid #3F5493;padding: 5px">Name</th>
            <th style="width: 30%; border: 1px solid #3F5493;padding: 5px">Department</th>
            <th style="width: 7%; border: 1px solid #3F5493;padding: 5px">Check IN</th>
            <th style="width: 7%; border: 1px solid #3F5493;padding: 5px">Check OUT</th>
            <th style="width: 7%; border: 1px solid #3F5493;padding: 5px">IN Time</th>
            <th style="width: 7%; border: 1px solid #3F5493;padding: 5px">Over Time</th>
        </tr>


        <?php
        $total=0;
        if(is_array(@$overtime)||is_object(@$overtime))
            foreach($overtime as $v)
            {?>
                <tr>

                    <?php
                    echo '<td style="width: 12%; border: 1px solid #3F5493;padding: 5px">'.$v['Date'].'</td>';
                    echo '<td style="width: 30%; border: 1px solid #3F5493;padding: 5px">'.$v['NAME'].'</td>';
                    echo '<td style="width: 30%; border: 1px solid #3F5493;padding: 5px">'.$v['DEPARTMENT'].'</td>';
                    echo '<td style="width: 7%;  border: 1px solid #3F5493;padding: 5px">'.$v['CHKIN'].'</td>';
                    echo '<td style="width: 7%;  border: 1px solid #3F5493;padding: 5px">'.$v['CHKOUT'].'</td>';
                    echo '<td style="width: 7%;  border: 1px solid #3F5493;padding: 5px">'.$v['INTIME'].'</td>';
                    echo '<td style="width: 7%;  border: 1px solid #3F5493;padding: 5px">'.$v['OverTIME'].'</td>';
                    $total+=$v['OverTIME'];
                    ?>
                </tr>
            <?php }
        ?>
        <tr>
            <th colspan="6" style="border: 1px solid #3F5493;padding: 5px; text-align: right"><b>Total Over Time (Hours)</b></th>
            <th style="border: 1px solid #3F5493;padding: 5px"><?php echo $total ?></th>
        </tr>

    </table>


    </page>