<!-- BEGIN BODY -->
<body class="login">
  <!-- BEGIN LOGO -->
  <div class="logo">
    <img src="<?php echo base_url() ?>assets/img/logo-big.png" alt="logo" /> 
  </div>
  <!-- END LOGO -->
  <!-- BEGIN LOGIN -->
  <div class="content">
    
    <?php $this->load->view($content); ?>
    
  </div>
<!-- END LOGIN -->
<!-- BEGIN COPYRIGHT -->
  <div class="copyright">
    2014 &copy; ESRNL. .
  </div>
  <!-- END COPYRIGHT -->
  <!-- BEGIN JAVASCRIPTS -->
  <script src="<?php echo base_url() ?>assets/js/jquery-1.8.3.min.js"></script>
  <script src="<?php echo base_url() ?>assets/bootstrap/js/bootstrap.min.js"></script>  
  <script src="<?php echo base_url() ?>assets/uniform/jquery.uniform.min.js"></script> 
  <script src="<?php echo base_url() ?>assets/js/jquery.blockui.js"></script>
  <script src="<?php echo base_url() ?>assets/js/app.js"></script>
  <script>
    jQuery(document).ready(function() {     
      App.initLogin();
    });
  </script>
  <!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>