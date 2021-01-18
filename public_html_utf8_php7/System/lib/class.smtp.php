<?php
/*
제목:
만든이: 김호
변경일:

email: webmaster@hodragon.com
msn: webmaster@hodragon.com
homepage: www.hodragon.com
*/

/*---------------------------------------------------
사용예입니다.

include HOYA_LIB_PATH."/class_smtp.inc.php"; //메일 발송 클래스

1) 파일없을경우
$mh=new HoyaMail();
$mh->setFrom("webmaster@hodragon.com", "자유인"); //보내는 사람 지정
$mh->setReceive("hoyaspace@naver.com", "네이버"); //받는사람 지정
$mh->setReceive("test2@test.com", "test2"); //받는사람 복수지정
$mh->setReceive("test3@test.com", "test3"); //받는사람 복수지정
$mh->setSubject("제목이지롱");  // 메일 제목 지정
$mh->MESSAGE = "내용이지롱";  // 메일 본문 지정
$mh->send();

2) 파일있을 경우
$mh=new HoyaMail();
$mh->setFrom("webmaster@hodragon.com", "자유인"); //보내는 사람 지정
$mh->setReceive("hoyaspace@naver.com", "test1"); //받는사람 지정
$mh->setReceive("test2@test.com", "test2"); //받는사람 복수지정
$mh->setReceive("test3@test.com", "test3"); //받는사람 복수지정
$mh->setSubject("제목이지롱");  // 메일 제목 지정
$mh->MESSAGE = "내용이지롱";  // 메일 본문 지정
$mh->setFile(&$userfile, $userfile_name, $userfile_type, $userfile_size); // &에 주의
$mh->send();

--------------------------
함수목록

function setFrom($email, $name)
function setReceive($email, $name)
function setFile(&$attach, $filename, $filetype, $filesize)
function setBody($MESSAGE)
function setReturnPath($email) //안해도 됩니다.
function setContent($type) //안해도 됩니다.
function setSubject($subject)
function setCharset($set) //안해도 됩니다.
function setEncoding($type) //안해도 됩니다.
function send()

[변수목록]
$CHARSET (option)
$ENCTYPE (option)
$MESSAGE - 본문
-----------------------------------------------------
*/

class HoyaMail
{
	var $sp;														 // SMTP connection
	var $MESSAGE;											 // Mail 본문
	var $host;														 // SMTP host
	var $port;														 // SMTP port
	var $sMail;														 // Sender mail address;
	var $sName;														 // Sender Name;
	var $rMail;														 // Receiver mail address;
	var $rName;														 // Receiver Name;
	var $returnpath;											// Return path;
	var $subject;												  // Mail subject
	var $content_type;											// Mail content type
	var $CHARSET="euc-kr";									 // Charset
	var $ENCTYPE="8bit";									 // Character encoding type
	var $attach;												  // Attached file
	var $attach_name;											// Attached file name
	var $attach_type;											// Attached file type
	var $attach_size;											// Attached file size
	var $boundary="----=_Hoya_Mailer_";	// Default Boundary

	var $msg="<p><font face='굴림' size='3'><b>Error Message</b></font></p>";

	var $smtp_id = "websendmail";  //사용자아이디
	var $smtp_pwd = "&^%tpsemapdlf00qkfthd"; //사용자 패스워드

	### 기본 SMTP 서버 설정 ###
   function HoyaMail($host="smtp.humanworks.com", $port="25")
	{
		$this->host=$host;
		$this->port=$port;
	}

	### SMTP 서버 연결 ###
	function connect()
	{
		if($this->sp) {
			fclose($this->sp);
		} else {
			if(!$this->sp=fsockopen($this->host, $this->port, $errno, $errstr, 30)) {
				$msg="Error no : $errno<p>Error Message :<br>$errstr";
				$this->error($msg);
			}
		}
	}

