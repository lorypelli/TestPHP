<?php
require_once sprintf('%s//src/utils/generate_code.php', $root);
require_once sprintf('%s/src/utils/send_email.php', $root);
function update_user(string $action): void
{
    global $users;
    $email = $_POST['email'] ?? '';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = 'invalid_email';
        redirect(sprintf('/%s', $action));
        exit(1);
    }
    if (!$users->check_email($email)) {
        $_SESSION['error'] = 'not_found';
        redirect(sprintf('/%s', $action));
        exit(1);
    }
    $code = generate_code();
    $_SESSION['email'] = $email;
    $_SESSION['code'] = $code;
    $_SESSION['type'] = $action;
    send_email($email, $code, $action);
    redirect('/verify', 307);
}
