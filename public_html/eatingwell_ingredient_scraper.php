
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
$recipes_q = $pdo->query("SELECT EatingWellRecipe.* FROM EatingWellRecipe LEFT JOIN EatingWellRecipeIngredient ON EatingWellRecipeIngredient.EatingWellRecipeId = EatingWellRecipe.EatingWellRecipeId WHERE RecipeName IS NULL AND EatingWellRecipeIngredientId IS NULL");

while( $row = $recipes_q->fetch() ){

  $url = $row['Url'];
  $crawler = $client->request('GET', $url);

  $ingredients = array();
  $title = "";
  $crawler->filter('h3[itemprop="name"]')->each(function ($node) {
    global $title;
    $title = $node->html();
  });
  $crawler->filter('span[itemprop="ingredients"]')->each(function ($node) {
    global $ingredients;
    $ingredients[] = $node->html();
  });

  $u_q = $pdo->prepare( "UPDATE EatingWellRecipe SET RecipeName=? WHERE EatingWellRecipeId=?" );
  $u_q->execute([$title,(int)$row['EatingWellRecipeId']]);

  $i_q = $pdo->prepare( "INSERT INTO EatingWellRecipeIngredient (EatingWellRecipeId,IngredientText) VALUES (?,?)" );
  if( count($ingredients) ){
    foreach( $ingredients as $i ){
      $i_q->execute([(int)$row['EatingWellRecipeId'],$i]);
    }
  }
}




echo 'ff';