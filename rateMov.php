<?php

    /*$redValue=$_SESSION['redValue'];
    $mid=$_SESSION['mid'];
    $movRating=$_SESSION['mvObj'];*/

    $redValue=$_GET['redValue'];
    $mid=$_GET['mid'];
    $movRating['rating']=$_GET['mscore'];
    $movRating['count']=$_GET['mcount'];
    
    $cb1 = new Couchbase("127.0.0.1:8091","Administrator","password","default");
    
    $score=$movRating['rating']*$movRating['count']-$redValue;
    
    if($redValue==0)$movRating['count']=$movRating['count']+1;
    
    
    $tmp['count']=$movRating['count'];
    $tmp['type']="movierating";
    
    $tmpUsr['rating']=rand(1,5);
    $tmpUsr['type']="userrating";
    
    $tmp['rating']=(($score+$tmpUsr['rating'])/$movRating['count']);
    
    $cb1->replace(md5("usermovierating". 1 . $mid),  json_encode($tmpUsr));
    $cb1->replace(md5("movierating". $mid),  json_encode($tmp));
    
    
    echo "<HTML>
<HEAD>
<TITLE>Redirecting</TITLE>
<META HTTP-EQUIV='refresh' CONTENT='1;URL=http://localhost/CouchBaseTrials/'>
</HEAD>

<BODY>
Redirecting
</BODY>

</HTML>"
    
?>
