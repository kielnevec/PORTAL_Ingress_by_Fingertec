<!-- BEGIN PAGE CONTENT-->
            <?php echo form_open("$formsubmit"); ?>
            <div class="row-fluid">
               <div class="span12">
                     <div class="tab-content">
                        <div>
                           <div class="portlet box blue">
                              <div class="portlet-title">
                                 <h4><i class="icon-reorder"></i><?php echo $pagetitle; ?></h4>                            
                              </div>
                              <div class="portlet-body form">
                                <!-- BEGIN FORM-->       
                                    <h3 class="form-section">Please to Select Period</h3>  
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">Year Period:</label>
                                             <div class="controls">
                                                <select class="span4 m-wrap" data-placeholder="Choose a Category" id="period" name="period">
                                                   <?php
                                                   foreach ($period as $row) {
                                                   ?>
                                                      <option value="<?php echo $row['years']?>"><?php echo $row['years'] ?></option>
                                                   <?php
                                                   }
                                                   ?>
                                                </select>
                                                
                                                 <?php echo form_error('period'); ?>
                                             </div>
                                             
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->                                  
                                    <div class="form-actions">
                                       <!--<button type="submit" name="exec" value="topdf" class="btn blue">Submit</button>-->
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