<?php
class dashboard extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->library('SimpleLoginSecure');
	$this->load->model('m_setting');
	if (!$this->session->userdata('logged_in')) {
            redirect('/login/');
        }
	$this->session->set_userdata('selectedmenu', '1');
	}
        
        function index(){
            $data['title'] = $this->m_setting->getSetting();
			$data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
			$data['pagetitle'] = "Dashboard";
            $data['content'] = "v_dashboard";
            $data['footer'] = "lyt_main/footer";		
	    $this->load->view('tpl_main', $data);
	    
        }
}
?>