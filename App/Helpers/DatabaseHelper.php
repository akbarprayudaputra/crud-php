<?php

namespace App\Helpers;

use App\Config\Database;

class DatabaseHelper
{
  private static Database $database;

  public static function connect()
  {
    if (!isset(self::$database)) {
      self::$database = new Database();
    }
    return self::$database->connect();
  }
}
