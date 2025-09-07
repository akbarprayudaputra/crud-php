<?php

namespace App\Controllers;

class UserController
{
  public function index()
  {
    try {
      $users = (new \App\Services\UserService())->getAllUsers();
      \App\Helpers\JsonResponseHelper::send($users, 200);
    } catch (\Throwable $th) {
      \App\Helpers\JsonResponseHelper::send(['error' => $th->getMessage()], $th->getCode() ?: 500);
    }
  }

  public function store()
  {
    try {
      $data = json_decode(file_get_contents('php://input'), true);

      $validator = new \App\Validators\Validator();
      $validator->required('name', $data['name'])
        ->required('username', $data['username'])
        ->required('email', $data['email'])
        ->email('email', $data['email'])
        ->required('password', $data['password']);

      if (!$validator->passes()) {
        \App\Helpers\JsonResponseHelper::send(['errors' => $validator->getErrors()], 422);
        return;
      }

      $user = (new \App\Services\UserService())->save($data);

      \App\Helpers\JsonResponseHelper::send([
        'message' => 'User created successfully',
        'user' => [
          'name' => $user->getName(),
          'username' => $user->getUsername(),
          'email' => $user->getEmail()
        ]
      ], 201);
    } catch (\Throwable $th) {
      \App\Helpers\JsonResponseHelper::send(['error' => $th->getMessage()], $th->getCode() ?: 500);
    }
  }

  public function show(int $id)
  {
    try {
      $user = (new \App\Repositories\UserRepository())->find($id);
      if ($user) {
        \App\Helpers\JsonResponseHelper::send($user, 200);
      } else {
        \App\Helpers\JsonResponseHelper::send(['error' => 'User not found'], 404);
      }
    } catch (\Throwable $th) {
      \App\Helpers\JsonResponseHelper::send(['error' => $th->getMessage()], $th->getCode() ?: 500);
    }
  }

  public function update(int $id)
  {
    try {
      $userService = new \App\Services\UserService();

      $user = $userService->userExists($id);

      if ($user === false) {
        \App\Helpers\JsonResponseHelper::send(['error' => 'User not found'], 404);
        return;
      }

      $data = json_decode(file_get_contents('php://input'), true);

      $validator = new \App\Validators\Validator();
      $validator->required('name', $data['name'])
        ->required('username', $data['username'])
        ->required('email', $data['email'])
        ->email('email', $data['email']);

      if (!$validator->passes()) {
        \App\Helpers\JsonResponseHelper::send(['errors' => $validator->getErrors()], 422);
        return;
      }

      $user = $userService->update($id, $data);

      \App\Helpers\JsonResponseHelper::send([
        'message' => 'User updated successfully',
        'user' => [
          'name' => $user->getName(),
          'username' => $user->getUsername(),
          'email' => $user->getEmail()
        ]
      ], 200);
    } catch (\Throwable $th) {
      \App\Helpers\JsonResponseHelper::send(['error' => $th->getMessage()], $th->getCode() ?: 500);
    }
  }

  public function delete(int $id)
  {
    try {
      $userService = new \App\Services\UserService();

      $user = $userService->userExists($id);

      if (!$userService->delete($id)) {
        \App\Helpers\JsonResponseHelper::send(['error' => 'Failed to delete user'], 500);
        return;
      }

      \App\Helpers\JsonResponseHelper::send(['message' => 'User deleted successfully'], 200);
    } catch (\Throwable $th) {
      \App\Helpers\JsonResponseHelper::send(['error' => $th->getMessage()], $th->getCode() ?: 500);
    }
  }

  public function deleteAll()
  {
    try {
      $result = (new \App\Services\UserService())->deleteAllUsers();
      if ($result) {
        \App\Helpers\JsonResponseHelper::send(['message' => 'All users deleted successfully'], 200);
      } else {
        \App\Helpers\JsonResponseHelper::send(['error' => 'Failed to delete users'], 500);
      }
    } catch (\Throwable $th) {
      \App\Helpers\JsonResponseHelper::send(['error' => $th->getMessage()], $th->getCode() ?: 500);
    }
  }
}
