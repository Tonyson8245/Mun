<?php

    include_once $_SERVER["DOCUMENT_ROOT"]."/util/db.php";
    $news_idx = $_GET['news_idx'];
    $page = $_GET['page'];
    $sort = $_GET['sort'];

    if($sort==="recent") {
        $sql = mysqli_query($con, "SELECT * FROM News_reply INNER JOIN USER ON News_reply_user_idx = user_idx WHERE News_reply_news_idx='$news_idx' AND NOT News_reply_status=-1 ORDER BY News_reply_datetime DESC LIMIT $page,5;");
    }
    else {
        $sql = mysqli_query($con, "SELECT * FROM News_reply INNER JOIN USER ON News_reply_user_idx = user_idx WHERE News_reply_news_idx='$news_idx' AND NOT News_reply_status=-1 ORDER BY News_reply_datetime ASC LIMIT $page,5;");
    }
    $total_sql =  mysqli_query($con, "SELECT COUNT(*) FROM News_reply WHERE News_reply_news_idx = '$news_idx' AND NOT News_reply_status=-1 ; ");
    $response = array();

    if($sql){
        $response['result'] = "success";
        $response['total'] = mysqli_fetch_assoc($total_sql )['COUNT(*)'];
        $reply = array();
        while($row = mysqli_fetch_assoc($sql))
        {
            array_push($reply, array(
                'content' => $row['News_reply_content'],
                'datetime' => $row['News_reply_datetime'],
                'user_nickname' => $row['user_nickname'],
                'user_profile_img'=> $row['user_id'],
                'reply_status'=> $row['News_reply_status'],
                'reply_idx' => $row['News_reply_idx']
            ));
        }
        $response['reply'] = $reply;
    }
    else $response['result'] = "failed";

    echo json_encode($response);