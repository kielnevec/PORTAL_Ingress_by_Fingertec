<?php

class apply extends CI_Controller
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

    function sendEmail($leaveid)
    {
        $setting = $this->m_setting->getSetting();
        $getapproval = $this->m_leave->getApprovalstage($leaveid);

        $data['title'] = $this->m_setting->getSetting();
        $data['form'] = $this->m_leave->getviewLeave($leaveid);
        $data['Header'] = 'Dear ' . ucwords(strtolower($getapproval[0]['app_full_name'])) . '<br/><br/>';
        //$this->session->set_flashdata('flash_flag', '1');

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => $setting[0]['stmp_mail'],
            'smtp_port' => 25,
            'smtp_user' => $setting[0]['user_mail'], // change it to yours
            'smtp_pass' => $setting[0]['password_mail'], // change it to yours
            'mailtype' => 'html',
            'charset' => 'iso-8859-1',
            'wordwrap' => TRUE
        );

        $message = $this->load->view('leave/v_pdf', $data, TRUE);
        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from($setting[0]['user_mail']); // change it to yours
        $this->email->to($getapproval[0]['Email']);// change it to yours
        $this->email->subject('Approval Leave Request');
        $this->email->message($message);
        if ($this->email->send()) {

        } else {
            show_error($this->email->print_debugger());
        }
    }

    function user($userid)
    {
        $this->session->set_userdata('leave', 0);
        if (is_numeric($userid) == TRUE && $this->session->userdata('applyuser') == '9') {
            $this->session->set_userdata('l_readonly', 0);
            //$dept = $this->session->userdata('User_Group');

            $this->session->set_userdata('l_thismanage', 0);
            $this->session->set_userdata('l_apply', 1);

            $userquery = $this->m_user->getUserdata($userid);

            if (count($userquery) == 0) {
                redirect('/dashboard/');
            } else {
                foreach ($userquery as $row) {
                    $this->session->set_userdata('l_userid', $row['userid']);
                    $this->session->set_userdata('l_level', $row['id_emp']);
                    $this->session->set_userdata('l_limit', $row['limits']);
                    $this->session->set_userdata('l_climit', $row['c_limit']);
                }

                $data['userdata'] = $userquery;
                //$data['approver'] = $this->m_user->getApprover($dept);

                $data['title'] = $this->m_setting->getSetting();
                $data['leave'] = $this->m_user->getLeave();

                $data['head'] = "lyt_main/head";
                $data['header'] = "lyt_main/header";
                $data['sidebar'] = "lyt_main/sidebar";
                $data['pagetitle'] = "Apply Leave";
                $data['content'] = "leave/v_apply";
                $data['footer'] = "lyt_main/footer";
                $this->load->view('tpl_main', $data);
            }
        } else {
            redirect('/dashboard/');
        }

    }

    function submit()
    {
        $this->load->library('form_validation');
        $reason = $this->input->post('reason');
        $phone = $this->input->post('phone');
        $leavetype = explode('|', $this->input->post('leavetype'));

        $leave_start = $this->input->post('leave_start');
        $leave_end = $this->input->post('leave_end');


        $this->form_validation->set_rules('reason', 'Reason For Leave', 'required');
        $this->form_validation->set_rules('phone', 'Phone Number', 'required');
        $this->form_validation->set_rules('leavetype', 'Leave Type', 'required|callback_checktype');
        $this->form_validation->set_rules('leave_start', 'Leave From', 'required|callback_checkdates');
        $this->form_validation->set_rules('leave_end', 'Leave End', 'required');

        $this->form_validation->set_message('greater_than', 'Please choose the option');

        $this->form_validation->set_error_delimiters('<span class="help-block" style="color:red">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            //nampilih greenbox di view
            $this->session->set_userdata('noticebox', '5');

            $data = array(
                'leavetype' => $leavetype[0],
                'leave_from' => date('Y-m-d', strtotime(str_replace('/', '-', $leave_start))),
                'leave_to' => date('Y-m-d', strtotime(str_replace('/', '-', $leave_end))),
                'ann_leave_allw' => $this->session->userdata('l_limit'),
                'ca_leave_allw' => $this->session->userdata('l_climit'),
                'level' => $this->session->userdata('l_level'),
                'r_id' => $this->session->userdata('l_userid'),
                'reason_leave' => $reason,
                'contact_no' => $phone,
                'total_days' => $this->session->userdata('l_total_days'),
                'docdate' => date('Y-m-d'),
                'remark_type' => $leavetype[1]
            );

            $this->db->insert('tr_leave', $data);
            $leaveid = $this->db->insert_id();
            $this->session->set_userdata('flash_flag', '1');
            $this->sendEmail($leaveid);
            $this->index();
        }
    }

    function index()
    {
        $data['title'] = $this->m_setting->getSetting();
        $this->session->set_userdata('leave', 0);
        $this->session->set_userdata('l_readonly', 0);
        $id = $this->session->userdata('userid');
        $dept = $this->session->userdata('User_Group');
        $this->session->set_userdata('l_thismanage', 0);
        $this->session->set_userdata('l_apply', 1);

        $periodleave = $this->m_setting->getSetting();
        $datefrom = $periodleave[0]['leaveperiod_start'];
        $dateto = $periodleave[0]['leaveperiod_end'];
        $userquery = $this->m_leave->leavebalanceuser($datefrom, $dateto, $id);

        foreach ($userquery as $row) {
            $this->session->set_userdata('l_userid', $row['userid']);
            //$this->session->set_userdata('l_level', $row['id_emp']);
            $this->session->set_userdata('l_limit', $row['Annual_Remaining']);
            $this->session->set_userdata('l_climit', $row['Casual_Remaining']);
        }

        $data['userdata'] = $userquery;
        //$data['approver'] = $this->m_user->getApprover($dept);


        $data['leave'] = $this->m_user->getLeave();

        $data['head'] = "lyt_main/head";
        $data['header'] = "lyt_main/header";
        $data['sidebar'] = "lyt_main/sidebar";
        $data['pagetitle'] = "Leave Form";
        $data['content'] = "leave/v_apply";
        $data['footer'] = "lyt_main/footer";
        $this->load->view('tpl_main', $data);
    }

    function checktype()
    {
        $leavetype = $this->input->post('leavetype');

        if ($leavetype == 0) {
            $this->form_validation->set_message('checktype', 'Please select the leave type');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function checkdates()
    {
        $leave_start = $this->input->post('leave_start');
        $leave_end = $this->input->post('leave_end');
        $leavetype = $this->input->post('leavetype');

        $date1 = date('Y-m-d', strtotime(str_replace('/', '-', $leave_start)));
        $date2 = date('Y-m-d', strtotime(str_replace('/', '-', $leave_end)));

        $str = $this->m_leave->validationdate($date1, $date2, $this->session->userdata('userid'));

        if ($str > 0) {
            if (($str > $this->session->userdata('l_limit')) && ($leavetype == 2)) {
                $this->form_validation->set_message('checkdates', 'Your Annual limit is not enough for leave');
                return FALSE;
            } else {
                $this->session->set_userdata('l_total_days', $str);
                return TRUE;
            }
        } else {
            $this->form_validation->set_message('checkdates', 'Please check "leave from" or "leave to" is incorrect');
            return FALSE;
        }
    }
}

?>