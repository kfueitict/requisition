
<div class="row"> 
    <div class="col-sm-12">
      <!-- Nav tabs -->
      

      <ul class="nav nav-tabs" role="tablist" style="margin-left: 165px;">  
        <li role="presentation" class="active">
        <a href="#home" class="btn btn-primary" aria-controls="home" role="tab" data-toggle="tab" style="padding: 10px 50px;
	font-weight: bold;">PRESENT</a>
        </li>
        <li role="presentation">
        <a href="#profile" class="btn btn-primary" aria-controls="profile" role="tab" data-toggle="tab" style="padding: 10px 50px;
	font-weight: bold;">ABSENT</a>
        </li>
        <li role="presentation">
        <a href="#leave" class="btn btn-primary" aria-controls="leave" role="tab" data-toggle="tab" style="padding: 10px 50px;
	font-weight: bold;">ON LEAVE</a>
        </li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="home">        
            <div id="no-more-tables" style="width: 100%">
            <table class="col-md-12 table-striped table-condensed cf tbl_emp" id="example">
        		<thead class="cf">
        			<tr>
        				<th style="text-align: center;">Sr. No</th>
        				<th style="width: 150%;">Name</th>
        				<th>Designation</th>
        				<th>Department</th>
        				<th>Check In</th>
        				<th>Check Out</th>
        			</tr>
        		</thead>
        		<tbody>
        		<?php
                    $count=0;
                    if(isset($present) && $present != null){
                        foreach($present as $key){
                            $count += 1;
                            $name = $key['NAME'];
                            $department = $key['DEPARTMENT'];
                            $designation = $key['DESIGNATION'];
                            $check_in = $key['CHKIN'];
                            $check_out = $key['CHKOUT'];
                    ?>
        			<tr>
        				<td style="text-align: center;"><?=$count; ?></td>
        				<td><?=$name; ?></td>
        				<td><?=$designation; ?></td>
        				<td><?=$department; ?></td>
        				<td><?=$check_in; ?></td>
        				<td><?=$check_out; ?></td>
        			</tr>
        			<?php
                        }
                    }
                    ?>

        		</tbody>
        	</table>
        </div>
            
        </div>
        <div role="tabpanel" class="tab-pane" id="profile">            
 <div id="no-more-tables" style="width: 100%">
            <table class="col-md-12 table-striped table-condensed cf  tbl_emp">
        		<thead class="cf">
        			<tr>
        				<th style="width: 10%; text-align: center;">Sr. No</th>
        				<th style="width: 30%;">Name</th>
        				<th style="width: 30%;">Designation</th>
        				<th style="width: 30%;">Department</th>
        			</tr>
        		</thead>
        		<tbody>
        		<?php
                    $count=0;
                    if(isset($absent) && $absent != null){
                        foreach($absent as $key){
                            $count += 1;
                            $name = $key->name;
                            $department = $key->department;
                            $designation = $key->designation;
                    ?>
        			<tr>
        				<td style="text-align: center;"><?=$count; ?></td>
        				<td><?=$name; ?></td>
        				<td><?=$designation; ?></td>
        				<td><?=$department; ?></td>
        			</tr>
        			<?php
                        }
                    }
                    ?>

        		        </tbody>
        	        </table>
                </div>
            </div>
        <div role="tabpanel" class="tab-pane" id="leave">            
 <div id="no-more-tables" style="width: 100%">
            <table class="col-md-12 table-striped table-condensed cf  tbl_emp">
        		<thead class="cf">
        			<tr>
        				<th style="width: 10%; text-align: center;">Sr. No</th>
        				<th style="width: 30%;">Name</th>
        				<th style="width: 30%;">Designation</th>
        				<th style="width: 30%;">Department</th>
        				<th style="width: 30%;">Title</th>
        				<th style="width: 30%;">From Date</th>
        				<th style="width: 30%;">To Date</th>
        			</tr>
        		</thead>
        		<tbody>
        		<?php
                    $count=0;
                    if(isset($leave) && $leave != null){
                        foreach($leave as $key){
                            $count += 1;
                            $id = $key->id;
                            $name = $key->name;
                            $department = $key->department;
                            $designation = $key->designation;
                            $leave_title = $key->leave_title;
                            $from_date = $key->from_date;
                            $to_date = $key->to_date;
                    ?>
        			<tr>
        				<td style="text-align: center;"><?=$count; ?></td>
        				<td><?=$name; ?></td>
        				<td><?=$designation; ?></td>
        				<td><?=$department; ?></td>
        				<td><?=$leave_title; ?></td>
        				<td><?=$from_date; ?></td>
        				<td><?=$to_date; ?></td>
        			</tr>
        			<?php
                        }
                    }
                    ?>

        		        </tbody>
        	        </table>
                </div>
            </div>    
          </div>
        </div>
    </div>
