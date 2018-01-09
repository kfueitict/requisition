
<div class="" style="background: #FFFFFF;">
    <div class="row">
        <div class="col-md-12">
            <h4 class="text-center" style="text-transform: uppercase; color: #008080; font-weight: bold; letter-spacing: 1.2px; margin-left: 150px;">
                DEPARTMENT WISE FACULTY POSITION
		<?php
                $_url = "";
                if(isset($url))
                {
                    foreach ($url as $link)
                    {
                        $_url = $link['link'];
                    }
			$b_url = base_url();
			$download_link = $b_url.$_url;
                    $success = "<a class=\"button\" href='".$download_link."'><strong style='font-size: 13px; letter-spacing: 0.1px; color: #008080; font-weight: 900;'>Print/Download</strong></a>";
                }
                ?>
		
		 <div class = "col-sm-3 pull-right">
                    <?php echo $success ?>
                </div>
            </h4>
            <table id="faculty_tbl" class="table table-bordered table-striped table-condensed table-hover" style="width: 100%;">
                <thead class="thead-inverse">
                <tr>
                    <th style="width: 50px; padding-bottom: 15px; text-align: center; color: #0000CD;">Sr #</th>
                    <th style="width: 260px; padding-bottom: 15px; color: #0000CD;">Departments</th>
                    <th style="text-align: center; padding-bottom: 15px; color: #0000CD;">Professor</th>
                    <th style="text-align: center; color: #0000CD;">Associate Professor</th>
                    <th colspan="2" style="width: 205px; text-align: center; padding-bottom: 15px; color: #0000CD;">Assistant Professor</th>
                    <th style="text-align: center; padding-bottom: 15px; color: #0000CD;">Lecturers</th>
                    <th style="text-align: center; color: #0000CD;">Teaching Assistant</th>
                    <th style="text-align: center; color: #0000CD;">Lab Engineer</th>
                    <th style="width: 60px; text-align: center; padding-bottom: 15px; color: #0000CD;">Total</th>
                </tr>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="width: 20px; text-align: center; color: #0000CD;">PHD</th>
                    <th style="width: 20px; text-align: center; color: #0000CD;">NON PHD</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $srNo = 0;   
                $dept_total = 0;
                $total_faculty = 0;
                $professor_total = 0;
                $asociate_prof_total = 0;
                $astant_prof_phd_total = 0;
                $astant_prof_nonphd_total=0;
                $prof_total = 0;
                $lec_total = 0;
                $ta_total = 0;
                $leb_engr_total = 0;
                $assoc_prof_total = 0;
                if(isset($faculty)){
                   
                    foreach($faculty as $edu){
                        $srNo += 1;
                        $title = substr($edu['dept_name'], 13, 50);
                        $vc = $edu['B22'];
                        $professor = $edu['B21'];
                        $associate_prof = $edu['B20'];
                        
                        $assistant_prof_phd = $edu['B19phd'];
                        $assistant_prof_nonphd = $edu['B19nophd'];
                        $lecturer = $edu['B18'];
                        $ta = $edu['TA'];
                        $lab_engr = $edu['B17'];
                        $total = $edu['total'];

                        $dept_total = $professor+$asociate_prof_total+$assistant_prof_phd+$assistant_prof_nonphd+$lec_total+$ta_total+$leb_engr_total+$total_faculty;
                        $professor_total += $professor;
                        $asociate_prof_total += $associate_prof;
                        
                        $astant_prof_phd_total += $assistant_prof_phd;
                        $astant_prof_nonphd_total += $assistant_prof_nonphd;
                        $lec_total += $lecturer;
                        $ta_total += $ta;
                        $leb_engr_total += $lab_engr;
                        $total_faculty += $total;

                        echo "<td style='text-align: center; font-weight: bold; color: #008080'>" . $srNo . "</td>";
                        echo "<td style='font-weight: bold; color: #008080'>" . $title . "</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>" . $professor . "</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>" . $associate_prof . "</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>" . $assistant_prof_phd . "</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>" . $assistant_prof_nonphd . "</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>" . $lecturer . "</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>" . $ta . "</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>" . $lab_engr . "</td>";
                        echo "<td style='text-align: center; font-weight: bold; color: #C71585'>" . $total . "</td>";
                        echo "</tr>";
                    }
                    echo "<tr>";
                    echo "<td colspan='2' style='font-weight: bold; color: #C71585'>Total Faculty Members</td>";
                    echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$professor_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$asociate_prof_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$astant_prof_phd_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$astant_prof_nonphd_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$lec_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$ta_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$leb_engr_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$total_faculty."</td>";
                    echo "</tr>";
                }
                ?>

                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5">
	<h4 class="text-center" style="text-transform: uppercase; color: #008080; font-weight: bold; letter-spacing: 1.2px;">
        Non Teaching Staff
                </h4>
            <table class="table-bordered table-striped table-condensed table-hover" style="width: 100%;">
                <thead>
                <tr>
                    <th style="color: #0000CD">Description</th>
                    <th style="text-align: center; color: #0000CD">No. of Employees</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $total = 0;
                if(isset($staff)){
                    foreach($staff as $record){
                        $officer_type = $record['Type'];
                        $officer = $record['Total'];
                        $total += $officer;

                        echo "<tr>"; 
                        echo "<td style='font-weight: bold; color: #008080'>" . $officer_type . "</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>" . $officer . "</td>";
                        echo "</tr>";

                    }
                    echo "<tr>";
                    echo "<td style='font-weight: bold; color: #C71585'>Total Staff</td>";
                    echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$total."</td>";
                    echo "</tr>";
                }
                ?>

                </tbody>
            </table>
                <div class="col-md-12" style="margin-top: 15px;">
                    <button id="btnStaff" class="btn btn-md" title = "Detail Staff Position" style=" background-color: #008080;">
                    <span style="font-weight: bold; color: white;">
                        DETAIL NON-TEACHING STAFF
                    </span></button>
                </div>
           </div>

        <div class="col-md-7">
                 <h4 class="text-center" style="text-transform: uppercase; color: #008080; font-weight: bold; letter-spacing: 1.2px;">
                    job status of all employees
                </h4>
                <table class="table-bordered table-striped table-condensed table-hover" style="width: 100%; margin-bottom: 10px;">
                    <thead>
                    <tr>
                        <th style="width: 0px; color: #0000CD;">Description</th>
                        <th style="text-align: center; width: 0px; color: #0000CD;">Teaching</th>
                        <th style="text-align: center; width: 0px; color: #0000CD;">Non-Teaching</th>
                        <th style="text-align: center; width: 0px; color: #0000CD;">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total = 0;
                    $t_total = 0;
                    $non_t_total = 0;
                    $all_emp_total = 0;
                    if(isset($all_emp)){
                        foreach($all_emp as $emp){
                            $job_type = $emp['JobTypeNew'];
                            $teaching = $emp['Teaching'];
                            $non_teaching = $emp['NonTeaching'];
                            $total = $emp['Total'];
                            $t_total += $teaching;
                            $non_t_total += $non_teaching;
                            $all_emp_total += $total;

                            echo "<tr class='active'>";
                            echo "<td style='font-weight: bold; color: #008080'>" . $job_type . "</td>";
                            echo "<td style='text-align: center; font-weight: bold;'>" . $teaching . "</td>";
                            echo "<td style='text-align: center; font-weight: bold;'>" . $non_teaching . "</td>";
                            echo "<td style='text-align: center; font-weight: bold; color: #C71585'>" . $total . "</td>";
                            echo "</tr>";

                        }
                        echo "<tr>";
                        echo "<td style='font-weight: bold; color: #C71585'>Total Employees</td>";
                        echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$t_total."</td>";
                        echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$non_t_total."</td>";
                        echo "<td style='text-align: center; font-weight: bold; color: #C71585'>".$all_emp_total."</td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
    </div>
</div>  

    