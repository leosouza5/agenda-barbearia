<?php
namespace App\Models;

use PDO;

class AgendamentoModel{
  private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($data, $hora,$idCliente)
    {
        $sql = "INSERT INTO tb_agendamento (data,hora,id_cliente) VALUES (:data, :hora, :idCliente)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':hora', $hora);
        $stmt->bindParam(':idCliente', $idCliente);
        return $stmt->execute();
    }

    public function list()
    {
        $sql = "SELECT ag.id,ag.status,ag.data,ag.hora, cl.nome FROM tb_agendamento ag LEFT JOIN tb_cliente cl on cl.id = ag.id_cliente ";
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

    public function update($id, $data, $hora,$idCliente)
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