<?php

namespace App\Controllers;

class HomeController
{
  public function index()
  {
    \App\Helpers\JsonResponseHelper::send(['message' => 'Welcome to the Home Page!']);
  }
}
