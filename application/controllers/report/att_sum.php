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
class att_sum extends CI_Controller {

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
            $data['category'] = $this->m_leave->catdept();
	    $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
	    $data['pagetitle'] = "Attendance Summary Report";
            $data['content'] = "report/v_attsum";
            $data['footer'] = "lyt_main/footer";
	    $data['formsubmit'] = "report/att_sum/submit";
	    $this->load->view('tpl_main', $data);        
    }
    
    function submit() {
	    $this->load->library('form_validation');	
	    $leave_start = $this->input->post('leave_start');
	    $leave_end = $this->input->post('leave_end');
	    $cat = $this->input->post('cat');
	    
	    $exec = $this->input->post('exec');
	    $this->form_validation->set_rules('leave_start', 'Date From', 'required|callback_checkdates');
	    $this->form_validation->set_rules('leave_end', 'Date to', 'required');
	    $this->form_validation->set_rules('cat', 'Category', 'required');
	    
	    
	    $this->form_validation->set_error_delimiters('<span class="help-block" style="color:red">', '</span>');
	    
	    if($this->form_validation->run() == FALSE){
		$this->index();   
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
		    
		    $detil = $this->m_leave->reportattendance($cat, $date1, $date2);
		    $data = array();
		    $data[] = array("# Ingress No.","#Emp No","Employee Name","Dept","Total Work Days","Present Work Days","Total Work (Hours)","Total OT (Hours)","Present Rest Days","Total Rest (Hours)","Present Holiday","Total Holiday (Hours)","Late in (Hours)","Early Out (Hours)","Total Short (Hours)","Total Short (Days)","Absent","Annual Leave","Sick Leave","Casual Leave","Compassionate Leave","Examination Leave","Maternity Leave","Field Work");
		    $data[] = array("# Ingress No.","#Emp No","Employee Name","Dept","Total Work Days","Present Work Days","Total Work (Hours)","Total OT (Hours)","Present Rest Days","Total Rest (Hours)","Present Holiday","Total Holiday (Hours)","Late in (Hours)","Early Out (Hours)","Total Short (Hours)","Total Short (Days)","Absent","Annual Leave","Sick Leave","Casual Leave","Compassionate Leave","Examination Leave","Maternity Leave","Field Work");
		    $i = 1;
		    foreach ($detil as $row) {
	
		    $data[] = array($row['userid'],$row['emp_no'],$row['EmployeeName'],$row['Dept'],$row['Total_Work_Days'],$row['Present_Work_Days'],$row['Total_Work(Hours)'],$row['Total_OT(Hours)'], $row['Present_Rest_Days'],
				    $row['Total_Rest(Hours)'], $row['Present_Holiday'], $row['Total_Holiday(Hours)'] , $row['Late_in(Hours)'], $row['Early_out(Hours)'], $row['Total_Short(Hours)'], $row['Total_Short(Days)'],$row['Absent'],
				    $row['Annual_Leave'], $row['Sick_Leave'], $row['Casual_Leave'], $row['Compassionate_Leave'], $row['Examination_Leave'], $row['Maternity_Leave'], $row['Field_Work']);
		    $i++;		
		    }
		    //excel export
		    $sheet = $this->phpexcel->getActiveSheet();
		    $sheet->setCellValue("A1","Attendance Summary Report ".$leave_start." - ".$leave_end." ".$cat);
		    
		    for($i = 2; $i<count($data) + 1; $i++){
			$sheet->setCellValue("A".$i,$data[$i-1][0]);
			$sheet->setCellValue("B".$i,$data[$i-1][1]);
			$sheet->setCellValue("C".$i,$data[$i-1][2]);
			$sheet->setCellValue("D".$i,$data[$i-1][3]);
			$sheet->setCellValue("E".$i,$data[$i-1][4]);
			$sheet->setCellValue("F".$i,$data[$i-1][5]);
			$sheet->setCellValue("G".$i,$data[$i-1][6]);
			$sheet->setCellValue("H".$i,$data[$i-1][7]);
            $sheet->setCellValue("I".$i,$data[$i-1][8]);
			$sheet->setCellValue("J".$i,$data[$i-1][9]);
			$sheet->setCellValue("K".$i,$data[$i-1][10]);
			$sheet->setCellValue("L".$i,$data[$i-1][11]);
			$sheet->setCellValue("M".$i,$data[$i-1][12]);
			$sheet->setCellValue("N".$i,$data[$i-1][13]);
			$sheet->setCellValue("O".$i,$data[$i-1][14]);
			$sheet->setCellValue("P".$i,$data[$i-1][15]);
			$sheet->setCellValue("Q".$i,$data[$i-1][16]);
			$sheet->setCellValue("R".$i,$data[$i-1][17]);
			$sheet->setCellValue("S".$i,$data[$i-1][18]);
			$sheet->setCellValue("T".$i,$data[$i-1][19]);
			$sheet->setCellValue("U".$i,$data[$i-1][20]);
			$sheet->setCellValue("V".$i,$data[$i-1][21]);
			$sheet->setCellValue("W".$i,$data[$i-1][22]);
			$sheet->setCellValue("X".$i,$data[$i-1][23]);
		    }
		    $writer = new PHPExcel_Writer_Excel5($this->phpexcel);
		    
		    $filename="Attendance Summary Report ".$leave_start." - ".$leave_end.".xls"; //save our workbook as this file name
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