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
class report extends CI_Controller {

    function __construct() {
        parent::__construct();
 	if (!$this->session->userdata('logged_in')) {
            redirect('/login/');
        }
	$this->load->model('m_setting');
	$this->load->model('m_user');
        $this->load->model('m_outsource');
	$this->session->set_userdata('selectedmenu', '10');
    }

    function misspunch() {
	    $data['title'] = $this->m_setting->getSetting();
	    $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
	    $data['pagetitle'] = "Miss Punch Report";
            $data['content'] = "outsource/v_report";
            $data['footer'] = "lyt_main/footer";
	    $data['formsubmit'] = "outsource/report/mpsubmit";
	    $this->load->view('tpl_main', $data);        
    }
    
    function mpsubmit() {
	    $this->load->library('form_validation');
	
	    $leave_start = $this->input->post('leave_start');
	    $leave_end = $this->input->post('leave_end');
	    $exec = $this->input->post('exec');
	    $this->form_validation->set_rules('leave_start', 'Date From', 'required|callback_checkdates');
	    $this->form_validation->set_rules('leave_end', 'Date to', 'required');
	    
	    $this->form_validation->set_error_delimiters('<span class="help-block" style="color:red">', '</span>');
	    
	    if($this->form_validation->run() == FALSE){
		$this->misspunch();   
	    }
	    else{
		
		$date1 = date('Y-m-d', strtotime(str_replace('/', '-', $leave_start)));
		$date2 = date('Y-m-d', strtotime(str_replace('/', '-', $leave_end)));
		       
		$this->session->set_userdata('date1', $leave_start);
		$this->session->set_userdata('date2', $leave_end);
		$data['title'] = $this->m_setting->getSetting();
		
		if($exec == "toexcel")
		{
		    $this->load->library('PHPExcel');
		    $detil = $this->m_outsource->getMissPunch($date1,$date2);
		    $data = array();
		    $data[] = array("# No.","#ID NO","Employee Name","Dept","Date","IN","OUT","Schedule");
		    $data[] = array("# No.","#ID NO","Employee Name","Dept","Date","IN","OUT","Schedule");
		    $i = 1;
		    foreach ($detil as $row) {
	
		    $data[] = array($i,$row['userid'],$row['EmployeeName'],$row['Department'],$row['date'],$row['att_in'],$row['att_out'],$row['schedulename']);
		    $i++;		
		    }
		    //excel export
		    $sheet = $this->phpexcel->getActiveSheet();
		    $sheet->setCellValue("A1","MissPunch From ".$leave_start." To ".$leave_end);
		    
		    for($i = 2; $i<count($data) + 1; $i++){
			$sheet->setCellValue("A".$i,$data[$i-1][0]);
			$sheet->setCellValue("B".$i,$data[$i-1][1]);
			$sheet->setCellValue("C".$i,$data[$i-1][2]);
			$sheet->setCellValue("D".$i,$data[$i-1][3]);
			$sheet->setCellValue("E".$i,$data[$i-1][4]);
			$sheet->setCellValue("F".$i,$data[$i-1][5]);
			$sheet->setCellValue("G".$i,$data[$i-1][6]);
			$sheet->setCellValue("H".$i,$data[$i-1][7]);
		    }
		    $writer = new PHPExcel_Writer_Excel5($this->phpexcel);
		    
		    $filename="MissPunch ".$leave_start." - ".$leave_end.".xls"; //save our workbook as this file name
		    header('Content-Type: application/vnd.ms-excel'); //mime type
		    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		    header('Cache-Control: max-age=0'); //no cache
		    $writer->save('php://output'); 
		    
		    
		}
	    }   
    }

    function checkdates(){
	    $leave_start = $this->input->post('leave_start');
	    $leave_end = $this->input->post('leave_end');
	    
	    $date1 = date_create(date('Y-m-d', strtotime(str_replace('/', '-', $leave_start))));
	    $date2 = date_create(date('Y-m-d', strtotime(str_replace('/', '-', $leave_end))));
	    
	    $diff=date_diff($date1,$date2);
	    $str = $diff->format("%R%a");
	    
	    if(substr_count($str,"-") == 0){
		return TRUE;
	    }
	    else{
		$this->form_validation->set_message('checkdates','Please check "Date from" & "Date to" is incorrect');
		return FALSE;		
	    }
    }
    
}    
?>