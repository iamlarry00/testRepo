<?php
/*
---------------------------------------------------------------------------------------------------
Program NAME : SITE PHP Framework 2
Content : 회원관리용	[로그인/로그아웃 클래스] 함수 모음
Version : 1.0
File Name : function_login.inc.php
Charset : euc-kr
Directory : /System/lib
URI :
---------------------------------------------------------------------------------------------------
[개발자정보]

개발자 : 김호
개발일 : 2008.01.18
email: webmaster@hodragon.com
msn: webmaster@hodragon.com
homepage: www.hodragon.com
support : www.hoyaboard.com
---------------------------------------------------------------------------------------------------
[함수 리스트]



*/


/*
-------------------------------------------------------------------------------
Login Class
-------------------------------------------------------------------------------

[사용 테이블]


[변수설명]
$user_mode  // 관리자:admin 일반유져:user 손님:guest
$user_id  	// 사용자 입력 id
$user_pwd  	// 사용자 입력 password
$goURL     	// 이동 URL
$id_save   	// 아이디저장
$login_page	// 아이디,비번 오류시 이동할 URL
$main_page 	// 사이트 매인
$c_domain  	// 쿠키도메인
$office_ip  // 사무실 ip

[설명]
- 기본 변수 초기화는 MemLogin() 함수에서 정해진다.
기본 변수를 변경하려면 MemLogin() 함수안에 변수를 변경

[사용법]
$login = Login($user_mode, $goURL);   // 객체 생성
$login->doGuestLog();                 // Guest Cookie 생성 및 로그 생성
$login->doLogin($user_id, $user_pwd);// Member Login Cookie 생성 및 로그 생성
$login->doLogout($goURL);             // Member Logout

[참고사항]
- DB 작업은 class Mysql을 이용한다.
*/





class Login {

	private $user_mode;
	private $user_id;
	private $user_id_cookie;
	private $user_pwd;
	private $goURL;
	private $id_save;
	private $pwd_save;
	private $login_page;
	private $main_page= SITE_DOMAIN;
	private $c_domain = SITE_GLOBAL_COOKIE_DOMAIN;
	private $office_ip= IP_OFFICE;

	// 생성자 (변수 초기화)
	// ************************************************************************
	function Login($user_mode = 'guest', $goURL = '', $login_page = '') {

		// 접근 유효성 검사
		// ********************************************************************
		$this->user_mode = 'guest';
		switch ($user_mode) {

			case 'admin':
				if ($_SERVER['REMOTE_ADDR'] != $this->office_ip) {
					$this->msgPopup('잘못된 접근입니다.', $this->main_page);
				}
			case 'user':
				$this->user_mode = $user_mode;
				break;
		}
		//----------------------------------------------------- 접근 유효성 검사



		if ( 'on' == $_POST['save_login'] ){
			
			$this->id_save = 1;
			$this->pwd_save = 1;

		}
		
		/* 아이디 비번 저장을 나눌려면 아래쪽 주석 제거 하고 값을 지정한다
		// id 저장
		// *********************************************************************
		if ( 'on' == $_POST['save_id'] ) $this->id_save = 1;
		//------------------------------------------------------------- id 저장

		// 비밀번호 저장
		// *********************************************************************
		if ( 'on' == $_POST['save_pwd'] ) $this->pwd_save = 1;
		//------------------------------------------------------------- 비밀번호 저장
		*/

		

		// 이동할 페이지
		// ********************************************************************
		$in_goURL = false;
		if ( !empty($goURL) ) {

			$this->goURL= urldecode($goURL);
			$in_goURL   = true;
		}

		if ( !$in_goURL && !empty($_SERVER['HTTP_REFERER']) ) {

			if ( strstr($_SERVER['HTTP_REFERER'], 'daily.co.kr') )
				$this->goURL = $_SERVER['HTTP_REFERER'];
		}

		if ( empty($this->goURL) ) $this->goURL = $this->main_page;
		//-------------------------------------------------------- 이동할 페이지


		// if ($this->user_mode == 'admin') $this->login_page= 'http://localhost/appstory/user_login.html';

		// 로그인 페이지
		// ********************************************************************
		$this->login_page = $this->main_page.'/login/';
		if ( !empty($login_page) ) $this->login_page = $login_page;

		$this->login_page .= '?goURL='.urlencode($this->goURL);
		//------------------------------------------------------ 로그인 페이지
	}


