<?php

    $cb = new Couchbase("127.0.0.1:8091","Administrator","password","default");
    $db = mysql_connect("127.0.0.1", "root", "national");
    if($db)
    {
        echo "<h1>connected</h1><br>";
        
        mysql_select_db("moviedb");
        $query="select moviegenretable.m_id as movid,m_name,year,g_name as genre from movietable, genretable ,  moviegenretable where moviegenretable.m_id=movietable.m_id and moviegenretable.g_id=genretable.g_id";
        //$query="select *from movietable";
        $result=  mysql_query($query);       
        while($row=  mysql_fetch_array($result))
        {         
            //print_r($row);
            $tmp['movid']=$row['movid'];
            $tmp['movname']=$row['m_name'];
            $tmp['movyear']=$row['year'];
            $tmp['genre']=$row['genre'];
            $tmp['type']='movie';
            
            if($cb->set(md5("movie".$row['movid']),  json_encode($tmp)))
                    echo "     Couch Base insert Success!";
            //echo $row['movid'] . "  " . $row['m_name'] . " " . $row['genre'];  
            echo "<br>";
        }
        
    }
    else
        echo "not connected";
        
?>
