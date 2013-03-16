<?php

//
// $Id: test.php 2903 2011-08-04 13:30:49Z shodan $
//


$genretable[1]="Action & Adventure";
$genretable[2]="Animation";
$genretable[3]="Anime";
$genretable[4]="comedy";
$genretable[5]="documentary";
$genretable[6]="horror";

require ( "sphinxapi.php" );

$cl = new SphinxClient ();

$q=$_GET["q"];
$sql = "";
$mode = SPH_MATCH_ALL;
$host = "localhost";
$port = 9312;
$index = "*";
$groupby = "";
$groupsort = "@group desc";
$filter = "group_id";
$filtervals = array();
$distinct = "";
$sortby = "";
$sortexpr = "";
$limit = 20;
$ranker = SPH_RANK_PROXIMITY_BM25;
$select = "";
////////////
// do query
////////////

$cl->SetServer ( $host, $port );
$cl->SetConnectTimeout ( 1 );
$cl->SetArrayResult ( true );
$cl->SetWeights ( array ( 100, 1 ) );
$cl->SetMatchMode ( $mode );
if ( count($filtervals) )	$cl->SetFilter ( $filter, $filtervals );
if ( $groupby )				$cl->SetGroupBy ( $groupby, SPH_GROUPBY_ATTR, $groupsort );
if ( $sortby )				$cl->SetSortMode ( SPH_SORT_EXTENDED, $sortby );
if ( $sortexpr )			$cl->SetSortMode ( SPH_SORT_EXPR, $sortexpr );
if ( $distinct )			$cl->SetGroupDistinct ( $distinct );
if ( $select )				$cl->SetSelect ( $select );
if ( $limit )				$cl->SetLimits ( 0, $limit, ( $limit>1000 ) ? $limit : 1000 );
$cl->SetRankingMode ( $ranker );

//$fastlogfile=fopen("/var/www/moviedb/sphinxtime.out",'a');
$time1=  microtime(true);
$res = $cl->Query ( $q, $index );
$time2= microtime(true);
//fwrite($slowlogfile," ".(1000*(microtime(true)-$time1)));
//fclose($fastlogfile);
//echo " <b> ".(1000*($time2-$time1))."<br><br>";
////////////////
// print me out
////////////////

if ( $res===false )
{
	print "Query failed: " . $cl->GetLastError() . ".\n";

} else
{
	if ( $cl->GetLastWarning() )
		print "WARNING: " . $cl->GetLastWarning() . "\n\n";

	print "Query '$q' retrieved $res[total] of $res[total_found] matches\n";
	print "Query stats:\n";
	if ( is_array($res["words"]) )
		foreach ( $res["words"] as $word => $info )
			print "    '$word' found $info[hits] times in $info[docs] documents\n";
	print "\n";
        echo "<br>";
        
        $cb = new Couchbase("127.0.0.1:8091","Administrator","password","default");
        
                     
	print "<br>Matches:\n<br><br>";
        echo "<br>";
                                              
        foreach ( $res["matches"] as $docinfo )
	{
                           
	    echo "<table>";
            $ans=$cb->get(md5("movie". $docinfo[id])); 
            $ans=  json_decode($ans);
            foreach ($ans as $key => $value)
                echo "<tr><td><b>" . $key . "</b></td><td> " . $value . "</td></tr>";
            echo "</table>";
            echo "<br><br>";		
	}
}

?>