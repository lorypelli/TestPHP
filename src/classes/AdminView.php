<?php
require_once sprintf('%s/src/classes/BaseConnection.php', $root);
require_once sprintf('%s/src/classes/Admin.php', $root);
final class AdminView extends BaseConnection
{
    public function __construct()
    {
        parent::__construct();
        $this->conn->query(
            "CREATE OR REPLACE VIEW admin AS (
                SELECT u.email, u.username, t.name, t.description, t.is_done
                FROM users AS u
                JOIN todos AS t
                ON u.id = t.user_id
            )",
        );
    }
    /**
     * @return Admin[]
     */
    public function get_all(): array
    {
        $res = $this->conn->query('SELECT * FROM admin');
        $row = $res->fetchAll(
            PDO::FETCH_FUNC,
            fn(
                string $email,
                string $username,
                string $name,
                string $description,
                bool $is_done,
            ): Admin => new Admin(
                $email,
                $username,
                new Todo($name, $description, $is_done),
            ),
        );
        return $row;
    }
}
