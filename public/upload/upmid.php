<?php
 if (isset($_GET['act']))
 {
 	$action = $_GET['act'];
 }
 else
 {
 	$action = '';
 }

if($action=='delimg'){
	$filename = $_POST['imagename'];
	if(!empty($filename)){
		unlink('files/'.$filename);
		echo '1';
	}else{
		echo '删除失败.';
	}
}else{
	if($_FILES)
	{
	 $picname = $_FILES['upfile']['name'];
	 $picsize = $_FILES['upfile']['size'];
	 $pic_path = '';
	 if ($picname != "") {
		// if ($picsize > 1024000) {
		// 	echo '图片大小不能超过1M';
		// 	exit;
		// }
		$type = strstr($picname, '.');
		if ($type != ".png"&&$type != ".jpg"&&$type != '.gif') {
			echo 'invalid media';
			exit;
		}
		$pics = date("YmdHis") . $type;
		$mdir = "files/" . date("Ymd")."/";//上传路径
		if (!is_dir($mdir)) {
			mkdir($mdir);
		}

		$pic_path =  $mdir . $pics;//存在位置
		move_uploaded_file($_FILES['upfile']['tmp_name'], $pic_path);
		if (file_exists($pic_path)) {
			$arr = getimagesize($pic_path);
			$width = $arr[0];
			$height = $arr[1];
			$size = $width/$height;
			$sizeS = 62/52;
			
			if ($size != $sizeS) {
				$status = 'error';
			}
			else {
				$status = 'success';
			}
		}
	 }
	 $arr = array(
		'name'=>$pics,
		'path'=>$pic_path,
		'status'=>$status,
	 );
	 echo json_encode($arr);
	}
}
?>