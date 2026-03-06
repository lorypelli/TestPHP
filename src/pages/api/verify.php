<?php
$email = $_SESSION['email'] ?? '';
$type = $_SESSION['type'] ?? 'register';
if (!$email) {
    $_SESSION['error'] = 'expired';
    redirect('/verify', 307);
    exit(1);
}
$code = $_POST['digit'] ?? [];
$user_code = implode('', $code);
$server_code = $_SESSION['code'] ?? '';
if ($user_code != $server_code) {
    $_SESSION['error'] = 'wrong_code';
    redirect('/verify', 307);
    exit(1);
}
match ($type) {
    'register' => (function () use ($email): void {
        global $users;
        $now = new DateTimeImmutable();
        $created_at = $users->get_created_at($email);
        if ($now->getTimestamp() - $created_at->getTimestamp() < 15 * 60) {
            $users->verify($email);
        } else {
            $_SESSION['error'] = 'expired';
            $users->delete($email);
            redirect('/register');
            exit(1);
        }
        session_destroy();
        redirect('/login');
    })(),
    'reset' => redirect('/new/password', 307),
    'change' => redirect('/new/email', 307),
    'change_confirm' => redirect('/api/new/email?confirm', 307),
};
