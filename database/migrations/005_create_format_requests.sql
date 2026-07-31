CREATE TABLE IF NOT EXISTS format_requests (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    applicant_name VARCHAR(190) NOT NULL,
    delivery_type ENUM('digital', 'envio') NOT NULL,
    requires_invoice TINYINT(1) NOT NULL DEFAULT 0,
    selected_formats TEXT NOT NULL,
    attachment_paths TEXT NOT NULL,
    total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    status ENUM('recibida', 'en_revision', 'atendida', 'cancelada') NOT NULL DEFAULT 'recibida',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT format_requests_user_fk FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE,
    INDEX format_requests_user_created_idx (user_id, created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
