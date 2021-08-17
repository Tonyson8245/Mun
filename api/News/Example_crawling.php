<!--https://www.google.com/search?q=%EC%84%9C%EC%9A%B8+%EB%82%A0%EC%94%A8&oq=%EC%84%9C%EC%9A%B8+%EB%82%A0%EC%94%A8&aqs=chrome..69i57j0i512l9.3984j1j4&sourceid=chrome&ie=UTF-8-->
<!--1. 구글 검색 페이지 소스를 가지고 오는 것-->
<!--2. 가지곤 온 소스에서 원하는 내용만 추출-->
<!--3. 추출한 내용을 메일로 발송-->

<?php
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

    $googleWeatherSource = getContents("https://www.google.com/search?q=%EC%84%9C%EC%9A%B8+%EB%82%A0%EC%94%A8&oq=%EC%84%9C%EC%9A%B8+%EB%82%A0%EC%94%A8&aqs=chrome..69i57j0i512l9.3984j1j4&sourceid=chrome&ie=UTF-8");

    $A = '<div class="fBgPuf">   <div>     <span class="qXLe6d epoveb">  <span class="fYyStc">';
    $B = '</span>';

    $nowWeather = findStringBetweenAnB($googleWeatherSource,$A,$B);

    $samsumgStockSource = getContents("https://www.google.com/search?q=%EC%82%BC%EC%84%B1+%EC%A3%BC%EA%B0%80&oq=%EC%82%BC%EC%84%B1+%EC%A3%BC%EA%B0%80&aqs=chrome..69i57j0i131i433i512j0i20i263i433i512j0i131i433i512j0i433i512j0i20i263i512j0i433i512j69i61.1745j0j4&sourceid=chrome&ie=UTF-8");

    $A = '<div>     <span class="qXLe6d epoveb">  <span class="fYyStc">';
    $B = '</span>';

    $nowStock = findStringBetweenAnB($samsumgStockSource,$A,$B);

    echo $nowStock;
?>