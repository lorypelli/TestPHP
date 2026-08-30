<?php
$skip = isset($_GET['skip-confirmation']);
if (!$skip) {
    require_once sprintf('%s/src/enums/Type.php', $root);
    $type = Type::Delete;
    include_once sprintf('%s/src/components/Confirmation.php', $root);
    exit(0);
}
$messages = require_once sprintf('%s/src/enums/AppError.php', $root);
$error = $_SESSION['error'] ?? '';
?>
<form method="POST" class="flex h-screen flex-col items-center justify-center gap-y-1" action="/api/delete">
    <?php if (isset($messages[$error])): ?>
        <?php include_once sprintf('%s/src/components/Error.php', $root); ?>
    <?php endif; ?>
    <span>Type your password to delete your account:</span>
    <div data-pwd class="relative flex flex-row-reverse">
        <?php include_once sprintf('%s/src/components/CapsLock.php', $root); ?>
        <input name="password" autocomplete="off" type="password" required class="w-60 rounded-md border-2 px-8 py-1" />
        <?php include_once sprintf('%s/src/components/Toggle.php', $root); ?>
    </div>
    <button type="submit" class="cursor-pointer rounded-md border-2 p-1">Delete!</button>
    <span>Forgot password? No problem, you can <a href="/reset" class="text-blue-600 hover:underline">reset
            here</a>!</span>
</form>
<?php include_once sprintf('%s/src/components/Icons.php', $root); ?>
<script src="/toggle.min.js" defer></script>