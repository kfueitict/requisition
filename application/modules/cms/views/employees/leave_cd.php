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
            <li><a href="<?php echo base_url('cms/overtime/employees/leaves') ?>"><i class="fa fa-cubes"></i>Leaves</a></li>
            <li class="active"><?php echo @$title ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
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
        <div class="box box-info">
            <div class="box-header with-border">
                <i class="fa fa-cube"></i>
                <h3 class="box-title">
                    Workings days for the period of <strong><?php echo mdate('%d %F, %Y',strtotime($dates->from_date)) ?> </strong>  to <strong><?php echo mdate('%d %F, %Y',strtotime($dates->to_date)) ?></strong>
                </h3>
                <button type="button" onclick="window.location.href='<?php echo @$_SERVER['HTTP_REFERER']?>'" class="btn btn-info pull-right">Back</button>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form id="form1" class="form-horizontal" action="" method="post">
                <input type="hidden" name="id"  value="<?php echo $row->id ?>">
                <div class="box-body">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-3 control-label"  for="emp_name">Employee Name</label>
                            <div class="col-sm-6">
                                <input required="" type="text" disabled
                                       class="form-control date"
                                       value="<?php echo @$row->name ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"  for="doa">Date of Joining</label>
                            <div class="col-sm-6">
                                <input required="" type="text" disabled
                                       class="form-control date"
                                       value="<?php echo @$row->doa ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"  for="workingDays">Working Days</label>
                            <div class="col-sm-6">
                                <input type="text" disabled
                                       class="form-control date"
                                       value="<?php echo @$workingDays ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label"  for="emp_days">Employee's Working Days</label>
                            <div class="col-sm-6">
                                <input required="" type="text"
                                       class="form-control date"
                                       value="<?php echo @$payrow->work_days ?>"
                                       id="emp_days"
                                       name="emp_days">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">

                            <label class="control-label "  for="police_case">Leave Details</label>
                            <div class="border">
                                <button class="pull-right btn grbg btn-success whc" type="button" id="add-leave">Add Leaves</button>
                                <div id="service-tbl">
                                    <table id="tbl-services" class="table table-bordered">
                                        <tbody id="l-body">
                                        <tr>
                                            <th >Sr.</th>
                                            <th width="20%">From Date</th>
                                            <th width="20%">To Date</th>
                                            <th width="20%">Leave Type</th>
                                            <th width="15%">Paid Status</th>
                                            <th width="15%">Leaves</th>
                                            <th>Action</th>
                                        </tr>
                                        <?php
                                        if(isset($details_c)) {
                                            if (is_array(@$details_c) || is_object(@$details_c))
                                                foreach ($details_c as $detail) {
                                                    echo '<tr>
<td></td>
<td><input name="from_date[]" class="form-control date"  type="text" value="' . @$detail->duration . '"></td>
<td><input name="to_date[]" class="form-control date"  type="text" value="' . @$detail->exp_date . '"></td>
<td><input name="leave_type[]" class="form-control"  type="text" value="' . @$detail->exp_date . '"></td>
<td><input name="paid_status[]" class="form-control"  type="text" value="' . @$detail->exp_date . '"></td>
<td><input name="leaves[]" class="form-control"  type="text" value="' . @$detail->reference . '"></td>
<td class="txt-c"><a class="btn redbg whc" onclick="' . " $(this).parents('tr').remove();" . '" ><i class="fa fa-close whc"></i></a></td>
</tr>';
                                                }
                                        }else
                                        {

                                            ?>
                                            <tr>
                                                <td></td>
                                                <td><input name="from_date[]" class="form-control datepicker"  type="text" value=""></td>
                                                <td><input name="to_date[]" class="form-control datepicker"  type="text" value=""></td>
                                                <td><select class="form-control leave_type" name="leave_type[]">
                                                        <?php
                                                        if(is_array(@$leave_types)||is_object(@$leave_types))
                                                            foreach($leave_types as $type)
                                                            {
                                                                echo '<option value="'.$type->id.'">'.$type->title.'</option>';
                                                            }
                                                        ?>
                                                    </select></td>
                                                <td><select class="form-control" name="paid_status[]">
                                                        <option value="paid">Paid</option>
                                                        <option value="unpaid">Un Paid</option>
                                                </select></td>
                                                <td ><input readonly name="days[]" class="form-control days"  type="text"></td>
                                                <td class="txt-c"><a class="btn redbg whc" onclick=" $(this).parents('tr').remove();" ><i class="fa fa-close whc"></i></a></td>


                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>


                            </div>

                        </div>
                    </div>






                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                    <button type="submit" class="btn btn-success">Save</button>
                        </div>
                </div><!-- /.box-footer -->
                <div class="box-body">
                <?php if(is_array(@$leaves_emp)||is_object(@$leaves_emp))
                {?>
                    <div class="row">
                        <div class="col-sm-12">

                            <label class="control-label "  for="police_case">Leave History</label>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>From Date</th>
                                    <th>To Date</th>
                                    <th>Leave Type</th>
                                    <th>Leave Paid Status</th>
                                    <th>Days</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array(@$leaves_emp)||is_object(@$leaves_emp))
                                    foreach($leaves_emp as $type)
                                    {?>
                                        <tr>
                                            <td><?php echo $type->from_date ?></td>
                                            <td><?php echo $type->to_date ?></td>
                                            <td><?php echo $type->title ?></td>
                                            <td><?php echo $type->paid_status ?></td>
                                            <td><?php
                                                $date_from= date('Y-m-d',strtotime($type->from_date));
                                                // sandwich rule de-active date
                                                $rule_date="2017-03-22";
                                                $date_compare= date('Y-m-d',strtotime($rule_date));
                                                if($date_from>$date_compare)
                                                {
                                                    echo getWorkingDays($type->from_date,$type->to_date,@$holidays);
                                                }else
                                                {
                                                    echo getWorkingDays($type->from_date,$type->to_date,array(),false);
                                                }


                                                ?></td>

                                            <td>
                                                <?php

                                                if($type->username!=="system")
                                                {
                                                    ?>
                                                    <a href="<?php echo base_url('cms/employees/leaves?emp='.@$slug.'&key='.$type->id)  ?>"
                                                       class=" btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></a>
                                                    <?php
                                                }
                                                
                                                ?>

                                            </td>

                                        </tr>
                                    <?php }
                                ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php }?>
                    </div>
            </form>


        </div><!-- /.box -->


    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php $this->load->view('include/footer'); ?>
