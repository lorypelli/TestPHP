<?php
enum AppError: string
{
    case ALREADY_EXISTS = 'This email already exists in the database';
    case NOT_FOUND = 'User not found';
    case INVALID_EMAIL = 'The email is not valid';
    case INCORRECT_PASSWORD = 'The user exists but the password is not correct';
    case EMAILS_NOT_MATCH = 'Emails do not match';
    case PASSWORDS_NOT_MATCH = 'Passwords do not match';
    case WRONG_CODE = 'Your verification code is not valid';
    case EXPIRED = 'Verification code expired';
    case INVALID_IMAGE = 'The image you provided is not valid';
    case USERNAME_TOO_LONG = 'The username is too long';
    case CF_ERROR = 'Cloudflare verification error';
    case TODO_ALREADY_EXISTS = 'A todo with that name already exists in your account';
    case TODO_NAME_TOO_LONG = 'The todo name is too long';
    case TODO_DESCRIPTION_TOO_LONG = 'The todo description is too long';
}

return array_combine(
    array_map(fn(AppError $c) => strtolower($c->name), AppError::cases()),
    array_map(fn(AppError $c) => $c->value, AppError::cases()),
);
