<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Excel  extends CI_Controller {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		
		if (!isset( $_SESSION['IS_LOGGED_IN'] )) { 
			redirect(base_url()); 
		}
		$this->load->model('TestReport_model');
		$this->load->model('TestCase_model');
		$this->load->model('Project_Details_model');
		$this->load->model('Combo_model');
		require(APPPATH . 'third_party/PHPExcel_1.8/Classes/PHPExcel.php');
		require(APPPATH . 'third_party/PHPExcel_1.8/Classes/PHPExcel/Writer/Excel2007.php');
		
	}
	
	
	function export_test_report()
	{
		$id = $this->uri->segment(3);
	
		if (empty($id))
		{
			show_404();
		}
		
		$report_data['report'] = $this->TestReport_model->fetch_data_by_report_id($id);
		$data['testreport_row'] = $this->TestReport_model->get_record_by_id($id);
		$data['login_details'] = $this->TestReport_model->get_app_login_details_report_id($id);
		$name = $data['testreport_row']['report_description']."_";
		
		$objPHPExcel = new PHPExcel();
		$objPHPExcel->setActiveSheetIndex(0);
		
		   $objPHPExcel->getActiveSheet()->SetCellValue('B2','Environment Details');
		   $objPHPExcel->getActiveSheet()->SetCellValue('B3','Project Name :');
		   $objPHPExcel->getActiveSheet()->SetCellValue('C3',$data['testreport_row']['project_name']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('B4','Project Version :');
		   $objPHPExcel->getActiveSheet()->SetCellValue('C4',$data['testreport_row']['version']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('B5','Client :');
		   $objPHPExcel->getActiveSheet()->SetCellValue('C5',$data['testreport_row']['client_name']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('B6','Report Description :');
		   $objPHPExcel->getActiveSheet()->SetCellValue('C6',$data['testreport_row']['report_description']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('B7','Date of preparation :');
		   $objPHPExcel->getActiveSheet()->SetCellValue('C7',$data['testreport_row']['created_datetime']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('B8','Prepared By :');
		   $objPHPExcel->getActiveSheet()->SetCellValue('C8',$data['testreport_row']['created_by']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('B9','Report Status :');
		   $objPHPExcel->getActiveSheet()->SetCellValue('C9',$data['testreport_row']['status']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('B12','Application Details');
		  
			$row = 13;
			$val = 1;
		  foreach($data['login_details'] as $value)
		  {
		   $objPHPExcel->getActiveSheet()->SetCellValue('B'.$row,'App Test link : '.$val);
		   $objPHPExcel->getActiveSheet()->SetCellValue('C'.$row,$value['app_url']);	  
		   $row++;
		   $objPHPExcel->getActiveSheet()->SetCellValue('B'.$row,'Entity Code:');
		   $objPHPExcel->getActiveSheet()->SetCellValue('C'.$row,$value['entity_code']);
		   $row++;
		   $objPHPExcel->getActiveSheet()->SetCellValue('B'.$row,'User Name :');
		   $objPHPExcel->getActiveSheet()->SetCellValue('C'.$row,$value['user_name']);
		   $row++;
		   $objPHPExcel->getActiveSheet()->SetCellValue('B'.$row,'Password :');
		   $objPHPExcel->getActiveSheet()->SetCellValue('C'.$row,$value['password']);
		   $row++;
		   $objPHPExcel->getActiveSheet()->SetCellValue('B'.$row,'Database Recived By:');
		   $objPHPExcel->getActiveSheet()->SetCellValue('C'.$row,$value['db_recived_by']);
		   $row++;
		   $objPHPExcel->getActiveSheet()->SetCellValue('B'.$row,'WarFile Recived By:');
		   $objPHPExcel->getActiveSheet()->SetCellValue('C'.$row,$value['warfile_recived_by']);
		   $row++;
		   $objPHPExcel->getActiveSheet()->SetCellValue('B'.$row,'APK Recived By:');
		   $objPHPExcel->getActiveSheet()->SetCellValue('C'.$row,$value['apk_recived_by']);
		   $objPHPExcel->getActiveSheet()->getStyle('B12:B'.$row)->applyFromArray(array('font'=>array('bold'=>true)));
		   $objPHPExcel->getActiveSheet()->getStyle('B12:C'.$row)->applyFromArray(
			  array(
			  'borders'=>array(
			  'allborders'=>array(
			  'style'=>PHPExcel_Style_Border::BORDER_THIN))
			  
			  ));
			
		   $row=$row+2;
		   $val++;
		  }

		  $objPHPExcel->getActiveSheet()->setTitle("Environment Details");
		  
		  
		  $objPHPExcel->getActiveSheet()->mergeCells('B2:C2');
		  $objPHPExcel->getActiveSheet()->mergeCells('B12:C12');
		  $objPHPExcel->getActiveSheet()->getStyle('B2')->getAlignment()->setHorizontal('center');
		  $objPHPExcel->getActiveSheet()->getStyle('B12')->getAlignment()->setHorizontal('center');
		  $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray(array('font'=>array('bold'=>true,'size'=>12)));
		  $objPHPExcel->getActiveSheet()->getStyle('B3:B9')->applyFromArray(array('font'=>array('bold'=>true)));
		  $objPHPExcel->getActiveSheet()->getStyle('B2:C9')->applyFromArray(
		  array(
		  'borders'=>array(
		  'allborders'=>array(
		  'style'=>PHPExcel_Style_Border::BORDER_THIN))
		  
		  ));
		  $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '93E10F')
				)
			)
			);
			$objPHPExcel->getActiveSheet()->getStyle('B12')->applyFromArray(
			array(
				'fill' => array(
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array('rgb' => '93E10F')
				)
			)
			);
		
		  
		  $objPHPExcel->createSheet();
		  $objPHPExcel->setActiveSheetIndex(1);
		
			$objPHPExcel->getActiveSheet()->SetCellValue('A1','Sl.No');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1','Module Name');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1','Feature Name');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1','High level Scenarios');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1','CheckPoints');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1','Execution Steps');
			$objPHPExcel->getActiveSheet()->SetCellValue('G1','Expected Result');
			$objPHPExcel->getActiveSheet()->SetCellValue('H1','Test Status');
			$objPHPExcel->getActiveSheet()->SetCellValue('I1','Bug Id');
			$objPHPExcel->getActiveSheet()->SetCellValue('J1','Bug Status');
			$objPHPExcel->getActiveSheet()->SetCellValue('K1','Developer Status');
			$objPHPExcel->getActiveSheet()->SetCellValue('L1','Assigned To');
			$objPHPExcel->getActiveSheet()->SetCellValue('M1','Comments');
			$objPHPExcel->getActiveSheet()->SetCellValue('N1','Tested By');
			$objPHPExcel->getActiveSheet()->SetCellValue('O1','Tested DateTime');

			$row = 2;
			
		  foreach($report_data['report'] as $value)
		  {
		   $objPHPExcel->getActiveSheet()->SetCellValue('A'.$row,$row-1);
		   $objPHPExcel->getActiveSheet()->SetCellValue('B'.$row,$value['module_name']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('C'.$row,$value['feature_name']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('D'.$row,$value['high_level_scenario']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('E'.$row,$value['checkpoints']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('F'.$row,$value['execution_steps']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('G'.$row,$value['expected_result']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('H'.$row,$value['test_status']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('I'.$row,$value['bug_id']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('J'.$row,$value['bug_status']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('K'.$row,$value['developer_status']);
		    if($value['assigned_to'] != 0){
			    $objPHPExcel->getActiveSheet()->SetCellValue('L'.$row,$value['nameof_assigned_to']);
		   }else{
			   $objPHPExcel->getActiveSheet()->SetCellValue('L'.$row,'N/A');
		   }
		   if($value['comments'] != 'N/A'){
		   $objPHPExcel->getActiveSheet()->SetCellValue('M'.$row,$value['updated_by']." :".$value['comments']);
		    }else{
			   $objPHPExcel->getActiveSheet()->SetCellValue('M'.$row,$value['comments']);
		   }
		   
		   if($value['tested_by'] != 0){
			    $objPHPExcel->getActiveSheet()->SetCellValue('N'.$row,$value['nameof_tested_by']);
		   }else{
			   $objPHPExcel->getActiveSheet()->SetCellValue('N'.$row,'N/A');
		   }
		   
		  	$objPHPExcel->getActiveSheet()->SetCellValue('O'.$row,$value['updated_date']);
		   
		   
		   $objPHPExcel->getActiveSheet()->getStyle('A1:O'.$row)->applyFromArray(
			  array(
			  'borders'=>array(
			  'allborders'=>array(
			  'style'=>PHPExcel_Style_Border::BORDER_THIN))
			  
			  ));
			  
		   $row++;
		   
		  }
		  
		  $objPHPExcel->getActiveSheet()->setTitle("Test Report Details");
		  
		  $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->getAlignment()->setHorizontal('center');
		  $objPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray(array('font'=>array('bold'=>true,'size'=>12)));
			  
			$objPHPExcel->getActiveSheet()->getStyle('A1:O1')->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => '93E10F')
					)
				)
			);
		  
		  
		  $filename = $name.date("d-m-Y").".xlsx"; 
 		  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		  header('Content-Disposition: attachment;filename="'.$filename.'"');
		  header('Cache-Control: max-age=0');
		  $writer = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');

		  $writer->save('php://output');
		  exit;
	}
	
	
	function export_test_cases()
	{
		$id = $this->uri->segment(3);
	
		if (empty($id))
		{
			show_404();
		}
		
		$data['testcase'] = $this->TestCase_model->view_record('',$id);
		
		/*echo "<pre>";
		print_r($data['testcase']);
		echo "</pre>";*/
		$name = "Test Case list_";
		
		$objPHPExcel = new PHPExcel();
		
		  $objPHPExcel->setActiveSheetIndex(0);
		
			$objPHPExcel->getActiveSheet()->SetCellValue('A1','Sl.No');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1','Module Name');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1','Feature Name');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1','High level Scenarios');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1','CheckPoints');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1','Execution Steps');
			$objPHPExcel->getActiveSheet()->SetCellValue('G1','Expected Result');

			$row = 2;
			
		  foreach($data['testcase'] as $value)
		  {
		   $objPHPExcel->getActiveSheet()->SetCellValue('A'.$row,$row-1);
		   $objPHPExcel->getActiveSheet()->SetCellValue('B'.$row,$value['module_name']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('C'.$row,$value['feature_name']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('D'.$row,$value['high_level_scenario']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('E'.$row,$value['checkpoints']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('F'.$row,$value['execution_steps']);
		   $objPHPExcel->getActiveSheet()->SetCellValue('G'.$row,$value['expected_result']);
		   
		   $objPHPExcel->getActiveSheet()->getStyle('A1:G'.$row)->applyFromArray(
			  array(
			  'borders'=>array(
			  'allborders'=>array(
			  'style'=>PHPExcel_Style_Border::BORDER_THIN))
			  
			  ));
			 $row++;
		   
		  }
		  
		  $objPHPExcel->getActiveSheet()->setTitle("Test Case Details");
		  
		  $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->getAlignment()->setHorizontal('center');
		  $objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray(array('font'=>array('bold'=>true,'size'=>12)));
			  
			$objPHPExcel->getActiveSheet()->getStyle('A1:G1')->applyFromArray(
				array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => '93E10F')
					)
				)
			);
		  
		  
		  $filename = $name.date("d-m-Y").".xlsx"; 
 		  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		  header('Content-Disposition: attachment;filename="'.$filename.'"');
		  header('Cache-Control: max-age=0');
		  $writer = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');

		  $writer->save('php://output');
		  exit;
	}
	
	function test_case_template()
	{
		$objPHPExcel = new PHPExcel();
		
		  $objPHPExcel->setActiveSheetIndex(0);
		
			$objPHPExcel->getActiveSheet()->SetCellValue('A1','Module Name');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1','Feature Name');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1','High level Scenarios');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1','CheckPoints');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1','Execution Steps');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1','Expected Result');

			$row = 2;
			
		 
		  
		  $objPHPExcel->getActiveSheet()->setTitle("Test Case Details");
		  $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal('center');
		  $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray(array('font'=>array('bold'=>true,'size'=>12)));
			  
		  
		  
		  $filename = "TestCase_Template.xlsx"; 
 		  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		  header('Content-Disposition: attachment;filename="'.$filename.'"');
		  header('Cache-Control: max-age=0');
		  $writer = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');

		  $writer->save('php://output');
		  exit;
	}
	
	
	
	function uploadtestcase()
	{
		$id = $this->uri->segment(3);
	
		if (empty($id))
		{
			show_404();
		}
		//GET DATA FROM TABLE
		$data['project_row'] = $this->Project_Details_model->get_record_by_id($id);
		$data['version'] = $this->Project_Details_model->get_current_version($id);
		
		$this->form_validation->set_rules('file', '', 'callback_file_check');
		if(($this->form_validation->run())==false)
		{
			$data['title'] = "TMT - Upload TestCase";
			$this->load->view('Home/header',$data);
			$this->load->view('Home/menu');
			$this->load->view('TestCase/uploadtestcase',$data);
			$this->load->view('Home/footer');
		}
		else
		{
		//UPLOAD STARTS
			$config['upload_path'] = './upload/File/';
			$config['allowed_types'] = 'xls|xlsx';
			$config['overwrite'] = TRUE;
			//$config['max_size'] = '';
			
			$this->load->library('upload', $config);
			
			//echo($displaypicture);
			if( !$this->upload->do_upload('file') ){
				print_r($this->upload->display_errors());
			}else{
				 $uploadData = $this->upload->data();
                 $uploadedFile = $uploadData['file_name'];
				 //print_r($uploadedFile);
				 
				 $object =  PHPExcel_IOFactory::load($config['upload_path'].$uploadedFile);
				foreach($object->getWorksheetIterator() as $worksheet)
   				{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				//print_r($highestRow);
				//print_r($highestColumn);
				
				for($row=2; $row<=$highestRow; $row++)
				{
				 $module_name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
				 $feature_name = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				 $high_level_scenario = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				 $checkpoints = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				 $execusion_steps = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
				 $expected_result = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
				
				  $data = array(
				  'status'=>'Active',
				  'project_id'=>$this->input->post('projectid'),
				  'client_name'=>$this->input->post('clientname'),
				  'version'=>$this->input->post('version'),
				  'module_name'  => $module_name,
				  'feature_name'   => $feature_name,
				  'high_level_scenario'    => $high_level_scenario,
				  'checkpoints'  => $checkpoints,
				  'execution_steps'   => $execusion_steps,
				  'expected_result'   => $expected_result,
				  'created_by'=> $_SESSION['USER_FULL_NAME'],
				  'user_type'=> $_SESSION['USER_TYPE']
				 );
				 $this->TestCase_model->add_record($data);
				 
				}
			   }
			   
			};
			
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    
                    <i class="icon fa fa-check"></i> Record Added Successfully.
                  </div>
				  ');
			
			redirect(base_url().'TestCase/testcaselist'); 

		}
     }
     function file_check($str){
        $allowed_mime_type_arr = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet','application/vnd.ms-excel');
        $mime = get_mime_by_extension($_FILES['file']['name']);
        if(isset($_FILES['file']['name']) && $_FILES['file']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Please select only XLS/XLSX file.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check', 'Please choose a file to upload.');
            return false;
        }
    }
	
	
	
	
	
	
	
	
	
	
	
	
}
