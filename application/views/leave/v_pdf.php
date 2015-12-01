<html>
<head>
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
<?php
if ($this->session->userdata('flash_flag') == 1) {
    echo $Header;
} else {
    ?>
    <div id="header">
        <center>
            <img src="<?php echo base_url(); ?>assets/img/<?php echo $title[0]['logo']; ?>">
        </center>
    </div>

    <?php
}
?>
<hr>
<div id="status">
    <table width="100%">
        <tr>
            <td width="50%" style="padding: 0 20px">
                Doc No: <strong><?php echo $form[0]['leaveid']; ?></strong><br/>

                Doc Status: <strong><?php
                    if ($form[0]['docstatus'] == 0) {
                        ?>
                        Waiting Approval
                        <?php
                    } else if ($form[0]['docstatus'] == 1) {
                        ?>
                        Approved
                        <?php
                    } else if ($form[0]['docstatus'] == 2) {
                        ?>
                        Rejected
                        <?php
                    }
                    ?>
                </strong>
            </td>
            <td width="50%" style="padding: 0 20px">
                Doc Date: <strong><?php echo date('d-m-Y', strtotime($form[0]['docdate'])); ?></strong><br/>
                Printed Date: <strong><?php echo date('d-m-Y h:i:s'); ?></strong>
            </td>
        </tr>
    </table>
</div>
<hr>

<div id="content" style="margin: 50px">
    Staff No: <strong><?php echo $form[0]['ic']; ?></strong><br/><br/>
    Name: <strong><?php echo $form[0]['name'] . " " . $form[0]['lastname']; ?></strong><br/><br/>
    Gender: <strong><?php echo $form[0]['gender']; ?></strong><br/><br/>
    Dept: <strong><?php echo $form[0]['gName']; ?></strong><br/><br/>
    Job Title: <strong><?php echo $form[0]['designation']; ?></strong><br/><br/>
    <hr>
    <?php if ($this->session->userdata('leave') == 0) {
        ?>
        <center><u>I request to proceed on Leave as indicated below : </u></center><br/>
        Type of Leave: <strong><?php echo $form[0]['remark_type']; ?></strong><br/><br/>
        From:
        <strong><?php echo date('d-m-Y', strtotime($form[0]['leave_from'])) . " - " . date('d-m-Y', strtotime($form[0]['leave_to'])); ?></strong> (Both days inclusive)
        <br/><br/>
        Total days due: <strong><?php echo $form[0]['ann_leave_allw']; ?></strong><br/><br/>
        Total days taken: <strong><?php echo $form[0]['total_days']; ?></strong><br/><br/>
        Remark: <?php echo $form[0]['reason_leave']; ?><br/><br/>
        <?php
    } else if ($this->session->userdata('leave') == 1) { ?>
        Type of Form: <strong><?php echo $form[0]['remark_type']; ?></strong><br/><br/>
        Location: <strong><?php echo $form[0]['location']; ?></strong><br/><br/>
        From:
        <strong><?php echo date('d-m-Y', strtotime($form[0]['leave_from'])) . " - " . date('d-m-Y', strtotime($form[0]['leave_to'])); ?></strong> (Both days inclusive)
        <br/><br/>
        Total days taken: <strong><?php echo $form[0]['total_days']; ?></strong><br/><br/>
        Remark: <?php echo $form[0]['reason_leave']; ?><br/><br/>
        <?php
    }
    if ($form[0]['docstatus'] != 0) {
        ?>
        <hr>
        <center><u>Application approved / not approved by : </u></center>
        <br/>
        Authorized by: <strong><?php echo $form[0]['appname'] . " " . $form[0]['applastname']; ?></strong><br/><br/>
        Date: <strong><?php if ($form[0]['app_date'] != '') {
                echo date('d-m-Y', strtotime($form[0]['app_date']));
            } ?></strong><br/><br/>
        Remark: <strong><?php echo $form[0]['appv_comment']; ?></strong><br/><br/>
        <?php
    }
    ?>
</div>
</body>
</html>