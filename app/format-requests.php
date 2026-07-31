<?php
declare(strict_types=1);

require_once __DIR__ . '/database.php';

function createFormatRequest(int $userId, array $data, array $attachmentPaths): int
{
    $statement = database()->prepare(
        'INSERT INTO format_requests
            (user_id, applicant_name, delivery_type, requires_invoice, selected_formats, attachment_paths, total)
         VALUES
            (:user_id, :applicant_name, :delivery_type, :requires_invoice, :selected_formats, :attachment_paths, :total)'
    );
    $statement->execute([
        'user_id' => $userId,
        'applicant_name' => $data['applicant_name'],
        'delivery_type' => $data['delivery_type'],
        'requires_invoice' => $data['requires_invoice'] === '1' ? 1 : 0,
        'selected_formats' => json_encode($data['formats'], JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR),
        'attachment_paths' => json_encode($attachmentPaths, JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR),
        'total' => $data['delivery_type'] === 'envio' ? 250.00 : 0.00,
    ]);
    return (int) database()->lastInsertId();
}
