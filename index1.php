<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
        $cb = new Couchbase("127.0.0.1:8091","Administrator","password","beer-sample");
        $result = $cb->view("dev_beer","beer_by_name",array('startkey' => 'O' , 'endkey' => 'R'));
        foreach($result["rows"] as $row){
            print_r($row);
            echo "<br>";
                //echo $row['key'] . "<br><br>";
        }
        echo "done";
        // put your code here
        ?>
    </body>
</html>
