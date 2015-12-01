<?php
class user extends CI_Controller {
	function __construct() {
        parent::__construct();
        $this->load->library('SimpleLoginSecure');
	$this->load->model('m_setting');
	$this->load->model('m_user');	
            if (!$this->session->userdata('logged_in')) {
                redirect('/login/');
            }
	}
        
        function index(){
            $id = $this->session->userdata('userid');            
            $data['userdata'] = $this->m_user->getUserdata($id);
            $data['title'] = $this->m_setting->getSetting();
	    $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
	    $data['sidebar_profile'] = "lyt_main/sidebar_profile";
	    $data['pagetitle'] = "My Profile";
            $data['content'] = "dashboard/v_myprofile";
            $data['footer'] = "lyt_main/footer";		
	    $this->load->view('tpl_main', $data);
        }
	
	function updatepassword(){
	    $email = $this->session->userdata('Email');            
            $data['title'] = $this->m_setting->getSetting();
	    $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
	    $data['sidebar_profile'] = "lyt_main/sidebar_profile";
	    $data['pagetitle'] = "Update Password";
            $data['content'] = "dashboard/v_chpassword";
            $data['footer'] = "lyt_main/footer";		
	    $this->load->view('tpl_main', $data);
	}
	
	function update_pass() {
		$email = $this->session->userdata('Email');
		$old_pass = $this->input->post('cpassword');
		$new_pass = $this->input->post('newpassword');
		$confirm = $this->input->post('c_newpassword');
		
		if($old_pass == "" || $new_pass == "")
		{
			$this->session->set_userdata('upass_err', 'Please fill all fields');
			redirect('/user/updatepassword/');
		}
		else if ($this->simpleloginsecure->login($email, $old_pass) == false)
		{
			$this->session->set_userdata('upass_err', 'Current Password is Wrong');
			redirect('/user/updatepassword/');
		}
		else if($new_pass != $confirm){
			$this->session->set_userdata('upass_err', 'New Password & Confirmation Password is not same');
			redirect('/user/updatepassword/');
			
		}
		else if (strlen($new_pass) < 6)
		{
			$this->session->set_userdata('upass_err', 'Min Password is 7 Characters');
			redirect('/user/updatepassword/');
		}
		else
		{
			$this->simpleloginsecure->edit_password($email, $old_pass, $new_pass);
			$this->session->set_userdata('upass_success', 'Success Your Password Has Been Updated');
			redirect('/user/updatepassword/');
		}
	}
}
?>