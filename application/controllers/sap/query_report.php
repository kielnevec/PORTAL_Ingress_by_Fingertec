<?php

class query_report extends CI_Controller {

    function __construct() {
        parent::__construct();
 	if (!$this->session->userdata('logged_in')) {
            redirect('/login/');
        }
	$this->load->model('m_setting');
	$this->load->model('m_sap');
	$this->load->helper('to_excel');
    }
    
    function summary() {               
            $data['title'] = $this->m_setting->getSetting();
	    $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
	    $data['pagetitle'] = "Query";
            $data['content'] = "sap/v_form";
            $data['footer'] = "lyt_main/footer";
	    $this->load->view('tpl_main', $data);        
    }
    
    function submit_summary() {
	    $this->load->library('form_validation');
	
	    $leave_start = $this->input->post('leave_start');
	    $leave_end = $this->input->post('leave_end');
	    $this->form_validation->set_rules('leave_start', 'Date From', 'required|callback_checkdates');
	    $this->form_validation->set_rules('leave_end', 'Date to', 'required');
	    
	    $this->form_validation->set_error_delimiters('<span class="help-block" style="color:red">', '</span>');
	    
	    if($this->form_validation->run() == FALSE){
		$this->index();   
	    }
	    else{
                $date1 = date('Y-m-d', strtotime(str_replace('/', '-', $leave_start)));
                $date2 = date('Y-m-d', strtotime(str_replace('/', '-', $leave_end)));
		$data['title'] = $this->m_setting->getSetting();
                $data['sap_query'] = $this->m_sap->getreportMonitoring($date1,$date2);
                $data['head'] = "lyt_main/head";
                $data['header'] = "lyt_main/header";
                $data['sidebar'] = "lyt_main/sidebar";
                $data['pagetitle'] = "Query Monitoring";
                $data['content'] = "sap/v_querymonitoring";
                $data['footer'] = "lyt_main/footer";
                $this->load->view('tpl_main', $data);
		$this->session->set_userdata('date1', $date1);
		$this->session->set_userdata('date2', $date2);
	    }   
    }
    
    function checkdates(){
	    $leave_start = $this->input->post('leave_start');
	    $leave_end = $this->input->post('leave_end');
	    
	    $date1 = date_create(date('Y-m-d', strtotime(str_replace('/', '-', $leave_start))));
	    $date2 = date_create(date('Y-m-d', strtotime(str_replace('/', '-', $leave_end))));
	    
	    $diff=date_diff($date1,$date2);
	    $str = $diff->format("%R%a");
	    
	    if(substr_count($str,"-") == 0){
		return TRUE;
	    }
	    else{
		$this->form_validation->set_message('checkdates','Please check "Date from" & "Date to" is incorrect');
		return FALSE;		
	    }
    }
    
    
    
}

?>