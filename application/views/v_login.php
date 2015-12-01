  <!-- BEGIN LOGIN FORM -->
    <?php echo form_open('login/sign_in'); ?>
      <h3 class="form-title">Login to your account</h3>
      <?php
        if($this->session->userdata('noticebox') == "1"){
      ?>
      <div class="alert alert-success ">
        <button class="close" data-dismiss="alert"></button>
        <span>Verified Successful. Please to Login with your username & password.</span>
      </div>
      <?php
        }
        else if($this->session->userdata('noticebox') == "4"){
      ?>
      <div class="alert alert-error ">
        <button class="close" data-dismiss="alert"></button>
        <span>Incorrect Username Or Password.</span>
      </div>
      <?php
        }
        $this->session->unset_userdata('noticebox');
      ?>
      <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Email</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-user"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Staff No / Email" name="email"/>
          </div>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-lock"></i>
            <input class="m-wrap placeholder-no-fix" type="password" placeholder="Password" name="password"/>
          </div>
        </div>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn green pull-right">
        Login <i class="m-icon-swapright m-icon-white"></i>
        </button>            
      </div>
	  <!--
      <div class="forget-password">
        <h4>Forgot your password ?</h4>
        <p>
          no worries, click <a href="javascript:;" class="" id="forget-password">here</a>
          to reset your password.
        </p>
      </div>
      <div class="create-account">
        <p>
          Don't have an account yet ?&nbsp; 
          <a href="<?php echo base_url(). "index.php/register" ;?>" id="register-btn" class="">Create an account</a>
        </p>
        <p>
          Not received confirmation email ?&nbsp; 
          <a href="<?php echo base_url(). "index.php/resendcode" ;?>" id="register-btn" class="">Resend code</a>
        </p>
      </div>
	  -->
    </form>
    <!-- END LOGIN FORM -->        


