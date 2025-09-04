<?php

namespace App\Builders;

use App\Models\User;

class UserBuilder
{
  private string
  $name,
  $username,
  $email,
  $password;


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

  public function build(): User
  {
    return new User(
      $this->name,
      $this->username,
      $this->email,
      $this->password
    );
  }
}
