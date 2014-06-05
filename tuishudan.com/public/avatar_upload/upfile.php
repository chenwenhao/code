<?php
echo $this->userinfo->id;die;
/**********  仅测试程序 **********/
define('PATH', dirname(dirname(dirname(__FILE__)))); // 根目录

$savePath = PATH .'/public/avatar/';  //图片存储路径
$savePicName = time();  //图片存储名称


$file_src = $savePath.$savePicName."_src.jpg";
$filename162 = $savePath.$savePicName."_162.jpg"; 
$filename48 = $savePath.$savePicName."_48.jpg"; 
$filename20 = $savePath.$savePicName."_20.jpg";    

$src=base64_decode($_POST['pic']);
$pic1=base64_decode($_POST['pic1']);   
$pic2=base64_decode($_POST['pic2']);  
$pic3=base64_decode($_POST['pic3']);  

if($src) {
	file_put_contents($file_src,$src);
}

file_put_contents($filename162,$pic1);
file_put_contents($filename48,$pic2);
file_put_contents($filename20,$pic3);

$rs['status'] = 1;
$rs['picUrl'] = '/avatar/'. $savePicName;

print json_encode($rs);
?>
