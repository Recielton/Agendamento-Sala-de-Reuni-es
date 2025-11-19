-- criar banco (execute como root ou usuário com permissão)
CREATE DATABASE IF NOT EXISTS agendamento CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE agendamento;

-- tabela de eventos
CREATE TABLE IF NOT EXISTS events (
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
);

-- tabela admin
CREATE TABLE IF NOT EXISTS admins (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(100) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Observação: use install.php para criar o admin padrão (admin / admin123)
