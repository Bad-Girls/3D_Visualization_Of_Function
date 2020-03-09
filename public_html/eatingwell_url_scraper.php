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
  $existing = $statement->fetch();
  if( !$existing ){
    $url = "http://www.eatingwell.com/recipes/?page=$page_id";
    $crawler = $client->request('GET', $url);
    $urls = array();
    $crawler->filter('a[data-internal-referrer-link="recipe hub"]')->each(function ($node) {
      global $pdo;
      global $page_id;
      $url = $node->attr("href");
      $id_pattern = '/.*\/recipe\/([0-9]+).*/';
      if( preg_match( $id_pattern, $url ) ){
        $id = preg_replace( $id_pattern, '$1', $url );

        $rc_q = $pdo->prepare("SELECT * FROM EatingWellRecipe WHERE RecipeNumber=?");
        $rc_q->execute([(int)$id]);
        $existing_r = $rc_q->fetch();
        if( !$existing_r ){
          $r_q = $pdo->prepare( "INSERT INTO EatingWellRecipe (RecipeNumber,RecipeName,Url,PageNumber) VALUES (?,?,?,?)" );
          $r_q->execute([$id,NULL,$url,$page_id]);
        }
      }
    });
  }
}

echo 'ff';
