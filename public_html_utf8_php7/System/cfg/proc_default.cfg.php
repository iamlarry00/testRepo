<?php
/*
---------------------------------------------------------------------------------------------------
Program NAME : ohing PHP default
Content : default
Version : 1.0
File Name : 
Charset : utf-8
Directory : 
URI :
---------------------------------------------------------------------------------------------------
개발자 : 권오용
개발일 : 2010-12-01
최종수정일 : 2010-12-01
email: koy@huanworks.com
msn:ohing80@hotmail.com
---------------------------------------------------------------------------------------------------
[상세설명]

- 해당 프로세스의 기본 설정을 상수로 만드는 프로세스

*/

$proc_ini_file = $dirname.".ini.php";

if($p){//서브 페이지가 있고 기본 성정을 분산 시켰다면 분산 처리한다
	$tmp_sub_dirname = "/".$p;
	$tmp_proc_ini_file = $dirname."_".$p.".ini.php";

	if(file_exists(SITE_INF_PATH."/dir_ini/".$dirname.$tmp_sub_dirname."/".$tmp_proc_ini_file)) { 
		
		$sub_dirname = "/".$p;
		$proc_ini_file = $dirname."_".$p.".ini.php";

	}

}

if(!file_exists(SITE_INF_PATH."/dir_ini/".$dirname.$sub_dirname."/".$proc_ini_file)) { 

	echo "not dir ini";
	exit;

}



$proc_ini_info = parse_ini_file(SITE_INF_PATH."/dir_ini/".$dirname.$sub_dirname."/".$proc_ini_file); //싸이트 기본 설정 변수가 저장되 있는 파일.

$site_title = $site_title." - ".$proc_ini_info['dir_title'];

?>
