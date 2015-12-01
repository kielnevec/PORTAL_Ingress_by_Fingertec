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
class approve extends CI_Controller {

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
            $id = $this->session->userdata('userid');
	    
	    $data['title'] = $this->m_setting->getSetting();
	    $data['pending'] = $this->m_outsource->getApprovaldoc();
            
	    $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
	    $data['pagetitle'] = "List Pending Form";
            $data['content'] = "outsource/v_approve";
            $data['footer'] = "lyt_main/footer";
	    $this->load->view('tpl_main', $data);        
    }
    
    function view($formid){
	
	if(is_numeric($formid) == TRUE)
	{
	    $this->session->set_userdata('l_view', $formid);
	    $this->session->set_userdata('l_readonly', 1);
	    $this->session->set_userdata('l_thismanage', 0);
	    $this->session->set_userdata('l_outsource', 2);
	    
	    $valid = $this->m_outsource->viewHeadForm($formid);
	    
	    if(count($valid) == 0)
	    {
		redirect('/outsource/approve/');
	    }
	    
	    foreach ($valid as $row)
	    {    
	       $this->session->set_userdata('form_status', $row['status']);
	    }
	    //$id = $this->session->userdata('userid');
	    //$userquery = $this->m_user->getUserdata($id);
	    
	    //foreach ($userquery as $row)
	    //{    
	    //   $this->session->set_userdata('l_userid', $row['userid']);
	    //   $this->session->set_userdata('l_level', $row['id_emp']);
	    //   $this->session->set_userdata('l_limit', $row['limit']);
	    //   $this->session->set_userdata('l_climit', $row['c_limit']);
	    //}
	    
	     //query for head & detil
	    $data['headform'] = $this->m_outsource->viewHeadForm($formid);
	    $data['detilform'] = $this->m_outsource->viewDetilForm($formid);
	    
	    $data['title'] = $this->m_setting->getSetting();
	    $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
	    $data['pagetitle'] = "Approve Form";
            $data['content'] = "outsource/v_create";
            $data['footer'] = "lyt_main/footer";
	    $this->load->view('tpl_main', $data);  	    
	}
    }
    
    function submit() {
	    $this->load->library('form_validation');
	    $remark = $this->input->post('remark');
	    $valueapp = $this->input->post('btn');
		    
	    $this->form_validation->set_rules('remark', 'Remark', 'required');
	    $this->form_validation->set_error_delimiters('<span class="help-block" style="color:red">', '</span>');
	    
	    if($this->form_validation->run() == FALSE){
		$this->view($this->session->userdata('l_view'));
	    }
	    else{
		//nampilih greenbox di view
		$this->session->set_userdata('noticebox', '6');
		
		if($valueapp == "approve"){
		    $data = array(
			    'status' => '1',
			    'remark' => $remark,
			    'exeby' => $this->session->userdata('userid'),
			    'exedate' => date('Y-m-d H:i:s')
			    
			);
		    
		    $this->db->where('docno', $this->session->userdata('tmp_docno'));
		    $this->db->update('f_osform_th', $data);
		    
		    
		    
		    
		    //execute to attendance ingress
		    if($this->session->userdata('tmp_typeform') == 5)
		    {
			 $clocking = $this->m_outsource->getscheduletime($this->session->userdata('tmp_docno'));
			 
			 for($i=0; $i < Count($clocking); $i++){
			    $dataattd = array(
				'att_in' => $clocking[$i]['sche_in'],
				'att_out' => $clocking[$i]['sche_out'],
				'workhour' => $clocking[$i]['workhour'],
				'othour' => $clocking[$i]['othour'],
				'in_c' => '1',
				'out_c' => '1',
				'remark_c' => '1',
				'remark' => $this->session->userdata('tmp_typeform'),
				'Form_docno' => $clocking[$i]['docno']				
			    );
			    
			    $this->db->where('userid', $clocking[$i]['empid']);
			    $this->db->where('date', $clocking[$i]['date']);
			    $this->db->update('attendance', $dataattd);
			    
			 }
		    }
		    else if($this->session->userdata('tmp_typeform') == 4){
			
			$clocking = $this->m_outsource->getsickscheduletime($this->session->userdata('tmp_docno'));
			 
			 for($i=0; $i < Count($clocking); $i++){
			    $dataattd = array(
				'workhour' => '8',
				'in_x' => '1',
				'out_x' => '1',
				'remark_c' => '1',
				'workhour_c' => '1',
				'remark' => $this->session->userdata('tmp_typeform'),
				'Form_docno' => $clocking[$i]['docno']				
			    );
			    
			    $this->db->where('userid', $clocking[$i]['empid']);
			    $this->db->where('date', $clocking[$i]['date']);
			    $this->db->update('attendance', $dataattd);
			    
			 }
			
		    }
		    else if($this->session->userdata('tmp_typeform') == 6)
		    {
			$clocking = $this->m_outsource->getscheduletime($this->session->userdata('tmp_docno'));
			 
			 for($i=0; $i < Count($clocking); $i++){
			    $dataattd = array(
				'att_in' => $clocking[$i]['sche_in'],
				'att_out' => $clocking[$i]['sche_out'],
				'workhour' => $clocking[$i]['workhour'],
				'othour' => $clocking[$i]['othour'],
				'in_c' => '1',
				'out_c' => '1',
				'in_x' => '1',
				'out_x' => '1',
				'remark_c' => '1',
				'remark' => $this->session->userdata('tmp_typeform'),
				'Form_docno' => $clocking[$i]['docno']	
				
			    );
			    
			    $this->db->where('userid', $clocking[$i]['empid']);
			    $this->db->where('date', $clocking[$i]['date']);
			    $this->db->update('attendance', $dataattd);
			    
			 }
		    }
		    else if($this->session->userdata('tmp_typeform') == 3)
		    {
			 $clocking = $this->m_outsource->getscheduletime($this->session->userdata('tmp_docno'));
			 
			 for($i=0; $i < Count($clocking); $i++){
			    $dataattd = array(
				'att_in' => NULL,
				'att_out' => NULL,
				'workhour' => '0',
				'othour' => '0',
				'in_c' => '1',
				'out_c' => '1',
				'remark_c' => '1',
				'remark' => $this->session->userdata('tmp_typeform'),
				'Form_docno' => $clocking[$i]['docno']	
			    );
			    $this->db->where('userid', $clocking[$i]['empid']);
			    $this->db->where('date', $clocking[$i]['date']);
			    $this->db->update('attendance', $dataattd);
			 }
		    }
		    else if ($this->session->userdata('tmp_typeform') == 1){
			$clocking = $this->m_outsource->getexpectedschedule($this->session->userdata('tmp_docno'));
			
			for($i=0; $i<Count($clocking); $i++){
			    $dataattd = array(
				'sche1' => $clocking[$i]['idplanschd'],
				'sche1_c' => '1',
				'remark_c' => '1',
				'remark' => $this->session->userdata('tmp_typeform'),
				'Form_docno' => $clocking[$i]['docno']	
			    );
			    $this->db->where('userid', $clocking[$i]['empid']);
			    $this->db->where('date', $clocking[$i]['date']);
			    $this->db->update('attendance', $dataattd);
			}
		    }		    
		    else if ($this->session->userdata('tmp_typeform') == 2){
			$clocking = $this->m_outsource->getexpectedroosterhead($this->session->userdata('tmp_docno'));
			
			for($i=0; $i<Count($clocking); $i++){
			    $dataattd = array(
				'dutygroup' => $clocking[$i]['idplnroster']
			    );
			    $this->db->where('userid', $clocking[$i]['empid']);
			    $this->db->update('user_info', $dataattd);
			}
			
			$rosterdetail = $this->m_outsource->getexpectedroosterdetail($this->session->userdata('tmp_docno'));
			
			for($i=0; $i<Count($rosterdetail); $i++){
			    $tmpsche1 = 0;
			    if($rosterdetail[$i]['scheduleno'] == NULL){
				$tmpsche1 = 0;
			    }
			    else
			    {
				$tmpsche1 = $rosterdetail[$i]['scheduleno'];
			    }
			    $dataroster = array(
				'daytype' => $rosterdetail[$i]['typeday'],
				'sche1' => $tmpsche1
			    );
			    $this->db->where('userid', $rosterdetail[$i]['userid']);
			    $this->db->where('Date', $rosterdetail[$i]['Date']);
			    $this->db->update('attendance', $dataroster);
			}
		    }
		    
		    $this->index();
		    
		}
		else if ($valueapp == "reject"){
		    $data = array(
			    'status' => '2',
			    'remark' => $remark,
			    'exeby' => $this->session->userdata('userid'),
			    'exedate' => date('Y-m-d H:i:s')
			);
		    
		    $this->db->where('docno', $this->session->userdata('tmp_docno'));
		    $this->db->update('f_osform_th', $data);
		    $this->index();    
		}
	    }
	    
    }
}

?>