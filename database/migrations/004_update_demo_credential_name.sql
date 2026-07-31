UPDATE users
SET full_name = 'Roberto Carlos Aguillar Jiménez (el más pistolas)'
WHERE username = 'demo';

UPDATE user_profiles p
JOIN users u ON u.id = p.user_id
SET p.first_name = 'Roberto Carlos',
    p.last_name = 'Aguillar Jiménez (el más pistolas)',
    p.public_name = 'Roberto Carlos Aguillar Jiménez (el más pistolas)',
    p.business_name = 'Roberto Carlos Aguillar Jiménez'
WHERE u.username = 'demo';
