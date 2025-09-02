<?php

namespace App\Config;

class Database
{
  private $host = 'localhost';
  private $dbName = 'crud_php';
  private $username = 'root';
  private $password = 'root';
  private $conn;

  public function connect()
  {
    if ($this->conn !== null) {
      return $this->conn;
    }

    try {
      $this->conn = new \PDO("mysql:host={$this->host};dbname={$this->dbName}", $this->username, $this->password);
      $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    } catch (\PDOException $e) {
      \App\helpers\JsonResponseHelper::send([
        'error' => 'Database Connection Error: ' . $e->getMessage()
      ], 500);
    }

    return $this->conn;
  }
}
