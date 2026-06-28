<?php
require_once sprintf('%s/src/classes/BaseConnection.php', $root);
class UserTodoTable extends BaseConnection
{
    public function __construct()
    {
        parent::__construct();
        $this->conn->exec(
            'CREATE TABLE IF NOT EXISTS users_todos (
                user_id UUID NOT NULL REFERENCES users(id),
                todo_id UUID NOT NULL REFERENCES todos(id),
                PRIMARY KEY (user_id, todo_id)
            )',
        );
    }
}
