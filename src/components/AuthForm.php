<?php
require_once sprintf('%s/src/enums/Type.php', $root);
$messages = require_once sprintf('%s/src/enums/AppError.php', $root);
$is_login = $type == Type::Login;
$error = $_SESSION['error'] ?? '';
?>
<form method="POST" class="flex h-screen flex-col items-center justify-center gap-y-1" action="<?= sprintf(
    '/api/%s',
    $is_login ? 'login' : 'register',
) ?>">
    <?php if (isset($messages[$error])): ?>
        <?php include_once sprintf('%s/src/components/Error.php', $root); ?>
    <?php endif; ?>
    <?php include_once sprintf('%s/src/components/Fields.php', $root); ?>
    <button type="submit" class="cursor-pointer rounded-md border-2 p-1"><?= $is_login
        ? 'Login!'
        : 'Register!' ?></button>
    <?php if (!$is_login): ?>
        <span>Already have an account? You can <a href="/login" class="text-blue-600 hover:underline">login here</a>!</span>
    <?php else: ?>
        <span>Don't have an account? You can <a href="/register" class="text-blue-600 hover:underline">register
                here</a>!</span>
    <?php endif; ?>
    <span>Forgot password? No problem, you can <a href="/reset" class="text-blue-600 hover:underline">reset
            here</a>!</span>
</form>