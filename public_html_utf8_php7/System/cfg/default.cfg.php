<?
define("__CASTLE_PHP_VERSION_BASE_DIR__", "/home/castle/public_html");
include_once(__CASTLE_PHP_VERSION_BASE_DIR__."/castle_referee.php");
?>
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

- 기본 설정을 상수로 만드는 프로세스
*/


$ini_info = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/System/inf/site_info.ini.php"); //싸이트 기본 설정 변수가 저장되 있는 파일.

define("SITE_TITLE", $ini_info['title']); //싸이트 기본 이름

$site_title = SITE_TITLE;

if($ini_info['domain_code'] === TRUE) { //2차 도메인명이 설정 되었을때.

	$sub_domain = $ini_info['domain_code'];

} else { //2차도메인명이 설정 되지 않았을때 들어온 도메인을 지정

	$name_server = $_SERVER["HTTP_HOST"];

	list($sub_domain,$first_domain,$last_domain) = explode(".",$name_server);

}




($_SERVER['HTTPS'] != "on") ? $http_type = "http" : $http_type = "https";//보안 적용일때 프로코콜을 https 로 수정 하기
define("SITE_DOMAIN", $http_type."://".$sub_domain.".".$ini_info['domain_name'].".".$ini_info['domain_base']); // 설치한 도메인네임
define("SITE_DOMAIN_SSL", "https://".$ini_info['domain_ssl']); // 설치한 도메인네임 SSL
define("SITE_COOKIE_DOMAIN", $sub_domain.".".$ini_info['domain_name'].".".$ini_info['domain_base']); // 쿠키를 굽기위한 도메인네임
define("SITE_GLOBAL_COOKIE_DOMAIN", ".".$ini_info['domain_name'].".".$ini_info['domain_base']); // 전체 쿠키를 굽기위한 도메인네임
define("SITE_ADMIN_EMAIL", $ini_info['admin_email']); //싸이트 관리자 email
define("SITE_ROOT_PATH", str_replace("/public_html","",$_SERVER['DOCUMENT_ROOT'])); // 계정 홈 디렉토리
define("SITE_KEYWORDS", $ini_info['keywords']); // 메타키워드
define("SITE_DESCRIPTION", $ini_info['description']); // 메타 디스크립션

define("WWW_SERVER", "http://".$ini_info['domain_www']); // www 서버
define("IMG_SERVER", "http://".$ini_info['domain_img']); // cdn 이미지서버
define("PDS_SERVER", "http://".$ini_info['domain_pds']); // cdn 파일서버

define("IMG_SERVER_TRUE", "http://".$ini_info['domain_img_true']); // 실제 이미지서버
define("PDS_SERVER_TRUE", "http://".$ini_info['domain_pds_true']); // 실제 파일서버



/*
---------------------------------------------------------------------------------------------------
	[디렉토리 파일 관련 상수 처리] -  절대 경로
---------------------------------------------------------------------------------------------------
*/
### 기본 디렉토리 경로 설정 ###
$ini_path = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/System/inf/site_path.ini.php"); //디렉토리환경 파일가져오기.()

define("SITE_PUB_PATH", $_SERVER['DOCUMENT_ROOT']); // 홈 디렉토리.


define("SITE_LOG_PATH", SITE_ROOT_PATH.$ini_path['log']); // log 쌓는곳.
define("SITE_CACHE_PATH", SITE_ROOT_PATH.$ini_path['cache']); // 캐시용 임시 문서들이 있는 곳
define("SITE_CACHE_PATH2", "/home/m.appstory".$ini_path['cache']); // 캐시용 임시 문서들이 있는 곳
define("SITE_SYS_PATH", $ini_path['sys']); // System 디렉토리.
define("SITE_PROC_PATH", SITE_SYS_PATH.$ini_path['proc']); // System 디렉토리.
define("SITE_HTML_PATH", SITE_SYS_PATH.$ini_path['html']); // 기본적으로 보여줄 html 문서들이 있는 곳.
define("SITE_INF_PATH", SITE_PUB_PATH.SITE_SYS_PATH.$ini_path['inf']); // 설정(*.ini)파일들이 들어있는 곳. 보안상 *.ini.php 로 만든다.
define("SITE_LIB_PATH", SITE_PUB_PATH.SITE_SYS_PATH.$ini_path['lib']); // System include 파일들이 들어있는 곳.
define("SITE_DIR_INI_PATH", SITE_INF_PATH.$ini_path['dir_ini']); // 생성된 디렉토리 설정(*.ini)파일들이 들어있는 곳. 보안상 *.ini.php 로 만든다.


