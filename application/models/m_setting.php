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
class m_setting extends CI_Model {
    
    function getSetting(){
        $query = $this->db->query("SELECT * FROM setting LIMIT 1");
        return $query->result_array();
    }
    
}

?>
