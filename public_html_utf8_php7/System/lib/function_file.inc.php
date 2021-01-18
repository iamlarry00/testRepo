<?php




/*
---------------------------------------------------------------------------------------------------
	[썸네일 만드는 함수]
---------------------------------------------------------------------------------------------------
개발자 : 김호

사용방법:
$file : 원본이미지 파일(디렉토리/파일명)
$save_filename : 저장할 파일명
$save_path : 저장할 경로
$max_width : 만들이미지의 width 값
$max_height : 만들이미지의 height 값
$jpeg_quality : jpeg 이미지 퀄리티 조정
$option : 가로비율에 맞출때는 NULL, 꽉 채우기 : TURE

예)
원본이미지 : width:1000, height : 500 이고
만들이미지 : width:500, height : 500 인경우

원본이미지의 width 값은 500 이 되구 비율로 height 값은 250이 됩니다

만들이미지의 크기는 500*500 인제 height 값이 250 이기때문에 이것이 상위 정렬되는 것을 방지하기위해 250/2 해서 Y 좌표에 뿌려줍니당
결국 500*500 이미지의 가운데에 이미지가 뿌려집니다. 백그라운드 이미지를 변경하고 싶으면 ImageColorAllocated의 RGB 만 건드리면 됨.

---------------------------------------------------------------------------------------------------
*/

function thumnail($file, $save_filename, $save_path, $max_width, $max_height, $jpeg_quality=90, $option=NULL)
{
	if(substr($save_path, -1) != "/") $save_path .="/";

	$img_info = getimagesize($file);

  if($img_info[2] == 1) {

		$src_img = @ImageCreateFromGif($file);

	} elseif($img_info[2] == 2) {

		$src_img = @ImageCreateFromJPEG($file);

	} elseif($img_info[2] == 3) {

		$src_img = @ImageCreateFromPNG($file);

	} else {

		return FALSE;

	}

	$dst_width = $img_info[0];
	$dst_height = $img_info[1];

	while($dst_width > $max_width || $dst_height > $max_height) {

		if($dst_width > $max_width) {
			$temp = $dst_width;
			$dst_width = $max_width;
			$dst_height = ceil(($max_width / $temp) * $dst_height);
		}

		if($dst_height > $max_height) {
			$temp = $dst_height;
			$dst_height = $max_height;
			$dst_width = ceil(($max_height / $temp) * $dst_width);
		}

	}

	if($option == NULL) {

		if($dst_width < $max_width) $srcx = ceil(($max_width - $dst_width)/2); else $srcx = 0;
		if($dst_height < $max_height) $srcy = ceil(($max_height - $dst_height)/2); else $srcy = 0;

	} else {

		$srcx = 0;
		$srcy = 0;
		$dst_height = $max_height;
		$dst_width = $max_width;

	}

	if($img_info[2] == 1) {

		$dst_img = imagecreate($max_width, $max_height);

	} else {

		$dst_img = imagecreatetruecolor($max_width, $max_height);

	}

	$bgc = ImageColorAllocate($dst_img, 255, 255, 255);
	ImageFilledRectangle($dst_img, 0, 0, $max_width, $max_height, $bgc);
	ImageCopyResampled($dst_img, $src_img, $srcx, $srcy, 0, 0, $dst_width, $dst_height, ImageSX($src_img),ImageSY($src_img));

	if($img_info[2] == 1) {

		ImageInterlace($dst_img);
		ImageGif($dst_img, $save_path.$save_filename);

	} elseif($img_info[2] == 2) {

		ImageInterlace($dst_img);
		ImageJPEG($dst_img, $save_path.$save_filename, $jpeg_quality);

	} elseif($img_info[2] == 3) {

		ImagePNG($dst_img, $save_path.$save_filename);

	}

	ImageDestroy($dst_img);
	ImageDestroy($src_img);

}



/*
---------------------------------------------------------------------------------------------------
Program NAME : HOYA PHP Framework 2
Content : 파일 전송 관련 함수 모음
Version : 1.0
File Name : function_file.inc.php
Charset : euc-kr
Directory : /System/lib
URI : 
---------------------------------------------------------------------------------------------------
[개발자정보]

개발자 : 김호
개발일 : 2008.08.08
email: webmaster@hodragon.com
msn: webmaster@hodragon.com
homepage: www.hodragon.com
support : www.hoyaboard.com
---------------------------------------------------------------------------------------------------
[함수 리스트]

Download() - 파일 다운로드 함수
FileUpLoad() - 파일 업로드 함수

ThisFile() - 소켓접속을 이용해 파일이 존재 하는지 알아보는 함수


*/

