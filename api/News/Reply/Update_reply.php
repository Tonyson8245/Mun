<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    header("Content-type:application/json");
    include_once $_SERVER["DOCUMENT_ROOT"]."/util/db.php";

    $reply_idx = $_POST['reply_idx'];
    $content = $_POST['content'];

    $sql = "UPDATE News_reply SET News_reply_content = '$content',News_reply_status = 1 WHERE News_reply_idx = '$reply_idx'";

    if (mysqli_query($con, $sql))
    {
        $response['result'] = "success";
        $response['message'] = "수정 완료";


    }
    else
    {
        $response['result'] = "failed";
        $response['message'] = "수정 실패";
    }
}
else
{
    $response['result'] = "failed";
}

echo json_encode($response);