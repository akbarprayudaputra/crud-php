<?php

namespace App\Controllers;

class UserController
{
  public function store()
  {
    $input = json_decode(file_get_contents('php://input'), true);

    try {
      $user = (new \App\Builders\UserBuilder())
        ->setName($input['name'])
        ->setUsername($input['username'])
        ->setEmail($input['email'])
        ->setPassword($input['password'])
        ->build();

      $userRepository = new \App\Repositories\UserRepository();
      $userRepository->create($user);

      \App\Helpers\JsonResponseHelper::send([
        'message' => 'User created successfully',
        'user' => [
          'username' => $user->getUsername(),
          'email' => $user->getEmail()
        ]
      ], 201);
    } catch (\Throwable $th) {
      \App\Helpers\JsonResponseHelper::send(['error' => $th->getMessage()], $th->getCode() ?: 500);
    }
  }
}
