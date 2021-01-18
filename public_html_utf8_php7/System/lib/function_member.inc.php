<?
if(!class_exists("Mysql")){//키티클래스가 필요하다
	include_once SITE_LIB_PATH.'/function_db.inc.php';
}


/*
2009-10-12
권오용


[일반회원]
ob_user[mid] - 회원번호
ob_user[id] - 회원아이디
ob_user[name] - 회원이름
ob_user[nick] - 회원닉네임
ob_user[level] - 회원레빌


[관리자]
ob_admin[aid] - 회원번호
ob_admin[id] - 회원아이디
ob_admin[level] - 회원레벨


*/




### 관리자 로그인 세션 생성###
function admin_login($aid,$id,$level){
	

	
	admin_logout('N');

	// 세션을 생성한다.
	session_start();


	$_SESSION['ob_admin']['aid'] = $aid;
	$_SESSION['ob_admin']['id'] = $id;
	$_SESSION['ob_admin']['level'] = $level;

	$cookie_domain = '.appstory.co.kr';


	setcookie("admin[id]",$id ,0,"/", $cookie_domain);
	

	/*접속로그*/
	$join_msg = "aid:".$aid."\n";
	$join_msg .= "id:".$id."\n";
	$join_msg .= "level:".$level."\n";

	$join_file_name = LOG_PATH."/adminjoin/join".date("Ymd")."/join".date("YmdH").".log";
	
	@MakeErrorFile($join_msg, $join_file_name);



}



### 관리자 로그인 세션 생성###
function admin_logout($state=""){
	

	/*로그*/

	$join_msg = "aid:".$_SESSION['ob_admin']['aid']."\n";
	$join_msg .= "id:".$_SESSION['ob_admin']['id']."\n";
	$join_msg .= "level:".$_SESSION['ob_admin']['level']."\n";

	$join_file_name = LOG_PATH."/adminjoin/out".date("Ymd")."/out".date("YmdH").".log";
	
	if(!$state){
		@MakeErrorFile($join_msg, $join_file_name);
	}




session_unset(); // 모든 세션변수를 언레지스터 시켜줌 
session_destroy(); // 세션해제함 


setcookie("admin[id]", "" ,0,"/", ".appstory.co.kr");





}


### 접근 레벨체크###
function permission(){

global $board_info, $process;

$info_key = $process."_level";

$this_admins = array();

if($board_info[admins]){

	$this_admins = explode("," , $board_info[admins]);

}

/*if ( $_COOKIE[user][id] == "star1616" ) {
	echo $info_key;exit;
}*/

if($_COOKIE[user][level] > $board_info[$info_key] && !in_array($_COOKIE[user][id],$this_admins)){
	
	if($_COOKIE[user][level] == "Z"){

	$back_goURL = urlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"]);


	if($_COOKIE[user][company_name]){//기업회원의경우 심의전 Z 권한을 가지고 있다


	if($board_info[bname] != "mypage" || $_GET['p'] != "memo" || $_GET['type'] != "receive_list"){//받은 쪽지함은 열어준다


	echo <<<JS
				
			<script type="text/javascript">
			<!--
				alert('기업 회원은 승인 후 이용 가능합니다.');history.back();
			//-->
			</script>

JS;
exit;

	}


	}else{


	echo <<<JS
				
			<script type="text/javascript">
			<!--
				alert('로그인 후 이용해 주세요.');location.href = '/login/?goURL=$back_goURL';
			//-->
			</script>

JS;
exit;

	}

	}else{

	echo <<<JS
				
			<script type="text/javascript">
			<!--
				alert('권한이 부족합니다!.');history.back();
			//-->
			</script>

JS;
exit;

	}

}


}


