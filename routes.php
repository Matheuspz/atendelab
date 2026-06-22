<?php
require_once __DIR___ . '/app/Middleware/auth.php'; 
require_once ___DIR____ . '/app/Controllers/AuthController.php'; 
require_once ___DIR__ . '/app/Controllers/UsuariosController.php';
require_once _DIR_____ . '/app/Controllers/PessoasController.php';
require_once __DIR__ . '/app/Controllers/TiposAtendimentos Controller.php'; 
require_once __DIR__ . '/app/Controllers/Atendimentos Controller.php';

$controller = $_GET['controller'] ?? 'auth'; 
$action = $_GET['action'] ?? 'login';

if ($controller === 'auth') {
    $auth = new AuthController();
    switch ($action) {
        case 'login':
            $auth->exibirLogin();
            break;
        case 'entrar':
            $auth->entrar();
            break;
        case 'dashboard':
            exigirAutenticacao();
            $auth->dashboard();
            break;
        case 'logout':
            $auth->Logout();
            break;
        default:
            http_response_code (404);
            echo 'Ação de autenticação não encontrada.';
        
    }
    exit;
}

exigirAutenticacao();   

switch ($controller) {
    case 'usuarios':
        $obj = new Usuarios Controller();
        break;
    case 'pessoas':
        $obj = new PessoasController(); 
        break;
    case 'tipos':
        $obj = new TiposAtendimentosController(); 
        break;
    case 'atendimentos':
        $obj = new AtendimentosController(); 
        break;
    default:
        http_response_code(404);
        exit('Controller não encontrado.');
}
if (!method_exists($obj, $action)) {
    http_response_code(404); 
    exit('Ação não encontrada.');
}

$obj->$action();