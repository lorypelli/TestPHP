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
    $_SESSION['type'] = 'register';
    redirect('/verify', 307);
    exit(0);
}
$token = bin2hex(random_bytes(32));
$sessions->new($token, $users->get_id($email));
$cookies->set('user_token', $token);
session_destroy();
redirect('/');
