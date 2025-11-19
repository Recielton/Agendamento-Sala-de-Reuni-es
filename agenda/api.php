<?php
// api.php
require_once 'config.php';
$pdo = getPDO();

// Headers CORS (ajuste conforme necessário)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
$script = $_SERVER['SCRIPT_NAME'];

// Extrair path após api.php
$path = substr($uri, strlen($script));
$path = strtok($path, '?'); // remove querystring
$parts = array_values(array_filter(explode('/', $path)));

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// util
function inputJson() {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    if ($data === null) $data = [];
    return $data;
}

function requireAdminPassword($pdo, $password) {
    if (!$password) return false;
    $stmt = $pdo->prepare("SELECT password_hash FROM admins WHERE username = 'admin' LIMIT 1");
    $stmt->execute();
    $row = $stmt->fetch();
    if (!$row) return false;
    return password_verify($password, $row['password_hash']);
}

try {

    // route: /events or /events/{id}
    if (isset($parts[0]) && $parts[0] === 'events') {
        // GET /events
        if ($method === 'GET' && count($parts) === 1) {
            // opcional filtro por sala ?room=SALA%2000
            $room = $_GET['room'] ?? null;
            if ($room) {
                $stmt = $pdo->prepare("SELECT * FROM events WHERE room = :room ORDER BY start ASC");
                $stmt->execute([':room' => $room]);
            } else {
                $stmt = $pdo->query("SELECT * FROM events ORDER BY start ASC");
            }
            $rows = $stmt->fetchAll();
            jsonResponse(['ok' => true, 'events' => $rows]);
        }

        // POST /events  (criar)
        if ($method === 'POST' && count($parts) === 1) {
            $data = inputJson();
            // validar campos
            $required = ['title','room','start','end'];
            foreach ($required as $r) {
                if (empty($data[$r])) jsonResponse(['ok'=>false,'error'=>"Missing field: $r"], 400);
            }
            // converter datas
            $start = date('Y-m-d H:i:s', strtotime($data['start']));
            $end = date('Y-m-d H:i:s', strtotime($data['end']));
            if ($end <= $start) jsonResponse(['ok'=>false,'error'=>'end must be after start'], 400);

            // conflito: mesma sala e overlap
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM events WHERE room = :room AND NOT (end <= :start OR start >= :end)");
            $stmt->execute([':room'=>$data['room'], ':start'=>$start, ':end'=>$end]);
            if ((int)$stmt->fetchColumn() > 0) {
                jsonResponse(['ok'=>false,'error'=>'Conflito de horario na sala'], 409);
            }

            // inserir
            $uuid = bin2hex(random_bytes(16));
            $stmt = $pdo->prepare("INSERT INTO events (uuid,title,room,responsavel,descricao,start,end) VALUES (:uuid,:title,:room,:responsavel,:descricao,:start,:end)");
            $stmt->execute([
                ':uuid'=>$uuid,
                ':title'=> $data['title'],
                ':room'=> $data['room'],
                ':responsavel'=> $data['responsavel'] ?? null,
                ':descricao'=> $data['descricao'] ?? null,
                ':start'=> $start,
                ':end'=> $end
            ]);
            $id = $pdo->lastInsertId();
            $stmt = $pdo->prepare("SELECT * FROM events WHERE id = :id");
            $stmt->execute([':id'=>$id]);
            $row = $stmt->fetch();
            jsonResponse(['ok'=>true,'event'=>$row], 201);
        }

        // PUT /events/{id} (editar) => requires admin_password
        if ($method === 'PUT' && count($parts) === 2) {
            $id = (int)$parts[1];
            $data = inputJson();

            // verificar senha admin
            $pw = $data['admin_password'] ?? null;
            if (!requireAdminPassword($pdo, $pw)) jsonResponse(['ok'=>false,'error'=>'admin authentication failed'], 401);

            // buscar evento existente
            $stmt = $pdo->prepare("SELECT * FROM events WHERE id = :id");
            $stmt->execute([':id'=>$id]);
            $exists = $stmt->fetch();
            if (!$exists) jsonResponse(['ok'=>false,'error'=>'Event not found'], 404);

            // validar entrada
            $title = $data['title'] ?? $exists['title'];
            $room = $data['room'] ?? $exists['room'];
            $start = !empty($data['start']) ? date('Y-m-d H:i:s', strtotime($data['start'])) : $exists['start'];
            $end = !empty($data['end']) ? date('Y-m-d H:i:s', strtotime($data['end'])) : $exists['end'];
            if ($end <= $start) jsonResponse(['ok'=>false,'error'=>'end must be after start'], 400);

            // conflito (ignorando o próprio id)
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM events WHERE room = :room AND id <> :id AND NOT (end <= :start OR start >= :end)");
            $stmt->execute([':room'=>$room, ':id'=>$id, ':start'=>$start, ':end'=>$end]);
            if ((int)$stmt->fetchColumn() > 0) {
                jsonResponse(['ok'=>false,'error'=>'Conflito de horario na sala'], 409);
            }

            // atualizar
            $upd = $pdo->prepare("UPDATE events SET title=:title, room=:room, responsavel=:responsavel, descricao=:descricao, start=:start, end=:end WHERE id=:id");
            $upd->execute([
                ':title'=>$title,
                ':room'=>$room,
                ':responsavel'=>$data['responsavel'] ?? $exists['responsavel'],
                ':descricao'=>$data['descricao'] ?? $exists['descricao'],
                ':start'=>$start,
                ':end'=>$end,
                ':id'=>$id
            ]);
            $stmt = $pdo->prepare("SELECT * FROM events WHERE id = :id");
            $stmt->execute([':id'=>$id]);
            $row = $stmt->fetch();
            jsonResponse(['ok'=>true,'event'=>$row]);
        }

        // DELETE /events/{id} (deletar) => requires admin_password
        if ($method === 'DELETE' && count($parts) === 2) {
            // ler input (pode vir via JSON)
            $data = inputJson();
            $pw = $data['admin_password'] ?? null;
            if (!requireAdminPassword($pdo, $pw)) jsonResponse(['ok'=>false,'error'=>'admin authentication failed'], 401);

            $id = (int)$parts[1];
            $stmt = $pdo->prepare("SELECT * FROM events WHERE id = :id");
            $stmt->execute([':id'=>$id]);
            $exists = $stmt->fetch();
            if (!$exists) jsonResponse(['ok'=>false,'error'=>'Event not found'], 404);

            $del = $pdo->prepare("DELETE FROM events WHERE id = :id");
            $del->execute([':id'=>$id]);
            jsonResponse(['ok'=>true,'message'=>'Deleted']);
        }

        // se não combinou
        jsonResponse(['ok'=>false,'error'=>'Invalid events route'], 400);
    }

    // rota admin: change-password
    if (isset($parts[0]) && $parts[0] === 'admin') {
        if (isset($parts[1]) && $parts[1] === 'change-password' && $method === 'POST') {
            $data = inputJson();
            $current = $data['current_password'] ?? null;
            $new = $data['new_password'] ?? null;
            $confirm = $data['confirm_password'] ?? null;
            if (!$current || !$new || !$confirm) jsonResponse(['ok'=>false,'error'=>'Missing fields'], 400);
            if ($new !== $confirm) jsonResponse(['ok'=>false,'error'=>'New passwords do not match'], 400);
            if (!requireAdminPassword($pdo, $current)) jsonResponse(['ok'=>false,'error'=>'Current password incorrect'], 401);
            if (strlen($new) < 4) jsonResponse(['ok'=>false,'error'=>'Password too short'], 400);
            $hash = password_hash($new, PASSWORD_DEFAULT);
            $up = $pdo->prepare("UPDATE admins SET password_hash = :h WHERE username = 'admin'");
            $up->execute([':h'=>$hash]);
            jsonResponse(['ok'=>true,'message'=>'Password updated']);
        }
        if (isset($parts[1]) && $parts[1] === 'check-password' && $method === 'POST') {
            $data = inputJson();
            $pw = $data['password'] ?? null;
            $valid = requireAdminPassword($pdo, $pw);
            jsonResponse(['ok'=>true,'valid'=>$valid]);
        }
    }

    // default
    jsonResponse(['ok'=>false,'error'=>'Unknown route'], 404);

} catch (PDOException $ex) {
    jsonResponse(['ok'=>false,'error'=>'Database error: '.$ex->getMessage()], 500);
} catch (Exception $ex) {
    jsonResponse(['ok'=>false,'error'=>$ex->getMessage()], 500);
}
