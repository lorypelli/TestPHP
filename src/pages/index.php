<?php
require_once sprintf('%s/src/utils/when.php', $root);
$messages = require_once sprintf('%s/src/enums/AppError.php', $root);
$error = $_SESSION['error'] ?? '';
$user_id = $email ? $users->get_id($email) : '';
?>
<?php if (!$is_logged): ?>
    <div class="flex flex-col justify-center h-screen text-center">
        <span class="font-bold text-6xl italic">Login to see the rest of the page!</span>
    </div>
<?php else: ?>
    <div class="gap-y-1 grid p-1 text-center">
        <?php if (isset($messages[$error])): ?>
            <?php include_once sprintf('%s/src/components/Error.php', $root); ?>
        <?php endif; ?>
        <?php foreach ($todos->get_all($user_id) as $t): ?>
            <?php
            $name = htmlspecialchars($t->get_name());
            $id = htmlspecialchars($todos->get_id($user_id, $name));
            ?>
            <form <?= when($id, sprintf('data-todo="%s"', $id)) ?> method="POST"
                class="flex justify-center items-center gap-x-2 sm:gap-x-4 md:gap-x-8 lg:gap-x-12 2xl:gap-x-20 xl:gap-x-16 cursor-not-allowed"
                action="/api/remove">
                <span class="font-bold">Done:</span>
                <input name="is_done" type="checkbox" disabled <?= when(
                    $t->get_is_done(),
                    'checked',
                ) ?> class="after:flex after:justify-center bg-red-600 checked:bg-blue-600 border-2 rounded-md focus:outline-none size-7 after:text-white after:content-['✕'] checked:after:content-['✓'] appearance-none cursor-not-allowed" />
                <span class="font-bold">Name:</span>
                <input name="name" autocomplete="off" readonly value="<?= $name ?>"
                    class="focus:outline-none w-[20vw] text-center cursor-not-allowed" />
                <span class="font-bold">Description:</span>
                <input name="description" autocomplete="off" readonly value="<?= htmlspecialchars(
                    $t->get_description(),
                ) ?>" class="focus:outline-none w-[20vw] text-center cursor-not-allowed" />
                <button type="button" class="p-1 border-2 rounded-md cursor-pointer"
                    onclick="openDialog('<?= $id ?>')">Edit!</button>
                <button type="submit" class="p-1 border-2 rounded-md cursor-pointer">Remove!</button>
            </form>
        <?php endforeach; ?>
        <button class="p-1 border-2 rounded-md cursor-pointer" onclick="openDialog()">Add!</button>
    </div>
    <dialog>
        <div data-dialog
            class="fixed inset-0 flex flex-col justify-center items-center h-screen data-open:animate-both not-data-open:animate-both-reverse">
            <div data-draggable class="flex flex-col items-center shadow-2xl p-5 rounded-md touch-none cursor-move">
                <button class="p-1 border-2 rounded-md cursor-pointer" onclick="closeDialog()">
                    <?php include_once sprintf('%s/svg/close.php', $root); ?>
                </button>
                <form method="POST" class="flex flex-col justify-center items-center gap-y-1">
                    <span>Done:</span>
                    <input name="is_done" type="checkbox"
                        class="after:flex after:justify-center bg-red-600 checked:bg-blue-600 border-2 rounded-md focus:outline-none size-7 after:text-white after:content-['✕'] checked:after:content-['✓'] appearance-none cursor-pointer" />
                    <span>Name:</span>
                    <input data-not-draggable name="name" autocomplete="off" maxlength="<?= Constants::MAX_NAME_LENGTH ?>"
                        required class="p-1 border-2 rounded-md w-60" />
                    <span>Description:</span>
                    <textarea data-not-draggable name="description" autocomplete="off"
                        maxlength="<?= Constants::MAX_DESCRIPTION_LENGTH ?>"
                        class="p-1 border-2 rounded-md w-60 resize-none"></textarea>
                    <button type="submit" class="p-1 border-2 rounded-md cursor-pointer">Continue!</button>
                </form>
            </div>
        </div>
    </dialog>
    <script src="/dialog.min.js" defer></script>
    <script src="/drag.min.js" defer></script>
    <?php if ($is_valid_todo): ?>
        <script>document.addEventListener('DOMContentLoaded', () => openDialog('<?= $todo_id ?>'));</script>
    <?php endif; ?>
<?php endif; ?>
