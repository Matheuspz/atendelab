CREATE DATABASE IF NOT EXISTS atendelab
CHARACTER SET utf8mb4
COLLATE utf8mb4_general_ci;

USE atendelab;

CREATE TABLE usuarios (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
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
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    documento VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    telefone VARCHAR(20) NOT NULL,
    curso VARCHAR(100) NOT NULL,
    periodo VARCHAR(100) NOT NULL,
    status VARCHAR(100) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tipo_atendimento (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)

CREATE TABLE atendimentos (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_tipo_atendimento INT NOT NULL,
    id_pessoa INT NOT NULL,
    id_usuario INT NOT NULL,
    data_atendimento DATE NOT NULL,
    hora_atendimento TIME NOT NULL,
    descricao TEXT NOT NULL,
    observacao_final TEXT NOT NULL,
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP

    CONSTRAINT fk_atendimentos_tipo_atendimento
        FOREIGN KEY(id_tipo_atendimento) REFERENCES tipo_atendimento(id)
    CONSTRAINT fk_atendimentos_pessoas
        FOREIGN KEY(id_pessoa) REFERENCES pessoas(id)
    CONSTRAINT fk_atendimentos_usuarios
        FOREIGN KEY(id_usuario) REFERENCES usuarios(id)
)