<?php

class level_auth extends CI_Controller {

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
        $crud->set_table('f_lvlauth')
                ->set_subject('Level Authorization')
                ->columns('id_lvlauth', 'desc', 'isActive')
                ->display_as('id_lvlauth', 'id')
                ->display_as('desc', 'Description')
                ->display_as('isActive', 'is Active');
                
            $data['title'] = $this->m_setting->getSetting();
	    $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
	    $data['pagetitle'] = "Manage Level Authorization";
            $data['content'] = "master/v_crud";
            $data['footer'] = "lyt_main/footer";
            $data['crud_output'] = $crud->render();
	    $this->load->view('tpl_main', $data);
        
    }


}

?>