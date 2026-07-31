<?php
declare(strict_types=1);

require_once __DIR__ . '/database.php';

function createMemberMessage(int $userId, array $data): int
{
    $statement = database()->prepare(
        'INSERT INTO member_messages (user_id, first_name, last_name, email, category, message)
         VALUES (:user_id, :first_name, :last_name, :email, :category, :message)'
    );
    $statement->execute([
        'user_id' => $userId,
        'first_name' => $data['first_name'],
        'last_name' => $data['last_name'],
        'email' => $data['email'],
        'category' => $data['category'],
        'message' => $data['message'],
    ]);
    return (int) database()->lastInsertId();
}
