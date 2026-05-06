<?php
require_once sprintf('%s/src/classes/BaseConnection.php', $root);
require_once sprintf('%s/src/classes/Constants.php', $root);
require_once sprintf('%s/src/classes/User.php', $root);
final class UserTable extends BaseConnection
{
    public function __construct()
    {
        parent::__construct();
        $this->conn->query(
            sprintf(
                'CREATE TABLE IF NOT EXISTS users (
                    id UUID PRIMARY KEY DEFAULT uuidv7(),
                    email VARCHAR(%d) UNIQUE NOT NULL,
                    password VARCHAR(%d) NOT NULL,
                    username VARCHAR(%d) NOT NULL,
                    avatar TEXT NOT NULL DEFAULT \'\',
                    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW(),
                    verified_at TIMESTAMPTZ DEFAULT NULL,
                    verification_code VARCHAR(%d) NOT NULL DEFAULT \'\'
                )',
                Constants::MAX_EMAIL_LENGTH,
                Constants::MAX_PASSWORD_LENGTH,
                Constants::MAX_NAME_LENGTH,
                Constants::MAX_CODE_LENGTH,
            ),
        );
    }
    public function new(string $email, string $password, string $username): void
    {
        $res = $this->conn->prepare(
            'INSERT INTO users (email, password, username) VALUES (?, ?, ?)',
        );
        $res->bindParam(1, $email);
        $res->bindParam(2, $password);
        $res->bindParam(3, $username);
        $res->execute();
    }
    public function check(string $email, string $password): bool
    {
        $res = $this->conn->prepare(
            'SELECT password FROM users WHERE email = ?',
        );
        $res->bindParam(1, $email);
        $res->execute();
        $row = $res->fetch();
        return $row && password_verify($password, $row->password);
    }
    public function check_hash(string $email, string $hash): bool
    {
        $res = $this->conn->prepare(
            'SELECT password FROM users WHERE email = ?',
        );
        $res->bindParam(1, $email);
        $res->execute();
        $row = $res->fetch();
        return $row && hash_equals($row->password, $hash);
    }
    public function check_email(string $email): bool
    {
        $res = $this->conn->prepare(
            'SELECT EXISTS(SELECT 1 FROM users WHERE email = ?)',
        );
        $res->bindParam(1, $email);
        $res->execute();
        $exists = $res->fetchColumn();
        return $exists;
    }
    public function get(string $email, string $password): ?User
    {
        $res = $this->conn->prepare(
            'SELECT email, password FROM users WHERE email = ?',
        );
        $res->bindParam(1, $email);
        $res->execute();
        $row = $res->fetch();
        if ($row && password_verify($password, $row->password)) {
            return new User($row->email, $row->password);
        }
        return null;
    }
    public function get_id(string $email): string
    {
        $res = $this->conn->prepare('SELECT id FROM users WHERE email = ?');
        $res->bindParam(1, $email);
        $res->execute();
        $row = $res->fetch();
        return $row ? $row->id : '';
    }
    public function get_username(string $email): string
    {
        $res = $this->conn->prepare(
            'SELECT username FROM users WHERE email = ?',
        );
        $res->bindParam(1, $email);
        $res->execute();
        $row = $res->fetch();
        return $row ? $row->username : '';
    }
    public function get_avatar(string $email): string
    {
        $res = $this->conn->prepare('SELECT avatar FROM users WHERE email = ?');
        $res->bindParam(1, $email);
        $res->execute();
        $row = $res->fetch();
        return $row ? $row->avatar : '';
    }
    public function get_verification_code(string $email): string
    {
        $res = $this->conn->prepare(
            'SELECT verification_code FROM users WHERE email = ?',
        );
        $res->bindParam(1, $email);
        $res->execute();
        $row = $res->fetch();
        return $row ? $row->verification_code : '';
    }
    public function get_created_at(string $email): ?DateTimeImmutable
    {
        $res = $this->conn->prepare(
            'SELECT created_at FROM users WHERE email = ?',
        );
        $res->bindParam(1, $email);
        $res->execute();
        $row = $res->fetch() ?: null;
        if ($row?->created_at) {
            return new DateTimeImmutable($row->created_at);
        }
        return null;
    }
    public function get_verified_at(string $email): ?DateTimeImmutable
    {
        $res = $this->conn->prepare(
            'SELECT verified_at FROM users WHERE email = ?',
        );
        $res->bindParam(1, $email);
        $res->execute();
        $row = $res->fetch() ?: null;
        if ($row?->verified_at) {
            return new DateTimeImmutable($row->verified_at);
        }
        return null;
    }
    public function set_username(string $email, string $username): void
    {
        $res = $this->conn->prepare(
            'UPDATE users SET username = ? WHERE email = ?',
        );
        $res->bindParam(1, $username);
        $res->bindParam(2, $email);
        $res->execute();
    }
    public function set_avatar(string $email, string $avatar): void
    {
        $res = $this->conn->prepare(
            'UPDATE users SET avatar = ? WHERE email = ?',
        );
        $res->bindParam(1, $avatar);
        $res->bindParam(2, $email);
        $res->execute();
    }
    public function set_password(string $email, string $password): void
    {
        $res = $this->conn->prepare(
            'UPDATE users SET password = ? WHERE email = ?',
        );
        $res->bindParam(1, $password);
        $res->bindParam(2, $email);
        $res->execute();
    }
    public function set_verification_code(string $email, string $code): void
    {
        $res = $this->conn->prepare(
            'UPDATE users SET verification_code = ? WHERE email = ?',
        );
        $res->bindParam(1, $code);
        $res->bindParam(2, $email);
        $res->execute();
    }
    private function set_verified_at(string $email, string $verified_at): void
    {
        $res = $this->conn->prepare(
            'UPDATE users SET verified_at = ? WHERE email = ?',
        );
        $res->bindParam(1, $verified_at);
        $res->bindParam(2, $email);
        $res->execute();
    }
    public function set_email(string $old_email, string $email): void
    {
        $res = $this->conn->prepare(
            'UPDATE users SET email = ? WHERE email = ?',
        );
        $res->bindParam(1, $email);
        $res->bindParam(2, $old_email);
        $res->execute();
    }
    public function verify(string $email): void
    {
        $this->set_verified_at($email, 'NOW()');
        $this->set_verification_code($email, '');
    }
    public function delete(string $email): void
    {
        try {
            $this->conn->beginTransaction();
            $id = $this->get_id($email);
            $res = $this->conn->prepare('DELETE FROM todos WHERE user_id = ?');
            $res->bindParam(1, $id);
            $res->execute();
            $res = $this->conn->prepare('DELETE FROM users WHERE email = ?');
            $res->bindParam(1, $email);
            $res->execute();
            $this->conn->commit();
        } catch (Exception) {
            $this->conn->rollBack();
        }
    }
}
