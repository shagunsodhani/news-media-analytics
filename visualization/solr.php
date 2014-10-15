<?php

    error_reporting(E_ALL | E_STRICT);
    ini_set('display_errors',1);
    ini_set('html_errors', 1);

    $query = $_GET["search"];
    $selector  = $_GET["from"];
    // echo $query;

    function search($qstring) 
    {
        echo "<div class=\"row marketing\"><div class=\"col-lg-12\">";
         
        $query = explode(' ', $qstring);    
        // var_dump($query);                       
        $url = "http://192.168.111.190:8983/solr/news/select?q=";

        $len = count($query)-1;

        for ($i = 0; $i < $len; $i++) 
        {
            $url = $url."headline:".$query[$i]."%20OR%20";
        }
        $url = $url."headline:".$query[$len];
        $url = $url."&start=0&rows=20&fl=headline,url&wt=json&indent=true&group=true&group.field=headline";
        $json = file_get_contents($url);
        $res = json_decode($json,true);
        // echo $url;
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

    function stat_1($query) 
    {
        // &fl=headline&wt=json&indent=true
        header('Content-type: text/plain');
        $url = "http://192.168.111.190:8983/solr/news/select?q=";
        $url = $url."headline:".$query;
        $url = $url."&start=0&rows=150&fq=url%3Ahttp*&fl=id&wt=json&indent=true&group=true&group.field=sourceid";
        $json = file_get_contents($url);
        // print_r ($json);
        $precise = json_decode($json,true);
        $res = "";
        foreach ($precise['grouped']['sourceid']['groups'] as $i)
        {
            // print_r ($i);
            if(array_key_exists ('groupValue' , $i ) )
            {
                $groupValue = $i['groupValue'];
                if(array_key_exists ('numFound' , $i['doclist'] ) )
                {
                    $numFound = $i['doclist']['numFound'];
                    $res=$res.strval($groupValue)."-valid,".strval($numFound)."\n";
                }
            }
        }
        $url = "http://192.168.111.190:8983/solr/news/select?q=";
        $url = $url."headline:".$query;
        $url = $url."&start=0&rows=150&-fq=url%3Ahttp*&fl=id&wt=json&indent=true&group=true&group.field=sourceid";
        echo $url;
        $json = file_get_contents($url);
        // print_r ($json);
        $precise = json_decode($json,true);
        $res = "";
        foreach ($precise['grouped']['sourceid']['groups'] as $i)
        {
            // print_r ($i);
            if(array_key_exists ('groupValue' , $i ) )
            {
                $groupValue = $i['groupValue'];
                if(array_key_exists ('numFound' , $i['doclist'] ) )
                {
                    $numFound = $i['doclist']['numFound'];
                    $res=$res.strval($groupValue)."-invalid,".strval($numFound)."\n";
                }
            }
        }
        echo $res;
    }

    if($selector==1)
    {
        search($query);
    }
    // stat_1("obama");
    

?>