<?php echo $this->load->view('admin/header'); ?>  

<div class="box span12">
    <div class="box-header" data-original-title> 
        <h2><i class="halflings-icon edit"></i><span class="break"></span> <?php echo $title ?></h2>
<!--        <div class="box-icon">
            <a href="#" onclick="history.back();" class="btn btn-primary" style="margin: -11px 10px 0px;">Back</a>
        </div>-->
    </div>
    <?php if ($this->session->flashdata('message')) { ?>
        <div class="alert alert-success" style="text-align: center;">
            <button data-dismiss="alert" class="close" type="button">×</button>
            <?php echo $this->session->flashdata('message'); ?>
        </div>
    <?php } ?>
    <div class="box-content">

        <fieldset>
            <div class="control-group">
                <label class="control-label" for="typeahead"> Contact Us E-Mail </label>
                <div class="controls">
                    <form class="form-horizontal" action="<?php echo base_url('cms/admin/save_setting'); ?>" method="post">
                        <input type="email" class="span6" value="<?php echo @$page->contact_email ?>" name="setting" />
                        <input type="hidden" name="field" value="contact_email" />
                        <button type="submit" class="btn btn-primary" name="update" >Save</button> 
                    </form> 
                </div>
            </div>  
        </fieldset>

        <fieldset>
            <div class="control-group">
                <label class="control-label" for="typeahead"> Sales E-Mail </label>
                <div class="controls">
                    <form class="form-horizontal" action="<?php echo base_url('cms/admin/save_setting'); ?>" method="post">
                        <input type="email" class="span6" value="<?php echo @$page->sales_email ?>" name="setting" />
                        <input type="hidden" name="field" value="sales_email" />
                        <button type="submit" class="btn btn-primary" name="update" >Save</button>
                    </form>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <div class="control-group">
                <label class="control-label" for="typeahead"> Subscription E-Mail </label>
                <div class="controls">
                    <form class="form-horizontal" action="<?php echo base_url('cms/admin/save_setting'); ?>" method="post">
                        <input type="text" class="span6" value="<?php echo @$page->subscribe_email ?>" name="setting" />
                        <input type="hidden" name="field" value="subscribe_email" />
                        <button type="submit" class="btn btn-primary" name="update" >Save</button>
                    </form>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <div class="control-group">
                <label class="control-label" for="typeahead"> Contact Phone </label>
                <div class="controls">
                    <form class="form-horizontal" action="<?php echo base_url('cms/admin/save_setting'); ?>" method="post">
                        <input type="text" class="span6" value="<?php echo @$page->contact_phone ?>" name="setting" /> 
                        <input type="hidden" name="field" value="contact_phone" />
                        <button type="submit" class="btn btn-primary" name="update" >Save</button> 
                    </form> 
                </div>
            </div>  
        </fieldset>  

        <fieldset>
            <div class="control-group">
                <label class="control-label" for="typeahead"> Fax </label>
                <div class="controls">
                    <form class="form-horizontal" action="<?php echo base_url('cms/admin/save_setting'); ?>" method="post">
                        <input type="text" class="span6" value="<?php echo @$page->fax ?>" name="setting" /> 
                        <input type="hidden" name="field" value="fax" />
                        <button type="submit" class="btn btn-primary" name="update" >Save</button> 
                    </form> 
                </div>
            </div>  
        </fieldset>  

        <!--        <fieldset>
                    <div class="control-group">
                        <label class="control-label" for="typeahead"> Video Link </label>
                        <div class="controls">
                            <form class="form-horizontal" action="<?php echo base_url('cms/admin/save_setting'); ?>" method="post">
                                <input type="text" class="span6" value="<?php echo @$page->video ?>" name="setting" /> 
                                <input type="hidden" name="field" value="video" />
                                <button type="submit" class="btn btn-primary" name="update" >Save</button> 
                            </form> 
                        </div>
                    </div>  
                </fieldset>  -->

    </div>
</div>

<?php echo $this->load->view('admin/footer'); ?>