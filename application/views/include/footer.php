<footer class="main-footer">

        <strong>Copyright &copy; 2018 <a href="#">Kfueit</a>.</strong> All rights reserved.
      </footer>
<div class="control-sidebar-bg"></div>
</div><!-- ./wrapper -->

    <!-- jQuery 2.1.4 -->
    <script src="<?php echo base_url('assets') ?>/plugins/jQuery/jquery-2.2.4.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
<!--    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>-->
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    
    
<!--popup window jquery files    -->
   <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    

<script src="<?php echo base_url('assets') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('assets') ?>/plugins/datatables/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url('assets') ?>/plugins/datatables/buttons.flash.min.js"></script>
<script src="<?php echo base_url('assets') ?>/plugins/datatables/jszip.min.js"></script>
<script src="<?php echo base_url('assets') ?>/plugins/datatables/pdfmake.min.js"></script>
<script src="<?php echo base_url('assets') ?>/plugins/datatables/vfs_fonts.js"></script>
<script src="<?php echo base_url('assets') ?>/plugins/datatables/buttons.html5.min.js"></script>
<script src="<?php echo base_url('assets') ?>/plugins/datatables/buttons.print.min.js"></script>
<script src="<?php echo base_url('assets') ?>/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url() ?>assets/js/zebra_datepicker.js" type="text/javascript"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="<?php echo base_url('assets') ?>/bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <!-- Sparkline -->
    <script src="<?php echo base_url('assets') ?>/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- jvectormap -->
    <script src="<?php echo base_url('assets') ?>/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="<?php echo base_url('assets') ?>/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="<?php echo base_url('assets') ?>/plugins/knob/jquery.knob.js"></script>

    <!-- daterangepicker -->
    <script src="<?php echo base_url('assets') ?>/plugins/daterangepicker/moment.min.js"></script>
    <script src="<?php echo base_url('assets') ?>/plugins/daterangepicker/daterangepicker.js"></script>
<script src="<?php echo base_url('assets') ?>/plugins/iCheck/icheck.min.js"></script>
    <!-- datepicker -->
    <script src="<?php echo base_url('assets') ?>/plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="<?php echo base_url('assets') ?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="<?php echo base_url('assets') ?>/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="<?php echo base_url('assets') ?>/plugins/fastclick/fastclick.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?php echo base_url('assets') ?>/dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--    <script src="--><?php //echo base_url('assets') ?><!--/dist/js/pages/dashboard.js"></script>-->
    <!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets') ?>/plugins/ckeditor/ckeditor.js"></script>
    <script src="<?php echo base_url('assets') ?>/dist/js/demo.js"></script>
<script src="<?php echo base_url('assets') ?>/validation/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url('assets') ?>/validation/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>

<script src="<?php echo base_url('assets') ?>/plugins/toastr/toastr.min.js"></script>
<script src="<?php echo base_url('assets') ?>/plugins/bootstrap-datetime-picker/bootstrap-datetimepicker.js"></script>
<script src="<?php echo base_url('assets') ?>/chart/js/jquery.jOrgChart.js"></script>
<script src="<?php echo base_url('assets/plugins/wizard') ?>/js/jquery.bootstrap.wizard.js" type="text/javascript"></script>


<!--  Plugin for the Wizard -->
<?php if(!empty($js)&& (is_array($js)||is_object($js))){
    foreach ($js as $cs)
    {
        echo '<script src="'.base_url('assets')."/$cs".'" type="text/javascript"></script>';
    }
}
?>
  </body>
