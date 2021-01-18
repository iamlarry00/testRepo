<?php
/*
---------------------------------------------------------------------------------------------------
Program NAME : HOYA PHP Framework 2
Content : 기본 함수 모음
Version : 1.0.3
File Name : function.inc.php
Charset : euc-kr
Directory : /System/lib
URI :
---------------------------------------------------------------------------------------------------
[개발자정보]

개발자 : 김호
개발일 : 2007.08.08
최종 수정일 : 2008.01.30
email: webmaster@hodragon.com
msn: webmaster@hodragon.com
homepage: www.hodragon.com
support : www.hoyaboard.com
---------------------------------------------------------------------------------------------------
[함수 리스트]

DBConnect($ini_file=NULL) : DB 연결 함수
MakeErrorFile($add_text=NULL,$path_and_file=NULL,$new_file=NULL,$over_write=1) : 에러 파일 만들기 함수
Makefile($path_and_file, $Input_content, $new_file=NULL, $over_write=NULL) : 파일 만들기 함수
Makeini($ini_file_name, $Input_ini_file_content, $add=FALSE) : ini 파일 만들기 함수
MkmyDir($path) : 디렉토리만드는 함수
PopupMsg($msg, $goURL="Back",$target="self") : alert 보여주는 함수
ReadDocFile($file_path) : 파일내용 불러오기 함수
ThisDirName() : 현재 디렉토리의 이름을 알아내는 함수
TimeProcess($start,$out=FALSE) :프로그램 실행속도 측정하는 함수
iniVar($_ver=NULL) : 구분자로 변수만드는 함수
DepthInclude($DEPTH, $filename) : 레이아웃에서 페이지를 불러오기 위한 함수

IDencode : 암호화 인코딩, 디코딩 클래스
Mysql : mysql 클래스

*/

function Test()
{
	echo "function.inc.php 연결";
}




### css,js 파일의 버젼을 알려준다(해당 파일수정시 자동 캐시해제)###
function file_version($filepath){
	
	if(file_exists($_SERVER['DOCUMENT_ROOT'].$filepath)){
		$return = $filepath."?v=".filemtime($_SERVER['DOCUMENT_ROOT'].$filepath);
	}else{
		$return = $filepath."?v=nofile";
	}
	return $return;

}


/*
---------------------------------------------------------------------------------------------------
	[배열을 글로벌 변수로 만드는 함수] ver.1.0.0
---------------------------------------------------------------------------------------------------
개발자 : 김호

설정 값이 register_globals off 일때 $_POST, $_GET, $_COOKIE,$_SESSION, $_FILES 등을 on 상태로 만든다.

*/
function params($_ver=NULL)
{

	if($_ver == NULL) {

		$params = array_merge($_POST, $_GET, $_COOKIE, $_FILES);

		foreach($params as $key => $value) {
			global ${$key};
			${$key} = $value;
		}

	} else {

		foreach($_ver as $key => $value) {
			global ${$key};
			${$key} = $value;
		}

	}

}




/*
---------------------------------------------------------------------------------------------------
	[프로그램 실행속도 측정하는 함수]
---------------------------------------------------------------------------------------------------
개발자 : 김호

$start_time = microtime(); //프로그램실행속도측정을 위해서 파일 최상단에 삽입.
$start = 시작시간 - 마이크로타임

*/
function TimeProcess($start,$out=FALSE)
{
  // 주어진 문자열을 나눔 (sec, msec으로 나누어짐)
  $start = explode(" ", $start);
  $end = explode(" ", microtime());

  $time['msec'] = $end[0] - $start[0];
  $time['sec']  = $end[1] - $start[1];

  if($time['msec'] < 0) {
    $time['msec'] = 1.0 + $time['msec'];
    $time['sec']--;
  }
	if($out == FALSE) {
	  printf("Access time: %.7f", $time['sec'] + $time['msec']);
	} else {
		return $time['sec'] + $time['msec'];
	}
}




/*
---------------------------------------------------------------------------------------------------
공용	[메세지 창 띄우기 함수]	 ver.1.0.0
---------------------------------------------------------------------------------------------------
개발자 : 김호

$msg = 보여줄 메세지
$goURL = 확인 버튼을 누르면 이동할 페이지 default = history.back();

*/
function PopupMsg($msg, $goURL="Back",$target="self")
{

	if(!strcmp($msg, "QUERY_ERROR")) {
    $err_no = mysql_errno();
    $err_msg = mysql_error();
    $error_msg = "ERROR CODE " . $err_no . " : " . $err_msg;
    $msg = addslashes($error_msg);
	}

	$act = $target.".location.href=\"$goURL\"";

  if($goURL == "Back") {
		$act = "history.back()";
	} elseif($goURL == "STOP") {
		unset($act);
	}

   echo <<<JAVASCRIPT
<script language="javascript">
   <!--
   alert("$msg");
   $act ;
   //-->
</script>
JAVASCRIPT;

}

