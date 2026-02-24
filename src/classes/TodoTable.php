<?php
require_once sprintf('%s/src/classes/BaseConnection.php', $root);
require_once sprintf('%s/src/classes/Constants.php', $root);
require_once sprintf('%s/src/classes/Todo.php', $root);
final class TodoTable extends BaseConnection
{
    public function __construct()
    {
        parent::__construct();
        $this->conn->query(
            sprintf(
                "CREATE TABLE IF NOT EXISTS todos (
                    id UUID PRIMARY KEY DEFAULT gen_random_uuid(),
                    user_id UUID,
                    name VARCHAR(%d) UNIQUE NOT NULL,
                    description VARCHAR(%d) NOT NULL,
                    is_done BOOLEAN NOT NULL DEFAULT FALSE,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                )",
                Constants::MAX_NAME_LENGTH,
                Constants::MAX_DESCRIPTION_LENGTH,
            ),
        );
    }
    public function new(
        string $name,
        string $description,
        bool $is_done,
        string $user_id,
    ): void {
        $res = $this->conn->prepare(
            'INSERT INTO todos (name, description, is_done, user_id) VALUES (?, ?, ?, ?)',
        );
        $res->bindParam(1, $name);
        $res->bindParam(2, $description);
        $res->bindParam(3, $is_done, PDO::PARAM_BOOL);
        $res->bindParam(4, $user_id);
        $res->execute();
    }
    public function check(string $id): bool
    {
        $is_valid = Ramsey\Uuid\Uuid::isValid($id);
        if (!$is_valid) {
            return false;
        }
        $res = $this->conn->prepare(
            'SELECT EXISTS(SELECT 1 FROM todos WHERE id = ?)',
        );
        $res->bindParam(1, $id);
        $res->execute();
        $exists = $res->fetchColumn();
        return $exists;
    }
    public function check_name(string $name): bool
    {
        $res = $this->conn->prepare(
            'SELECT EXISTS(SELECT 1 FROM todos WHERE name = ?)',
        );
        $res->bindParam(1, $name);
        $res->execute();
        $exists = $res->fetchColumn();
        return $exists;
    }
    public function get_id(string $user_id, string $name): string
    {
        $res = $this->conn->prepare(
            'SELECT id FROM todos WHERE user_id = ? AND name = ?',
        );
        $res->bindParam(1, $user_id);
        $res->bindParam(2, $name);
        $res->execute();
        $row = $res->fetch();
        return $row ? $row->id : '';
    }
    /**
     * @return Todo[]
     */
    public function get_all(string $user_id): array
    {
        $res = $this->conn->prepare(
            'SELECT name, description, is_done FROM todos WHERE user_id = ?',
        );
        $res->bindParam(1, $user_id);
        $res->execute();
        $row = $res->fetchAll(
            PDO::FETCH_FUNC,
            fn(
                string $name,
                string $description,
                bool $is_done,
            ): Todo => new Todo($name, $description, $is_done),
        );
        return $row;
    }
    public function set(
        string $name,
        string $description,
        bool $is_done,
        string $user_id,
        string $id,
    ): void {
        $res = $this->conn->prepare(
            'UPDATE todos SET name = ?, description = ?, is_done = ? WHERE user_id = ? AND id = ?',
        );
        $res->bindParam(1, $name);
        $res->bindParam(2, $description);
        $res->bindParam(3, $is_done, PDO::PARAM_BOOL);
        $res->bindParam(4, $user_id);
        $res->bindParam(5, $id);
        $res->execute();
    }
    public function delete(string $user_id, string $name): void
    {
        $res = $this->conn->prepare(
            'DELETE FROM todos WHERE user_id = ? AND name = ?',
        );
        $res->bindParam(1, $user_id);
        $res->bindParam(2, $name);
        $res->execute();
    }
}
