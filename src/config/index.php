<?php
require_once sprintf('%s/src/classes/Page.php', $root);
return [
    'index' => new Page('Home', 'Application home page'),
    'login' => new Page('Login', 'Login with username and password'),
    'register' => new Page('Register', 'Create an account'),
    'verify' => new Page('Verify', 'Verify your email'),
    'logout' => new Page('Logout', 'Are you sure you want to logout?'),
    'settings' => new Page('Settings', 'Manage your account settings'),
    'reset' => new Page('Reset Password', 'Reset your password'),
    'change' => new Page('Change Email', 'Change your email'),
    'new/email' => new Page('New Email', 'Choose your new your email'),
    'new/password' => new Page('New Password', 'Choose your new your password'),
    'delete' => new Page(
        'Delete your Account',
        'Are you sure you want to delete your account?',
    ),
    'remove' => new Page(
        'Remove a Todo',
        'Are you sure you want to remove the todo?',
    ),
    'default' => new Page(
        'Reset to Default Avatar',
        'Are you sure you want to reset your avatar to the default one?',
    ),
];
