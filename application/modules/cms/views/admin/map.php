<?php echo $this->load->view('admin/header'); ?>  

<div class="box span12">
    <div class="box-header" data-original-title> 
        <h2><i class="halflings-icon edit"></i><span class="break"></span> <?php echo $title ?></h2>
        <div class="box-icon">
            <a href="#" onclick="history.back();" class="btn btn-primary" style="margin: -11px 10px 0px;">Back</a>
        </div>
    </div>
    <?php if ($this->session->flashdata('message')) { ?>
        <div class="alert alert-success" style="text-align: center;">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <?php echo $this->session->flashdata('message'); ?>
        </div>
    <?php } ?>
    <div class="box-content">
        <?php
        $array = (array) @$page;
        for($i=1;$i<=1;$i++)  { ?>
            <form id="form_<?php echo $i; ?>" action="<?php echo base_url('cms/admin/map'); ?>" class="form-horizontal" method="post" style="border: 1px; border-style: dashed; padding: 1%;">

                <legend>Map <?php echo $i; ?></legend>
                <div id="msg_<?php echo $i; ?>">

                </div>
                <fieldset>
                    <div class="control-group">
                        <label class="control-label" for="typeahead"> Map Title </label>

                        <div class="controls">
                            <input type="text" class="span6" value="<?php echo $array['map_title_'.$i] ?>" name="map_title_<?php echo $i; ?>"/>
                        </div>
                    </div>
                </fieldset>
                <fieldset>
                    <div class="control-group">
                        <label class="control-label"> Map Url</label>

                        <div class="controls">
                            <input type="url" class="span6" style="width: 100%" onchange="updateSrc(<?php echo $i ?>)" value="<?php echo $array['map_url_'.$i] ?>" name="map_url_<?php echo $i; ?>"/>
                            <input type="hidden" name="map_title" value="map_title_<?php echo $i; ?>"/>
                            <input type="hidden" name="map_url" value="map_url_<?php echo $i; ?>"/>
                        </div>

                    </div>
                </fieldset>

                <fieldset>
                    <iframe src="<?php echo $array['map_url_'.$i] ?>" id="frame_<?php echo $i; ?>" frameborder="0" style="border:0;margin: 0.9% 0 0 !important; width:100% !important; height:200px !important;" allowfullscreen></iframe>
                </fieldset>

                <fieldset>
                    <div class="controls">
                        <button type="button" onclick="subMit(<?php echo $i; ?>)" class="btn btn-primary" name="update">Save</button>
                    </div>
                </fieldset>
            </form>
        <?php } ?>





    </div>
</div>
<script>
    function updateSrc(id)
    {

        document.getElementById('frame_'+id).src = document.getElementsByName('map_url_'+id)[0].value;
    }


    function subMit(id)
    {
        $.ajax({
            url: $('#form_'+id).attr('action'),
            type: "post",
            data : $('#form_'+id).serialize(),
            success: function(response){
                $('#msg_'+id).html('<div class="alert alert-success" style="text-align: center;"><button data-dismiss="alert" class="close" type="button">×</button>'+response+'</div>');
            }
        });
    }

</script>

<?php echo $this->load->view('admin/footer'); ?>