<script>
    $(document).on('ready',function(){

    });
    $(document).on('change','#emp_days', function () {
        $(this).addClass('bg-warning');
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('cms/employees/leaves') ?>",
            data: {method:'days', id: <?php echo $row->id ?>, value: this.value }
        })
            .done(function( msg ) {
                $('#emp_days').removeClass('bg-warning');
            });
    });
    $('.datepicker').datepicker({
        format:'yyyy/mm/dd'
    });

    $(document).on('change','.leave_type', function () {
        if($(this).find("option:selected").text()=="Other")
        {
            $(this).after('<input class="form-control" name="other_leave_type_'+this.parentNode.parentNode.rowIndex+'">');
        }else
        {
            $(this).next().remove();
        }
        $('.datepicker').trigger('change');
    });

    $(document).on('change','.datepicker', function () {
        var row = $(this).closest("tr");    // Find the row
        var from_date,to_date;
        var leave_type;
        $(this).closest('tr').find("input").each(function() {
            if(this.name == 'from_date[]')
                from_date=this.value;
            if(this.name == 'to_date[]')
                to_date=this.value;
        });
        $(this).closest('tr').find("select").each(function() {
            if(this.name == 'leave_type[]')
                leave_type=$('option:selected', $(this)).text();
        });
        var days=dateDiffInDays(from_date,to_date);
        if(leave_type=='CL')
        {
            if(days>4)
            {
                alert('Maximum 4 CL leaves allowed');
                $(this).closest("tr").find("input.days").val('');
                return;
            }

        }
        $(this).closest("tr").find("input.days").val(days);
    } );

    $('#add-leave').on('click',function (evt) {
        $('#l-body').append('<tr>'+
        '<td></td>'+
        '<td><input name="from_date[]"  type="text" class="form-control datepicker"></td>'+
        '<td><input name="to_date[]"  type="text" class="form-control datepicker"></td>'+
        '<td><select class="form-control leave_type" name="leave_type[]"><?php
                                                if(is_array(@$leave_types)||is_object(@$leave_types))
                                                    foreach($leave_types as $types)
                                                    {
                                                        echo '<option value="'.$types->id.'">'.$types->title.'</option>';
                                                    }
                                                ?></select></td>'+
        '<td>' +
        '<select class="form-control" name="paid_status[]">' +
        '<option value="paid">Paid</option>' +
        '<option value="unpaid">Un Paid</option>' +
        '<td><input name="days[]" readonly class="form-control days"  type="text"></td>'+
        '<td class="txt-c"><a class="btn redbg whc" onclick=" $(this).parents('+'\'tr\''+').remove();" ><i class="fa fa-close whc"></i></a></td>' +
        '</tr>');
        $('.datepicker').datepicker({
            format:'yyyy/mm/dd'
        });

    });



    var _MS_PER_DAY = 1000 * 60 * 60 * 24;

    // a and b are javascript Date objects
    function dateDiffInDays(a, b) {
        a= new Date(a);
        b= new Date(b);
        // Discard the time and time-zone information.
        var utc1 = Date.UTC(a.getFullYear(), a.getMonth(), a.getDate());
        var utc2 = Date.UTC(b.getFullYear(), b.getMonth(), b.getDate());
        var days=Math.floor((utc2 - utc1) / _MS_PER_DAY);
        if(days>-1)
        days++;
        else
        days=0;
        return days;
    }
</script>