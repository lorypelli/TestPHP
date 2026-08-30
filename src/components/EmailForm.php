<?php
$messages = require_once sprintf('%s/src/enums/AppError.php', $root);
$is_reset = $type == Type::Reset;
$error = $_SESSION['error'] ?? '';
?>
<form method="POST" class="flex h-screen flex-col items-center justify-center gap-y-1" action="<?= sprintf(
    '/api/%s',
    $is_reset ? 'reset' : 'change',
) ?>">
    <?php if (isset($messages[$error])): ?>
        <?php include_once sprintf('%s/src/components/Error.php', $root); ?>
    <?php endif; ?>
    <span>Email:</span>
    <input name="email" autocomplete="off" type="email" required class="w-60 rounded-md border-2 p-1" />
    <button type="submit" class="cursor-pointer rounded-md border-2 p-1">Continue!</button>
</form>