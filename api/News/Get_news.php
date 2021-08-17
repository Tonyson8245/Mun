<?php
    function Unescape($str){
        return urldecode(preg_replace_callback('/%u([[:alnum:]]{4})/', 'UnescapeFunc', $str));
    }

    function UnescapeFunc($str){
        return iconv('UTF-16LE', 'UTF-8', chr(hexdec(substr($str[1], 2, 2))).chr(hexdec(substr($str[1],0,2))));
    }

    include $_SERVER["DOCUMENT_ROOT"] . "/util/db.php";
    header("Content-type:application/json");
    $page = "0";
    $page = $_GET['page'];

    $page = $page * 10;

    $sql = mysqli_query($con, "SELECT * FROM News ORDER BY news_datetime DESC LIMIT $page,10");

    $response = array();

    if(sql){
        if($row = mysqli_fetch_assoc($sql)>0) $response['result'] = "success";
        else $response['result'] = "failed";

        $list = array();

        while($row = mysqli_fetch_assoc($sql))
        {
            array_push($list, array(
                'news_href' => $row['news_ahref'],
                'news_title' => $row['news_title'],
                'news_writing' => $row['news_writing'],
                'news_datetime' => $row['news_datetime'],
                'news_img' => $row['news_img'],
                'news_idx' => $row['news_idx']
            ));
        }
        $response['list'] = $list;
    }
    else{
        $response['result'] = "error";
    }

    echo json_encode($response);
