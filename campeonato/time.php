<?php
class Time {
    private $conexao;
    public $id;
    public $nome;
    public $cor;
    public $ano;
    public $presidente;

    public function __construct($db) {
        $this->conexao = $db;
    }

    public function inserir() {
        $query = "INSERT INTO time (nome, cor, ano, presidente) VALUES (:nome, :cor, :ano, :presidente)";
        $stmt = $this->conexao->prepare($query);
        
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':cor', $this->cor);
        $stmt->bindParam(':ano', $this->ano);
        $stmt->bindParam(':presidente', $this->presidente);
        
        return $stmt->execute();
    }

    public function atualizar() {
        $query = "UPDATE time SET nome = :nome, cor = :cor, ano = :ano, presidente = :presidente WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        
        $stmt->bindParam(':nome', $this->nome);
        $stmt->bindParam(':cor', $this->cor);
        $stmt->bindParam(':ano', $this->ano);
        $stmt->bindParam(':presidente', $this->presidente);
        $stmt->bindParam(':id', $this->id);
        
        return $stmt->execute();
    }

    public function excluir() {
        $query = "DELETE FROM time WHERE id = :id";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function listar() {
        $query = "SELECT * FROM time ORDER BY id DESC";
        $stmt = $this->conexao->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarPorId() {
        $query = "SELECT * FROM time WHERE id = :id LIMIT 1";
        $stmt = $this->conexao->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>