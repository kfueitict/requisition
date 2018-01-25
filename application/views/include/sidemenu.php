
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="active treeview">
                <a href="<?php echo base_url('cms'); ?>">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            <?php if(is_admin(false)){?>
                <li class="treeview <?php  if(strpos(current_url(),'/user')!==false) echo 'active' ?>">
                    <a href="#">
                        <i class="fa fa-user"></i>
                        <span>Manage Users</span>
                        <i class="fa pull-right fa-angle-left"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url('users/types') ?>"><i class="fa fa-circle-o"></i> User Types</a></li>
                        <li><a href="<?php echo base_url('users') ?>"><i class="fa fa-circle-o"></i> Users</a></li>
                        <li><a href="<?php echo base_url('users/audit?from_date='.date('Y-m-d')) ?>"><i class="fa fa-user-secret"></i> Audit</a></li>
                    </ul>
                </li>

            <?php }?>
            <?php if(is_dr_user(false)||is_dr_user_payroll(false)){?>
                <li class="treeview
                <?php  if(
                    strpos(current_url(),'/employees/setting')!==false ||
                    strpos(current_url(),'cms/leaves')!==false ||
                    strpos(current_url(),'/departments')!==false ||
                    strpos(current_url(),'/designations')!==false ||
                    strpos(current_url(),'/boards')!==false ||
                    strpos(current_url(),'/degrees')!==false ||
                    strpos(current_url(),'/employers')!==false ||
                    strpos(current_url(),'/countries')!==false ||
                    strpos(current_url(),'/hierarchy')!==false ||
                    strpos(current_url(),'/holidays')!==false
                )

                    echo 'active' ?>">
                    <a href="#">
                        <i class="fa fa-user"></i>
                        <span>Master Files</span>
                        <i class="fa pull-right fa-angle-left"></i>
                    </a>
                    <ul class="treeview-menu">

                        <li><a href="<?php echo base_url('cms/hierarchy') ?>"><i class="fa fa-circle-o"></i> Hierarchy</a></li>


                    </ul>
                </li>
            <?php } ?>
            


            <li class="treeview <?php  if(strpos(current_url(),'items')!==false && strpos(current_url(),'items/request')===false) echo 'active' ?>">
                <a href="#">
                    <i class="fa fa-calendar-times-o"></i>
                    <span>My Requisition</span>
                    <i class="fa pull-right fa-angle-left"></i>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url('items') ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                    <li><a href="<?php echo base_url('items/status/in-process') ?>"><i class="fa fa-circle-o"></i> Pending for Approval </a></li>
                    <li><a href="<?php echo base_url('items/ispartial/partial-approved') ?>"><i class="fa fa-circle-o"></i> Partial Approved </a></li>
                    <li><a href="<?php echo base_url('items/status/withdrawn') ?>"><i class="fa fa-circle-o"></i>Request Withdrawn </a></li>

                    <li><a href="<?php echo base_url('items/status/approved') ?>"><i class="fa fa-circle-o"></i> Approved</a></li>
                    <li><a href="<?php echo base_url('items/status/rejected') ?>"><i class="fa fa-circle-o"></i> Rejected</a></li>
                </ul>
            </li>
            <?php if(is_admin(false)){?>

            <?php } ?>

            <?php if(is_hod(false)||is__reportingHead(false)){?>
                <li class="treeview <?php  if(strpos(current_url(),'leaves/request')!==false) echo 'active' ?>">
                    <a href="#">
                        <i class="fa fa-tasks"></i>
                        <span>Tasks</span>
                        <i class="fa pull-right fa-angle-left"></i>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="<?php echo base_url('items/request/tasks/pending') ?>"><i class="fa fa-circle-o"></i> Pending</a></li>
                        <li><a href="<?php echo base_url('items/request/tasks/partial') ?>"><i class="fa fa-circle-o"></i> Partial Completed</a></li>
                        <li><a href="<?php echo base_url('items/request/tasks/completed') ?>"><i class="fa fa-circle-o"></i> Completed</a></li>
                    </ul>
                </li>
                


                
            <?php } ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
