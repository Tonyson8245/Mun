<?php
    include_once $_SERVER["DOCUMENT_ROOT"]."/util/db.php";
    $target_url = $_GET['url'];
    function getContents($webpage)
    {
        $ch = curl_init($webpage);

        curl_setopt($ch,CURLOPT_FAILONERROR,true);
        curl_setopt($ch,CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0");
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,300);
        curl_setopt($ch,CURLOPT_TIMEOUT,400);

        $webcontents = curl_exec($ch);

        curl_close($ch);

        return $webcontents;
    }
    function findStringBetweenAnB($dest, $A, $B)
    {
        $firstFindIdx = strpos($dest,$A);
        $firstFindIdx = $firstFindIdx + strlen($A);
        $secondFindIdx = strpos($dest,$B,$firstFindIdx);

        $finalSearString = trim(substr($dest,$firstFindIdx,$secondFindIdx-$firstFindIdx));
        return $finalSearString;
    }

    $raw_contents = iconv("euc-kr", "utf-8",getContents($target_url));
    $raw_article = findStringBetweenAnB($raw_contents,"<!-- // TV플레이어 -->","<!-- // 본문 내용 -->");
    $raw_article=preg_replace("!<span class=\"end_photo_org\">(.*?)<\/span>!is","",$raw_article);

    $article = strip_tags( $raw_article,"<br>");
    $article=preg_replace("!\[(.*?)<br>!is","",$article);
    $article = substr($article,strpos($raw_article,"{}")+strlen("{}"));

    $article = substr($article,strpos($article,"= ")+strlen("= "));

    $response = array();

    if($article===false){
        $response['result'] = "failed";
    }
    else{
        $response['result'] = "success";
        $response['text'] = $article;
        $sql = mysqli_query($con, "SELECT * FROM News WHERE news_ahref = '$target_url'");
        $row = mysqli_fetch_assoc($sql);
        if($row>0) {
                $response['news_idx'] = $row['news_idx'];
        }
        else{
            $response['news_idx'] = "no_news_idx";
        }

    }
    echo json_encode($response);

