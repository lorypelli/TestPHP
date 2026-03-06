<?php
require_once sprintf('%s//src/utils/generate_code.php', $root);
require_once sprintf('%s/src/utils/send_email.php', $root);
$is_confirm = isset($_GET['confirm']);
$session_email = !$is_confirm ? $_SESSION['email'] : $_SESSION['old_email'];
if (!filter_var($session_email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'invalid_email';
    redirect('/new/email', 307);
    exit(1);
}
$email = $_POST['email'] ?? ($_SESSION['email'] ?? '');
$repeat_email = $_POST['repeat_email'] ?? '';
if (!$is_confirm && $email != $repeat_email) {
    $_SESSION['error'] = 'emails_not_match';
    redirect('/new/email', 307);
    exit(1);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = 'invalid_email';
    redirect('/new/email', 307);
    exit(1);
}
if (!$is_confirm) {
    $code = generate_code();
    $_SESSION['old_email'] = $session_email;
    $_SESSION['email'] = $email;
    $_SESSION['code'] = $code;
    $_SESSION['type'] = 'change_confirm';
    send_email($email, $code, 'new/email');
    redirect('/verify', 307);
    exit(0);
}
$users->set_email($session_email, $email);
session_destroy();
redirect('/api/logout', 307);