/*
---------------------------------------------------------------------------------------------------
	[파일내용 불러오기 함수] ver.1.0.0
---------------------------------------------------------------------------------------------------
개발자 : 김호

$file_path = 디렉토리/파일 - 절대 경로

[수정]
2007-01-18 - 김호

파일과 디렉토리 변수를 각각 받았으나 절대 경로를 받는 것으로 수정.
*/
function ReadDocFile($file_path)
{
	if(file_exists($file_path) === TRUE) {

		$fd = fopen($file_path, "r");
		$content = fread ($fd, filesize($file_path));
		fclose ($fd);

	} else {

		$content = FALSE;

	}

  return $content;

}

/*
---------------------------------------------------------------------------------------------------
	[현재 디렉토리의 이름을 알아내는 함수] ver.0.9.0
---------------------------------------------------------------------------------------------------
개발자 : 김호
*/
function ThisDirName($DIR_NAME)
{	

	if(!$DIR_NAME){

		$FULL_path = dirname($_SERVER['PHP_SELF']);

		if(!strcmp($FULL_path,"/") ||!strcmp($FULL_path,"\\")) {
			$DIR_NAME = "Home"; // root 일때.
		} else {
			$DIR_path = explode("/", $FULL_path); //배열로저장
			$DIR_NAME = array_pop($DIR_path); // 배열 끝의 요소를 뽑아낸다.(즉, 현재 path name 다.)
		}

	}
	
	define("_DIR_NAME", "/".$DIR_NAME); // 메타 디스크립션

	return $DIR_NAME;
}

/*
---------------------------------------------------------------------------------------------------
	[디렉토리 생성 함수] ver.0.9.0
---------------------------------------------------------------------------------------------------
개발자 : 김호

$path = 만들고자 하는 디렉토리 절대경로.

*/

function MkmyDir($path)
{

	if(!is_dir($path)) { //디렉토리가 없을때

		$dirs = explode("/",$path); //디렉토리 경로를 배열로 만든다.

		### 디렉토리가 없으면 만든다.###
		foreach($dirs as $dir) {

			if($dir) {
				$check_dir .= "/".$dir;
				if(!is_dir($check_dir)) { //디렉토리가 없을때
					mkdir($check_dir, 0777);
					@chmod($check_dir, 0777); //디렉토리를 만들고 퍼미션을 쓰기가 가능하게 변경
				} else {
					@chmod($check_dir, 0777); //퍼미션을 쓰기가 가능하게 변경
				}

			}

		} //foreach end.

	}

}

/*
---------------------------------------------------------------------------------------------------
	[에러 파일 만들기 함수] ver.0.9.0  - 파일생성 함수 Makefile() 를 필요로 한다.
---------------------------------------------------------------------------------------------------
개발자 : 김호

$add_text = 기본 정보 외에 추가할 내용
$path_and_file = 경로/파일이름
$new_file = NULL 일때는 덮어씌운다. 동명 파일이 있을때 [0], [1] ... 으로 이름을 만든다.
$over_write = 1 기존 파일에 내용 추가.

*/

function MakeErrorFile($add_text=NULL,$path_and_file=NULL,$new_file=NULL,$over_write=1)
{

	if($path_and_file === NULL) {
		$path_and_file = SITE_LOG_PATH."/bugs/error".date("Ymd").".log";
	}

	$Input_content = "시간: ".date("Y-m-d H:i:s")."\nAGENT: ".$_SERVER['HTTP_USER_AGENT']."\n실행파일: ".$_SERVER['SCRIPT_FILENAME']."\n접근IP: ".$_SERVER['REMOTE_ADDR']."\n이전URL: ".$_SERVER['HTTP_REFERER']."\n실행URI: ".$_SERVER['REQUEST_URI']."\n".$add_text."\n";

	Makefile($path_and_file,$Input_content,$new_file,$over_write);

}


