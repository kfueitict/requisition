<?php $this->load->view('include/header');?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
        <h1>
            <i class="fa fa-cubes"></i>
            <?php echo @$title ?>
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
    <form class="form-horizontal" method="post" action="">
        <input type="hidden" name="update_id" value="<?php echo @$_edit->id?>" >
        <div class="box-body panel panel-default">
            <div class="row">

                <div class="col-sm-6">

                    <label for="title">Title</label>
                    <input type="text" required="" class="form-control" name="title" id="title" value="<?php echo @$_edit->title?>">

                </div>
                <div class="col-sm-6">
                    <label class="control-label"  for="iso">ISO</label>
                    <input type="text"  class="form-control" required=""
                           value="<?php echo @$_edit->iso ?>"
                           id="iso"
                           name="iso"
                           placeholder="ISO">
                </div>
                <div class="col-sm-6">
                    <label class="control-label"  for="iso3">ISO3</label>
                    <input type="text"  class="form-control"
                           value="<?php echo @$_edit->iso3 ?>"
                           id="iso3"
                           name="iso3"
                           placeholder="ISO 3">
                </div>
                <div class="col-sm-6">
                    <label class="control-label" for="status">Status</label>
                    <select class="form-control" id="status" required=""
                            name="status">
                        <option value="">Status</option>
                        <?php
                        $st=array(
                            '0'=>'Blocked',
                            '1'=>'Active'
                        );
                        if(is_array(@$st)||is_object(@$st))
                            foreach(@$st as $k=>$v)
                            {
                                $select='';
                                if(@$_edit->status==$k)
                                    $select='selected';
                                echo '<option '.$select.' value="'.$k.'"  >'.$v.'</option>';
                            }
                        ?>
                    </select>
                </div>



            </div>
            <div class="row">

            </div>
            <div class="box-footer">

                <button type="submit" class="btn btn-success pull-right"><?php echo $button?></button>
            </div>
        </div>
    </form>

    <table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
    <th>Title</th>
    <th>ISO</th>
    <th>ISO3</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>
    <tbody>
    <?php
    $status=array(
        0=>"<label class='label label-warning'>Blocked</label>",
        1=>"<label class='label label-success'>Active</label>",
    );
    if(is_array(@$countries)||is_object(@$countries))
    foreach($countries as $type)
    {?>
        <tr>
            <td><?php echo $type->title ?></td>
            <td><?php echo $type->iso ?></td>
            <td><?php echo $type->iso3 ?></td>
            <td><?php echo $status[$type->status] ?></td>
            <td>
                <a href="<?php echo base_url('cms/countries?mod=edit&id='.$type->id)  ?>"
                   class=" btn btn-info btn-sm" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                <a
                    onclick="return confirm('Are you sure want to delete?')"
                    href="<?php echo base_url('cms/countries?mod=delete&id=' . $type->id); ?>"
                    class=" btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></a>
            </td>

        </tr>
    <?php }
    ?>

    </tbody>
<tfoot>
<tr>
    <th>Title</th>
    <th>Action</th>
</tr>
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
        $("#example1").DataTable();
    });
</script>
