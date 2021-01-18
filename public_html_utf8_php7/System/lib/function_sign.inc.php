<?php
/**
---------------------------------------------------------------------------------------------------
Program NAME: -
Content     : form 의 유효성을 검사하는 Class
Version     : v1.0
File Name   : function_sign.inc.php
Charset     : EUC-KR
Directory   :  /appstory.co.kr/public_html/System/lib/function_sign.inc.php
URI         : -
---------------------------------------------------------------------------------------------------
[사용 DB정보]
DB : 사용하는 DB
Tables(Fields) : 사용하는 테이블 

---------------------------------------------------------------------------------------------------
[개발자정보]
개발자: 최승학
개발일: 2010-02-26 금요일 21:04
변경일: -
email : sghakgun@gmail.com
---------------------------------------------------------------------------------------------------
[상세설명]

- 폼의 유효성을 검사화는 class 입니다.

[사용방법]
$checker = new FormValidation();
$checker->checkName(이름);

[결과값]
결과 값을 검사해서 문자열이면 error 메세지 입니다.
if ( is_string($checker->checkName(이름)) ) { 에러처리.. };

[수정내역] 
버젼, 작업자, 날짜,  변경내용 순으로 기술 (아래는 예제임)

1.0.1 김호 2009-10-29
- Xyx 함수에 abc 변수를 추가 했음.

**/

class FormValidation {

	function checkName($na) {	
		
		//$na = iconv('utf-8','euc-kr',$na);

		$msg = '';

		if ( $this->isEmpty($na) ) {

			$msg = '이름을 입력해 주세요.';
			return $msg;
		}


		if ( !$this->isKor($na) ) {
			$msg = '이름은 한글만 가능합니다.';
			return $msg;
		}

		if ( !$this->isValidLength($na, 2, 15) ) {
			$msg = '이름은 공백없이 2자 이상 8자 이하만 가능합니다.';
			return $msg;
		}

		return true;
	}

	function checkJumin($j_num) {

		$j_num = str_replace('-', '', $j_num);

		if ( $this->isEmpty($j_num) ) {
			$msg = '주민등록번호 13자리를 모두 입력해주세요.';
			return $msg;
		}

		if ( $this->hasSpace($j_num) ) {
			$msg = '주민등록번호는 공백없이 숫자만 13자리로 입력해 주세요.';
			return $msg;
		}

		if ( !$this->isNumber($j_num) ) {
			$msg = '주민등록번호는 숫자만 가능합니다.';
			return $msg;
		}

		if ( !$this->isValidLength($j_num, 13, 13) ) {
			$msg = '주민등록번호는 공백없이 숫자만 13자리로 입력해 주세요.';
			return $msg;
		}

		$sum=0;
		for($i=0;$i<8;$i++) { $sum+=substr($j_num,$i, 1)*($i+2); }
		for($i=8;$i<12;$i++) { $sum+=substr($j_num,$i, 1)*($i-6); }

		$sum=11-($sum%11);
		if ($sum>=10) { $sum-=10; }

		// 주민번호 7번째 자리의 규칙 ########################
		// 1800년대: 남자 9, 여자 0 (제외시켰음)
		// 1900년대: 남자 1, 여자 2
		// 2000년대: 남자 3, 여자 4
		// 2100년대: 남자 5, 여자 6
		// 외국인 등록번호: 남자 7, 여자 8
		if ( substr($j_num,12,1) != $sum ||
			 (substr($j_num,6,1) < 1 && substr($j_num,6,1) > 8) ) {
			$msg = '올바른 주민등록번호가 아닙니다. 다시 확인해주세요.';
		 	return $msg;
		}

		return true;
	}

