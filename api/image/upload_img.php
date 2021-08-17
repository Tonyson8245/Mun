<?php
$file_path = $_SERVER['DOCUMENT_ROOT']."/storage/profile_img/";
$var = $_POST['result'];
$file_path = $file_path . basename( $_FILES['uploaded_file']['name']);

$ret = move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path);
if($ret) {
    $result =array("result" => "success", "value" => $_FILES['uploaded_file']['name']);
} else{
    $result = array("result" => "error");
}

echo json_encode($result);
?>