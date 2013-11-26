<?php
/*
**信息处理工具包
design By HJtianling_LXY,<2507073658@qq.com>
2013.11.16
*/

class InfoDisposeManager extends CApplicationComponent{
	  
	/*
	**excel方式导出数据
	**注意表头标题应当和数据项对应,建议使用标准二维数组作为参数！
	*/
	public function ExcelOutput($title,$data){
		spl_autoload_unregister(array('YiiBase','autoload'));//暂时关闭Yii自动加载功能

		Yii::import('application.extensions.PHPExcel.PHPExcel.*');
		include dirname(Yii::app()->basePath).'/application/extensions/PHPExcel/PHPExcel.php';
		include dirname(Yii::app()->basePath).'/application/extensions/PHPExcel/PHPExcel/IOFactory.php';
		include dirname(Yii::app()->basePath).'/application/extensions/PHPExcel/PHPExcel/Writer/Excel5.php';
		
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

				foreach($value as $key){
					$excelData->getActiveSheet()->setCellValue($titleLevelPointer.$titleNumber,$key);
					$titleLevelPointer++;
				}
			
			}
			 

			$OutputFilname = 'excelFile.xls';
			//$objWriter = new PHPExcel_Writer_Excel2007($excelData);
			$objWriter = new PHPExcel_Writer_Excel5($excelData);
			header("Pragma: public");
			header("Expires: 0");
			header('Cache-Control:must-revalidate, post-check=0, pre-check=0');
			header("Content-Type:application/force-download");
			header("Content-Type:application/vnd.ms-execl");
			header("Content-Type:application/octet-stream");
			header("Content-Type:application/download");;
			header('Content-Disposition:attachment;filename='.$OutputFilname.'');
			header("Content-Transfer-Encoding:binary");

			$objWriter->save('php://output');

			spl_autoload_register(array('YiiBase','autoload'));//恢复Yii自动加载功能
			
		}
		
	}


	/*
	**用户留言以及提问添加
	*/
	public function UsermessageAdd($data){
		if(!empty($data) && is_array($data)){
			$model = new FrontUserMessageBoard;
			$model->attributes = $data;
			$model->add_time = time();
			$model->reply_status = 0;
			if($model->save())
				return 200;
			else
				return 400;
			
		}
	}
		

}


?>