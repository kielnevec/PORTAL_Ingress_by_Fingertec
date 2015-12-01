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
class m_outsource extends CI_Model {

    function getMissPunch($datefrom, $dateto){
        $query = $this->db->query("SELECT user.userid, CONCAT(user.Name,' ',user.lastname) AS 'EmployeeName', user_group.gName AS 'Department', attendance.date, attendance.att_in, attendance.att_out, schedule.schedulename FROM attendance 
                INNER JOIN user ON attendance.userid = user.userid
                INNER JOIN user_group ON user.User_Group = user_group.id
                INNER JOIN schedule ON schedule.idschedule = attendance.sche1
                WHERE ((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR (attendance.att_out IS NOT NULL AND attendance.att_in IS NULL)) 
                AND attendance.date BETWEEN '$datefrom' AND '$dateto';");
        return $query->result_array();
    }
    
    function getTypeForm(){
        $query = $this->db->query("SELECT * FROM f_tpform_os WHERE status = 'A'");
        return $query->result_array();
    }
    
    function getTypeFormdev(){
        $query = $this->db->query("SELECT * FROM f_tpform_os");
        return $query->result_array();
    }
    
    function getRoster() {
        $query = $this->db->query("SELECT idroster, rostername FROM roster");
        return $query->result_array();
    }
    
    function getSchedule(){
        $query = $this->db->query("SELECT idschedule, schedulename FROM schedule");
        return $query->result_array();
    }
    
    function getlastdocno(){
        $query = $this->db->query("SELECT docno FROM f_osform_th ORDER BY docno DESC LIMIT 1");
        $result = $query->result_array();
    
        if (isset($result[0]['docno'])) {
            return $result[0]['docno'];
        } else {
            return 0;
        }
    }
    
    function getApprovaldoc(){
        $query = $this->db->query("SELECT f_osform_th.docno, f_osform_th.docdate, user.Name, user.lastname ,f_tpform_os.desc, f_osform_th.status, f_osform_th.remark
                                  FROM f_osform_th
                                  INNER JOIN f_tpform_os ON f_tpform_os.id = f_osform_th.typeform
                                  INNER JOIN user ON user.userid = f_osform_th.creator
                                  WHERE f_osform_th.status = 0
                                  ");
         return $query->result_array();
    }
    
    function viewHeadForm($formid){
        $query = $this->db->query("SELECT f_osform_th.docno, f_osform_th.docdate, user.Name, user.lastname ,f_tpform_os.desc, f_osform_th.status, f_osform_th.remark, f_osform_th.typeform
                                  FROM f_osform_th
                                  INNER JOIN f_tpform_os ON f_tpform_os.id = f_osform_th.typeform
                                  INNER JOIN user ON user.userid = f_osform_th.creator
                                  WHERE f_osform_th.docno = '$formid'");
        return $query->result_array();
    }
    
    function viewDetilForm($formid){
        $query = $this->db->query("SELECT * FROM f_osform_td
                                  WHERE f_osform_td.docno = '$formid'");
        return $query->result_array();
    }
    
    function headmanpower($datefrom, $dateto){
        $query = $this->db->query("SELECT DISTINCT
        SUBSTRING_INDEX(user_group.gName, '/', 1) AS 'Section',
        COUNT(DISTINCT USER .userid) AS 'Total'
        FROM
            USER
        INNER JOIN user_group ON `user`.User_Group = User_Group.id
        INNER JOIN attendance ON attendance.userid = `user`.userid
        WHERE
            user_group.parentId = '99'
        AND attendance.date BETWEEN '$datefrom'
        AND '$dateto'
        AND (attendance.workhour != '0')
        GROUP BY
            SUBSTRING_INDEX(user_group.gName, '/', 1)");
        return $query->result_array();
    }
    
    function detailmanpower($datefrom, $dateto){
        $query = $this->db->query("SELECT
            TRIM(
                SUBSTRING_INDEX(user_group.gName, '/', 1)
            ) AS 'Head',
            TRIM(
                SUBSTRING_INDEX(user_group.gName, '/' ,- 1)
            ) AS 'Section',
            COUNT(DISTINCT USER .userid) AS 'Total'
            FROM
                USER
            INNER JOIN user_group ON `user`.User_Group = User_Group.id
            INNER JOIN attendance ON attendance.userid = `user`.userid
            WHERE
                user_group.parentId = '99'
            AND attendance.date BETWEEN '$datefrom'
            AND '$dateto'
            AND (attendance.workhour != '0')
            GROUP BY
            SUBSTRING_INDEX(user_group.gName, '/', 1),
            SUBSTRING_INDEX(user_group.gName, '/' ,- 1)");
        return $query->result_array();
    }
    
    function grosswages($datefrom, $dateto){
        $query = $this->db->query("SELECT user.userid , CONCAT(user.Name,' ',user.lastname) AS 'EmployeeName', user.define_2 AS 'Rate', user_group.gName AS 'Dept',
        CAST(
        ((user.define_2 / 3600) * SUM(CASE WHEN attendance.daytype = 'W' AND attendance.workhour != 0 THEN (SUBSTRING_INDEX(workhour, '.',1) * 3600) + (SUBSTRING_INDEX(workhour, '.',-1) * 60)ELSE 0 END) * ((SELECT wages_work FROM daytype WHERE sdaytype = 'W') / 100))
        +
        ((user.define_2 / 3600) * SUM(CASE WHEN attendance.daytype = 'W' AND attendance.othour != 0 THEN (SUBSTRING_INDEX(othour, '.',1) * 3600) + (SUBSTRING_INDEX(othour, '.',-1) * 60)ELSE 0 END) * ((SELECT wages_ot FROM daytype WHERE sdaytype = 'W') / 100))
        +
        (
        ((user.define_2 / 3600) * 
        SUM(CASE WHEN attendance.daytype = 'R' AND attendance.workhour != 0 THEN (SUBSTRING_INDEX(workhour, '.',1) * 3600) + (SUBSTRING_INDEX(workhour, '.',-1) * 60)				
        ELSE 0 END)
        * ((SELECT wages_work FROM daytype WHERE sdaytype = 'R') / 100))
        + 
        ((user.define_2 / 3600) * 
        SUM(CASE WHEN attendance.daytype = 'R' AND attendance.othour != 0 THEN (SUBSTRING_INDEX(othour, '.',1) * 3600) + (SUBSTRING_INDEX(othour, '.',-1) * 60)
        ELSE 0 END)
        * ((SELECT wages_work FROM daytype WHERE sdaytype = 'R') / 100))
        +
        ((user.define_2 / 3600) * 
        SUM(CASE WHEN attendance.daytype = 'O' AND attendance.workhour != 0 THEN (SUBSTRING_INDEX(workhour, '.',1) * 3600) + (SUBSTRING_INDEX(workhour, '.',-1) * 60)				
        ELSE 0 END)
        * ((SELECT wages_work FROM daytype WHERE sdaytype = 'O') / 100))
        +
        ((user.define_2 / 3600) * 
        SUM(CASE WHEN attendance.daytype = 'O' AND attendance.othour != 0 THEN (SUBSTRING_INDEX(othour, '.',1) * 3600) + (SUBSTRING_INDEX(othour, '.',-1) * 60)
        ELSE 0 END)
        * ((SELECT wages_work FROM daytype WHERE sdaytype = 'O') / 100))
        )
        +
        (
        ((user.define_2 / 3600) * 
        SUM(CASE WHEN attendance.daytype = 'H' AND attendance.workhour != 0 THEN (SUBSTRING_INDEX(workhour, '.',1) * 3600) + (SUBSTRING_INDEX(workhour, '.',-1) * 60)				
        ELSE 0 END)
        * ((SELECT wages_work FROM daytype WHERE sdaytype = 'H') / 100))
        + 
        ((user.define_2 / 3600) * 
        SUM(CASE WHEN attendance.daytype = 'H' AND attendance.othour != 0 THEN (SUBSTRING_INDEX(othour, '.',1) * 3600) + (SUBSTRING_INDEX(othour, '.',-1) * 60)
        ELSE 0 END)
        * ((SELECT wages_work FROM daytype WHERE sdaytype = 'H') / 100))
        ) AS DECIMAL(8,2))
        AS 'GrossWages',
        
        SUBSTRING_INDEX(SEC_TO_TIME(SUM(CASE WHEN attendance.daytype = 'W' AND attendance.workhour != 0 THEN (SUBSTRING_INDEX(workhour, '.',1) * 3600) + (SUBSTRING_INDEX(workhour, '.',-1) * 60)ELSE 0 END)),':',2) AS 'Worktime',
        CAST((user.define_2 / 3600) * SUM(CASE WHEN attendance.daytype = 'W' AND attendance.workhour != 0 THEN (SUBSTRING_INDEX(workhour, '.',1) * 3600) + (SUBSTRING_INDEX(workhour, '.',-1) * 60)ELSE 0 END) * ((SELECT wages_work FROM daytype WHERE sdaytype = 'W') / 100) AS Decimal(12,2))
        AS 'W_Wages',
        
        SUBSTRING_INDEX(SEC_TO_TIME(SUM(CASE WHEN attendance.daytype = 'W' AND attendance.othour != 0 THEN (SUBSTRING_INDEX(othour, '.',1) * 3600) + (SUBSTRING_INDEX(othour, '.',-1) * 60)ELSE 0 END)),':',2) AS 'OT',
        CAST((user.define_2 / 3600) * SUM(CASE WHEN attendance.daytype = 'W' AND attendance.othour != 0 THEN (SUBSTRING_INDEX(othour, '.',1) * 3600) + (SUBSTRING_INDEX(othour, '.',-1) * 60)ELSE 0 END) * ((SELECT wages_ot FROM daytype WHERE sdaytype = 'W') / 100) AS Decimal(12,2))
        AS 'OT_Wages',
        
        SUBSTRING_INDEX(SEC_TO_TIME(
        SUM(CASE WHEN attendance.daytype = 'R' AND attendance.workhour != 0 THEN (SUBSTRING_INDEX(workhour, '.',1) * 3600) + (SUBSTRING_INDEX(workhour, '.',-1) * 60)
        ELSE 0 END) 
        + 
        SUM(CASE WHEN attendance.daytype = 'R' AND attendance.othour != 0 THEN (SUBSTRING_INDEX(othour, '.',1) * 3600) + (SUBSTRING_INDEX(othour, '.',-1) * 60)
        ELSE 0 END)
        +
        SUM(CASE WHEN attendance.daytype = 'O' AND attendance.workhour != 0 THEN (SUBSTRING_INDEX(workhour, '.',1) * 3600) + (SUBSTRING_INDEX(workhour, '.',-1) * 60)
        ELSE 0 END) 
        +
        SUM(CASE WHEN attendance.daytype = 'O' AND attendance.othour != 0 THEN (SUBSTRING_INDEX(othour, '.',1) * 3600) + (SUBSTRING_INDEX(othour, '.',-1) * 60)
        ELSE 0 END)
        )
        ,':',2) AS 'Restday',

        CAST(
        ((user.define_2 / 3600) * 
        SUM(CASE WHEN attendance.daytype = 'R' AND attendance.workhour != 0 THEN (SUBSTRING_INDEX(workhour, '.',1) * 3600) + (SUBSTRING_INDEX(workhour, '.',-1) * 60)				
        ELSE 0 END)
        * ((SELECT wages_work FROM daytype WHERE sdaytype = 'R') / 100))
        + 
        ((user.define_2 / 3600) * 
        SUM(CASE WHEN attendance.daytype = 'R' AND attendance.othour != 0 THEN (SUBSTRING_INDEX(othour, '.',1) * 3600) + (SUBSTRING_INDEX(othour, '.',-1) * 60)
        ELSE 0 END)
        * ((SELECT wages_work FROM daytype WHERE sdaytype = 'R') / 100))
        +
        ((user.define_2 / 3600) * 
        SUM(CASE WHEN attendance.daytype = 'O' AND attendance.workhour != 0 THEN (SUBSTRING_INDEX(workhour, '.',1) * 3600) + (SUBSTRING_INDEX(workhour, '.',-1) * 60)				
        ELSE 0 END)
        * ((SELECT wages_work FROM daytype WHERE sdaytype = 'O') / 100))
        +
        ((user.define_2 / 3600) * 
        SUM(CASE WHEN attendance.daytype = 'O' AND attendance.othour != 0 THEN (SUBSTRING_INDEX(othour, '.',1) * 3600) + (SUBSTRING_INDEX(othour, '.',-1) * 60)
        ELSE 0 END)
        * ((SELECT wages_work FROM daytype WHERE sdaytype = 'O') / 100))
        AS Decimal(12,2)) AS 'R_Wages',

        SUBSTRING_INDEX(SEC_TO_TIME(
        SUM(CASE WHEN attendance.daytype = 'H' AND attendance.workhour != 0 THEN (SUBSTRING_INDEX(workhour, '.',1) * 3600) + (SUBSTRING_INDEX(workhour, '.',-1) * 60)
        ELSE 0 END) 
        + 
        SUM(CASE WHEN attendance.daytype = 'H' AND attendance.othour != 0 THEN (SUBSTRING_INDEX(othour, '.',1) * 3600) + (SUBSTRING_INDEX(othour, '.',-1) * 60)
        ELSE 0 END)
        )
        ,':',2) AS 'Holiday',

        CAST(
        ((user.define_2 / 3600) * 
        SUM(CASE WHEN attendance.daytype = 'H' AND attendance.workhour != 0 THEN (SUBSTRING_INDEX(workhour, '.',1) * 3600) + (SUBSTRING_INDEX(workhour, '.',-1) * 60)				
        ELSE 0 END)
        * ((SELECT wages_work FROM daytype WHERE sdaytype = 'H') / 100))
        + 
        ((user.define_2 / 3600) * 
        SUM(CASE WHEN attendance.daytype = 'H' AND attendance.othour != 0 THEN (SUBSTRING_INDEX(othour, '.',1) * 3600) + (SUBSTRING_INDEX(othour, '.',-1) * 60)
        ELSE 0 END)
        * ((SELECT wages_work FROM daytype WHERE sdaytype = 'H') / 100))
        AS Decimal(12,2)) AS 'H_Wages'
        
        FROM 
        attendance 
        INNER JOIN daytype ON attendance.daytype = daytype.sdaytype
        INNER JOIN user ON attendance.userid = user.userid
        INNER JOIN user_group ON user_group.id = user.user_group
        WHERE user_group.parentId = '99' AND (attendance.date BETWEEN '$datefrom' AND '$dateto') AND (attendance.workhour != '0')
        GROUP BY
        user.userid
	ORDER BY
	user_group.id
        ");
        return $query->result_array();
    }
    
    function sumgrosswages($datefrom, $dateto){
        $query = $this->db->query("
                SELECT
                CONCAT('N ', FORMAT(SUM(CAST(a.GrossWages AS DECIMAL(8,2))), 2)) AS Gross, 
                CONCAT('N ', FORMAT(SUM(CAST(a.GrossWages * (9/100) AS DECIMAL(8,2))), 2))
                AS 'mgtfee',
                CONCAT('N ', FORMAT(SUM(CAST((a.GrossWages * (10/100)) * (5/100) AS DECIMAL(8,2))), 2))
                AS 'vatmgtfee',
                CONCAT('N ', FORMAT(SUM(CAST(a.GrossWages + (a.GrossWages * (10/100)) + ((a.GrossWages * (10/100)) * (5/100)) AS DECIMAL(8,2))), 2))
                AS 'Net'
                FROM 
                         (
                             SELECT 
                                ((user.define_2 / 3600) * SUM(CASE WHEN attendance.daytype = 'W' AND attendance.workhour != 0 THEN (SUBSTRING_INDEX(workhour, '.',1) * 3600) + (SUBSTRING_INDEX(workhour, '.',-1) * 60)ELSE 0 END) * ((SELECT wages_work FROM daytype WHERE sdaytype = 'W') / 100))
                                +
                                ((user.define_2 / 3600) * SUM(CASE WHEN attendance.daytype = 'W' AND attendance.othour != 0 THEN (SUBSTRING_INDEX(othour, '.',1) * 3600) + (SUBSTRING_INDEX(othour, '.',-1) * 60)ELSE 0 END) * ((SELECT wages_ot FROM daytype WHERE sdaytype = 'W') / 100))
                                +
                                (
                                ((user.define_2 / 3600) * 
                                SUM(CASE WHEN attendance.daytype = 'R' AND attendance.workhour != 0 THEN (SUBSTRING_INDEX(workhour, '.',1) * 3600) + (SUBSTRING_INDEX(workhour, '.',-1) * 60)				
                                ELSE 0 END)
                                * ((SELECT wages_work FROM daytype WHERE sdaytype = 'R') / 100))
                                + 
                                ((user.define_2 / 3600) * 
                                SUM(CASE WHEN attendance.daytype = 'R' AND attendance.othour != 0 THEN (SUBSTRING_INDEX(othour, '.',1) * 3600) + (SUBSTRING_INDEX(othour, '.',-1) * 60)
                                ELSE 0 END)
                                * ((SELECT wages_work FROM daytype WHERE sdaytype = 'R') / 100))
                                +
                                ((user.define_2 / 3600) * 
                                SUM(CASE WHEN attendance.daytype = 'O' AND attendance.workhour != 0 THEN (SUBSTRING_INDEX(workhour, '.',1) * 3600) + (SUBSTRING_INDEX(workhour, '.',-1) * 60)				
                                ELSE 0 END)
                                * ((SELECT wages_work FROM daytype WHERE sdaytype = 'O') / 100))
                                +
                                ((user.define_2 / 3600) * 
                                SUM(CASE WHEN attendance.daytype = 'O' AND attendance.othour != 0 THEN (SUBSTRING_INDEX(othour, '.',1) * 3600) + (SUBSTRING_INDEX(othour, '.',-1) * 60)
                                ELSE 0 END)
                                * ((SELECT wages_work FROM daytype WHERE sdaytype = 'O') / 100))
                                )
                                +
                                (
                                ((user.define_2 / 3600) * 
                                SUM(CASE WHEN attendance.daytype = 'H' AND attendance.workhour != 0 THEN (SUBSTRING_INDEX(workhour, '.',1) * 3600) + (SUBSTRING_INDEX(workhour, '.',-1) * 60)				
                                ELSE 0 END)
                                * ((SELECT wages_work FROM daytype WHERE sdaytype = 'H') / 100))
                                + 
                                ((user.define_2 / 3600) * 
                                SUM(CASE WHEN attendance.daytype = 'H' AND attendance.othour != 0 THEN (SUBSTRING_INDEX(othour, '.',1) * 3600) + (SUBSTRING_INDEX(othour, '.',-1) * 60)
                                ELSE 0 END)
                                * ((SELECT wages_work FROM daytype WHERE sdaytype = 'H') / 100))
                                )
                AS 'GrossWages'
                FROM
                attendance 
                INNER JOIN daytype ON attendance.daytype = daytype.sdaytype
                INNER JOIN user ON attendance.userid = user.userid
                INNER JOIN user_group ON user_group.id = user.user_group
                WHERE user_group.parentId = '99' AND attendance.date BETWEEN '$datefrom' AND '$dateto' AND (attendance.workhour != '0')
                GROUP BY
                user.userid
        ) a
        ");
        return $query->result_array();
    }
    
    
    //buat ngambil schedule time in & out 
    function getscheduletime($docno){
        $query = $this->db->query("SELECT attendance.date, schedule_weekday.sche_in, f_osform_th.docno,
		CASE 
			WHEN (schedule_weekday.sche_ot != '')
			THEN schedule_weekday.sche_ot
			ELSE schedule_weekday.sche_out
		END AS sche_out,
		
		CASE
		WHEN
		CAST(SUBSTR(TIMEDIFF(schedule_weekday.sche_out,schedule_weekday.sche_in),1,2) AS DECIMAL(12,2)) > 0
		THEN
		CAST(SUBSTR(TIMEDIFF(schedule_weekday.sche_out,schedule_weekday.sche_in),1,2) AS DECIMAL(12,2))
		
		ELSE ((SUBSTR(schedule_weekday.sche_out,1,2) + 12) - (SUBSTR(schedule_weekday.sche_in,1,2) - 12))
		END AS workhour,
		
		CASE
			WHEN CAST(REPLACE(TIMEDIFF(schedule_weekday.sche_ot,schedule_weekday.sche_in),':','.') AS DECIMAL(12,2)) > 8
			THEN CAST(REPLACE(TIMEDIFF(schedule_weekday.sche_ot,schedule_weekday.sche_in),':','.') AS DECIMAL(12,2)) - 8
	
			WHEN CAST(SUBSTR(TIMEDIFF(schedule_weekday.sche_ot,schedule_weekday.sche_in),1,2) AS DECIMAL(12,2)) = -1
			THEN ((SUBSTR(schedule_weekday.sche_ot,1,2) + 12) - (SUBSTR(schedule_weekday.sche_in,1,2) - 12)) - 8
		ELSE '0'
		END AS othour, f_osform_td.empid
		
		FROM attendance
			INNER JOIN f_osform_td ON f_osform_td.empid = attendance.userid
			INNER JOIN f_osform_th ON f_osform_th.docno = f_osform_td.docno
			INNER JOIN user ON attendance.userid = user.userid
			INNER JOIN schedule ON schedule.idschedule = attendance.sche1
			INNER JOIN schedule_settings ON schedule_settings.idschedule = schedule.idschedule
			INNER JOIN schedule_weekday ON schedule_weekday.idschedule = schedule.idschedule
		WHERE schedule_weekday.idschedule_dow = DAYOFWEEK(attendance.date) 
		AND (attendance.date BETWEEN f_osform_td.datefrom AND f_osform_td.dateto)
		AND f_osform_th.docno = '$docno'");
        return $query->result_array();
    }
    
    //buat ngambil schedule time in & out for sick leave 
    function getsickscheduletime($docno){
        $query = $this->db->query("SELECT attendance.date, schedule_weekday.sche_in, f_osform_th.docno,
		CASE 
			WHEN (schedule_weekday.sche_ot != '')
			THEN schedule_weekday.sche_ot
			ELSE schedule_weekday.sche_out
		END AS sche_out,
		
		CASE
		WHEN
		CAST(SUBSTR(TIMEDIFF(schedule_weekday.sche_out,schedule_weekday.sche_in),1,2) AS DECIMAL(12,2)) > 0
		THEN
		CAST(SUBSTR(TIMEDIFF(schedule_weekday.sche_out,schedule_weekday.sche_in),1,2) AS DECIMAL(12,2))
		
		ELSE ((SUBSTR(schedule_weekday.sche_out,1,2) + 12) - (SUBSTR(schedule_weekday.sche_in,1,2) - 12))
		END AS workhour,
		
		CASE
			WHEN CAST(REPLACE(TIMEDIFF(schedule_weekday.sche_ot,schedule_weekday.sche_in),':','.') AS DECIMAL(12,2)) > 8
			THEN CAST(REPLACE(TIMEDIFF(schedule_weekday.sche_ot,schedule_weekday.sche_in),':','.') AS DECIMAL(12,2)) - 8
	
			WHEN CAST(SUBSTR(TIMEDIFF(schedule_weekday.sche_ot,schedule_weekday.sche_in),1,2) AS DECIMAL(12,2)) = -1
			THEN ((SUBSTR(schedule_weekday.sche_ot,1,2) + 12) - (SUBSTR(schedule_weekday.sche_in,1,2) - 12)) - 8
		ELSE '0'
                
		END AS othour, f_osform_td.empid
		
		FROM attendance
			INNER JOIN f_osform_td ON f_osform_td.empid = attendance.userid
			INNER JOIN f_osform_th ON f_osform_th.docno = f_osform_td.docno
			INNER JOIN user ON attendance.userid = user.userid
			INNER JOIN schedule ON schedule.idschedule = attendance.sche1
			INNER JOIN schedule_settings ON schedule_settings.idschedule = schedule.idschedule
			INNER JOIN schedule_weekday ON schedule_weekday.idschedule = schedule.idschedule
                        
		WHERE 
		CASE 

		WHEN DATEDIFF(f_osform_td.dateto, f_osform_td.datefrom) > 15
		THEN schedule_weekday.idschedule_dow = DAYOFWEEK(attendance.date) 
		AND (attendance.date BETWEEN f_osform_td.datefrom AND f_osform_td.dateto)
                AND (attendance.daytype != 'R' AND attendance.daytype != 'O' AND attendance.daytype != 'H' AND DAYOFWEEK(attendance.date) != '7')
		
                WHEN DATEDIFF(f_osform_td.dateto, f_osform_td.datefrom) < 15
		THEN schedule_weekday.idschedule_dow = DAYOFWEEK(attendance.date) 
		AND (attendance.date BETWEEN f_osform_td.datefrom AND f_osform_td.dateto)
                AND (attendance.daytype != 'R' AND attendance.daytype != 'O' AND attendance.daytype != 'H')
                END
		AND f_osform_th.docno = '$docno'");
        return $query->result_array();
    }


    /**
     * @param $docno
     * @return mixed
     */
    function getexpectedschedule($docno){
        $query = $this->db->query("SELECT attendance.date, f_osform_td.idplanschd, f_osform_td.empid , f_osform_th.docno
                                  FROM attendance                                  
                                  INNER JOIN f_osform_td ON f_osform_td.empid = attendance.userid
                                  INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                                  WHERE f_osform_th.docno = '$docno' AND
                                  (attendance.date BETWEEN f_osform_td.datefrom AND f_osform_td.dateto)");
        return $query->result_array();
    }
    
    function getexpectedroosterhead($docno){
        $query = $this->db->query("SELECT f_osform_td.idplnroster, f_osform_td.empid , f_osform_th.docno
                                  FROM user_info                                  
                                  INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                                  INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                                  WHERE f_osform_th.docno = '$docno'");
        return $query->result_array();
    }
    
    function getAllForm(){
        $query = $this->db->query("SELECT f_osform_th.docno, f_osform_th.docdate, user.Name, user.lastname ,f_tpform_os.desc, f_osform_th.status, f_osform_th.remark
                                  FROM f_osform_th
                                  INNER JOIN f_tpform_os ON f_tpform_os.id = f_osform_th.typeform
                                  INNER JOIN user ON user.userid = f_osform_th.creator
                                  ORDER BY f_osform_th.docno DESC
                                  ");
         return $query->result_array();
    }
    
    function removeOTMP($datefrom, $dateto){
        $query = $this->db->query("SELECT attendance.userid, attendance.date, attendance.att_in, attendance.att_out, attendance.othour 
                                FROM attendance 
                                INNER JOIN user ON attendance.userid = user.userid
                                INNER JOIN user_group ON user_group.id = user.user_group 
                                WHERE (attendance.date BETWEEN '$datefrom' AND '$dateto') AND (attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) 
                                AND attendance.othour != 0 AND user_group.parentId = '99'");
        return $query->result_array();
    }
    
    function getexpectedroosterdetail($docno){
        $query = $this->db->query("(
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-01')) AS 'Date',  
                roster_calendar.daytype1 AS 'typeday' ,roster_calendar.sche1_1 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-01')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-02')) AS 'Date',  
                roster_calendar.daytype2 AS 'typeday' ,roster_calendar.sche1_2 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-02')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-03')) AS 'Date',  
                roster_calendar.daytype3 AS 'typeday' ,roster_calendar.sche1_3 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-03')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-04')) AS 'Date',  
                roster_calendar.daytype4 AS 'typeday' ,roster_calendar.sche1_4 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-04')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-05')) AS 'Date',  
                roster_calendar.daytype5 AS 'typeday' ,roster_calendar.sche1_5 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-05')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-06')) AS 'Date',  
                roster_calendar.daytype6 AS 'typeday' ,roster_calendar.sche1_6 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-06')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-07')) AS 'Date',  
                roster_calendar.daytype7 AS 'typeday' ,roster_calendar.sche1_7 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-07')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-08')) AS 'Date',  
                roster_calendar.daytype8 AS 'typeday' ,roster_calendar.sche1_8 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-08')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-09')) AS 'Date',  
                roster_calendar.daytype9 AS 'typeday' ,roster_calendar.sche1_9 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-09')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-10')) AS 'Date',  
                roster_calendar.daytype10 AS 'typeday' ,roster_calendar.sche1_10 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-10')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-11')) AS 'Date',  
                roster_calendar.daytype11 AS 'typeday' ,roster_calendar.sche1_11 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-11')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-12')) AS 'Date',  
                roster_calendar.daytype12 AS 'typeday' ,roster_calendar.sche1_12 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-12')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-13')) AS 'Date',  
                roster_calendar.daytype13 AS 'typeday' ,roster_calendar.sche1_13 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-13')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-14')) AS 'Date',  
                roster_calendar.daytype14 AS 'typeday' ,roster_calendar.sche1_14 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-14')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-15')) AS 'Date',  
                roster_calendar.daytype15 AS 'typeday' ,roster_calendar.sche1_15 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-15')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-16')) AS 'Date',  
                roster_calendar.daytype16 AS 'typeday' ,roster_calendar.sche1_16 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-16')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-17')) AS 'Date',  
                roster_calendar.daytype17 AS 'typeday' ,roster_calendar.sche1_17 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-17')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-18')) AS 'Date',  
                roster_calendar.daytype18 AS 'typeday' ,roster_calendar.sche1_18 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-18')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-19')) AS 'Date',  
                roster_calendar.daytype19 AS 'typeday' ,roster_calendar.sche1_19 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-19')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-20')) AS 'Date',  
                roster_calendar.daytype20 AS 'typeday' ,roster_calendar.sche1_20 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-20')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-21')) AS 'Date',  
                roster_calendar.daytype21 AS 'typeday' ,roster_calendar.sche1_21 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-21')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-22')) AS 'Date',  
                roster_calendar.daytype22 AS 'typeday' ,roster_calendar.sche1_22 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-22')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-23')) AS 'Date',  
                roster_calendar.daytype23 AS 'typeday' ,roster_calendar.sche1_23 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-23')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-24')) AS 'Date',  
                roster_calendar.daytype24 AS 'typeday' ,roster_calendar.sche1_24 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-24')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-25')) AS 'Date',  
                roster_calendar.daytype25 AS 'typeday' ,roster_calendar.sche1_25 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-25')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-26')) AS 'Date',  
                roster_calendar.daytype26 AS 'typeday' ,roster_calendar.sche1_26 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-26')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-27')) AS 'Date',  
                roster_calendar.daytype27 AS 'typeday' ,roster_calendar.sche1_27 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-27')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-28')) AS 'Date',  
                roster_calendar.daytype28 AS 'typeday' ,roster_calendar.sche1_28 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-28')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-29')) AS 'Date',  
                roster_calendar.daytype29 AS 'typeday' ,roster_calendar.sche1_29 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-29')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno' AND roster_calendar.daytype29 != '-'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-30')) AS 'Date',  
                roster_calendar.daytype30 AS 'typeday' ,roster_calendar.sche1_30 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-30')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno' AND roster_calendar.daytype30 != '-'
                )
                UNION
                (
                SELECT roster_calendar.idroster, 
                DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-31')) AS 'Date',  
                roster_calendar.daytype31 AS 'typeday' ,roster_calendar.sche1_31 AS 'scheduleno', user_info.userid
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
                INNER JOIN f_osform_td ON f_osform_td.empid = user_info.userid
                INNER JOIN f_osform_th ON f_osform_td.docno = f_osform_th.docno
                WHERE roster_calendar.idroster = f_osform_td.idplnroster 
                AND DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-31')) BETWEEN f_osform_td.datefrom AND DATE(CONCAT(YEAR(f_osform_td.datefrom),'-12-31'))
                AND f_osform_th.docno = '$docno' AND roster_calendar.daytype31 != '-'
                )
                ");
        return $query->result_array();
    }
}
?>