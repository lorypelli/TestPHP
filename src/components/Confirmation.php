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
<form method="POST" class="flex flex-col justify-center items-center gap-y-1 h-screen" action="<?= sprintf(
    '/api/%s',
    $action,
) ?>">
    <span class="font-bold text-xl">Are you sure you want to <?= $actions[
        $action
    ] ?>?</span>
    <div class="flex gap-x-1">
        <button type="submit" class="p-1 border-2 rounded-md cursor-pointer">Yes!</button>
        <a href="/">
            <button type="button" class="p-1 border-2 rounded-md cursor-pointer">No!</button>
        </a>
    </div>
</form>