### 접근 레벨체크###
function link_permission($process, $link){

	global $board_info;

	$info_key = $process."_level";


	$go_url = $link;


	$this_admins = array();

	if($board_info[admins]){

		$this_admins = explode("," , $board_info[admins]);

	}

	
	if($_COOKIE[user][level] > $board_info[$info_key] && !in_array($_COOKIE[user][id],$this_admins)){

		if($board_info[$info_key] == "0")	{
			return;
		}else{

			if($_COOKIE[user][level] == "Z"){

				$back_goURL = urlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"]);

				if($_COOKIE[user][company_name]){//기업회원의경우 심의전 Z 권한을 가지고 있다

					$go_url = "javascript:alert('기업 회원은 승인 후 이용 가능합니다.');";

				}else{

					$go_url = "javascript:alert('로그인 후 이용해 주세요.');location.href = 'http://www.appstory.co.kr/login/?goURL=$back_goURL';";
				
				}

			}else{

				$go_url = "javascript:alert('권한이 부족합니다!!.');";

			}
		}

	}


	return $go_url;

}



function member_point_level($point, $type="", $option=""){
	
	$level_point[1] = 0;
	$level_point[2] = 1000;
	$level_point[3] = 2000;
	$level_point[4] = 3000;
	$level_point[5] = 4000;
	$level_point[6] = 5000;
	$level_point[7] = 7000;
	$level_point[8] = 10000;
	$level_point[9] = 15000;
	$level_point[10] = 20000;

	if($type == "next_level_point"){//다음레벨 포인트

		if(!$option)return;
		
		$option++;

		return $level_point[$option];


	}else{//포인에 따른 레벨

	if($point >= $level_point[1])$level = "1";
	if($point >= $level_point[2])$level = "2";
	if($point >= $level_point[3])$level = "3";
	if($point >= $level_point[4])$level = "4";
	if($point >= $level_point[5])$level = "5";
	if($point >= $level_point[6])$level = "6";
	if($point >= $level_point[7])$level = "7";
	if($point >= $level_point[8])$level = "8";
	if($point >= $level_point[9])$level = "9";
	if($point >= $level_point[10])$level = "10";

	return $level;

	}

}


