<?php

class PessoasController
{
    private PDO $pdo;
    public function __construct()
    {
        require __DIR__ . '/../../config/database.php';
        $this->pdo = $pdo;
    }

    public function json(array $dados, int $status = 200) :void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($dados, JSON_UNESCAPED_UNICODE);
    }

    public function listar() :void
    {
        $sql = 'SELECT id, nome, descricao, status
                FROM tipos_atendimentos 
                ORDER BY nome';
        $this->json($this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC));
    }

    public function buscarPorId() :void
    {
        $id = filter_input(INPUT_GET,'id', FILTER_VALIDATE_INT);

        if(!$id){
            $this->json(['erro' => 'ID Inválido.'], 400);
            return;
        }

        $stmt = $this->pdo->prepare(
            'SELECT id, nome, descricao, status,
                FROM tipos_atendimentos
                WHERE id = :id'
        );
        $stmt->execute(['id' => $id]);
        $pessoa = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$pessoa){
            $this->json(['erro' => 'Tipo não encontrada.'], 400);
            return;
        }
        $this->json($pessoa);   
    }

    public function criar() :void
    {
        $nome = trim($_POST['nome'] ?? '');
        $documento = trim($_POST['descricao'] ?? '');
        $status = $_POST['status'] ?? 'ativo';

        if($nome ==='') {
            $this->json(['erro'=> 'Nome é obrigatório'], 422);
            return;
        }
        if (!in_array($status, ['ativo','inativo'], true)){
            $this->json(['erro'=> 'Status inválido'], 422);
            return;
        }  

        try
        {
            $stmt = $this->pdo->prepare(
                'INSERT INTO tipos_atendimentos (nome, descricao, status)
                VALUES (:nome, :descricao, :status)'
            );
            $stmt->execute(compact(
                'nome', 'descricao', 'status'
            ));
            $this->json(['mensagem' => 'Tipo cadastrado com sucesso', 201]);

        } catch (PDOException $e) {
            $this->json(['erro' => 'Erro ao cadastrar tipo', 400]);
        }
    }

    public function atualizar() :void
    {
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        $nome = trim($_POST['nome'] ?? '');
        $documento = trim($_POST['descricao'] ?? '');
        $status = $_POST['status'] ?? 'ativo';

        if($nome ==='') {
            $this->json(['erro'=> 'Nome é obrigatório'], 422);
            return;
        }
        if (!in_array($status, ['ativo','inativo'], true)){
            $this->json(['erro'=> 'Status inválido'], 422);
            return;
        }  

        try {
            $stmt = $this->pdo->prepare(
                'UPDATE tipos_atendimentos SET nome = :nome,
                                    descricao = :descricao,
                                    status = :status,
                                WHERE id = :id'
            );
            $stmt->execute(compact(
                'id', 'nome', 'descricao', 'status'
            ));
            $this->json(['mensagem' => 'Tipo atualizado com sucesso', 201]);
        } catch(PDOException $e) {
            $this->json(['erro' => 'Erro ao atualizar tipo', 400]);
        }
    }

    public function inativar() :void 
    {
        $id = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT);
        if(!$id) {
            $this->json(['erro' => 'ID Inválido'], 422);
        }

        $stmt = $this->pdo->prepare(
            "UPDATE tipos_atendimentos SET status = 'inativo' WHERE id = :id"
        );
        $stmt->execute(['id' => $id]);
        $this->json(['mensagem' => 'Tipo invativado com sucesso.']);
    }

    }