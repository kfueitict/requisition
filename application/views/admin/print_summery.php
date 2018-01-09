<?php
?>
<div class="container" style="background: #FFFFFF; ">
    <div class="row" >
        <div class="col-md-12">
            <h3 class="text-center" style="text-transform: uppercase;">
                DEPARTMENT WISE FACULTY POSITION
            </h3>
            <table class="table table-bordered table-striped table-condensed table-hover" style="width: 100%;">
                <thead class="thead-inverse">
                <tr>
                    <th style="width: 165px;">Departments</th>
                    <th style="width: 10px;">Professor</th>
                    <th style="width: 10px;">Associate Professor</th>
                    <th colspan="2" style="width: 135px; text-align: center">Assistant Professor</th>
                    <th style="width: 20px;">Lecturers</th>
                    <th style="width: 10px;">Teaching Assistant</th>
                    <th style="width: 10px;">Lab Engineer</th>
                    <th style="width: 10px;">Total</th>
                </tr>
                <tr>
                    <th style="width: 165px;"></th>
                    <th style="width: 10px;"></th>
                    <th style="width: 10px;"></th>
                    <th style="width: 20px;">PHD</th>
                    <th style="width: 20px;">NON PHD</th>
                    <th style="width: 20px;"></th>
                    <th style="width: 10px;"></th>
                    <th style="width: 10px;"></th>
                    <th style="width: 10px;"></th>
                </tr>
                </thead>
                <tbody>
                <?php
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
                        $title = substr($edu['dept_name'], 13, 50);

                        $vc = $edu['B22'];
                        $professor = $edu['B21'];
                        $associate_prof = $edu['B20'];
                        $assistant_prof = $edu['B19'];
                        $assistant_prof_phd = $edu['B19phd'];
                        $assistant_prof_nonphd = $edu['B19nophd'];
                        $lecturer = $edu['B18'];
                        $ta = $edu['TA'];
                        $lab_engr = $edu['B17'];
                        $total = $edu['total'];

                        $dept_total = $professor+$asociate_prof_total+$astant_prof_total+$lec_total+$ta_total+$leb_engr_total+$total_faculty;
                        $professor_total += $professor;
                        $asociate_prof_total += $associate_prof;
                        $astant_prof_total += $assistant_prof;
                        $astant_prof_phd_total += $assistant_prof_phd;
                        $astant_prof_nonphd_total += $assistant_prof_nonphd;
                        $lec_total += $lecturer;
                        $ta_total += $ta;
                        $leb_engr_total += $lab_engr;
                        $total_faculty += $total;

                        echo "<tr>";
                        echo "<td>" . $title . "</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>" . $professor . "</td>";
                        echo "<td style='text-align: center'>" . $associate_prof . "</td>";
                        echo "<td style='text-align: center'>" . $assistant_prof_phd . "</td>";
                        echo "<td style='text-align: center'>" . $assistant_prof_nonphd . "</td>";
                        echo "<td style='text-align: center'>" . $lecturer . "</td>";
                        echo "<td style='text-align: center'>" . $ta . "</td>";
                        echo "<td style='text-align: center'>" . $lab_engr . "</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>" . $total . "</td>";
                        echo "</tr>";
                    }
                    echo "<tr>";
                    echo "<td style='font-weight: bold;'>Total Faculty Members</td>";
                    echo "<td style='text-align: center; font-weight: bold'>".$professor_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold'>".$asociate_prof_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold'>".$astant_prof_phd_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold'>".$astant_prof_nonphd_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold'>".$lec_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold'>".$ta_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold'>".$leb_engr_total."</td>";
                    echo "<td style='text-align: center; font-weight: bold'>".$total_faculty."</td>";
                    echo "</tr>";
                }
                ?>

                </tbody>
            </table>
        </div>
    </div>

    <div class="row" >
        <div class="col-md-5">
            <div class="col-md-12">
                <h3 class="text-center" style="text-transform: uppercase;">
                    Non Teaching Staff
                </h3>
                <table class="table-bordered table-striped table-condensed table-hover" style="width: 100%;">
                    <thead>
                    <tr>
                        <th>Description</th>
                        <th style="text-align: center">No. of Employees</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total = 0;
                    if(isset($staff)){

                        foreach($staff as $record){
                            $officer_type = $record['Type'];
                            $officer = $record['cnt'];
                            $total += $officer;

                            echo "<tr>";
                            echo "<td >" . $officer_type . "</td>";
                            echo "<td style='text-align: center;'>" . $officer . "</td>";
                            echo "</tr>";

                        }
                        echo "<tr>";
                        echo "<td style='font-weight: bold;'>Total Staff</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>".$total."</td>";
                        echo "</tr>";
                    }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-7">
            <div class="col-md-12">
                <h3 class="text-center" style="text-transform: uppercase;">
                    job status of all employees
                </h3>
                <table class="table-bordered table-striped table-condensed table-hover" style="width: 100%; margin-bottom: 10px;">
                    <thead>
                    <tr>
                        <th style="width: 0px;">Description</th>
                        <th style="text-align: center; width: 0px;">Teaching</th>
                        <th style="text-align: center; width: 0px;">Non Teaching</th>
                        <th style="text-align: center; width: 0px;">Total</th>
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
                            $job_type = $emp['JobType'];
                            $teaching = $emp['Teaching'];
                            $non_teaching = $emp['NonTeaching'];
                            $total = $emp['Total'];
                            $t_total += $teaching;
                            $non_t_total += $non_teaching;
                            $all_emp_total += $total;

                            echo "<tr class='active'>";
                            echo "<td>" . $job_type . "</td>";
                            echo "<td style='text-align: center'>" . $teaching . "</td>";
                            echo "<td style='text-align: center'>" . $non_teaching . "</td>";
                            echo "<td style='text-align: center; font-weight: bold;'>" . $total . "</td>";
                            echo "</tr>";

                        }
                        echo "<tr>";
                        echo "<td style='font-weight: bold'>Total Employees</td>";
                        echo "<td style='text-align: center; font-weight: bold'>".$t_total."</td>";
                        echo "<td style='text-align: center; font-weight: bold'>".$non_t_total."</td>";
                        echo "<td style='text-align: center; font-weight: bold;'>".$all_emp_total."</td>";
                        echo "</tr>";
                    }
                    ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

    