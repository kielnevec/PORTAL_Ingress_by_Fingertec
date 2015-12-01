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
class autofix extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('m_patch');
    }

    function index() {               	    
	    $fix = $this->m_patch->getErrorDaytype();
			 
                for($i=0; $i < Count($fix); $i++){
                   $dataattd = array(
                       'daytype' => $fix[$i]['typeday']				
                   );
                   
                   $this->db->where('userid', $fix[$i]['userid']);
                   $this->db->where('date', $fix[$i]['Date']);
                   $this->db->update('attendance', $dataattd);
                }         
	    $this->load->view('v_autopatch');        
    }
}
?>