<?php

class DbConn {
  public static $pdo = NULL;
  public static $host = '127.0.0.1';
  public static $db = 'recipesub';
  public static $user = 'recipesub';
  public static $pass = 'Latter!Padua!Valium1';
  public static $charset = 'utf8mb4';


  public static function getPdo(){
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $dsn = "mysql:host=".static::$host.";dbname=".static::$db.";charset=".static::$charset;
    if( static::$pdo == NULL ){
      static::$pdo = new PDO($dsn, static::$user, static::$pass, $opt);
    }
    return static::$pdo;
  }
}
