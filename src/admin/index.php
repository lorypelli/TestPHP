<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once sprintf('%s/vendor/autoload.php', $root);
require_once sprintf('%s/src/classes/AdminView.php', $root);
require_once sprintf('%s/src/utils/buffer.php', $root);
Dotenv\Dotenv::createImmutable($root)->load();
$admin = new AdminView();
ob_start(buffer(...));
?>
<!DOCTYPE html>
<html lang="en">

<?php include_once sprintf('%s/src/components/Header.php', $root); ?>

<body class="flex flex-col p-2">
    <table class="border-2 rounded-md border-separate">
        <thead>
            <th>Avatar</th>
            <th>Email</th>
            <th>Username</th>
            <th>Is Verified</th>
            <th>Todo Name</th>
            <th>Todo Description</th>
            <th>Todo IsDone</th>
        </thead>
        <tbody>
            <?php foreach ($admin->get_all() as $a): ?>
                <?php $t = $a->get_todo(); ?>
                <tr class="text-center">
                    <td>
                        <img src="/admin/avatar?email=<?= $a->get_email() ?>" loading="lazy" decoding="async"
                            class="rounded-full size-10" />
                    </td>
                    <td>
                        <input autocomplete="off" readonly value="<?= $a->get_email() ?>"
                            class="focus:outline-none w-[20vw] text-center cursor-not-allowed" />
                    </td>
                    <td>
                        <input autocomplete="off" readonly value="<?= $a->get_username() ?>"
                            class="focus:outline-none w-[20vw] text-center cursor-not-allowed" />
                    </td>
                    <td>
                        <input type="checkbox" disabled <?= htmlspecialchars(
                            $a->get_is_verified(),
                        )
                            ? 'checked'
                            : '' ?> class="after:flex after:justify-center bg-red-600 checked:bg-blue-600 border-2 rounded-md focus:outline-none size-7 after:text-white after:content-['✕'] checked:after:content-['✓'] appearance-none cursor-not-allowed" />
                    </td>
                    <td>
                        <input autocomplete="off" readonly value="<?= $t->get_name() ?>"
                            class="focus:outline-none w-[20vw] text-center cursor-not-allowed" />
                    </td>
                    <td>
                        <input autocomplete="off" readonly value="<?= $t->get_description() ?>"
                            class="focus:outline-none w-[20vw] text-center cursor-not-allowed" />
                    </td>
                    <td>
                        <input type="checkbox" disabled <?= htmlspecialchars(
                            $t->get_is_done(),
                        )
                            ? 'checked'
                            : '' ?> class="after:flex after:justify-center bg-red-600 checked:bg-blue-600 border-2 rounded-md focus:outline-none size-7 after:text-white after:content-['✕'] checked:after:content-['✓'] appearance-none cursor-not-allowed" />
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>
<?php ob_end_flush(); ?>
