<?
define("__CASTLE_PHP_VERSION_BASE_DIR__", "/home/castle/public_html");
include_once(__CASTLE_PHP_VERSION_BASE_DIR__."/castle_referee.php");
?>
<?php
/*
---------------------------------------------------------------------------------------------------
Program NAME : ohing PHP global
Content : global
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

- 기본 설정 하는 프로세스
*/


/*
if($_GET['bid']){
	
	
	$tmp_params_data_get['bid'] = $_GET['bid'];

	$_GET['bid'] = (int) $_GET['bid'];


}



if($_GET['bname']){

	$tmp_params_data_get['bname'] = $_GET['bname'];

	$_GET['bname'] = preg_replace ("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\|\!\?\*$#<>()\[\]\{\}]/i", "", $_GET['bname']);//특수문자 제거 _ 언더바 허용

}

if($_POST['bname']){

	$tmp_params_data_post['bname'] = $_POST['bname'];	

	$_POST['bname'] = preg_replace ("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\|\!\?\*$#<>()\[\]\{\}]/i", "", $_POST['bname']);//특수문자 제거 _ 언더바 허용

}
*/


if($_GET['p']){

	$tmp_params_data_get['p'] = $_GET['p'];

	$_GET['p'] = preg_replace ("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\|\!\?\*$#<>()\[\]\{\}]/i", "", $_GET['p']);//특수문자 제거 _ 언더바 허용

}

if($_POST['p']){

	$tmp_params_data_post['p'] = $_POST['p'];	

	$_POST['p'] = preg_replace ("/[ #\&\+\-%@=\/\\\:;,\.'\"\^`~\|\!\?\*$#<>()\[\]\{\}]/i", "", $_POST['p']);//특수문자 제거 _ 언더바 허용

}


if($tmp_params_data_post){

	foreach($tmp_params_data_post as $k => $v){

		if (strcasecmp($v, $_POST[$k]) != 0) {
			echo "param_post error";
			exit;
		}

	}

}




if($tmp_params_data_get){

	foreach($tmp_params_data_get as $k => $v){

		if (strcasecmp($v, $_GET[$k]) != 0) {
			echo "param_get error";
			exit;
		}

	}

}



unset($tmp_params_data_post, $tmp_params_data_get);




### include ### 
include_once $_SERVER['DOCUMENT_ROOT']."/System/cfg/default.cfg.php"; // 디렉토리 경로등 기본 설정 상수파일
include_once SITE_LIB_PATH."/function_default.inc.php";  //기본함수 전체 페이지에 적용되는 꼭 필요한것만 넣어야 한다
include_once SITE_LIB_PATH."/function_login.inc.php";  //로그인 함수 파일.
include_once SITE_LIB_PATH."/function_db.inc.php";  //로그인 함수 파일.
include_once SITE_LIB_PATH."/function_secuStr.inc.php";  //공용 함수 및 클래스 파일.
include_once SITE_LIB_PATH."/horagon_encoder.inc.php";  //기본함수 전체 페이지에 적용되는 꼭 필요한것만 넣어야 한다



### 내부 아이피에서는 오류 출력###
if($_SERVER['REMOTE_ADDR'] == IP_OFFICE){
error_reporting(E_ERROR | E_PARSE);
ini_set("display_errors", 1);
}

### 접근한 모바일 체크###
$mobile_agent = check_agent();













### 배열을 글로벌 변수로 만드는 함수###
params();




// 로그인 상태 확인
// **************************************************************************
$login_ck_name = array('admin', 'user');

$is_mem_logined = false;

foreach ($login_ck_name as $v) {

	if ( empty($_COOKIE[$v]) ) continue;
	if ( empty($_COOKIE[$v]['mid']) ) continue;

	$tmp_login_mode    = $v;

	$is_mem_logined = true;//admin 또는 user 로그인 한 상태


	// 쿠키 조작 (불법접근) 방지
	// **************************************************************************

	$user_ssid = $_COOKIE[$tmp_login_mode]['mid'].$_COOKIE[$tmp_login_mode]['id'];
	if ( $user_ssid != decode64($_COOKIE[$tmp_login_mode]['ssid']) ){


		$login = new Login($tmp_login_mode, $goURL);
		$login->doLogout(false);
		
		exit;

	}


	//-------------------------------------------------------- 쿠키 조작 - 불법접근


};
//----------------------------------------------------------- 로그인 상태 확인

if(!$logout_mode)$logout_mode = 'user';

// 로그아웃
// **************************************************************************
if (!empty($_COOKIE[$logout_mode]['mid']) && 'action' == $logout_prc) {

	$login = new Login($logout_mode, $goURL);
	$login->doLogout(true);
	exit;
}
//------------------------------------------------------------------- 로그아웃

// 로그인
// **************************************************************************

$is_loging = false;

if($login_mode){

	if ( !empty($_COOKIE[$login_mode]['mid']) )$is_loging = true;//로그인 한 상태

}

if ( !$is_loging && $user_id && $user_pwd ) {

	$select_login_mode = 'guest';
	switch ($login_mode) {
		case 'admin':
		case 'user' :
			$select_login_mode = $login_mode;
	}

	$get_login_url = '';
	if ($login_url) $get_login_url = $login_url;

	$login = new Login($select_login_mode, $goURL, $get_login_url);
	switch ($select_login_mode) {
		case 'guest':
			if ( empty($_COOKIE['guest']) ) $login->doGuestLog();
			break;

		case 'admin' :
		case 'user' :
			$login->doLogin($user_id, $user_pwd);
			exit;
	}

} elseif ( !$is_mem_logined && empty($_COOKIE['guest']) ) {

	$login = new Login();
	$login->doGuestLog();
}
//--------------------------------------------------------------------- 로그인


?>