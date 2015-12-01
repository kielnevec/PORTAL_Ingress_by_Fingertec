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
class upload_rates extends CI_Controller {

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
	    $data['pagetitle'] = "Upload Rates Outsource";
            $data['content'] = "outsource/v_upload_rates";
            $data['footer'] = "lyt_main/footer";
	    $this->load->view('tpl_main', $data);        
    }
    
    function submit() {
	    $this->load->library('form_validation');
            	function do_upload()
                {
                    $config['upload_path'] = './uploads/';
                    $config['allowed_types'] = 'gif|jpg|png';
                    $config['max_size']	= '100';
                    $config['max_width']  = '1024';
                    $config['max_height']  = '768';
    
                    $this->load->library('upload', $config);
    
                    if ( ! $this->upload->do_upload())
                    {
                            $error = array('error' => $this->upload->display_errors());
    
                            $this->load->view('upload_form', $error);
                    }
                    else
                    {
                            $data = array('upload_data' => $this->upload->data());
    
                            $this->load->view('upload_success', $data);
                    }
                }
    }
}