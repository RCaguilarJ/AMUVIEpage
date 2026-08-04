ALTER TABLE users
    ADD COLUMN must_change_password TINYINT(1) NOT NULL DEFAULT 0 AFTER status;

CREATE TABLE IF NOT EXISTS document_categories (
    id SMALLINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(80) NOT NULL,
    name VARCHAR(120) NOT NULL,
    UNIQUE KEY document_categories_slug_unique (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS documents (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id SMALLINT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    original_name VARCHAR(255) NOT NULL,
    stored_path VARCHAR(255) NOT NULL,
    mime_type VARCHAR(120) NOT NULL,
    file_size BIGINT UNSIGNED NOT NULL,
    status ENUM('activo', 'inactivo') NOT NULL DEFAULT 'activo',
    uploaded_by BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT documents_category_fk FOREIGN KEY (category_id) REFERENCES document_categories (id) ON DELETE RESTRICT,
    CONSTRAINT documents_user_fk FOREIGN KEY (uploaded_by) REFERENCES users (id) ON DELETE RESTRICT,
    INDEX documents_category_status_idx (category_id, status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS admin_activity_log (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    admin_user_id BIGINT UNSIGNED NOT NULL,
    action VARCHAR(80) NOT NULL,
    entity_type VARCHAR(80) NOT NULL,
    entity_id BIGINT UNSIGNED NULL,
    details TEXT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT admin_activity_user_fk FOREIGN KEY (admin_user_id) REFERENCES users (id) ON DELETE RESTRICT,
    INDEX admin_activity_created_idx (created_at),
    INDEX admin_activity_entity_idx (entity_type, entity_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO document_categories (slug, name) VALUES
    ('comentarios-nom', 'Comentarios de la NOM'),
    ('biblioteca', 'Biblioteca de Documentos'),
    ('consejo-directivo', 'Documentos Consejo Directivo'),
    ('aranceles', 'Aranceles')
ON DUPLICATE KEY UPDATE name = VALUES(name);

INSERT INTO users (username, email, password_hash, full_name, status, must_change_password)
VALUES ('amuvie@admincom', 'administracion@amuvie.mx', '$2y$12$Clw.Mcu6FSD74bKbS8b8Guc/lZL55brYtJiDJRpsK.vAyGtLI.0ea', 'Administrador AMUVIE', 'activo', 1)
ON DUPLICATE KEY UPDATE status='activo';

INSERT IGNORE INTO user_roles (user_id, role_id)
SELECT u.id, r.id FROM users u JOIN roles r ON r.name IN ('administrador', 'usuario') WHERE u.username='amuvie@admincom';
