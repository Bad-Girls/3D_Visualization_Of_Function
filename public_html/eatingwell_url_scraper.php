<?php

require_once( $_SERVER['DOCUMENT_ROOT'].'/includes/autoload.php' );

set_time_limit(0);

use Goutte\Client;

$pdo = DbConn::getPdo();

$client = new Client();
$gzl