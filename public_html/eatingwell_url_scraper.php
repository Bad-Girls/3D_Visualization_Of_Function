<?php

require_once( $_SERVER['DOCUMENT_ROOT'].'/includes/autoload.php' );

set_time_limit(0);

use Goutte\Client;

$pdo = DbConn::getPdo();

$client = new Client();
$gzl = new GuzzleHttp\Client( array(
  'curl' => array(
    CURLOPT_SSL_VERIFYPEER => false,
  ),
) );
$client->setClient($gzl);

for( $i=200; $i< 340; $i++ ){
  $statement = $pdo->prepare("SELECT * FROM EatingWellRecipe WHERE PageNumber=?");
  $page_id = $i;
  $statement->execute([$page_id]);
  $existing = $statem