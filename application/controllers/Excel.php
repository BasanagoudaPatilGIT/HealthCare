<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Excel  extends CI_Controller {

	function __construct()
	{
		// Call the Model constructor
		parent::__construct();
		
		if (!isset( $_SESSION['IS_LOGGED_IN'] )) { 
			redirect(base_url()); 
		}
		
		$this->load->model('Combo_model');
		$this->load->model('Product_model');
		$this->load->model('User_model');
		require(APPPATH . 'third_party/PHPExcel_1.8/Classes/PHPExcel.php');
		require(APPPATH . 'third_party/PHPExcel_1.8/Classes/PHPExcel/Writer/Excel2007.php');
		
	}
	
	
	function medicine_template()
	{
		$objPHPExcel = new PHPExcel();
		
		  $objPHPExcel->setActiveSheetIndex(0);
		
			$objPHPExcel->getActiveSheet()->SetCellValue('A1','ProductType');
			$objPHPExcel->getActiveSheet()->SetCellValue('B1','ProductName');
			$objPHPExcel->getActiveSheet()->SetCellValue('C1','AboutProduct');
			$objPHPExcel->getActiveSheet()->SetCellValue('D1','TaxPercent');
			$objPHPExcel->getActiveSheet()->SetCellValue('E1','MRP[For Pcs/Bottle]');
			$objPHPExcel->getActiveSheet()->SetCellValue('F1','PurchaseRate[For Pcs/Bottle]');
			$objPHPExcel->getActiveSheet()->SetCellValue('G1','SaleRate[For Pcs/Bottle]');
			$objPHPExcel->getActiveSheet()->SetCellValue('H1','PackDate');
			$objPHPExcel->getActiveSheet()->SetCellValue('I1','ExpiryDate');
			$objPHPExcel->getActiveSheet()->SetCellValue('J1','StripsInBox');
			$objPHPExcel->getActiveSheet()->SetCellValue('K1','PcsInStrip');
			$objPHPExcel->getActiveSheet()->SetCellValue('L1','BottlesInBox');
			$objPHPExcel->getActiveSheet()->SetCellValue('M1','MlInBottle');
			$objPHPExcel->getActiveSheet()->SetCellValue('N1','QuantityLimit[In Pcs/Bottle]');
			$objPHPExcel->getActiveSheet()->SetCellValue('O1','UOM');
			$objPHPExcel->getActiveSheet()->SetCellValue('P1','Quantity');

			$row = 2;
			
		 
		  
		  $objPHPExcel->getActiveSheet()->setTitle("Medicine Details");
		  $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->getAlignment()->setHorizontal('center');
		  $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->applyFromArray(array('font'=>array('size'=>12)));
			  
		  
		  
		  $filename = "MedicineTemplate.xlsx"; 
 		  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		  header('Content-Disposition: attachment;filename="'.$filename.'"');
		  header('Cache-Control: max-age=0');
		  $writer = PHPExcel_IOFactory::createWriter($objPHPExcel,'Excel2007');

		  $writer->save('php://output');
		  exit;
	}
	
	
	function uploadmedicine()
	{
		$id = $this->input->post('cbo_doctor');
		$user_row = $this->User_model->get_record_by_id($id);
		$data['cbo_doctor'] = $this->Combo_model->cbo_doctor();
		$this->form_validation->set_rules('file', '', 'callback_file_check');
		$this->form_validation->set_rules('cbo_doctor','Doctor','required');
		if(($this->form_validation->run())==false)
		{
			$data['title'] = "HealthCare - Upload Medicine";
			$this->load->view('Home/header',$data);
			$this->load->view('Home/menu');
			$this->load->view('Products/uploadmedicine',$data);
			$this->load->view('Home/footer');
		}
		else
		{
		//UPLOAD STARTS
			$config['upload_path'] = './upload/File/';
			$config['allowed_types'] = 'xls|xlsx';
			$config['overwrite'] = TRUE;
			
			$this->load->library('upload', $config);
			
			if( !$this->upload->do_upload('file') ){
				print_r($this->upload->display_errors());
			}else{
				 $uploadData = $this->upload->data();
                 $uploadedFile = $uploadData['file_name'];
				
				 
				 $object =  PHPExcel_IOFactory::load($config['upload_path'].$uploadedFile);
				foreach($object->getWorksheetIterator() as $worksheet)
   				{
				$highestRow = $worksheet->getHighestRow();
				$highestColumn = $worksheet->getHighestColumn();
				
				
				for($row=2; $row<=$highestRow; $row++)
				{
				 $data['auto_code'] = $this->Product_model->get_productcode($id);
				 $prodcode = $data['auto_code']['series_id'].''.$data['auto_code']['user_id'].'-'.$data['auto_code']['continues_count'];
				 $productcount = $data['auto_code']['continues_count'];
				 $productType = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
				 $productName = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
				 $Abtproduct = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
				 $Taxper = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
				 $MRP = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
				 $Prate = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
				 $Srate = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
				 $packdate = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
				 $expdate = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
				 $stripsinbox = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
				 $pcsinstrip = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
				 $bottlesinbox = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
				 $mlinBot = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
				 $qtylimit = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
				 $UOM = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
				 $prodqty = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
				
				$batchno = $prodcode.'-'.(String)$expdate.'-'.(int)$MRP.'-'.(int)$Prate.'-'.(int)$Srate;
				
				if($UOM == 'Boxes'){
				if($productType == "Tablet"){
					$prodqty = $prodqty * (int)$stripsinbox * (int)$pcsinstrip;
					
				}else if($productType == "Liquid"){
					$prodqty = $prodqty * (int)$bottlesinbox * (int)$mlinBot;
					
				}
				
				}elseif($UOM == 'Strips'){
					$prodqty = $prodqty * (int)$pcsinstrip;
					
				}elseif($UOM == 'Pcs'){
					$prodqty = $prodqty;
					
				}elseif($UOM == 'Bottles'){
					$prodqty = $prodqty * (int)$mlinBot;
					
				}
				
				 if($productType == 'Tablet'){
					  
					  $data = array(
						'status'=>'Active',
						'user_id'=>$id,
						'product_code'=>$prodcode,
						'product_name'=>$productName,
						'product_qty'=>$prodqty,
						'abtproduct'=>$Abtproduct,
						'batchno'=>$batchno,
						'mrp'=>$MRP,
						'purrate'=>$Prate,
						'salerate'=>$Srate,
						'packdate'=>$packdate,
						'expirydate'=>$expdate,
						'stripsinbox'=>$stripsinbox,
						'pcsinstrip'=>$pcsinstrip,
						'bottlesinbox'=>1,
						'mlinbottle'=>1,
						'qtylimit'=>$qtylimit,
						'tax_percent'=>$Taxper,
						'product_type'=>$productType
					 );
					 $this->Product_model->add_record($data);
					 
					  $data =array
						(
							'last_updated'=>mdate($datestring),
							'continues_count'=> (int)$productcount + 1
						);
					
						$this->Product_model->incriment_productcode_no($data,$user_row['ent_id']);
				  }else if($productType == 'Liquid'){
					  $data = array(
						'status'=>'Active',
						'user_id'=>$this->input->post('cbo_doctor'),
						'product_code'=>$prodcode,
						'product_name'=>$productName,
						'product_qty'=>$prodqty,
						'abtproduct'=>$Abtproduct,
						'batchno'=>$batchno,
						'mrp'=>(double)$MRP /(double)$mlinBot,
						'purrate'=>(double)$Prate /(double)$mlinBot,
						'salerate'=>(double)$Srate /(double)$mlinBot,
						'packdate'=>$packdate,
						'expirydate'=>$expdate,
						'stripsinbox'=>1,
						'pcsinstrip'=>1,
						'bottlesinbox'=>$bottlesinbox,
						'mlinbottle'=>$mlinBot,
						'qtylimit'=>$qtylimit,
						'tax_percent'=>$Taxper,
						'product_type'=>$productType
					 );
					 $this->Product_model->add_record($data);
					 $datestring = date('Y-m-d');	
					 $data =array
						(
							'last_updated'=>mdate($datestring),
							'continues_count'=> (int)$productcount + 1
						);
					
						$this->Product_model->incriment_productcode_no($data,$user_row['ent_id']);
				  }
				  
				 
				 
				}
			   }
			   
			};
			
			$this->session->set_flashdata('msg','<div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    
                    <i class="icon fa fa-check"></i> Record Added Successfully.
                  </div>
				  ');
			
			redirect(base_url().'Product/productlist'); 

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
