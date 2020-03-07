
<?php

require_once "includes/autoload.php"; 

set_time_limit(120*60);

$start = microtime(true);

$handle = fopen( "grocery_data/groc_df_v.csv", "w" );

$pdo = DbConn::getPdo();

$offset = $_REQUEST['offset'];

$sql = "SELECT * FROM Groc_df_v";

$fetcher  = $pdo->query($sql);

$cnt = 0;
while( $r = $fetcher->fetch() ){
  if( $cnt++ == 0 ) 
    fputcsv( $handle, array_keys($r) );
  fputcsv( $handle, $r );
}
echo "done in: ".( microtime(true) - $start );