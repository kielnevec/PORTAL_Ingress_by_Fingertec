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
class outsourcelist extends CI_Controller {

    function __construct() {
        parent::__construct();
	$this->load->model('m_setting');	
 	if (!$this->session->userdata('logged_in')) {
            redirect('/login/');
        }
        $this->load->model('m_tablelist');
    }

    function getlist($search) {
            $id = $this->session->userdata('userid');
	    $dept = $this->session->userdata('User_Group');
	    
	    $data['title'] = $this->m_setting->getSetting();
	    $data['titletable'] = "Outsource List"; 
            $data['outsource'] = $this->m_tablelist->getOutsource($search);
            $data['title'] = $this->m_setting->getSetting();
	    $this->load->view('tpl_tablelist', $data);
        
    }
    
    function index() {
            $id = $this->session->userdata('userid');
	    $dept = $this->session->userdata('User_Group');
	    
	    $data['title'] = $this->m_setting->getSetting();
	    $data['titletable'] = "Outsource List"; 
            $data['outsource'] = $this->m_tablelist->getOutsourceall();
            $data['title'] = $this->m_setting->getSetting();
	    $this->load->view('tpl_tablelist', $data);
        
    }
}

?>