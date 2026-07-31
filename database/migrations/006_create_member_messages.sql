CREATE TABLE IF NOT EXISTS member_messages (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL,
    category ENUM('administracion', 'soporte', 'facturacion', 'formatos', 'directorio', 'otro') NOT NULL,
    message TEXT NOT NULL,
    status ENUM('recibido', 'en_revision', 'respondido', 'cerrado') NOT NULL DEFAULT 'recibido',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT member_messages_user_fk FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    INDEX member_messages_user_created_idx (user_id, created_at),
    INDEX member_messages_status_idx (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
