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

                    <p><strong>Employee's Overtime</strong></p>
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
            <th style="width: 35%; border: 1px solid #3F5493;padding: 5px">Name</th>
            <th style="width: 35%; border: 1px solid #3F5493;padding: 5px">Department</th>
            <th style="width: 10%; border: 1px solid #3F5493;padding: 5px">Overtime Device</th>
            <th style="width: 10%; border: 1px solid #3F5493;padding: 5px">Overtime Modified</th>
            <th style="width: 10%; border: 1px solid #3F5493;padding: 5px">Overtime Total</th>
        </tr>


        <?php
        $total1=0;
        $total2=0;
        $total3=0;
        if(is_array(@$employees)||is_object(@$employees))
            foreach($employees as $type)
            {?>
                <tr>

                    <?php

                    $total1+=$type->otd;
                    $total2+=$type->otm;
                    $total3+=$type->otc;
                    ?>
                    <td style="width: 35%; border: 1px solid #3F5493;padding: 5px"><?php echo $type->name ?></td>
                    <td style="width: 35%; border: 1px solid #3F5493;padding: 5px"><?php echo @$type->department ?></td>
                    <td style="width: 10%; border: 1px solid #3F5493;padding: 5px"><?php echo $type->otd ?></td>
                    <td style="width: 10%; border: 1px solid #3F5493;padding: 5px"><?php echo $type->otm ?></td>
                    <td style="width: 10%; border: 1px solid #3F5493;padding: 5px"><?php echo $type->otc ?></td>
                </tr>
            <?php }
        ?>
        <tr>
            <th colspan="2" style="border: 1px solid #3F5493;padding: 5px; text-align: right"><b>Total Over Time (Hours)</b></th>
            <th style="border: 1px solid #3F5493;padding: 5px"><?php echo $total1 ?></th>
            <th style="border: 1px solid #3F5493;padding: 5px"><?php echo $total2 ?></th>
            <th style="border: 1px solid #3F5493;padding: 5px"><?php echo $total3 ?></th>
        </tr>

    </table>


    </page>