<?php
namespace App\Models;

use PDO;

class AgendamentoModel{
  private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($data, $hora)
    {
        $sql = "INSERT INTO tb_agendamento (data,hora) VALUES (:data, :hora)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':hora', $hora);
        return $stmt->execute();
    }

    public function list()
    {
        $sql = "SELECT id, hora FROM tb_agendamento";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM tb_agendamento WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data, $hora)
    {
        $sql = "UPDATE tb_agendamento SET data = :data, hora = :hora WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':hora', $hora);
        $stmt->execute();
        return $stmt->rowCount();
    }

    public function delete($id)
    {
        $sql = "DELETE FROM tb_agendamento WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->rowCount();
    }
}