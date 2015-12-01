<!-- BEGIN PAGE CONTENT-->
            <?php
              if($this->session->userdata('noticebox') == "5"){
            ?>
            <div class="alert alert-success ">
              <button class="close" data-dismiss="alert"></button>
              <span>Success. Request Form will be approve by IT Officer</span>
            </div>
            <?php
              }
            ?>
            <?php
            if($this->session->userdata('l_readonly') == 1){              
               echo form_open('outsource/approve/submit');
            }
            else{
               echo form_open('outsource/create/submit');
            }
            ?>
            <div class="row-fluid">
               <div class="span12">
                     <div class="tab-content">
                        <div>
                           <div class="portlet box red">
                              <div class="portlet-title">
                                 <h4><i class="icon-reorder"></i>
                                    <?php
                                    if($this->session->userdata('l_readonly') == 1){
                                       echo "Doc No : ".$headform[0]['docno'];
                                       $this->session->set_userdata('tmp_docno', $headform[0]['docno']);
                                       $this->session->set_userdata('tmp_typeform', $headform[0]['typeform']);
                                       
                                       if($headform[0]['status'] == 0){
                                          echo '    <span class="label label-warning label-mini">Pending</span>';
                                       }
                                       else if($headform[0]['status'] == 1){
                                          echo '    <span class="label label-success label-mini">Approve</span>';
                                       }
                                       else if($headform[0]['status'] == 2){
                                          echo '    <span class="label label-danger label-mini">Reject</span>';
                                       }
                                    }
                                    else{
                                       echo "Attendance Request Form";
                                    }
                                    ?>
                                 </h4>
                                 <?php                                              
                                              if($this->session->userdata('l_readonly') == 1 || $this->session->userdata('l_thismanage') == 1)
                                              {
                                 ?>
                                 <div class="actions">
                                        <div class="btn-group">
                                                <a class="btn white" href="#" data-toggle="dropdown">
                                                <i class="icon-cogs"></i> Tools
                                                <i class="icon-angle-down"></i>
                                                </a>
                                                <ul class="dropdown-menu pull-right">
                                                        <li><a href="<?php echo base_url() ?>index.php/outsource/manage/savepdf/<?php echo $headform[0]['docno'];?>">Save As PDF</a></li>
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
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" for="firstName">Date:</label>
                                             <div class="controls">
                                                <span class="text">
                                                <?php
                                                   if($this->session->userdata('l_readonly') == 1){
                                                      echo date('d-m-Y',strtotime($headform[0]['docdate']));
                                                   }
                                                   else{
                                                      echo date("d-m-Y");
                                                   }
                                                ?>
                                                </span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" for="lastName">Created By: </label>
                                             <div class="controls">
                                                <span class="text">
                                                <?php
                                                   if($this->session->userdata('l_readonly') == 1){
                                                      echo $headform[0]['Name']." ".$headform[0]['lastname'];
                                                   }
                                                   else{
                                                      echo $this->session->userdata('Name')." ".$this->session->userdata('lastname');
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
                                             <label class="control-label" >Form Type:</label>
                                             <div class="controls">
                                                <?php
                                                   if($this->session->userdata('l_readonly') == 1){
                                                    
                                                ?>
                                                   <span class="text"><?php echo $headform[0]['desc']; ?></span>
                                                   
                                                <?php
                                                   }
                                                   else {
                                                 ?>
                                                
                                                <select class="span8 m-wrap" data-placeholder="Choose a Category" id="typeform" name="typeform">
                                                   <option value="0">-SELECT-</option>
                                                   <?php
                                                   foreach ($typeform as $row) {
                                                   ?>
                                                      <option value="<?php echo $row['id']; ?>"><?php echo $row['desc']; ?></option>
                                                   <?php
                                                   }
                                                   ?>
                                                </select>
                                                <input type="hidden" name="tmptypeform" id="tmptypeform" />
                                                <?php
                                                   }
                                                   echo form_error('typeform'); ?>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" ></label>
                                             <div class="controls">
                                                <span class="text bold">
                                                   
                                                </span>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->        
                                    <?php
                                        if($this->session->userdata('l_readonly') != 0){
                                          
                                        }
                                        else{
                                          
                                    ?>
                                    <h3 class="form-section">Employee</h3>
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" >ID:</label>
                                             <div class="controls">
                                                <input class="m-wrap span6" type="text" value="" id="idemp" name="idemp">
                                                <a class="fancybox-button btn icn-only" data-fancybox-type="iframe" id="oslist" href="<?php echo base_url() ?>index.php/outsource/outsourcelist">
                                                <i class="icon-search"></i></a>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" >Full Name:</label>
                                             <div class="controls">                                                
                                                <input class="m-wrap span6" type="text" value="" id="firstname" name="firstname" readonly=true> <input class="m-wrap span6" type="text" value="" id="lastname" name="lastname" readonly=true>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    <!--/row-->
                                    
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" >Department:</label>
                                             <div class="controls">
                                                <input class="m-wrap span6" type="text" value="" id="dept" name="dept" readonly=true>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" >Current Roster:</label>
                                             <div class="controls">
                                                <input type="hidden" name="idroster" id="idroster" />
                                                <input class="m-wrap span6" type="text" value="" name="roster" id="roster" readonly=true>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    
                                    <div class="row-fluid">
                                       <div class="span12 ">
                                          <div class="control-group">
                                             <label class="control-label" id="lblexpectedroster">Expected Roster:</label>
                                             <label class="control-label" id="lblexpectedschedule">Expected Schedule:</label>
                                             <div class="controls">
                                               <select class="span4 m-wrap" data-placeholder="Choose a Category" id="expectedroster" name="expectedroster">
                                                   <option value="0">-SELECT-</option>
                                                   <?php
                                                   foreach ($roster as $row) {
                                                   ?>
                                                      <option value="<?php echo $row['idroster']."#|#".$row['rostername'] ?>"><?php echo $row['rostername'] ?></option>
                                                   <?php
                                                   }
                                                   ?>
                                                </select>
                                               <select class="span4 m-wrap" data-placeholder="Choose a Category" id="expectedschedule" name="expectedschedule">
                                                   <option value="0">-SELECT-</option>
                                                   <?php
                                                   foreach ($schedule as $row) {
                                                   ?>
                                                      <option value="<?php echo $row['idschedule']."#|#".$row['schedulename'] ?>"><?php echo $row['schedulename'] ?></option>
                                                   <?php
                                                   }
                                                   ?>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                     
                                    <div class="row-fluid">
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" >Date From:</label>
                                             <div class="controls">
                                                <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text" value="" id="datefrom" name="datefrom"/>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                       <div class="span6 ">
                                          <div class="control-group">
                                             <label class="control-label" id="lbldateto">Date To:</label>
                                             <div class="controls">                                                
                                                 <input class="m-wrap m-ctrl-medium date-picker" size="16" type="text" value="" id="dateto" name="dateto"/>
                                             </div>
                                          </div>
                                       </div>
                                       <!--/span-->
                                    </div>
                                    
                                    <div class="row-fluid">
                                       <div class="span8 ">
                                          <div class="control-group">
                                            <center>
                                            <button type="button" class="btn green" id="addline">Add to table</button>
                                            <button type="button" class="btn red" id="removeline">Remove row</button>
                                            </center>
                                          </div>
                                       </div>
                                    </div>
                          
                                    <?php
                                        }
                                        
                                       
                                    ?>
        
                                    <!--/row--> 
                                    <h3 class="form-section">Detail Form</h3>
                                    <table class="table table-bordered table-hover" id="tabledetail">
                                        <thead>
                                          <tr>
                                          <?php
                                            if($this->session->userdata('l_readonly') == 1)
                                            {
                                          ?>
                                                        <th># ID NO</th>
                                                        <th>Name</th>
                                                        <th>Dept</th>
                                                        <th>Id Roster</th>
                                                        <th>Roster</th>
                                                        <?php
                                                        if($headform[0]['typeform'] == 2){                                                         
                                                        ?>
                                                          <th >Id Plan Roster</th>
                                                          <th>Plan Roster</th>
                                                        <?php
                                                        }
                                                        else if($headform[0]['typeform'] == 1){   
                                                        ?>
                                                        <th>Id Plan Schdl</th>
                                                        <th>Name Schdl</th>                                                       
                                                        <?php
                                                        }
                                                        echo '<th>DateFrom</th>'; 
                                                        if($headform[0]['typeform'] != 2)
                                                        {
                                                        ?>
                                                        <th>DateTo</th>                                                                                                            
                                          <?php
                                                        }
                                            }
                                            else{                                                                                          
                                          ?>                                               
                                                        <th># ID NO</th>
                                                        <th>Name</th>
                                                        <th>Dept</th>
                                                        <th>Id Roster</th>
                                                        <th>Roster</th>
                                                        <th>Id Plan Roster</th>
                                                        <th>Plan Roster</th>
                                                        <th>Id Plan Schdl</th>
                                                        <th>Name Schdl</th>
                                                        <th>DateFrom</th>
                                                        <th>DateTo</th>
                                            <?php
                                            }
                                            ?>
                                                </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if($this->session->userdata('l_readonly') == 1)
                                            {
                                                foreach ($detilform as $row) {
                                                ?>
                                                <tr>
                                                  <td><?php echo $row['empid']; ?></td>
                                                  <td><?php echo $row['empname']; ?></td>
                                                  <td><?php echo $row['dept']; ?></td>
                                                  <td><?php echo $row['idroster']; ?></td>
                                                  <td><?php echo $row['nameroster']; ?></td>
                                                  <?php
                                                        if($headform[0]['typeform'] == 2){                                                         
                                                  ?>
                                                  <td><?php echo $row['idplnroster']; ?></td>
                                                  <td><?php echo $row['plnnameroster']; ?></td>
                                                  <?php
                                                        }
                                                        else if($headform[0]['typeform'] == 1){   
                                                  ?>
                                                  <td><?php echo $row['idplanschd']; ?></td>
                                                  <td><?php echo $row['plnnameschd']; ?></td>
                                                  <?php
                                                        }
                                                        echo '<td>'.date('d-m-Y',strtotime($row['datefrom'])).'</td>';
                                                        if($headform[0]['typeform'] != 2)
                                                        {
                                                  ?>
                                                  <td><?php echo date('d-m-Y',strtotime($row['dateto'])); ?></td>
                                                  <?php
                                                        }
                                                  ?>
                                                </tr>
                                                <?php
                                                }
                                            }
                                            ?>    
                                        </tbody>
                                </table>
                                  <br/>
                                    <div class="row-fluid">
                                       <div class="span10">
                                          <div class="control-group">
                                             <label class="control-label">Remark:</label>
                                             <div class="controls">
                                             <?php                                              
                                              if($this->session->userdata('form_status') != 0 || $this->session->userdata('l_thismanage') == 1)
                                              {
                                                echo $headform[0]['remark'];  
                                              }                                             
                                              else
                                              {
                                              ?>
                                               <textarea class="span9 wysihtml5 m-wrap" rows="4" name="remark" id="remark">                                                
                                                <?php
                                                if($this->session->userdata('l_readonly') == 1){
                                                echo $headform[0]['remark'];                                                
                                                }
                                                ?>
                                               </textarea>
                                               <?php
                                              }
                                               ?>
                                               <?php echo form_error('remark'); ?>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="form-actions">
                                       <?php
                                          if(($this->session->userdata('l_readonly') == 1) && ($headform[0]['status'] == 0) && ($this->session->userdata('l_thismanage') == 0)){
                                       ?>
                                       <button type="submit" name="btn" value="approve" class="btn green">Approve</button>
                                       <button type="submit" name="btn" value="reject" class="btn red">Reject</button>
                                       <?php
                                          }
                                          else if ($this->session->userdata('l_thismanage') != 0 || $this->session->userdata('l_readonly') != 0){
                                            
                                          }
                                          else{
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
            </form>
            <?php
              $this->session->unset_userdata('noticebox');
            ?>