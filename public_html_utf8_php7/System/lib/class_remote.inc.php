<?php




function new_curlFileUpload($uploadFile, $remote_url, $upload_path=NULL, $rename=NULL)
{

	$postData['upfile'] = "@".$_FILES[$uploadFile]['tmp_name'];


	if(NULL != $upload_path) $postData['save_path']= $upload_path;

	if(NULL != $rename) $postData['save_file']= $rename;

	$ch = curl_init(); //세션초기화

	curl_setopt($ch, CURLOPT_URL, $remote_url);

	curl_setopt($ch, CURLOPT_POST, true);

	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

	curl_exec($ch);//실행

	$result = curl_getinfo($ch);

	curl_close($ch); //닫기
	
	if($result[0] == "notfile"){
		PopupMsg("죄송합니다. 해당 파일은 업로드 할 수 없는 파일 입니다.");
	}


	return $result[0];

}


function new_curlFileUpload_arr($uploadFile, $remote_url, $arrFile, $upload_path=NULL, $rename=NULL)
{
		//배열일 경우 파일명을 $arrFile로 가져와서 업로드
		$ch = curl_init(); //세션초기화	
	
		$postData['upfile'] = "@".$arrFile;

		if(NULL != $upload_path) $postData['save_path']= $upload_path;

		if(NULL != $rename) $postData['save_file'] = $rename;

		
		curl_setopt($ch, CURLOPT_URL, $remote_url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);	
		
		$result = curl_getinfo($ch);
		curl_exec($ch);//실행
		
		
		
		if($result[0] == "notfile"){
			PopupMsg("죄송합니다. 해당 파일은 업로드 할 수 없는 파일 입니다.");
		}
		return $result[0];
		
		
		unset($postData);

		curl_close($ch); //닫기

}


/*
---------------------------------------------------------------------------------------------------
	[curl을 이용한 파일 업로드 함수] ver.0.9.0
---------------------------------------------------------------------------------------------------
개발일: 2009-01-16
개발자: 김호

curlFileUpload(보낼파일명경로,받을서버URL,저장할 위치,저장파일명);

[받는서버 프로세서]

/System/proc/get_curlfile.proc.php 참조

 단 form 으로 만 전송 가능.

*/
function curlFileUpload($uploadFile, $remote_url, $upload_path=NULL, $rename=NULL)
{

  $postData['upfile']= "@".$uploadFile;

	if(NULL != $upload_path) $postData['save_path']= $upload_path;

	if(NULL != $rename) $postData['save_file']= $rename;

	$ch = curl_init(); //세션초기화

	curl_setopt($ch, CURLOPT_URL, $remote_url);

	curl_setopt($ch, CURLOPT_POST, true);

	curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

	curl_exec($ch);//실행

	$result = curl_getinfo($ch);

	curl_close($ch); //닫기

	return $result;

}

/*
---------------------------------------------------------------------------------------------------
	[curl을 이용한 데이터교환 함수] ver.1.0.0
---------------------------------------------------------------------------------------------------
개발일: 2009-06-24
개발자: 김호

curlRemoteFile(받을서버URL);


*/
function curlRemoteFile($remote_url)
{

	$ch = curl_init(); //세션초기화

	curl_setopt($ch, CURLOPT_URL, $remote_url);
	curl_setopt($ch, CURLOPT_POST, 0);
  curl_setopt($ch, CURLOPT_REFERER, "");
  curl_setopt($ch, CURLOPT_TIMEOUT, 3);
	$result = curl_exec($ch);//실행
	$cinfo = curl_getinfo($ch);

	curl_close($ch); //닫기

	if($cinfo['http_code'] != 200) {

     return "error";

   }

   return $result;

}

?>
