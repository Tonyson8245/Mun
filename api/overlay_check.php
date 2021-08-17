<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db.php";

$response = array();

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $response["response"] = "success";
    $ret = mysqli_query($con, "SELECT * FROM USER WHERE user_id = '$user_id'");
    if (mysqli_num_rows($ret) == 0) {
        $response["result"] = true;
    }
    else {
        $response["result"] = false;
    }
}
else if (isset($_GET['user_nickname'])){
    $user_nickname = $_GET['user_nickname'];
    $response["response"] = "success";
    $ret = mysqli_query($con, "SELECT * FROM USER WHERE user_nickname = '$user_nickname'");
    if (mysqli_num_rows($ret) == 0) {
        $response["result"] = true;
    }
    else {
        $response["result"] = false;
    }
}
else   $response["response"] = "failed";



//$user_phonenum = $_POST["phone_num"];
//
//$ret = mysqli_query($con, "SELECT * FROM USER WHERE user_phonenum = '$user_phonenum'");
//
//$response = array();
//$response["result"] = false;
//
//if (mysqli_num_rows($ret) == 0) {
//    // echo "성공";
//    $response["result"] = "success";
//}
//else{
//    $response["result"] = "failed";
//}


echo json_encode($response);
?>