	### 보내는 사람 설정 ###
	function setFrom($email, $name)
	{
		if($this->checkMail($email)) {
			$this->sMail=$email;
		} else {
			$this->error("보내는 사람의 메일주소가 형식에 어긋납니다.");
		}

		if($this->checkSpace($name)) {
			$this->sName=$name;
		} else {
			$this->error("보내는 사람의 이름이 형식에 어긋납니다.");
		}
	}

	### 받는 사람 설정 ###
	function setReceive($email, $name)
	{
		if($this->checkMail($email)) {
			$this->rMail[count($this->rMail)+1]=$email;
		} else {
			$this->error("받는 사람의 메일주소가 형식에 어긋납니다.");
		}
		if($this->checkSpace($name)) {
			$this->rName[count($this->rName)+1]=$name;
		} else {
			$this->error("받는 사람의 이름이 형식에 어긋납니다.");
		}
	}

	### 첨부파일 ###
	function setFile(&$attach, $filename, $filetype, $filesize)
	{
		$this->attach=$attach;
		$this->attach_name=$filename;
		$this->attach_type=$filetype;
		$this->attach_size=$filesize;
	}

	### 돌려 받을 메일 주소 ###
	function setReturnPath($email)
	{
		if($this->checkMail($email)) {
			$this->returnpath=$email;
		} else {
			$this->error("Return path의 메일주소가 형식에 어긋납니다.");
		}
	}

	### 메일 형식 설정 ###
	function setContent($type)
	{
		if($type == "text") {
			$this->content_type="text/plain";
		} elseif ($type == "html") {
			$this->content_type="text/html";
		} else {
			$this->error("Content-type 은 text, html 중 선택해 주세요");
		}
	}

	### 메일제목 ###
	function setSubject($subject)
	{
		if($this->checkSpace($subject)) {
			$this->subject=$subject;
		} else {
			$this->error("메일 제목이 형식에 어긋납니다.");
		}
	}

	/*
   Set Boundary
	*/
   function setBoundary()
	{
		  $this->boundary.=time();
	}

	### 돌려 받을 파일 종류 ###
	function getAttachedFileType()
	{
		if(!$this->attach_type) {
			return "application/octet-stream";
		}
		return $this->attach_type;
	}

   function getAttachedFile()
	{
		$fp=fopen($this->attach,"r");
		$encoded=fread($fp, $this->attach_size);
		$encoded=chunk_split(base64_encode($encoded));
		fclose($fp);
		return $encoded;
	}

	function putRcpt()
	{
		for($i=1; $i<sizeof($this->rMail)+1; $i++) {
			fputs($this->sp, "rcpt to: <".$this->rMail[$i].">\r\n");
			$retval = fgets($this->sp, 128);
		}
		return $retval;
	}

	function putTo()
	{
		fputs($this->sp, "To: ");
		for ($i=1; $i<sizeof($this->rMail)+1; $i++)
		{
			$str.="\"".$this->rName[$i]."\""." <".$this->rMail[$i].">";
			if($i < sizeof($this->rMail)) {
				$str=$str.",\r\n\t";
			} else {
				$str.="\r\n";
			}
		}
		fputs($this->sp, $str);
	}

  ### SMTP 닫기 ###
	function close()
	{
		fclose($this->sp);
	}

	function sendBody()
	{

//		if($this->content_type == "text/html") $this->MESSAGE=str_replace("\n", "<br>", $this->MESSAGE);

		fputs($this->sp, "Content-Type: ".$this->content_type.";\r\n");
		fputs($this->sp, "   charset=\"".$this->CHARSET."\"\r\n");
		fputs($this->sp, "Content-Transfer-Encoding: ".$this->ENCTYPE."\r\n\r\n");
		fputs($this->sp, $this->MESSAGE);
		fputs($this->sp, "\r\n");
	}

