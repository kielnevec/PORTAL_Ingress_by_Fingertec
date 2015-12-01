<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="utf-8" />
	<title><?php echo $title[0]['appname']." v.".$title[0]['version']; ?></title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="<?php echo base_url() ?>assets/css/metro.css" rel="stylesheet" />
	<link href="<?php echo base_url() ?>assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="<?php echo base_url() ?>assets/css/style.css" rel="stylesheet" />
	<link href="<?php echo base_url() ?>assets/css/style_responsive.css" rel="stylesheet" />
	<link href="<?php echo base_url() ?>assets/css/style_default.css" rel="stylesheet" id="style_color" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/data-tables/DT_bootstrap.css" />
	<link rel="shortcut icon" href="<?php echo base_url() ?>favicon.ico" />
        <script type='text/javascript'>//<![CDATA[ 
         
        
        </script>
</head>
<!-- END HEAD -->

<div class="row-fluid">
        <div class="span12">
                <!-- BEGIN EXAMPLE TABLE PORTLET-->
                <div class="portlet box light-grey">
                        <div class="portlet-title">
                        <h4><i class="icon-user"></i><?php echo $titletable ?></h4>
                        </div>
                        <div class="portlet-body">
                                <div class="btn-group pull-right">

				</div>
                                <table class="table table-striped table-bordered table-hover" id="sample_99">
                                        <thead>
                                                <tr>
                                                        <th># User ID.</th>
                                                        <th>Employee No</th>
                                                        <th>Firstname</th>
                                                        <th>Lastname</th>
                                                        <th>Department</th>
							<th style="display:none;">Id Roster</th>
                                                        <th>Roster</th>
							<th>Action</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                                <?php
                                                        foreach ($outsource as $row) {
                                                ?>
                                               <tr>
                                                        <td><?php echo $row['userid']; ?></td>
                                                        <td><?php echo $row['ic']; ?></td>
                                                        <td><?php echo $row['Name']; ?></td>
                                                        <td><?php echo $row['lastname']; ?></td>							
							<td><?php echo $row['gName']; ?></td>
							<td style="display:none;"><?php echo $row['idroster']; ?></td>
                                                        <td><?php echo $row['rostername']; ?></td>
                                                        <td><a id="insert_single" href="#" name="<?php echo $row['userid']."#".$row['Name']."#".$row['lastname']."#".$row['gName']."#".$row['rostername']."#".$row['idroster']; ?>" class="btn mini green-stripe">Choose</a></td>
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

<!-- BEGIN FOOTER -->


	<script src="<?php echo base_url() ?>assets/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/data-tables/DT_bootstrap.js"></script>	
	<script src="<?php echo base_url() ?>assets/breakpoints/breakpoints.js"></script>
	<script src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.blockui.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.cookie.js"></script>
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
	<script src="<?php echo base_url() ?>assets/js/excanvas.js"></script>
	<script src="<?php echo base_url() ?>assets/js/respond.js"></script>
	<![endif]-->
	<script src="<?php echo base_url() ?>assets/js/app.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			App.setPage("table_managed");
			App.init();
		});                
                $(window).load(function(){
                $(document).ready(function() {
                $('a#insert_single').click(function() {
                    parent.setSelectedUser($(this).attr('name'));
                    parent.$.fancybox.close();
                });               
        });
        });//]]> 
	</script>
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>