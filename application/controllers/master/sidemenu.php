<?php

class sidemenu extends CI_Controller {

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
        $crud->set_table('f_sidemenu')
                ->set_subject('Side Menu')
                ->columns('idmenu', 'name', 'link','parent','active','isParent','icon')
                ->display_as('idmenu', 'id')
                ->display_as('name', 'Description')
                ->display_as('link', 'Link')
                ->display_as('parent', 'Parent')
                ->display_as('active', 'Active')
                ->display_as('isParent', 'Parent?')
                ->display_as('icon', 'Icon');
                
            $data['title'] = $this->m_setting->getSetting();
	    $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
	    $data['pagetitle'] = "Side Menu Configuration";
            $data['content'] = "master/v_crud";
            $data['footer'] = "lyt_main/footer";
            $data['crud_output'] = $crud->render();
	    $this->load->view('tpl_main', $data);
        
    }


}

?>