<?php
class testexcel extends CI_Controller {
            function __construct() {
            parent::__construct();
            $this->load->library('SimpleLoginSecure');
            $this->load->model('m_setting');
            //load our new PHPExcel library
            
            if (!$this->session->userdata('logged_in')) {
                redirect('/login/');
            }
	}
        
        function index(){
            $this->load->library('PHPExcel');

            $sheet = $this->phpexcel->getActiveSheet();
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->setCellValue('A1','First Row');
            
            $writer = new PHPExcel_Writer_Excel5($this->phpexcel);
            $filename='just_some_random_name.xls'; //save our workbook as this file name
            header('Content-Type: application/vnd.ms-excel'); //mime type
            header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
            header('Cache-Control: max-age=0'); //no cache
            $writer->save('php://output'); 
        }
}
?>