<?php

class m_leave extends CI_Model
{

    function getPendingLeave($id)
    {
        $query = $this->db->query("SELECT
										tr_leave.leaveid,
										tr_leave.docdate,
										tr_leave.total_days,
										tr_leave.docstatus,
										tr_leave.reason_leave,
										tr_leave.contact_no,
										tr_leave.leave_from,
										tr_leave.leave_to,
										tr_leave.appv_comment,
										f_approver_staff.userid AS 'Approver',
										USER .ic,
										USER .name,
										USER .lastname,
										USER .Gender,
										USER .ic,
										emp_level.`desc`,
										user_group.gName,
										tr_leave.remark_type,
										emp_level.`limit`,
									 	emp_level.c_limit,
									 	tr_leave.app_date
									FROM
										tr_leave
									INNER JOIN USER ON tr_leave.r_id = USER .userid
									INNER JOIN user_group ON USER .User_Group = user_group.id
									INNER JOIN emp_level ON emp_level.id_emp = USER .define_1
									LEFT JOIN f_approver_staff ON f_approver_staff.user_group = user_group.id
									WHERE f_approver_staff.userid = '$id' AND tr_leave.docstatus = '0'");
        return $query->result_array();
    }

    function getApprovalstage($leaveid)
    {
        $query = $this->db->query("SELECT
						`user`.userid, CONCAT(user.`Name`,' ',user.lastname) AS full_name, user_group.gName, a.userid AS 'app_id', CONCAT(a.`Name`,' ',a.lastname) AS app_full_name, a.Email
						FROM
						`user`
						INNER JOIN user_group ON `user`.User_Group = user_group.id
						INNER JOIN f_approver_staff ON user_group.id = f_approver_staff.user_group
						INNER JOIN tr_leave ON `user`.userid = tr_leave.r_id
						INNER JOIN user a ON a.userid = f_approver_staff.userid
						WHERE tr_leave.leaveid = '$leaveid'");
		return $query->result_array();
    }

    function getFA()
    {
        $query = $this->db->query("SELECT * FROM remark where idremark = '5' OR idremark = '8'");
        return $query->result_array();
    }

    function getviewLeave($leaveid)
    {
        $query = $this->db->query("SELECT
									tr_leave.leaveid,
									tr_leave.r_id,
									f_approver_staff.userid AS 'Approver',
									tr_leave.docdate,
									tr_leave.total_days,
									tr_leave.docstatus,
									tr_leave.reason_leave,
									tr_leave.contact_no,
									tr_leave.leave_from,
									tr_leave.leave_to,
									tr_leave.appv_comment,
									tr_leave.app_date,
									USER .ic,
									USER .name,
									USER .lastname,
									USER .gender,
									USER .ic,
									emp_level.desc,
									user_group.gName,
									T2. NAME AS 'appname',
									T2.Lastname AS 'applastname',
									tr_leave.location,
									tr_leave.remark_type,
									tr_leave.leavetype,
									tr_leave.formtype,
									emp_level.limit,
								 emp_level.c_limit,
								 emp_level.cmp_limit,
								 emp_level.exam_limit,
								 USER .designation,
								 tr_leave.ann_leave_allw,
								 tr_leave.total_days,
								 USER .IssueDate,
								 tr_leave.timein,
								 tr_leave.timeout
								FROM
									tr_leave
								INNER JOIN USER ON tr_leave.r_id = USER .userid
								INNER JOIN user_group ON USER .User_Group = user_group.id
								INNER JOIN emp_level ON emp_level.id_emp = USER .define_1
								LEFT JOIN USER T2 ON tr_leave.appv = T2.userid
								INNER JOIN f_approver_staff ON user_group.id = f_approver_staff.user_group
								WHERE
									tr_leave.leaveid = '$leaveid'");
        return $query->result_array();
    }

    function getLeave($id)
    {
        $query = $this->db->query("SELECT
										tr_leave.leaveid,
										tr_leave.docdate,
										tr_leave.total_days,
										tr_leave.docstatus,
										tr_leave.reason_leave,
										tr_leave.contact_no,
										tr_leave.leave_from,
										tr_leave.leave_to,
										tr_leave.appv_comment,
										USER .ic,
										USER .name,
										USER .lastname,
										USER .Gender,
										USER .ic,
										emp_level.`desc`,
										user_group.gName,
										tr_leave.remark_type,
										emp_level.`limit`,
									 	emp_level.c_limit,
									 	tr_leave.app_date
									FROM
										tr_leave
									INNER JOIN USER ON tr_leave.r_id = USER .userid
									INNER JOIN user_group ON USER .User_Group = user_group.id
									INNER JOIN emp_level ON emp_level.id_emp = USER .define_1
									LEFT JOIN f_approver_staff ON f_approver_staff.user_group = user_group.id
									WHERE f_approver_staff.userid = '$id' OR user.userid = '$id'");
        return $query->result_array();
    }
    /*
    function getLeaveuser($id) {
        $query = $this->db->query("SELECT tr_leave.leaveid, tr_leave.docdate, tr_leave.total_days, tr_leave.docstatus, tr_leave.reason_leave, tr_leave.contact_no, tr_leave.leave_from, tr_leave.leave_to, tr_leave.appv_comment,
                                  user.ic, user.Name, user.lastname, user.Gender, user.ic, emp_level.desc, user_group.gName, leavetype.leavetypename , tr_leave.remark_type,
                                  emp_level.limit, emp_level.c_limit,tr_leave.app_date
                                  FROM tr_leave
                                  INNER JOIN user ON tr_leave.r_id = user.userid
                                  INNER JOIN user_group ON user.User_Group = user_group.id
                                  INNER JOIN leavetype ON tr_leave.leavetype = leavetype.idleavetype
                                  INNER JOIN emp_level ON emp_level.id_emp = user.define_1
                                  
                                  WHERE user.userid = '$id'");
        return $query->result_array();
    }
 	 */
    //buat menghitung total hari cuti
    function validationdate($datefrom, $dateto, $user)
    {
        $query = $this->db->query("SELECT COUNT(attendance.date) AS 'total'
                            FROM attendance                  
                            WHERE                 
                            (attendance.date BETWEEN '$datefrom' AND '$dateto')
                            AND (attendance.daytype = 'W')
                            AND (attendance.userid = '$user')");
        $result = $query->result_array();

        if (isset($result[0]['total'])) {
            return $result[0]['total'];
        } else {
            return 0;
        }
    }

    function attendanceleave($leaveid)
    {
        $query = $this->db->query("SELECT attendance.date, tr_leave.leavetype, tr_leave.leaveid, attendance.userid
                                FROM 
                                user 
                                INNER JOIN tr_leave ON user.userid = tr_leave.r_id
                                INNER JOIN attendance ON user.userid = attendance.userid
                                WHERE
                                (attendance.date BETWEEN tr_leave.leave_from AND tr_leave.leave_to)
                                AND
                                tr_leave.leaveid = '$leaveid'
                                AND (attendance.daytype = 'W')");
        return $query->result_array();
    }

    //buat ngambil schedule time in & out 
    function getscheduletime($docno)
    {
        $query = $this->db->query("SELECT attendance.date, schedule_weekday.sche_in, tr_leave.leaveid,
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
		END AS othour, user.userid, tr_leave.formtype
		
		FROM attendance
			INNER JOIN tr_leave ON tr_leave.r_id = attendance.userid
			INNER JOIN user ON attendance.userid = user.userid
			INNER JOIN schedule ON schedule.idschedule = attendance.sche1
			INNER JOIN schedule_settings ON schedule_settings.idschedule = schedule.idschedule
			INNER JOIN schedule_weekday ON schedule_weekday.idschedule = schedule.idschedule
		WHERE schedule_weekday.idschedule_dow = DAYOFWEEK(attendance.date) 
		AND (attendance.date BETWEEN tr_leave.leave_from AND tr_leave.leave_to)
		AND tr_leave.leaveid = '$docno'");
        return $query->result_array();
    }

    function reportattendance($cat, $datefrom, $dateto)
    {
        $query = $this->db->query("SELECT
	USER .userid,
	USER .ic AS emp_no,
	CONCAT(
		USER . NAME,
		' ',
		USER .lastname
	) AS 'EmployeeName',
	user_group.gName AS 'Dept',
	Count(
		CASE
		WHEN attendance.daytype = 'W' THEN
			'1'
		ELSE
			NULL
		END
	) AS 'Total_Work_Days',
	Count(
		CASE
		WHEN attendance.leavetype = 0
		AND attendance.daytype = 'W'
		AND attendance.workhour != 0 THEN
			'1'
		ELSE
			NULL
		END
	) AS 'Present_Work_Days',
	SUBSTRING_INDEX(
		SEC_TO_TIME(
			SUM(
				CASE
				WHEN attendance.leavetype = 0
				AND attendance.daytype = 'W'
				AND attendance.workhour != 0 THEN
					(
						(
							SUBSTRING_INDEX(workhour, '.', 1) * 3600
						) + (
							SUBSTRING_INDEX(workhour, '.' ,- 1) * 60
						)
					)
				ELSE
					0
				END
			)
		),
		':',
		2
	) AS 'Total_Work(Hours)',
	SUBSTRING_INDEX(
		SEC_TO_TIME(
			SUM(
				CASE
				WHEN attendance.leavetype = 0
				AND attendance.daytype = 'W'
				AND attendance.workhour != 0 THEN
					(
						(
							SUBSTRING_INDEX(othour, '.', 1) * 3600
						) + (
							SUBSTRING_INDEX(othour, '.' ,- 1) * 60
						)
					)
				ELSE
					0
				END
			)
		),
		':',
		2
	) AS 'Total_OT(Hours)',
	Count(
		CASE
		WHEN attendance.leavetype = 0
		AND (
			attendance.daytype = 'R'
			OR attendance.daytype = 'O'
		)
		AND attendance.workhour != 0 THEN
			'1'
		ELSE
			NULL
		END
	) AS 'Present_Rest_Days',
	SUBSTRING_INDEX(
		SEC_TO_TIME(
			SUM(
				CASE
				WHEN attendance.leavetype = 0
				AND attendance.daytype = 'R'
				OR attendance.daytype = 'O'
				AND attendance.workhour != 0 THEN
					(
						(
							SUBSTRING_INDEX(workhour, '.', 1) * 3600
						) + (
							SUBSTRING_INDEX(workhour, '.' ,- 1) * 60
						)
					)
				ELSE
					0
				END
			)
		),
		':',
		2
	) AS 'Total_Rest(Hours)',
	Count(
		CASE
		WHEN attendance.leavetype = 0
		AND attendance.daytype = 'H'
		AND attendance.workhour != 0 THEN
			'1'
		ELSE
			NULL
		END
	) AS 'Present_Holiday',
	SUBSTRING_INDEX(
		SEC_TO_TIME(
			SUM(
				CASE
				WHEN attendance.leavetype = 0
				AND attendance.daytype = 'H'
				AND attendance.workhour != 0 THEN
					(
						(
							SUBSTRING_INDEX(workhour, '.', 1) * 3600
						) + (
							SUBSTRING_INDEX(workhour, '.' ,- 1) * 60
						)
					)
				ELSE
					0
				END
			)
		),
		':',
		2
	) AS 'Total_Holiday(Hours)',
	SUBSTRING_INDEX(
		SEC_TO_TIME(
			SUM(
				CASE
				WHEN attendance.daytype = 'W'
				AND attendance.in_s != 0 THEN
					(
						SUBSTRING_INDEX(attendance.in_s, '.', 1) * 3600
					) + (
						SUBSTRING_INDEX(attendance.in_s, '.' ,- 1) * 60
					)
				ELSE
					0
				END
			)
		),
		':',
		2
	) AS 'Late_in(Hours)',
	SUBSTRING_INDEX(
		SEC_TO_TIME(
			SUM(
				CASE
				WHEN attendance.daytype = 'W'
				AND attendance.out_s != 0 THEN
					(
						SUBSTRING_INDEX(attendance.out_s, '.', 1) * 3600
					) + (
						SUBSTRING_INDEX(attendance.out_s, '.' ,- 1) * 60
					)
				ELSE
					0
				END
			)
		),
		':',
		2
	) AS 'Early_out(Hours)',
	SUBSTRING_INDEX(
		SEC_TO_TIME(
			SUM(
				CASE
				WHEN attendance.daytype = 'W'
				AND attendance.out_s != 0 THEN
					(
						SUBSTRING_INDEX(attendance.out_s, '.', 1) * 3600
					) + (
						SUBSTRING_INDEX(attendance.out_s, '.' ,- 1) * 60
					)
				ELSE
					0
				END
			) + SUM(
				CASE
				WHEN attendance.daytype = 'W'
				AND attendance.in_s != 0 THEN
					(
						SUBSTRING_INDEX(attendance.in_s, '.', 1) * 3600
					) + (
						SUBSTRING_INDEX(attendance.in_s, '.' ,- 1) * 60
					)
				ELSE
					0
				END
			)
		),
		':',
		2
	) AS 'Total_Short(Hours)',
	CASE
WHEN SUBSTRING_INDEX(
	SEC_TO_TIME(
		SUM(
			CASE
			WHEN attendance.daytype = 'W'
			AND attendance.out_s != 0 THEN
				(
					SUBSTRING_INDEX(attendance.out_s, '.', 1) * 3600
				) + (
					SUBSTRING_INDEX(attendance.out_s, '.' ,- 1) * 60
				)
			ELSE
				0
			END
		) + SUM(
			CASE
			WHEN attendance.daytype = 'W'
			AND attendance.in_s != 0 THEN
				(
					SUBSTRING_INDEX(attendance.in_s, '.', 1) * 3600
				) + (
					SUBSTRING_INDEX(attendance.in_s, '.' ,- 1) * 60
				)
			ELSE
				0
			END
		)
	),
	':',
	2
) / 8 > 1 THEN
	SUBSTRING_INDEX(
		SUBSTRING_INDEX(
			SEC_TO_TIME(
				SUM(
					CASE
					WHEN attendance.daytype = 'W'
					AND attendance.out_s != 0 THEN
						(
							SUBSTRING_INDEX(attendance.out_s, '.', 1) * 3600
						) + (
							SUBSTRING_INDEX(attendance.out_s, '.' ,- 1) * 60
						)
					ELSE
						0
					END
				) + SUM(
					CASE
					WHEN attendance.daytype = 'W'
					AND attendance.in_s != 0 THEN
						(
							SUBSTRING_INDEX(attendance.in_s, '.', 1) * 3600
						) + (
							SUBSTRING_INDEX(attendance.in_s, '.' ,- 1) * 60
						)
					ELSE
						0
					END
				)
			),
			':',
			2
		) / 8,
		'.',
		1
	)
ELSE
	0
END AS 'Total_Short(Days)',
 Count(
	CASE
	WHEN attendance.leavetype = 0
	AND attendance.remark = 0
	AND attendance.daytype = 'W'
	AND (
		(
			attendance.att_in IS NULL
			AND attendance.att_out IS NULL
		)
		OR (
			attendance.att_in IS NULL
			AND attendance.att_out = ''
		)
		OR (
			attendance.att_in = ''
			AND attendance.att_out IS NULL
		)
		OR (
			(
				attendance.att_in IS NOT NULL
				AND attendance.att_out IS NULL
				AND attendance.att_in != ''
			)
			OR (
				attendance.att_out IS NOT NULL
				AND attendance.att_out != ''
				AND attendance.att_in IS NULL
			)
		)
	) THEN
		'1'
	ELSE
		NULL
	END
) AS 'Absent',
 Count(
	CASE attendance.leavetype
	WHEN '2' THEN
		1
	ELSE
		NULL
	END
) AS 'Annual_Leave',
 Count(
	CASE attendance.leavetype
	WHEN '1' THEN
		1
	ELSE
		NULL
	END
) AS 'Sick_Leave',
 Count(
	CASE attendance.leavetype
	WHEN '3' THEN
		1
	ELSE
		NULL
	END
) AS 'Casual_Leave',
 Count(
	CASE attendance.leavetype
	WHEN '4' THEN
		1
	ELSE
		NULL
	END
) AS 'Compassionate_Leave',
 Count(
	CASE attendance.leavetype
	WHEN '5' THEN
		1
	ELSE
		NULL
	END
) AS 'Examination_Leave',
 Count(
	CASE attendance.leavetype
	WHEN '6' THEN
		1
	ELSE
		NULL
	END
) AS 'Maternity_Leave',
 Count(
	CASE attendance.leavetype
	WHEN '7' THEN
		1
	ELSE
		NULL
	END
) AS 'Field_Work'
FROM
	USER
INNER JOIN user_group ON `user`.User_Group = user_group.id
INNER JOIN attendance ON `user`.userid = attendance.userid
WHERE
user_group.parentId = '$cat' AND attendance.date between '$datefrom' AND '$dateto'
GROUP BY
	USER .userid,
	USER .ic,
	`user`.`Name`,
	`user`.lastname,
	user_group.gName
ORDER BY
	user_group.gName
");
        return $query->result_array();
    }

    function reportleave($datefrom, $dateto)
    {
        $query = $this->db->query("SELECT
					USER .userid,
					USER .ic AS 'emp_no',
					CONCAT(
						USER . NAME,
						' ',
						USER .lastname
					) AS 'EmployeeName',
					user_group.gName AS 'Dept',
					emp_level.`limit` AS 'Annual_Entitled',
					COUNT(attendance.leavetype) + f_leave_openbalance.t_annual AS 'Annual_Used',
					(
						emp_level.`limit` - (COUNT(attendance.leavetype) + f_leave_openbalance.t_annual)
					) AS 'Annual_Remaining',
					emp_level.c_limit AS 'Casual',
					COUNT(a.leavetype) AS 'Casual_Used',
					(
						emp_level.`c_limit` - COUNT(a.leavetype)
					) AS 'Casual_Remaining',
					COUNT(s.leavetype) AS 'Sick_Used'
				FROM
					USER
				INNER JOIN emp_level ON USER .define_1 = emp_level.id_emp
				INNER JOIN user_group ON `user`.User_Group = user_group.id
				LEFT JOIN f_leave_openbalance ON `user`.userid = f_leave_openbalance.userid
				LEFT JOIN attendance ON `user`.userid = attendance.userid
				AND attendance.leavetype = '2'
				AND attendance.date BETWEEN '$datefrom'
				AND '$dateto'
				LEFT JOIN attendance a ON `user`.userid = a.userid
				AND a.leavetype = '3'
				AND a.date BETWEEN '$datefrom'
				AND '$dateto'
				LEFT JOIN attendance s ON `user`.userid = s.userid
				AND s.leavetype = '1'
				AND s.date BETWEEN '$datefrom'
				AND '$dateto'
				WHERE
					user_group.parentId IN ('4', '273','283','7','3','234') AND `user`.define_1 != '3'
				GROUP BY
					`user`.userid,
					`user`.`Name`,
					USER .lastname,
					emp_level.`limit`
				ORDER BY
					`user`.userid, user_group.gName");
        return $query->result_array();
    }

    function leavebalanceuser($datefrom, $dateto, $id)
    {
        $query = $this->db->query("SELECT
									USER .userid,
									USER .ic,
									USER .name,
									USER .lastname,
									USER .gender,
									USER .Email,
									user_group.gName,
									USER .designation,
									USER .IssueDate,
									CONCAT(
										USER . NAME,
										' ',
										USER .lastname
									) AS 'EmployeeName',
									user_group.gName AS 'Dept',
									emp_level.`limit` AS 'Annual_Entitled',
									COUNT(attendance.leavetype) + IFNULL(cast(f_leave_openbalance.t_annual AS DECIMAL),0) AS 'Annual_Used',
									IFNULL(tr_leave.total_days,0) AS 'Annual_Planed',
									CAST(emp_level.`limit` AS DECIMAL) - (cast((COUNT(attendance.leavetype)) AS DECIMAL ) + IFNULL(cast(f_leave_openbalance.t_annual AS DECIMAL),0) + IFNULL(cast(tr_leave.total_days AS DECIMAL),0)) AS 'Annual_Remaining',
									emp_level.c_limit AS 'Casual',
									COUNT(a.leavetype) + IFNULL(cast(f_leave_openbalance.t_casual AS DECIMAL),0) AS 'Casual_Used',
									CAST(emp_level.`c_limit` AS DECIMAL) - (cast((COUNT(a.leavetype)) AS DECIMAL ) + IFNULL(cast(f_leave_openbalance.t_casual AS DECIMAL),0) + IFNULL(cast(tr_leave.total_days AS DECIMAL),0)) AS 'Casual_Remaining',
									COUNT(s.leavetype) AS 'Sick_Used'
								FROM
									USER
								INNER JOIN emp_level ON USER .define_1 = emp_level.id_emp
								INNER JOIN user_group ON `user`.User_Group = user_group.id
								LEFT JOIN f_leave_openbalance ON `user`.userid = f_leave_openbalance.userid
								LEFT JOIN tr_leave ON `user`.userid = tr_leave.r_id
								AND tr_leave.leavetype = '2'
								AND tr_leave.docstatus = '0'
								AND (
									tr_leave.leave_to BETWEEN '$datefrom'
									AND '$dateto'
								)
								LEFT JOIN attendance ON `user`.userid = attendance.userid
								AND attendance.leavetype = '2'
								AND attendance.date BETWEEN '$datefrom'
								AND '$dateto'
								LEFT JOIN attendance a ON `user`.userid = a.userid
								AND a.leavetype = '3'
								AND a.date BETWEEN '$datefrom'
								AND '$dateto'
								LEFT JOIN attendance s ON `user`.userid = s.userid
								AND s.leavetype = '1'
								AND s.date BETWEEN '$datefrom'
								AND '$dateto'
								WHERE
									`user`.userid = '$id'
								AND `user`.define_1 != '3'
								GROUP BY
									`user`.userid,
									`user`.`Name`,
									USER .lastname,
									emp_level.`limit`
				");
        return $query->result_array();
    }

    function yearatt()
    {
        $query = $this->db->query("SELECT YEAR(attendance.date) as 'years' FROM attendance WHERE YEAR(attendance.date) = '2015'
                    GROUP BY YEAR(attendance.date)");
        return $query->result_array();
    }

    function catdept()
    {
        $query = $this->db->query("SELECT id, gName FROM user_group WHERE parentId IS NULL");
        return $query->result_array();
    }
}

?>