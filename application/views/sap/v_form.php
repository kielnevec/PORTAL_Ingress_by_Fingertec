<!-- BEGIN PAGE CONTENT-->
            <?php echo form_open('sap/query_report/submit_summary'); ?>
            <div class="row-fluid">
               <div class="span12">
                     <div class="tab-content">
                        <div>
                           <div class="portlet box blue">
                              <div class="portlet-title">
                                 <h4><i class="icon-reorder"></i>Query Monitoring</h4>                            
                              </div>
                              <div class="portlet-body form">
                                <!-- BEGIN FORM-->
         
                                    <h3 class="form-section">Please to fill parameter</h3>
   
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