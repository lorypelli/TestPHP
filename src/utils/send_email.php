<?php
function send_email(string $email, string $code, string $action): void
{
    global $resend;
    if (!is_api_key_valid()) {
        return;
    }
    try {
        $resend->emails->send([
            'from' => $_ENV['EMAIL'],
            'to' => $email,
            'subject' => 'Verification Code',
            'text' => sprintf('Your verification code is: %s', $code),
        ]);
    } catch (Exception) {
        $_SESSION['error'] = 'invalid_email';
        redirect(sprintf('/%s', $action));
        exit(1);
    }
}
