<div class="row-fluid">
        <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box light-grey">
                        <div class="portlet-title">
                        <h4><i class="icon-user"></i>Manage Form</h4>
                                <div class="actions">
                                        <div class="btn-group">
                                                <a class="btn green" href="#" data-toggle="dropdown">
                                                <i class="icon-cogs"></i> Tools
                                                <i class="icon-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-menu pull-right">
                                                        <li><a href="<?php echo base_url() ?>index.php/leave/manage/excel">Export To Excel</a></li>
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
							<th>#No</th>
                                                        <th>Doc No</th>
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
							$i = 1;
                                                        foreach ($outsource as $row) {
                                                ?>
                                               <tr>
						    <td><?php echo $i; ?></td>
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
                                                    <span class="label label-success label-mini">Complete</span>
                                                    <?php
                                                    }
                                                    else if ($row['status'] == 2){
                                                    ?>
                                                    <span class="label label-danger label-mini">Reject</span>
                                                    <?php
                                                    }
                                                    ?>
                                                    </td>
                                                    
                                                    <td><a href="<?php echo base_url(); ?>index.php/outsource/manage/view/<?php echo $row['docno']; ?>" class="btn mini green-stripe">View</a></td>
                                                </tr>
                                                <?php
							$i++;
                                                    }
                                                ?>
                                        </tbody>
                                </table>
                        </div>
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
        </div>
</div>