<?php
declare(strict_types=1);

$basePath ??= rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
if ($basePath === '.') {
    $basePath = '';
}

if (!defined('SITE_BASE_PATH')) {
    define('SITE_BASE_PATH', $basePath);
}

require_once __DIR__ . '/helpers.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
        'cookie_secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
        'use_strict_mode' => true,
    ]);
}

$config = require __DIR__ . '/config/site.php';
$requestedView = $vista ?? ($_GET['vista'] ?? $config['default_view']);
$titles = $config['titles'];

if (!is_string($requestedView) || !array_key_exists($requestedView, $titles)) {
    $requestedView = $config['default_view'];
}

$vista = $requestedView;
$pageTitle = $titles[$vista];
$constructionViews = $config['construction_views'] ?? [];
$isConstructionView = in_array($vista, $constructionViews, true);
$viewFile = $isConstructionView
    ? __DIR__ . '/views/pages/construction.php'
    : __DIR__ . "/views/pages/{$vista}.php";

if (!is_file($viewFile)) {
    throw new RuntimeException("No existe la vista registrada: {$vista}");
}

$loginError = null;
$profileError = null;
$profileSuccess = null;
$requestError = null;
$requestSuccess = null;
$messageError = null;
$messageSuccess = null;
if ($vista === 'portal-amuvie' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    require_once __DIR__ . '/auth.php';

    $submittedToken = $_POST['csrf_token'] ?? '';
    if (!is_string($submittedToken) || !hash_equals($_SESSION['csrf_token'] ?? '', $submittedToken)) {
        $loginError = 'La sesión del formulario expiró. Recarga la página e inténtalo nuevamente.';
    } else {
        $login = is_string($_POST['usuario'] ?? null) ? $_POST['usuario'] : '';
        $password = is_string($_POST['contrasena'] ?? null) ? $_POST['contrasena'] : '';

        try {
            $authenticatedUser = authenticateUser($login, $password);
            if ($authenticatedUser === null) {
                $loginError = 'Usuario, correo o contraseña incorrectos.';
            } else {
                loginUser($authenticatedUser);
                $statement = database()->prepare(
                    'UPDATE users SET last_login_at = NOW() WHERE id = :id'
                );
                $statement->execute(['id' => $authenticatedUser['id']]);
                header('Location: ' . site_url('mi-perfil/'));
                exit;
            }
        } catch (PDOException $exception) {
            $errorReference = strtoupper(substr(hash('sha256', $exception->getCode() . '|' . $exception->getMessage()), 0, 8));
            error_log(sprintf(
                '[AMUVIE LOGIN %s] PDO %s: %s',
                $errorReference,
                (string) $exception->getCode(),
                $exception->getMessage()
            ));
            $databaseMessage = $exception->getMessage();
            $loginCause = match (true) {
                str_contains($databaseMessage, '[1045]') => 'Las credenciales configuradas para la base de datos fueron rechazadas.',
                str_contains($databaseMessage, '[1049]') => 'La base de datos configurada no existe.',
                str_contains($databaseMessage, '[2002]') => 'No fue posible localizar el servidor de base de datos.',
                str_contains($databaseMessage, 'could not find driver') => 'El servidor no tiene habilitada la extensión PDO para MySQL.',
                str_contains($databaseMessage, '1146') || str_contains($databaseMessage, 'Base table or view not found') => 'Faltan las tablas del portal; deben ejecutarse las migraciones.',
                (string) $exception->getCode() === 'HY093' => 'La versión desplegada de la consulta de autenticación está desactualizada.',
                default => 'Ocurrió un error de base de datos no identificado.',
            };
            $loginError = $loginCause . ' Referencia: ' . $errorReference . '.';
        }
    }
}

$_SESSION['csrf_token'] ??= bin2hex(random_bytes(32));

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && ($_POST['action'] ?? '') === 'logout') {
    $submittedToken = $_POST['csrf_token'] ?? '';
    if (is_string($submittedToken) && hash_equals($_SESSION['csrf_token'], $submittedToken)) {
        $_SESSION = [];
        session_destroy();
        header('Location: ' . site_url('portal-amuvie/'));
        exit;
    }
}