	function get_id($id){

		return base64_decode(strrev(base64_decode($id))); //base64_encode(strrev(base64_encode($this->user_id)));

	}

	// 로그인
	// **************************************************************************
	function doLogin($id, $pw) {

		$id = trim($id);
		$pw = trim($pw);
		if ( empty($id) || empty($pw) ) {

			$this->msgPopup('아이디와 비밀번호를 확인해 주세요.', $this->login_page);
		}

		$this->user_id = strtolower($id);
		
		$this->user_id_cookie = base64_encode(strrev(base64_encode($this->user_id)));//노출되는 쿠기이므로 암호화한다

		

		$this->user_pwd = $pw;

		$this->makeLoginCk();
	}

	// 로그인 쿠키 만들기
	// **************************************************************************
	function makeLoginCk() {

		$SQL = new Mysql();

		$escape = array();
		$escape['pw'] = mysqli_real_escape_string($SQL->conn, $this->user_pwd);
		$escape['id'] = mysqli_real_escape_string($SQL->conn, $this->user_id);

		// 회원정보 가져오기
		// **************************************************************************
		switch ($this->user_mode) {

			case 'admin':
				
				$q = 'SELECT `aid` AS `mid`, `id`, `pw` AS `passwd`, `level`, `reg_date`, ';
				$q.= '  PASSWORD("'.$escape['pw'].'") AS `input_passwd` ';
				$q.= 'FROM `admin_member` ';
				$q.= 'WHERE `id` = "'.$escape['id'].'"';
				//echo $q;exit;
				$row = $SQL->MySelect($q);
				break;

			case 'user':
				$q = 'SELECT *,  ';
				$q.= 'PASSWORD("'.$escape['pw'].'") AS `input_passwd` ';
				$q.= 'FROM `member`  ';
				$q.= 'WHERE ';
				$q.= '`id` = "'.$escape['id'].'"';
				$row = $SQL->MySelect($q);
				break;

			default :
				$this->msgPopup('잘못된 접근 입니다.', $this->main_page);
		}


		if ( empty($row) ) {
			//$this->msgPopup('일치하는 아이디가 없습니다.', $this->login_page); 2013-12-02 권오용 : 아이디든 비번이든 둘중 하나만 안맞는다는건 힌트이므로 애매하게 노출해줘야한다
			$this->msgPopup('일치하는 정보가 없습니다.', $this->login_page);
		}
		//--------------------------------------------------- 회원정보 가져오기


		// 불량 회원
		// **************************************************************************
		if( 'B' == $row['level'] ) {

			$err_msg = "회원님은 불량회원으로 등록 되어 있습니다.\\n\\n고객센터로 문의 하세요.";
			$this->msgPopup($err_msg, $this->goURL);
		}

		// 탈퇴회원
		// **************************************************************************
		if( 'del' == $row['status'] ) {

			$del_date= '';
			$q       = 'SELECT `datetime` FROM `member_del` WHERE `mid`= '.$row['mid'];
			$del_date= $SQL->OneValue($q);

			$err_msg = $del_date.' 에 탈퇴하신 회원 입니다.';
			$this->msgPopup($err_msg, $this->goURL);
		}

		// 비밀번호 확인
		// **************************************************************************
		$input_passwd= $row['input_passwd'];
		$DB_passwd   = $row['passwd'];



		if( headers_sent() ) {

			$this->msgPopup('헤더 파일을 전송 할 수 없어서 로그인을 수행할 수 없습니다! 관리자에게 문의하시기 바랍니다.');
		}

		if($this->user_mode == 'user'){


		
		$save_cname = 'save';//저장할쿠키 키값

		$md5_key = "%#Q$)*%@@";//md5 쿠키생성시 추가되는값

		### 비밀번호 저장 쿠키값이 있으면 비밀번호 체크를 안하는대신 해당 쿠키값이 해당 아이디의 비밀번호가 맞는지 체크한다###
		if( $this->pwd_save > 0 && $_COOKIE[$save_cname]['pwd']){
	
			### 자릿수 복호화###
			list($cookie_save_pwd, $cookie_save_pwd_len) = explode("_::_", $_COOKIE[$save_cname]['pwd']);//_::_ 구분자

			$cookie_save_pwd_len = numDecode($cookie_save_pwd_len, "snum");

			if($cookie_save_pwd == md5($DB_passwd.$md5_key.$this->user_id) && $cookie_save_pwd_len == strlen($this->user_pwd)){

				$input_passwd = $DB_passwd;//비밀번호를 체크해도 동일하도록 처리한다

			}
			
		}

		// id 저장
		// *******************************************************************
		
		if($_COOKIE[$save_cname]) {

			foreach($_COOKIE[$save_cname] as $key => $value)
				setcookie($save_cname.'['.$key.']', NULL, time()+0, '/', $this->c_domain);
		}

		if ( $this->id_save > 0 ) {

			setcookie($save_cname.'[id]', $this->user_id_cookie, time()+3600*24*30, '/', $this->c_domain);
		}
		//------------------------------------------------------------ id 저장

		
		### 비밀번호를 저장한다(암호하해야 다른 아이디의 쿠키값을 적용하여 악용하는 해킹을 막을수 있다)###
		if ( $this->pwd_save > 0 ) {


			### 비밀번호 쿠키값생성하기###
			$save_pwd_value = md5($DB_passwd.$md5_key.$this->user_id);

			### 비밀번호 자릿수 암호화###
			$user_pwd_len = strlen($this->user_pwd);
			$save_pwd_value .= "_::_".numEncode($user_pwd_len, "snum");//_::_ 구분자


			setcookie($save_cname.'[pwd]', $save_pwd_value, time()+3600*24*30, '/', $this->c_domain);
		}
		//------------------------------------------------------------ id 저장


		}

		

		//if ( $DB_passwd != $input_passwd && $_SERVER['REMOTE_ADDR'] != $this->office_ip && $this->user_mode == "user") {
		if ( $DB_passwd != $input_passwd ) {

			$sep_str = '?';
			if( strstr($this->login_page, '?') ) $sep_str = '&';

			$error_go = $this->login_page.$sep_str.'id='.$this->user_id;
			//$this->msgPopup('비밀번호가 일치하지 않습니다.', $error_go);
			$this->msgPopup('일치하는 정보가 없습니다.', $error_go);
		}
		//------------------------------------------------------ 비밀번호 확인







		// 로그인 Log (admin page 접근을 제외하고 사무실에서의 접속은 로그를 남기지 않는다. )
		// **************************************************************************
		// if( $_SERVER['REMOTE_ADDR'] != $this->office_ip || 'admin' == $this->user_mode ) {
		if( true || 'admin' == $this->user_mode ) { // 무조건 로그를 남긴다.


			$referer = 'self';
			if ( !empty($_SERVER['HTTP_REFERER']) ) $referer = $_SERVER['HTTP_REFERER'];

			// 로그 테이블이 없으면 만든다.

			if($this->user_mode == 'admin'){
				$table_name= 'admin_login_log'.date('Ym');
			}elseif($this->user_mode == 'user'){
				$table_name= 'member_login_log'.date('Ym');
			}
			
			$temp_row['Msg_text'] = '';
		
			$SQL->SelectDB('daily_log');
			if ( $SQL->checkTable($table_name) ) $temp_row['Msg_text'] = 'OK';
			
			if( $temp_row['Msg_text'] != 'OK' ) {

				$q = 'CREATE TABLE IF NOT EXISTS `'.$table_name.'` ( ';
				$q.= '`lid` int(10) unsigned NOT NULL AUTO_INCREMENT, ';
				$q.= '`mid` int(10) unsigned NOT NULL, ';
				$q.= '`login_date` date NOT NULL, ';
				$q.= '`login_time` time NOT NULL, ';
				$q.= '`logout_date` date NOT NULL DEFAULT "0000-00-00", ';
				$q.= '`logout_time` time NOT NULL DEFAULT "00:00:00", ';
				$q.= '`referer` varchar(200) NOT NULL, ';
				$q.= '`thispage` varchar(255) NOT NULL, ';
				$q.= '`user_ip` char(15) NOT NULL, ';
				$q.= '`status` enum("login","logout") NOT NULL DEFAULT "login", ';
				$q.= 'PRIMARY KEY (`lid`), ';
				$q.= 'KEY `mid` (`mid`), ';
				$q.= 'KEY `status` (`status`) ';
				$q.= ') ENGINE=MyISAM DEFAULT CHARSET=euckr COMMENT="로그인-아웃 로그"';

				$SQL->Query($q);
			}

			### 금일 로그인 카운트###
			$today_join_count =  $SQL->OneValue("SELECT COUNT(*) FROM `".$table_name."` WHERE `mid`='".$row['mid']."' AND `login_date`='".date("Y-m-d")."' ");
			
			// 로그 삽입
			$q = 'INSERT INTO `'.$table_name.'` ';
			$q.= '(`mid`, `login_date`, `login_time`, ';
			$q.= '`referer`, `thispage`, `user_ip`, `status`) ';
			$q.= 'VALUES ';
			$q.= '( '.$row['mid'].', now(), now(), "'.$referer.'", ';
			$q.= '"'.$_SERVER['PHP_SELF'].'", "'.$_SERVER['REMOTE_ADDR'].'", "login")';

			$result = $SQL->Query($q);

			if( !$result ) {

				$this->msgPopup("죄송합니다. 일시적인 장애로 정상적인 로그인을 할 수 없습니다. 다시 로그인을 해주세요.\\n\\n이 문제가 계속 되면 고객센터로 문의 바랍니다.", $this->main_page);
			}

			$result     = $SQL->Query('SELECT LAST_INSERT_ID()');
			$temp_row 	= mysqli_fetch_row($result);
			$last_log_id= $temp_row[0];

			// 로그 테이블에서 이전 정보중에 정상적으로 로그아웃 하지 못한 정보를 로그아웃
			$q = 'UPDATE `'.$table_name.'` ';
			$q.= 'SET `logout_date` = now(), `logout_time`= now(), `status` = "logout" ';
			$q.= 'WHERE `mid` = '.$row['mid'].' AND `lid` != '.$last_log_id.' ';
			$q.= 'AND `status` = "login"';
			$SQL->Query($q);

			
			if($this->user_mode == 'user'){

				### 로그인 카운트###
				$SQL->Query("INSERT INTO `daily_log`.`member_login_count` (`mid`,`login_count`) VALUES ('".$row['mid']."','1') ON DUPLICATE KEY UPDATE `login_count` = `login_count`+1;");

			}

			$SQL->SelectDB('daily');
		}
		//------------------------------------------------------- 로그인 Log


		// 로그인 쿠키 생성
		// ********************************************************************
		if( 'admin' == $this->user_mode ) {

			setcookie('admin[id]', $this->user_id_cookie, 0, '/', $this->c_domain);
			setcookie('admin[mid]', $row['mid'], 0, '/', $this->c_domain);
			setcookie('admin[logid]', $last_log_id, 0, '/', $this->c_domain); // 저장로그 PK

		} else {

	
			// if ( $this->office_ip == $_SERVER['REMOTE_ADDR'] ) $last_log_id = 'office';

			//로그인 한 날짜.
			setcookie('user[login_date]', date('Y-m-d'), 0, '/', $this->c_domain);
			//로그저장 pk
			setcookie('user[logid]', $last_log_id, 0, '/', $this->c_domain);
			setcookie('user[id]', $this->user_id_cookie, 0, '/', $this->c_domain);
			setcookie('user[mid]', $row['mid'], 0, '/', $this->c_domain);
			setcookie('user[level]', $row['level'], 0, '/', $this->c_domain);//레벨
			

		}





		//회원id암호화
		if ( function_exists('encode64') ) {

			$ssid = encode64($row['mid'].$this->user_id_cookie);
			setcookie($this->user_mode.'[ssid]', $ssid, 0, '/', $this->c_domain);
		}
			

		//--------------------------------------------------- 로그인 쿠키 생성


		// GUEST 쿠키 로그파일 삭제.
		// ********************************************************************
		if( $_COOKIE['guest'] ) {

			//------------------------------------------------ 테이블 존재유무체
			$table_name_pre= 'guest_login_log';
			$table_name    = $table_name_pre.date('Ym');

			$temp_row['Msg_text'] = '';
			
			$SQL->SelectDB('daily_log');
			if ( $SQL->checkTable($table_name) ) $temp_row['Msg_text'] = 'OK';
			
			if( 'OK' != $temp_row['Msg_text'] ) {

				$last_month= mktime( 0, 0, 0, date('m')-1, 1, date('Y') );
				$table_name= $table_name_pre.date( 'Ym', $last_month );
			}

			// 정상적으로 로그아웃 하지 못한 정보를 로그아웃
			$q = 'UPDATE `'.$table_name.'` SET `mid` = '.$row['mid'].' ';
			$q.= 'WHERE `lid` = "'.$_COOKIE['guest']['logid'].'"';

			$SQL->Query($q);

			foreach( $_COOKIE['guest'] as $k => $v ) {

				setcookie('guest['.$k.']', NULL, time()+0, '/', $this->c_domain);
			}
			
			$SQL->SelectDB('daily');
		}

		
		### 미승인 기업회원은 이벤트 필요없이 바로 이동###
		/*
		if($company_name && $row['level'] == "Z"){

			echo "<script language='javascript'>location.replace('".$this->goURL."');</script>";
			//echo "<meta http-equiv='Refresh' content='0; URL=".$this->goURL."'>";			
			//2013-10-22 고동진 : 브라우저 보안수준 강화시 메타태그 차단기능이 설정되면서 페이지 이동이 되지 않는다.			
			exit;

		}
		*/


		### 현재회원 로그인 카운트###
		/*
		$login_total_count = $SQL->OneValue("SELECT `login_count` FROM `log`.`member_login_count` WHERE `mid`='".$row['mid']."'");

		if($login_total_count <= 3 && $login_total_count){//회원가입 후 첫 로그인시,회원가입 후 두번째 로그인시,회원가입 후 세번째 로그인시


			### ? 가 있으면 &을 붙여주고 없으면 ? 붙여준다 출석체크 레이어를 띄우기위해서이다###
			if(eregi("\?", $this->goURL)){
				$this->goURL .= "&login_count=".$login_total_count;
			}else{
				$this->goURL .= "?login_count=".$login_total_count;
			}


		}elseif($today_join_count == "0"){//오늘 날짜 처음 로그인시

	

		}
		*/


		echo "<script language='javascript'>location.replace('".$this->goURL."');</script>";
        //echo "<meta http-equiv='Refresh' content='0; URL=".$this->goURL."'>";		
		//2013-10-22 고동진 : 브라우저 보안수준 강화시 메타태그 차단기능이 설정되면서 페이지 이동이 되지 않는다.

		exit;

	}

