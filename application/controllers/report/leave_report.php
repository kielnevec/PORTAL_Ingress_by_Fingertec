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
class leave_report extends CI_Controller {

    function __construct() {
        parent::__construct();
 	if (!$this->session->userdata('logged_in')) {
            redirect('/login/');
        }
	$this->load->model('m_setting');
	$this->load->model('m_user');
        $this->load->model('m_leave');
	$this->session->set_userdata('selectedmenu', '10');
    }

    function index() {
	    $data['title'] = $this->m_setting->getSetting();
            $data['period'] = $this->m_leave->yearatt();
	    $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
	    $data['pagetitle'] = "Leave Balance Report";
            $data['content'] = "report/v_leavereport";
            $data['footer'] = "lyt_main/footer";
	    $data['formsubmit'] = "report/leave_report/submit";
	    $this->load->view('tpl_main', $data);        
    }

    function submit() {
	    $this->load->library('form_validation');
		$periodleave = $this->m_setting->getSetting();
		$datefrom = $periodleave[0]['leaveperiod_start'];
		$dateto = $periodleave[0]['leaveperiod_end'];
	    $period = $this->input->post('period');	   
	    $exec = $this->input->post('exec');
	    $this->form_validation->set_rules('period', 'Year Period', 'required');	    
	    $this->form_validation->set_error_delimiters('<span class="help-block" style="color:red">', '</span>');
	    
	    if($this->form_validation->run() == FALSE){
		$this->index();   
	    }
	    else{

		$data['title'] = $this->m_setting->getSetting();
		
		if($exec == "toexcel")
		{
		    $this->load->library('PHPExcel');
		    $detil = $this->m_leave->reportleave($datefrom, $dateto);
		    $data = array();
		    $data[] = array("# Ingress No.","#Emp No","Employee Name","Dept","Annual Entitled","Annual Used","Annual Remaining","Casual","Casual_Used","Casual_Remaining","Sick_Used");
		    $data[] = array("# Ingress No.","#Emp No","Employee Name","Dept","Annual Entitled","Annual Used","Annual Remaining","Casual","Casual_Used","Casual_Remaining","Sick_Used");
		    $i = 1;
		    foreach ($detil as $row) {
	
		    $data[] = array($row['userid'],$row['emp_no'],$row['EmployeeName'],$row['Dept'],$row['Annual_Entitled'],$row['Annual_Used'],$row['Annual_Remaining'],
                                    $row['Casual'], $row['Casual_Used'], $row['Casual_Remaining'], $row['Sick_Used']);
		    $i++;		
		    }
		    //excel export
		    $sheet = $this->phpexcel->getActiveSheet();
		    $sheet->setCellValue("A1","Leave Balance Period ".$period);
		    
		    for($i = 2; $i<count($data) + 1; $i++){
			$sheet->setCellValue("A".$i,$data[$i-1][0]);
			$sheet->setCellValue("B".$i,$data[$i-1][1]);
			$sheet->setCellValue("C".$i,$data[$i-1][2]);
			$sheet->setCellValue("D".$i,$data[$i-1][3]);
			$sheet->setCellValue("E".$i,$data[$i-1][4]);
			$sheet->setCellValue("F".$i,$data[$i-1][5]);
			$sheet->setCellValue("G".$i,$data[$i-1][6]);
			$sheet->setCellValue("H".$i,$data[$i-1][7]);$sheet->setCellValue("I".$i,$data[$i-1][8]);
			$sheet->setCellValue("J".$i,$data[$i-1][9]);
			$sheet->setCellValue("K".$i,$data[$i-1][10]);
		    }
		    $writer = new PHPExcel_Writer_Excel5($this->phpexcel);
		    
		    $filename="Leave Balance Period ".$period.".xls"; //save our workbook as this file name
		    header('Content-Type: application/vnd.ms-excel'); //mime type
		    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		    header('Cache-Control: max-age=0'); //no cache
		    $writer->save('php://output'); 
		    
		    
		}
	    }   
    }

    
}    
?>