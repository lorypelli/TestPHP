<?php
function is_api_key_valid(bool $do_test = false): bool
{
    global $resend;
    $email = $_ENV['EMAIL'] ?? '';
    $api_key = $_ENV['APIKEY'] ?? '';
    if (!$email || !$api_key) {
        return false;
    }
    if ($do_test) {
        try {
            $resend->emails->send([
                'from' => $email,
                'to' => $email,
                'subject' => 'Test',
                'text' => 'Test',
            ]);
            return true;
        } catch (Exception) {
            return false;
        }
    }
    return true;
}
