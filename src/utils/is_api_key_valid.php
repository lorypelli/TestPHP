<?php
function is_api_key_valid(): bool
{
    global $resend;
    $email = $_ENV['EMAIL'] ?? '';
    $api_key = $_ENV['APIKEY'] ?? '';
    if (!$email || !$api_key) {
        return false;
    }
    try {
        $resend->emails->send([
            'from' => $_ENV['EMAIL'],
            'to' => $_ENV['EMAIL'],
            'subject' => 'Test',
            'text' => 'Test',
        ]);
        return true;
    } catch (Exception) {
        return false;
    }
}
