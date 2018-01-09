<?php $this->load->view('include/header');?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
        <h1>
            <i class="fa fa-cubes"></i>
            Leaves
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
        <input type="hidden" name="update_id" value="<?php echo @$leave_edit->id?>" >
        <div class="box-body panel panel-default">
            <div class="row">
                <div class="col-md-6">

                    <label for="title">Title</label>
                    <input type="text" required="" class="form-control" name="title" id="title" value="<?php echo @$leave_edit->title?>">

                </div>
                <div class="col-md-6">
                    <label class="control-label" for="status_req_ini">Show in Request Initiation</label>
                    <select class="form-control" id="status_req_ini" required=""
                            name="status_req_ini">
                        <?php
                        $st=array(
                            '0'=>'No',
                            '1'=>'Yes'
                        );
                        if(is_array(@$st)||is_object(@$st))
                            foreach(@$st as $k=>$v)
                            {
                                $select='';
                                if(@$leave_edit->status_req_ini==$k)
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

                <div class="col-sm-12">
                    <button type="submit" class="btn btn-success pull-right"><?php echo $button?></button>
                </div>
            </div>
        </div>
    </form>

    <table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
    <th>Title</th>
    <th>Show in Request Initiation</th>
    <th>Display Order</th>
    <th>Action</th>
</tr>
</thead>
    <tbody>
    <?php if(is_array(@$leaves)||is_object(@$leaves))
    foreach($leaves as $type)
    {?>
        <tr>
            <td><?php echo $type->title ?></td>
            <td><?php echo $st[$type->status_req_ini] ?></td>
            <td><label class="hidden"><?php echo $type->display_order ?></label> <input type="number" class="display-order" id="<?php echo $type->slug ?>" value="<?php echo $type->display_order ?>"></td>
            <td>
                <a href="<?php echo base_url('cms/leaves?mod=edit&id='.$type->slug)  ?>"
                   class=" btn btn-info btn-sm" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                <a
                    onclick="return confirm('Are you sure want to delete?')"
                    href="<?php echo base_url('cms/leaves?mod=delete&id=' . $type->slug); ?>"
                    class=" btn btn-danger btn-sm" title="Delete"><i class="fa fa-trash"></i></a>
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
    $(function () {
        $("#example1").DataTable();
    });
    $(document).on('change','.display-order', function () {
        $(this).addClass('bg-warning');
        $.ajax({
                method: "POST",
                url: "<?php echo base_url('cms/leaves') ?>",
                data: { slug: this.id, value: this.value,type:'ajax' }
            })
            .done(function( msg ) {
                $('#'+msg).removeClass('bg-warning');
            });
    });
</script>
