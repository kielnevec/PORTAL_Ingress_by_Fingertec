<?php

class apply_user extends CI_Controller {

    function __construct() {
        parent::__construct();
 	if (!$this->session->userdata('logged_in')) {
            redirect('/login/');
        }
	$this->load->model('m_setting');
	$this->load->model('m_user');
	$this->load->model('m_leave');
    }

    function index() {
            $data['title'] = $this->m_setting->getSetting();
	    
	    $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
	    $data['pagetitle'] = "Apply Form for staff";
            $data['content'] = "leave/v_applyuser";
            $data['footer'] = "lyt_main/footer";
	    $this->load->view('tpl_main', $data);  
    }
    
    function submit(){
            $empid = $this->m_user->validEmpId($this->input->post('empid'));
	    $formtype = $this->input->post('formtype');
            
            if($empid == 0)
            {
                $this->session->set_userdata('applyuser', '1');
                $this->index();
            }
            else{
		if($formtype == '1'){
		   $this->session->set_userdata('applyuser', '9');
		    redirect('/eform/apply/user/'.$empid); 
		}
		else if($formtype == '2'){
		    $this->session->set_userdata('applyuser', '9');
		    redirect('/eform/apply_amendment/user/'.$empid); 
		}
		else if($formtype == '3') {
		    $this->session->set_userdata('applyuser', '9');
		    redirect('/eform/apply_fieldwork/user/'.$empid); 
		}
		else
		{
		   $this->index();
		}
                
            }
    }
}
?>