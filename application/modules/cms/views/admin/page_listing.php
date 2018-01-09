<?php echo $this->load->view('admin/header'); ?>
<div class="box span12">
    <div class="box-header" data-original-title>
        <h2><i class="halflings-icon user"></i><span class="break"></span>CMS Pages</h2>
    </div>
    <div class="box-content">
        <table class="table table-striped table-bordered bootstrap-datatable datatable">

            <thead>
                <tr>
                    <th>Heading</th>
                    <th>Slug</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead> 
            <?php
            if ($record) {
                ?>
                <tbody>
                    <?php foreach ($record as $row) { ?> 
                        <tr>
                            <td style="width: 130px;"><?php echo $row->heading ?></td> 
                            <td style="width: 130px;"><?php echo $row->slug ?></td>
                            <td>
                                <?php
                                $string = strip_tags($row->desc);
                                if (strlen($string) > 400) {
                                    $pos = strpos($row->desc, ' ', 400);
                                    $string = strip_tags(substr($row->desc, 0, $pos)) . '...';
                                }
                                echo $string;
                                ?>
                            </td>
                            <td class="center">
                                <?php
                                if ($row->status == 1) {
                                    echo '<span class="label label-success">Active</span>';
                                } else {
                                    echo '<span class="label label-danger">Block</span>';
                                }
                                ?>
                            </td>
                            <td class="center" style="width: 130px;"> 
                                <a class="btn btn-info" href="<?php echo base_url('cms/admin/editpage/' . $row->cms_id); ?>">
                                    <i class="halflings-icon white edit"></i>                                            
                                </a>
                                <a class="btn btn-danger" onclick="return confirm('Are you sure you want to delete')" href="<?php echo base_url('cms/admin/delete/' . $row->cms_id); ?>">
                                    <i class="halflings-icon white trash"></i> 

                                </a>
                            </td>
                        </tr>
                    <?php } ?> 
                </tbody>
                <?php
            }
            ?>
        </table>            
    </div>
</div><!--/span-->
<?php echo $this->load->view('admin/footer'); ?>