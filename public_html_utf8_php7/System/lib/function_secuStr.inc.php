<?php
/*
---------------------------------------------------------------------------------------------------
Program NAME :
Content : 보안을 위한 문자열 암호화 인코더, 디코더 64bit
Version :
File Name : function_secuStr.inc.php
Charset : euc-kr
Directory : /System/lib
URI : http://fg.gameangel.com/System/lib/function_secuStr.inc.php
---------------------------------------------------------------------------------------------------
[사용 DB정보]

DB :
Tables(Fields)

---------------------------------------------------------------------------------------------------
[개발자정보]

개발자 : 김호
개발일 : 2009.06.22
email: webmaster@hodragon.com
msn: webmaster@hodragon.com
homepage: www.hodragon.com
support : www.hoyaboard.com
---------------------------------------------------------------------------------------------------
[상세설명]

내장함수 base64_encode 를 기초으로 하고 있다.

숫자형은 인코딩 할 수 없으므로 반드시 문자형으로 바꿔서 인코딩 하고 디코딩 후에는 숫자형으로 전환 해서 사용해야 한다.

주의! global 변수 $keystr 값이 encode 하는 쪽과 decode 하는 쪽이 같아야한다.


[사용방법]

$a = "12345678901234567890";

$enStr = encode64($a);

$deStr = decode64($enStr);

echo "\$enStr : $enStr , \$deStr : $deStr ";

$deStr_tmp = (integer)$deStr;

if(TRUE == is_numeric($deStr_tmp) && 0 !== $deStr_tmp) $deStr = $deStr_tmp; // 숫자형 일때

*/

//$keystr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/="; //base64_encode

$keystr = "CfgstuDWXopqr67Pyz012QA89+TIJEnHNOB5VKFjklmUG/=RShivwx34LMabcYZde"; //gameangel 전용 base64 encoder : 절대로 바꾸면 안됨!

// 문자열 인코딩 - 문자열만 인코딩 되므로 숫자형은 따옴 감싸서 보내야 한다.

function encode64($input)
{
	global $keystr;

	$i = 0;

	do {

		$chr1 = ord($input[$i++]);
		$chr2 = ord($input[$i++]);
		$chr3 = ord($input[$i++]);

		$enc1 = $chr1 >> 2;

		$enc2 = (($chr1 & 3) << 4) | ($chr2 >> 4);

		$enc3 = (($chr2 & 15) << 2) | ($chr3 >> 6);

		$enc4 = $chr3 & 63;

		if(FALSE == is_numeric($chr2)) {

			$enc3 = $enc4 = 64;

		} else if (FALSE == is_numeric($chr3)) {

			$enc4 = 64;

		}

		$output .= substr($keystr,$enc1,1).substr($keystr,$enc2,1).substr($keystr,$enc3,1).substr($keystr,$enc4,1);

	} while ($i < strlen($input));

	return trim($output);

}


/*
base64 decoder
*/

function decode64($input)
{

	global $keystr;

	$i = 0;

  do {

		$enc1 = strpos($keystr, substr($input,$i++,1));
		$enc2 = strpos($keystr, substr($input,$i++,1));
		$enc3 = strpos($keystr, substr($input,$i++,1));
		$enc4 = strpos($keystr, substr($input,$i++,1));

		$chr1 = ($enc1 << 2) | ($enc2 >> 4);
		$chr2 = (($enc2 & 15) << 4) | ($enc3 >> 2);
		$chr3 = (($enc3 & 3) << 6) | $enc4;

		$output .= chr($chr1);

		if($enc3 != 64) {

			$output .= chr($chr2);

		}

		if($enc4 != 64) {

			$output .= chr($chr3);

		}

	} while ($i < strlen($input));

   return trim($output);

}


?>
