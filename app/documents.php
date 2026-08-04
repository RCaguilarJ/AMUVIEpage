<?php
declare(strict_types=1);

require_once __DIR__ . '/database.php';

function publishedDocuments(string $categorySlug): array
{
    $statement = database()->prepare(
        "SELECT d.id, d.title, d.description, d.original_name, d.stored_path, d.mime_type, d.file_size, d.created_at
         FROM documents d JOIN document_categories c ON c.id=d.category_id
         WHERE c.slug=:slug AND d.status='activo'
         ORDER BY d.created_at DESC, d.id DESC"
    );
    $statement->execute(['slug' => $categorySlug]);
    return $statement->fetchAll();
}
