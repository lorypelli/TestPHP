<?php
require_once sprintf('%s/src/classes/Todo.php', $root);
final class Admin
{
    private string $email;
    private string $username;
    private bool $is_verified;
    private Todo $todo;
    public function __construct(
        string $email,
        string $username,
        bool $is_verified,
        Todo $todo,
    ) {
        $this->email = $email;
        $this->username = $username;
        $this->is_verified = $is_verified;
        $this->todo = $todo;
    }
    public function get_email(): string
    {
        return $this->email;
    }
    public function get_username(): string
    {
        return $this->username;
    }
    public function get_is_verified(): string
    {
        return $this->is_verified;
    }
    public function get_todo(): Todo
    {
        return $this->todo;
    }
}
