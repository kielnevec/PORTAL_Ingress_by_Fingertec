<!-- BEGIN PAGE CONTENT-->
	<?php
              if($this->session->userdata('noticebox') == "5"){
            ?>
            <div class="alert alert-success ">
              <button class="close" data-dismiss="alert"></button>
              <span>Success. Attendance Misspunch with OT has been removed</span>
            </div>
            <?php
		$this->session->unset_userdata('noticebox');
              }
            ?>
            <?php echo form_open('outsource/remove_ot/submit'); ?>
            <div class="row-fluid">
               <div class="span12">
                     <div class="tab-content">
                        <div>
                           <div class="portlet box blue">
                              <div class="portlet-title">
                                 <h4><i class="icon-reorder"></i>Remove OT Misspunch</h4>                            
                              </div>
                              <div class="portlet-body form">
                                <!-- BEGIN FORM-->
         
                                    <h3 class="form-section">Please to fill the Date</h3>
   
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" >Date From:</label>
                                             <div class="controls">
                                                 <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text" value="<?php echo set_value('leave_start'); ?>" name="leave_start"/>
                                                 <?php echo form_error('leave_start'); ?>
                                             </div>
                                             
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6">
                                          <div class="control-group">
                                             <label class="control-label" >Date To:</label>
                                             <div class="controls">
                                                <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text" value="<?php echo set_value('leave_end'); ?>" name="leave_end"/>
                                                <?php echo form_error('leave_end'); ?>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->
                                    
                                    
                                    <div class="form-actions">
                                       <button type="submit" class="btn blue">Submit</button>
                                       
                                    </div>
                                 </div>
                                 <!-- END FORM-->               
                              </div>
                           </div>
                        </div>
                   </div>      
                  </div>
               </div>
            </form>