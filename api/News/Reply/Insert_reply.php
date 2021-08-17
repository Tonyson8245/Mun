<?php


if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    header("Content-type:application/json");
    include_once $_SERVER["DOCUMENT_ROOT"]."/util/db.php";

    $news_idx = $_POST['news_idx'];
    $user_id = $_POST['user_id'];
    $content = $_POST['content'];
    $datetime = date("Y-m-d H:i:s");

    $sql = mysqli_query($con, "SELECT * FROM USER WHERE user_id = '$user_id'");
    $row = mysqli_fetch_assoc($sql);
    if($row>0) {
        $user_idx = $row['user_idx'];
    }

    $sql = "INSERT INTO News_reply(News_reply_news_idx, News_reply_user_idx,News_reply_content,News_reply_datetime) VALUES('$news_idx', '$user_idx','$content','$datetime')";

    if (mysqli_query($con, $sql))
    {
        $response['result'] = "success";
        $response['message'] = "추가 완료";
    }
    else
    {
        $response['result'] = "failed";
        $response['message'] = "추가 실패";
    }
}
else
{
    $response['result'] = "failed";
    $response['message'] = "POST로 오지 않음";
}

echo json_encode($response);