<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require_once sprintf('%s/vendor/autoload.php', $root);
require_once sprintf('%s/src/classes/AdminView.php', $root);
require_once sprintf('%s/src/utils/buffer.php', $root);
require_once sprintf('%s/src/utils/when.php', $root);
Dotenv\Dotenv::createImmutable($root)->load();
$admin = new AdminView();
ob_start(buffer(...));
?>
<!DOCTYPE html>
<html lang="en">

<?php include_once sprintf('%s/src/components/Header.php', $root); ?>

<body class="flex flex-col p-2">
    <table class="border-separate rounded-md border-2">
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
                            class="size-10 rounded-full" />
                    </td>
                    <td>
                        <input autocomplete="off" readonly value="<?= $a->get_email() ?>"
                            class="w-[20vw] cursor-not-allowed text-center focus:outline-none" />
                    </td>
                    <td>
                        <input autocomplete="off" readonly value="<?= $a->get_username() ?>"
                            class="w-[20vw] cursor-not-allowed text-center focus:outline-none" />
                    </td>
                    <td>
                        <input type="checkbox" disabled <?= when(
                            $a->get_is_verified(),
                            'checked',
                        ) ?> class="size-7 cursor-not-allowed appearance-none rounded-md border-2 bg-red-600 after:flex after:justify-center after:text-white after:content-['✕'] checked:bg-blue-600 checked:after:content-['✓'] focus:outline-none" />
                    </td>
                    <td>
                        <input autocomplete="off" readonly value="<?= $t->get_name() ?>"
                            class="w-[20vw] cursor-not-allowed text-center focus:outline-none" />
                    </td>
                    <td>
                        <input autocomplete="off" readonly value="<?= $t->get_description() ?>"
                            class="w-[20vw] cursor-not-allowed text-center focus:outline-none" />
                    </td>
                    <td>
                        <input type="checkbox" disabled <?= when(
                            $t->get_is_done(),
                            'checked',
                        ) ?> class="size-7 cursor-not-allowed appearance-none rounded-md border-2 bg-red-600 after:flex after:justify-center after:text-white after:content-['✕'] checked:bg-blue-600 checked:after:content-['✓'] focus:outline-none" />
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>
<?php ob_end_flush(); ?>