/*
---------------------------------------------------------------------------------------------------
	[파일 만들기 함수] ver.0.9.3  - 디렉토리 생성 함수 MkmyDir() 를 필요로 한다.
---------------------------------------------------------------------------------------------------
개발자 : 김호

$path_and_file = 경로/파일이름
$Input_content = 들어갈내용
$new_file = NULL 일때는 덮어씌운다. 동명 파일이 있을때 [0], [1] ... 으로 이름을 만든다.
$over_write = NULL 일때는 파일을 새로 만든다. 값이 들어오면 기존 파일에 내용 추가.

*/
function Makefile($path_and_file, $Input_content, $new_file=NULL, $over_write=NULL)
{

	@MkmyDir(dirname($path_and_file)); //디렉토리가 없으면 만든다.

	if($new_file != NULL) { //동명 파일이 있을때 [0], [1] ... 으로 이름을 만든다.
		$i = 0;

		while(file_exists($path_and_file)) {
			if($file_ext = 	array_pop(explode(".",$path_and_file))) { //파일 확장자를 추출 한다 확장자가 있을때만 "."을 붙인다.
				$file_ext = 	".".$file_ext;
			}

			$file_name = basename($path_and_file,$file_ext);

			if(eregi("[".$i."]", $file_name)) {
				$file_name = str_replace("[".$i."]","[".++$i."]",$file_name);
			} else {
				$file_name .= "[".$i."]";//경로명에서 확장자를 제외한 파일 이름을 반환
			}
			$path_and_file = dirname($path_and_file)."/".$file_name.$file_ext;
		}
	} elseif($over_write != NULL) {
		$Input_content = "\n".$Input_content;
		$fopen_mode = "a";
	} else {
		$fopen_mode = "w";
	}

  $fp = fopen($path_and_file, $fopen_mode);
  fwrite($fp, $Input_content);
  fclose($fp);
	return file_exists($path_and_file);
}

/*
---------------------------------------------------------------------------------------------------
	[ini 파일 만들기 함수] ver.1.0.0
---------------------------------------------------------------------------------------------------
개발자 : 김호

$ini_file_name = 경로/파일이름
$Input_ini_file_content = 들어갈내용 (문자열 or 배열)
$add // (FALSE=새로만들거나 덮어씌우기) , (TRUE=추가하기),
(key=같은 키값이 있으면 value를 대체 ) (value=같은 값이 key를 대체) - 단, Input_ini_file_content 배열로 들어와야 함

[변경]
2006.11.15 - 김호
- MkmyDir() 함수를 사용하여 디렉토리가 없으면 만들기
- $add 기존의 파일에 내용추가 하기
- $Input_ini_file_content 에 배열로 입력하기 추가

*/
function Makeini($ini_file_name, $Input_ini_file_content, $add=FALSE)
{

	@MkmyDir(dirname($ini_file_name)); //디렉토리가 없으면 만든다.

	if($add !== FALSE && file_exists($ini_file_name)) { //기존의 파일이 있을때 추가한다.

		$get_ini = parse_ini_file($ini_file_name);

		if($add == "key" && is_array($Input_ini_file_content)) { //key 값이 같은게 있으면 value를 대체 한다.

			foreach($Input_ini_file_content as $k => $v) $get_ini[$k] = $v;

			unset($Input_ini_file_content);

		} elseif($add == "value" && is_array($Input_ini_file_content)) { //value 값이 같은게 있으면 key를 대체 한다.

			foreach($Input_ini_file_content as $k => $v) { //단, 값이 같은 원소가 존재 하면 제일 앞에있는 원소만 교체 된다.

				$get_ini[$k] = $v; //새 원소를 입력

				if($my_key = array_search($v, $get_ini)) unset($get_ini[$my_key]); //찾은 원소를 삭제

			}

			unset($Input_ini_file_content);

		}

		foreach($get_ini as $k => $v) $ini_file_content .= $k." = \"".$v."\"\n";

	}

	if(is_array($Input_ini_file_content)) { //배열로 들어 왔을때 처리

		foreach($Input_ini_file_content as $k => $v) $ini_file_content .= $k." = \"".$v."\"\n";

		unset($Input_ini_file_content);
	}

	$content =<<<HTML
;<? /*

$ini_file_content
$Input_ini_file_content

;*/?>
HTML;

//화면보기주석<?

  $fp = fopen($ini_file_name, "w");
  fwrite($fp, $content);
  fclose($fp);
	return file_exists($ini_file_name);

}




