<?php
require_once sprintf('%s/src/utils/send_email.php', $root);
$messages = require_once sprintf('%s/src/enums/AppError.php', $root);
$is_post = isset($_POST['id']);
$error = $_SESSION['error'] ?? '';
$email = $_SESSION['email'] ?? ($_POST['email'] ?? '');
if (!$is_post) {
    $code = $_SESSION['code'] ?? '';
    send_email($email, $code, 'register');
} else {
    $code = $_POST['code'] ?? '';
}
if (!$email) {
    redirect('/');
}
?>
<?php if ($is_post): ?>
    <script>history.pushState(null, '', '/verify');</script>
<?php endif; ?>
<form method="POST" class="flex flex-col justify-center items-center gap-y-1 h-screen" action="/api/verify">
    <?php if (isset($messages[$error])): ?>
        <?php include_once sprintf('%s/src/components/Error.php', $root); ?>
    <?php endif; ?>
    <span data-code class="font-bold text-xl text-center">A verification code has been sent to <?= htmlspecialchars(
        $email,
    ) ?>!</span>
    <?php if (!$is_valid_email): ?>
        <style>
            [data-code] {
                text-decoration: line-through;
            }
        </style>
        <span class="font-bold">The verification code is: <?= htmlspecialchars(
            $code,
        ) ?></span>
    <?php endif; ?>
    <div class="flex gap-x-1">
        <?php foreach (range(0, 5) as $i): ?>
            <input name="digit[]" autocomplete="off" type="number" min="0" max="9" <?= $i ==
            0
                ? 'autofocus'
                : '' ?> required <?= $is_post
     ? sprintf('value="%s"', $code[$i])
     : '' ?>
                class="disabled:bg-gray-200 p-1 border-2 rounded-md w-12 text-center disabled:cursor-not-allowed" />
        <?php endforeach; ?>
    </div>
    <button type="submit" class="p-1 border-2 rounded-md cursor-pointer">Verify!</button>
    <script src="/input.min.js" defer></script>
</form>