	function checkNick($nick) {

		if ( $this->isEmpty($nick) ) {
			$msg = '닉네임을 입력해 주세요.';
			return $msg;
		}

		if ( $this->hasSpace($nick) ) {
			$msg = '닉네임은 공백없이 2자 이상 10자 이하로 입력해 주세요.';
			return $msg;
		}

		$illegal_nick      = array('webmaster', 'admin', 'guest');
		$illegal_nick_index= array_search($nick, $illegal_nick);
		if ( false !== $illegal_nick_index ) {

			$msg = $illegal_nick[$illegal_nick_index].'는 사용하실 수 없습니다.';
			return $msg;
		}
		
		if ( !$this->isValidLength($nick, 2, 10) ) {
			$msg = '닉네임은 공백없이 2자 이상 10자 이하로 입력해 주세요.';
			return $msg;
		}

		if ( !$this->isKorEnNum($nick, "", true) ) {
			$msg = '닉네임은 한글/영문 대소문자/숫자 만 가능합니다.';
			return $msg;
		}

		return true;
	}

	function checkID($id) {

		if ( $this->isEmpty($id) ) {
			$msg = '아이디를 입력해 주세요.';
			return $msg;
		}

		if ( $this->hasSpace($id) ) {
			$msg = '아이디는 공백없이 6자 이상 12자 이하로 입력해 주세요.';
			return $msg;
		}

		if ( !$this->isValidLength($id, 6, 12) ) {
			$msg = '아이디는 공백없이 6자 이상 12자 이하로 입력해 주세요.';
			return $msg;
		}

		$illegal_id      = array('webmaster', 'admin', 'guest');
		$illegal_id_index= array_search($id, $illegal_id);
		if ( false !== $illegal_id_index ) {

			$msg = $illegal_id[$illegal_id_index].'는 사용하실 수 없습니다.';
			return $msg;
		}
		
		if ( !$this->isEnNum($id, '', false) ) {
			$msg = '아이디는 영문 소문자/숫자/_ 만 가능합니다.';
			return $msg;
		}

		return true;
	}

	function checkPwd($pwd) {

		if ( $this->isEmpty($pwd) ) {
			$msg = '비밀번호를 입력해 주세요.';
			return $msg;
		}

		if ( $this->hasSpace($pwd) ) {
			$msg = '비밀번호는 공백없이 6자 이상 12자 이하로 입력해 주세요.';
			return $msg;
		}

		if ( !$this->isValidLength($pwd, 6, 12) ) {
			$msg = '비밀번호는 공백없이 6자 이상 12자 이하로 입력해 주세요.';
			return $msg;
		}

		if ( !$this->isEnNum($pwd, '', true) ) {
			$msg = '비밀번호는 영문+숫자로 6자이상, 12자 이하로 입력해 주세요.';
			return $msg;
		}
		
		if ( $this->hasKor($pwd) ) {
			$msg = '비밀번호는 한글을 사용할수 없습니다.';
			return $msg;
		}
		
		return true;
	}

	function checkEmail($email) {

		if ( $this->isEmpty($email) ) {
			$msg = '이메일 주소를 입력해 주세요.';
			return $msg;
		}

		$dot_pos = strpos($email, '.');
		if ( empty($dot_pos) ) {
			$msg = '잘못된 이메일 형식 입니다.';
			return $msg;
		}

		$split = explode('@', $email);
		if ( 2 != count($split) ) {
			$msg = '잘못된 이메일 형식 입니다.';
			return $msg;
		}

		$allow_c = '.-!#$%&"*+\/^_~{}|';
		if ( !$this->isEnNum($split[0], $allow_c, true) ) {
			$msg = '잘못된 이메일 형식 입니다.';
			return $msg;
		}

		$allow_c = '.-';
		if ( !$this->isEnNum($split[1], $allow_c, true) ) {
			$msg = '잘못된 이메일 형식 입니다.';
			return $msg;
		}

		if ( !$this->isValidLength($email, 0, 50) ) {
			$msg = '이메일 주소는 최대 50자 입니다.';
			return $msg;
		}

		return true;
	}

