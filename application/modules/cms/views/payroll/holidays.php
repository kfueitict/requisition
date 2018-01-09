<?php
$this->load->view('include/header');?>
<div class="grybg">
    <div class="title-wrapper grbg padtb-50 txt-c">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="fadeInDownShort slowest go blc padtb-10">Set Holidays</span></h1>
                    <p class="fadeInUpShort slow go whc fs22 padtb-10">Set holidays so employees will get their overtime according</p>
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper my-availibility padtb-30">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="col-box-wrapper pada-30">
                        <div id="calendar-availibility">
                            <div class="loader-wrapper" id="ajaxWrapper">
                                <div id="ajaxBusy"><p id="ajaxBusyMsg">Please wait...</p></div>
                            </div>

                        </div>
                        <div class="form-group">
                            <input class="form-control" id="availibility-field" type="text" placeholder="Click any Calendar date">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="col-box-wrapper pada-20 marl-15">
                        <h4 class="redc fs24 marb-15">Additional Info</h4>
                            <ul class="db fs15 avail-info">
                                <li><span class="grybg"></span> Click the dates to set Holiday</li>
                                <li><span class="redbg"></span> Off Days</li>
                                <li><span class="grbg"></span> ON Days</li>
                            </ul>
                    </div>
                    <div class="col-box-wrapper pada-20 marl-15 fs18">
                        <?php $temp=explode(',',@$avail->weekends);
                        ?>
                        <label class="Form-label--tick pada-5">
                            <input <?php if(@$temp[0]==6) echo 'checked' ?> type="checkbox" value="0" id="sat" name="SomeCheckbox" class="Form-label-checkbox weekends">
                            <span class="Form-label-text fs14"> &nbsp; Disable all Saturdays.</span>
                        </label>
                        <label class="Form-label--tick pada-5">
                            <input type="checkbox" value="6" id="sun" <?php if(isset($temp[1]) && @$temp[1]!='*') echo 'checked' ?> name="SomeCheckbox" class="Form-label-checkbox weekends">
                            <span class="Form-label-text fs14"> &nbsp; Disable all Sundays.</span>
                        </label>
                    </div>
                </div>

            </div>



        </div>
    </div>

</div>

<?php $this->load->view('include/footer'); ?>
<script>
    $('#ajaxWrapper').hide();
    $(document).ajaxStart(function () {
        //$('#ajaxBusy').center();
        $('#ajaxWrapper').show();
    }).ajaxStop(function () {
        $('#ajaxWrapper').hide();
    });
    var dates;
    var el;
    var diable= <?php if(@$avail->weekends)
     {?>
        ['* * * <?php echo @$avail->weekends; ?>'];

     <?php }else{?>
      null;
      <?php }
      ?>
    var dates= <?php if(@$avail->holidays)
     {
      echo json_encode(explode(',',@$avail->holidays)).';';
      }else{?>
    null;
    <?php }
    ?>
    $('#availibility-field').Zebra_DatePicker({
        direction:[0, 365],
        disabled_dates:diable,
        onChange: function(view, elements) {
            elements.each(function() {
                try{
                    if (dates.length>0&&dates.indexOf($(this).data('date'))!=-1)
                    {
                        $(this).css({
                            background: '#f23630',
                            color:      '#FFF'
                        });
                    }else{
                        $(this).css({
                            background: '',
                            color:      ''
                        });
                    }
                }catch (error)
                {
                    $(this).css({
                        background: '',
                        color:      ''
                    });
                }



            });
            el=elements;
        },
        onSelect: function(d){
            $.post(BASE_URL+'cms/holidays',{value:d},function(result){
                dates=JSON.parse(result);
                update();
            });
        },
        always_visible: $('#calendar-availibility')

    });
    function update()
    {
        el.each(function() {
            try{
                if (dates.length>0&&dates.indexOf($(this).data('date'))!=-1)
                {
                    $(this).css({
                        background: '#f23630',
                        color:      '#FFF'
                    });
                }else{
                    $(this).css({
                        background: '',
                        color:      ''
                    });
                }

            }catch(err)
                {
                    $(this).css({
                        background: '',
                        color:      ''
                    });
            }


        });
    }
    $(document).on('click','.weekends', function () {
        $.post(BASE_URL+'cms/holidays',
            {weekends:true,key:this.id,value:this.checked},
            function(result){
                var r= JSON.parse(result);
                var datepicker = $('#availibility-field').data('Zebra_DatePicker');
                datepicker.update({
                    direction: [true,90],
                    disabled_dates:r
                });
        });
    });
</script>