<?php
require_once sprintf('%s/src/utils/turnstile.php', $root);
turnstile('login');
$email = $_POST['email'] ?? '';
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'invalid_email';
    redirect('/login');
    exit(1);
}
if (!$users->check_email($email)) {
    $_SESSION['error'] = 'not_found';
    redirect('/login');
    exit(1);
}
$password = $_POST['password'];
if (!$users->check($email, $password)) {
    $_SESSION['error'] = 'incorrect_password';
    redirect('/login');
    exit(1);
}
if (!$users->get_verified_at($email)) {
    $_SESSION['email'] = $email;
    $_SESSION['code'] = $users->get_verification_code($email);
    $_SESSION['type'] = 'login';
    redirect('/verify', 307);
    exit(0);
}
$user = $users->get($email, $password);
if ($user) {
    $cookies->set('email', $user->get_email());
    $cookies->set('password', $user->get_password());
}
session_destroy();
redirect('/');
