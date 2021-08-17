<?php
include_once $_SERVER["DOCUMENT_ROOT"]."/util/db.php";
$type = $_GET['type'];

$response = array();

if ($type=="service") {
    $response["result"] = "success";
    $response['data'] = "service!";
}
else if($type=="info"){
    $response["result"] = "success";
    $response['data'] = "info!";
}
else {
    $response['result'] = "failed";
}

echo json_encode($response);
?>