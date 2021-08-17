<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    header("Content-type:application/json");

    include_once $_SERVER["DOCUMENT_ROOT"]."/util/db.php";

    $user_id = $_POST['user_id'];
    $user_birthday = $_POST['user_birthday'];
    $user_nickname = $_POST['user_nickname'];

    $newDate = date("Y-m-d", strtotime($user_birthday)); // 01-15-2019

    $sql = "UPDATE USER SET user_nickname = '$user_nickname',user_birthday = '$newDate' WHERE user_id = '$user_id';";

    if (mysqli_query($con, $sql))
    {
        $response['result'] = "$sql";
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