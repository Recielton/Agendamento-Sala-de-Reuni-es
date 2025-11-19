<?php
    // install.php
    require_once 'config.php';
    $pdo = getPDO();

    // criar tabelas se não existirem
    $pdo->exec("CREATE TABLE IF NOT EXISTS events (
      id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      uuid CHAR(32) NOT NULL,
      title VARCHAR(255) NOT NULL,
      room ENUM('SALA 00','SALA 01','SALA 02','SALA GERENCIAL') NOT NULL,
      responsavel VARCHAR(150) DEFAULT NULL,
      descricao TEXT DEFAULT NULL,
      start DATETIME NOT NULL,
      end DATETIME NOT NULL,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      UNIQUE KEY ux_uuid (uuid)
    );");

    $pdo->exec("CREATE TABLE IF NOT EXISTS admins (
      id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      username VARCHAR(100) NOT NULL UNIQUE,
      password_hash VARCHAR(255) NOT NULL,
      created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );");

    // cria admin padrão se não existir
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM admins");
    $stmt->execute();
    $count = (int)$stmt->fetchColumn();
    if ($count === 0) {
        $password = password_hash('admin123', PASSWORD_DEFAULT);
        $insert = $pdo->prepare("INSERT INTO admins (username, password_hash) VALUES (:u,:p)");
        $insert->execute([':u' => 'admin', ':p' => $password]);
        echo "Admin user created: username=admin password=admin123
";
    } else {
        echo "Admin already exists.
";
    }
    echo "Install finished.
";
