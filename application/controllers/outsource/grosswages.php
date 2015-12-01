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
class grosswages extends CI_Controller {

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

    function index() {
	    $data['title'] = $this->m_setting->getSetting();
	    $data['head'] = "lyt_main/head";
            $data['header'] = "lyt_main/header";
            $data['sidebar'] = "lyt_main/sidebar";
	    $data['pagetitle'] = "Gross Wages Report";
            $data['content'] = "outsource/v_grosswages";
            $data['footer'] = "lyt_main/footer";
	    $this->load->view('tpl_main', $data);        
    }
    
    function submit() {
	    $this->load->library('form_validation');
	
	    $leave_start = $this->input->post('leave_start');
	    $leave_end = $this->input->post('leave_end');
	    $exec = $this->input->post('exec');
	    $this->form_validation->set_rules('leave_start', 'Date From', 'required|callback_checkdates');
	    $this->form_validation->set_rules('leave_end', 'Date to', 'required');
	    
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
		//$data['headform'] = $this->m_outsource->viewHeadForm($formid);
		$data['grosswagesdetil'] = $this->m_outsource->grosswages($date1,$date2);
		$data['grosswagestotal'] = $this->m_outsource->sumgrosswages($date1,$date2);
		
		if($exec == "topdf")
		{
		    $this->load->library('pdf_2');
					       		    
		    $this->load->view('outsource/v_pdfwages', $data);
		    //$html = $this->load->view('outsource/v_pdfwages', $data, true);
		    //$this->pdf_2->pdf_create($html, 'Grosswages-'.$date1.' s/d '.$date2);
		}
		else if($exec == "toexcel")
		{
		    $this->load->library('PHPExcel');
		    $detilwages = $this->m_outsource->grosswages($date1,$date2);
		    $data = array();
		    $data[] = array("# No.","#ID NO","Employee Name","Dept","Rate","Gross Wages","Workday","W_Wages","OT","OT_Wages","Restday","R_Wages","Holiday","H_Wages");
		    $data[] = array("# No.","#ID NO","Employee Name","Dept","Rate","Gross Wages","Workday","W_Wages","OT","OT_Wages","Restday","R_Wages","Holiday","H_Wages");
		    $i = 1;
		    foreach ($detilwages as $row) {
	
		    $data[] = array($i,$row['userid'],$row['EmployeeName'],$row['Dept'],$row['Rate'],$row['GrossWages'],$row['Worktime'],$row['W_Wages'],$row['OT'],$row['OT_Wages'],$row['Restday'],$row['R_Wages'],$row['Holiday'],$row['H_Wages']);
		    $i++;		
		    }
		    //excel export
			$this->phpexcel->setActiveSheetIndex(0);
		    $sheet = $this->phpexcel->getActiveSheet();
			$sheet->setTitle('Detail Grosswages');
		    $sheet->setCellValue("A1","Gross Wages From ".$leave_start." To ".$leave_end);
		    
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
		    }

			$sheet->setCellValue("A".($i+1),"Total GrossWages : ");
			$sheet->setCellValue("C".($i+1),"=SUM(F2:F".$i.")");
			/////////////////////////////////////
			// sheet 2
			$headmanpower = $this->m_outsource->headmanpower($date1,$date2);
			$new = $this->phpexcel->createSheet(1);
			$this->phpexcel->setActiveSheetIndex(1);
			$sheet = $this->phpexcel->getActiveSheet();
			$sheet->setTitle('Total Man Power');
			$sheet->setCellValue("A1","WORKFORCE STRENGTH");
			$data = array();
		    $data[] = array("# No.","Dept","Total Figure");
		    $data[] = array("# No.","Dept","Total Figure");
		    $i = 1;
			foreach ($headmanpower as $row) {
	
				$data[] = array($i,$row['Section'],$row['Total']);
				$i++;		
		    }
			for($i = 2; $i<count($data) + 1; $i++){
				$sheet->setCellValue("A".$i,$data[$i-1][0]);
				$sheet->setCellValue("B".$i,$data[$i-1][1]);
				$sheet->setCellValue("C".$i,$data[$i-1][2]);
		    }
			
			$sheet->setCellValue("B".($i+1),"Total : ");
			$sheet->setCellValue("C".($i+1),"=SUM(C2:C".$i.")");
			
			$writer = new PHPExcel_Writer_Excel5($this->phpexcel);
			/////////////////////////////////////
			// sheet 3
			$detilmanpower = $this->m_outsource->detailmanpower($date1,$date2);
			$new = $this->phpexcel->createSheet(2);
			$this->phpexcel->setActiveSheetIndex(2);
			$sheet = $this->phpexcel->getActiveSheet();
			$sheet->setTitle('Detail Total Man Power');
			$sheet->setCellValue("A1","DETAIL WORKFORCE STRENGTH");
			
			$data = array();
		    $data[] = array("# No.","Dept","Section","Total Figure");
		    $data[] = array("# No.","Dept","Section","Total Figure");
		    $i = 1;
			
			foreach ($detilmanpower as $row) {
	
				$data[] = array($i,$row['Head'],$row['Section'],$row['Total']);
				$i++;		
		    }
			for($i = 2; $i<count($data) + 1; $i++){
				$sheet->setCellValue("A".$i,$data[$i-1][0]);
				$sheet->setCellValue("B".$i,$data[$i-1][1]);
				$sheet->setCellValue("C".$i,$data[$i-1][2]);
				$sheet->setCellValue("D".$i,$data[$i-1][3]);
		    }
			
			$sheet->setCellValue("B".($i+1),"Total : ");
			$sheet->setCellValue("D".($i+1),"=SUM(D2:D".$i.")");
			
			$writer = new PHPExcel_Writer_Excel5($this->phpexcel);
			
			
		    $filename="Gross Wages ".$leave_start." - ".$leave_end.".xls"; //save our workbook as this file name
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