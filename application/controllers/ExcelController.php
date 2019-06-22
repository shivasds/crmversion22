<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
class ExcelController extends CI_Controller {
	// construct
    public function __construct() {
        parent::__construct();
		// load model
		$this->load->model('callback_model');   
    }    
	 // export xlsx|xls file
    public function index() {
       
        	$page = $this->uri->segment(2);
        	$startpage =$page;
        	if(empty($startpage)==true)
        	$startpage=1;
        	
        	//echo $page;
        	$topage=$page+200;
	 			$fileName = 'callbacks '.$startpage.' to '.$topage.'.xlsx';   //
		//load excel library
		 $this->load->library('excel'); 

		$where="";
		
		        $offset = !$page ? 0 : $page;
				//------ End --------------

		        $data = $this->callback_model->search_callback(null,$where,$offset,VIEW_PER_PAGE);

		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		 
		 // set Header
		$objPHPExcel->getActiveSheet()->SetCellValue('A1', 'No');
		$objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Contact Name');
		$objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Contact No');
		$objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Email');
		$objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Project'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Lead Source'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Lead Id'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Advisor'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('I1', 'Sub-Source'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('J1', 'Due date'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('K1', 'Status'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('L1', 'Date Added'); 
		$objPHPExcel->getActiveSheet()->SetCellValue('M1', 'Last Update');  

		//set rows        	
		          $rowC = 2;
		 		  $i= 1;
		        if(count($data)>0){
		        foreach ($data as $resultdata) {
		            $duedate = explode(" ", $resultdata->due_date);
		            $duedate = $duedate[0]; 
		             if(strtotime($duedate)<strtotime('today')){
					 }
					 elseif(strtotime($duedate) == strtotime('today')) 
					 {
					 }
					 elseif(strtotime($duedate)>strtotime('today')){ 
					 } 
        
		      $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowC, $i);
		      $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowC, $resultdata->name);
		    $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowC, $resultdata->contact_no1);
		      $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowC, $resultdata->email1);
		      $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowC, $resultdata->project_name);
		      $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowC, $resultdata->lead_source_name);
		      $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowC, $resultdata->leadid);
		      $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowC, $resultdata->user_name);
		      $objPHPExcel->getActiveSheet()->SetCellValue('I' . $rowC, $resultdata->broker_name);
		      $objPHPExcel->getActiveSheet()->SetCellValue('J' . $rowC, $resultdata->due_date);
		      $objPHPExcel->getActiveSheet()->SetCellValue('K' . $rowC, $resultdata->status_name);
		      $objPHPExcel->getActiveSheet()->SetCellValue('L' . $rowC, $resultdata->date_added);
		      $objPHPExcel->getActiveSheet()->SetCellValue('M' . $rowC,$resultdata->last_update);
		      $i++;
		 $rowC++; } }


		 	$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
	       $objWriter->save($fileName);
			// download file
header('Content-type: application/xls/vnd.ms-excel');
header('Content-Disposition: attachment; filename="' . $fileName . '"');
// Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
// Write the Excel file to filename some_excel_file.xlsx in the current directory
$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
// Write the Excel file to filename some_excel_file.xlsx in the current directory
$objWriter->save('php://output'); 
 
		               
    }
    
}
?>