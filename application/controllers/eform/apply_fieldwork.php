<?php

class apply_fieldwork extends CI_Controller
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

    function user($userid)
    {
        $this->session->set_userdata('leave', 1);
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

                $data['head'] = "lyt_main/head";
                $data['header'] = "lyt_main/header";
                $data['sidebar'] = "lyt_main/sidebar";
                $data['pagetitle'] = "Field Work";
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
        $location = $this->input->post('location');
        $leave_start = $this->input->post('leave_start');
        $leave_end = $this->input->post('leave_end');

        $this->form_validation->set_rules('reason', 'Reason For Leave', 'required');
        $this->form_validation->set_rules('location', 'Location', 'required');
        $this->form_validation->set_rules('leave_start', 'Leave From', 'required|callback_checkdates');
        $this->form_validation->set_rules('leave_end', 'Leave End', 'required');

        $this->form_validation->set_error_delimiters('<span class="help-block" style="color:red">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->index();
        } else {
            //nampilih greenbox di view
            $this->session->set_userdata('noticebox', '5');

            $data = array(
                'location' => $location,
                'formtype' => '5',
                'remark_type' => 'Field Work',
                'leave_from' => date('Y-m-d', strtotime(str_replace('/', '-', $leave_start))),
                'leave_to' => date('Y-m-d', strtotime(str_replace('/', '-', $leave_end))),
                'level' => $this->session->userdata('l_level'),
                'r_id' => $this->session->userdata('l_userid'),
                'reason_leave' => $reason,
                'total_days' => $this->session->userdata('l_total_days'),
                'docdate' => date('Y-m-d')
            );

            $this->db->insert('tr_leave', $data);
            $this->index();
        }
    }

    function index()
    {
        $this->session->set_userdata('leave', 1);

        $this->session->set_userdata('l_readonly', 0);
        $id = $this->session->userdata('userid');
        $dept = $this->session->userdata('User_Group');

        $this->session->set_userdata('l_thismanage', 0);
        $this->session->set_userdata('l_apply', 1);

        $userquery = $this->m_user->getUserdata($id);

        foreach ($userquery as $row) {
            $this->session->set_userdata('l_userid', $row['userid']);
            $this->session->set_userdata('l_level', $row['id_emp']);
            $this->session->set_userdata('l_limit', $row['limits']);
            $this->session->set_userdata('l_climit', $row['c_limit']);
        }

        $data['userdata'] = $userquery;
        //$data['approver'] = $this->m_user->getApprover($dept);

        $data['title'] = $this->m_setting->getSetting();

        $data['head'] = "lyt_main/head";
        $data['header'] = "lyt_main/header";
        $data['sidebar'] = "lyt_main/sidebar";
        $data['pagetitle'] = "Field Work";
        $data['content'] = "leave/v_apply";
        $data['footer'] = "lyt_main/footer";
        $this->load->view('tpl_main', $data);
    }

    function checkdates()
    {
        $leave_start = $this->input->post('leave_start');
        $leave_end = $this->input->post('leave_end');
        $leavetype = $this->input->post('leavetype');

        $date1 = date_create(date('Y-m-d', strtotime(str_replace('/', '-', $leave_start))));
        $date2 = date_create(date('Y-m-d', strtotime(str_replace('/', '-', $leave_end))));

        $diff = date_diff($date1, $date2);
        $str = $diff->format("%R%a");

        if (substr_count($str, "-") == 0) {
            $this->session->set_userdata('l_total_days', ($str + 1));
            return TRUE;

        } else {
            $this->form_validation->set_message('checkdates', 'Please check "Date from" & "Date to" is incorrect');
            return FALSE;
        }
    }
}

?>