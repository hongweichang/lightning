<?php

class Tool
{
	//获取一个随机命名
	public static function getRandName()
	{
		$getDate = date('YmdHis');
		$chars = array( 
        	"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",  
        	"l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",  
        	"w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",  
        	"H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",  
        	"S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",  
        	"3", "4", "5", "6", "7", "8", "9" 
    	);
    	$getChar = null;
    	for($i = 0;$i<5;$i++){
    		$n = rand(0,61);
    		$getChar = $getChar.$chars[$n];
    	}
    	$randName = $getDate.$getChar;
    	return $randName;
	}

	//获取文件类型
	public static function getFileType($fileName)
	{
		$extend = explode('.', $fileName);
		$n = count($extend)-1;
		$fileType = strtolower($extend[$n]);
		return $fileType;
	}


	//制作缩略图--使用扩展image制作
	public static function getThumb($srcPic,$width,$height,$thumbUrl)
	{
		if(file_exists($srcPic)){
			list($w,$h,$picType,$attr) = getimagesize($srcPic);

			if($w>$width||$h>$height){
				if($w>$h){
					$thumb_x = $width;
					$thumb_y = $h*($width/$w);
				}else{
					$thumb_y = $height;
					$thumb_x = $w*($height/$h);
				}

				$image = Yii::app()->image->load($srcPic);
				$image->resize($thumb_x,$thumb_y)->quality(85);
				$image->save($thumbUrl);
			}else{
				$thumbUrl = $srcPic;
			}
			return $thumbUrl;
		}
	}

	//	文件操作的函数
	public static function deleteFile($dir,$listArray)
	{
		$reDir = str_replace(Yii::app()->basePath,"",$dir);
		print_r($listArray);
		echo $dir;
		if(is_dir($dir)){
			$handler = opendir($dir);
			while(($file = readdir($handler))!==false){
				if($file != "." && $file != ".."){
					$reFile = $reDir."/".$file;
					if(in_array($reFile,$listArray))
					{
						echo $file."<br/>";
						/*if(unlink($dir."/".$file)){
							echo $file." be deleted!<br/>";
						}*/
					}
				}

			}
			closedir($handler);
		}
		
	}

	//截取UTF=8字符串
    public static function truncate_utf8_string($string, $length, $etc='...')
    {
        $result = '';
        $string = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
        $strlen = strlen($string);
        for ($i = 0; (($i < $strlen) && ($length > 0)); $i++){
        	if ($number = strpos(str_pad(decbin(ord(substr($string, $i, 1))), 8, '0', STR_PAD_LEFT), '0')){
            	if ($length < 1.0){
            		break;
            	}
            	$result .= substr($string, $i, $number);
            	$length -= 1.0;
            	$i += $number-1;
        	}else{
            	$result .= substr($string, $i, 1);
            	$length -= 0.5;
        	}
        }
        $result = htmlspecialchars($result, ENT_QUOTES, 'UTF-8');
        if ($i < $strlen){
        	$result .= $etc;
        }
        return $result;
    }

    // 搜索字符串处理返回数组
    public static function handleStr($str)
    {
    	$str=str_replace("'","",$str);
    	$str=str_replace("\"","",$str);
	    $str=str_replace("%","",$str);
	    // $str=str_replace("and"," ",$str);
	    // $str=str_replace("select","",$str);
	    $str=str_replace("@","",$str);
	    $str=str_replace("^","",$str);
	    $str=str_replace("&","",$str);
	    $str=str_replace("+"," ",$str);
	    $str=str_replace(",","",$str);
	    $str=str_replace("?","",$str);
	    $str=str_replace("*","",$str);
	    $str=str_replace("/","",$str);
	    // $str=str_replace("on","",$str);
	    $str=str_replace("expression","",$str);
	    $str=str_replace("<iframe","&lt;iframe",$str);
	    $str=str_replace("<script","&lt;script",$str);
	    $str=str_replace("<","&lt;",$str);
	    $str=str_replace(">","&gt;",$str);
	    if (empty($str)){
	       header("Location:./\n");
	    }else{
	      $keyword=trim($str);
	    }
	    return $keyword;
	}

}
?>