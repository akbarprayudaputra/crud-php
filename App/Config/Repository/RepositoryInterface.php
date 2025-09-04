<?php

namespace App\Config\Repository;

interface RepositoryInterface
{
  public function all(): array;
  public function find(int $id): array|false;
  public function delete(int $id): bool;
}
