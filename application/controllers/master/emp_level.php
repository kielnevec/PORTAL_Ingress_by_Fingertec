<?php

class emp_level extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('grocery_CRUD');
	$this->load->model('m_setting');	
 	if (!$this->session->userdata('logged_in')) {
            redirect('/login/');
        }
	$this->session->set_userdata('selectedmenu', '12');
    }

    function index() {
        $crud = new grocery_CRUD();
        
        // list table
        $crud->set_table('emp_level')
                ->set_subject('Employee Level')
                ->columns('id_emp', 'desc', 'limit', 'lastupdate')
                ->display_as('id_emp', 'id')
                ->display_as('desc', 'Description')
                ->display_as('limit', 'Limit Leave')
                ->display_as('lastupdate', 'Last Update');
                
            $data['title'] = $this->m_setting->getSetting();
	    $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
	    $data['pagetitle'] = "Manage Employee Level";
            $data['content'] = "master/v_crud";
            $data['footer'] = "lyt_main/footer";
            $data['crud_output'] = $crud->render();
	    $this->load->view('tpl_main', $data);
        
    }


}

?>