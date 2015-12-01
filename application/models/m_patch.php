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
class m_patch extends CI_Model {
    function getErrorDaytype(){
        $query = $this->db->query("
                                  SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype1 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-01'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype2 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-02'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()						
								UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype3 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-03'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
								UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype4 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-04'))
								WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
								UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype5 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-05'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
								UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype6 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-06'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
								UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype7 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-07'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
								UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype8 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-08'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype9 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-09'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype10 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-10'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype11 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-11'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype12 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-12'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype13 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-13'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype14 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-14'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype15 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-15'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype16 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-16'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype17 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-17'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype18 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-18'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype19 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-19'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype20 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-20'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype21 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-21'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype21 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-21'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype22 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-22'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype23 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-23'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype24 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-24'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype25 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-25'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype26 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-26'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype27 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-27'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype28 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-28'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype29 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-29'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype30 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-30'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()
UNION
SELECT roster_calendar.idroster, 
                attendance.date AS 'Date',  
                roster_calendar.daytype31 AS 'typeday' ,user_info.userid,
								attendance.att_in, attendance.att_out
                FROM roster_calendar
                INNER JOIN user_info ON roster_calendar.idroster = user_info.dutygroup
								INNER JOIN attendance ON user_info.userid = attendance.userid AND attendance.date = DATE(CONCAT(roster_calendar.year,'-',roster_calendar.month,'-31'))
                WHERE (attendance.daytype = '' OR attendance.daytype IS NULL) AND 
								((attendance.att_in IS NOT NULL AND attendance.att_out IS NULL) OR 
								(attendance.att_in IS NULL AND attendance.att_out IS NOT NULL) OR
								(attendance.att_in IS NOT NULL AND attendance.att_out IS NOT NULL)) 
								AND attendance.date BETWEEN ADDDATE(CURDATE(), -7) AND CURDATE()");
        return $query->result_array();
    }
}
?>