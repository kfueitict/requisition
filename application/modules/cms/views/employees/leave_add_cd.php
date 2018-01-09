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
                <button type="button" onclick="window.location.href='<?php echo @$_SERVER['HTTP_REFERER']?>'" class="btn btn-info pull-right">Back</button>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form id="form1" class="form-horizontal" action="" method="post">
                <input type="hidden" name="id"  value="<?php echo $row->id ?>">
                <input type="hidden" name="method"  value="<?php echo @$_GET['mode'] ?>">
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
                            <label class="col-sm-3 control-label"  for="doa">Working Day</label>
                            <div class="col-sm-6">
                                <input required="" type="text" name="working_day" id="working_day"
                                       class="form-control">
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

                            <label class="control-label "  for="police_case">Work Days</label>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array(@$leaves_emp)||is_object(@$leaves_emp))
                                    foreach($leaves_emp as $type)
                                    {?>
                                        <tr>
                                            <td><?php echo $type->date ?></td>

                                            <td>
                                                <a href="<?php echo base_url('cms/employees/leaves?method=day&emp='.@$slug.'&key='.$type->id)  ?>"
                                                   class=" btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></a>
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


    var availableDates = ["9-5-2011","14-5-2011","15-5-2011"];

    function available(dt) {
        return [dt.getDay() == 0 || dt.getDay() == 6, ""];

    }

    $('#working_day').datepicker({ beforeShowDay: available });

</script>