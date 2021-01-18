<?php
/*
---------------------------------------------------------------------------------------------------
Program NAME : ohing PHP layout
Content : layout
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

레이아웃 가져오기 프로세스

*/


include_once SITE_LIB_PATH."/function_layout.inc.php";  //레이아웃 기본함수


### 타이틀###
$ste_title = SITE_TITLE;
$ste_title .= $proc_ini_info['dir_title'];



### 자동 리플래시###
if($proc_ini_info['refresh_time']){
/*
### $proc_ini_info[refresh_time] 초동안 아무행동이 없다면 리플래시###

$footer_js .=<<< JS

///페이지 리로딩타임
var gameangel_page_time = $proc_ini_info[refresh_time];

function gameangel_page_loading(){

	gameangel_page_time = gameangel_page_time-1;

	if(gameangel_page_time <= 0){
		document.location.reload();
	}

}

setInterval("gameangel_page_loading()",1000);

JS;

$body_loading_status = " onmousemove=\"gameangel_page_time=$proc_ini_info[refresh_time];\" ";
$body_loading_status .= " onclick=\"gameangel_page_time=$proc_ini_info[refresh_time];\" ";
$body_loading_status .= " onkeydown=\"gameangel_page_time=$proc_ini_info[refresh_time];\" ";
*/
}



### js첨부파일 설정 ###
($proc_ini_info['js'] == NULL) ? $JS_file = SITE_INF_PATH."/js.ini.php" : $JS_file = SITE_DIR_INI_PATH._DIR_NAME."/".$proc_ini_info['js'].".ini.php"; //js 파일 설정

$HTML_js = IncludeHead($JS_file,"js");

### css첨부파일 설정 ###
($proc_ini_info['css']== NULL) ? $CSS_file = SITE_INF_PATH."/css.ini.php" : $CSS_file = SITE_DIR_INI_PATH._DIR_NAME."/".$proc_ini_info['css'].".ini.php"; //css 파일 설정

$HTML_css = IncludeHead($CSS_file);

if($proc_ini_info['hack_css']!= NULL){
	$CSS_hack_file = SITE_DIR_INI_PATH._DIR_NAME."/".$proc_ini_info['hack_css'].".ini.php"; //css 파일 설정
	$HTMLhack_css = IncludeHead($CSS_hack_file, "hack_css");
}




### 스킨파일 가져오기###
$skin_file_dir = SITE_SKIN_PATH."/".$dirname."/";
$skin_file = $skin_file_dir.$dirname.".skin.php";

### 해당 레이아웃###
include SITE_LAYOUT_PATH."/".$proc_ini_info['layout'].$proc_ini_info['layout_html'];

?>
