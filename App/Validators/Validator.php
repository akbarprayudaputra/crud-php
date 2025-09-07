<?php

namespace App\Validators;

class Validator
{
  private array $errors = [];

  public function required(string $field, mixed $value): self
  {
    if (empty($value) && $value !== '0' && $value === "" && $value === '') {
      $this->errors[$field] = "$field wajib diisi.";
    }
    return $this;
  }

  public function email(string $field, mixed $value): self
  {
    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
      $this->errors[$field] = "$field harus berupa email yang valid.";
    }
    return $this;
  }

  public function getErrors(): array
  {
    return $this->errors;
  }

  public function passes(): bool
  {
    return empty($this->errors);
  }
}
