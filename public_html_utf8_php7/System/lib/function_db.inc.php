<?php


/*
---------------------------------------------------------------------------------------------------
	[mysql 함수 class]	 var.1.0.20
---------------------------------------------------------------------------------------------------
개발자 : 김호

$TABLE_NAME = 테이블명
$query = 보낼 쿼리
$fields = 필드명 "`field_name`, `field_name`,`field_name`"
$values = 값 "'value','value','value','value','value'"
$array_fields_values = array("key"=>"'value'", ...)
$where = 기본값 '1', cid = aaa
$return_error = 기본값 "pass" 인경우는 SQL에러를 리턴하지 않는다. pass가 아닐경우 SQL에러 값을 보낸다.

[변경]

2006.05.11/김호
- $error_return 값이 NULL 이 아닐경우는 에러시 에러 메세지를  보낸다 - 테스트시 이용하자.
- 에러가 발생하면 /System/log/query/error.log 에 입력 된다. - Makefile() 함수 이용.
- $return_error 변수 제거

2006.05.16 / 김호
- MySelect() 함수 추가 - SELECT 문의 값을 배열(키=값)로 가져온다.

2006.05.22 / 김호
- 최적화

2006.11.02 / 김호
- debug 모드 삽입
- 프로그램 실행전에 정상적인 쿼리를 보내는지 알기위해 쿼리 값을 리턴한다. FALSE 가 아닌 값을 넣어주면 디버그 모드 작동.
- ex : $SQL->debug = TRUE;

2007-01-10 - 김호
- $this->log 변수 추가 : TRUE 로 활성화 시 보낸 쿼리를 로그로 남김.
- DB연결 Mysql()함수 추가
- DB선택 SelectDB() 함수 추가

2007-10-02 - 김호
- $print_q 쿼리 출력 변수 추가

2007-12-26 - 김호
MySelectRow() - SELECT 문의 값을 배열(값)로 가져온다.

2008-01-29 - 김호
OneValue() 에 Limit 값을 넣을 수 있도록 수정.

2008-03-07 - 김호
OneValue() 에서 Limit 를 사용하지 않을 수 있도록 수정.

2008-03-08 - 김호
OneValue() MySelect() 에서 값이 없을때는 return FALSE 로 수정

*/

class Mysql
{
	var $TABLE_NAME;
	var $query;
	var $fields;
	var $values;
	var $array_fields_values; //Update()함수용 객체 배열로 받아야 한다.
	var $where = 1;
	var $path_error_log; //에러로그를 저장할 파일경로
	var $error_return; //값이 있으면 에러 창을 띄운다.
	var $debug = FALSE; //디버그 모드 - DB에 접근 하지 않고 쿼리를 출력한다.
	var $log = FALSE;//쿼리 로그 기록
	var $print_q = FALSE; //쿼리 출력.
	var $conn;

	function Mysql($ini_file=FALSE)
	{

		if($ini_file === FALSE) {

			$ini_file = SITE_DB_INI_FILE; //DB설정파일.

		} else {

			$ini_file = SITE_INF_PATH."/".$ini_file; //DB설정파일.

		}

	  $db_connect = @parse_ini_file($ini_file); //디렉토리환경 파일

	  $this->conn = @mysqli_connect($db_connect['HOSTNAME'],$db_connect['USERNAME'],$db_connect['PASSWD'], $db_connect['DBNAME']); // 데이터베이스에 연결한다.

		//if(!$conn) {
		if (mysqli_connect_errno()){

			if(IP_OFFICE == $_SERVER['REMOTE_ADDR']) {

				$msg = $ini_file."에 연결을 할 수 없습니다. DATABASE 관리자에게 문의 하세요.";

			} else {
				//echo "ini_file=$ini_file , ".$db_connect['HOSTNAME'];print_r($db_connect);exit;
				$msg = "죄송합니다1. 현재 DATABASE 점검 중 입니다. 잠시 후 다시 이용해 주십시요!".IP_OFFICE." / ".$_SERVER['REMOTE_ADDR'];

			}

			PopupMsg($msg);
			exit;
		}

	  $db = @mysqli_select_db($this->conn, $db_connect['DBNAME']); // 작업대상 데이터베이스를 선택한다.

		if(!$db) {

			if(IP_OFFICE == $_SERVER['REMOTE_ADDR']) {

				$msg = "지정한 데이터베이스(".$db_connect['DBNAME'].")를 열수 없습니다.\\n\\nDATABASE 관리자에게 문의 하세요.";

			} else {

				$msg = "죄송합니다2. 현재 DATABASE 점검 중 입니다. 잠시 후 다시 이용해 주십시요!";

			}

			PopupMsg($msg);
			exit;

		}

		//mysqli_query("SET NAMES 'euckr'");//캐릭터셋 해결

		return TRUE;

	}


