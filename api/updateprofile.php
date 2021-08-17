<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    header("Content-type:application/json");

    include_once $_SERVER["DOCUMENT_ROOT"]."/util/db.php";

    $user_id = $_POST['user_id'];
    $user_password = $_POST['user_password'];

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

    $sql = "UPDATE USER SET user_password = '$encrypted' WHERE user_id = '$user_id';";

    if (mysqli_query($con, $sql))
    {
        $response['result'] = "success";
    }
    else
    {
        $response['result'] = "failed";
    }
}
else
{
    $response['result'] = "failed";
}

echo json_encode($response);