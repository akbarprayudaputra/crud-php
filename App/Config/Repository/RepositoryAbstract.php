<?php

namespace App\Config\Repository;

abstract class RepositoryAbstract
{
  protected \PDO $db;
  protected string $table;

  public function __construct($table)
  {
    $this->table = $table;
    $this->db = \App\Helpers\DatabaseHelper::connect();
  }
}
