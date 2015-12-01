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
class m_register extends CI_Model {
    
    function getHash($email){
        $query = $this->db->query("SELECT hash FROM m_user WHERE user_email = '$email' LIMIT 1");
        $result = $query->result_array();
    
        if (isset($result[0]['hash'])) {
            return $result[0]['hash'];
        } else {
            return 0;
        }
    }
    
    function updateStatus($hash){
        $query = $this->db->query("UPDATE m_user SET isActive = 'yes' WHERE hash = '$hash' and isActive = 'nope' LIMIT 1");
        $count = $this->db->affected_rows();
        return $count;
    }
    
    function checkActive($email){
        $query = $this->db->query("SELECT isActive FROM m_user WHERE user_email = '$email' AND isActive = 'nope' LIMIT 1");
        $result = $query->result_array();
    
        if (isset($result[0]['isActive'])) {
            return 1;
        } else {
            return 0;
        }
    }
}

?>