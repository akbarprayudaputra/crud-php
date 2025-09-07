<?php

namespace App\Services;

class UserService
{
  public function getAllUsers(): array
  {
    $userRepository = new \App\Repositories\UserRepository();
    return $userRepository->all();
  }

  public function save(array $input): \App\Models\User
  {

    if ($this->checkEmailExists($input['email'])) {
      throw new \Exception('Email already exists', 400);
    }

    if ($this->checkUsernameExists($input['username'])) {
      throw new \Exception('Username already exists', 400);
    }

    $user = (new \App\Builders\UserBuilder())
      ->setName($input['name'])
      ->setUsername($input['username'])
      ->setEmail($input['email'])
      ->setPassword($input['password'])
      ->build();

    $userRepository = new \App\Repositories\UserRepository();
    $userRepository->create($user);

    return $user;
  }

  public function update(int $id, $data): \App\Models\User
  {
    $userRepository = new \App\Repositories\UserRepository();

    $user = (new \App\Builders\UserBuilder())
      ->setName($data['name'])
      ->setUsername($data['username'])
      ->setEmail($data['email'])
      ->build();

    if (!$userRepository->update($id, $user)) {
      throw new \Exception('Error updating user', 400);
    }

    return $user;
  }

  public function delete(int $id): bool
  {
    $userRepository = new \App\Repositories\UserRepository();
    return $userRepository->delete($id);
  }

  public function findUserById(int $id): ?\App\Models\User
  {
    $userRepository = new \App\Repositories\UserRepository();
    $result = $userRepository->find($id);

    if ($result) {
      return (new \App\Builders\UserBuilder())
        ->setId($result['id'])
        ->setName($result['name'])
        ->setUsername($result['username'])
        ->setEmail($result['email'])
        ->build();
    }
  }

  public function userExists(int $id): bool
  {
    $userRepository = new \App\Repositories\UserRepository();
    $user = $userRepository->find($id);
    return $user !== false;
  }

  public function checkEmailExists(string $email)
  {
    $userRepository = new \App\Repositories\UserRepository();
    $users = $userRepository->findByEmail($email);
    return $users !== false;
  }

  public function checkUsernameExists(string $username)
  {
    $userRepository = new \App\Repositories\UserRepository();
    $users = $userRepository->findByUsername($username);
    return $users !== false;
  }

  public function deleteAllUsers(): bool
  {
    $userRepository = new \App\Repositories\UserRepository();
    return $userRepository->deleteAll();
  }
}
