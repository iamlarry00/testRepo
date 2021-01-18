<?


### 게시글 페이지뷰 로그생성###
function board_count_add_log($bname, $bid){

	global $ohing_board_info;

	$SQL = new Mysql;

	$table_name = "ohing_board_daily_log".date("Ym");
	

	/*
	리뷰 추가시 $review_names 추가요망
	적용된 페이지 모두 찾아 수정해줘야함
	img.appstory.co.kr/System/lib/download.proc.php
	m.appstory.co.kr/System/lib/function_appstory.inc.php -> board_count_add_log 함수내에
	www.appstory.co.kr/app_board/lib/function_board.inc.php -> board_count_add_log 함수내에
	2012-01-03
	권오용
	*/
	$review_names = array("iphone_apps_review", "ipad_apps_review", "ipmovie", "aphone_apps_review", "galaxytab_apps_review", "wphone_apps_review");

	### 리뷰의 경우 로그테이블 추가 생성###
	if(in_array($bname, $review_names)){

		$table_name = "ohing_board_review_daily_log".date("Ym");

	}


	//$SQL->Query("INSERT INTO `appstory_log`.`".$table_name."` (`bname` ,`bid` ,`view_num` ,`reg_date` ) VALUES ('".$bname."', '".$bid."' , '1', '".date("Y-m-d")."') ON DUPLICATE KEY UPDATE `view_num` = `view_num`+1;");  요게 슬로우퀘리로 가끔 잡힌다 그래서 인서트와 업데이트로 나눴다

	$today_add_lid = $SQL->OneValue("SELECT `lid` FROM `appstory_log`.`".$table_name."` WHERE `bname`='".$bname."' AND `bid`='".$bid."' AND `reg_date`='".date("Y-m-d")."' ");

	if($today_add_lid){//업데이트

		$SQL->Query("UPDATE `appstory_log`.`".$table_name."` SET `view_num` = `view_num`+1 WHERE `lid`='".$today_add_lid."'");

	}else{//인서트

		$SQL->Query("INSERT INTO `appstory_log`.`".$table_name."` (`bname` ,`bid` ,`view_num` ,`reg_date` ) VALUES ('".$bname."', '".$bid."' , '1', '".date("Y-m-d")."')");

	}

	$SQL->Query("UPDATE `ohing_board_".$bname."_log` SET `view_num`=view_num+1 WHERE `bid`='".$bid."'");

	

}

?>
