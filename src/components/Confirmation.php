<?php
require_once sprintf('%s/src/enums/Type.php', $root);
$actions = [
    'remove' => 'remove the todo',
    'logout' => 'logout',
    'delete' => 'delete your account',
    'default' => 'reset your avatar to the default one',
];
$action = match ($type) {
    Type::Logout => 'logout',
    Type::Delete => 'delete',
    Type::Reset => 'default',
    Type::Remove => 'remove',
};
?>
<form method="POST" class="flex h-screen flex-col items-center justify-center gap-y-1" action="<?= sprintf(
    '/api/%s',
    $action,
) ?>">
    <span class="text-xl font-bold">Are you sure you want to <?= $actions[
        $action
    ] ?>?</span>
    <div class="flex gap-x-1">
        <button type="submit" class="cursor-pointer rounded-md border-2 p-1">Yes!</button>
        <a href="/">
            <button type="button" class="cursor-pointer rounded-md border-2 p-1">No!</button>
        </a>
    </div>
</form>