	### 작업대상 데이터베이스를 선택하는 함수 ###
	function SelectDB($db_name)
	{

		$db = @mysqli_select_db($this->conn, $db_name);

		if(!$db) {

			if(IP_OFFICE == $_SERVER['REMOTE_ADDR']) {

				$msg = "지정한 데이터베이스(".$db_connect['DBNAME'].")를 열수 없습니다.\\n\\nDATABASE 관리자에게 문의 하세요.";

			} else {

				$msg = "죄송합니다3. 현재 DATABASE 점검 중 입니다. 잠시 후 다시 이용해 주십시요!";

			}

			PopupMsg($msg);
			exit;

		}

	}

	### SELECT 함수 : 하나의 value 만 가져온다. ###
	function OneValue($Q, $start=0,$limit=1)
	{

		if(is_numeric($start)) $Q .= " LIMIT $start,$limit";

		if($this->debug === FALSE) {

			$row = @mysqli_fetch_row($this->Query($Q));

			if($row[0] != NULL) {
				return $row[0];
			} else {
				return FALSE;
			}

		} else {

			return $Q;

		}

	}

	### SELECT 함수 : 여러개의 필드에서 값을 배열(키=값)로 가져올때 사용 ###
	function MySelect($Q, $start=0)
	{
		if(is_numeric($start)) $Q .= " LIMIT $start,1";

		if($this->debug === FALSE) {

			$row = @mysqli_fetch_array($this->Query($Q));

			if($row[0] != NULL) {
				return $row;
			} else {
				return FALSE;
			}

		} else {

			return $Q;

		}

	}

	### SELECT 함수 : 여러개의 필드에서 값을 배열(값)로 가져올때 사용 ###
	function MySelectRow($Q, $start="0")
	{
		if(is_numeric($start)) $Q .= " LIMIT $start,1";

		if($this->debug === FALSE) {

			return @mysqli_fetch_row($this->Query($Q));

		} else {

			return $Q;

		}

	}

	### 랜덤값을가져온다
	function RandValue($Q,$count="1")
	{

		if(is_numeric($count)) $Q .= " ORDER BY rand() LIMIT ".$count;

		if($this->debug === FALSE) {

			$row = @mysqli_fetch_row($this->Query($Q));
			return $row[0];

		} else {

			return $Q;

		}

	}

	### INSERT 함수 ###
	# 사용방법
	# $SQL->fields = "`field_name`, `field_name`,`field_name`";
	# $SQL->values = "'value','value','value','value','value'";
	# $SQL->Insert();
	function Insert()
	{
		if(!$this->fields) {
			PopupMsg("입력한 필드가 없습니다. \\n\\n프로그램 확인 바람."); //들어온 필드가 없으면 돌려보냄
			exit;
		}
		if(!$this->values) {
			PopupMsg("입력한 값이 없습니다.\\n\\n프로그램 확인 바람."); //들어온 값이 없으면 돌려보냄
			exit;
		}

		$Q = "INSERT INTO `".$this->TABLE_NAME."` (".$this->fields.") VALUES (".$this->values.")";

		if($this->debug === FALSE) {

			if($this->Query($Q) != NULL) {
				return TRUE;
			} else {
				return FALSE;
			}

		} else {

			return $Q;

		}

	}

