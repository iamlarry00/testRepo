<?php
/*
---------------------------------------------------------------------------------------------------
Program NAME : HOYA PHP Framework 2
Content : 레이아웃 관련 함수
Version : 1.0
File Name : function_layout.inc.php
Charset : euc-kr
Directory : /System/lib
URI :
---------------------------------------------------------------------------------------------------
[개발자정보]

개발자 : 김호
개발일 : 2007.10.04
email: webmaster@hodragon.com
msn: webmaster@hodragon.com
homepage: www.hodragon.com
support : www.hoyaboard.com
---------------------------------------------------------------------------------------------------
[함수 리스트]

IncludeHead($ini_file,$type="css") : css,js 파일 첨부하기 함수
PageLoadding($position="middle",$h="100%",$w="100%") : 화면열기전에 로딩 보여주는 함수

*/

/*
---------------------------------------------------------------------------------------------------
	[화면 로딩 보여주기] ver.0.9.0
---------------------------------------------------------------------------------------------------
개발자 : 김호

출력할 페이지 앞에 사용하면 됩니다.
$position = "absolute"
PageLoadding("absolute"); //상단

if($proc_ini_info['loadding'] == 1) PageLoadding(); //페이지로딩 보여주기
*/
function PageLoadding($s=0,$position="middle",$h="100%",$w="100%")
{
	$domain =  IMG_SERVER;

	if($position == "middle") {
		$style = "document.all['loadingHidden'].style.position = \"absolute\""; 
	} 
	echo <<<HTML
<script type="text/javascript">
<!--
    document.onreadystatechange = fnStartInit;
function fnStartInit()
{
	if(document.readyState=="complete") {
		if (document.all['loadingHidden']) { 
			document.all['loadingHidden'].style.visibility = "hidden";
			$style			
		}
	}
}
/ -->
</script>

<div id="loadingHidden" style="position:$position; overflow:hidden; left:expression((document.body.clientWidth-200)/2);	height:$h; border:0px; z-index:1;">
<table width="$w" height="$h"  border="0" cellpadding="0" cellspacing="0">
	<tr>
    <td align="center" valign="middle">
		<img src="${domain}/images/img_loading.gif">		
		</td>
	</tr>
</table>
</div>

HTML;

	flush();

	sleep($s);

}

/*
---------------------------------------------------------------------------------------------------
	[css,js 파일 첨부하기 함수] ver.0.9.0
---------------------------------------------------------------------------------------------------
개발자 : 김호

*/
function IncludeHead($ini_file,$type="css")
{

	### 버젼###

	if(file_exists($ini_file)) {
		
		$attach_array =  parse_ini_file($ini_file); //설정 파일을 가져온다.

		### css 첨부파일 설정 ###
		if($type == "css") {

			foreach($attach_array as $v){

				$version = "?v=".$FileMtime = filemtime(SITE_PUB_PATH.SITE_CSS_PATH."/".$v); 

				$HTML .="<link type=\"text/css\" rel=\"stylesheet\" href=\"".SITE_CSS_PATH."/".$v.$version."\" />\n";

			}

		### css핵파일 설정###
		} elseif($type == "hack_css") { 

			foreach($attach_array as $v){

				$version = "?v=".$FileMtime = filemtime(SITE_PUB_PATH.SITE_CSS_PATH."/".$v); 

				$HTML .="<!--[if lte IE 6]>\n";
				$HTML .="<link type=\"text/css\" rel=\"stylesheet\" href=\"".SITE_CSS_PATH."/".$v.$version."\" />\n";
				$HTML .="<![endif]-->\n";
			}

		
		### js 첨부파일 설정 ###
		} elseif($type == "js") { 

			foreach($attach_array as $v){
			
				$version = "?v=".$FileMtime = filemtime(SITE_PUB_PATH.SITE_JS_PATH."/".$v); 
				$HTML .="<script type=\"text/javascript\" src=\"".SITE_JS_PATH."/".$v.$version."\"></script>\n";

			}

		}

		return $HTML;

	}
	
}



/*
---------------------------------------------------------------------------------------------------
	[메타테그 설정]
---------------------------------------------------------------------------------------------------
*/
function metaPrint() {
	
	global $proc_ini_info, $keywords, $description;

	($proc_ini_info['keywords'] == NULL) ? $keywords =SITE_KEYWORDS : $keywords = $proc_ini_info['keywords']; //META keyword 설정

	($proc_ini_info['description'] == NULL) ? $description = SITE_DESCRIPTION : $description = $proc_ini_info['description']; //META description 설정

}

?>
