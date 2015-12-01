<!-- BEGIN REGISTRATION FORM  -->

    <?php echo form_open('register/processing'); ?>
      <h3 class="">Sign Up</h3>
      
      <?php
        if($this->session->userdata('noticebox') == "3"){
      ?>
      <div class="alert alert-success ">
        <button class="close" data-dismiss="alert"></button>
        <span>Thank you. A confirmation email has been sent to "your email address". Please click on the verification link in that email to complete the sign up process</span>
      </div>
      <?php
        }
        $this->session->unset_userdata('noticebox');
      ?>
      
      <p>Enter your account details below:</p>
      
      <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Email</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-envelope"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Email" name="email" value="<?php if($this->session->userdata('email')){echo $this->session->userdata('email');} ?>"/>
            
          </div>
          <?php echo form_error('email'); ?>
        </div>
      </div>
      
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-lock"></i>
            <input class="m-wrap placeholder-no-fix" type="password" id="register_password" placeholder="Password" name="password"/>
            
          </div>
          <?php echo form_error('password'); ?>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-ok"></i>
            <input class="m-wrap placeholder-no-fix" type="password" placeholder="Re-type Your Password" name="rpassword"/>
            
          </div>
          <?php echo form_error('rpassword'); ?>
        </div>
      </div>

      <div class="control-group">
        <div class="controls">
          <center>
          <label class="checkbox">
          <input type="checkbox" name="tnc" value="yes"/>I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
          </label>
          </center>
        </div>
        <?php echo form_error('tnc'); ?>
      </div>
      <div class="form-actions">
        <a href="<?php echo base_url() ?>">
        <button id="register-back-btn" type="button" class="btn">
        <i class="m-icon-swapleft"></i>  Back
        </button>
        </a>
        <input type="submit" class="btn green pull-right" value="Sign Up" />
                  
      </div>
    </form>
<!-- END REGISTRATION FORM -->	