### 포인트 부여###
function point_add($point,$mid,$cid="", $bname="", $bid="", $log_msg="", $log_code=""){

	global $board_info;

	$SQL = new Mysql;

	### 100점 넘어도 등록해준다###
	### 리뷰 if문 현재주석은 수정하거나 삭제하면 안된다 차후 리뷰추가시 현재주석으로 추가될파일들을 찾아야한다 2010-12-10 권팀###
	$point100_allow_bname = array("iphone_apps_review@board_write","wphone_apps_review@board_write","aphone_apps_review@board_write","sphone_apps_review@board_write","ephone_apps_review@board_write","ipad_apps_review@board_write","galaxytab_apps_review@board_write");

	### 하루 등록 점수는 100점까지만 가능###
	if($point > 0){//플러스 점수일때

		$point100_value = $bname."@".$log_code;

		### 유저리뷰 등록, 추천은 100점 넘어도 허가###
		if(in_array($point100_value, $point100_allow_bname) || $log_code == "board_recom") {// 유저리뷰등록에선 제외

		}else{
		

			$today_add_point = $SQL->OneValue("SELECT SUM(`point`) FROM `appstory_log`.`point_log".date("Ym")."` WHERE `mid`='".$mid."' AND `reg_date`='".date("Y-m-d")."' ");//오늘 등록된 포인트 점수
		
			if($today_add_point >= 100)return;

			if($today_add_point+$point > 100){
				
				$point = 100-$today_add_point;//넣을수있는 포인트

			}

		}
	}

	list($my_max_point, $my_point_level) = $SQL->MySelect("SELECT `point`,`point_level` FROM `appstory`.`member_info` WHERE `mid`='".$mid."'");//현재 나의 점수
			
	$add_max_point = $my_max_point+$point;

	$point_level_data = member_point_level($add_max_point);
	
	### 포인트 레벨 업###
	if($point_level_data != $my_point_level){
		
		$SQL->Query("UPDATE `appstory`.`member_info` SET `point_level`='".$point_level_data."' WHERE `mid`='".$mid."'");

	}

	$SQL->Query("INSERT INTO `appstory`.`point_log` (
`mid` ,
`point` ,
`max_point` ,
`cid` ,
`bname` ,
`bid` ,
`log_code`, 
`log_msg` ,
`reg_date` ,
`reg_time` 
)
VALUES (
'".$mid."', '".$point."', '".$add_max_point."','".$cid."', '".$bname."', '".$bid."', '".$log_code."','".$log_msg."', now(), now()
);");


	$SQL->Query("UPDATE `appstory`.`member_info` SET `point`='".$add_max_point."' WHERE  `mid`='".$mid."'");//현재 나의 점수 등록

	### 세분화하여 로그를 하나더 생성한다###

	### 해당 테이블 존재유무체크###
	$db_check_result = $SQL->Query("CHECK TABLE `appstory_log`.`point_log".date("Ym")."`");
	$db_check_row = mysql_fetch_array($db_check_result);

	if($db_check_row['Msg_text']!="OK"){
	
	$SQL->Query("
	CREATE TABLE IF NOT EXISTS `appstory_log`.`point_log".date("Ym")."` (
  `lid` int(11) NOT NULL auto_increment,
  `mid` int(11) NOT NULL,
  `point` smallint(5) NOT NULL,
  `max_point` bigint(20) NOT NULL,
  `cid` int(11) NOT NULL,
  `bname` varchar(20) NOT NULL,
  `bid` int(11) NOT NULL,
  `log_code` varchar(15) NOT NULL,
  `log_msg` varchar(50) NOT NULL,
  `reg_date` date NOT NULL,
  `reg_time` time NOT NULL,
  PRIMARY KEY  (`lid`),
  KEY `mid` (`mid`,`bname`,`bid`,`reg_date`),
  KEY `log_code` (`log_code`)
) ENGINE=MyISAM  DEFAULT CHARSET=euckr COMMENT='회원 포인트 부여 로그' AUTO_INCREMENT=1 ;
");

	}

	$SQL->Query("INSERT INTO `appstory_log`.`point_log".date("Ym")."` (
`mid` ,
`point` ,
`max_point` ,
`cid` ,
`bname` ,
`bid` ,
`log_code`, 
`log_msg` ,
`reg_date` ,
`reg_time` 
)
VALUES (
'".$mid."', '".$point."', '".$add_max_point."','".$cid."', '".$bname."', '".$bid."', '".$log_code."','".$log_msg."', now(), now()
);");

	### 베스트 회원 랭킹 캐시 파일 left 에서 /proc/etc/best_member_rank.inc.php 를 인클루드해서 사용한다###
	//@unlink($board_info[board_dir]."/cache/etc/best_member_rank.inc.php"); //비사용

}


### 회원처리###
function member_join(){

	$SQL = new Mysql;

	### 회원정보가 있는지 체크한뒤 없으면 넣어준다###
	$member_result = $SQL->Query("SELECT * FROM `member_info` WHERE `mid`='".$_COOKIE['user']['mid']."'");
	$member_row = mysql_fetch_array($member_result);

	if(!$member_row[mid]){//해당 정보가 없다면 비회원 처리				
		
		member_reset();

	}elseif($member_row[mid]){

	### 데이타 넣어주자 회원이관###
	$cookie_domain = '.appstory.co.kr';
	
	member_reset();

	setcookie("user[mid]",$member_row[mid] ,0,"/", $cookie_domain);
	setcookie("user[id]",$_COOKIE['user']['id'] ,0,"/", $cookie_domain);
	setcookie("user[nick]",$member_row[nick] ,0,"/", $cookie_domain);
	setcookie("user[level]",$member_row[level] ,0,"/", $cookie_domain);
	
	$_COOKIE['user']['mid'] = $_COOKIE['user']['mid'];
	$_COOKIE['user']['id'] = $_COOKIE['user']['id'];
	$_COOKIE['user']['nick'] = $member_row[nick];
	$_COOKIE['user']['level'] = $member_row[level];



	}

}

### 비회원 처리###
function member_reset(){

	$cookie_domain = '.appstory.co.kr';

	
	if($_COOKIE["user"]){
		foreach($_COOKIE["user"] as $key => $value) {
			setcookie('user['.$key.']',NULL,0,'/', $cookie_domain);
		}
	}



	setcookie("user[level]","Z" ,0,"/", $cookie_domain);


	$_COOKIE['user']['level'] = "Z";

	unset($_COOKIE['user']['mid'], $_COOKIE['user']['id'], $_COOKIE['user']['nick'], $_COOKIE['user']['company_name']);

}


?>
