<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once sprintf('%s/vendor/autoload.php', $root);
require_once sprintf('%s/src/utils/buffer.php', $root);
$code = intval($_GET['code'] ?? '500');
http_response_code($code);
$message = match ($code) {
    404 => 'Not Found',
    405 => 'Method Not Allowed',
    500 => 'Internal Server Error',
};
ob_start(buffer(...));
?>
<!DOCTYPE html>
<html lang="en">

<?php include_once sprintf('%s/src/components/Header.php', $root); ?>

<body class="flex h-screen flex-col items-center justify-center">
    <span class="text-4xl font-bold text-red-600"><?= $code ?> - <?= $message ?>!</span>
</body>

</html>
<?php ob_end_flush(); ?>
