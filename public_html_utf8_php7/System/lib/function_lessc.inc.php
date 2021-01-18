<?

// TEST 

include_once $_SERVER['DOCUMENT_ROOT']."/System/cfg/default.cfg.php"; // 디렉토리 경로등 기본 설정 상수파일
//include_once $_SERVER['DOCUMENT_ROOT']."/System/cfg/snc_cache_path.cfg.php"; // 디렉토리 경로등 기본 설정 상수파일
include_once SITE_LIB_PATH."/function.inc.php";  //공용 함수 및 클래스 파일.


include_once SITE_LIB_PATH."/lessc.inc.php"; // LESS 라이브러리 경로
//$cssname = "test"; // test

$less = new lessc;
$less->setFormatter("compressed"); // css 압축하기
try {
    $less->checkedCompile($_SERVER['DOCUMENT_ROOT']."/css/less/".$cssname.".less", SITE_CACHE_PATH."/css/".$cssname.".css");
} catch (Exception $ex) {
  // 사내 아이피에서만 문법 오류시 출력
  if($_SERVER['REMOTE_ADDR'] == IP_OFFICE) {
	echo "LESS 문법 오류 발생(사내 아이피에서만 노출) : ".$ex->getMessage();
  }
}
?>


<?

/* 2013-08-20, 사용할 때는 레이아웃 파일이나, 헤더 파일 상단에 아래 내용을 추가한다.

########################## LESS ##########################
// 여준혁, LESS 라이브러리로 CSS를 컴파일함.
$cssname = "test2"; // css 파일이름 지정, less 파일이 없는 경우 오류 발생
@include_once SITE_LIB_PATH."/function_lessc.inc.php"; // LESS PHP 경로
##########################################################

<link type="text/css" rel="stylesheet" href="/app_board/css/css.php?c=<?=base64_encode('/'.$cssname.'.css');?>" />
*/
?>
