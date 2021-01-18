<?php
/*
---------------------------------------------------------------------------------------------------
Program NAME : 호라곤 암호화 인코딩 디코딩
Content : 보안용 파일
Version :
File Name : horagon_encoder.inc.php
Charset :
Directory : /System/lib
URI :
---------------------------------------------------------------------------------------------------
[사용 DB정보]

DB :
Tables(Fields)

---------------------------------------------------------------------------------------------------
[개발자정보]

개발자 : 김호
개발일 : 2009-03-24
email: webmaster@hodragon.com
msn: webmaster@hodragon.com
homepage: www.hodragon.com
support : www.hoyaboard.com
---------------------------------------------------------------------------------------------------
[상세설명]

랭킹게임과 통신할때 숫자값을 암호화 해서 주고 받을때 사용한다.

30271.11111.55391

scoreDecode("48657.11111.96529"); //원소 키, 원소키길이, 1차원배열키, 거짓값

$a = numDecode(base64_decode(NDAxLjExMS4wODE=));

*/

$sgameangel[0] = array("z", "a", "c", "b", "d", "k", "a", "a", 2, "n", "h", 4, 3, "d", "g", 5, "o", 8, "b", 0, 6, 7, "r", 1, 9, "m", "c");
$sgameangel[1] = array("b", "g", "d", "r", 7, "k", 0, "n", "c", "h", "z", "b", 6, 5, "d", 8, 1, "a", 4, "a", 2, "m", "o", 9, "a", 3, "c");
$sgameangel[2] = array("n", "m", 1, "z", "c", 0, 5, 7, "a", "a", "b", "a", "d", 8, "h", "b", "d", 2, 4, "o", "r", 3, "c", "k", 9, 6, "g");
$sgameangel[3] = array("d", "g", "a", "d", "k", "b", "c", 6, 5, 1, 4, 2, "o", "c", 9, "m", "z", 3, "h", 8, "a", "n", 7, 0, "r", "a", "b");
$sgameangel[4] = array(6, "z", "c", "k", 7, "b", "r", "a", "m", "h", "b", "c", 3, "a", "n", 8, 0, 5, 4, "g", "a", 2, "d", "o", 9, "d", 1);
$sgameangel[5] = array("c", "b", 5, 0, "r", 3, "a", 1, 9, "o", "z", 8, "a", "k", 4, "b", 2, "g", "n", "h", "c", "d", "d", 6, "a", 7, "m");
$sgameangel[6] = array("r", 0, "d", 4, "c", 8, 2, 9, "m", "b", 6, 1, "g", "b", "a", "a", "o", "c", 7, "a", 5, "n", "d", "h", "k", 3, "z");
$sgameangel[7] = array("d", 3, "a", "a", 6, "c", "m", "k", "o", "z", 1, 9, 4, "r", 7, 2, 5, "b", "b", "n", "h", "d", 8, "g", "c", "a", 0);
$sgameangel[8] = array("a", 1, 2, 0, 9, 3, "a", "c", "d", 6, "z", "r", "b", 7, "a", "k", "c", "g", 8, 4, "n", "h", "m", "o", "b", "d", 5);
$sgameangel[9] = array("m", "n", 6, 1, "g", 3, "d", "r", 9, "a", "z", "k", 8, "d", "o", "a", "b", "c", "a", "b", 7, 2, 5, 0, "c", 4, "h");

$snum[0] = array("q", "g", "a", "d", "k", "b", "c", 6, 5, 1, 4, 2, "o", "n", 9, "m", "z", 3, "h", 8, "a", "n", 7, 0, "r", "a", "x");
$snum[1] = array("r", 0, "d", 4, "c", 8, 2, 9, "m", "b", 6, 1, "g", "b", "a", "a", "o", "c", 7, "a", 5, "n", "d", "h", "k", 3, "z");
$snum[2] = array(6, "z", "c", "k", 7, "b", "r", "a", "m", "h", "b", "c", 3, "a", "n", 8, 0, 5, 4, "g", "a", 2, "d", "o", 9, "d", 1);
$snum[3] = array("d", 3, "a", "a", 6, "c", "m", "k", "o", "z", 1, 9, 4, "r", 7, 2, 5, "b", "b", "n", "h", "d", 8, "g", "c", "a", 0);
$snum[4] = array("c", "b", 5, 0, "r", 3, "a", 1, 9, "o", "z", 8, "a", "k", 4, "b", 2, "g", "n", "h", "c", "d", "d", 6, "a", 7, "m");
$snum[5] = array("b", "g", "d", "r", 7, "k", 0, "n", "c", "h", "z", "b", 6, 5, "d", 8, 1, "a", 4, "a", 2, "d", "o", 9, "a", 3, "c");
$snum[6] = array("m", "n", 6, 1, "g", 3, "d", "r", 9, "a", "z", "k", 8, "d", "o", "a", "b", "c", "a", "b", 7, 2, 5, 0, "c", 4, "h");
$snum[7] = array("a", 1, 2, 0, 9, 3, "a", "j", "d", 6, "z", "r", "b", 7, "a", "k", "c", "g", 8, 4, "n", "h", "m", "o", "b", "d", 5);
$snum[8] = array("z", "a", "c", "b", "d", "k", "c", "a", 2, "n", "h", 4, 3, "d", "g", 5, "o", 8, "b", 0, 6, 7, "r", 1, 9, "m", "c");
$snum[9] = array("n", "l", 1, "z", "c", 0, 5, 7, "a", "a", "b", "a", "d", 8, "h", "o", "d", 2, 4, "o", "r", 3, "c", "k", 9, 6, "g");

function numDecode($my_num,$array_key)
{

	global $sgameangel, $snum;

	$m = 0;

	list($score, $index, $rand) = explode(".",$my_num);

	if(strlen($score) < strlen($index) || strlen($index) != strlen($rand)) return FALSE;

	for($i = 0; $i < strlen($index); $i++) {

		$key1 = substr($rand, $i, 1);

		$n = substr($index, $i, 1);

		$key2 = substr($score, $m, $n);

		$result .= ${$array_key}[$key1][$key2]; //1차원 키, 원소키

		$m += $n;

	}

	return $result;

}



function numEncode($my_num,$array_key)
{

	global $sgameangel, $snum;

	$my_len = strlen($my_num); //자리수

	$r = rand(0,9); //0~9 중에 랜덤

	for($i=0; $i < $my_len; $i++) {

		$this_key = array_search(substr($my_num, $i,1), ${$array_key}[$r]); //한자씩 찾는다. - 인코딩한 키 값
		$en_key .= $this_key;
		$en_len .= strlen($this_key); //키 자리수
		$en_ran .= $r; //랜덤하게 뽑은 배열 값

		$en_hack .= rand(1,2); //해킹 방지를 위한 허수 값

		$r = rand(0,9); //0~9 중에 랜덤

	}

	return $en_key.".".$en_len.".".$en_ran.".".$en_hack;

}


/*

[테스트]

URL http://gamerank.gameangel.com/System/lib/horagon_encoder.inc.php

$m = date("YmdHis");

$a = numEncode($m,"sgameangel");
$b = base64_encode($a);
$c = base64_decode($b);
$d = numDecode("6814100.11221.00171","sgameangel");

echo "인코딩전:".$m;
echo "<br/> 인코딩:".$a;
echo "<br/> 64base 인코딩:".$b;
echo "<br/> 64base 디코딩:".$c;
echo "<br/> 디코딩:".$d;


$b = "OS4xLjMuMg==";
echo $c = base64_decode($b);
echo "<br>mid:";
echo $d = numDecode($c,"sgameangel");
*/

?>
