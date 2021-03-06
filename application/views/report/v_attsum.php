<!-- BEGIN PAGE CONTENT-->
            <?php echo form_open('report/att_sum/submit'); ?>
            <div class="row-fluid">
               <div class="span12">
                     <div class="tab-content">
                        <div>
                           <div class="portlet box blue">
                              <div class="portlet-title">
                                 <h4><i class="icon-reorder"></i>Attendance Summary Report</h4>                            
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
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">Category:</label>
                                             <div class="controls">
                                                <select class="span4 m-wrap" data-placeholder="Choose a Category" id="cat" name="cat">
                                                   <?php
                                                   foreach ($category as $row) {
                                                   ?>
                                                      <option value="<?php echo $row['id']?>"><?php echo $row['gName'] ?></option>
                                                   <?php
                                                   }
                                                   ?>
                                                </select>
                                                
                                                 <?php echo form_error('cat'); ?>
                                             </div>
                                             
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    
                                    <div class="form-actions">
                                       <button type="submit" name="exec" value="toexcel" class="btn green">Export to Excel</button>
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