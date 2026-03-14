<?php

namespace App\Core;

class Validator
{
    private array $data;
    private array $errors = [];
    private array $validated = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function validate(array $rules): bool
    {
        foreach ($rules as $field => $fieldRules) {

            $value = trim($this->data[$field] ?? '');

            foreach ($fieldRules as $rule) {

                if ($rule === 'required' && $value === '') {
                    $this->errors[$field][] = "$field is required.";
                }

                if ($rule === 'email' && $value !== '' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->errors[$field][] = "$field must be a valid email.";
                }

                if (str_starts_with($rule, 'min:')) {
                    $min = (int) explode(':', $rule)[1];

                    if (strlen($value) < $min) {
                        $this->errors[$field][] = "$field must be at least $min characters.";
                    }
                }

                if ($rule === 'numeric' && $value !== '' && !is_numeric($value)) {
                    $this->errors[$field][] = "$field must be numeric.";
                }
            }

            if (!isset($this->errors[$field])) {
                $this->validated[$field] = $value;
            }
        }

        return empty($this->errors);
    }

    public function addError(string $field, string $message): void
    {
        $this->errors[$field][] = $message;
    }

    public function fails(): bool
    {
        return !empty($this->errors);
    }

    public function passes(): bool
    {
        return empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    public function validated(): array
    {
        return $this->validated;
    }

    public function first(string $field): ?string
    {
        return $this->errors[$field][0] ?? null;
    }
}
