<?php
$messages = require_once sprintf('%s/src/enums/AppError.php', $root);
$error = $_SESSION['error'] ?? '';
?>
<form method="POST" class="flex h-screen flex-col items-center justify-center gap-y-1" action="/api/new/password">
    <?php if (isset($messages[$error])): ?>
        <?php include_once sprintf('%s/src/components/Error.php', $root); ?>
    <?php endif; ?>
    <span>New Password:</span>
    <div data-pwd class="relative flex flex-row-reverse">
        <?php include sprintf('%s/src/components/CapsLock.php', $root); ?>
        <input name="password" autocomplete="off" type="password" required class="w-60 rounded-md border-2 px-8 py-1" />
        <?php include sprintf('%s/src/components/Toggle.php', $root); ?>
    </div>
    <span>Repeat New Password:</span>
    <div data-pwd class="relative flex flex-row-reverse">
        <?php include sprintf('%s/src/components/CapsLock.php', $root); ?>
        <input name="repeat_password" autocomplete="off" type="password" required
            class="w-60 rounded-md border-2 px-8 py-1" />
        <?php include sprintf('%s/src/components/Toggle.php', $root); ?>
    </div>
    <button type="submit" class="cursor-pointer rounded-md border-2 p-1">Continue!</button>
</form>
<?php include_once sprintf('%s/src/components/Icons.php', $root); ?>
<script src="/toggle.min.js" defer></script>