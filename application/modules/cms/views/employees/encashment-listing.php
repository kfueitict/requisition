<?php $this->load->view('include/header');?>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
        <h1>
            <i class="fa fa-cubes"></i>
            <?php echo @$title?>
            <small>

            </small>
        </h1>
    <div class="Button padt-10">
        <a href=" <?php echo base_url('cms/employees/leaves_encashment');?>" class="btn btn-success">New Request</a>
    </div>

</section>

<!-- Main content -->
<section class="content">
<?php if($this->session->flashdata('message')||$this->session->flashdata('message-error'))
{?>
    <div class="box-body">
        <?php if($this->session->flashdata('message'))
        {?>

            <div class="alert alert-info alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-info"></i> Alert!</h4>
                <?php echo $this->session->flashdata('message') ;?>
            </div>

        <?php }
        ?>
        <?php if($this->session->flashdata('message-error'))
        {?>

            <div class="alert alert-error alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                <?php echo $this->session->flashdata('message-error') ;?>
            </div>

        <?php }
        ?>
    </div>
<?php }
?>
<div class="row">
<div class="col-xs-12">

<div class="box">
<div class="box-body">
    <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped">
            <thead>
            <tr>
                <?php
                $rec=$employees[0];
                if(is_array($rec))
                    foreach(@$rec as $k=>$v)
                    {
                        //echo '<th>'.$k.'</th>';
                        if($k!='id')
                        {
                            echo '<td>'.$k.'</td>';
                        }
                    }
                ?>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php  if(is_array(@$employees)||is_object(@$employees))
                foreach($employees as $k=>$v)
                {?>
                    <tr>
                        <?php

                        foreach($v as $k1=>$v1)
                        {

                        if($k1!='id')
                        {
                            echo '<td>'.$v1.'</td>';
                        }else
                        {
                            ?>
                            <td>
                                <a
                                    onclick="return confirm('Are you sure?');"
                                    href="<?php echo base_url('cms/employees/leaves_encashment/delete/'.$v1)?>"
                                    class=" btn btn-danger" title="Delete this Record">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        <?php
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
    </div>

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
            "lengthChange": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            lengthMenu: [
                [ 10, 25, 50, -1 ],
                [ '10 rows', '25 rows', '50 rows', 'Show all' ]
            ],
            buttons: [
                 'excel'
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
