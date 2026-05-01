<?php
require_once sprintf('%s//src/utils/generate_code.php', $root);
require_once sprintf('%s/src/utils/turnstile.php', $root);
turnstile('register');
$email = $_POST['email'] ?? '';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'invalid_email';
    redirect('/register');
    exit(1);
}
if ($users->check_email($email)) {
    $_SESSION['error'] = 'already_exists';
    redirect('/register');
    exit(1);
}
$password = $_POST['password'] ?? '';
$repeat_password = $_POST['repeat_password'] ?? '';
if ($password != $repeat_password) {
    $_SESSION['error'] = 'passwords_not_match';
    redirect('/register');
    exit(1);
}
if (strlen($password) > 72) {
    $_SESSION['error'] = 'password_too_long';
    redirect('/register');
    exit(1);
}
$hash = password_hash($password, PASSWORD_BCRYPT);
$username = $_POST['username'] ?? '';
if (strlen($username) > Constants::MAX_NAME_LENGTH) {
    $_SESSION['error'] = 'username_too_long';
    redirect('/register');
    exit(1);
}
$users->new($email, $hash, $username);
$code = generate_code();
$users->set_verification_code($email, $code);
$_SESSION['email'] = $email;
$_SESSION['code'] = $code;
$_SESSION['type'] = 'register';
redirect('/verify', 307);
