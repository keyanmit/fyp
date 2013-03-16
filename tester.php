<?php

$cbase= new Couchbase("127.0.0.1:8091","Administrator","password","default");

$ans=$cbase->get(md5("movierating". 3));
$ans=  json_decode($ans);

//echo $ans["rating"];
foreach ($ans as $key => $value) {
    echo $key . " " .$value;
    if($key=="rating")break;
}

?>