	function checkMobileNum($num) {

		if ( $this->isEmpty($num) ) {
			$msg = '핸드폰번호를 입력해 주세요.';
			return $msg;
		}

		$num = str_replace('-', '', $num);

		if ( $this->isEmpty($num) ) {
			$msg = '핸드폰번호를 입력해 주세요.';
			return $msg;
		}

		if ( !$this->isNumber($num) ) {
			$msg = '핸드폰번호는 숫자만 가능합니다.';
			return $msg;
		}

		if ( !$this->isValidLength($num, 9, 11) ) {
			$msg = '핸드폰번호는 최소 9자 최대 11자 입니다.';
			return $msg;
		}

		$is_legal_num  = false;
		$comp_num      = substr($num, 0, 3);
		$allow_comp_num= array('010', '011', '016', '017', '018', '019');
		$l = count($allow_comp_num);
		for ($i = 0; $i <  $l; $i++) {
			if ($comp_num != $allow_comp_num[$i]) continue;

			$is_legal_num = true;
			break;
		}

		if ( !$is_legal_num ) {
			$msg = '핸드폰번호는 010,011,016,017,018,019 만 가능합니다.';
			return $msg;
		}

		return true;
	}

	function isEmpty($str) {

		$is_empty= false;
		$str     = trim($str);
		if ( !isset($str{0}) ) $is_empty = true;

		return $is_empty;
	}

	function isNumber($v) {

		$is_number = false;
		if ( is_numeric($v) ) $is_number = true;

		return $is_number;
	}

	function isValidLength($str, $min, $max, $kor_byte = 2) {

		if ( !is_string($str) ) return false;

		if ( empty($min) ) $min = 0;
		if ( empty($max) ) $max = 0;

		if ( !is_numeric($min) || !is_numeric($max) ) return false;

		$min = intval($min);
		$max = intval($max);

		$mode = "both";
		if ( $min > 0 && empty($max) ) $mode = "min";
		if ( $max > 0 && empty($min) ) $mode = "max";

		$is_valid_min = $this->validByteLen($str, $min);
		$is_valid_max = $this->validByteLen($str, $max+1);

		// echo $form_valid->isValidLength('최a최a승학', 2, 7);
		// echo $is_valid_max;
		// exit;

		$is_valid = true;
		switch ($mode) {
			case "both":
				if ( !$is_valid_min || $is_valid_max ) $is_valid = false;
				break;
			case "min":
				if ( !$is_valid_min ) $is_valid = false;
				break;
			case "max":
				if ( $is_valid_max ) $is_valid = false;
		}

		return $is_valid;
	}

	function isKor($str, $deny_jamo=true, $kor_byte=2) {

		if ( !is_string($str) ) return false;

		$is_kor= true;
		$l     = strlen($str);
		$asc   = '';
		for ($i = 0; $i < $l; $i++) {

			$asc = ord( $str{$i} );
			if($asc >= 0xa1 && $asc <= 0xfe) continue;

			$is_kor = false;
			break;
		}

		$kor_jamo = array(
			'cho' => 'ㄱㄲㄴㄷㄸㄹㅁㅂㅃㅅㅆㅇㅈㅉㅊㅋ ㅌㅍㅎ',
			'jung'=> 'ㅏㅐㅑㅒㅓㅔㅕㅖㅗㅘㅙㅚㅛㅜㅝㅞ ㅟㅠㅡㅢㅣ',
			'jong'=> 'ㄱㄲㄳㄴㄵㄶㄷㄹㄺㄻㄼㄽㄾㄿㅀ ㅁㅂㅄㅅㅆㅇㅈㅊㅋㅌㅍㅎ',
		);

		if ( !$is_kor && $deny_jamo ) {

			for ($i = 0; $i < $l; $i+=$kor_byte) {

				$c = substr($str, $i, $kor_byte);
				foreach ($kor_jamo as $v) {
					if ( !strstr($v, $c) ) continue;

					$is_kor = false;
					break;
				}

				if ( !$is_kor ) break;
			}
		}

		return $is_kor;
	}

