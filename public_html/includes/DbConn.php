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
        PDO::ATTR