<!-- BEGIN PAGE CONTENT-->
            <?php echo form_open('eform/apply_user/submit'); ?>
            <div class="row-fluid">
               <div class="span12">
                     <div class="tab-content">
                        <div>
                           <div class="portlet box blue">
                              <div class="portlet-title">
                                 <h4><i class="icon-reorder"></i>Apply Form for employees</h4>                            
                              </div>
                              <div class="portlet-body form">
                                <!-- BEGIN FORM-->         
                                    <h3 class="form-section">Please input the employees id</h3>  
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" >INGRESS ID:</label>
                                             <div class="controls">
                                                 <input size="16" type="text" value="" name="empid"/>
                                                 <?php if ($this->session->userdata('applyuser') == 1) {
                                                      echo '<font color="red">Employee ID is wrong</font>';
                                                      $this->session->unset_userdata('applyuser');
                                                  }?>
                                             </div>
                                             
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" >Form Type:</label>
                                             <div class="controls">
                                                 <select class="span8 m-wrap" data-placeholder="Choose a Category" name="formtype">
                                                   <option value="1">Leave</option>
                                                   <option value="2">Amendment</option>
                                                   <option value="3">Field Work</option>
                                                 </select>
                                                 <?php if ($this->session->userdata('applyuser') == 1) {
                                                      echo '<font color="red">Employee ID is wrong</font>';
                                                      $this->session->unset_userdata('applyuser');
                                                  }?>
                                             </div>
                                             
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->
                                    
                                    
                                    <div class="form-actions">
                                       <button type="submit" name="exec" value="topdf" class="btn blue">Submit</button>
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