### 모바일접근 체크###
function check_agent()
{

    /*CellPhone 이 kft 다*/
    /*
     * date 2011.01.06 목요일 17:19
     * name 고영왕
     * email star1610@nate.com
     * 
     * 아이패드에서 홈에 추가 눌렀을시 아이콘 표시를 위하여 ipad 배열 값 추가
     * 기존 - $OS = array('PSP', 'Symbian', 'Nokia', 'LGT', 'SKT', 'KTF', 'iPhone', 'CellPhone','PPC','Mobile');
     */
	$OS = array('PSP', 'Symbian', 'Nokia', 'LGT', 'SKT', 'KTF', 'iPhone', 'iPad', 'CellPhone','PPC','Mobile');

	foreach($OS as $val){

		### 존재한다면 
		/*
		 * date 2011.01.03 월요일 10:37
         * name 고영왕
         * email star1610@nate.com
         * 
         * win7 일경우 에이전트에서 AskTbUT2V5 값이 들어온다.
         * 그럼 $OS 배열변수의 값에서 'SKT'에 걸리면서 모바일로 체크가 되므로
         * windows로 들어오는 경우는 break 되게 설정했다.
		 */

		if ( preg_match("/Windows NT 6.1/i", $_SERVER['HTTP_USER_AGENT']) ){
			break;
		} elseif (preg_match("/".$val."/i", $_SERVER['HTTP_USER_AGENT'])){
			$this_mobile = $val;
			break;
		}

	}

	return $this_mobile;

}



/*
---------------------------------------------------------------------------------------------------
	[문자열 자르기 함수]	
---------------------------------------------------------------------------------------------------
개발자 : 김호

$str = 문자열
$len = 자를 문자열의 길이
$suffix = 자른후 붙이는 문자열 ex) ...

사용방법 kstrcut($subject, "30", "...") 

*/
function kstrcut($str, $len, $suffix = "") 
{
	if ($len >= strlen($str)) return $str;

	$klen = $len - 1;

	while(ord($str[$klen]) & 0x80) $klen--;

	return substr($str, 0, $len - (($len + $klen + 1) % 2)).$suffix;
}



### mid 암호화###
function mid_endcode($mid){
	
	return strrev(base64_encode(escape($mid)));

}

### mid 암호하풀기###
function mid_decode($mid){

	return unescape(base64_decode(strrev($mid)));

}



/*암호화 모듈*/
function toString($text){
 return iconv('UTF-16LE', 'UHC', chr(hexdec(substr($text[1], 2, 2))).chr(hexdec(substr($text[1], 0, 2))));
}

function toUnicode($word) {
 $word = iconv('UHC', 'UTF-16LE', $word);
 return strtoupper(sprintf('%02s',dechex(ord(substr($word,1,1)))).sprintf('%02s',dechex(ord(substr($word,0,1)))));
}

function unescape($text){
 return urldecode(preg_replace_callback('/%u([[:alnum:]]{4})/', 'toString', $text));
}



function escape($str) {
 $len = strlen($str);
 for($i=0,$s='';$i<$len;$i++) {
  $ck = substr($str,$i,1);
  $ascii = ord($ck);
  if($ascii > 127) $s .= '%u'.toUnicode(substr($str, $i++, 2));
  else $s .= (in_array($ascii, array(42, 43, 45, 46, 47, 64, 95))) ? $ck : '%'.strtoupper(dechex($ascii));
 }
 return $s;
}



/*
 * date 2011.04.01 금요일 14:30
 * name 고영왕
 * ywko@hu.co.kr
 * 
 * 시간차이 구하는 함수
 * 앱 라이브에서 사용한다.
 */
function datetimediff($rtime, $ctime = null, $option = null){
      if ($ctime) $cur_time = strtotime($ctime);
      else $cur_time = time();
      $ref_time = strtotime($rtime);

      $cur_date = floor($cur_time / 86400);
      $ref_date = floor($ref_time / 86400);

      $datetimediff = $cur_time - $ref_time;
      $datedist = $cur_date - $ref_date;
      $datediff = floor($datetimediff / 86400);
      $weekdiff = floor($datediff / 7);
      $timediff = $datetimediff % 86400;

      $hour = floor($timediff / 3600);
      $min = floor($timediff % 3600 / 60);
      $sec = floor($timediff % 3600 % 60);

      $result = "";
      if ($datedist>34) {
            $result = date("Y년 n월 j일", $ref_time);
      } else if ($weekdiff>0) {
            $result = $weekdiff . "주 전";
      } else {
            if ($datediff>0) {
                  $result = $datedist . "일 전";
            } else if ($timediff<=0) {
                  $result = "1초 전";
            } else {
                  if ($hour) $result = $hour . "시간";
                  else if ($min) $result = $min . "분";
                  else $result = $sec . "초";
                  if ($result) $result .= " 전";
            }
      }
      if ($option=='ALL') {
            $result = "";
            if ($datediff) $result .= ($result?" ":"") . $datediff."일";
            if ($hour) $result .= ($result?" ":"") . $hour."시간";
            if ($min) $result .= ($result?" ":"") . $min ."분";
            if ($sec) $result .= ($result?" ":"") . $sec . "초";
            $result .= " 전";
      }
      return $result;
}



