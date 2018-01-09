<?php $this->load->view('header'); ?>
<div class="white_section"><!--Start of Midsection-->

    <div class="mid_center midd">
        <div class="slider_img">

            <div id="wowslider-container1">
                <div class="ws_images"><ul>
                        <?php foreach ($slider as $row) { ?>
                            <li><img src="<?php echo base_url('uploads/slider') . '/' . $row->img_src ?>" alt="Delivering quality air products since 1989." title="Delivering quality air products since 1989." id="wows1_0"/></li> 
                        <?php } ?>
                    </ul></div> 
                <div class="ws_shadow"></div>
            </div>	 

        </div><!--slider-->
        </div>
<div class="mid_center">
        <?php echo $page->desc ?>

        <div class="ri_side">
            <a href="<?php echo base_url();?>uploads/certificate/pdf/company_profile.pdf " target="_blank">Download Company Profile<img src="<?php echo base_url(); ?>assets/images/pdf_icn.png"></a>
            <div class="abou_imgs">
                <img src="<?php echo base_url(); ?>assets/images/about1.png" />
                <img src="<?php echo base_url(); ?>assets/images/about2.png" />
                <img src="<?php echo base_url(); ?>assets/images/about3.png" />

            </div>

        </div>
    </div>
</div>
<?php
$this->load->view('footer');