/*
---------------------------------------------------------------------------------------------------
	[파일 다운로드 함수]
---------------------------------------------------------------------------------------------------
개발자 : 김호

$path = 받을 경로
$fname = 실제 존재하는 파일 이름
$filename = 실제 저장할 파일 이름
$file_extension = 확장자

*/
function Download($path, $fname, $filename, $file_extension=NULL) 
{

	$download_file = $path."/".$fname; //실제 받을 파일 경로/파일명

	if(!is_file($download_file)) {//파일이 존재하지 않을때
		PopupMsg("해당 파일이나 경로가 존재하지 않습니다!","STOP");
	  exit;
	}

	### 실제 받는 파일 이름 만들기 ###
	if($file_extension !== NULL) {
		$filename .=  ".".$file_extension; //들어온 확장자를 붙인다.
	} else {
		$file_extension = strtolower(substr(strrchr($filename,"."),1)); //확장자를 구한다.
	}
	$len = filesize($download_file); //파일크기

	### 확장자에 따른 다운로드 처리 ###
	switch( $file_extension ) {
		case "exe": $ctype="application/octet-stream"; break;
		case "zip": $ctype="application/zip"; break;
		case "ZIP": $ctype="application/zip"; break;
		//case "mp3": $ctype="audio/mpeg"; break;
		case "mpg":$ctype="video/mpeg"; break;
		case "avi": $ctype="video/x-msvideo"; break;
	  ### 다운로드 불가 파일 ###
		case "php":
		case "htm":
		case "html":
		case "ini":
		case "inc":
		/*case "txt": die("<b>Cannot be used for ". $file_extension ." files!</b>"); break;*/
		default: $ctype="file/unknown";		
	}
	
	//해더부분 시작
	header("Content-Type: $ctype");
	header("Content-Disposition:attachment;filename=".$filename);
	header("Content-Transfer-Encoding: binary");
	header("Content-Length: ".filesize($download_file));
	header("Pragma: no-cache");
	header("Expires: 0");
	header("Cache-Control: private");
	header("Content-Description: File Transfer");
	header("Connection: close"); 
	
	$fp = fopen($download_file, "rb"); // 파일을 연다.
	if (!fpassthru($fp)) fclose($fp); 
	clearstatcache();

	fclose($fp); 
}





/*
권오용 팀장
2011-01-18
해당 파일에 스크립트및 php 사용여부 체크 해당 코드가 삽입되어있을시 false 리턴한다

업로드 파일시 if(hackingfilecheck($_FILES['변수명']['tmp_name']) == false){ 이렇게 하면된다

*/
function hackingfilecheck($dir_filename){
	

	### 검색할 단어###
	$hacking_data = array("<?php","function_exists","<script","$_POST","$_GET","session","cookie","$_SERVER","phpinfo","file_exists","<form","include","include","require","extract");


	$fd = fopen($dir_filename, "r");
	$content = fread ($fd, filesize($dir_filename));

	
	foreach($hacking_data as $k => $v){
		
		$pos = strripos($content, $v);
		if ($pos !== false) {
			
			return false;

		}

	}

	fclose ($fd);
	return $content;

}






/*
---------------------------------------------------------------------------------------------------
	[파일 업로드 함수] ver.1.0.3 - PopupMsg() 함수를 필요로 한다.
---------------------------------------------------------------------------------------------------
개발자 : 김호

$sendfile = input name로 받은 파일 
$save_dir = 저장할 디렉토리
$ext = 허용하는 확장자 - 사용하지 않는 경우엔 값을 넣지 않는다.
$ext_hidden = 확장자 숨기기 - "on"을 넣으면 사용
$save_fname = 저장할 파일명

[사용방법]

list($filename,$dir) = FileUpLoad($sendfile, $save_dir, $ext, "on")// $save_fname, $save_dir결과 받기

[변경]

2006.04.19 / 김호 
- 업로드 디렉토리가 없으면 생성 한다.


*/

