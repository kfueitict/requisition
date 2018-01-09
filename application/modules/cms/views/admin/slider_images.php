<?php echo $this->load->view('include/header'); ?>
<div class="box span12">
    <div class="box-header" data-original-title>
        <h2><i class="halflings-icon user"></i><span class="break"></span>Slider Images</h2>
        <a href="<?php echo base_url('cms/admin/image_edit'); ?>" class="btn btn-primary" style="float: right; margin: -10px;">Add New</a>
    </div>
    <div class="box-content">
        <table class="table table-striped table-bordered bootstrap-datatable datatable">

            <thead>
                <tr>
                    <th>Images</th>
                    <th>Order</th>
                    <th>Active</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>   
            <?php if ($records) { ?>
                <tbody>
                    <?php
                    foreach ($records as $row) {
                        ?>
                        <tr>
                            <td><img src=" <?php echo base_url('uploads/slider/' . $row->img_src); ?>" height="100" width="100"></td>
                            <td><input type="number" min="1" name="order_<?php echo $row->id; ?>" id="order_<?php echo $row->id; ?>" onchange="ajaxCall(this);" value="<?php echo $row->order; ?>"></td>
                            <td><input type="checkbox" value="1" id="status_<?php echo $row->id; ?>" <?php if ($row->status) echo 'checked'; ?> onchange="ajaxCall(this);"></td>
                            <td><a href="<?php echo base_url() . 'cms/admin/image_edit/' . $row->id; ?>" class="btn btn-primary"><i class="icon-pencil icon-white"></i></a></td>
                            <td><a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete')" href="<?php echo base_url() . 'cms/admin/deleteslideimg/' . $row->id; ?>"><i class="icon-remove icon-white"></i></a></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <?php
            }else {
                echo 'No Record Found';
            }
            ?>
        </table>  
    </div>
</div><!--/span-->
<script>

    function ajaxCall(field)
    {
        var fid = field.id;
        var v = '';

        var f = fid.split('_');

        if (f[0] == "status")
        {
            if (field.checked)
                v = 1;
            else
                v = 0;
        } else
        {
            v = $('#' + field.id).val();
        }
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>cms/admin/change",
            cache: false,
            data: {value: v, id: f[1], field: f[0]},
            success: function (result) {
                console.log("success " + result);
            },
            error: function (request, error) {
                console.log("Error " + error);
            }
        });
    }



</script>
<?php echo $this->load->view('include/footer'); ?>