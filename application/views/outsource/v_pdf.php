<html><head>
        <meta content="text/html; charset=UTF-8" http-equiv="content-type">

        <title>Printed document</title>

        <style type="text/css">

            body {
                font-family: sans-serif;
                font-size: 10pt;
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
            <table width="100%">
                <tr>
                    <td width="50%" style="padding: 0 20px">
                        Doc No: <strong><?php echo $headform[0]['docno'] ;?></strong><br/>
                        Doc Date: <strong><?php echo date('d-m-Y',strtotime($headform[0]['docdate']));?></strong><br/>
                        Doc Status: <strong><?php
                                                    if($headform[0]['status'] == 0){
                                                    ?>
                                                    Pending
                                                    <?php
                                                    }
                                                    else if ($headform[0]['status'] == 1){
                                                    ?>
                                                   Complete
                                                    <?php
                                                    }
                                                    else if ($headform[0]['status'] == 2){
                                                    ?>
                                                   Reject
                                                    <?php
                                                    }
                                                    ?>
                                                    </strong>                       
                    </td>
                    <td width="50%" style="padding: 0 20px">
                        Doc Type: <strong><?php echo $headform[0]['desc'] ;?></strong><br/>
                        Created By: <strong><?php echo $headform[0]['Name']." ".$headform[0]['lastname'];?></strong><br/>
                        Printed Date: <strong><?php echo date('d-m-Y h:i:s') ;?></strong>
                    </td>
                </tr>
            </table>
        </div>
        <hr>

        <div id="content" style="margin: 5px">
            <table width="100%" border=1>
                <tr style="background-color: #cccccc">
                    <td align="center"># ID NO</td>
                    <td align="center">Name</td>
                    <td align="center">Dept</td>
                    <td align="center">Id Roster</td>
                    <td align="center">Roster</td>
                    <?php
                    if($headform[0]['typeform'] == 2){                                                         
                    ?>
                      <td align="center">Id Plan Roster</td>
                      <td align="center">Plan Roster</td>
                      <td align="center">DateFrom</td> 
                    <?php
                    }
                    else if($headform[0]['typeform'] == 1){   
                    ?>
                    <td align="center">Id Plan Schdl</td>
                    <td align="center">Name Schdl</td>
                    <td align="center">DateFrom</td> 
                    <?php
                    }
                    if($headform[0]['typeform'] != 2)
                    {
                    ?>
                    <td align="center">DateTo</td>
                    <?php
                    }
                    ?>
                </tr>
                <?php
                foreach ($detilform as $row) {
                ?>
                <tr>
                  <td align="center"><?php echo $row['empid']; ?></td>
                  <td align="center"><?php echo $row['empname']; ?></td>
                  <td align="center"><?php echo $row['dept']; ?></td>
                  <td align="center"><?php echo $row['idroster']; ?></td>
                  <td align="center"><?php echo $row['nameroster']; ?></td>
                  <?php
                        if($headform[0]['typeform'] == 2){                                                         
                  ?>
                  <td align="center"><?php echo $row['idplnroster']; ?></td>
                  <td align="center"><?php echo $row['plnnameroster']; ?></td>
                  <td align="center"><?php echo date('d-m-Y',strtotime($row['datefrom'])); ?></td>
                  <?php
                        }
                        else if($headform[0]['typeform'] == 1){   
                  ?>
                  <td align="center"><?php echo $row['idplanschd']; ?></td>
                  <td align="center"><?php echo $row['plnnameschd']; ?></td>
                  <td align="center"><?php echo date('d-m-Y',strtotime($row['datefrom'])); ?></td>
                  <?php
                        }
                        if($headform[0]['typeform'] != 2)
                        {
                  ?>
                  <td align="center"><?php echo date('d-m-Y',strtotime($row['dateto'])); ?></td>
                  <?php
                        }
                  ?>
                </tr>
                <?php
                }
                ?>
            </table>
        </div>
        <hr>
        <div id="footer">
            Remark : <?php echo $headform[0]['remark'] ;?>
        </div>
        <hr>         
    </body>
</html>