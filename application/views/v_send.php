    <!-- BEGIN FORGOT PASSWORD FORM -->
    <?php echo form_open('register/validate_email'); ?>
      <h3 class="">Resend Confirmation Email ?</h3>
      <?php
        if($this->session->userdata('noticebox') == "2"){
      ?>
      <div class="alert alert-error">
        <button class="close" data-dismiss="alert"></button>
        <span>Email Address is not valid</span>
      </div>
      <?php
        }
        else if($this->session->userdata('noticebox') == "1"){
      ?>
        <div class="alert alert-success">
        <button class="close" data-dismiss="alert"></button>
        <span>Confirmation Email address has been sent to your email. Please check in your inbox or spam</span>
      </div>
      <?php
        }
        $this->session->unset_userdata('noticebox');
      ?>
      <p>Enter your e-mail address below to resend confirmation email.</p>
      <div class="control-group">
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-envelope"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Email" name="email" />
          </div>
        </div>
      </div>
      <div class="form-actions">
        <a href = <?php echo base_url() ?>
        <button type="button" id="back-btn" class="btn">
        <i class="m-icon-swapleft"></i> Back
        </button>
        </a>
        <button type="submit" class="btn green pull-right">
        Submit <i class="m-icon-swapright m-icon-white"></i>
        </button>            
      </div>
    </form>
    <!-- END FORGOT PASSWORD FORM --> 