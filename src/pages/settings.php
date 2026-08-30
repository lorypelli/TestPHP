<?php
$messages = require_once sprintf('%s/src/enums/AppError.php', $root);
$error = $_SESSION['error'] ?? '';
?>
<form method="POST" enctype="multipart/form-data" class="flex h-screen flex-col items-center justify-center gap-y-1"
    action="/api/settings">
    <?php if (isset($messages[$error])): ?>
        <?php include_once sprintf('%s/src/components/Error.php', $root); ?>
    <?php endif; ?>
    <span>Username:</span>
    <input name="username" autocomplete="off" maxlength="<?= Constants::MAX_NAME_LENGTH ?>" value="<?= htmlspecialchars(
    $users->get_username($email),
) ?>" class="rounded-md border-2 p-1" />
    <span>Avatar:</span>
    <div class="flex gap-x-1">
        <input name="avatar" type="file" accept="image/*" class="cursor-pointer rounded-md border-2 p-1" />
        <a href="/default"><button type="button" class="cursor-pointer rounded-md border-2 p-1">Reset!</button></a>
    </div>
    <span>Do you want to reset your password? You can <a href="/reset" class="text-blue-600 hover:underline">do it
            here</a>!</span>
    <span>Do you want to change your email? You can <a href="/change" class="text-blue-600 hover:underline">do it
            here</a>!</span>
    <details>
        <summary class="cursor-pointer text-center">Dangerous settings!</summary>
        <span>Do you want to delete your account? Just <a href="/delete?skip-confirmation"
                class="text-blue-600 hover:underline">click here</a>!</span>
    </details>
    <button type="submit" class="cursor-pointer rounded-md border-2 p-1">Save!</button>
</form>