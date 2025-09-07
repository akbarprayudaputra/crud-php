<?php

namespace App\Repositories;

use PDO;

class UserRepository extends \App\Config\Repository\RepositoryAbstract implements \App\Config\Repository\RepositoryInterface
{
  public function __construct()
  {
    parent::__construct('users');
  }

  public function all(): array
  {
    $stmt = $this->db->query("SELECT id, name, username, email FROM {$this->table}");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function find(int $id): array|false
  {
    $stmt = $this->db->prepare("SELECT id, name, username, email FROM {$this->table} WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function delete(int $id): bool
  {
    $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = ?");
    return $stmt->execute([$id]);
  }

  public function deleteAll(): bool
  {
    $stmt = $this->db->prepare("DELETE FROM {$this->table}");
    return $stmt->execute();
  }

  public function create(\App\Models\User $user): bool
  {
    try {
      $stmt = $this->db->prepare("INSERT INTO {$this->table} (name, username, email, password) VALUES (?, ?, ?, ?)");
      return $stmt->execute([
        $user->getName(),
        $user->getUsername(),
        $user->getEmail(),
        password_hash($user->getPassword(), PASSWORD_BCRYPT)
      ]);
    } catch (\Throwable $th) {
      throw new \Exception('Error creating user: ' . $th->getMessage(), 400);
    }
  }

  public function update(int $id, \App\Models\User $user): bool
  {
    $stmt = $this->db->prepare("UPDATE {$this->table} SET name = ?, username = ?, email = ?, password = ? WHERE id = ?");
    return $stmt->execute([
      $user->getName(),
      $user->getUsername(),
      $user->getEmail(),
      password_hash($user->getPassword(), PASSWORD_BCRYPT),
      $id
    ]);
  }

  public function findByEmail(string $email): array|false
  {
    $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function findByUsername(string $username): array|false
  {
    $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
}
