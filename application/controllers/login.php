<?php
class login extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->helper('file');
        $this->load->library('SimpleLoginSecure');
		$this->load->model('m_setting');
	}
	
	function index() {
		if ($this->session->userdata('logged_in')) {
		redirect('/dashboard/');	
		}
		
		$data['title'] = $this->m_setting->getSetting();
		$data['header'] = "lyt_login/header";
		$data['content'] = "v_login";	
		$this->load->view('tpl_front', $data);
	}
	
	//function create_user() {
	//    $this->simpleloginsecure->create('faisal.muhamad@esrnl.com', 'abcdef123?');
	//}
	
	function sign_in(){
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		if($this->simpleloginsecure->login($email, $password)){
			$this->session->set_userdata('selectedmenu', '1');
			redirect('/dashboard/');
		}
		else{
			$this->session->set_userdata('noticebox', '4');
			redirect('/login/');
		}
	}
	
	function logout() {
		$this->simpleloginsecure->logout();
		redirect('/login/');
	}

}
?>