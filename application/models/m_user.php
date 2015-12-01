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
class m_user extends CI_Model {

    function getUserdata($id) {
        $query = $this->db->query("SELECT user.userid, emp_level.id_emp, emp_level.limit, emp_level.c_limit, emp_level.exam_limit, emp_level.maternity_limit,
			emp_level.sick_limit, user.ic , user.name, user.lastname ,
			user.gender , user.Email, user_group.gName, user.designation, user.Gender, 
			CASE  
                                WHEN PERIOD_DIFF(DATE_FORMAT(now(),'%Y%m'),DATE_FORMAT(DATE_ADD(user.IssueDate, INTERVAL 1 YEAR),'%Y%m')) < -1
                                THEN 0
				WHEN SUM(tr_leave.total_days) IS NULL
				THEN emp_level.limit
                                ELSE emp_level.limit - SUM(tr_leave.total_days)
                                END AS limits, 
                                emp_level.c_limit, emp_level.cmp_limit, emp_level.exam_limit,
                                user.IssueDate FROM
                                user 
				INNER JOIN user_group ON user.User_Group = user_group.id
                                INNER JOIN emp_level ON emp_level.id_emp = user.define_1
				LEFT JOIN tr_leave ON user.userid = tr_leave.r_id AND tr_leave.docstatus != '2' AND tr_leave.leavetype = '2'
				WHERE userid = '$id' 
				GROUP BY user.userid, emp_level.id_emp, emp_level.limit, emp_level.c_limit, emp_level.exam_limit, emp_level.maternity_limit,
				emp_level.sick_limit, user.ic , user.Name, user.lastname ,
				user.gender , user.Email, user_group.gName, user.designation, user.Gender, emp_level.c_limit, emp_level.cmp_limit, emp_level.exam_limit
				");
            return $query->result_array();
    }
    
    function getLeave() {
        $query = $this->db->query("SELECT * FROM leavetype");
        return $query->result_array();
    }
    
    function getApprover($dept) {
        $query = $this->db->query("SELECT userid, Name, lastname FROM user WHERE User_Group = '$dept' AND (define_1 = '2' OR define_1 = '3')");
        return $query->result_array();
    }
    
    function getStaffdept(){
	$query = $this->db->query("SELECT * FROM user_group WHERE parentId IS NOT NULL AND (parentId = '3' OR parentId = '4')");
	return $query->result_array();
    }
    
    function validEmpId($id){
        $query = $this->db->query("SELECT user.userid FROM user
				  INNER JOIN user_group ON user.User_Group = user_group.id
				  WHERE (user.userid = '$id' AND user.userid IS NOT NULL AND user.userid != '') AND (user_group.parentId = '3' OR user_group.parentId = '4')");
        $result = $query->result_array();
    
        if (isset($result[0]['userid'])) {
            return $result[0]['userid'];
        } else {
            return 0;
        }
    }
}
?>