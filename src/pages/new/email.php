<?php
$messages = require_once sprintf('%s/src/enums/AppError.php', $root);
$error = $_SESSION['error'] ?? '';
?>
<form method="POST" class="flex h-screen flex-col items-center justify-center gap-y-1" action="/api/new/email">
    <?php if (isset($messages[$error])): ?>
        <?php include_once sprintf('%s/src/components/Error.php', $root); ?>
    <?php endif; ?>
    <span>New Email:</span>
    <input name="email" autocomplete="off" type="email" required class="w-60 rounded-md border-2 p-1" />
    <span>Repeat New Email:</span>
    <input name="repeat_email" autocomplete="off" type="email" required class="w-60 rounded-md border-2 p-1" />
    <button type="submit" class="cursor-pointer rounded-md border-2 p-1">Continue!</button>
</form>