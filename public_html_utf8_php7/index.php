<?php
/*
---------------------------------------------------------------------------------------------------
Program NAME : ohing PHP Framework 1
Content : index 엔진 1.0
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

- 기본출력 화면을 보여주는 기능
*/


$start_time = microtime(); //프로그램실행속도측정 - 테스트를 위해서 임시적용.


### 디폴트 설정 파일(전페이지 공통 사항 파일)###
include_once $_SERVER['DOCUMENT_ROOT']."/System/cfg/global.inc.php"; 



### 배열을 글로벌 변수로 만드는 함수###
params();

$dirname = ThisDirName($dirname);

### 프로세스의 디렉토리 경로등 기본 설정 상수파일###
include_once $_SERVER['DOCUMENT_ROOT']."/System/cfg/proc_default.cfg.php"; 



### 프로세스 파일(예 /login/ 은 로그인 프로세스, /?dirname=login 도 같은 방법이다)###
$proc_file = SITE_PUB_PATH.SITE_PROC_PATH."/".$dirname."/".$dirname.".proc.php";

### 해당 프로세스 호출###
if(file_exists($proc_file)) { 
	include $proc_file;
}



### 레이아웃 호출(스킨은 레이아웃 에서 호출한다)###
include SITE_PUB_PATH.SITE_PROC_PATH."/layout/layout.inc.php";



?>
