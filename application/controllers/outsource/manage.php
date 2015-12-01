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
class manage extends CI_Controller {

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
	    $data['outsource'] = $this->m_outsource->getAllForm();
            
	    $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
	    $data['pagetitle'] = "Manage Form";
            $data['content'] = "outsource/v_manage";
            $data['footer'] = "lyt_main/footer";
	    $this->load->view('tpl_main', $data);       
    }
    
    function savepdf($formid){
        if(is_numeric($formid) == TRUE)
	{
            $this->load->library('pdf');
            $valid = $this->m_outsource->viewHeadForm($formid);
                        
            if(count($valid) == 0)
	    {
		redirect('/outsource/manage/');
	    }
            
            $data['title'] = $this->m_setting->getSetting();
            $data['headform'] = $this->m_outsource->viewHeadForm($formid);
	    $data['detilform'] = $this->m_outsource->viewDetilForm($formid);
            
            $html = $this->load->view('outsource/v_pdf', $data, true);
            $this->pdf->pdf_create($html, 'DocNo-'.$valid[0]['docno']);
            //$this->load->view('tpl_main', $data);
            //$this->load->view('outsource/v_pdf', $data);
        }
    }
    
    function view($formid){
	
	if(is_numeric($formid) == TRUE)
	{
	    $this->session->set_userdata('l_view', $formid);
	    $this->session->set_userdata('l_readonly', 1);
	    $this->session->set_userdata('l_thismanage', 1);
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
	    
	     //query for head & detil
	    $data['headform'] = $this->m_outsource->viewHeadForm($formid);
	    $data['detilform'] = $this->m_outsource->viewDetilForm($formid);
	    
	    $data['title'] = $this->m_setting->getSetting();
	    $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
	    $data['pagetitle'] = "Attendance Form";
            $data['content'] = "outsource/v_create";
            $data['footer'] = "lyt_main/footer";
	    $this->load->view('tpl_main', $data);  	    
	}
	else{
	    redirect('/outsource/manage/');
	}
    }
}    
?>