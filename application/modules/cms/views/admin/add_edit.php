<?php echo $this->load->view('admin/header'); ?>
<style>
    #imagePreview {
        width: 180px;
        height: 180px;
        background-position: center center;
        background-size: cover;
        -webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);
        display: inline-block;
    }
</style>
<div class="box span12">
    <div class="box-header" data-original-title>
        <h2><i class="halflings-icon edit"></i><span class="break"></span> <?php echo $title ?></h2>
        <div class="box-icon">
            <a href="#" onclick="history.back();" class="btn btn-primary" style="margin: -11px 10px 0px;">Back</a>
        </div>
    </div>
    <div class="box-content">
        <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <fieldset>
                <div class="control-group">
                    <label class="control-label" for="heading">Page Heading </label>
                    <div class="controls">
                        <input type="text" <?php if(@$button=='Add'){
                            ?>
                            onkeyup="ajaxCall1(this)"
                        <?php
                        } ?> class="span6" value="<?php echo @$page->heading ?>" name="heading" id="heading" />
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="slug">Page slug </label>
                    <div class="controls">
                        <input type="text" readonly id="slug" class="span6" value="<?php echo @$page->slug ?>" name="slug" />
                    </div>
                </div>
                <div class="control-group hidden-phone">
                    <label class="control-label" for="textarea2">Description</label>
                    <div class="controls">
                        <textarea class="cleditor" id="textarea2" name="desc" rows="3"><?php echo @$page->desc ?></textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="typeahead">Background Image</label>
                    <div class="controls">
                        <input type="file" id="uploadFile_thumb" class="span6" name="bg_image" />
                        <?php if (@$page->bg_image)
                        {
                        echo '<a class="btn btn-danger" onclick="return confirm('."'Are you sure you want to delete'".')" href="'.base_url('cms/admin/delete_img/' .$page->cms_id.'/'. $page->bg_image.'/'.true).'">
                        <i class="halflings-icon white trash"></i>
                        </a>';
                         } ?>
                        <input type="hidden" value="<?php echo @$page->bg_image ?>" name="bg_image" />
                    </div>
                    <div class="controls">
                    <div id="imagePreview"
                         <?php if (@$page->bg_image)
                         { ?>style="background-image: url(<?php echo base_url('uploads/cms') . '/' . $page->bg_image ?>)"<?php
                    } else { ?>
                        style="background-image: url(<?php echo base_url('assets/images/no.jpg') ?>)"
                    <?php } ?>
                        ></div>
                        </div>

                </div>
                <div class="control-group">
                    <label class="control-label" for="news_images">Images</label>
                    <div class="controls">
                        <input class="span6" name="images[]" id="images" type="file" multiple="" />
                    </div>
                </div>
                <?php if(isset($page)){?>
                    <div class="control-group">
                        <label class="control-label" >Current Images</label>
                        <div class="controls">
                            <?php

                            $temp=explode(',',$page->images);
                            if($page->images==''||$page->images==null)
                            {
                                echo 'This Page has no images yet';
                            }else
                            {
                                echo '<ul style="list-style: none;" >';
                                for($i=0;$i<count($temp)&&$temp[$i]!='';$i++)
                                {
                                    echo '<li style="float: left;margin: 5px;" >
                            <img style="vertical-align: top" height="100" width="100" src="'.base_url('uploads/cms/'.$temp[$i]).'" />
                            <a style="margin:0 0 0 -40px;" class="btn btn-danger" onclick="return confirm('."'Are you sure you want to delete'".')" href="'.base_url('cms/admin/delete_img/' .$page->cms_id.'/'. $temp[$i]).'">
                                    <i class="halflings-icon white trash"></i>
                                </a>
                            </li>';
                                }
                                echo ' </ul>';
                            }
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary" name="<?php echo $button ?>"><?php echo $button ?></button> 
                </div>
            </fieldset>
        </form>   

    </div>
</div>

<?php echo $this->load->view('admin/footer'); ?>

<script>
    CKEDITOR.replace( 'textarea2' );
    $(function () {
        $("#uploadFile_thumb").on("change", function () {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader)
                return; // no file selected, or no FileReader support

            if (/^image/.test(files[0].type)) { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function () { // set image data as background of div
                    $("#imagePreview").css("background-image", "url(" + this.result + ")");
                }
            }
        });
    });
</script>

<script>
    function ajaxCall1(field)
    {
        var v = '';
        v = $('#' + field.id).val();
        $.ajax({
            type: "POST",
            url: "<?php echo base_url() ?>cms/admin/slugify",
            cache: false,
            data: {txt: v},
            success: function (result) {
                $('#slug').val(result);
            },
            error: function (request, error) {
                console.log("Error " + error);
            }
        });
    }
</script>