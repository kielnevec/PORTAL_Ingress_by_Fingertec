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
                                                                        <div id="tab_1-1" class="tab-pane active profile-classic row-fluid">
                                                                                <div style="height: auto;" id="accordion1-1" class="accordion collapse">
                                                                                <ul class="unstyled span10">
                                                                                        <li><span>Employee No:</span> <?php echo $userdata[0]['ic']; ?></li>
                                                                                        <li><span>First Name:</span> <?php echo $userdata[0]['name']; ?></li>
                                                                                        <li><span>Last Name:</span> <?php echo $userdata[0]['lastname']; ?></li>
                                                                                        <li><span>Email:</span> <?php echo $userdata[0]['Email']; ?></li>
                                                                                        <li><span>Gender:</span> <?php echo $userdata[0]['gender']; ?></li>
                                                                                        <li><span>Department:</span> <?php echo $userdata[0]['gName']; ?></li>
                                                                                        <li><span>Job Title:</span> <?php echo $userdata[0]['designation']; ?></li>
                                                                                </ul>
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