<?php $this->load->view('include/header');?>
<style>
    #service-tbl table {
        counter-reset: rowNumber;
    }

    #service-tbl table tr:not(:first-child)  {
        counter-increment: rowNumber;
    }

    #service-tbl table tr td:first-child::after {
        content: counter(rowNumber);
        min-width: 1em;
        margin-right: 0.5em;
    }
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo @$title ?>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="<?php echo base_url('cms/employees') ?>"><i class="fa fa-users"></i>Employees</a></li>
            <li class="active"><?php echo @$title ?></li>
        </ol>
    </section>
    <?php if($this->session->flashdata('message'))
    {?>
        <div class="box-body">
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                <?php echo $this->session->flashdata('message') ;?>
            </div>
        </div>
    <?php }
    ?>
    <!-- Main content -->
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <i class="fa fa-user"></i>
                <h3 class="box-title"></h3>
                <button type="button"
                        onclick="window.location.href='<?php echo base_url('cms/employees')?>'" class="btn btn-info pull-right">Back</button>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form id="form1" class="form-horizontal" action="" method="post" enctype="multipart/form-data">
                <input type="hidden" value="<?php echo @$user->id ?>" name="update_id">
                <input type="hidden" id="tbl" value="employees">
                <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <label class="control-label"  for="title">Title</label>
                        <select class="form-control" name="title" id="title">
                            <?php
                            $titles=array(
                                'Mr.',
                                'Ms.',
                                'Mrs.',
                                'Engr.',
                                'Dr.'
                            );
                            if(is_array(@$titles)||is_object(@$titles))
                                foreach(@$titles as $v)
                                {
                                    $select='';
                                    if(@$user->title==$v)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$v.'"  >'.$v.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="name">Name</label>
                        <input type="text" required="" class="form-control"
                               value="<?php echo @$user->name ?>"
                               id="name"
                               name="name"
                               placeholder="Name">
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="father_name">Father Name</label>
                        <input type="text" required="" class="form-control"
                               value="<?php echo @$user->father_name ?>"
                               id="father_name"
                               name="father_name"
                               placeholder="Father Name">
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="bm_id">Biometric ID</label>
                        <input type="number" class="form-control"
                               value="<?php echo @$user->bm_id ?>"
                               id="bm_id"
                               name="bm_id"
                               placeholder="">
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="eci">ECI</label>
                        <select class="form-control" name="eci" id="eci">
                            <?php
                            $eci=array(
                                1=>'Not Processed',
                                2=>'In Process',
                                3=>'Issued',
                            );
                            if(is_array(@$eci)||is_object(@$eci))
                                foreach(@$eci as $k=>$v)
                                {
                                    $select='';
                                    if(@$user->eci==$k)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$k.'"  >'.$v.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-6 hide" id="rfid-col">
                        <label class="control-label"  for="rfid">RFID Number</label>
                        <input type="number" class="form-control"
                               value="<?php echo @$user->rfid ?>"
                               id="rfid"
                               name="rfid">
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <label class=" control-label"  for="designation">Job Designation</label>
                            <select class="form-control" required="" id="designation" name="designation">
                                <option value="">Select Designation</option>
                                <?php
                                if(is_array(@$designations)||is_object(@$designations))
                                    foreach(@$designations as $type)
                                    {
                                        $select='';
                                        if(@$user->designation==$type->id||@$bps_row->parent_id==$type->id)
                                            $select='selected';
                                        echo '<option '.$select.' value="'.$type->id.'"  >'.$type->title.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="control-label"  for="additional_bps">Additional BPS</label>
                            <select class="form-control required" name="additional_bps" id="additional_bps">
                                <option value="">NA</option>
                                <?php
                                if(is_array(@$additional_bps)||is_object(@$additional_bps))
                                    foreach(@$additional_bps as $type)
                                    {
                                        $select='';
                                        if(@$user->designation==$type->id)
                                            $select='selected';
                                        echo '<option '.$select.' value="'.$type->id.'"  >'.$type->bps.'-'.$type->title.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class="control-label"  for="gender">Gender</label>
                            <select class="form-control required" name="gender" id="gender">
                                <?php
                                $gender=array(
                                    '1'=>'Male',
                                    '2'=>'Female',
                                );
                                if(is_array(@$gender)||is_object(@$gender))
                                    foreach(@$gender as $k=>$v)
                                    {
                                        $select='';
                                        if(@$user->gender==$k)
                                            $select='selected';
                                        echo '<option '.$select.' value="'.$k.'"  >'.$v.'</option>';
                                    }
                                ?>


                            </select>
                        </div>
                        <div class="col-md-1">
                            <label class=" control-label"  for="hod">Is HOD?</label>
                            <input type="checkbox" <?php if(@$user->is_hod==1) echo 'checked' ?> name="is_hod" id="hod" value="1" class="checkbox">
                        </div>
                        <div class="col-md-2">
                            <label class=" control-label"  for="is_teaching">Is Teaching?</label>
                            <input type="checkbox" <?php if(@$user->is_teaching==1) echo 'checked' ?> name="is_teaching" id="is_teaching" value="1" class="checkbox">
                        </div>

                    </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label class="control-label"  for="nationality">Nationality</label>

                        <select class="form-control" name="nationality" id="nationality">
                            <option value="">Select Nationality</option>
                            <?php if(is_array(@$countries)||is_object(@$countries))
                                foreach(@$countries as $k)
                                {
                                    $select='';
                                    if(@$user->nationality==$k->id)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$k->id.'"  >'.$k->title.'</option>';
                                }
                            ?>
                        </select>

                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="religion">Religion</label>
                        <select class="form-control required" name="religion" id="religion">
                            <option value="">Select Religion</option>
                            <?php
                            $religions=array(
                                'Islam'=>'Islam',
                                'Agnosticism'=>'Agnosticism',
                                'Aztec'=>'Aztec',
                                'Baha'=>'Baha',
                                'Buddhism'=>'Buddhism',
                                'Candomble'=>'Candomble',
                                'Christianity'=>'Christianity',
                                'Confucianism'=>'Confucianism',
                                'Hare Krishna'=>'Hare Krishna',
                                'Hinduism'=>'Hinduism',
                                'Jainism'=>'Jainism',
                                "Judaism's"=>"Judaism's",
                                "Mormonism"=>"Mormonism",
                                "Ocha/Voodoo/Ifa/Orisha"=>"Ocha/Voodoo/Ifa/Orisha",
                                "Paganism"=>"Paganism",
                                "Palo Mayombe y Palo Monte"=>"Palo Mayombe y Palo Monte",
                                "Peyotism"=>"Peyotism",
                                "Qadyani"=>"Qadyani",
                                "Quimbisa"=>"Quimbisa",
                                "Santeri"=>"Santeri",
                                "Satanism"=>"Satanism",
                                "Scientology"=>"Scientology",
                                "Shangoism"=>"Shangoism",
                                "Shintoism"=>"Shintoism",
                                "Sikhism"=>"Sikhism",
                                "Taoism"=>"Taoism",
                                "Umbanda y Quimbanda"=>"Umbanda y Quimbanda",
                                "Unitarian"=>"Unitarian",
                                "Universalism"=>"Universalism",
                                "Voudou"=>"Voudou",
                                "Wicca"=>"Wicca",
                                "Zen"=>"Zen",
                                "Zoroastrianism"=>"Zoroastrianism",
                                "Sathya Sai Baba/Shirdi Sa"=>"Sathya Sai Baba/Shirdi Sa",
                                'Atheism'=>'Atheism'
                            );
                            if(is_array(@$religions)||is_object(@$religions))
                                foreach(@$religions as $k=>$v)
                                {
                                    $select='';
                                    if(@$user->religion==$k)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$v.'"  >'.$k.'</option>';
                                }
                            ?>


                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="domicile">Domicile</label>
                        <select class="form-control" name="domicile" id="domicile">
                            <option value="">Select District</option>
                            <?php if(is_array(@$districts)||is_object(@$districts))
                                foreach(@$districts as $k)
                                {
                                    $select='';
                                    if(@$user->domicile==$k->id)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$k->id.'"  >'.$k->title.'</option>';
                                }
                            ?>
                        </select>

                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="cnic">CNIC</label>
                        <input type="text" required="" class="form-control"
                               value="<?php echo @$user->cnic ?>"
                               id="cnic"
                               name="cnic"
                               placeholder="CNIC">
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="blood_group">Blood Group</label>
                        <select class="form-control required" id="blood_group" name="blood_group">
                            <option value="">Select Blood Group</option>
                            <?php
                            $titles=array(
                                'A Negative',
                                'A Positive',
                                'A Unknown',
                                'B Positive',
                                'B Negative',
                                'B Unknown',
                                'AB Positive',
                                'AB Negative',
                                'AB Unknown',
                                'O Positive',
                                'O Negative',
                                'O Unknown',
                                'Unknown',
                            );
                            if(is_array(@$titles)||is_object(@$titles))
                                foreach(@$titles as $v)
                                {
                                    $select='';
                                    if(@$user->blood_group==$v)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$v.'"  >'.$v.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class=" control-label"  for="passport_no">Passport No</label>
                        <input type="text" class="form-control"
                               value="<?php echo @$user->passport_no ?>"
                               id="passport_no"
                               name="passport_no"
                               placeholder="Passport No">
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="mobile_no">Mobile No</label>
                        <input type="tel" required="" class="form-control"
                               value="<?php echo @$user->mobile_no ?>"
                               id="mobile_no"
                               name="mobile_no"
                               placeholder="Mobile No">
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="phone_no">Phone No</label>
                        <input type="tel" required="" class="form-control"
                               value="<?php echo @$user->phone_no ?>"
                               id="phone_no"
                               name="phone_no"
                               placeholder="Phone No">
                    </div>
                    <div class="col-sm-6">
                        <label class=" control-label"  for="nok">Next of Kin</label>
                        <input type="text" required="" class="form-control"
                               value="<?php echo @$user->nok ?>"
                               id="nok"
                               name="nok"
                               placeholder="Next of Kin">
                    </div>
                    <div class="col-sm-6">
                        <?php
                        $kin=array(
                            "Brother"=>"Brother",
                            "Son"=>"Son",
                            "Brother In Law"=>"Brother In Law",
                            "Cousin"=>"Cousin",
                            "Daughter"=>"Daughter",
                            "Father"=>"Father",
                            "Father In Law"=>"Father In Law",
                            "Friend"=>"Friend",
                            "Grand Father"=>"Grand Father",
                            "Grand Mother"=>"Grand Mother",
                            "Husband"=>"Husband",
                            "Mother"=>"Mother",
                            "Nephew"=>"Nephew",
                            "Niece"=>"Niece",
                            "Sister"=>"Sister",
                            "Uncle"=>"Uncle",
                            "Wife"=>"Wife",
                        );
                        ?>
                        <label class=" control-label"  for="relation">Relation</label>
                        <select class="form-control" id="relation"
                                name="relation">
                            <?php
                            if(is_array(@$kin)||is_object(@$kin))
                                foreach(@$kin as $k=>$v)
                                {
                                    $select='';
                                    if(@$user->relation==$k)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$k.'"  >'.$v.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class=" control-label"  for="e_phone_no">Contact No(Next of Kin)</label>
                        <input type="tel" required="" class="form-control"
                               value="<?php echo @$user->e_phone_no ?>"
                               id="e_phone_no"
                               name="e_phone_no"
                               placeholder="Emergency Contact No">
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="date">Date of Birth</label>
                        <input type="text" required="" class="form-control datepicker" data-date-format="yyyy/mm/dd"
                               value="<?php echo @$user->dob ?>"
                               id="dob"
                               name="dob"
                               placeholder="date of birth">
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="present_address">Present Address</label>
                        <input type="text" required="" class="form-control"
                               value="<?php echo @$user->present_address ?>"
                               id="present_address"
                               name="present_address"
                               placeholder="Present Address">
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="permanent_address">Permanent Address</label>
                        <input type="text" required="" class="form-control"
                               value="<?php echo @$user->permanent_address ?>"
                               id="permanent_address"
                               name="permanent_address"
                               placeholder="Permanent Address">
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="email">Email</label>
                        <input type="email" required="" class="form-control"
                               value="<?php echo @$user->email ?>"
                               id="email"
                               name="email"
                               placeholder="Email">
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="app_letter_no">App Letter No</label>
                        <input type="text"  class="form-control"
                               value="<?php echo @$user->app_letter_no ?>"
                               id="app_letter_no"
                               name="app_letter_no"
                               placeholder="App Letter No">
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="bio_data_form">BIO Data Form</label>
                        <select class="form-control" id="bio_data_form"
                                name="bio_data_form">
                            <?php
                            $jobs=array(
                                '0'=>'No',
                                '1'=>'Yes'
                            );
                            if(is_array(@$jobs)||is_object(@$jobs))
                                foreach(@$jobs as $k=>$v)
                                {
                                    $select='';
                                    if(@$user->bio_data_form==$k)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$k.'"  >'.$v.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="erv">ERV</label>
                        <select class="form-control" id="erv"
                                name="erv">
                            <option value="">Select ERV</option>
                            <?php
                            $jobs=array(
                                'Verified'=>'Verified',
                                'Not Verified'=>'Not Verified',
                                'Not Applicable'=>'Not Applicable',
                                'Still in Process'=>'Still in Process'
                            );
                            if(is_array(@$jobs)||is_object(@$jobs))
                                foreach(@$jobs as $k=>$v)
                                {
                                    $select='';
                                    if(@$user->erv==$k)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$k.'"  >'.$v.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-6">

                            <label class="control-label"  for="joining_letter_no">Joining Letter No</label>

                                <input type="text"  class="form-control"
                                       value="<?php echo @$user->joining_letter_no ?>"
                                       id="joining_letter_no"
                                       name="joining_letter_no"
                                       placeholder="Joining Letter No">


                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="doa">Date of Joining</label>

                            <input type="text" required="" class="form-control datepicker" data-date-format="yyyy/mm/dd"
                                   value="<?php echo @$user->doa ?>"
                                   id="doa"
                                   name="doa"
                                   placeholder="Date of Joining">

                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="job_type">Type of Job</label>

                            <select class="form-control" required="" id="job_type" name="job_type">
                                <option value="">Select Job Type</option>
                                <?php
                                $jobs=array(
                                    'Adhoc'=>'Adhoc',
                                    'Contract'=>'Contract',
                                    'Permanent'=>'Permanent',
                                    'Daily Wages'=>'Daily Wages',
                                    'IPFP'=>'IPFP',
                                );
                                if(is_array(@$jobs)||is_object(@$jobs))
                                    foreach(@$jobs as $k=>$v)
                                    {
                                        $select='';
                                        if(@$user->job_type==$k)
                                            $select='selected';
                                        echo '<option '.$select.' value="'.$v.'"  >'.$k.'</option>';
                                    }
                                ?>
                            </select>

                    </div>
                    </div>
                    <div id="expire-fields">
                        <div class="row">
                            <div class="col-sm-12">

                                <label class="control-label "  for="police_case">Contract Details</label>
                                <div class="border">
                                    <button class="pull-right btn grbg btn-success whc" type="button" id="add-contract">Add Contract</button>
                                    <div id="service-tbl">
                                        <table id="tbl-services" class="table table-bordered">
                                            <tbody id="c-body">
                                            <tr>
                                                <th >Sr.</th>
                                                <th width="25%">Contract Type</th>
                                                <th width="20%">Contract Date</th>
                                                <th width="20%">Expire Date</th>
                                                <th width="10%">Months</th>
                                                <th width="25%">Reference</th>
                                                <th>Action</th>
                                            </tr>
                                            <?php
                                            if(isset($details_c)) {
                                                if (is_array(@$details_c) || is_object(@$details_c))
                                                    foreach ($details_c as $detail) {
                                                        echo '<tr>
<td></td>
<td>';?>
                                                        <select class="form-control" required="" name="contract_type[]">
                                                            <option value="">Select Job Type</option>
                                                            <?php
                                                            $jobs=array(
                                                                'Adhoc'=>'Adhoc',
                                                                'Contract'=>'Contract',
                                                                'Permanent'=>'Permanent',
                                                                'Daily Wages'=>'Daily Wages',
                                                                'IPFP'=>'IPFP',
                                                            );
                                                            if(is_array(@$jobs)||is_object(@$jobs))
                                                                foreach(@$jobs as $k=>$v)
                                                                {
                                                                    $select='';
                                                                    if(@$detail->contract_type==$k)
                                                                        $select='selected';
                                                                    echo '<option '.$select.' value="'.$k.'"  >'.$v.'</option>';
                                                                }
                                                            ?>
                                                        </select>
                                                        <?php echo '</td>
                                                                    <td><input name="contract_date[]" class="form-control date-class"  type="text" value="' . @$detail->contract_date . '"></td>
                                                                    <td><input name="exp_date[]" class="form-control date-class"  type="text" value="' . @$detail->exp_date . '"></td>
                                                                    <td><input name="months[]" class="form-control days"  type="number" readonly value="' . @$detail->duration . '"></td>
                                                                    <td><input name="reference[]" class="form-control"  type="text" value="' . @$detail->reference . '"></td>
                                                                    <td class="txt-c"><a class="btn redbg whc" onclick="' . " $(this).parents('tr').remove();" . '" ><i class="fa fa-close whc"></i></a></td>
                                                                    </tr>';
                                                    }
                                            }else
                                            {

                                                ?>

                                            <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>


                                </div>

                            </div>
                        </div>

                    </div>
                <div class="row">
                    <div class="col-sm-6">
                        <label class="control-label"  for="job_status">Job Status</label>

                        <select class="form-control" required="" id="job_status" name="job_status">
                            <option value="">Select Job Status</option>
                            <?php
                            $jobsS=array(
                                'Active'=>'Active',
                                'Resigned'=>'Resigned',
                                'Terminated'=>'Terminated',
                                'NCNS'=>'NCNS',
                                'De Active'=>'De Active',
                            );
                            if(is_array(@$jobsS)||is_object(@$jobsS))
                                foreach(@$jobsS as $k=>$v)
                                {
                                    $select='';
                                    if(@$user->job_status==$k)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$v.'"  >'.$k.'</option>';
                                }
                            ?>
                        </select>

                    </div>
                    <div class="col-sm-6">
                        <label class=" control-label"  for="job_status_date">Job Status Date</label>


                        <input type="text" class="form-control datepicker" data-date-format="yyyy/mm/dd"
                               value="<?php echo @$user->job_status_date ?>"
                               id="job_status_date"
                               name="job_status_date"
                               placeholder="">


                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="salary">Salary</label>

                                <input type="number" class="form-control"
                                       value="<?php echo @$user->salary ?>"
                                       id="salary"
                                       name="salary"
                                       placeholder="Salary">

                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="department">Current Department</label>

                            <select class="form-control" required="" id="department" name="department">
                                <option value="">Select Department</option>
                                <?php
                                if(is_array(@$department)||is_object(@$department))
                                    foreach(@$department as $type)
                                    {
                                        $select='';
                                        if(@$user->department==$type->id)
                                            $select='selected';
                                        echo '<option '.$select.' value="'.$type->id.'"  >'.$type->title.'</option>';
                                    }
                                ?>
                            </select>

                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="ps_name">Police Station Name</label>

                            <input type="text" class="form-control"
                                   value="<?php echo @$user->ps_name ?>"
                                   id="ps_name"
                                   name="ps_name"
                                   placeholder="ps name">

                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="org_name">Organization Name</label>

                            <input type="text" class="form-control"
                                   value="<?php echo @$user->org_name ?>"
                                   id="org_name"
                                   name="org_name"
                                   placeholder="org name">


                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="org_phone">Organization Phone</label>

                            <input type="text" required="" class="form-control"
                                   value="<?php echo @$user->org_phone ?>"
                                   id="org_phone"
                                   name="org_phone"
                                   placeholder="org phone">


                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="first_name">Image</label>
                        <input type="hidden" name="old_img" value="<?php echo @$user->img ?>">

                            <input type="file" class="form-control"

                                   id="img"
                                   name="img"
                                   placeholder="Image">



                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-12">

                            <label class="control-label "  for="police_case">Education Details</label>
                            <div class="border">
                                <button class="pull-right btn grbg btn-success whc" type="button" id="add-service">Add Education</button>
                                <div id="service-tbl">
                                    <table id="tbl-services" class="table table-bordered">
                                        <tbody id="s-body">
                                        <tr>
                                            <th >Sr.</th>
                                            <th width="25%">Degree/Certificate</th>
                                            <th width="25%">Institute</th>
                                            <th>Year</th>
                                            <th>Roll No</th>
                                            <th>Certificate No.</th>
                                            <th>Total Marks/CGPA</th>
                                            <th>Obtained Marks/CGPA</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php
                                        if(isset($details)) {
                                            if (is_array(@$details) || is_object(@$details))
                                                foreach ($details as $detail) {
                                                    echo '<tr>
<td></td>
<td><select class="form-control degree" name="degree[]" >';
                                                    if(is_array(@$degrees)||is_object(@$degrees))
                                                        foreach($degrees as $degree)
                                                        {
                                                            $s='';
                                                            if($degree->id==$detail->degree)
                                                                $s='selected';
                                                            echo '<option '.$s.' value="'.$degree->id.'">'.$degree->title.'</option>';
                                                        }
echo '</td>
<td><select class="form-control board" name="board[]" >';

                                                    if(is_array(@$boards)||is_object(@$boards))
                                                        foreach($boards as $board)
                                                        {
                                                            $s='';
                                                            if($board->id==$detail->board)
                                                                $s='selected';
                                                            echo '<option '.$s.' value="'.$board->id.'">'.$board->title.'</option>';
                                                        }

                                                    echo '</select></td>
<td><input name="year[]" class="form-control"  type="text" value="' . $detail->year . '"></td>
<td><input name="roll_no[]" class="form-control"  type="text" value="' . $detail->roll_no . '"></td>
<td><input name="certificate_no[]" class="form-control"  type="text" value="' . $detail->certificate_no . '"></td>
<td><input name="total_marks[]" class="form-control"  type="text" value="' . ($detail->total_marks+0) . '"></td>
<td><input name="obtained_marks[]" class="form-control"  type="text" value="' . ($detail->obtained_marks+0) . '"></td>
<td class="txt-c"><a class="btn redbg whc" onclick="' . " $(this).parents('tr').remove();" . '" ><i class="fa fa-close whc"></i></a></td>
</tr>';
                                                }
                                        }else
                                        {

                                            ?>
                                            <tr>
                                                <td></td>
                                                <td><select class="form-control degree" name="degree[]" id="degree">
                                                        <?php


                                                        if(is_array(@$degrees)||is_object(@$degrees))
                                                            foreach($degrees as $degree)
                                                            {
                                                                echo '<option value="'.$degree->id.'">'.$degree->title.'</option>';
                                                            }
                                                        ?>
                                                    </select> </td>
                                                <td>
                                                    <select class="form-control board" name="board[]" id="board">

                                                        <?php
                                                        if(is_array(@$boards)||is_object(@$boards))
                                                            foreach($boards as $board)
                                                            {
                                                                echo '<option value="'.$board->id.'">'.$board->title.'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td><input name="year[]" id="year" type="text" class="form-control"></td>
                                                <td><input name="roll_no[]" id="year" type="text" class="form-control"></td>
                                                <td><input name="certificate_no[]" id="year" type="text" class="form-control"></td>
                                                <td><input name="total_marks[]" id="total_marks" type="text" class="form-control"></td>
                                                <td><input name="obtained_marks[]" id="obtained_marks" type="text" class="form-control"></td>
                                                <td class="txt-c"><a class="btn redbg whc" onclick=" $(this).parents('tr').remove();" ><i class="fa fa-close whc"></i></a></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>


                            </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">

                            <label class="control-label "  for="police_case">Police/Army/Govt. Experience</label>
                            <div class="border">
                                <button class="pull-right btn grbg btn-success whc" type="button" id="add-experience">Add Experience</button>
                                <div id="service-tbl">
                                    <table id="tbl-services" class="table table-bordered">
                                        <tbody id="e-body">
                                        <tr>
                                            <th >Sr.</th>
                                            <th width="25%">Job Designation</th>
                                            <th width="25%">Employer</th>
                                            <th>From Date</th>
                                            <th>To Date</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php
                                        if(isset($details_e)) {
                                            if (is_array(@$details_e) || is_object(@$details_e))
                                                foreach ($details_e as $detail) {
                                                    echo '<tr>
<td></td>
<td><select class="form-control" name="e_designation[]" ><option value="' . $detail->designation . '">' . $detail->designationt . '</option></select></td>
<td><select class="form-control" name="employer[]" ><option value="' . $detail->employer . '">' . $detail->employert . '</option></select></td>
<td><input name="from_date[]" class="form-control" readonly type="text" value="' . $detail->from_date . '"></td>
<td><input name="to_date[]" class="form-control" readonly type="text" value="' . $detail->to_date . '"></td>
<td class="txt-c"><a class="btn redbg whc" onclick="' . " $(this).parents('tr').remove();" . '" ><i class="fa fa-close whc"></i></a></td>
</tr>';
                                                }
                                        }else
                                        {

                                            ?>
                                            <tr>
                                                <td></td>
                                                <td><select class="form-control e_designation" name="e_designation[]" id="e_designation">
                                                        <?php


                                                        if(is_array(@$designations)||is_object(@$designations))
                                                            foreach($designations as $designation)
                                                            {
                                                                echo '<option value="'.$designation->id.'">'.$designation->title.'</option>';
                                                            }
                                                        ?>
                                                    </select> </td>
                                                <td>
                                                    <select class="form-control employer" name="employer[]" id="employer">

                                                        <?php
                                                        if(is_array(@$employers)||is_object(@$employers))
                                                            foreach($employers as $employer)
                                                            {
                                                                echo '<option value="'.$employer->id.'">'.$employer->title.'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </td>
                                                <td><input name="from_date[]" type="text" class="form-control datepicker"></td>
                                                <td><input name="to_date[]" type="text" class="form-control datepicker"></td>
                                                <td class="txt-c"><a class="btn redbg whc" onclick=" $(this).parents('tr').remove();" ><i class="fa fa-close whc"></i></a></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>


                            </div>

                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <label class="control-label"  for="police_case">If any police case</label>

                            <textarea class="form-control" id="police_case"
                                      name="police_case"
                                      placeholder="Police Case"><?php echo @$user->police_case ?></textarea>



                    </div>
                </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-success"><?php echo @$button ?></button>
                        </div>
                </div><!-- /.box-footer -->
            </form>
        </div><!-- /.box -->


    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php $this->load->view('include/footer'); ?>
<script>

    $('#add-service').on('click',function (evt) {
        $('#s-body').append('<tr>'+
        '<td></td>'+
        '<td><select class="form-control degree" name="degree[]" id="degree"><?php
                                                if(is_array(@$degrees)||is_object(@$degrees))
                                                    foreach($degrees as $degree)
                                                    {
                                                        echo '<option value="'.$degree->id.'">'.$degree->title.'</option>';
                                                    }
                                                ?></select></td>'+
        '<td><select class="form-control board" name="board[]" id="board"><?php
                                                if(is_array(@$boards)||is_object(@$boards))
                                                    foreach($boards as $board)
                                                    {
                                                        echo '<option value="'.$board->id.'">'.$board->title.'</option>';
                                                    }
                                                ?></select></td>'+
        '<td><input name="year[]" id="year" type="text" class="form-control"></td>'+
        '<td><input name="roll_no[]"  type="text" class="form-control"></td>'+
        '<td><input name="certificate_no[]"  type="text" class="form-control"></td>'+
        '<td><input name="total_marks[]" type="text" class="form-control"></td>'+
        '<td><input name="obtained_marks[]" id="obtained_marks" type="text" class="form-control"></td>'+
        '<td><a class="btn redbg whc" onclick=" $(this).parents('+'\'tr\''+').remove();" ><i class="fa fa-close whc"></i></a></td>'+
        '</tr>');

    });
    $('#add-experience').on('click',function (evt) {
        $('#e-body').append('<tr>'+
        '<td></td>'+
        '<td><select class="form-control e_designation" name="e_designation[]"><?php
                                                if(is_array(@$designations)||is_object(@$designations))
                                                    foreach($designations as $designation)
                                                    {
                                                        echo '<option value="'.$designation->id.'">'.$designation->title.'</option>';
                                                    }
                                                ?></select></td>'+
        '<td><select class="form-control employer" name="employer[]"><?php
                                                if(is_array(@$employers)||is_object(@$employers))
                                                    foreach($employers as $employer)
                                                    {
                                                        echo '<option value="'.$employer->id.'">'.$employer->title.'</option>';
                                                    }
                                                ?></select></td>'+
        '<td><input name="from_date[]" type="text" class="form-control datepicker"></td>'+
        '<td><input name="to_date[]"  type="text" class="form-control datepicker"></td>'+
        '<td><a class="btn redbg whc" onclick=" $(this).parents('+'\'tr\''+').remove();" ><i class="fa fa-close whc"></i></a></td>'+
        '</tr>');
        $('.datepicker').datepicker(
            {
                format:'yyyy/mm/dd'
            }
        );
    });
    $('#add-contract').on('click',function (evt) {
        $('#c-body').append('<tr>'+
        '<td></td>'+
        '<td><select class="form-control" name="contract_type[]"><?php
                                                if(is_array(@$jobs)||is_object(@$jobs))
                                                    foreach($jobs as $k=>$v)
                                                    {
                                                        echo '<option value="'.$k.'">'.$v.'</option>';
                                                    }
                                                ?></select></td>'+
        '<td><input name="contract_date[]"  type="text" class="form-control datepicker"></td>'+
        '<td><input name="exp_date[]"  type="text" class="form-control datepicker"></td>'+
        '<td><input name="months[]" readonly class="form-control days"  type="number"></td>'+
        '<td><input name="reference[]"  type="text" class="form-control"></td>'+
        '<td><a class="btn redbg whc" onclick=" $(this).parents('+'\'tr\''+').remove();" ><i class="fa fa-close whc"></i></a></td>'+
        '</tr>');
        $('.datepicker').datepicker(
            {
                format:'yyyy/mm/dd'
            }
        );
    });


</script>
<script>
    $(document).on('change','#job_type', function () {

       if(this.value=='Permanent')
       $("#expire-fields").addClass('hide');else
       $("#expire-fields").removeClass('hide');

    });
    $(document).on('change','.degree', function () {
        if($(this).find("option:selected").text()=="Other")
        {
            $(this).after('<input class="form-control" name="other_degree_'+this.parentNode.parentNode.rowIndex+'">');
        }else
        {
            $(this).next().remove();
        }


    });
    $(document).on('change','.board', function () {
        if($(this).find("option:selected").text()=="Other")
        {
            $(this).after('<input class="form-control" name="other_board_'+this.parentNode.parentNode.rowIndex+'">');
        }else
        {
            $(this).next().remove();
        }


    });
    $(document).on('change','.e_designation', function () {
        if($(this).find("option:selected").text()=="Other")
        {
            $(this).after('<input class="form-control" name="other_designation_'+this.parentNode.parentNode.rowIndex+'">');
        }else
        {
            $(this).next().remove();
        }


    });
    $(document).on('change','.employer', function () {
        if($(this).find("option:selected").text()=="Other")
        {
            $(this).after('<input class="form-control" name="other_employer_'+this.parentNode.parentNode.rowIndex+'">');
        }else
        {
            $(this).next().remove();
        }


    });
    $(document).ready(function(){
        $('#job_type').trigger('change');
        $('#eci').trigger('change');

        $("#form1").validationEngine(
        );
    });
</script>
<script>
    $(function () {
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        });
        //Red color scheme for iCheck
        $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
            checkboxClass: 'icheckbox_minimal-red',
            radioClass: 'iradio_minimal-red'
        });
        //Flat red color scheme for iCheck
        $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
            checkboxClass: 'icheckbox_flat-green',
            radioClass: 'iradio_flat-green'
        });
    });
    $('.datepicker').datepicker({
        format:'yyyy/mm/dd'
    });

    $(document).on('change','.datepicker', function () {
        var row = $(this).closest("tr");    // Find the row
        var from_date,to_date;
        $(this).closest('tr').find("input").each(function() {
            if(this.name == 'contract_date[]')
                from_date=this.value;
            if(this.name == 'exp_date[]')
                to_date=this.value;
        });
        $(this).closest("tr").find("input.days").val(getMonthsBetween(from_date,to_date,true));
    }); $(document).on('change','.date-class', function () {
        var row = $(this).closest("tr");    // Find the row
        var from_date,to_date;
        $(this).closest('tr').find("input").each(function() {
            if(this.name == 'contract_date[]')
                from_date=this.value;
            if(this.name == 'exp_date[]')
                to_date=this.value;
        });
        $(this).closest("tr").find("input.days").val(getMonthsBetween(from_date,to_date,true));
    });
    function getBPS(){
        var gender=$('#gender').val();
        var designation=$('#designation').val();
        $('#additional_bps').empty();
        $.ajax({
            method: "POST",
            url: BASE_URL+"cms/designations/additional_bps",
            data: { gender: gender, designation: designation }
        })
            .done(function( responce ) {
                $('#additional_bps').append(responce);
            });

    }
    $(document).on('change',"#designation",getBPS);
    $(document).on('change',"#eci",setRFID);
    $(document).on('change',"#gender",getBPS);
    
    function setRFID() {
        var rfid_col=$("#rfid-col");
        var rfid=$("#rfid");
        var eci=$("#eci");
        if(eci.val()!=3)
        {
            rfid.attr('required',false);
            rfid_col.addClass('hide');
        }else
        {
            rfid.attr('required',true);
            rfid_col.removeClass('hide');
        }
    }
    var _MS_PER_DAY = 1000 * 60 * 60 * 24;

    // a and b are javascript Date objects
    function dateDiffInDays1(a, b) {
        a= new Date(a);
        b= new Date(b);
        // Discard the time and time-zone information.
        var utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
        var utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate());
        var days=Math.floor((utc2 - utc1) );/// _MS_PER_DAY);
        if(days>-1)
            days++;
        else
            days=0;
        return days;
    }

    function getMonthsBetween(date1,date2,roundUpFractionalMonths)
    {
        //Months will be calculated between start and end dates.
        //Make sure start date is less than end date.
        //But remember if the difference should be negative.
        var startDate= new Date(date1);
        var endDate= new Date(date2);
        var inverse=false;
        if(date1>date2)
        {
            startDate=new Date(date2);
            endDate=new Date(date1);
            inverse=true;
        }

        //Calculate the differences between the start and end dates
        var yearsDifference=endDate.getFullYear()-startDate.getFullYear();
        var monthsDifference=endDate.getMonth()-startDate.getMonth();
        var daysDifference=endDate.getDate()-startDate.getDate();


        var monthCorrection=0;
        //If roundUpFractionalMonths is true, check if an extra month needs to be added from rounding up.
        //The difference is done by ceiling (round up), e.g. 3 months and 1 day will be 4 months.
        if(roundUpFractionalMonths===true && daysDifference>=28)
        {
            monthCorrection=1;
        }
        //If the day difference between the 2 months is negative, the last month is not a whole month.
        else if(roundUpFractionalMonths!==true && daysDifference<0)
        {
//            monthCorrection=-1;
        }
        var output=(inverse?-1:1)*(yearsDifference*12+monthsDifference+monthCorrection);
        console.log(output);
        if(output=='NaN')
        return 0;
        else
        return output;
    }


</script>