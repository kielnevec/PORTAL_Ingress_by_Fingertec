<div class="row-fluid">
    <div class="span12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet box light-grey">
            <div class="portlet-title">
                <h4><i class="icon-user"></i>Manage Leave</h4>

                <div class="actions">
                    <div class="btn-group">
                        <a class="btn green" href="#" data-toggle="dropdown">
                            <i class="icon-cogs"></i> Tools
                            <i class="icon-angle-down"></i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="<?php echo base_url() ?>index.php/eform/manage/excel">Export To Excel</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="portlet-body">
                <div class="btn-group pull-right">

                </div>
                <table class="table table-striped table-bordered table-hover" id="sample_1">
                    <thead>
                    <tr>
                        <th># Doc No.</th>
                        <th>Doc Date</th>
                        <th>Employee ID</th>
                        <th>Department</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Form Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($leave as $row) {
                        ?>
                        <tr>
                            <td><?php echo $row['leaveid']; ?></td>
                            <td><?php echo $row['docdate']; ?></td>
                            <td><?php echo $row['ic']; ?></td>
                            <td><?php echo $row['gName']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['lastname']; ?></td>
                            <td><?php echo $row['remark_type']; ?></td>

                            <td>
                                <?php
                                if ($row['docstatus'] == 0) {
                                    ?>
                                    <span class="label label-info label-mini">Waiting App</span>
                                    <?php
                                } else if ($row['docstatus'] == 1) {
                                    ?>
                                    <span class="label label-success label-mini">Approved</span>
                                    <?php
                                } else if ($row['docstatus'] == 2) {
                                    ?>
                                    <span class="label label-danger label-mini">Rejected</span>
                                    <?php
                                }
                                ?>
                            </td>
                            <td>
                                <a href="<?php echo base_url(); ?>index.php/eform/manage/view/<?php echo $row['leaveid']; ?>"
                                   class="btn mini green-stripe">Detail</a></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>