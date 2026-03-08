<?php
function send_email(string $email, string $code, string $action): void
{
    global $resend, $users;
    if (!is_api_key_valid(true)) {
        return;
    }
    $is_register = $action == 'register';
    $text = sprintf('Your verification code is: %s', $code);
    if ($is_register) {
        $text .= sprintf(', you have 15 minutes to use it before it expires!');
        $user_id = $users->get_id($email);
        $options = ['id' => $user_id, 'email' => $email, 'code' => $code];
        $encoded = base64_encode(json_encode($options));
        $text .= sprintf(
            "\nYou can also use the following URL to automatically verify:\nhttp://%s/verify/%s",
            $_SERVER['HTTP_HOST'],
            $encoded,
        );
    }
    try {
        $resend->emails->send([
            'from' => $_ENV['EMAIL'],
            'to' => $email,
            'subject' => 'Verification Code',
            'text' => $text,
        ]);
    } catch (Exception) {
        $_SESSION['error'] = 'invalid_email';
        redirect(sprintf('/%s', $action));
        exit(1);
    }
}
