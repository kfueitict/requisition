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
    table {
        border-spacing: 0;
        border-collapse: collapse

    }
    .table-bordered td,
    .table-bordered th {
        border: 1px solid #ddd!important;
        padding:5px;
    }
</style>
<page backtop="35mm" backbottom="12mm">

    <page_header>
        <table class="page_header" cellspacing="0" style="width: 100%; text-align: center; font-size: 14px; padding: 2mm">
            <tr>
                <td style="width: 15%; color: #444444;">
<!--                    <img style="width: 100%;" src="--><?php //echo MIS_SERVER.'assets/img/logokfuiet.jpg' ?><!--" alt="Logo"><br>-->
                    <img style="width: 100%;" src="<?php echo base_url('assets/img/logokfuiet.jpg') ?>" alt="Logo"><br>
                </td>
                <td style="width: 85%;">
                    <h3>KHWAJA FAREED UNIVERSITY OF ENGINEERING & INFORMATION TECHNOLOGY</h3>

<!--                    <p><strong>Request For Quotation</strong></p>-->
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

    <div class="form-group">
        <div class="row">
            <table>
                <tbody>
                <tr>
                    <td style="width:75%;"></td>
                    <td style="width:25%;"> <div><p>Ref:  No. KFUEIT/LPRO/___ </p></div>
                        <div> Date <?php echo date("Y/m/d")?></div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="form-group">
        <div class="row">
            <div class="col-md-12"><p><strong>Subject: Call for Quotation</strong></p></div>
            <div class="col-md-offset-2 col-md-10"><p>With Reference to subject cited above, you are requested to quote rates for the following items and issue a certificate that price are no exorbitant.</p></div>
            <br>
            <div class="col-md-12">
                        <table style="border:1px solid black" class="table table-hover table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Item Name</th>
                                <th>Requested Quantity</th>
                                <th>Balance Quantity</th>
                                <th>Price (PKR)</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(is_array($proItems)||is_object($proItems)){ ?>
                           <?php foreach ($proItems as $k=>$ite){?>
                            <tr>
                                <?php $k+=1; echo "<th>$k</th>"?>
                                <td><?php echo $ite->name ?></td>
                                <td><?php echo $ite->qty ?></td>
                                <td><?php echo $ite->balance_qty ?></td>
                                <td></td>
                            </tr>
                           <?php }?>
                           <?php }?>

                            </tbody>
                        </table>
                </div>
            </div>
    </div>
    <br>
    <br>
    <br>

    <div class="form-group">
        <div class="row">
             <table>
                <tbody>
                <tr>
                    <td style="width:75%;"></td>
                    <td style="width:25%;"> <div>Dr.Zaheer Ahmad</div>
                        <div>Director Procurement</div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br><br<br><br><br<br>
    <div class="form-group">
        <div class="row">
            <table>
                <tbody>
                <tr>
                    <td style="width:40%;">
                        C.C to:
                        <ul>
                           <li>All Members of  Local Purchase Committee </li>
                           <li>IT Manager, KFUEIT, Rahim Yar Khan</li>
                           <li>Finance Manager, KFUEIT, Rahim Yar Khan</li>
                           <li>Internal Auditor, KFUEIT, Rahim Yar Khan </li>
                           <li>Notice Board</li>
                       </ul>

                    </td>
                    <td style="width:60%;"></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</page>