<?php
//    include "/var/www/html/api/News/Class.php";
//    function getContents($webpage)
//    {
//        $ch = curl_init($webpage);
//
//        curl_setopt($ch,CURLOPT_FAILONERROR,true);
//        curl_setopt($ch,CURLOPT_HEADER, 0);
//        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
//        curl_setopt($ch,CURLOPT_USERAGENT,"Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0");
//        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,300);
//        curl_setopt($ch,CURLOPT_TIMEOUT,400);
//
//        $webcontents = curl_exec($ch);
//
//        curl_close($ch);
//
//        return $webcontents;
//    }
//    function findStringBetweenAnB($dest, $A, $B)
//    {
//        $firstFindIdx = strpos($dest,$A);
//        $firstFindIdx = $firstFindIdx + strlen($A);
//        $secondFindIdx = strpos($dest,$B,$firstFindIdx);
//
//        $finalSearString = trim(substr($dest,$firstFindIdx,$secondFindIdx-$firstFindIdx));
//        return $finalSearString;
//    }
//    function get_article($dest){
//        $A_aid = 'news001,';
//        $B_aid = '\',nclicks:\'fls.cmt\'}">';
//
//        $A_href = '<a href="';
//        $B_href = '"class="nclicks(cnt_flashart)">';
//
//        $A_title = '<strong>';
//        $B_title = '</strong>';
//
//        $A_writing = '<span class="writing">';
//        $B_writing = '</span>';
//
//        $A_date = '<span class="date">';
//        $B_date = '</span>';
//
//        $aid = findStringBetweenAnB($dest,$A_aid,$B_aid);
//        $href = findStringBetweenAnB($dest,$A_href,$B_href);
//        $title = findStringBetweenAnB($dest,$A_title,$B_title);
//        $writing = findStringBetweenAnB($dest,$A_writing,$B_writing);
//        $str_date = findStringBetweenAnB($dest,$A_date,$B_date);
//
//        $date = str_replace(".","-",substr($str_date,0,10));
//
//
//        if(substr($str_date,12,6)==="오전"){
//            $ampm = 0;
//            $hour = findStringBetweenAnB($str_date,"오전 ",":");
//        }
//        else{
//            $ampm = 12;
//            $hour = findStringBetweenAnB($str_date,"오후 ",":");
//        }
//        if($hour==12) $hour = $hour-12;
//        $hour =  $hour + $ampm;
//        $minute = substr($str_date,strpos($str_date,":")+1,2);
//
//
//        $datetime = date("Y-m-d H:i",strtotime($date.$hour.":".$minute));
//
//        return $article = new Article($aid,$href,$title,$writing,$datetime);
//    }
//    function get_img($url){
//        $news_detail = iconv("euc-kr", "utf-8",getContents($url));
//        $img_url = findStringBetweenAnB($news_detail,"\"end_photo_org\"><img src=\"","\" alt=\"\"");
//        return $img_url;
//    }//이미지 가져오기
//
//    function insert_article($article)
//    {
//        include "/var/www/html/util/db.php";
//
//        $sql = mysqli_query($con, "SELECT * FROM News WHERE news_aid = '$article->aid';");
//        $total = mysqli_num_rows($sql);
//
//        $img_url = get_img($article->ahref);
//
//        $new_title = $article->title;
//
//
//        if($article->aid!=="") {
//            if ($total == 0) {
//                mysqli_query($con, "INSERT INTO News(news_aid,news_ahref,news_title,news_writing,news_datetime,news_img)
//            VALUES('$article->aid', '$article->ahref','$new_title','$article->writing','$article->date','$img_url');");
//            }// 자료가 없을 경우 추가
//            else {
//                mysqli_query($con, "UPDATE News SET news_ahref = '$article->ahref', news_title = '$new_title', news_writing = '$article->writing',
//                news_datetime = '$article->date', news_img = '$img_url' WHERE news_aid = '$article->aid';");
//            }
//        }
//
//    }// 기사 mysql 안에 입력
//    $now_date = date("Ymd");
//
//    for($i=0;$i<10;$i++) {
//        $newsmain = getContents("https://news.naver.com/main/list.naver?mode=LPOD&sid2=140&sid1=001&mid=sec&oid=001&isYeonhapFlash=Y&date=".$now_date ."&page=".$i);
//        $newsmain = iconv("euc-kr", "utf-8", $newsmain);
//        $news_list .= findStringBetweenAnB($newsmain, '<ul class="type02">', '</ul>');
//    }// 전체 리스트 불러오기 9*10 = 90개
//
//    for($i=0;$i<90;$i++){
//        $A = '<li class="_rcount" data-comment="{gno:';
//        $B = '</li>';
//
//        $temp_article = findStringBetweenAnB($news_list,$A,$B); // 기사 하나만 추출
//        insert_article(get_article($temp_article)); //기사를 DB에 저장
//        $news_list = substr($news_list,strlen($temp_article)); // 추출된 기사를 제외한 나머지 기사
//    }
//
//    error_log(date("Y-m-d H:i:s").": New news receive"."\n","3","/var/www/html/log/News.log");
?>