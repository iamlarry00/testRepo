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

기본 레이아웃
해당 스킨을 보여주며 해당(해더,센터,레프트,푸터) 부분 데이타를 호출한다
*/



echo <<<TAG
<!doctype html>
<!--[if IE 7 ]><html class="ie7 ie"><![endif]-->
<!--[if IE 8 ]><html class="ie8 ie"><![endif]-->
<!--[if IE 9 ]><html class="ie9 ie"><![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="ko"><!--<![endif]-->
<head>
	<meta charset="euc-kr">
	<meta http-equiv="Content-Script-Type" content="text/javascript">
	<meta http-equiv="Content-Style-Type" content="text/css">
	<meta http-equiv="X-UA-Compatible" content="chrome=1,IE=Edge">

	<meta name="format-detection" content="telephone=no">
	<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0">
	<meta name="author" content="YJH">
	<meta name="copyright" content="www.daily.co.kr">
	<meta name="keywords" content="">
	<meta name="description" content="">
	
	<title>$site_title</title>
	
	<link rel="stylesheet" href="/System/html/css/daily_style.css" media="all"> 
	
	<!--[if lt IE 9]>
		<script type="text/javascript" src="/System/html/js/respond.min.js"></script>
		<script type="text/javascript" src="/System/html/js/html5.js"></script>
	<![endif]-->
</head>
<body>


<div id="wrap">



TAG;

/*
echo SITE_HEAD_PATH."/".$proc_ini_info['head']."<br>";//상단
echo SITE_LEFT_PATH."/".$proc_ini_info['left']."<br>";//상단
echo SITE_CENTER_PATH."/".$proc_ini_info['center']."<br>";//상단
*/

if($proc_ini_info['head'])include SITE_HEAD_PATH."/".$proc_ini_info['head'];//상단
if($proc_ini_info['left'])include SITE_LEFT_PATH."/".$proc_ini_info['left'];//촤측단
if($proc_ini_info['center'])include SITE_CENTER_PATH."/".$proc_ini_info['center'];//중앙




### 해당 프로세스 호출###
if(file_exists($skin_file)) { 
	include $skin_file;
}




if($proc_ini_info['right'])include SITE_RIGHT_PATH."/".$proc_ini_info['right'];//우측
if($proc_ini_info['foot'])include SITE_FOOT_PATH."/".$proc_ini_info['foot'];//하단





echo <<<TAG

</div>

$HTML_js


<script type="text/javascript">
<!--
/*자동실행*/


document.write('<iframe name="proc" id="proc" width="0" height="0" marginheight="0" marginwidth="0" scrolling="no" frameborder="0"></iframe>');

/*먼저 실행되야 하는 스크립트*/
$footer_js_first

$footer_js

/*마지막에 실행되야 하는 스크립트*/
$footer_js_last


/*기울기변화 감지하기
window.onorientationchange = function() {
  alert(window.orientation); 
}
*/






//-->
</script>

<!--로그스크립트-->


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-43778793-1', 'daily.co.kr');
  ga('send', 'pageview');

</script>

<!--로그스크립트-->






</body>
</html>
TAG;








?>
