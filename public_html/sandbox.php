
<?php

require_once "includes/autoload.php"; 

echo 'hi 3';

$pdo = DbConn::getPdo();

$start = microtime(true);
$cnt = 0;
while( microtime(true) - $start < 60 ){
  $cnt++;

  $sql = "SELECT * FROM EatingWellRecipeIngredientTmpa WHERE PartB IS NULL LIMIT 1000";

  $fetcher  = $pdo->query($sql);

  while( $r = $fetcher->fetch() ){
    $new = $r['PartA'];
    $new = preg_replace( '/\(.*\)/', '', $new );
    $new = strtolower( preg_replace( '/ +/', ' ', preg_replace( '/[^A-Za-z ]/', ' ', $new ) ) );
    $new = trim( $new );
    $update_q = $pdo->prepare( "UPDATE EatingWellRecipeIngredientTmpa Set PartB = ? WHERE EatingWellRecipeIngredientId = ?" );
    $update_q->execute( array( $new, $r['EatingWellRecipeIngredientId'] ) );
  }
}
d($cnt);
exit;

$cnt = 0;
$measurements = array();
while( $r = $fetcher->fetch() ){
  $pattern = '/^[0-9]+\s+([\w\-]+)(.*)/';
  if( preg_match( $pattern, $r['IngredientText'] ) ){
    $measurement = preg_replace( $pattern, '$1', $r['IngredientText'] );
    $remainder = preg_replace( $pattern, '$2', $r['IngredientText'] );
    if( !in_array($measurement,$measurements) ){
      $measurements[] = $measurement;
      $out[] = array(
        "original" => $r['IngredientText'],
        "extract" => $measurement,
        "remainder" => $remainder,
      );
      $insert_q = $pdo->prepare( "INSERT INTO EatingWellRecipeIngredientTmpa ( EatingWellRecipeIngredientId, PartA, PartB, PartC ) VALUES ( ?, ?, ?, ? )" );
      $insert_q->execute( array( $r['EatingWellRecipeIngredientId'], $r['IngredientText'], $measurement, $remainder ) );
    }
  }
}
d($out);
d($measurements);