<?php
declare(strict_types=1);
require_once __DIR__ . '/auth.php';

function findProfile(int $userId): array
{
    $statement = database()->prepare(
        'SELECT u.id, u.username, u.email, u.full_name, p.first_name, p.last_name, p.company,
                p.joined_at, p.public_name, p.city, p.state, p.phone, p.mobile, p.website, p.photo_path,
                p.birth_date, p.biography, p.business_name, p.tax_id, p.business_address,
                p.exterior_number, p.neighborhood, p.municipality, p.postal_code, p.cfdi_use,
                p.payment_method, p.business_phone, p.business_email
         FROM users u LEFT JOIN user_profiles p ON p.user_id = u.id WHERE u.id = :id LIMIT 1'
    );
    $statement->execute(['id' => $userId]);
    return $statement->fetch() ?: [];
}

function saveProfile(int $userId, array $data, ?string $photoPath): void
{
    $pdo = database();
    $pdo->beginTransaction();
    try {
        $passwordSql = $data['new_password'] !== '' ? ', password_hash = :password_hash' : '';
        $statement = $pdo->prepare('UPDATE users SET email = :email, full_name = :full_name' . $passwordSql . ' WHERE id = :id');
        $userValues = ['email' => $data['email'], 'full_name' => trim($data['first_name'] . ' ' . $data['last_name']) ?: null, 'id' => $userId];
        if ($data['new_password'] !== '') $userValues['password_hash'] = password_hash($data['new_password'], PASSWORD_DEFAULT);
        $statement->execute($userValues);
        $statement = $pdo->prepare(
            'INSERT INTO user_profiles (user_id, first_name, last_name, company, joined_at, public_name, city, state, phone, mobile, website, photo_path,
             birth_date, biography, business_name, tax_id, business_address, exterior_number, neighborhood, municipality, postal_code, cfdi_use, payment_method, business_phone, business_email)
             VALUES (:user_id, :first_name, :last_name, :company, :joined_at, :public_name, :city, :state, :phone, :mobile, :website, :photo_path,
             :birth_date, :biography, :business_name, :tax_id, :business_address, :exterior_number, :neighborhood, :municipality, :postal_code, :cfdi_use, :payment_method, :business_phone, :business_email)
             ON DUPLICATE KEY UPDATE first_name=VALUES(first_name), last_name=VALUES(last_name), company=VALUES(company),
             joined_at=VALUES(joined_at), public_name=VALUES(public_name), city=VALUES(city), state=VALUES(state),
             phone=VALUES(phone), mobile=VALUES(mobile), website=VALUES(website), photo_path=COALESCE(VALUES(photo_path), photo_path),
             birth_date=VALUES(birth_date), biography=VALUES(biography), business_name=VALUES(business_name), tax_id=VALUES(tax_id),
             business_address=VALUES(business_address), exterior_number=VALUES(exterior_number), neighborhood=VALUES(neighborhood),
             municipality=VALUES(municipality), postal_code=VALUES(postal_code), cfdi_use=VALUES(cfdi_use), payment_method=VALUES(payment_method),
             business_phone=VALUES(business_phone), business_email=VALUES(business_email)'
        );
        $statement->execute([
            'user_id'=>$userId, 'first_name'=>$data['first_name'] ?: null, 'last_name'=>$data['last_name'] ?: null,
            'company'=>$data['company'], 'joined_at'=>$data['joined_at'] ?: null, 'public_name'=>$data['public_name'] ?: null,
            'city'=>$data['city'] ?: null, 'state'=>$data['state'] ?: null, 'phone'=>$data['phone'] ?: null,
            'mobile'=>$data['mobile'] ?: null, 'website'=>$data['website'] ?: null, 'photo_path'=>$photoPath,
            'birth_date'=>$data['birth_date'] ?: null, 'biography'=>$data['biography'] ?: null,
            'business_name'=>$data['business_name'] ?: null, 'tax_id'=>$data['tax_id'] ?: null,
            'business_address'=>$data['business_address'] ?: null, 'exterior_number'=>$data['exterior_number'] ?: null,
            'neighborhood'=>$data['neighborhood'] ?: null, 'municipality'=>$data['municipality'] ?: null,
            'postal_code'=>$data['postal_code'] ?: null, 'cfdi_use'=>$data['cfdi_use'] ?: null,
            'payment_method'=>$data['payment_method'] ?: null, 'business_phone'=>$data['business_phone'] ?: null,
            'business_email'=>$data['business_email'] ?: null,
        ]);
        $pdo->commit();
    } catch (Throwable $exception) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        throw $exception;
    }
}
