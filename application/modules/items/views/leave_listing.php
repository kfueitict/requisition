<?php
$this->load->view('include/header');
?>

<div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo @$title ?>
          </h1>

          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Requisition Listing</li>
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
        <?php if($this->session->flashdata('message-error'))
        {?>
            <div class="box-body">
                <div class="alert alert-error alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                    <?php echo $this->session->flashdata('message-error') ;?>
                </div>
            </div>
        <?php }
        ?>

        <section>
            <div class="box">
            <div class="box-body">
                <div class="table-responsive">
                <table id="leaves" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Request Date</th>
                        <th>Name</th>
<!--                        <th>Days</th>-->
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array(@$leaves)||is_object(@$leaves))
                        foreach($leaves as $lv)
                        {?>
                            <tr>
                                <td><?php echo $lv->request_date ?></td>
                                <td><?php echo $lv->emp_no ?>-<?php echo $lv->name ?></td>
<!--                                <td>--><?php //echo getWorkingDays($lv->from_date,$lv->to_date,array(),false) ?><!--</td>-->
                                <td>
                                    <a href="<?php echo base_url('items/request/ru/step/'.$lv->id.'?emp='.$lv->slug) ?>"
                                       class=" btn btn-info btn-sm" title="View"><i class="fa fa-eye"></i></a>
<!--                                    <a-->
<!--                                        href="--><?php //echo base_url('items/request/ru/step/'.$lv->id.'?emp='.$lv->slug.'&download=pdf') ?><!--"-->
<!--                                       class=" btn btn-info btn-sm" title="Print / Do   wnload"><i class="fa fa-download"></i></a>-->
                                    <?php
                                    if(false && !$lv->locked){
                                        ?>
                                        <a href="<?php echo base_url('items/request/ru/edit/'.$lv->id) ?>"
                                           class=" btn btn-info btn-sm" title="Edit"><i class="fa fa-pencil"></i></a>
                                    <?php }
                                    ?>
                                </td>

                            </tr>
                        <?php }
                    ?>

                    </tbody>

                </table>

            </div>
            </div>
            </div>

        </section>

<!--        --><?php
//        echo @$previous_el_balance[$emp->slug]."<br>";
//        echo @$leaves["cl_balance"][$emp->slug]."<br>";
//        echo @$leaves["el_balance"][$emp->slug]."<br>";
//        echo @$leaves["el_leaves"][$emp->slug]."<br>";
//        echo @$leaves["employees"][0]["CL"]."<br>";
//        echo @$leaves["employees"][0]["EL"]."<br>";
//        echo @$leaves["employees"][0]["short Leave"]."<br>";
//
//        ?>


    </section><!-- /.content -->

      </div><!-- /.content-wrapper -->
      <?php $this->load->view('include/footer'); ?>
<script>
    $("#leaves").DataTable();
</script>