<script>
    $( document ).ajaxStart(function() {
        $('#loader').show();
    });

    $( document ).ajaxComplete(function() {
        $('#loader').hide();
    });

    $(document).ready(function () {
        setInterval(function () {
            $('.alert').fadeOut(2500);
        },4000);
    });///////////////////////////////////////////////////////////////////////////
    ///////// Get Cart Items using ajax call
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//    $(document).ready(function() {
//        $.ajax({
//            //////////////////////////////////////////////////////////////////////////////////////////
//            /////////////////////////////////Cart Scripts Start//////////////////////////////
//            //////////////////////////////////////
//            url: "<?php //echo base_url('/Items/getCartItemsReady'); ?>//",
//            method: "GET",
//            success: function(res) {
//                console.log(res);
//                $('.cart_table tbody').html(res);
//            },
//            error: function(res){
//                alert("pop error")
//            }
//        });
//    });
    $(document).on('change','.availableqty',function(){
        var qty = $(this).closest("tr").find($('.qty')).text();
        var availableqty = $(this).val();
        var balanceqty = $(this).closest("tr").find($('.balanceqty')).text();
        var setMaxLimit = $(this).closest("tr").find($('.availableqty').attr('max',qty));
        var bal = parseInt(qty) - parseInt(availableqty);

        $(this).closest("tr").find($(".balanceqty")).html(bal.toString());

        $(this).closest("tr").find($('.availableqty')).attr('value',availableqty);
        $(this).closest("tr").find( $("input[name='availableqty[]']")).attr("value",parseInt(availableqty))[$(this).closest("tr")[0].rowIndex];
        $(this).closest("tr").find( $("input[name='balanceqty[]']")).attr("value",parseInt(bal))[$(this).closest("tr")[0].rowIndex];

    })


    $(".checkRequest").change(function() {

        if(this.checked) {

            $(this).closest('tr').find('.availableqty').val($(this).closest('tr').find('.qty').text());
            $(this).closest("tr").find( $("input[name='availableqty[]']")).val($(this).closest('tr').find('.qty').text());
            $(this).closest('tr').find('.balanceqty').text('0');
            $(this).closest('tr').find('.availableqty').prop('disabled', true);
            console.log("Checked")
        }
        else{
            $(this).closest('tr').find('.availableqty').val($(this).closest('tr').find('.qty').text());
            $(this).closest('tr').find('.balanceqty').text('0');
            $(this).closest('tr').find('.availableqty').prop('disabled', false);
            console.log("Un Checked")
        }
    });

    $.ajax({
        url: "<?php echo base_url('/Items/getCartItemsReady'); ?>",
        method: "GET",
        success: function(res) {
            $('.cart_table tbody').html(res);
        },
        error: function(res){
            console.log(res);
        }
    });

    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ///////// Add Cart item in cart using ajax call
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $( "#add_item" ).click(function() {
        $count = $("#quantity").val();
        $itm = $("#pro_item option:selected").text();
        $itmNum = $("#pro_item option:selected").val();
        $i_reason = $('#reason').val();


        $.ajax({
            url: "<?php echo base_url('/Items/addToCart'); ?>",
            method: "POST",
            data: {item_id: $itmNum, item_count: $count , item_name: $itm, reason : $i_reason},
            //dataType: 'json',
            success: function(res) {
                $('.cart_table tbody').html(res);
                // checkTableLength()
            },
            error: function(res){
                console.log(res);

                alert("  error")
            }
        });
    });
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    ////////////// Update Cart count
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    $(document).on('click' , '#approveItem',function() {

        $rowid = $(this).attr('value')
        $val   = $(this).closest("tr").find(".qty").val();
        $appr   = $(this).closest("tr").find(".approveI").val();
        if($appr == null || $appr == ""){
            $appr = 'Recommended';
            $(this).closest("tr").find(".approveI").val('Recommended');
            $(this).closest("tr").addClass("success")
        }

        $.ajax({
            url: "<?php echo base_url('/Items/approveItem'); ?>",
            method: "POST",
            data: {rownumber: $rowid, value: $val, approve:$appr},
            success: function(res) {
                if(res =='success')
                {
                    // $(this).closest("tr").addClass("success")
                }
                          },
            error: function(res){
                alert("update error")
            }
        });
    });
    $(document).on('click' , '#updateCart',function() {

        $rowid = $(this).attr('value')
        $val   = $(this).closest("tr").find(".qty").text();

        $.ajax({
            url: "<?php echo base_url('/Items/updateCart'); ?>",
            method: "POST",
            data: {rownumber: $rowid, value: $val},
            success: function(res) {
                // $('.cart_table tbody').html(res);
                //alert("succcess")
            },
            error: function(res){
                //alert("update error")
            }
        });
    });
    $(document).on('click' , '#deleteCart',function() {
         $(this).closest('tr').remove()
        $rowid = $(this).attr('value')
        console.log($rowid)
        $.ajax({
            url: "<?php echo base_url('/Items/deleteItem'); ?>",
            method: "POST",
            data: {rownumber: $rowid},
            success: function(result) {
                console.log(result)
                if(result == '1'){
                    $($('#deleteCart').closest("tr")).remove()

                    }else{
                    console.log('Contact to IT Department')
                }
            },
            error: function(result){
                console.log('Contact to IT Department')
            }
        });

    });
    // Fill modal with content from link href
    $("#myModal").on("show.bs.modal", function(e) {
        var link = $(e.relatedTarget);
        $(this).find(".modal-body").load(link.attr("href"));
    });
    $(document).on("click",".modalPop", function(){
        $itemid = $(this).attr('data-reqid')
        $obj = $(this)
        $.ajax({
            url: "<?php echo base_url('/Items/history'); ?>",
            method: "POST",
            data: {reqid: $itemid},
            success: function($re) {
                if($re == 'success'){

                    $("#myModal").on("show.bs.modal", function(e) {
                        var link = $(e.relatedTarget);
                        $obj.find(".modal-body").load(link.attr("href"));
                    });
                }
            },
            error: function(result){
                console.log('Contact to IT Department')
            }
        });
    })
    $(document).ready(function() {
//  checkTableLength()

        $('.cart_table').DataTable(
            {
                "bLengthChange": false,
                "searching": false,
                "ordering": false,
                "bInfo": false
            });

        $('#category_ddl').on('change', function () {
            var cat_id = $(this).val();
            if (cat_id == '') {
                $('#pro_item').prop('disabled', true);
            }
            else {
                $('#pro_item').prop('disabled', false);
                $.ajax({
                    url: "<?php echo base_url('/items/getProducts'); ?>",
                    type: 'POST',
                    data: {"category_id": cat_id},
                    success: function (data) {
                        var cate = JSON.parse(data);
                        $('#pro_item').empty();
                        if (cate.cat_query != false) {
                            $.each(cate, function (i, d) {
                                $('#pro_item').append("<option value='" + d[0].id + "'>" + d[0].name + "</option>");
                            });
                            $(".select2").select2();
                        }
                    },
                    error: function (data) {
                        alert('Error....');
                    }
                });
            }
        });
    });
    function checkTableLength(){
        var rowCount = $('.cart_table > tbody >tr').length;
        if(rowCount >= 1 ){
            $('.cart_table').slideDown();
        }
        else{
            $('.cart_table').slideUp();
        }
    }
    //////////////////////////////////Cart Scripts End/////////////////////////////////////////////
</script>


</html>
