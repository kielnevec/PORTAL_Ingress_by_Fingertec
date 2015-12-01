<?php 
class my404 extends CI_Controller 
{
	function __construct() {
        parent::__construct();
	}

    function index() 
    { 
        $this->output->set_status_header('404'); 
        //$data['content'] = 'error_404'; // View name 
        $this->load->view('error_404');//loading in my template 
    } 
} 
?> 