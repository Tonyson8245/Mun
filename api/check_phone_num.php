<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db.php";

$user_phonenum = $_POST["phone_num"];

$ret = mysqli_query($con, "SELECT * FROM USER WHERE user_phonenum = '$user_phonenum'");

$response = array();
$response["result"] = false;

if (mysqli_num_rows($ret) == 0) {
    // echo "성공";
    $response["result"] = "success";
}
else{
    $response["result"] = "failed";
}


echo json_encode($response);
?>