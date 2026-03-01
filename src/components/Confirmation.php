<?php
require_once sprintf('%s/src/enums/Type.php', $root);
$is_logout = $type == Type::Logout;
$is_delete = $type == Type::Delete;
$is_reset = $type == Type::Reset;
$action = 'remove';
$actions = [
    'remove' => 'remove the todo',
    'logout' => 'logout',
    'delete' => 'delete your account',
    'default' => 'reset your avatar to the default one',
];
if ($is_logout) {
    $action = 'logout';
} elseif ($is_delete) {
    $action = 'delete';
} elseif ($is_reset) {
    $action = 'default';
}
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