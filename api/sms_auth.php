<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db.php";

$phone_num = $_POST["phone_num"];

$sID = "ncp:sms:kr:265178095549:sms_test"; // 서비스 ID
$smsURL = "https://sens.apigw.ntruss.com/sms/v2/services/".$sID."/messages";
$smsUri = "/sms/v2/services/".$sID."/messages";
$sKey = "68b7f969e2144d80af9658e4de7f01c7";//"{서비스 ID Secret Key}";

$accKeyId = "pLTY5UivqtfcvOj8c274";//"{인증키 key id}";
$accSecKey = "HWoErbyvCP2OrlcfCy12YER4o6WPi0RW4de3yKwE";//"{인증키 secret key}";

$sTime = floor(microtime(true) * 1000);

$num = sprintf('%06d',rand(000000,999999));

$user_id = $_GET['user_id'];
$response["response"] = "success";
$date = date("Y-m-d H:i:s");

$count = 0;

$ret = mysqli_query($con, "SELECT * FROM sms_auth_check WHERE phonenum = '$phone_num';");

if (mysqli_num_rows($ret) == 0) {
    $sql = "INSERT INTO sms_auth_check(phonenum,lastest_request_time) VALUES('$phone_num', '$date');";
    mysqli_query($con, $sql);
}
else{
    $row = mysqli_fetch_array($ret);
    $count = $row['auth_count'];
    $firstDate  = new DateTime($row['lastest_request_time']);
    $secondDate = new DateTime($date);

    $intvl = $firstDate->diff($secondDate);

    if($intvl->days>0) $count = 0;
    $count ++;

    if($count<=4){
        $sql = "UPDATE sms_auth_check SET auth_count = '$count',lastest_request_time='$date' WHERE phonenum = '$phone_num'";
        mysqli_query($con, $sql);
    }
}

if($count<=4){
    $content = "[TORON] 인증번호[".$num."]를 입력해주세요.";

    // The data to send to the API
    $postData = array(
        'type' => 'SMS',
        'countryCode' => '82',
        'from' => '01082458698', // 발신번호 (등록되어있어야함)
        'contentType' => 'COMM',
        'content' => $content,
        'messages' => array(array('content' => $content, 'to' => $phone_num))
    );

    $postFields = json_encode($postData) ;

    $hashString = "POST {$smsUri}\n{$sTime}\n{$accKeyId}";
    $dHash = base64_encode( hash_hmac('sha256', $hashString, $accSecKey, true) );

    $header = array(
        // "accept: application/json",
        'Content-Type: application/json; charset=utf-8',
        'x-ncp-apigw-timestamp: '.$sTime,
        "x-ncp-iam-access-key: ".$accKeyId,
        "x-ncp-apigw-signature-v2: ".$dHash
    );

    // Setup cURL
    $ch = curl_init($smsURL);
    curl_setopt_array($ch, array(
        CURLOPT_POST => TRUE,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_HTTPHEADER => $header,
        CURLOPT_POSTFIELDS => $postFields
    ));

    $response = curl_exec($ch);

    $answer = array();
    $answer['rand_num'] = $num;
    $answer['phone_num'] = $phone_num;
}
else{
    $answer = array();
    $answer['rand_num'] = "failed";
    $answer['phone_num'] = $phone_num;
}

echo json_encode($answer);
?>