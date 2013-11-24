<?php
/*
**信息处理工具包
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/

class InfoDisposeManager extends CApplicationComponent{

	Yii::import('application.extensions.PHPExcel.PHPExcel.php');
	Yii::import('application.extensions.PHPExcel.PHPExcel.IOFactory.php');
	Yii::import('application.extensions.PHPExcel.PHPExcel.Writer.Excel5.php');

	/*
	**excel方式导出数据
	**注意表头标题应当和数据项对应,建议使用标准二维数组作为参数！
	*/
	public static function ExcelOutput($title,$data){
		$excelData = new PHPExcel();

		if(!empty($title) && is_array($title) && !empty($title) && is_array($title)){
			$titleNumber = 1;
			$titleLevel = 'A';

			foreach($title as $value){
				$excelData->getActiveSheet()->setCellValue($titleLevel.$titleNumber,$value);
				$titleLevel++;
			}

		
			foreach($data as $value){
				$titleLevelPointer = 'A';
				$titleNumber++;

				foreach($data as $key){
					$excelData->getActiveSheet()->setCellValue($titleLevelPointer.$titleNumber,$key);
					$titleLevelPointer++;
				}
			
			}

			$OutputFilname = 'excelFile'.Tool::getRandName().'xls';
			$xlsWriter = new PHPExcel_Writer_Excel5($excelData);

			header("Content-Type: application/force-download"); 
			header("Content-Type: application/octet-stream"); 
			header("Content-Type: application/download"); 
			header('Content-Disposition:inline;filename="'.$OutputFilname.'"'); 
			header("Content-Transfer-Encoding: binary"); 
			header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); 
			header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); 
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
			header("Pragma: no-cache"); 

			$xlsWriter->save("php://output");
			$finalFileName = (Yii::app()->basePath.'/runtime/'.time().'.xls'; 
			$xlsWriter->save($finalFileName);

			echo file_get_contents($finalFileName);  


		}
		

	}
}


?>