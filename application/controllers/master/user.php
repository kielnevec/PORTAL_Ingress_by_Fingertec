<?php

class user extends CI_Controller {

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
        $crud->set_table('user')
                ->set_subject('User')
                ->columns('userid', 'ic', 'Name', 'lastname', 'Email', 'User_Group' , 'define_1' , 'LastUpdate', 'user_last_login')
                ->display_as('userid', 'User ID')
                ->display_as('ic', 'Employee ID')
                ->display_as('Name', 'First Name')
                ->display_as('lastname', 'Last Name')
                ->display_as('Email', 'Email')
                ->display_as('User_Group', 'Dept')
		->display_as('define_1', 'Employee Level')
                ->display_as('LastUpdate', 'Last Update')
                ->display_as('user_last_login', 'Last Login');
        
        $crud->set_relation('User_Group','user_group','gName');
	$crud->set_relation('define_1','emp_level','desc');
                
            $data['title'] = $this->m_setting->getSetting();
	    $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
	    $data['pagetitle'] = "Manage User";
            $data['content'] = "master/v_crud";
            $data['footer'] = "lyt_main/footer";
            $data['crud_output'] = $crud->render();
	    $this->load->view('tpl_main', $data);
        
    }


}

?>