<?php

// Importa a conexão com o banco de dados.
require_once __DIR__ . '/../../config/database.php';

// Importa funções auxiliares de autenticação e sessão.
require_once __DIR__ . '/../Middleware/auth.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class FrontendController
{
    private PDO $pdo;
    public function __construct()
    {
    }

    public function exibirPessoas(): void
    {
        if (!usuarioAutenticado()) {
            header('Location: ?controller=auth&action=login');
        }

        $usuario = usuarioAtual();
        require_once __DIR__ . '/../Views/pessoas/index.php';
    }
    public function exibirTipos(): void
    {
        if (!usuarioAutenticado()) {
            header('Location: ?controller=auth&action=login');
        }

        $usuario = usuarioAtual();
        require_once __DIR__ . '/../Views/tipos-atendimentos/index.php';
    }

    public function exibirAtendimentos(): void
    {
        if (!usuarioAutenticado()) {
            header('Location: ?controller=auth&action=login');
        }

        $usuario = usuarioAtual();
        require_once __DIR__ . '/../Views/atendimentos/index.php';
    }

}