<?php

class manage extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged_in')) {
            redirect('/login/');
        }
        $this->load->model('m_setting');
        $this->load->model('m_user');
        $this->load->model('m_leave');
    }

    function index()
    {
        $id = $this->session->userdata('userid');
        $data['title'] = $this->m_setting->getSetting();
        $data['leave'] = $this->m_leave->getLeave($id);
        $data['head'] = "lyt_main/head";
        $data['header'] = "lyt_main/header";
        $data['sidebar'] = "lyt_main/sidebar";
        $data['pagetitle'] = "Manage Form";
        $data['content'] = "leave/v_manage";
        $data['footer'] = "lyt_main/footer";
        $this->load->view('tpl_main', $data);
    }

    function savepdf($formid)
    {
        if (is_numeric($formid) == TRUE) {
            $this->load->library('pdf_2');
            $valid = $this->m_leave->getviewLeave($formid);

            if (count($valid) == 0) {
                redirect('/eform/manage/');
            }

            $data['title'] = $this->m_setting->getSetting();
            $data['form'] = $this->m_leave->getviewLeave($formid);

            $html = $this->load->view('leave/v_pdf', $data, true);
            $this->pdf_2->pdf_create($html, 'DocNo-' . $valid[0]['leaveid']);
            //$this->load->view('tpl_main', $data);
            //$this->load->view('leave/v_pdf', $data);
        }
    }

    function excel()
    {
        ////load our new PHPExcel library
        $this->load->library('PHPExcel');
        $id = $this->session->userdata('userid');
        $dept = $this->session->userdata('User_Group');

        $leave = $this->m_leave->getLeave($dept);

        $data = array();
        $data[] = array("# Doc No.", "Doc Date", "Employee ID", "Department", "First Name", "Last Name", "Leave Type", "Approved By", "Approved Date", "Status");
        $data[] = array("# Doc No.", "Doc Date", "Employee ID", "Department", "First Name", "Last Name", "Leave Type", "Approved By", "Approved Date", "Status");

        foreach ($leave as $row) {
            $tmpdate = "";
            $tmpdocstatus = "";

            if ($row['docstatus'] == 0) {
                $tmpdocstatus = "Pending";
            } else if ($row['docstatus'] == 1) {
                $tmpdocstatus = "Approve";
            } else if ($row['docstatus'] == 2) {
                $tmpdocstatus = "Reject";
            }

            if ($row['app_date'] != "0000-00-00 00:00:00") {
                $tmpdate = date('d/m/Y', strtotime(str_replace('-', '/', $row['app_date'])));
            }
            $data[] = array($row['leaveid'], $row['docdate'], $row['ic'], $row['gName'], $row['Name'], $row['lastname'], $row['leavetypename'], $row['appname'] . " " . $row['applastname'], $tmpdate, $tmpdocstatus);


        }
        //excel export
        $sheet = $this->phpexcel->getActiveSheet();

        for ($i = 0; $i < count($data); $i++) {
            $sheet->setCellValue("A" . $i, $data[$i][0]);
            $sheet->setCellValue("B" . $i, $data[$i][1]);
            $sheet->setCellValue("C" . $i, $data[$i][2]);
            $sheet->setCellValue("D" . $i, $data[$i][3]);
            $sheet->setCellValue("E" . $i, $data[$i][4]);
            $sheet->setCellValue("F" . $i, $data[$i][5]);
            $sheet->setCellValue("G" . $i, $data[$i][6]);
            $sheet->setCellValue("H" . $i, $data[$i][7]);
            $sheet->setCellValue("I" . $i, $data[$i][8]);
            $sheet->setCellValue("J" . $i, $data[$i][9]);
        }
        $writer = new PHPExcel_Writer_Excel5($this->phpexcel);

        $filename = 'just_some_random_name.xls'; //save our workbook as this file name
        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="' . $filename . '"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache
        $writer->save('php://output');
    }

    function view($leaveid)
    {

        if (is_numeric($leaveid) == TRUE) {
            $this->session->set_userdata('l_view', $leaveid);
            $this->session->set_userdata('l_readonly', 1);
            $this->session->set_userdata('l_thismanage', 1);

            $leavequery = $this->m_leave->getviewLeave($leaveid);

            //validation if ID not valid
            if (count($leavequery) == 0) {
                redirect('/eform/manage/');
            }

            foreach ($leavequery as $row) {
                //$this->session->set_userdata('l_userid', $row['userid']);
                $this->session->set_userdata('eleaveid', $row['leaveid']);
                if ($row['leavetype'] != NULL || $row['leavetype'] != 0) {
                    $this->session->set_userdata('leave', 0);
                } else if ($row['formtype'] != NULL || $row['formtype'] != 0) {
                    if ($row['formtype'] == '5') {
                        $this->session->set_userdata('leave', 1);
                    } else if ($row['formtype'] == '8') {
                        $this->session->set_userdata('leave', 2);
                    }
                }
            }
            $id = $this->session->userdata('userid');
            $userquery = $this->m_user->getUserdata($id);

            foreach ($userquery as $row) {
                //$this->session->set_userdata('l_userid', $row['userid']);
                $this->session->set_userdata('l_level', $row['id_emp']);
                $this->session->set_userdata('l_limit', $row['limit']);
                $this->session->set_userdata('l_climit', $row['c_limit']);
            }

            $data['eleave'] = $leavequery;
            $data['title'] = $this->m_setting->getSetting();
            $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
            $data['pagetitle'] = "View Form";
            $data['content'] = "leave/v_apply";
            $data['footer'] = "lyt_main/footer";
            $this->load->view('tpl_main', $data);

            if ($this->session->userdata('userid') == $leavequery[0]['r_id'] || $this->session->userdata('userid') == $leavequery[0]['Approver']) {

            } else {
                redirect('/eform/manage/');
            }
        } else {
            redirect('/eform/manage/');
        }
    }
}

?>