function FileUpLoad($sendfile, $save_dir, $ext="", $ext_hidden="", $exc_not="", $save_fname="", $overlap="")
{

	if(substr($save_dir, -1) != "/") $save_dir .="/"; // 절대 경로로 '/' 부터 시작해야 한다.

	$filename = explode(".", $_FILES[$sendfile]['name']);
	$extension = $filename[count($filename)-1];

	$extension_low = strtolower($extension); //파일 확장자 비교를 위해 확장자를 소문자로...

	if(!$exc_not) $exc_not="php,php3,html,htm,asp,jsp";
	$exc_list= explode(",", $exc_not);
	if(in_array($extension_low,$exc_list)) {
		PopupMsg("죄송합니다. 해당 파일은 업로드 할 수 없는 파일 입니다.");
		exit;
	}

	if($ext) { //업로드 가능 확장자 검색이 들어왔을때만.
		$list = explode(",", $ext);
		if($ext && !in_array($extension_low,$list)) {
			PopupMsg("확장자가 '$ext'인 파일만 올릴 수 있습니다. 파일을 확인해 주세요.");
			exit;
		}
	}

	if(!$ext_hidden) { //확장자 제거후 업로드, 다운 받을때 확장자를 붙이는 방식을 사용할때 입력한다.
		$temp_fname = md5(time()).".".$extension;
	} else { //일반 업로드
		$temp_fname = md5(time());
	}
	if(!$save_fname) $save_fname = "ohing_board_".$temp_fname;//임시 저장파일 이름

	### 디렉토리가 없으면 만든다. ###
	if(!is_dir($save_dir)) { //디렉토리가 없을때

		MkmyDir($save_dir);

		if(!is_dir($save_dir)) {

			PopupMsg("업로드할 디렉토리를 만들 수  없습니다. 관리자에게 문의 바랍니다.");

			exit;

		}

	}

	$dest = $save_dir.$save_fname;// 업로드한 파일을 저장할 디렉토리와 저장할 화일이름 설정

	while(file_exists($dest)) { //같은 이름의 파일이 있는지 확인	한다.
		if($overlap){
			@unlink($dest);
		}else{
			$i++;
			$dest = $save_dir.$save_fname."[".$i."]";//임시 저장파일 이름
		}
	}


	if(hackingfilecheck($_FILES[$sendfile]['tmp_name']) == false){
		PopupMsg("해당 파일은 업로드 하실 수 없습니다.");
		exit;
	}

	// 파일을 지정한 디렉토리에 저장
	if(!move_uploaded_file($_FILES[$sendfile]['tmp_name'],$dest)) {
		PopupMsg("$dest 파일을 올릴 수  없습니다. 관리자에게 문의 바랍니다.");
		exit;
	}
	@chmod($dest, 0644); //서버를 옮긴 후 업로드 파일의 퍼미션이 600으로 되는 문제가 생겼다.  ㅡㅡ;

	return array($save_fname, $dest); //저장한 파일 이름($save_fname), 파일의 실제올라간 $dest(디렉토리/파일명)

}

/*
---------------------------------------------------------------------------------------------------
	[파일이 존재 하는지 알아보는 함수] var.1.0.0
---------------------------------------------------------------------------------------------------
개발자 : 김호

$getserver  - 서버 호스트 이름 ip주소나, 
$host         -  'http://' 를 제외한 도메인 ex) .abc.com
$thisfile_url -  도메인을 제외한 파일 경로로 이용하고자 하는 변수 값은 GET 으로 보낸다.

ex) ThisFile(PDS_SERVER, HOYA_COOKIE_DOMAIN, $open_url)
*/

function ThisFile($getserver, $host, $thisfile_url, $file_type="file") 
{

	if($file_type == "file") { //찾고자 하는 URL이 파일일 경우에 확인 : 기본값.
		if(!array_pop(explode("/",$thisfile_url))) {
			return FALSE;
		}
	}

	$getserver = str_replace("http://","",$getserver);

	if($fp = fsockopen($getserver, 80, $errno, $errstr, 30)) {
		fputs($fp, "GET $thisfile_url HTTP/1.0\r\nHost: ".$host."\r\n\r\n");
		$var = fgets($fp, 1024)."<BR>";
		fclose($fp);
		clearstatcache();
	}

	if($var && eregi("404",	$var)) { //파일 없음
		return FALSE;
	} else { //파일 있음
		return TRUE;
	}

}




### 외부이미지를 다운로드할수 있다###
function img_download($img_url, $tmppath, $img_name = ""){

	//$img_url = 'http://phpschool.com/images/top_logo.gif'; 

	if(!$img_name)$img_name = basename($img_url); 
    $ch = curl_init(); 
    curl_setopt($ch, CURLOPT_URL, $img_url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); 
    $content = curl_exec ($ch); 
    //$fh = fopen("./data/temp/".$img_name, 'w'); 
	$fh = fopen($tmppath.$img_name, 'w'); 
    fwrite($fh, $content); 
    fclose($fh); 
    curl_close($ch); 

}






?>
