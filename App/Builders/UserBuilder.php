<?php

namespace App\Builders;

use App\Models\User;

class UserBuilder
{
  private int $id = 0;
  private string
  $name = '',
  $username = '',
  $email = '',
  $password = '';


  public function getPassword(): string
  {
    return $this->password;
  }

  public function setName(string $name): self
  {
    $this->name = $name;
    return $this;
  }

  public function setUsername(string $username): self
  {
    $this->username = $username;
    return $this;
  }

  public function setEmail(string $email): self
  {
    $this->email = $email;
    return $this;
  }

  public function setPassword(string $password): self
  {
    $this->password = $password;
    return $this;
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function getName(): string
  {
    return $this->name;
  }

  public function getUsername(): string
  {
    return $this->username;
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function setId(int $id): self
  {
    $this->id = $id;
    return $this;
  }

  public function build(): User
  {
    return new User(
      $this->id,
      $this->name,
      $this->username,
      $this->email,
      $this->password
    );
  }
}

