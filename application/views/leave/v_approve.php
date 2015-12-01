<div class="span12">
        <!-- BEGIN SAMPLE TABLE PORTLET-->				
        <div class="portlet box blue">
                <div class="portlet-title">
                        <h4><i class="icon-check"></i>Approve List</h4>
                </div>
                <div class="portlet-body">
                        <table class="table table-bordered table-hover">
                                <thead>
                                        <tr>
                                                <th># Doc No.</th>
                                                <th>Doc Date</th>
                                                <th>Employee ID</th>
                                                <th>Department</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Type Form</th>
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
                                                if($row['docstatus'] == 0){
                                                ?>
                                                <span class="label label-info label-mini">Pending</span>
                                                <?php
                                                }
                                                else if ($row['docstatus'] == 1){
                                                ?>
                                                <span class="label label-success label-mini">Approve</span>
                                                <?php
                                                }
                                                else if ($row['docstatus'] == 2){
                                                ?>
                                                <span class="label label-danger label-mini">Reject</span>
                                                <?php
                                                }
                                                ?>
                                                </td>
                                                
                                                <td><a href="<?php echo base_url(); ?>index.php/eform/approve/view/<?php echo $row['leaveid']; ?>" class="btn mini green-stripe">View Detail</a></td>
                                        </tr>
                                        <?php
                                            }
                                        ?>
                                        
                                        
                                </tbody>
                        </table>
                </div>
        </div>
    </div>
                <!-- END SAMPLE TABLE PORTLET-->