### 리플 테이블번호 자동생성 나눔 번호###
function reply_table_division($bname = ""){

	$reply_table_division_no = 1000; //기본 1000개로 나눈다

	$reply_table_division_no_bname['attendance'] = 1000000; //출석체크
	$reply_table_division_no_bname['sign_greeting'] = 1000000; //출석체크



	### 게시판마다 별도 나눔 번호 지정###
	if($bname){

		if($reply_table_division_no_bname[$bname])$reply_table_division_no = $reply_table_division_no_bname[$bname];

	}

	return $reply_table_division_no;

}




function new_curlFileUpload($uploadFile, $remote_url, $upload_path=NULL, $rename=NULL)
{

	//$postData['upfile'] = "@".$_FILES[$uploadFile]['tmp_name'];
	 $postData['upfile'] = new CURLFile($_FILES[$uploadFile]['tmp_name']);


	if(NULL != $upload_path) $postData['save_path']= $upload_path;

	if(NULL != $rename) $postData['save_file']= $rename;

	$ch = curl_init(); //세션초기화

	curl_setopt($ch, CURLOPT_URL, $remote_url);

	curl_setopt($ch, CURLOPT_POST, true);

	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

	curl_exec($ch);//실행

	$result = curl_getinfo($ch);

	curl_close($ch); //닫기
	
	if($result[0] == "notfile"){
		PopupMsg("죄송합니다. 해당 파일은 업로드 할 수 없는 파일 입니다.");
	}


	return $result[0];

}

### sns 발송###
function sns($receive_num, $message, $type){

	### 문자발송###
	$annex_url = "http://sms.annexlab.com/smssendv10.asp";
	$v1 = 'gameangel';  // 에넥스 아이디
	$v2 = 'sms10040401';// 에넥스 비밀번호
	$v3 = '15445874';   // 발송 번호

	$url= $annex_url."?v1=".$v1."&v2=".$v2."&v3=".$v3."&v4=".$receive_num."&v5=".urlencode($message)."&v6=0&v7=0";


	global $SQL;

	if(!$SQL){
		$SQL = new Mysql;
		$db_close = true;
	}

	
	$SQL->Query("INSERT INTO `daily_log`.`sns_log` (`data`, `type`, `reg_datetime`) VALUES ('".$url."', '".$type."', '".date("Y-m-d H:i:s")."');");

	if($db_close)mysql_close();

	### 문자발송을 db에 저장한다(용도 파악) 2013-12-03 권오용###


	$send_result = fsockopen_content($url);


}

function fsockopen_content($url,$time="30"){

	$info = parse_url($url);
	$host = $info['host'];
	$port = $info['port'];
	if ( empty($port) ) $port = 80;

	$path = $info['path'];
	if ( !empty($info['query']) ) $path.= '?'.$info['query'];

	$out = "GET {$path} HTTP/1.0\r\nHost: {$host}\r\n\r\n";

	$fp = fsockopen($host, $port, $errno, $errstr, $time);
	if ( !$fp ) {

		echo $errstr.' ('.$errno.') <br />'."\n";

	} else {
		
		fputs($fp, $out);
		$start = false;
		$ret_val = '';
		
		while ( !feof($fp) ) {
			
			$tmp = fgets($fp, 5120);
			if ( $start ) $ret_val .= $tmp;
			if ( "\r\n" == $tmp ) $start = true;
		}
		
		fclose($fp);
		
		return $ret_val;
	}
}

function agent_get_content($url, $timeout = 5) { 
    $agent = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 5.1; Trident/4.0; GTB6.6; .NET CLR 2.0.50727; InfoPath.2; .NET CLR 3.0.4506.2152; .NET CLR 3.5.30729)'; 
    $curlsession = curl_init (); 
    curl_setopt ($curlsession, CURLOPT_URL,             $url); 
    curl_setopt ($curlsession, CURLOPT_HEADER,          0); 
    curl_setopt ($curlsession, CURLOPT_RETURNTRANSFER,  1); 
    curl_setopt ($curlsession, CURLOPT_POST,            0); 
    curl_setopt ($curlsession, CURLOPT_USERAGENT,       $agent); 
    curl_setopt ($curlsession, CURLOPT_REFERER,         ""); 
    curl_setopt ($curlsession, CURLOPT_TIMEOUT,         $timeout); 

    $buffer = curl_exec ($curlsession); 
    $cinfo = curl_getinfo($curlsession); 
    curl_close($curlsession); 

    if ($cinfo['http_code'] != 200) 
    { 
        return ""; 
    } 

    return $buffer; 
}



?>
