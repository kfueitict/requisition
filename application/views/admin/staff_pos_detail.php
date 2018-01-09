
<div class="" style="background: #FFFFFF;">
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-center" style="text-transform: uppercase; color: #008080; font-weight: bold; letter-spacing: 1.2px; margin-left: 150px;">
                DEPARTMENT WISE STAFF POSITION

            <table id="faculty_tbl" class="table table-bordered table-striped table-condensed table-hover" style="width: 100%;">
                <thead class="thead-inverse">
                <tr>
                    <th style="color: #0000CD;">Departments</th>
                    <th style="text-align: center; color: #0000CD;">BPS 20</th>
                    <th style="text-align: center; color: #0000CD;">BPS 19</th>
                    <th style="text-align: center; color: #0000CD;">BPS 18</th>
                    <th style="text-align: center; color: #0000CD;">BPS 17</th>
                    <th style="text-align: center; color: #0000CD;">BPS 16</th>
                    <th style="text-align: center; color: #0000CD;">BPS 12-14</th>
                    <th style="text-align: center; color: #0000CD;">BPS 5-11</th>
                    <th style="text-align: center; color: #0000CD;">BPS 1-4</th>
                    <th style="width: 0px; text-align: center; color: #0000CD;">Total</th>
                </tr>
             
                </thead>
                <tbody>
                <?php    
                $dept_total = 0;
                $total_staff = 0;

                $bps20_total = 0;
                $bps19_total = 0;
                $bps18_total = 0;
                $bps17_total = 0;
                $bps16_total = 0;
                $bps12_14_total = 0;
                $bps5_11_total = 0;
                $bps1_4_total = 0;

                if(isset($staff)){
                    foreach($staff as $detail){
                        $title = substr($detail['dept_name'], 13, 20);
                        // $title = $detail['dept_name'];

                        $bps20 = $detail['Bps_20'];
                        $bps19 = $detail['Bps_19'];
                        $bps18 = $detail['Bps_18'];
                        $bps17 = $detail['Bps_17'];
                        $bps16 = $detail['Bps_16'];
                        $bps12_14 = $detail['Bps_12_14'];
                        $bps5_11 = $detail['Bps_5_11'];
                        $bps1_4 = $detail['Bps_1_4'];
                       
                        $total = $detail['total'];

                        // $dept_total = $professor+$asociate_prof_total+$assistant_prof_phd+$assistant_prof_nonphd+$lec_total+$ta_total+$leb_engr_total+$total_faculty;

                        $bps20_total += $bps20;
                        $bps19_total += $bps19;
                        $bps18_total += $bps18;
                        $bps17_total += $bps17;
                        $bps16_total += $bps16;
                        $bps12_14_total += $bps12_14;
                        $bps5_11_total += $bps5_11;
                        $bps1_4_total += $bps1_4; 
                         
                        $total_staff += $total;

                        echo "<tr>";
                        echo "<td style='font-weight: bold; color: #008080'>" . $title . "</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>" . $bps20 . "</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>" . $bps19 . "</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>" . $bps18 . "</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>" . $bps17 . "</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>" . $bps16 . "</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>" . $bps12_14 . "</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>" . $bps5_11 . "</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>" . $bps1_4 . "</td>";
                        echo "<td style='text-align: center; font-weight: bold; color: #C71585'>" .$total. "</td>";
                        echo "</tr>";
                    }
                    echo "<tr>";
                    echo "<td style='font-weight: bold; color: #C71585'>Total Staff</td>";
                    echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$bps20_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$bps19_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$bps18_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$bps17_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$bps16_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$bps12_14_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$bps5_11_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$bps1_4_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$total_staff."</td>";
                    echo "</tr>";
                }
                ?>

                </tbody>
            </table>
        </div>
    </div>
</div>    

