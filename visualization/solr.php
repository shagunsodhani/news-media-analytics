<?php

    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors',1);
    ini_set('html_errors', 1);


    function shagun() 
    {
        $url = "http://192.168.111.190:8983/solr/news/select?q=";
        $url = $url."headline%3A%22Obama%22";
        $url = $url."&sort=startdate+desc&start=0&rows=20&fl=headline,url&wt=json&indent=true&start=0&rows=100&group=true&group.field=headline";
        // &sort=startdate+desc&start=0&rows=20&fl=headline%2C+url%2C+startdate&wt=json&indent=true
        // echo $url;
        $json = file_get_contents($url);
        // echo gettype($json);
        $res = json_decode($json,true);
        var_dump($res['grouped']);
    }

    shagun();

//     $r = new HttpRequest(url, HttpRequest::METH_GET);
//     try {
//     $r->send();
//     if ($r->getResponseCode() == 200) {
//         print_r($r->getResponseBody());
//         // file_put_contents('local.rss', $r->getResponseBody());
//     }
// } catch (HttpException $ex) {
//     echo $ex;
// }
//     // print_r($info);
//     echo "string";      
?>