<?php
$username = $_POST['username'] ?? '';
if (strlen($username) > Constants::MAX_NAME_LENGTH) {
    $_SESSION['error'] = 'username_too_long';
    redirect('/settings');
    exit(1);
}
$users->set_username($email, $username);
$avatar = $_FILES['avatar'] ?? null;
if ($avatar && !$avatar['error']) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $avatar_name = $avatar['tmp_name'];
    $mime = $finfo->file($avatar_name);
    if (!str_starts_with($mime, 'image/')) {
        $_SESSION['error'] = 'invalid_image';
        redirect('/settings');
        exit(1);
    }
    $path = sprintf('/app/avatars/%s', $email);
    $users->set_avatar($email, $path);
    move_uploaded_file($avatar_name, $path);
}
session_destroy();
redirect('/');
