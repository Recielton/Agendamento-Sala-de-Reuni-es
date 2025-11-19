<?php
// config.php
// Ajuste estes valores conforme seu ambiente
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'agendamento');
define('DB_USER', 'root');
define('DB_PASS', '');

// timezone de Manaus
date_default_timezone_set('America/Manaus');

// cria e retorna PDO
function getPDO(){
    static $pdo = null;
    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $opts = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $opts);
    }
    return $pdo;
}

function jsonResponse($data, $status = 200) {
    http_response_code($status);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
