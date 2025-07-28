<?php
namespace App\Libraries;

class AllowedUsers
{
    private string $file;

    public function __construct()
    {
        $this->file = WRITEPATH . 'allowed_users.json';
        if (!is_file($this->file)) {
            file_put_contents($this->file, json_encode([], JSON_PRETTY_PRINT));
        }
    }

    public function getUsers(): array
    {
        $data = json_decode(file_get_contents($this->file), true);
        return is_array($data) ? $data : [];
    }

    public function findByEmail(string $email): ?array
    {
        foreach ($this->getUsers() as $user) {
            if (strcasecmp($user['email'] ?? '', $email) === 0) {
                return $user;
            }
        }
        return null;
    }

    public function saveUsers(array $users): void
    {
        file_put_contents($this->file, json_encode($users, JSON_PRETTY_PRINT));
    }

    public function addUser(string $email, array $apps, bool $isAdmin = false): void
    {
        $users = $this->getUsers();
        $users[] = ['email' => $email, 'apps' => $apps, 'is_admin' => $isAdmin];
        $this->saveUsers($users);
    }

    public function removeUser(string $email): void
    {
        $users = array_filter($this->getUsers(), fn ($u) => strcasecmp($u['email'] ?? '', $email) !== 0);
        $this->saveUsers(array_values($users));
    }
}
