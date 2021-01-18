<?


if($p == 'agreement'){

	$proc_ini_info['dir_title'] = "이용약관";

}elseif($p == 'private'){

	$proc_ini_info['dir_title'] = "개인정보취급방침";

}else{

	echo "<script>alert('not page'); location.href = '/';</script>";
	exit;

}


$site_title = $site_title." - ".$proc_ini_info['dir_title'];



?>
