<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once sprintf('%s/vendor/autoload.php', $root);
require_once sprintf('%s/src/utils/show_fallback_avatar.php', $root);
require_once sprintf('%s/src/classes/UserTable.php', $root);
Dotenv\Dotenv::createImmutable($root)->load();
header('Content-Type: image/gif');
$users = new UserTable();
$email = $_GET['email'] ?? '';
$avatar = $email
    ? $users->get_avatar($email) ?? show_fallback_avatar()
    : show_fallback_avatar();
readfile($avatar);
