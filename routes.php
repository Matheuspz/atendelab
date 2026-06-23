<?php

require_once __DIR__ . '/app/Controllers/AuthController.php';
require_once __DIR__ . '/app/Controllers/UsuariosController.php';
require_once __DIR__ . '/app/Middleware/auth.php';

$controller = $_GET['controller'] ?? 'auth';
$action = $_GET['action'] ?? 'login';

function responderRotaNaoEncontrada(string $mensagem): void
{
    http_response_code(404);
    echo json_encode(['erro' => $mensagem], JSON_UNESCAPED_UNICODE);
}

switch ($controller) {
    case 'auth':
        $authController = new AuthController();

        switch ($action) {
            case 'login':
                $authController->exibirLogin();
                break;

            case 'entrar':
                $authController->entrar();
                break;

            case 'dashboard':
                $authController->dashboard();
                break;

            case 'logout':
                $authController->logout();
                break;

            default:
                responderRotaNaoEncontrada('Acao de autenticacao nao encontrada.');
        }
        break;

    case 'usuarios':
        exigirAutenticacao();
        $usuariosController = new UsuarioController();

        switch ($action) {
            case 'listar':
                $usuariosController->listar();
                break;

            case 'buscarPorId':
                $usuariosController->buscarPorId();
                break;

            case 'criar':
                $usuariosController->criar();
                break;

            case 'atualizar':
                $usuariosController->atualizar();
                break;

            case 'inativar':
                $usuariosController->inativar();
                break;

            default:
                responderRotaNaoEncontrada('Acao de usuarios nao encontrada.');
        }
        break;

    case 'tipos':
        exigirAutenticacao();
        require_once __DIR__ . '/app/Controllers/TiposAtendimentosController.php';
        $tiposController = new TiposAtendimentosController();

        switch ($action) {
            case 'listar':
                $tiposController->listar();
                break;

            case 'buscarPorId':
                $tiposController->buscarPorId();
                break;

            case 'criar':
                $tiposController->criar();
                break;

            case 'atualizar':
                $tiposController->atualizar();
                break;

            case 'inativar':
                $tiposController->inativar();
                break;

            default:
                responderRotaNaoEncontrada('Ação de tipos de atendimento não encontrada.');
                break;
        }
        break;

    case 'atendimentos':
        exigirAutenticacao();
        require_once __DIR__ . '/app/Controllers/AtendimentosController.php';
        $atendimentosController = new AtendimentosController();

        switch ($action) {
            case 'listar':
                $atendimentosController->listar();
                break;

            case 'visualizar':
                $atendimentosController->visualizar();
                break;

            case 'criar':
                $atendimentosController->criar();
                break;

            case 'alterarStatus':
            case 'atualizarStatus':
                $atendimentosController->alterarStatus();
                break;

            case 'opcoesFormulario':
                $atendimentosController->opcoesFormulario();
                break;

            default:
                responderRotaNaoEncontrada(
                    'Ação de atendimentos não encontrada.'
                );
                break;
        }
        break;


    default:
        responderRotaNaoEncontrada('Controller nao encontrado.');
}