define("WEBCACHE_PATH", SITE_ROOT_PATH.$ini_path['webcache']); // 웹캐시 쌓는곳.
define("SITE_UPLOAD_PATH", $ini_path['upload_dir']); // 업로드 디렉토리

/*디자인HTML 관련 디렉토리 상수 설정*/
define("SITE_LAYOUT_PATH", SITE_PUB_PATH.SITE_HTML_PATH.$ini_path['layout']); // 기본적으로 보여줄 layot 디렉토리가 있는 곳.
define("SITE_SKIN_PATH", SITE_PUB_PATH.SITE_SYS_PATH.$ini_path['skin']); // 기본적으로 보여줄 우측메뉴 디렉토리가 있는 곳.
define("SITE_IMG_PATH", $ini_path['images']); // 기본 image 디렉토리.
define("SITE_CSS_PATH", SITE_HTML_PATH.$ini_path['css']); // 기본 css 디렉토리.
define("SITE_JS_PATH", SITE_HTML_PATH.$ini_path['jscript']); // 자바스크립트 디렉토리


define("SITE_LAYOUT_PATH", SITE_PUB_PATH.SITE_HTML_PATH.$ini_path['layout']); // 기본적으로 보여줄 layot 디렉토리가 있는 곳.
define("SITE_HEAD_PATH", SITE_PUB_PATH.SITE_HTML_PATH.$ini_path['head']); // 기본적으로 보여줄 상단메뉴 디렉토리가 있는 곳.
define("SITE_LEFT_PATH", SITE_PUB_PATH.SITE_HTML_PATH.$ini_path['left']); // 기본적으로 보여줄 좌측메뉴 디렉토리가 있는 곳.
define("SITE_CENTER_PATH", SITE_PUB_PATH.SITE_HTML_PATH.$ini_path['center']); // 기본적으로 보여줄 내용 디렉토리가 있는 곳.
define("SITE_RIGHT_PATH", SITE_PUB_PATH.SITE_HTML_PATH.$ini_path['right']); // 기본적으로 보여줄 우측메뉴 디렉토리가 있는 곳.
define("SITE_FOOT_PATH", SITE_PUB_PATH.SITE_HTML_PATH.$ini_path['foot']); // 기본적으로 보여줄 하단메뉴 디렉토리가 있는 곳.




/*
---------------------------------------------------------------------------------------------------
	[프로그램 처리 설정 관련 상수 처리]
---------------------------------------------------------------------------------------------------
*/
$ini_var = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/System/inf/site_cfg.ini.php"); //싸이트 기본 설정 변수가 저장되 있는 파일.
define("SITE_LOGIN_MODE", $ini_var['login_mode']); // 로그인 모드 설정
define("IMG_UP_SERVER", "http://".$ini_var['img_up_server']); // 이미지 업로드 서버
define("SITE_RELOGIN", $ini_var['relogin']); // 중복 로그인 방지 설정
define("SITE_DB_INI_FILE", SITE_INF_PATH."/".$ini_var['db_config_file']); // 기본 DB정보 파일
define("SITE_IP", $_SERVER['SERVER_ADDR']); // 설치한 도메인네임



/*사무실 아아피*/
if(in_array($_SERVER[REMOTE_ADDR], $ini_var['allow_ip'])){

	// list($return_allow_ip) = array_keys ($ini_var['allow_ip'], $_SERVER[REMOTE_ADDR]); 

	// if($return_allow_ip!="")
	
	
	define("IP_OFFICE", $_SERVER[REMOTE_ADDR]); //사무실 아이피
	
}else{
	define("IP_OFFICE", $ini_var['allow_ip'][0]); //없으므로 첫번째걸로 대체한다
}



?>
