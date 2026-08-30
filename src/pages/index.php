<?php
require_once sprintf('%s/src/utils/when.php', $root);
$messages = require_once sprintf('%s/src/enums/AppError.php', $root);
$error = $_SESSION['error'] ?? '';
$user_id = $users->get_id($email);
?>
<?php if (!$is_logged): ?>
    <div class="flex h-screen flex-col justify-center text-center">
        <span class="text-6xl font-bold italic">Login to see the rest of the page!</span>
    </div>
<?php else: ?>
    <div class="grid gap-y-1 p-1 text-center">
        <?php if (isset($messages[$error])): ?>
            <?php include_once sprintf('%s/src/components/Error.php', $root); ?>
        <?php endif; ?>
        <?php foreach ($todos->get_all($user_id) as $t): ?>
            <?php
            $name = htmlspecialchars($t->get_name());
            $id = htmlspecialchars($todos->get_id($user_id, $name));
            ?>
            <form <?= when($id, sprintf('data-todo="%s"', $id)) ?> method="POST"
                class="flex cursor-not-allowed items-center justify-center gap-x-2 sm:gap-x-4 md:gap-x-8 lg:gap-x-12 xl:gap-x-16 2xl:gap-x-20"
                action="/api/remove">
                <span class="font-bold">Done:</span>
                <input name="is_done" type="checkbox" disabled <?= when(
                    $t->get_is_done(),
                    'checked',
                ) ?> class="size-7 cursor-not-allowed appearance-none rounded-md border-2 bg-red-600 after:flex after:justify-center after:text-white after:content-['✕'] checked:bg-blue-600 checked:after:content-['✓'] focus:outline-none" />
                <span class="font-bold">Name:</span>
                <input name="name" autocomplete="off" readonly value="<?= $name ?>"
                    class="w-[20vw] cursor-not-allowed text-center focus:outline-none" />
                <span class="font-bold">Description:</span>
                <input name="description" autocomplete="off" readonly value="<?= htmlspecialchars(
                    $t->get_description(),
                ) ?>" class="w-[20vw] cursor-not-allowed text-center focus:outline-none" />
                <button type="button" class="cursor-pointer rounded-md border-2 p-1"
                    onclick="openDialog('<?= $id ?>')">Edit!</button>
                <button type="submit" class="cursor-pointer rounded-md border-2 p-1">Remove!</button>
            </form>
        <?php endforeach; ?>
        <button class="cursor-pointer rounded-md border-2 p-1" onclick="openDialog()">Add!</button>
    </div>
    <dialog>
        <div data-dialog
            class="fixed inset-0 flex h-screen flex-col items-center justify-center not-data-open:animate-both-reverse data-open:animate-both">
            <div data-draggable="true" class="flex cursor-move touch-none flex-col items-center rounded-md p-5 shadow-2xl">
                <button class="cursor-pointer rounded-md border-2 p-1" onclick="closeDialog()">
                    <?php include_once sprintf('%s/svg/close.php', $root); ?>
                </button>
                <form method="POST" class="flex flex-col items-center justify-center gap-y-1">
                    <span>Done:</span>
                    <input name="is_done" type="checkbox"
                        class="size-7 cursor-pointer appearance-none rounded-md border-2 bg-red-600 after:flex after:justify-center after:text-white after:content-['✕'] checked:bg-blue-600 checked:after:content-['✓'] focus:outline-none" />
                    <span>Name:</span>
                    <input data-draggable="false" name="name" autocomplete="off"
                        maxlength="<?= Constants::MAX_NAME_LENGTH ?>" required class="w-60 rounded-md border-2 p-1" />
                    <span>Description:</span>
                    <textarea data-draggable="false" name="description" autocomplete="off"
                        maxlength="<?= Constants::MAX_DESCRIPTION_LENGTH ?>"
                        class="w-60 resize-none rounded-md border-2 p-1"></textarea>
                    <button type="submit" class="cursor-pointer rounded-md border-2 p-1">Continue!</button>
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
