<!-- BEGIN PAGE CONTENT-->
<?php
if ($this->session->userdata('noticebox') == "5") {
    ?>
    <div class="alert alert-success ">
        <button class="close" data-dismiss="alert"></button>
        <span>Success. Your document will be approved by your HOD</span>
    </div>
    <?php
} else {
    ?>
    <?php
    if ($this->session->userdata('l_readonly') == 1) {
        echo form_open('eform/approve/submit');
    } else {
        if ($this->session->userdata('leave') == 0) {
            echo form_open('eform/apply/submit');
        } else if ($this->session->userdata('leave') == 1) {
            echo form_open('eform/apply_fieldwork/submit');
        } else if ($this->session->userdata('leave') == 2) {
            echo form_open('eform/apply_amendment/submit');
        }
    }
    ?>
    <div class="row-fluid">
    <div class="span12">
        <div class="tab-content">
            <div>
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <h4><i class="icon-reorder"></i>
                            <?php
                            if ($this->session->userdata('l_readonly') == 1) {
                                echo "Doc No : " . $eleave[0]['leaveid'];

                                if ($eleave[0]['docstatus'] == 0) {
                                    echo '    <span class="label label-warning label-mini">Waiting Approval</span>';
                                } else if ($eleave[0]['docstatus'] == 1) {
                                    echo '    <span class="label label-success label-mini">Approved</span>';
                                } else if ($eleave[0]['docstatus'] == 2) {
                                    echo '    <span class="label label-danger label-mini">Rejected</span>';
                                }
                            } else {
                                echo "Apply Form";
                            }
                            ?>
                        </h4>
                        <?php
                        if ($this->session->userdata('l_readonly') == 1 || $this->session->userdata('l_thismanage') == 1) {
                            ?>
                            <div class="actions">
                                <div class="btn-group">
                                    <a class="btn white" href="#" data-toggle="dropdown">
                                        <i class="icon-cogs"></i> Tools
                                        <i class="icon-angle-down"></i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a href="<?php echo base_url() ?>index.php/eform/manage/savepdf/<?php echo $eleave[0]['leaveid']; ?>">Save
                                                As PDF</a></li>
                                    </ul>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <div class="portlet-body form">
                        <!-- BEGIN FORM-->
                        <div class="form-horizontal form-view">
                            <div class="row-fluid">
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label" for="firstName">Name:</label>

                                        <div class="controls">
                                                <span class="text">
                                                <?php
                                                if ($this->session->userdata('l_readonly') == 1) {
                                                    echo $eleave[0]['name'] . " " . $eleave[0]['lastname'];
                                                } else {
                                                    echo $userdata[0]['name'] . " " . $userdata[0]['lastname'];
                                                }
                                                ?>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label" for="lastName">Date:</label>

                                        <div class="controls">
                                                <span class="text">
                                                <?php
                                                if ($this->session->userdata('l_readonly') == 1) {
                                                    echo date('d-m-Y', strtotime($eleave[0]['docdate']));
                                                } else {
                                                    echo date("d-m-Y");
                                                }
                                                ?>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label">Gender:</label>

                                        <div class="controls">
                                                <span class="text">
                                                   <?php
                                                   if ($this->session->userdata('l_readonly') == 1) {
                                                       echo $eleave[0]['gender'];
                                                   } else {
                                                       echo $userdata[0]['gender'];
                                                   }
                                                   ?>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label">Staff No:</label>

                                        <div class="controls">
                                                <span class="text bold">
                                                   <?php
                                                   if ($this->session->userdata('l_readonly') == 1) {
                                                       echo $eleave[0]['ic'];
                                                   } else {
                                                       echo $userdata[0]['ic'];
                                                   }
                                                   ?>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label">Department:</label>

                                        <div class="controls">
                                                <span class="text bold">
                                                   <?php
                                                   if ($this->session->userdata('l_readonly') == 1) {
                                                       echo $eleave[0]['gName'];
                                                   } else {
                                                       echo $userdata[0]['gName'];
                                                   }
                                                   ?>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label">Job Title:</label>

                                        <div class="controls">
                                                <span class="text bold">
                                                   <?php
                                                   if ($this->session->userdata('l_readonly') == 1) {
                                                       echo $eleave[0]['designation'];
                                                   } else {
                                                       echo $userdata[0]['designation'];
                                                   }
                                                   ?>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->

                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label">Date Of Employement:</label>

                                        <div class="controls">
                                                <span class="text bold">
                                                   <?php
                                                   if ($this->session->userdata('l_readonly') == 1) {
                                                       echo date('d/m/Y', strtotime(str_replace('-', '/', $eleave[0]['IssueDate'])));
                                                   } else {
                                                       echo date('d/m/Y', strtotime(str_replace('-', '/', $userdata[0]['IssueDate'])));
                                                   }
                                                   ?>
                                                </span>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="span6 ">
                                    <div class="control-group">

                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->

                            <h3 class="form-section">Detail</h3>
                            <?php
                            if ($this->session->userdata('leave') == 0) {
                                ?>
                                <div class="row-fluid">
                                    <div class="span6 ">
                                        <div class="control-group">
                                            <label class="control-label">Alt Contact No:</label>

                                            <div class="controls">
                                                <?php
                                                if ($this->session->userdata('l_readonly') == 1) {
                                                    ?>
                                                    <span class="text"><?php echo $eleave[0]['contact_no']; ?></span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <input type="text" class="m-wrap span12" name="phone"
                                                           value="<?php echo set_value('phone'); ?>">
                                                    <?php echo form_error('phone');
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span5 ">
                                        <div class="control-group">
                                            <label class="control-label">Form Type:</label>

                                            <div class="controls">
                                                <?php
                                                if ($this->session->userdata('l_readonly') == 1) {
                                                    ?>
                                                    <span class="text"><?php echo $eleave[0]['remark_type']; ?></span>
                                                    <?php
                                                } else {
                                                    ?>

                                                    <select class="span8 m-wrap" data-placeholder="Choose a Category"
                                                            name="leavetype">
                                                        <?php
                                                        foreach ($leave as $row) {

                                                            ?>
                                                            <option <?php if (set_value('leavetype') == $row['idleavetype'] . "|" . $row['leavetypename']) {
                                                                echo "selected";
                                                            } ?>value="<?php echo $row['idleavetype'] . "|" . $row['leavetypename']; ?>"><?php echo $row['leavetypename'] ?></option>
                                                            <?php

                                                        }
                                                        ?>
                                                    </select>
                                                    <?php
                                                }
                                                echo form_error('leavetype'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } else if ($this->session->userdata('leave') == 1) {
                                ?>
                                <div class="row-fluid">
                                    <div class="span6 ">
                                        <div class="control-group">
                                            <label class="control-label">Location:</label>

                                            <div class="controls">
                                                <?php
                                                if ($this->session->userdata('l_readonly') == 1) {
                                                    ?>
                                                    <span class="text"><?php echo $eleave[0]['location']; ?></span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <input size="16" class="m-wrap span8" type="text" value=""
                                                           name="location"/>
                                                    <?php echo form_error('location');
                                                } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if ($this->session->userdata('l_readonly') == 1) {
                                        ?>
                                        <div class="span6 ">
                                            <div class="control-group">
                                                <label class="control-label">Form Type:</label>

                                                <div class="controls">
                                                    <span class="text"><?php echo $eleave[0]['remark_type']; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>

                                <?php
                            }
                            ?>


                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label">From:</label>

                                        <div class="controls">
                                            <?php
                                            if ($this->session->userdata('l_readonly') == 1) {
                                                ?>
                                                <span
                                                    class="text"><?php echo date('d/m/Y', strtotime(str_replace('-', '/', $eleave[0]['leave_from']))); ?></span>
                                                <?php
                                            } else {
                                                ?>
                                                <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text"
                                                       value="<?php echo set_value('leave_start'); ?>"
                                                       name="leave_start"/>
                                                <?php echo form_error('leave_start');
                                            }
                                            ?>
                                        </div>

                                    </div>
                                </div>
                                <!--/span-->
                                <div class="span6">
                                    <div class="control-group">
                                        <label class="control-label">To:</label>

                                        <div class="controls">
                                            <?php
                                            if ($this->session->userdata('l_readonly') == 1) {
                                                ?>
                                                <span
                                                    class="text"><?php echo date('d/m/Y', strtotime(str_replace('-', '/', $eleave[0]['leave_to']))); ?></span>
                                                <?php
                                            } else {
                                                ?>
                                                <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text"
                                                       value="<?php echo set_value('leave_end'); ?>" name="leave_end"/>
                                                <?php
                                            }
                                            echo form_error('leave_end'); ?>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <!--/row-->
                            <?php
                            if ($this->session->userdata('leave') == 0){
                                ?>
                                <div class="row-fluid">
                                    <div class="span6 ">
                                        <div class="control-group">
                                            <label class="control-label">Total leave balance:</label>

                                            <div class="controls">
                                                <?php
                                                if ($this->session->userdata('l_readonly') == 1) {
                                                    ?>
                                                    <span
                                                        class="text"><?php echo $eleave[0]['ann_leave_allw']; ?></span>
                                                    <?php
                                                } else {
                                                    ?>
                                                    <span
                                                        class="text"><?php echo $userdata[0]['Annual_Remaining']; ?></span>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>

                                    <!--/span-->
                                    <?php
                                    if ($this->session->userdata('l_readonly') == 1) {
                                        ?>

                                        <div class="span6 ">
                                            <div class="control-group">
                                                <label class="control-label">Total days taken:</label>

                                                <div class="controls">
                                                    <span class="text"><?php echo $eleave[0]['total_days']; ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                            }
                            else if ($this->session->userdata('leave') == 2){

                            ?>

                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label">Time In (24 Hrs):</label>

                                        <div class="controls">
                                            <?php if ($this->session->userdata('l_readonly') == 1) {
                                                ?>
                                                <span class="text"><?php echo $eleave[0]['timein']; ?></span>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="input-append bootstrap-timepicker-component">
                                                    <input class="m-wrap m-ctrl-small timepicker-24" type="text"
                                                           name="timein"/>
                                                    <span class="add-on"><i class="icon-time"></i></span>
                                                    <?php echo form_error('timein'); ?>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label">Time Out (24 Hrs):</label>

                                        <div class="controls">
                                            <?php if ($this->session->userdata('l_readonly') == 1) {
                                                ?>
                                                <span class="text"><?php echo $eleave[0]['timeout']; ?></span>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="input-append bootstrap-timepicker-component">
                                                    <input class="m-wrap m-ctrl-small timepicker-24" type="text"
                                                           name="timeout"/>
                                                    <span class="add-on"><i class="icon-time"></i></span>
                                                    <?php echo form_error('timeout'); ?>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if ($this->session->userdata('l_readonly') == 1){
                            ?>
                            <div class="row-fluid">
                                <div class="span6 ">
                                    <div class="control-group">
                                        <label class="control-label">Total Workday:</label>

                                        <div class="controls">
                                            <span class="text"><?php echo $eleave[0]['timein']; ?></span>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                }
                                }
                                else if ($this->session->userdata('leave') == 1){
                                if ($this->session->userdata('l_readonly') == 1){
                                ?>
                                <div class="row-fluid">
                                    <div class="span6 ">
                                        <div class="control-group">
                                            <label class="control-label">Total Days Taken:</label>

                                            <div class="controls">
                                                              <span
                                                                  class="text"><?php echo $eleave[0]['total_days']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                    }
                                    ?>
                                    <!--/span-->
                                    <div class="row-fluid">
                                        <div class="span10">
                                            <div class="control-group">
                                                <label class="control-label">Reason:</label>

                                                <div class="controls">
                                                    <?php
                                                    if ($this->session->userdata('form_status') != 0 || $this->session->userdata('l_readonly') == 1) {
                                                        echo '<span class="text">' . $eleave[0]['reason_leave'] . '</span>';
                                                    } else {
                                                        ?>
                                                        <textarea class="span9 wysihtml5 m-wrap" rows="4" name="reason"
                                                                  id="reason">
                                                
                                               </textarea>
                                                        <?php
                                                    }
                                                    ?>
                                                    <?php echo form_error('reason'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    if ($this->session->userdata('l_readonly') == 1){
                                    ?>
                                    <h3 class="form-section">Approval</h3>

                                    <div class="row-fluid">
                                        <div class="row-fluid">
                                            <div class="span8 ">
                                                <div class="control-group">
                                                    <label class="control-label">Authorized by:</label>

                                                    <div class="controls">
                                                        <span
                                                            class="text"><?php echo $eleave[0]['appname'] . " " . $eleave[0]['applastname']; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row-fluid">
                                            <div class="span12 ">
                                                <div class="control-group">
                                                    <label class="control-label">Remark:</label>

                                                    <div class="controls">
                                                        <?php
                                                        if (($eleave[0]['docstatus'] == 0) && ($this->session->userdata('userid') == $eleave[0]['Approver']) && $this->session->userdata('l_thismanage') == "0") {
                                                            ?>

                                                            <input type="text" class="m-wrap span12" name="app_comment"
                                                                   value="<?php //echo set_value('reason');
                                                                   ?>">
                                                            <?php echo form_error('app_comment');
                                                        } else if ($eleave[0]['docstatus'] != 0) {
                                                            ?>

                                                            <span
                                                                class="text"><?php echo $eleave[0]['appv_comment']; ?></span>

                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                                <!--/row-->

                                <div class="form-actions">
                                    <?php
                                    if (($this->session->userdata('l_readonly') == 1) && ($eleave[0]['docstatus'] == 0) && $this->session->userdata('l_thismanage') == 0 && ($this->session->userdata('userid') == $eleave[0]['Approver'])) {
                                        ?>
                                        <button type="submit" name="btn" value="approve" class="btn green">Approve
                                        </button>
                                        <button type="submit" name="btn" value="reject" class="btn red">Reject</button>
                                        <?php
                                    } else if (($this->session->userdata('l_thismanage') == 1)) {

                                    } else {
                                        ?>
                                        <button type="submit" class="btn blue">Submit</button>
                                        <button type="button" class="btn">Cancel</button>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <!-- END FORM-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
}
$this->session->unset_userdata('noticebox');
?>