	// 로그아웃
	// **************************************************************************
	function doLogout($log_db = true) {

		$log_id= $_COOKIE[$this->user_mode]['logid'];
		$mid   = $_COOKIE[$this->user_mode]['mid'];
		
		if( $log_db && $log_id != "office" && !empty($log_id) ) {

			$SQL   = new Mysql();

			$log_id= mysqli_real_escape_string($SQL->conn, $log_id);
			$mid   = mysqli_real_escape_string($SQL->conn, $mid);

			$table_name_pre= 'member_login_log';
			$table_name    = $table_name_pre.date('Ym');

			$temp_row['Msg_text'] = '';
		
			$SQL->SelectDB('daily_log');
			if ( $SQL->checkTable($table_name) ) $temp_row['Msg_text'] = 'OK';

			if( 'OK' != $temp_row['Msg_text'] ) {

				$last_month= mktime( 0, 0, 0, date('m')-1, 1, date('Y') );
				$table_name= $table_name_pre.date( 'Ym', $last_month );
			}

			$SQL->Query('UPDATE `'.$table_name.'` SET `logout_date` = now(), `logout_time` = now(), `status` = "logout" WHERE `mid` = '.$mid.' AND `lid` = '.$log_id);
		}

		if( isset($_COOKIE[$this->user_mode]) ) {

			foreach($_COOKIE[$this->user_mode] as $key => $value) {
				setcookie($this->user_mode.'['.$key.']',NULL,time()+0,'/', $this->c_domain);
			}
		}

		### 출첵 파라미터값제거###
		/*
		$this->goURL = str_replace("attendance=no","",$this->goURL);
		
		### 뉴토리얼 제거###
		$this->goURL = str_replace("login_count=1","",$this->goURL);

		$this->goURL = str_replace("login_count=2","",$this->goURL);

		$this->goURL = str_replace("login_count=3","",$this->goURL);

		$this->goURL = str_replace("board_first_write=1","",$this->goURL);
		*/

		header('location: '.$this->goURL);

		exit;
	}

