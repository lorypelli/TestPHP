<?php
$messages = require_once sprintf('%s/src/enums/AppError.php', $root);
$error = $_SESSION['error'] ?? '';
?>
<form method="POST" enctype="multipart/form-data" class="flex flex-col justify-center items-center gap-y-1 h-screen" action="/api/settings">
    <?php if (isset($messages[$error])): ?>
        <?php include_once sprintf('%s/src/components/Error.php', $root); ?>
    <?php endif; ?>
    <span>Username:</span>
    <input name="username" autocomplete="off" maxlength="<?= Constants::MAX_NAME_LENGTH ?>" value="<?= htmlspecialchars(
    $users->get_username($email),
) ?>" class="p-1 border-2 rounded-md" />
    <span>Avatar:</span>
    <input name="avatar" type="file" accept="image/*" class="p-1 border-2 rounded-md cursor-pointer" />
    <span>Do you want to reset your password? You can <a href="/reset" class="text-blue-600 hover:underline">do it
            here</a>!</span>
    <span>Do you want to change your email? You can <a href="/change" class="text-blue-600 hover:underline">do it
            here</a>!</span>
    <details>
        <summary class="text-center cursor-pointer">Dangerous settings!</summary>
        <span>Do you want to delete your account? Just <a href="/delete?skip-confirmation"
                class="text-blue-600 hover:underline">click here</a>!</span>
    </details>
    <button type="submit" class="p-1 border-2 rounded-md cursor-pointer">Save!</button>
</form>