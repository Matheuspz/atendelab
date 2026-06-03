CREATE DATABASE IF NOT EXISTS atendelab
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE atendelab;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('admin', 'atendente') DEFAULT 'atendente',
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
/* TESTE DA TABELA USUARIO */
INSERT INTO usuarios (nome, email, senha, perfil, status)
VALUES (
    'Administrador',
    'admin@atendelab.com',
    '$2y$10$J9P2kU2BAMZ3TZcuxTsW4e1D/lka8EocYHzvyoOZmCNcWDQz3RuVC',
    'admin',
    'ativo'
);

CREATE TABLE pessoas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefone VARCHAR(14) NOT NULL,
    cpf VARCHAR(14) NOT NULL UNIQUE
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
