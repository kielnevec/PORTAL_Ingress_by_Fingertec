<?php

class approve extends CI_Controller
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

    function submit()
    {
        $this->load->library('form_validation');
        $app_comment = $this->input->post('app_comment');
        $valueapp = $this->input->post('btn');


        $this->form_validation->set_rules('app_comment', 'Approval Comment', 'required');
        $this->form_validation->set_error_delimiters('<span class="help-block" style="color:red">', '</span>');

        if ($this->form_validation->run() == FALSE) {
            $this->view($this->session->userdata('l_view'));
        } else {
            if ($this->session->userdata('leave') == 0) {
                //nampilih greenbox di view
                $this->session->set_userdata('noticebox', '6');

                if ($valueapp == "approve") {
                    $data = array(
                        'appv' => $this->session->userdata('userid'),
                        'docstatus' => '1',
                        'appv_comment' => $app_comment,
                        'app_date' => date('Y-m-d H:i:s')
                    );
                    $this->db->where('leaveid', $this->session->userdata('eleaveid'));
                    $this->db->update('tr_leave', $data);

                    $recordatt = $this->m_leave->attendanceleave($this->session->userdata('l_view'));

                    for ($i = 0; $i < Count($recordatt); $i++) {
                        $dataattd = array(
                            'leavetype' => $recordatt[$i]['leavetype'],
                            'leavetype_c' => '1',
                            'Form_docno' => $recordatt[$i]['leaveid'],
                            'Form_type' => 'L'
                        );

                        $this->db->where('userid', $recordatt[$i]['userid']);
                        $this->db->where('date', $recordatt[$i]['date']);
                        $this->db->update('attendance', $dataattd);
                    }
                    $this->index();
                } else if ($valueapp == "reject") {
                    $data = array(
                        'appv' => $this->session->userdata('userid'),
                        'docstatus' => '2',
                        'appv_comment' => $app_comment,
                        'app_date' => date('Y-m-d H:i:s')
                    );

                    $this->db->where('leaveid', $this->session->userdata('eleaveid'));
                    $this->db->update('tr_leave', $data);
                    $this->index();
                }
            } else if ($this->session->userdata('leave') == 1) {
                $this->session->set_userdata('noticebox', '6');

                if ($valueapp == "approve") {
                    $data = array(
                        'appv' => $this->session->userdata('userid'),
                        'docstatus' => '1',
                        'appv_comment' => $app_comment,
                        'app_date' => date('Y-m-d H:i:s')
                    );
                    $this->db->where('leaveid', $this->session->userdata('eleaveid'));
                    $this->db->update('tr_leave', $data);

                    $recordatt = $this->m_leave->getscheduletime($this->session->userdata('l_view'));

                    for ($i = 0; $i < Count($recordatt); $i++) {
                        $dataattd = array(
                            /*				    'att_in' => $recordatt[$i]['sche_in'],
                                                'att_out' => $recordatt[$i]['sche_out'],
                                                'workhour' => $recordatt[$i]['workhour'],
                                                'othour' => $recordatt[$i]['othour'],
                                                'in_c' => '1',
                                                'out_c' => '1',*/
                            'remark_c' => '1',
                            'remark' => $recordatt[$i]['formtype'],
                            'Form_docno' => $recordatt[$i]['leaveid'],
                            'Form_type' => 'W'
                        );

                        $this->db->where('userid', $recordatt[$i]['userid']);
                        $this->db->where('date', $recordatt[$i]['date']);
                        $this->db->update('attendance', $dataattd);
                    }
                    $this->index();
                } else if ($valueapp == "reject") {
                    $data = array(
                        'appv' => $this->session->userdata('userid'),
                        'docstatus' => '2',
                        'appv_comment' => $app_comment,
                        'app_date' => date('Y-m-d H:i:s')
                    );

                    $this->db->where('leaveid', $this->session->userdata('eleaveid'));
                    $this->db->update('tr_leave', $data);
                    $this->index();
                }
            }
        }

    }

    function view($leaveid)
    {

        if (is_numeric($leaveid) == TRUE) {
            $this->session->set_userdata('l_view', $leaveid);
            $this->session->set_userdata('l_readonly', 1);
            $this->session->set_userdata('l_thismanage', 0);

            $leavequery = $this->m_leave->getviewLeave($leaveid);
            //validation if ID not valid
            if (count($leavequery) == 0) {
                redirect('/eform/approve/');
            } else if ($this->session->userdata('userid') != $leavequery[0]['Approver']) {
                redirect('/eform/manage/');
            }

            foreach ($leavequery as $row) {
                //$this->session->set_userdata('l_userid', $row['userid']);
                $this->session->set_userdata('eleaveid', $row['leaveid']);
                if ($row['leavetype'] != NULL || $row['leavetype'] != 0) {
                    $this->session->set_userdata('leave', 0);
                } else if ($row['formtype'] != NULL || $row['formtype'] != 0) {
                    $this->session->set_userdata('leave', 1);
                }
            }
            $id = $this->session->userdata('userid');
            $userquery = $this->m_user->getUserdata($id);

            //foreach ($userquery as $row)
            //{
            //   //$this->session->set_userdata('l_userid', $row['userid']);
            //   $this->session->set_userdata('l_level', $row['id_emp']);
            //   $this->session->set_userdata('l_limit', $row['limits']);
            //   $this->session->set_userdata('l_climit', $row['c_limit']);
            //}

            $data['eleave'] = $leavequery;
            $data['title'] = $this->m_setting->getSetting();
            $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
            $data['pagetitle'] = "Approve Form";
            $data['content'] = "leave/v_apply";
            $data['footer'] = "lyt_main/footer";
            $this->load->view('tpl_main', $data);
        } else {
            redirect('/eform/approve/');
        }
    }

    function index()
    {
        $id = $this->session->userdata('userid');
        $leavequery = $this->m_leave->getPendingLeave($id);
        $data['title'] = $this->m_setting->getSetting();
        $data['leave'] = $leavequery;

        $data['head'] = "lyt_main/head";
        $data['header'] = "lyt_main/header";
        $data['sidebar'] = "lyt_main/sidebar";
        $data['pagetitle'] = "Approve Form";
        $data['content'] = "leave/v_approve";
        $data['footer'] = "lyt_main/footer";
        $this->load->view('tpl_main', $data);

        if (!$id == $leavequery[0]['Approver']) {
            redirect('/eform/manage/');
        }

    }
}

?>