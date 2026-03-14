<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$errors = [];

function pushError(string $key, string $value): void
{
    global $errors;
    $errors[$key] = $value;

    $_SESSION['errors'] = $errors;
}


function hasErrors(): bool
{

    if (! empty($_SESSION['errors'])) {
        return true;
    }

    return false;
}


function showErrors(): void
{

    foreach (getFlashErrors() as $error) {


        echo "<div class='alert alert-danger' role='alert'>$error</div>";
    }
}

function getFlashErrors(): array
{
    if (isset($_SESSION['errors'])) {
        $errors = $_SESSION['errors'];
        unset($_SESSION['errors']);
        return $errors;
    } else {

        return [];
    }
}