	// 손님 로그
	// **************************************************************************
	function doGuestLog() {

		$SQL = new Mysql();

		// REFERER 정보
		// **************************************************************************
		$referer = 'self';
		if( !empty($_SERVER['HTTP_REFERER']) ) $referer = $_SERVER['HTTP_REFERER'];

		$refer_domain = 'self';
		if( strstr($referer, 'http://') || strstr($referer, 'https://') ) {

			$refer_domain = explode('/', $referer);
			if ( isset($refer_domain[2]) ) $refer_domain = $refer_domain[2];
		}

		$this_referer = str_replace('\'','', $referer);
		$this_referer = str_replace('"','', $this_referer);
		//--------------------------------------------------------- REFERER 정보


		// 로그 테이블이 없으면 만든다.
		// *******************************************************************
		$table_name= 'guest_login_log'.date('Ym');
		
		$temp_row['Msg_text'] = '';
			
		if ( $SQL->checkTable($table_name) ) $temp_row['Msg_text'] = 'OK';
		
		if( $temp_row['Msg_text'] != 'OK' ) {

			$q = 'CREATE TABLE IF NOT EXISTS `'.$table_name.'` (';
			$q.= '`lid` int(10) unsigned NOT NULL AUTO_INCREMENT, ';
			$q.= '`mid` int(11) unsigned NOT NULL DEFAULT "0", ';
			$q.= '`login_date` date NOT NULL, ';
			$q.= '`login_time` time NOT NULL,';
			$q.= '`referer` varchar(200) NOT NULL,';
			$q.= '`referer_domain` varchar(80) NOT NULL,';
			$q.= '`thispage` varchar(255) NOT NULL,';
			$q.= '`agent` varchar(255) NOT NULL,';
			$q.= '`user_ip` char(15) NOT NULL,';
			$q.= ' PRIMARY KEY (`lid`),';
			$q.= ' KEY `mid` (`mid`)';
			$q.= ') ENGINE=MyISAM DEFAULT CHARSET=euckr COMMENT="게스트 접속 로그";';

			$SQL->Query($q);
		}
		//---------------------------------------- 로그 테이블이 없으면 만든다.


		// 로그 기록
		// **************************************************************************
		$this_referer = mysqli_real_escape_string($SQL->conn, $this_referer);
		$refer_domain = mysqli_real_escape_string($SQL->conn, $refer_domain);

		$q = 'INSERT INTO `'.$table_name.'` ';
		$q.= '(`login_date`, `login_time`, `referer`, `referer_domain`, ';
		$q.= '`thispage`, `agent`, `user_ip`) ';
		$q.= 'VALUES ';
		$q.= '( now(), now(), "'.$this_referer.'", "'.$refer_domain.'", "'.$_SERVER['PHP_SELF'].'", "'.$_SERVER['HTTP_USER_AGENT'].'", "'.$_SERVER['REMOTE_ADDR'].'")';

		$SQL->Query($q);
		//--------------------------------------------------------- 로그 기록


		// Guest 로그인 쿠키 생성
		// *******************************************************************
		$log_id  = 0;
		$result  = $SQL->Query('SELECT LAST_INSERT_ID()');
		$temp_row= mysqli_fetch_row($result);
		$log_id  = $temp_row[0];

		setcookie('guest[logid]', $log_id, 0, '/', $this->c_domain);
		setcookie('guest[join_date]', date('Y-m-d'), 0, '/', $this->c_domain);
		setcookie('ip_address', $_SERVER['REMOTE_ADDR'], 0, '/', $this->c_domain);
		//----------------------------------------------- Guest 로그인 쿠키 생성


		// 회원 로그인 쿠키 제거
		// **************************************************************************
		if( isset($_COOKIE['user']) ) {

			foreach($_COOKIE['user'] as $key => $value) {
				setcookie('user['.$key.']', NULL, time()+0, '/', $this->c_domain);
			}
		}
		//------------------------------------------------ 회원 로그인 쿠키 제거

		mysqli_close();
	}

	// 에러 발생시 js 로 메세지 보여줌
	// **************************************************************************
	function msgPopup($msg, $go = 'back', $target='self') {

		switch ($go) {

			case 'back':
				$act = "history.back()";
				break;

			case 'stop':
				break;

			default :
				$act = $target.'.location.href="'.$go.'"';
		}

		echo "
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=euc-kr\" />
		<script type='text/javascript'>
			alert('{$msg}');
			{$act};
		</script>
		";

		exit;
	}
}




?>
