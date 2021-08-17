<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db.php";

//$con = mysqli_connect("localhost", "dongo", "dongo", "db") or die("MySQL 접속 실패 !!");

$id = $_POST["id"];
$pw = $_POST["pw"];

$ret = mysqli_query($con, "SELECT * FROM USER WHERE user_id = '$id'");
$response = array();
$result = array();

function Decrypt($str, $secret_key='secret key', $secret_iv='secret iv') //복호화
{
    $key = hash('sha256', $secret_key);
    $iv = substr(hash('sha256', $secret_iv), 0, 32);
    return openssl_decrypt(
        base64_decode($str), "AES-256-CBC", $key, 0, $iv
    );
}
$secret_key = "123456789";
$secret_iv = "#@$%^&*()_+=-";



if (mysqli_num_rows($ret) > 0) {
    while($row = mysqli_fetch_assoc($ret)) {
        $raw_pw = $row['user_password'];
        $password = Decrypt($row['user_password'], $secret_key, $secret_iv);
        $name = $row['user_nickname'];
        $user_id = $row['user_id'];
        $user_birthday = $row['user_birthday'];
    }

    if($password == $pw || $pw == $raw_pw){
        $response["success"] = true;
        $response["message"] = "Login success";
        $response["result"] = array(
          "user_nickname"  => $name,
            "user_id" => $user_id,
            "user_birthday" => $user_birthday
        );
     }
    else {
        $response["success"] = false;
        $response["message"] = "Wrong password";
    }
}
else{
    $response["success"] = false;
    $response["message"] = "No user data";
}

echo json_encode($response);

?>