	function hasKor($str) {
		
		if ( !is_string($str) ) return false;
		
		$has_kor = false;
		$l = strlen($str);
		for ($i = 0; $i < $l; $i++) {
  
			if ( !$this->isKor($str[$i]) ) continue;
			
			$has_kor = true;
			break;
		}
		
		return $has_kor;
	}
	
	function hasSpace($str) {

		$has_space = false;
		if ( strstr($str, " ") ) $has_space = true;

		return $has_space;
	}

	function isEnNum($str, $allow_c='', $allow_cap=false) {

		$l       = strlen($str);
		$is_legal= true;
		$c       = '';
		for ($i = 0; $i <  $l; $i++) {

			$c = $str{$i};
			if( $c >= 'a' && $c <= 'z' ) continue;
			if( $allow_cap && $c >= 'A' && $c <= 'Z' ) continue;
			if( $c >= '0' && $c <= '9') continue;
			if( $allow_c && strstr($allow_c, $c) ) continue;

			$is_legal = false;
			break;
		}

		return $is_legal;
	}

	function isKorEnNum($str, $allow_c, $allow_cap) {

		$l       = strlen($str);
		$is_legal= true;
		$c       = '';
		for ($i = 0; $i <  $l; $i++) {

			$c = $str{$i};
			if( $c >= 'a' && $c <= 'z' ) continue;
			if( $allow_cap && $c >= 'A' && $c <= 'Z' ) continue;
			if( $c >= '0' && $c <= '9') continue;
			if( $this->isKor($c, false) ) continue;
			if( $allow_c && strstr($allow_c, $c) ) continue;

			$is_legal = false;
			break;
		}

		return $is_legal;
	}

	function validByteLen($str, $cut_len, $kor_byte = 2) {

		$kor_over_byte= 0;
		$add_kor_byte = $kor_byte - 1;
		$len          = strlen($str);
		$is_valid     = false;
		for ($i = 0; $i < $len; $i++) {

			++$byte_size;
			if ( ord($str[$i]) > 127 ) ++$kor_over_byte;

			if ($kor_byte == $kor_over_byte) {

				$kor_over_byte= 0;
				$cut_len += $add_kor_byte;
			}

			if ($byte_size == $cut_len && $kor_over_byte == 0) {

				$is_valid = true;
				break;
			}
		}

		return $is_valid;
	}
	
	function showErrorMsg($msg, $go_url = 'back') {

		$act = "history.back()";
		if ($go_url != 'back') $act = 'self.location.href="'.$go_url.'"';

		echo "
		<script type='text/javascript'>
		<!--
			alert('{$msg}');
			{$act};
		//-->
		</script>";

		exit;
	}




	function check_company_num($co_serial_1, $co_serial_2, $co_serial_3){


		if (!isset($co_serial_1) || !isset($co_serial_2) || !isset($co_serial_3)) 
		{ 
			$msg = '사업자등록번호를 입력해 주세요.';
		 	return $msg;
		}elseif (ereg("[^0-9]+",$co_serial_1) || ereg("[^0-9]+",$co_serial_2) || ereg("[^0-9]+",$co_serial_3)) 
		{ 
			$msg = '사업자등록번호를 정확히 입력해 주세요.';
		 	return $msg;
		}else{
			
			$co_serial = $co_serial_1.$co_serial_2.$co_serial_3; 
			$IDtot = 0; 
			$IDAdd = "137137135"; 

			for ($i=0;$i < 9 ; $i++) 
			{ 
			$IDtot = $IDtot + (substr($co_serial,$i,1) * substr($IDAdd,$i,1)); 
			} 

			$IDtot = $IDtot + ((substr($co_serial,8,1)*5)/10); 
			$IDtot = 10 - ($IDtot % 10); 

			if (substr($co_serial_3,-1) != substr($IDtot,-1)) 
			{ 
				$msg = '사업자등록번호를 정확히 입력해 주세요.';
			 	return $msg;
			} 
		} 

		return true;
	}

	function sign_data_check($v, $msg){

		if ( $this->isEmpty($v) ) {
			return $msg;
		}

		return true;
	}


}



?>