	### UPDATE 함수 ### 		$array_fields_values = array("key"=>"'value'", ...)
	# 사용방법
	# $SQL->array_fields_values = array("key"=>"'value'", ...);
	# $SQL->where = 조건문;
	# $SQL->Update();
	function Update()
	{

		foreach ($this->array_fields_values as $k => $v) { $field_values .= "`$k` = $v,"; }

		$field_values = substr($field_values, 0, -1); //마지막 ','제거

		$Q = "UPDATE `".$this->TABLE_NAME."` SET ".$field_values." WHERE ".$this->where;

		if($this->debug === FALSE) {

			if($this->Query($Q) != NULL) {
				return TRUE;
			} else {
				return FALSE;
			}

		} else {

			return $Q;

		}

	}

	### DELETE 함수 ###
	# 사용방법
	# $SQL->where = 조건문;
	# $SQL->Delete();
	function Delete()
	{
		$Q = "DELETE FROM `".$this->TABLE_NAME."` WHERE $this->where";

		if($this->debug === FALSE) {

			if($this->Query($Q) != NULL) {
				return TRUE;
			} else {
				return FALSE;
			}

		} else {

			return $Q;

		}

	}

	### 쿼리 보내기 함수 ###
	function Query($query)
	{

		//mysqli_query("SET NAMES 'euckr'");//캐릭터셋 해결

		if(!$result = @mysqli_query($this->conn, $query)) { //에러가 있을때는 $result 에 값이 없다.

		  $err_no = @mysqli_errno($this->conn);
		  $err_msg = @mysqli_error($this->conn);
		  $error_msg = "전송쿼리: ".$query."\nERROR CODE " . $err_no . " : " . $err_msg."\n";

			if(!$this->path_error_log) $this->path_error_log = SITE_LOG_PATH."/query/error".date("Ymd").".log";
			@MakeErrorFile($error_msg,$this->path_error_log);

			if(isset($this->error_return)) {//에러가 있을때는 경고 창을 띄운다.
				PopupMsg("쿼리에 오류가 있습니다.".$this->path_error_log."파일을 확인해 주세요");
			}

			return FALSE;

		} else {

			if($this->log === TRUE) { //로그 남기기

				@MakeErrorFile("전송쿼리: ".$query,SITE_LOG_PATH."/debug/query".date("Ymd").".log");

			}

			if($this->print_q === TRUE) echo $query."<br/>\n";

			return $result;

		}

	}

	### 테이블 삭제 함수 ###
	function Drop()
	{
		return @mysqli_query("DROP TABLE `$this->TABLE_NAME`" );
	}

	### 테이블 최적화 함수 ###
	function Optimize()
	{
		return @mysqli_query("OPTIMIZE TABLE `$this->TABLE_NAME`");
	}

	### 테이블 비우기 함수 ###
	function Truncate()
	{
		return @mysqli_query("TRUNCATE TABLE `$this->TABLE_NAME`");
	}


	// Table, Column 존재 여부 확인
	function checkTable($table, $column='*') {

		$table = mysqli_real_escape_string($table);
		if ( $column != '*' ) $column = mysqli_real_escape_string($column);

		$q = 'SELECT '.$column.' FROM ' . $table . ' LIMIT 1';

		$r = $this->Query($q);

		$result = FALSE;
		if ( is_resource($r) ) {
			$row = mysqli_fetch_row( $r );
			if($row[0] != NULL) $result = $row[0];
		}

		return $result;
	}


}



// Quote variable to make safe
function quote_smart($value)
{
    // Stripslashes
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }
    // Quote if not integer
    if (!is_numeric($value)) {
        $value = "'" . mysqli_real_escape_string($value) . "'";
    }
    return $value;
}




?>
