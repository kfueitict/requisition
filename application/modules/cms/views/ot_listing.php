<?php $this->load->view('include/header');

?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
        <h1>
            <i class="fa fa-cubes"></i>
            Overtime
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
            <?php
            if(is_array(@$department)||is_object(@$department)){ ?>
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
            <?php } ?>
        </div>

        <div class="box-footer">
            <?php if(!empty($_GET['emp']))
            {
                ?>
                <div class="pull-left">
                    <a target="_blank" class="btn btn-success" href="<?php echo base_url('cms/overtime/downloadpdf').'?'. $_SERVER['QUERY_STRING'].'&download=pdf'; ?>"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
                </div>
            <?php
            } else
            {
                ?>
                <div class="pull-left">
                    <a target="_blank" class="btn btn-success" href="<?php echo base_url('cms/overtime/downloadpdf').'?'. $_SERVER['QUERY_STRING'].'&download=pdf'; ?>"><i class="fa fa-file-pdf-o"></i> Download PDF</a>
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
    <?php
    $rec=$overtime[0];
    if(is_array($rec))
        foreach(@$rec as $k=>$v)
        {
            echo '<th>'.$k.'</th>';
        }
    ?>
</tr>
</thead>
    <tbody>
    <?php if(is_array(@$overtime)||is_object(@$overtime))
        
        foreach($overtime as $k=>$v)
        {
            $s="";
            $day= getWorkingDays(date('Y-m-d',strtotime($v["Date"])),date('Y-m-d',strtotime($v["Date"])),@$holidays);
            if($day==0){
                $s='style="background-color: rgb(167,256,170);"';
            } else if($v["OverTIME"]<0){
                $s='style="background-color: rgb(251,256,152);"';
            }

            ?>
            <tr <?php echo @$s ?>>
                <?php
                foreach($v as $k1=>$v1)
                {
                    if($k1=='STATUS')
                    {
                        if($v1==1)
                        echo '<td><input id="'.$v["Date"].'_'.$v["ID"].'" class="ot-status" type="checkbox" checked></td>';
                        else
                        {
                            echo '<td><input id="'.$v["Date"].'_'.$v["ID"].'" class="ot-status" type="checkbox"></td>';
                        }
                    }else
                    {
                        echo '<td>'.$v1.'</td>';
                    }

                }

                ?>
            </tr>
        <?php }
    ?>
    </tbody>
<tfoot>
</tfoot>
</table>
</div><!-- /.box-body -->
</div><!-- /.box -->
</div><!-- /.col -->
</div><!-- /.row -->
</section><!-- /.content -->
</div><!-- /.content-wrapper -->




<?php $this->load->view('include/footer'); ?>
<script>
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
    });
    $('.datepicker').datepicker({
        format:'yyyy-mm-dd'
    });


    $(document).on('change','.ot-status', function () {
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('cms/overtime/update_status') ?>",
            data: { slug: this.id, value: ~~$(this).is(':checked') }
        });
    });
</script>
