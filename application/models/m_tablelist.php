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
class m_tablelist extends CI_Model {
    
    function getOutsource($search){
        $query = $this->db->query("SELECT user.userid, user.ic, user.Name, user.lastname, user_group.gName , roster.idroster, roster.rostername FROM user
                                  INNER JOIN user_group ON user.user_group = user_group.id
                                  INNER JOIN user_info ON user.userid = user_info.userid
                                  INNER JOIN roster ON user_info.dutygroup = roster.idroster
								  WHERE (user_group.parentId = '99' OR user_group.parentId = '3' OR user_group.parentId = '234') AND (user.Name LIKE '%$search%' OR user.lastname LIKE '%$search%' OR user.userid LIKE '%$search')");
        return $query->result_array();
    }
    
    function getOutsourceall(){
        $query = $this->db->query("SELECT user.userid, user.ic, user.Name, user.lastname, user_group.gName , roster.idroster, roster.rostername FROM user
                                  INNER JOIN user_group ON user.user_group = user_group.id
                                  INNER JOIN user_info ON user.userid = user_info.userid
                                  INNER JOIN roster ON user_info.dutygroup = roster.idroster
								  WHERE (user_group.parentId = '99' OR user_group.parentId = '3' OR user_group.parentId = '234')");
        return $query->result_array();
    }
    
}

?>