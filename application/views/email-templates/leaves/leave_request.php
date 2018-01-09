<div style="width:100%">
    <div class="adM">
    </div>
    <div style="background-color:#FFFFFF;width:800px;margin:0 auto">
        <div class="adM">
        </div>
        <table class="page_header" cellspacing="0" style="width: 100%; text-align: center; font-size: 14px; padding: 2mm">
            <tr>
                <td style="width: 15%; color: #444444;">
                    <img style="width: 100%;" src="http://www.kfueit.edu.pk/assets/img/logokfuietReSize.png" alt="Logo"><br>
                </td>
                <td style="width: 85%;">
                    <p style="font-size: 1.8em"><strong>KHWAJA FAREED UNIVERSITY OF ENGINEERING & INFORMATION TECHNOLOGY</strong></p>

                    <p><strong>Leave Request </strong></p>
                </td>

            </tr>
        </table>

        <div style="padding:20px 20px 50px 20px">


            <div
                style="font-family:Arial,Helvetica,sans-serif;font-size:16px;font-weight:normal;line-height:30px;margin:0 0 20px 0">
                <div>Dear <?php echo @$applicant ?>,</div>
                <div><?php echo @$message ?></div>
                <div>
                    <table width="100%" cellspacing="0" cellpadding="5" border="0"
                           style="border:3px solid #bbbbbb;font-size:16px;font-family:Arial,Helvetica,sans-serif;margin:30px 0 30px 0"
                           bgcolor="#ffffff">
                        <tbody>
                        <?php
                        foreach ($mail_body as $k=>$v)
                        {
                            echo '<tr>';
                            echo '<td width="28%" style="border-right:2px solid #bbbbbb">'.$k.'</td>';
                            echo '<td width="72%">'.$v.'</td>';
                            echo '</tr>';
                        }
                        ?>
                        </tbody>
                    </table>

                </div>
                <div style="padding:20px 0 10px 0">Please <a href="<?php echo base_url() ?>"
                                                             style="color:#b3512f" target="_blank"
                                                             >click
                        here</a> to login and check the leave details.
                </div>
            </div>

            <div style="font-family:Arial,Helvetica,sans-serif;font-size:16px;font-weight:normal;line-height:30px">
                Regards,<br>
                <b>HR KFUEIT</b>
                <div class="yj6qo"></div>
                <div class="adL">
                </div>
            </div>
            <div class="adL">
            </div>
        </div>
        <div class="adL">
        </div>
    </div>
    <div class="adL">
    </div>
</div>