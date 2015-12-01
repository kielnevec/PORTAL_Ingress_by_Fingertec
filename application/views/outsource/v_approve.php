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
                                                <th>Creator</th>
                                                <th>Doc Type</th>
                                                <th>Remark</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                        </tr>
                                </thead>
                                <tbody>
                                        <?php
                                                foreach ($pending as $row) {
                                        ?>
                                       <tr>
                                                <td><?php echo $row['docno']; ?></td>
                                                <td><?php echo date('d-m-Y',strtotime($row['docdate'])); ?></td>
                                                <td><?php echo $row['Name']." ".$row['lastname']; ?></td>
                                                <td><?php echo $row['desc']; ?></td>
                                                <td><?php echo $row['remark']; ?></td>   
                                                <td>
                                                <?php
                                                if($row['status'] == 0){
                                                ?>
                                                <span class="label label-info label-mini">Pending</span>
                                                <?php
                                                }
                                                else if ($row['status'] == 1){
                                                ?>
                                                <span class="label label-success label-mini">Execute</span>
                                                <?php
                                                }
                                                else if ($row['status'] == 2){
                                                ?>
                                                <span class="label label-danger label-mini">Reject</span>
                                                <?php
                                                }
                                                ?>
                                                </td>
                                                
                                                <td><a href="<?php echo base_url(); ?>index.php/outsource/approve/view/<?php echo $row['docno']; ?>" class="btn mini green-stripe">View</a></td>
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
