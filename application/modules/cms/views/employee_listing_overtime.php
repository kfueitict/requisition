<?php $this->load->view('include/header');?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
        <h1>
            <i class="fa fa-cubes"></i>
            Employees Overtime
        </h1>

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
<div class="row">
<div class="col-xs-12">

<div class="box">
<div class="box-body">
    <div class="box box-info">
        <div class="box-header with-border">
            <i class="fa fa-filter"></i>
            <h3 class="box-title">Filter</h3>
        </div>

        <form class="form-horizontal">
            <input type="hidden" name="emp" value="<?php echo @$_GET['emp'] ?>">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-6">
                        <label class="control-label"  for="date">From Date</label>
                        <label class="label">From Date</label>
                        <input type="text" class="form-control datepicker" value="<?php echo @$_GET['from_date'] ?>" name="from_date">
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label">TO  Date</label>
                        <input type="text" class="form-control datepicker" value="<?php echo @$_GET['to_date'] ?>" name="to_date">
                    </div>
                    <div class="col-sm-6">
                        <label class="control-label"  for="dpt">Department</label>
                        <select class="form-control" id="dpt" name="dpt">
                            <option value="">Select Department</option>
                            <?php
                            if(is_array(@$department)||is_object(@$department))
                                foreach(@$department as $type)
                                {
                                    $select='';
                                    if(@$_GET['dpt']==$type->id)
                                        $select='selected';
                                    echo '<option '.$select.' value="'.$type->id.'"  >'.$type->title.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="box-footer">
                    <?php if(!empty($_GET['emp']))
                    {
                        ?>
                        <div class="pull-left">
                            <a target="_blank" class="btn btn-success" href="<?php echo base_url('cms/overtime/downloadpdf').'?'. $_SERVER['QUERY_STRING'].'&download=pdf'; ?>"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
                        </div>
                    <?php
                    } else?>
                    <?php
                    {
                        ?>
                        <div class="pull-left">
                            <a target="_blank" class="btn btn-success" href="<?php echo base_url('cms/overtime/employees').'?'. $_SERVER['QUERY_STRING'].'&download=pdf'; ?>"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
                        </div>
                    <?php
                    }?>

                    <div class="pull-right">
                        <button type="reset" class="btn btn-default">Reset</button>
                        <button type="submit" class="btn btn-success">Apply Filter</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
<table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
    <th>Name</th>
    <th>Department</th>
    <th>Designation</th>
    <th>Overtime Device</th>
    <th>Overtime Modify</th>
    <th>Overtime Total</th>
    <th>Action</th>
</tr>
</thead>
    <tbody>
    <?php if(is_array(@$employees)||is_object(@$employees))
    foreach($employees as $type)
    {?>
        <tr>
            <td><?php echo $type->name ?></td>
            <td><?php echo @$type->department ?></td>
            <td><?php echo @$type->designation ?></td>
            <td><?php echo $type->otd ?></td>
            <td><?php echo $type->otm ?></td>
            <td><?php echo $type->otc ?></td>
            <td>
                <a href="<?php echo base_url('cms/overtime/employees/'.@$type->slug)  ?>"
                   class=" btn btn-info btn-sm" title="Add Time"><i class="fa fa-pencil"></i></a>
                <a target="_blank" href="<?php echo base_url('cms/overtime?emp='.@$type->bm_id.'&from_date='.@$_GET['from_date'].'&to_date='.@$_GET['to_date'])  ?>"
                   class=" btn btn-info btn-sm" title="download overtime report"><i class="fa fa-download"></i></a>
            </td>

        </tr>
    <?php }
    ?>

    </tbody>

</table>
</div><!-- /.box-body -->
</div><!-- /.box -->
</div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->




<?php $this->load->view('include/footer'); ?>
<script>
    $(document).on('change','.emp', function () {
        $(this).addClass('bg-warning');
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('cms/employees/update') ?>",
            data: { slug: this.id, value: this.value }
        })
            .done(function( msg ) {
                $('#'+msg).removeClass('bg-warning');
            });
    });
    $(function () {
        $("#example1").DataTable({
            "paging": true,
            dom: 'Bfrtip',
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            ],
            buttons: [
                'excel', 'pageLength'
            ]
        });
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
</script>
