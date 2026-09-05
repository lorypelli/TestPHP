<?php
require_once sprintf('%s/src/classes/BaseConnection.php', $root);
require_once sprintf('%s/src/classes/Constants.php', $root);
class SessionTable extends BaseConnection
{
    public function __construct()
    {
        parent::__construct();
        $this->conn->exec(
            sprintf(
                'CREATE TABLE IF NOT EXISTS sessions (
                    id UUID PRIMARY KEY DEFAULT uuidv7(),
                    user_id UUID UNIQUE NOT NULL REFERENCES users(id),
                    token CHAR(%d) UNIQUE NOT NULL
                )',
                Constants::MAX_TOKEN_LENGTH,
            ),
        );
    }
    public function new(string $token, string $user_id): void
    {
        $this->delete_user($user_id);
        $hash = $this->hash($token);
        $res = $this->conn->prepare(
            'INSERT INTO sessions (token, user_id) VALUES (?, ?)',
        );
        $res->bindParam(1, $hash);
        $res->bindParam(2, $user_id);
        $res->execute();
    }
    public function delete(string $token): void
    {
        $hash = $this->hash($token);
        $res = $this->conn->prepare('DELETE FROM sessions WHERE token = ?');
        $res->bindParam(1, $hash);
        $res->execute();
    }
    public function get_user_email(string $token): string
    {
        $hash = $this->hash($token);
        $res = $this->conn->prepare(
            'SELECT u.email FROM sessions AS s JOIN users AS u ON s.user_id = u.id WHERE s.token = ?',
        );
        $res->bindParam(1, $hash);
        $res->execute();
        $row = $res->fetch();
        return $row ? $row->email : '';
    }
    public function get_user_password(string $token): string
    {
        $hash = $this->hash($token);
        $res = $this->conn->prepare(
            'SELECT u.password FROM sessions AS s JOIN users AS u ON s.user_id = u.id WHERE s.token = ?',
        );
        $res->bindParam(1, $hash);
        $res->execute();
        $row = $res->fetch();
        return $row ? $row->password : '';
    }
    private function hash(string $token): string
    {
        return hash('sha256', $token);
    }
    private function delete_user(string $user_id): void
    {
        $res = $this->conn->prepare('DELETE FROM sessions WHERE user_id = ?');
        $res->bindParam(1, $user_id);
        $res->execute();
    }
}
