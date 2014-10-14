<?php

    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors',1);
    ini_set('html_errors', 1);


    function search($query) 
    {
        echo "<div class=\"row marketing\"><div class=\"col-lg-12\">";
                                   
        $url = "http://192.168.111.190:8983/solr/news/select?q=";
        $url = $url."headline:".$query;
        $url = $url."&sort=startdate+desc&start=0&rows=20&fl=headline,url&wt=json&indent=true&start=0&rows=100&group=true&group.field=headline";
        $json = file_get_contents($url);
        $res = json_decode($json,true);
        foreach ($res['grouped']['headline']['groups'] as $i)
        {
            // print_r ($i);
            echo "<p>";
            $flag = 0;
            if(array_key_exists ('url' , $i['doclist']['docs'][0] ) )
            {
                $flag = 1;
                $url = $i['doclist']['docs'][0]['url'];
                echo "<a href=\"".$url."\">";
            }
            if(array_key_exists ('headline' , $i['doclist']['docs'][0] ) )
            {
                $headline = $i['doclist']['docs'][0]['headline'];
                echo $headline;
            }
            if($flag == 1)
            {
                echo "</a>";
            }
            echo "</p>";
        }
        echo "</div></div>";
    }

    search("obama");

?>