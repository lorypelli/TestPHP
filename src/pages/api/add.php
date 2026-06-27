<?php
$name = $_POST['name'] ?? '';
if ($todos->check_name($users->get_id($email), $name)) {
    $_SESSION['error'] = 'todo_already_exists';
    redirect('/');
    exit(1);
}
if (strlen($name) > Constants::MAX_NAME_LENGTH) {
    $_SESSION['error'] = 'todo_name_too_long';
    redirect('/');
    exit(1);
}
$description = $_POST['description'] ?? '';
if (strlen($description) > Constants::MAX_DESCRIPTION_LENGTH) {
    $_SESSION['error'] = 'todo_description_too_long';
    redirect('/');
    exit(1);
}
$is_done = isset($_POST['is_done']);
$todos->new($name, $description, $is_done, $users->get_id($email));
redirect('/');
