<?php $this->load->view('include/header');

function generateTree($hrchy,$id=null)
{
    echo '<ul>';
    foreach ($hrchy as $hr)
    {
        if($hr->parent_id==$id)
        {
            echo '<li><div class="bg-light-blue-gradient pada-4" style="border-top-right-radius: 5px; border-top-left-radius: 5px"> ';
            echo '<span class=" btn glyphicon glyphicon-trash pull-right" onclick="deleteHr('.$hr->id.');"></span>';
            echo  "<h4>".$hr->title."</h4></div>";
            echo '<div class="pada-4"><h5>HOD: '.$hr->emp_no."-".$hr->emp_title." ".$hr->name
                .' <small>
                <span class=" btn glyphicon glyphicon-edit" onclick="updateDept('.$hr->id.",'hod'".');" data-toggle="modal" data-target="#empModal"></span>
                
                </small></h5>';
            echo "<h5>Reporting Head: ".$hr->emp_no_r."-".$hr->emp_title_r." ".$hr->name_r
                .' <small><span class=" btn glyphicon glyphicon-edit" onclick="updateDept('.$hr->id.",'r_head'".');" data-toggle="modal" data-target="#empModal"></span>
                <span class=" btn glyphicon glyphicon-trash pull-right" onclick="updateHierarchy('.$hr->id.",'r_head'".');"></span>
                </small></h5>';
            echo '</div> <div class="bg-light-blue-gradient pada-4" style="border-bottom-right-radius: 5px; border-bottom-left-radius: 5px"><span class=" btn glyphicon glyphicon-plus-sign" onclick="updateValue('.$hr->id.');" data-toggle="modal" data-target="#myModal"> Add Child Department</span></div>
            ';
            generateTree($hrchy,$hr->id);
            echo ' </li>';
        }
    }
    echo '</ul>';
}
?>
<style>
    .node{
        padding: 0px !important;
    }
</style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
        <h1>
            <i class="fa fa-cubes"></i>
            KFUEIT Hierarchy (Departments)
        </h1>

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
    <div class="row">
        <ul id="org" style="display:none">
            <li>
                <?php
                if(is_array(@$root)||is_object(@$root))
                {

                    echo '<div class="bg-green-gradient pada-4" style="border-top-right-radius: 5px; border-top-left-radius: 5px">'."<h4>".$root[0]->title."</h4>".'</div>';
                    echo "<h5>HOD: ".$root[0]->emp_no."-".$root[0]->emp_title." ".$root[0]->name.
                        ' <small><span class=" btn glyphicon glyphicon-edit" onclick="updateDept('.$root[0]->id.",'hod'".');" data-toggle="modal" data-target="#empModal"></span></small></h5>';
                    echo "<h5>Reporting Head: ".$root[0]->emp_no_r."-".$root[0]->emp_title_r." ".$root[0]->name_r.
                        ' <small><span class=" btn glyphicon glyphicon-edit" onclick="updateDept('.$root[0]->id.",'r_head'".');" data-toggle="modal" data-target="#empModal"></span>
                        <span class=" btn glyphicon glyphicon-trash pull-right" onclick="updateHierarchy('.$root[0]->id.",'r_head'".');"></span>
                        </small></h5>';
                }
                ?>
                <br>
                <div class="bg-green-gradient pada-4" style="border-bottom-right-radius: 5px; border-bottom-left-radius: 5px">
                <span class=" btn glyphicon glyphicon-edit" onclick="updateValue(<?php echo $root[0]->id; ?>);" data-toggle="modal" data-target="#myModal">Add Child Department</span>
                </div>
                    <?php
                generateTree($hierarchy,$root[0]->id);
                ?>
            </li>
        </ul>
    </div>
    <div class="table-responsive">
        <div id="chart"></div>
    </div>



    <input type="hidden" id="parent_id">
    <input type="hidden" id="dept">
    <input type="hidden" id="field">

</section><!-- /.content -->
</div><!-- /.content-wrapper -->

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Chose Department</h4>
            </div>
            <div class="modal-body">
                <div >
                    <table class="table" id="example1">
                        <thead>
                        <tr>
                            <th>Chose</th>
                            <th>Department</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(is_array(@$departments)||is_object(@$departments))
                        {
                            foreach ($departments as $dept){
                                {
                                    echo "<tr><td><input type='radio' value='$dept->id' id='rd_$dept->id' name='department'></td><td><label for='rd_$dept->id'>$dept->title</label></td></tr>";
                                }
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="chose" class="btn btn-success">Chose</button>
            </div>
        </div>

    </div>
</div>
<div class="modal fade" id="empModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Chose </h4>
            </div>
            <div class="modal-body">
                <div >
                    <table class="table" id="emptbl">
                        <thead>
                        <tr>
                            <th>Chose</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Department</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(is_array(@$employees)||is_object(@$employees))
                        {
                            foreach ($employees as $emp){
                                {
                                    echo "<tr>
                                            <td><input type='radio' value='$emp->id' id='rd_$emp->id' name='employee'></td>
                                            <td><label for='rd_$emp->id'>$emp->emp_no - $emp->title $emp->name</label></td>
                                            <td><label for='rd_$emp->id'>$emp->designation</label></td>
                                            <td><label for='rd_$emp->id'>$emp->department</label></td>
                                            </tr>";
                                }
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="choseHOD" class="btn btn-success">Chose</button>
            </div>
        </div>

    </div>
</div>


<?php $this->load->view('include/footer'); ?>
<script>


   
   
    $(function () {
        $("#example1").DataTable();
        $("#emptbl").DataTable();
    });
    
    function deleteHr(id) {
        var confirmation= confirm("Are you sure to delete this hierarchy?");
        if(confirmation) {
            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('cms/hierarchy/post') ?>",
                    data: {deleteHr: id}
                })
                .done(function (msg) {
                   location.reload();
                }).fail(function(msg) {
                location.reload();
            });
        }
    }


    function updateValue (field) {
        $("#parent_id").val(field);
    }
    function updateDept (dpt,field) {
        $("#dept").val(dpt);
        $("#field").val(field);
    }
    $('#chose').on('click',function () {
        var radioValue = $("input[name='department']:checked"). val();

        var parent= $("#parent_id").val();
        $.ajax({
                method: "POST",
                url: "<?php echo base_url('cms/hierarchy/post') ?>",
                data: { add_dept:1,dept:radioValue, parent:parent }
            })
            .done(function( msg ) {
                location.reload();
            });
    });


    function updateHierarchy(dpt,field) {
        $("#dept").val(dpt);
        $("#field").val(field);
        $("input[name='employee']").attr('checked', false);
        _updateHierarchy();
    }

    function _updateHierarchy() {
        var emp = $("input[name='employee']:checked"). val();
        if(emp=="undefined")
            emp=0;
        console.log(emp);

        var dept= $("#dept").val();
        var field= $("#field").val();
        $.ajax({
                method: "POST",
                url: "<?php echo base_url('cms/hierarchy/post') ?>",
                data: { emp:emp, dept:dept,field:field }
            })
            .done(function( msg ) {
                location.reload();
            });
    }

    $('#choseHOD').on('click',function () {
        _updateHierarchy();
    });
    jQuery(document).ready(function() {
        var options={
            depth   :0
        };
        $("#org").jOrgChart();
    });
</script>
