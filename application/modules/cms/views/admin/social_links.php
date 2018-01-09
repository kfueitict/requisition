<?php echo $this->load->view('admin/header'); ?>
<div class="box span12">
    <div class="box-header" data-original-title>
        <h2><i class="halflings-icon user"></i><span class="break"></span>Social Links</h2>
        <a href="<?php echo base_url('cms/admin/social_edit'); ?>" class="btn btn-primary" style="float: right; margin: -10px;">Add New</a>
    </div>
    <div class="box-content">
        <input type="hidden" id="tbl" value="social_links">
        <table class="table table-striped table-bordered bootstrap-datatable datatable">

            <thead>
                <tr>
                    <th>Images</th>
                    <th>Url</th>
                    <th>Order</th>
                    <th>Active</th>
                    <th>Show in Header</th>
                    <th>Show in Site</th>
                    <th>Show in Footer</th>
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
                            <td><img src=" <?php echo base_url('uploads/social/' . $row->img_src); ?>" height="32" width="32"></td>
                            <td><?php echo $row->url ?></td>
                            <td><input type="number" min="1" id="order-<?php echo $row->id; ?>" name="order_<?php echo $row->id; ?>" onchange="ajaxCall(this);" value="<?php echo $row->order; ?>"></td>
                            <td><input type="checkbox" value="1" id="status-<?php echo $row->id; ?>" <?php if ($row->status) echo 'checked'; ?> onchange="ajaxCall(this);"></td>
                            <td><input type="checkbox" value="1" id="show_in_header-<?php echo $row->id; ?>" <?php if ($row->show_in_header) echo 'checked'; ?> onchange="ajaxCall(this);"></td>
                            <td><input type="checkbox" value="1" id="show_in_site-<?php echo $row->id; ?>" <?php if ($row->show_in_site) echo 'checked'; ?> onchange="ajaxCall(this);"></td>
                            <td><input type="checkbox" value="1" id="show_in_footer-<?php echo $row->id; ?>" <?php if ($row->show_in_footer) echo 'checked'; ?> onchange="ajaxCall(this);"></td>
                            <td><a href="<?php echo base_url() . 'cms/admin/social_edit/' . $row->id; ?>" class="btn btn-primary"><i class="icon-pencil icon-white"></i></a></td>
                            <td><a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete')" href="<?php echo base_url() . 'cms/admin/deleteSocialLink/' . $row->id; ?>"><i class="icon-remove icon-white"></i></a></td>
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

        var f = fid.split('-');

        if (f[0] != "order")
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
            data: {value: v, id: f[1], field: f[0],tbl:$('#tbl').val()},
            success: function (result) {
                console.log("success " + result);
            },
            error: function (request, error) {
                console.log("Error " + error);
            }
        });
    }



</script>
<?php echo $this->load->view('admin/footer'); ?>