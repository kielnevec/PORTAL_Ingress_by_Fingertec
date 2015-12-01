<div class="row-fluid">
        <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box light-grey">
                        <div class="portlet-title">
                                <h4><i class="icon-globe"></i>Managed Table</h4>
                                <div class="tools">
                                        <a href="javascript:;" class="collapse"></a>
                                </div>
                        </div>
                        <div class="portlet-body">
                                <div class="clearfix">
                                        <div class="btn-group pull-right">
                                                <a href="<?php echo base_url() ?>/index.php/sap/query_report/exportexcel"><button id="btnExport">Export to Excel
                                                </button></a>
                                        </div>
                                </div>
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                        <thead>
                                                <tr>
                                                        <th>Customer/Vendor Code</th>
                                                        <th>Customer/Vendor Name</th>
                                                        <th>PO #</th>
                                                        <th>SO #</th>
                                                        <th>SO Date</th>
                                                        <th>SO Status</th>
                                                        <th>ItemCode</th>
                                                        <th>Dscription</th>
                                                        <th>SO Qty</th>
                                                        <th>Picked Qty</th>
                                                        <th>Delvrd Qty</th>
                                                        <th>Remain Qty</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                                
                                                
                                                <?php
                                                   foreach ($sap_query as $row) {
                                                ?>
                                                    <tr class="odd gradeX">
                                                        <td><?php echo $row['CardCode']; ?></td>
                                                        <td><?php echo $row['CardName']; ?></td>
                                                        <td><?php echo $row['NumAtCard']; ?></td>
                                                        <td><?php echo $row['DocNum']; ?></td>
                                                        <td><?php echo $row['DocDate']; ?></td>
                                                        <td><?php echo $row['SOStatus']; ?></td>
                                                        <td><?php echo $row['ItemCode']; ?></td>
                                                        <td><?php echo $row['Dscription']; ?></td>
                                                        <td><?php echo $row['Quantity']; ?></td>
                                                        <td><?php echo $row['pkqty']; ?></td>
                                                        <td><?php echo $row['dqty']; ?></td>
                                                        <td><?php echo $row['Remaining']; ?></td>
                                                        
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