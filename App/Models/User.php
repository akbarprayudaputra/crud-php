<?php

namespace App\Models;

use App\Config\Model;

class User extends Model
{
  /**
   * Class User
   *
   * Represents a user entity in the application.
   *
   * @package App\Models
   *
   * Properties:
   * @property int $id          The id of the user..
   * @property string $name     The name of the user.
   * @property string $username The username of the user.
   * @property string $email    The email address of the user.
   * @property string $password The hashed password of the user.
   *
   * Methods:
   * @method __construct(string $name, string $username, string $email, string $password)
   *         Initializes a new User instance and hashes the password.
   * @method getName(): string
   *         Returns the name of the user.
   * @method getUsername(): string
   *         Returns the username of the user.
   * @method getEmail(): string
   *         Returns the email address of the user.
   * @method getPassword(): string
   *         Returns the hashed password of the user.
   *
   */

  protected int $id;

  protected string
  $name,
  $username,
  $email,
  $password;

  public function __construct($name, $username, $email, $password)
  {
    $this->name = $name;
    $this->username = $username;
    $this->email = $email;
    $this->password = password_hash($password, PASSWORD_BCRYPT);
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

  public function getPassword(): string
  {
    return $this->password;
  }


  public function getId(): int
  {
    return $this->id;
  }
}
