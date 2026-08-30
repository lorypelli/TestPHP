<?php
require_once sprintf('%s/src/enums/Type.php', $root);
$is_login = $type == Type::Login;
?>
<span>Email:</span>
<input name="email" autocomplete="off" type="email" required class="w-60 rounded-md border-2 p-1" />
<span>Password:</span>
<div data-pwd class="relative flex flex-row-reverse">
    <?php include sprintf('%s/src/components/CapsLock.php', $root); ?>
    <input name="password" autocomplete="off" type="password" required class="w-60 rounded-md border-2 px-8 py-1" />
    <?php include sprintf('%s/src/components/Toggle.php', $root); ?>
</div>
<?php if (!$is_login): ?>
    <span>Repeat Password:</span>
    <div data-pwd class="relative flex flex-row-reverse">
        <?php include sprintf('%s/src/components/CapsLock.php', $root); ?>
        <input name="repeat_password" autocomplete="off" type="password" required
            class="w-60 rounded-md border-2 px-8 py-1" />
        <?php include sprintf('%s/src/components/Toggle.php', $root); ?>
    </div>
    <span>Username:</span>
    <input name="username" autocomplete="off" maxlength="<?= Constants::MAX_NAME_LENGTH ?>" required
        class="w-60 rounded-md border-2 p-1" />
<?php endif; ?>
<?php include_once sprintf('%s/src/components/Icons.php', $root); ?>
<?php include_once sprintf('%s/src/components/Turnstile.php', $root); ?>
<script src="/toggle.min.js" defer></script>