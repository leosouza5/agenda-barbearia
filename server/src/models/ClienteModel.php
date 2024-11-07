<?php
namespace App\Models;

use PDO;

class ClienteModel {
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($nome, $telefone)
    {
        $sql = "INSERT INTO tb_cliente (nome, telefone) VALUES (:nome, :telefone)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        return $stmt->execute();
    }

    public function list()
    {
        $sql = "SELECT id, nome, telefone FROM tb_cliente";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // print_r($res);
        return $res;
    }

    public function getById($id)
    {
        $sql = "SELECT id, nome, telefone FROM tb_cliente WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $nome, $telefone)
    {
        $sql = "UPDATE tb_cliente SET nome = :nome, telefone = :telefone WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->execute();
        return $stmt->rowCount(); // Retorna o número de linhas afetadas
    }

    public function delete($id)
    {
        $sql = "DELETE FROM tb_cliente WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount(); // Retorna o número de linhas afetadas
    }
}
