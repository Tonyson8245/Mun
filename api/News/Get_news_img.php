<?php
$url = $_GET['url'];
$idx = $_GET['idx'];
function getContents($webpage)
{
    $ch = curl_init($webpage);

    curl_setopt($ch,CURLOPT_FAILONERROR,true);
    curl_setopt($ch,CURLOPT_HEADER, 0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0");
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,300);
    curl_setopt($ch,CURLOPT_TIMEOUT,400);

    $webcontents = curl_exec($ch);

    curl_close($ch);

    return $webcontents;
}
function findStringBetweenAnB($dest, $A, $B)
{
    $firstFindIdx = strpos($dest,$A);
    $firstFindIdx = $firstFindIdx + strlen($A);
    $secondFindIdx = strpos($dest,$B,$firstFindIdx);

    $finalSearString = trim(substr($dest,$firstFindIdx,$secondFindIdx-$firstFindIdx));
    return $finalSearString;
}
function get_img($url){
    $news_detail = iconv("euc-kr", "utf-8",getContents($url));
    $img_url = findStringBetweenAnB($news_detail,"\"end_photo_org\"><img src=\"","\" alt=\"\"");
    return $img_url;
}//이미지 가져오기


$img_url = get_img($url);
$response = array();
if(empty($img_url)){
    $response['result'] = "failed";
    $response['idx'] = $idx;
}
else{
    $response['result'] = "success";
    $response['idx'] = $idx;
    $response['img_url'] = $img_url;
}

echo json_encode($response);