$memberViews = ['mi-perfil', 'credencial-digital', 'comentarios-de-la-nom', 'biblioteca-de-documentos', 'documentos-consejo-directivo', 'solicitud-formatos-portadas', 'directorio-asociados-extendido', 'aranceles', 'enviar-mensaje'];
if (in_array($vista, $memberViews, true)) {
    require_once __DIR__ . '/profile.php';
    $sessionUser = currentUser();
    if ($sessionUser === null) {
        header('Location: ' . site_url('portal-amuvie/'));
        exit;
    }

    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && ($_POST['action'] ?? '') === 'logout') {
        $submittedToken = $_POST['csrf_token'] ?? '';
        if (is_string($submittedToken) && hash_equals($_SESSION['csrf_token'], $submittedToken)) {
            $_SESSION = [];
            session_destroy();
            header('Location: ' . site_url('portal-amuvie/'));
            exit;
        }
    }

    if ($vista === 'mi-perfil' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
        $submittedToken = $_POST['csrf_token'] ?? '';
        if (!is_string($submittedToken) || !hash_equals($_SESSION['csrf_token'], $submittedToken)) {
            $profileError = 'La sesión del formulario expiró. Recarga la página e inténtalo nuevamente.';
        } else {
            $fields = ['first_name', 'last_name', 'company', 'joined_at', 'public_name', 'city', 'state', 'phone', 'mobile', 'email', 'website',
                'birth_date', 'biography', 'new_password', 'business_name', 'tax_id', 'business_address', 'exterior_number', 'neighborhood',
                'municipality', 'postal_code', 'cfdi_use', 'payment_method', 'business_phone', 'business_email'];
            $profileData = [];
            foreach ($fields as $field) $profileData[$field] = trim(is_string($_POST[$field] ?? null) ? $_POST[$field] : '');

            if ($profileData['company'] === '' || !filter_var($profileData['email'], FILTER_VALIDATE_EMAIL)) {
                $profileError = 'Completa la empresa y proporciona un correo electrónico válido.';
            } elseif ($profileData['joined_at'] !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $profileData['joined_at'])) {
                $profileError = 'La fecha de ingreso no es válida.';
            } elseif ($profileData['website'] !== '' && !filter_var($profileData['website'], FILTER_VALIDATE_URL)) {
                $profileError = 'El sitio web debe ser una URL válida, por ejemplo https://ejemplo.com.';
            } elseif ($profileData['new_password'] !== '' && mb_strlen($profileData['new_password']) < 8) {
                $profileError = 'La nueva contraseña debe tener al menos 8 caracteres.';
            } elseif ($profileData['business_email'] !== '' && !filter_var($profileData['business_email'], FILTER_VALIDATE_EMAIL)) {
                $profileError = 'El correo de empresa no es válido.';
            } else {
                $photoPath = null;
                $uploadedPhoto = $_FILES['photo'] ?? null;
                if (is_array($uploadedPhoto) && ($uploadedPhoto['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_NO_FILE) {
                    if (($uploadedPhoto['error'] ?? null) !== UPLOAD_ERR_OK || ($uploadedPhoto['size'] ?? 0) > 2097152) {
                        $profileError = 'La fotografía no pudo cargarse o supera el límite de 2 MB.';
                    } else {
                        $mime = (new finfo(FILEINFO_MIME_TYPE))->file($uploadedPhoto['tmp_name']);
                        $extensions = ['image/jpeg'=>'jpg', 'image/png'=>'png', 'image/webp'=>'webp'];
                        if (!isset($extensions[$mime])) {
                            $profileError = 'La fotografía debe ser JPG, PNG o WebP.';
                        } else {
                            $uploadDirectory = dirname(__DIR__) . '/assets/uploads/profiles';
                            if (!is_dir($uploadDirectory)) mkdir($uploadDirectory, 0755, true);
                            $filename = $sessionUser['id'] . '-' . bin2hex(random_bytes(8)) . '.' . $extensions[$mime];
                            if (!move_uploaded_file($uploadedPhoto['tmp_name'], $uploadDirectory . '/' . $filename)) $profileError = 'No fue posible guardar la fotografía.';
                            else $photoPath = 'assets/uploads/profiles/' . $filename;
                        }
                    }
                }
                if ($profileError === null) {
                    try {
                        saveProfile((int) $sessionUser['id'], $profileData, $photoPath);
                        $_SESSION['user']['email'] = $profileData['email'];
                        $_SESSION['user']['full_name'] = trim($profileData['first_name'] . ' ' . $profileData['last_name']);
                        header('Location: ' . site_url('mi-perfil/?guardado=1'));
                        exit;
                    } catch (PDOException $exception) {
                        $profileError = (string) $exception->getCode() === '23000' ? 'Ese correo electrónico ya está asociado a otra cuenta.' : 'No fue posible guardar el perfil. Inténtalo nuevamente.';
                    }
                }
            }
        }
    }
    $profile = findProfile((int) $sessionUser['id']);
    $profileSuccess = $vista === 'mi-perfil' && isset($_GET['guardado']) ? 'Tu perfil se actualizó correctamente.' : null;

    if ($vista === 'solicitud-formatos-portadas' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
        require_once __DIR__ . '/format-requests.php';
        $submittedToken = $_POST['csrf_token'] ?? '';
        $allowedFormats = ['Portada NOM-001-SEDE', 'Portada NOM-007-ENER', 'Portada NOM-013-ENER', 'Portada personalizada AMUVIE'];
        $formats = is_array($_POST['formats'] ?? null) ? array_values(array_intersect($allowedFormats, $_POST['formats'])) : [];
        $requestData = [
            'applicant_name' => trim(is_string($_POST['applicant_name'] ?? null) ? $_POST['applicant_name'] : ''),
            'delivery_type' => is_string($_POST['delivery_type'] ?? null) ? $_POST['delivery_type'] : '',
            'requires_invoice' => is_string($_POST['requires_invoice'] ?? null) ? $_POST['requires_invoice'] : '',
            'formats' => $formats,
        ];
        if (!is_string($submittedToken) || !hash_equals($_SESSION['csrf_token'], $submittedToken)) {
            $requestError = 'La sesión del formulario expiró. Recarga la página e inténtalo nuevamente.';
        } elseif ($requestData['applicant_name'] === '' || !in_array($requestData['delivery_type'], ['digital', 'envio'], true) || !in_array($requestData['requires_invoice'], ['0', '1'], true) || $formats === []) {
            $requestError = 'Completa los campos requeridos y selecciona al menos un formato.';
        } else {
            $attachments = $_FILES['attachments'] ?? null;
            $uploadedPaths = [];
            $names = is_array($attachments['name'] ?? null) ? $attachments['name'] : [];
            if ($names === []) {
                $requestError = 'Adjunta tu comprobante de pago y aprobación vigente.';
            } else {
                $allowedMimes = ['application/pdf'=>'pdf', 'image/jpeg'=>'jpg', 'image/png'=>'png'];
                $uploadDirectory = dirname(__DIR__) . '/assets/uploads/format-requests';
                if (!is_dir($uploadDirectory)) mkdir($uploadDirectory, 0755, true);
                foreach ($names as $index => $originalName) {
                    $error = $attachments['error'][$index] ?? UPLOAD_ERR_NO_FILE;
                    $size = (int) ($attachments['size'][$index] ?? 0);
                    $temporaryPath = $attachments['tmp_name'][$index] ?? '';
                    if ($error !== UPLOAD_ERR_OK || $size <= 0 || $size > 10 * 1024 * 1024) {
                        $requestError = 'Cada archivo debe pesar como máximo 10 MB.';
                        break;
                    }
                    $mime = (new finfo(FILEINFO_MIME_TYPE))->file($temporaryPath);
                    if (!isset($allowedMimes[$mime])) {
                        $requestError = 'Los archivos deben ser PDF, JPG o PNG.';
                        break;
                    }
                    $filename = $sessionUser['id'] . '-' . bin2hex(random_bytes(10)) . '.' . $allowedMimes[$mime];
                    if (!move_uploaded_file($temporaryPath, $uploadDirectory . '/' . $filename)) {
                        $requestError = 'No fue posible guardar uno de los archivos.';
                        break;
                    }
                    $uploadedPaths[] = 'assets/uploads/format-requests/' . $filename;
                }
                if ($requestError === null) {
                    try {
                        $requestId = createFormatRequest((int) $sessionUser['id'], $requestData, $uploadedPaths);
                        header('Location: ' . site_url('solicitud-formatos-portadas/?enviada=' . $requestId));
                        exit;
                    } catch (Throwable) {
                        $requestError = 'No fue posible registrar la solicitud. Inténtalo nuevamente.';
                    }
                }
            }
        }
    }
    if ($vista === 'solicitud-formatos-portadas' && isset($_GET['enviada'])) {
        $requestSuccess = 'Solicitud recibida correctamente. Folio #' . (int) $_GET['enviada'] . '.';
    }

    if ($vista === 'enviar-mensaje' && ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
        require_once __DIR__ . '/messages.php';
        $submittedToken = $_POST['csrf_token'] ?? '';
        $allowedCategories = ['administracion', 'soporte', 'facturacion', 'formatos', 'directorio', 'otro'];
        $messageData = [];
        foreach (['first_name', 'last_name', 'email', 'category', 'message'] as $field) {
            $messageData[$field] = trim(is_string($_POST[$field] ?? null) ? $_POST[$field] : '');
        }
        if (!is_string($submittedToken) || !hash_equals($_SESSION['csrf_token'], $submittedToken)) {
            $messageError = 'La sesión del formulario expiró. Recarga la página e inténtalo nuevamente.';
        } elseif ($messageData['first_name'] === '' || $messageData['last_name'] === '' || !filter_var($messageData['email'], FILTER_VALIDATE_EMAIL) || !in_array($messageData['category'], $allowedCategories, true) || mb_strlen($messageData['message']) < 10) {
            $messageError = 'Completa todos los campos y escribe un mensaje de al menos 10 caracteres.';
        } else {
            try {
                $messageId = createMemberMessage((int) $sessionUser['id'], $messageData);
                header('Location: ' . site_url('enviar-mensaje/?enviado=' . $messageId));
                exit;
            } catch (Throwable) {
                $messageError = 'No fue posible registrar el mensaje. Inténtalo nuevamente.';
            }
        }
    }
    if ($vista === 'enviar-mensaje' && isset($_GET['enviado'])) {
        $messageSuccess = 'Mensaje recibido correctamente. Folio #' . (int) $_GET['enviado'] . '.';
    }
}

require __DIR__ . '/views/layouts/site.php';
