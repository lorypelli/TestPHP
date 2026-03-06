<?php
function send_email(string $email, string $code, string $action): void
{
    global $resend;
    if (!is_api_key_valid(true)) {
        return;
    }
    $is_register = $action == 'register';
    $text = sprintf('Your verification code is: %s', $code);
    if ($is_register) {
        $text .= sprintf(', you have 15 minutes to use it before it expires!');
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
