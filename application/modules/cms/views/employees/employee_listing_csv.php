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
<table id="example1" class="table table-bordered table-striped">
<thead>
<tr>
    <?php
    $rec=$employees[0];
    if(is_array($rec))
    foreach(@$rec as $k=>$v)
    {
        echo '<th>'.$k.'</th>';
    }
    ?>
</tr>
</thead>
    <tbody>
    <?php if(is_array(@$employees)||is_object(@$employees))
    foreach($employees as $k=>$v)
    {?>
        <tr>
            <?php
            foreach($v as $k1=>$v1)
            {
                echo '<td>'.$v1.'</td>';
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
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            buttons: [
                'excel'
            ]
        });

    });
    $(document).ready(
        function(){
            $('.buttons-excel').trigger('click');
            setTimeout(window.close, 10);
        });
</script>
