<!-- BEGIN PAGE CONTENT-->
<div class="row-fluid profile">
        <div class="span12">
                <!--BEGIN TABS-->
                <div class="tabbable tabbable-custom">
                        <div class="tab-content">
                                <!--tab_1_2-->
                                <div class="row-fluid profile-account" id="tab_1_3">
                                        <div class="row-fluid">
                                                <div class="span12">
                                                        <div class="span3">
                                                                <?php $this->load->view($sidebar_profile); ?>
                                                        </div>
                                                        <div class="span9">
                                                                <div class="tab-content">
                                                                        <div id="tab_3-3" class="tab-pane active profile-classic row-fluid">
                                                                                <div style="height: auto;" id="accordion3-3" class="accordion collapse">
                                                                                        
                                                                                        <?php
                                                                                        if($this->session->userdata('upass_err') != ""){
                                                                                        ?>
                                                                                            <div class="alert alert-error ">
                                                                                                <button class="close" data-dismiss="alert"></button>
                                                                                                <span><?php echo $this->session->userdata('upass_err'); ?></span>
                                                                                            </div>
                                                                                        <?php
                                                                                        }
                                                                                        else if($this->session->userdata('upass_success') != ""){
                                                                                        ?>
                                                                                            <div class="alert alert-success ">
                                                                                                <button class="close" data-dismiss="alert"></button>
                                                                                                <span><?php echo $this->session->userdata('upass_success'); ?></span>
                                                                                            </div>
                                                                                        <?php
                                                                                        }
                                                                                        echo form_open('user/update_pass');
                                                                                        
                                                                                        $this->session->unset_userdata('upass_err');
                                                                                        $this->session->unset_userdata('upass_success');
                                                                                        
                                                                                        ?>
                                                                                            
                                                                                                <label class="control-label">Current Password</label>
                                                                                                <input name="cpassword" type="password" class="m-wrap span8" />
                                                                                                
                                                                                                <label class="control-label">New Password</label>
                                                                                                <input name="newpassword" type="password" class="m-wrap span8" />
                                                                                                
                                                                                                <label class="control-label">Re-type New Password</label>
                                                                                                <input name="c_newpassword" type="password" class="m-wrap span8" />
                                                                                                </br>
                                                                                                <button type="submit" class="btn green">Submit</button>
                                                                                        
                                                                                </div>
                                                                        </div>
                                                                        
                                                                </div>
                                                        </div>
                                                        <!--end span9-->                                   
                                                </div>
                                        </div>
                                </div>
                                <!--end tab-pane-->
                        </div>
                </div>
                <!--END TABS-->
        </div>
</div>
<!-- END PAGE CONTENT-->