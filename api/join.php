<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    header("Content-type:application/json");

    include_once $_SERVER["DOCUMENT_ROOT"]."/util/db.php";

    $user_id = $_POST['user_id'];
    $user_password = $_POST['user_password'];
    $user_nickname = $_POST['user_nickname'];
    $user_phonenum = $_POST['user_phonenum'];
    $user_birthday = $_POST['user_birthday'];
    $user_datatime = date("Y-m-d H:i:s");


    $newDate = date("Y-m-d", strtotime($user_birthday)); // 01-15-2019


    function Encrypt($str, $secret_key='secret key', $secret_iv='secret iv')//암호화
    {

        $key = hash('sha256', $secret_key);
        $iv = substr(hash('sha256', $secret_iv), 0, 32)    ;
        return str_replace("=", "", base64_encode(
                openssl_encrypt($str, "AES-256-CBC", $key, 0, $iv))
        );
    }

    $secret_key = "123456789";
    $secret_iv = "#@$%^&*()_+=-";
    $encrypted = Encrypt($user_password, $secret_key, $secret_iv);

    $sql = "INSERT INTO USER(user_id,user_nickname,user_password,user_phonenum,user_joindatetime,user_birthday) VALUES('$user_id','$user_nickname','$encrypted','$user_phonenum','$user_datatime','$newDate');";

    if ($ret = mysqli_query($con, $sql))
    {
        $response['result'] = "success";
        $response['message'] = "추가 완료";
    }
    else
    {
        $response['result'] = "failed";
        $response['message'] = $ret;
    }
}
else
{
    $response['result'] = "failed";
    $response['message'] = "POST로 오지 않음";
}

echo json_encode($response);