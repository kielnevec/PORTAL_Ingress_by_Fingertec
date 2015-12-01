<!-- BEGIN FOOTER -->
	<div class="footer">
		2014 &copy; ESRNL.
		<div class="span pull-right">
			<span class="go-top"><i class="icon-angle-up"></i></span>
		</div>
	</div>
	<!-- END FOOTER -->
	<!-- BEGIN JAVASCRIPTS -->
	<!-- Load javascripts at bottom, this will reduce page load time -->
	<?php if(isset($crud_output)){ ?>

	<?php foreach ($crud_output->css_files as $file): ?>
        <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />

        <?php endforeach; ?>
        <?php foreach ($crud_output->js_files as $file): ?>

        <script src="<?php echo $file; ?>"></script>
        <?php endforeach; ?>
	
	<?php }
	
	else {
	?>
	<script src="<?php echo base_url() ?>assets/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/data-tables/jquery.dataTables.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/data-tables/DT_bootstrap.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.btechco.excelexport.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.blockui.js"></script>
	<script src="<?php echo base_url() ?>assets/fancybox/source/jquery.fancybox.pack.js"></script>
		<?php
		if($this->session->userdata('l_outsource') == 1 || $this->session->userdata('l_outsource') == 2 || $this->session->userdata('l_apply') == 1){
		?>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/bootstrap-wysihtml5/wysihtml5-0.3.0.js"></script> 
		<script type="text/javascript" src="<?php echo base_url() ?>assets/bootstrap-wysihtml5/bootstrap-wysihtml5.js"></script>
		<?php
			if($this->session->userdata('l_outsource') == 2){
				$this->session->set_userdata('l_outsource', 0);
			}
		}
		?>
	<?php 		
	}
	?>
	
	
	<script src="<?php echo base_url() ?>assets/breakpoints/breakpoints.js"></script>
	<script src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.blockui.js"></script>
	<script src="<?php echo base_url() ?>assets/js/jquery.cookie.js"></script>
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
	<script src="<?php echo base_url() ?>assets/js/excanvas.js"></script>
	<script src="<?php echo base_url() ?>assets/js/respond.js"></script>
	<![endif]-->
	<script type="text/javascript" src="<?php echo base_url() ?>assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/gritter/js/jquery.gritter.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.pulsate.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/bootstrap-timepicker/js/bootstrap-timepicker.js"></script>
	<script src="<?php echo base_url() ?>assets/js/app.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			App.setPage("table_managed");
			App.init();
		});
		<?php
		if($this->session->userdata('l_outsource') == 1){
		?>
		
		//function hide & disable when it start		
		$("#typeform").prop('disabled', false);
		$("#expectedroster").hide();
		$("#lblexpectedschedule").hide();
		$("#expectedschedule").hide();
		$("#lblexpectedroster").hide();
		$("#typeform").val(0);
		
		//hide column for specific form type
		$('#tabledetail tr *:nth-child(6)').css('display','none');
		$('#tabledetail tr *:nth-child(7)').css('display','none');
		$('#tabledetail tr *:nth-child(8)').css('display','none');
		$('#tabledetail tr *:nth-child(9)').css('display','none');
		var flagtable = 0;

		//function btn find into textbox
		function setSelectedUser(userText) {
			var str = userText;
			var arrtmp = userText.split('#');
			
			$('#idemp').val(arrtmp[0]);
			$('#firstname').val(arrtmp[1]);
			$('#lastname').val(arrtmp[2]);
			$('#dept').val(arrtmp[3]);
			$('#roster').val(arrtmp[4]);
			$('#idroster').val(arrtmp[5]);
		}
		
		$(document).ready(function(){
			$("#idemp").change(function(){
				if ($('#idemp').val() != "") {
					$("#oslist").attr("href", "<?php echo base_url() ?>index.php/outsource/outsourcelist/getlist/"+$('#idemp').val());

				}
				else
				{
					$("#oslist").attr("href", "<?php echo base_url() ?>index.php/outsource/outsourcelist");
				}
				
			    
			});
		});
				
		//function btn remove to table
		$("#removeline").click(function (){
			$('#tabledetail tbody tr:last').remove();
		});
		
		//function btn add to table
		$("#addline").click(function () {
			var idemp = $('#idemp').val();
			var firstname= $('#firstname').val();
			var lastname = $('#lastname').val();
			var dept = $('#dept').val();
			var idroster = $('#idroster').val();
			var roster = $('#roster').val();
			
			var expectedroster = ($('#expectedroster').val()).split('#|#');
			var expectedschedule = ($('#expectedschedule').val()).split('#|#');
			
			var amountOfRows = $("#tabledetail  tbody  tr").length;
			var t = document.getElementById('tabledetail');
			var typeform = $('#typeform').val();
			var datefrom = $("#datefrom").val();
			var dateto = $("#dateto").val();
			
			flagtable = 0;

			for(i = 0; i <= amountOfRows; i++){
				if(($(t.rows[i].cells[0]).text() == idemp))
				   {
					flagtable = 1;
				   }
			} 
			
			if (typeform == 0) {
				alert("Please Choose Form Type");
			}
			else if(idemp == "" || idroster == "")
			{
				alert("Please Select the employee");
			}
			else if (flagtable == 1) {
				
				alert("Employee already added to table");
			}
			else
			{
				//validation for form type
				$("#typeform").prop('disabled', true);
				if (typeform == 3 || typeform == 4 || typeform == 5 || typeform == 1 || typeform == 6) {
					if ($("#datefrom").val() == "" || $("#dateto").val() == "") {
						
						alert("Please to Fill DateFrom & DateTo");
					}
					else if (process(datefrom) > process(dateto)) {
						alert("Please check DateFrom & DateTo is incorrect");
					}
					else
					{
						if (typeform == 1 && $("#expectedschedule").val() == 0) {
							alert("Please Select Expected Schedule");
						}
						else
						{
							if (typeform == 1) {
								
								var row = "<tr><td><input type=\"hidden\" name=\"tmpidemp[]\" value='"+idemp+"#|#"+firstname+" "+lastname+"#|#"+dept+"#|#"+idroster+"#|#"+roster+"#|#"+expectedschedule[0]+"#|#"+expectedschedule[1]+"#|#"+datefrom+"#|#"+dateto+"' /><label>"+idemp+"</label></td><td><label>"+firstname+" "+lastname+"</label></td><td><label>"+dept+"</label></td><td><label>"+idroster+"</label></td><td><label>"+roster+"</label></td><td><label>"+expectedschedule[0]+"</label></td><td><label>"+expectedschedule[1]+"</label></td><td><label>"+datefrom+"</label></td><td><label>"+dateto+"</label></td></tr>";
								$("#tabledetail").append(row);
							}
							else{
								//function for add row based on form type
								var row = "<tr><td><input type=\"hidden\" name=\"tmpidemp[]\" value='"+idemp+"#|#"+firstname+" "+lastname+"#|#"+dept+"#|#"+idroster+"#|#"+roster+"#|#"+datefrom+"#|#"+dateto+"'/><label>"+idemp+"</label></td><td><label>"+firstname+" "+lastname+"</label></td><td><label>"+dept+"</label></td><td><label>"+idroster+" </label></td><td><label>"+roster+"</label></td><td><label>"+datefrom+"</label></td><td><label>"+dateto+"</label></td></tr>";
								$("#tabledetail").append(row);	
							}
							
						}
					}
				}
				else if (typeform == 2) {
					if ($("#datefrom").val() == ""){
						
						alert("Please to Fill DateFrom");
					}
					else if ($("#expectedroster").val() == 0) {
						alert("Please Select Expected Roster");
					}
					else{
						var row = "<tr><td><input type=\"hidden\" name=\"tmpidemp[]\" value='"+idemp+"#|#"+firstname+" "+lastname+"#|#"+dept+"#|#"+idroster+"#|#"+roster+"#|#"+expectedroster[0]+"#|#"+expectedroster[1]+"#|#"+datefrom+"' /><label>"+idemp+"</label></td><td><label>"+firstname+" "+lastname+"</label></td><td><label>"+dept+"</label></td><td><label>"+idroster+"</label></td><td><label>"+roster+"</label></td><td><label>"+expectedroster[0]+"</label></td><td><label>"+expectedroster[1]+"</label></td><td><label>"+datefrom+"</label></td></tr>";
						$("#tabledetail").append(row);
					}
				}
	
			}
			
		});
		
		//function cmbbox hidefield when clicked
		$("#typeform").change(function(){
			$("#tmptypeform").val($(this).val());
			
			if ($('#typeform').val() == "1"){
				$("#expectedschedule").show( "slow");
				$("#lblexpectedschedule").show("slow");
				
				$("#expectedroster").hide( "slow");
				$("#lblexpectedroster").hide("slow");
				
				$("#lbldateto").show("slow");
				$("#dateto").show("slow");
				
				$('#tabledetail tr *:nth-child(6)').css('display','none');
				$('#tabledetail tr *:nth-child(7)').css('display','none');
				$('#tabledetail tr *:nth-child(8)').css('display','');
				$('#tabledetail tr *:nth-child(9)').css('display','');
				$('#tabledetail tr *:nth-child(11)').css('display','');
			}
			else if ($('#typeform').val() == "2"){
				$("#expectedroster").show( "slow");
				$("#lblexpectedroster").show("slow");
				
				$("#expectedschedule").hide( "slow");
				$("#lblexpectedschedule").hide("slow");
				$("#lbldateto").hide("slow");
				$("#dateto").hide("slow");
				
				$('#tabledetail tr *:nth-child(6)').css('display','');
				$('#tabledetail tr *:nth-child(7)').css('display','');
				$('#tabledetail tr *:nth-child(8)').css('display','none');
				$('#tabledetail tr *:nth-child(9)').css('display','none');
				$('#tabledetail tr *:nth-child(11)').css('display','none');
			}
			else {
				$("#expectedroster").hide( "slow");
				$("#lblexpectedroster").hide("slow");
				$("#expectedschedule").hide( "slow");
				$("#lblexpectedschedule").hide("slow");
				
				$("#lbldateto").show("slow");
				$("#dateto").show("slow");
				
				$('#tabledetail tr *:nth-child(6)').css('display','none');
				$('#tabledetail tr *:nth-child(7)').css('display','none');
				$('#tabledetail tr *:nth-child(8)').css('display','none');
				$('#tabledetail tr *:nth-child(9)').css('display','none');
				$('#tabledetail tr *:nth-child(11)').css('display','');
			}
		});
		
		function process(date){
			var parts = date.split("/");
			return new Date(parts[2], parts[1] - 1, parts[0]);
		}
		
		<?php
		
		$this->session->set_userdata('l_outsource', 0);
		}
		
		?>
	</script>
	
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>