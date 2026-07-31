ALTER TABLE user_profiles
    ADD COLUMN birth_date DATE NULL AFTER website,
    ADD COLUMN biography TEXT NULL AFTER birth_date,
    ADD COLUMN business_name VARCHAR(190) NULL AFTER biography,
    ADD COLUMN tax_id VARCHAR(20) NULL AFTER business_name,
    ADD COLUMN business_address VARCHAR(190) NULL AFTER tax_id,
    ADD COLUMN exterior_number VARCHAR(20) NULL AFTER business_address,
    ADD COLUMN neighborhood VARCHAR(120) NULL AFTER exterior_number,
    ADD COLUMN municipality VARCHAR(120) NULL AFTER neighborhood,
    ADD COLUMN postal_code VARCHAR(10) NULL AFTER municipality,
    ADD COLUMN cfdi_use VARCHAR(100) NULL AFTER postal_code,
    ADD COLUMN payment_method VARCHAR(60) NULL AFTER cfdi_use,
    ADD COLUMN business_phone VARCHAR(30) NULL AFTER payment_method,
    ADD COLUMN business_email VARCHAR(190) NULL AFTER business_phone;

INSERT INTO users (username, email, password_hash, full_name, status)
VALUES ('demo', 'demo@demo.com', '$2y$12$DZW2vZwlXpETEts7QTPOa.gOcQBrAWV4jf/wTAx7HClX8YCpZQ5uW', 'Oscar Hinojosa Aguilar', 'activo')
ON DUPLICATE KEY UPDATE password_hash=VALUES(password_hash), status='activo';

INSERT IGNORE INTO user_roles (user_id, role_id)
SELECT u.id, r.id FROM users u JOIN roles r ON r.name='usuario' WHERE u.username='demo';

INSERT INTO user_profiles
    (user_id, first_name, last_name, company, public_name, city, state, phone, mobile, website,
     birth_date, biography, business_name, tax_id, business_address, exterior_number, neighborhood,
     municipality, postal_code, cfdi_use, payment_method, business_phone, business_email)
SELECT id, 'Oscar Hinojosa', 'Aguilar', 'Empresa', 'demo', 'Zapopan', 'Jalisco', '(331) 144-5589',
       '(331) 116-1573', 'http://www.designsgdl.com.mx', '2022-05-18', 'nada',
       'Carlos Aguilarr', 'HIAO900426KN3', 'Av. del tesoro', '2130', 'Cerro del tesoro',
       'Zapopan', '45852', 'G03 - Gastos en general', 'Transferencia', '3311445589', 'oscar90.aguilar@gmail.com'
FROM users WHERE username='demo'
ON DUPLICATE KEY UPDATE first_name=VALUES(first_name);