	### 메일 보내기 ###
	function send()
	{
		//만약 return path가 설정이 되지 않으면 보내는 사람 메일주소를 입력한다.
		if(!$this->returnpath)	$this->returnpath=$this->sMail;
		if(!$this->content_type)	$this->content_type="text/html";
		if(!$this->sName) $this->error("보내는 사람의 이름이 지정되지 않았습니다.");
		if(!$this->sMail) $this->error("보내는 사람의 메일이 지정되지 않았습니다.");
		if(!$this->rName) $this->error("받을 사람의 이름이 지정되지 않았습니다.");
		if(!$this->rMail) $this->error("받을 사람의 메일이 지정되지 않았습니다.");
		if(!$this->subject) $this->error("메일 제목이 지정되지 않았습니다.");
		if(!$this->MESSAGE) $this->error("메일 본문이 지정되지 않았습니다.");

		$this->connect();
		$this->setBoundary();

		fgets($this->sp, 128);
		fputs($this->sp, "helo HoyaMail\r\n"); fgets($this->sp, 128);
		

		 fputs($this->sp, "auth login\r\n"); 
		 fgets($this->sp,128); 
		 fputs($this->sp, base64_encode($this->smtp_id)."\r\n"); 
		 fgets($this->sp,128); 
		 fputs($this->sp, base64_encode($this->smtp_pwd)."\r\n"); 
		 fgets($this->sp,128); 
		
		fputs($this->sp, "mail from: <".$this->sMail.">\r\n");	$retval[0] = fgets($this->sp, 128);
		$this->putRcpt();
		

		
		fputs($this->sp, "data\r\n");										   fgets($this->sp, 128);
		fputs($this->sp, "Return-Path: <".$this->returnpath.">\r\n");
		fputs($this->sp, "From: ".$this->sName."<".$this->sMail.">\r\n");
		$this->putTo();
		fputs($this->sp, "Subject: ".$this->subject."\r\n");
		fputs($this->sp, "MIME-Version: 1.0\r\n");

		if($this->attach) {
			fputs($this->sp, "Content-Type: multipart/mixed;\r\n");
			fputs($this->sp, "   boundary=\"".$this->boundary."\"\r\n");
			fputs($this->sp, "\r\nThis is a multi-part message in MIME format\r\n\r\n");
			fputs($this->sp, "--".$this->boundary."\r\n");
			$this->sendBody();

			fputs($this->sp, "--".$this->boundary."\r\n");
			fputs($this->sp, "Content-Type: ".$this->getAttachedFileType().";\r\n");
			fputs($this->sp, "   name=\"".$this->attach_name."\"\r\n");
			fputs($this->sp, "Content-Transfer-Encoding: base64\r\n");
			fputs($this->sp, "Content-Disposition: attachment;\r\n");
			fputs($this->sp, "   filename=\"".$this->attach_name."\"\r\n\r\n");
			fputs($this->sp, $this->getAttachedFile());
			fputs($this->sp, "\r\n");
			fputs($this->sp, "--".$this->boundary."--\r\n");
		} else {
			$this->sendBody();
		}

		fputs($this->sp, "\r\n.\r\n");
		$retval[1]=fgets($this->sp, 128);
		$this->close();

		if (!ereg("^250", $retval[0]) || !ereg("^250", $retval[1]))
		{
			$errormsg="메일을 보내지 못하였습니다.<br>";
			$errormsg.=$retval[0]."<br>".$retval[1]."<br><br><br>";
			$this->error($errormsg);
		}
	}

	### 메일주소 유효성 검사 ###
	function checkMail($email)
	{
		if($this->checkSpace($email)) {
			if(!ereg("(^[_0-9a-zA-Z-]+(\.[_0-9a-zA-Z-]+)*@[0-9a-zA-Z-]+(\.[0-9a-zA-Z-]+)*$)",trim($email))) return false;
	  } else {
			return false;
		}
		return true;
	}

	### 공백 체크 ###
	function checkSpace($str)
	{
		if(!ereg("([^[:space:]]+)",trim($str))) return false;
	  return true;
	}

	### 오류메세지 출력 ###
	function error($msg)
	{
	  //die("<b>".$this->msg.$msg."</b>");
	  echo ("<b>".$this->msg.$msg."</b>");
	}
}

?>
