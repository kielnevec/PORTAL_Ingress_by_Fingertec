<html><head>
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">

        <title>Gross Wages</title>

        <style type="text/css">

            body {
                font-family: sans-serif;
                font-size: 8pt;
                background: #fff;
                margin: 5px;
            }



        </style>

    </head>

    <body>

        <div id="header">
            <center>
            <img src="<?php echo base_url(); ?>assets/img/<?php echo $title[0]['logo']; ?>">
            </center>
        </div>
        <hr>

        <div id="status">
            <center>
                <strong><font size="4">Gross Wages Report</font><br/>
                <?php echo '['.$this->session->userdata('date1').'] - ['.$this->session->userdata('date2').']'; ?>
                </strong>
            </center>
        </div>
        <hr>

        <div id="content" style="margin: 5px">
            <table width="100%" border=1>
                <tr style="background-color: #cccccc" >
		    <td align="center">#NO</td>
                    <td align="center">#ID NO</td>
                    <td align="center">Employee Name</td>
		    <td align="center">Dept</td>
                    <td align="center">Rate</td>
                    <td align="center">Gross Wages</td>
                    <td align="center">Workday</td>
                    <td align="center">W_Wages</td>
                    <td align="center">OT</td>
                    <td align="center">OT_Wages</td>
                    <td align="center">Restday</td>
                    <td align="center">R_Wages</td>
                    <td align="center">Holiday</td>
                    <td align="center">H_Wages</td>
   
                </tr>
                <?php
			$i = 1;
                foreach ($grosswagesdetil as $row) {
                ?>
                <tr>
		  <td align="center"><?php echo $i; ?></td>	
                  <td align="center"><?php echo $row['userid']; ?></td>
                  <td align="center"><?php echo $row['EmployeeName']; ?></td>
		  <td align="center"><?php echo $row['Dept']; ?></td>
                  <td align="center"><?php echo $row['Rate']; ?></td>
                  <td align="center"><?php echo $row['GrossWages']; ?></td>
                  <td align="center"><?php echo $row['Worktime']; ?></td>
                  <td align="center"><?php echo $row['W_Wages']; ?></td>
                  <td align="center"><?php echo $row['OT']; ?></td>
                  <td align="center"><?php echo $row['OT_Wages']; ?></td>
                  <td align="center"><?php echo $row['Restday']; ?></td>
                  <td align="center"><?php echo $row['R_Wages']; ?></td>
                  <td align="center"><?php echo $row['Holiday']; ?></td>
                  <td align="center"><?php echo $row['H_Wages']; ?></td>
                </tr>
                <?php
				$i++;
                }
                ?>
            </table>
        </div>
        <hr>
         <div id="content" style="margin: 5px">
                <br/>
                <table width="35%" border=0>
                <?php
                foreach ($grosswagestotal as $row) {
                ?>              
                        <tr><td>Total GrossWages :  </td>
                        <td><?php echo $row['Gross']; ?></td></tr> 
                
                <?php
                }
                ?>
                </table>
        </div>        
        </hr>         
    </body>
</html>