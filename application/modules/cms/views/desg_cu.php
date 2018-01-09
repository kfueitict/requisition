<?php $this->load->view('include/header');
$genders=array(
    0=>"Male & Female",
    1=>"Male",
    2=>"Female",
);
?>
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
            <li><a href="<?php echo base_url('cms/designations') ?>"><i class="fa fa-cubes"></i>Designations</a></li>
            <li class="active"><?php echo @$title ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box box-info">
            <div class="box-header with-border">
                <i class="fa fa-cube"></i>
                <h3 class="box-title"></h3>
                <button type="button" onclick="window.location.href='<?php echo base_url('cms/designations')?>'" class="btn btn-info pull-right">Back</button>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form id="form1" class="form-horizontal" action="" method="post">
                <input type="hidden" name="update_id" id="update_id" value="<?php echo @$type->id ?>">
                <input type="hidden" id="tbl" value="designations">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="title">Title</label>
                        <div class="col-sm-6">
                            <input required="" type="text"
                                   class="form-control validate[ajax[ajaxUnique]]"
                                   value="<?php echo @$type->title ?>"
                                   id="title"
                                   name="title"
                                   placeholder="Title">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="bps">BPS</label>
                        <div class="col-sm-6">
                            <input required="" type="text"
                                   class="form-control"
                                   value="<?php echo @$type->bps ?>"
                                   id="bps"
                                   name="bps"
                                   placeholder="BPS">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label"  for="description">Description</label>
                        <div class="col-sm-6">
                            <textarea class="form-control" id="description"
                                      name="description"
                                      placeholder="Description"><?php echo @$type->description ?></textarea>


                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">

                            <label class="control-label "  for="police_case">Additional BPS</label>
                            <div class="border">
                                <button class="pull-right btn grbg btn-success whc" type="button" id="add-bps">Add Additional BPS</button>
                                <div id="service-tbl">
                                    <table id="tbl-services" class="table table-bordered">
                                        <tbody id="l-body">
                                        <tr>
                                            <th >Sr.</th>
                                            <th >Heading</th>
                                            <th >Genders</th>
                                            <th >BPS</th>
                                            <th>Action</th>
                                        </tr>
                                            <tr>
                                                <td></td>
                                                <td><input name="heading[]" class="form-control"  type="text" value=""></td>
                                                <td><select class="form-control" name="genders[]">
                                                        <?php

                                                        if(is_array(@$genders)||is_object(@$genders))
                                                            foreach($genders as $k=>$v)
                                                            {
                                                                echo '<option value="'.$k.'">'.$v.'</option>';
                                                            }
                                                        ?>
                                                    </select></td>

                                                <td ><input name="ad_bps[]" class="form-control"  type="number"></td>
                                                <td class="txt-c"><a class="btn redbg whc" onclick=" $(this).parents('tr').remove();" ><i class="fa fa-close whc"></i></a></td>


                                            </tr>

                                        </tbody>
                                    </table>
                                </div>


                            </div>

                        </div>
                    </div>



                </div><!-- /.box-body -->
                <div class="box-footer">
                    <div class="pull-right">
                    <button type="reset" class="btn btn-default">Reset</button>
                    <button type="submit" class="btn btn-success"><?php echo @$button; ?></button>
                        </div>
                </div><!-- /.box-footer -->
                <div class="box-body">
                    <?php if(is_array(@$additional_bps)||is_object(@$additional_bps))
                    {?>
                        <div class="row">
                            <div class="col-sm-12">

                                <label class="control-label "  for="police_case">Additional BPS</label>
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Heading</th>
                                        <th>Genders</th>
                                        <th>BPS</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array(@$additional_bps)||is_object(@$additional_bps))
                                        foreach($additional_bps as $type)
                                        {?>
                                            <tr>
                                                <td><?php echo $type->title ?></td>
                                                <td><?php echo $genders[$type->genders] ?></td>
                                                <td><?php echo $type->bps ?></td>
                                                <td>
                                                    <a href="<?php echo base_url('cms/designations/bps?bps='.@$type->slug.'&key='.$type->id)  ?>"
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

</script>
<script>
    $(document).ready(function(){


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



        $('#add-bps').on('click',function (evt) {
            $('#l-body').append('<tr>'+
            '<td></td>'+
            '<td><input name="heading[]"  type="text" class="form-control"></td>'+
            '<td><select class="form-control" name="genders[]"><?php
                                                if(is_array(@$genders)||is_object(@$genders))
                                                    foreach($genders as $k=>$v)
                                                    {
                                                        echo '<option value="'.$k.'">'.$v.'</option>';
                                                    }
                                                ?></select></td>'+
            '<td><input name="ad_bps[]" class="form-control"  type="number"></td>'+
            '<td class="txt-c"><a class="btn redbg whc" onclick=" $(this).parents('+'\'tr\''+').remove();" ><i class="fa fa-close whc"></i></a></td>' +
            '</tr>');
            $('.datepicker').datepicker({
                format:'yyyy/mm/dd'
            });

        });
    });
</script>