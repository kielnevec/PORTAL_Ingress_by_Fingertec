<?php
/**
 * ESRNL PORTAL
 *
 * Copyright (C) 2014 - 2015  Muhamad Faisal.
 *
 * @package    	ESRNL PORTAL
 * @version    	1.0
 * @author     	Muhamad Faisal <deihororo@gmail.com>
 **/
class remove_ot extends CI_Controller {

    function __construct() {
        parent::__construct();
 	if (!$this->session->userdata('logged_in')) {
            redirect('/login/');
        }
	$this->load->model('m_setting');
	$this->load->model('m_user');
        $this->load->model('m_outsource');
	$this->session->set_userdata('selectedmenu', '6');
    }
    
    function index() {
	    $data['title'] = $this->m_setting->getSetting();
	    $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
	    $data['pagetitle'] = "Remove OT Misspunch";
            $data['content'] = "outsource/v_removeot";
            $data['footer'] = "lyt_main/footer";
	    $this->load->view('tpl_main', $data);        
    }
    
    function submit() {
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
		       
		$this->session->set_userdata('date1', $leave_start);
		$this->session->set_userdata('date2', $leave_end);
		$data['title'] = $this->m_setting->getSetting();
		//$data['headform'] = $this->m_outsource->viewHeadForm($formid);
		$removetmp = $this->m_outsource->removeOTMP($date1,$date2);
                
                for($i=0; $i < Count($removetmp); $i++){
			    $dataattd = array(				
				'othour' => '0'							
			    );
			    
			    $this->db->where('userid', $removetmp[$i]['userid']);
			    $this->db->where('date', $removetmp[$i]['date']);
			    $this->db->update('attendance', $dataattd);			    
		}
                $this->session->set_userdata('noticebox', '5');
		$this->index();
		
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