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
class create extends CI_Controller {

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
            $this->session->set_userdata('l_readonly', 0);
	    $id = $this->session->userdata('userid');
	    $lvlauth = $this->session->userdata('lvl_auth');
	    $dept = $this->session->userdata('User_Group');
	    $this->session->set_userdata('l_thismanage', 0);
	    $this->session->set_userdata('form_status', 0);
	    
	    $this->session->set_userdata('l_outsource', 1);
	    
	    $userquery = $this->m_user->getUserdata($id);
	    
	    foreach ($userquery as $row)
	    {    
	       //$this->session->set_userdata('l_userid', $row['userid']);
	       $this->session->set_userdata('l_level', $row['id_emp']);
	       $this->session->set_userdata('l_limit', $row['limit']);
	       $this->session->set_userdata('l_climit', $row['c_limit']);
	    }
	    
	    
            $data['userdata'] = $userquery;
	    $data['approver'] = $this->m_user->getApprover($dept);
	    
	    $data['title'] = $this->m_setting->getSetting();
	    $data['leave'] = $this->m_user->getLeave();
	    $data['roster'] = $this->m_outsource->getRoster();
	    $data['schedule'] = $this->m_outsource->getSchedule();
	    if($lvlauth == "99"){
	    $data['typeform'] = $this->m_outsource->getTypeFormdev();
	    }
	    else{
	    $data['typeform'] = $this->m_outsource->getTypeForm();	
	    }
	    $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
	    $data['pagetitle'] = "Create Attendance Form";
            $data['content'] = "outsource/v_create";
            $data['footer'] = "lyt_main/footer";
	    $this->load->view('tpl_main', $data);        
    }
   
    function submit() {
	    $this->load->library('form_validation');
	
	    $typeform = $this->input->post('tmptypeform');
	    $remark = $this->input->post('remark');
	    $tmprow = $this->input->post('tmpidemp');

	    $this->form_validation->set_rules('typeform', 'Form Type', 'is_natural_no_zero');
	    
	    $this->form_validation->set_message('is_natural_no_zero', 'Please choose the option');
	    
	    $this->form_validation->set_rules('remark', 'Remark', 'required');
	    $this->form_validation->set_error_delimiters('<span class="help-block" style="color:red">', '</span>');
	    
	    if($this->form_validation->run() == FALSE){
		$this->index();   
	    }
	    else{
	    
		//nampilih greenbox di view
		$this->session->set_userdata('noticebox', '5');
		
		//insert header
		$data = array(
		    'typeform' => $typeform,
		    'docdate' => date('Y-m-d'),
		    'creator' => $this->session->userdata('userid'),
		    'remark' => $remark,		    
		 );
		$this->db->insert('f_osform_th', $data);
		
		//insert detail
		$thdocno = $this->m_outsource->getlastdocno();
		
		if($typeform == 3 || $typeform == 4 || $typeform == 5 || $typeform == 6){
		    for($i = 0 ; $i < count($tmprow); $i++){
			$exploderow = explode("#|#", $tmprow[$i]);
			    $datadetil = array(
			    'docno' => $thdocno,
			    'empid' => $exploderow[0],
			    'empname' => $exploderow[1],
			    'dept' => $exploderow[2],
			    'idroster' => $exploderow[3],
			    'nameroster' => $exploderow[4],
			    'datefrom' => date('Y-m-d', strtotime(str_replace('/', '-', $exploderow[5]))),
			    'dateto' => date('Y-m-d', strtotime(str_replace('/', '-', $exploderow[6]))),		    
			    );
			    $this->db->insert('f_osform_td', $datadetil);
		    }
		}
		else if ($typeform == 1){
		    for($i = 0 ; $i < count($tmprow); $i++){
			$exploderow = explode("#|#", $tmprow[$i]);
			    $datadetil = array(
			    'docno' => $thdocno,
			    'empid' => $exploderow[0],
			    'empname' => $exploderow[1],
			    'dept' => $exploderow[2],
			    'idroster' => $exploderow[3],
			    'nameroster' => $exploderow[4],
			    'idplanschd' => $exploderow[5],
			    'plnnameschd' => $exploderow[6],
			    'datefrom' => date('Y-m-d', strtotime(str_replace('/', '-', $exploderow[7]))),
			    'dateto' => date('Y-m-d', strtotime(str_replace('/', '-', $exploderow[8]))),		    
			    );
			    $this->db->insert('f_osform_td', $datadetil);
		    }
		}
		else if ($typeform == 2){
		    for($i = 0 ; $i < count($tmprow); $i++){
			$exploderow = explode("#|#", $tmprow[$i]);
			    $datadetil = array(
			    'docno' => $thdocno,
			    'empid' => $exploderow[0],
			    'empname' => $exploderow[1],
			    'dept' => $exploderow[2],
			    'idroster' => $exploderow[3],
			    'nameroster' => $exploderow[4],
			    'idplnroster' => $exploderow[5],
			    'plnnameroster' => $exploderow[6],
			    'datefrom' => date('Y-m-d', strtotime(str_replace('/', '-', $exploderow[7]))),			    		    
			    );
			    $this->db->insert('f_osform_td', $datadetil);
		    }
		}		
		redirect('/outsource/manage/view/'.$thdocno);
		
	    //}   
	}
     
    
    }
}

?>