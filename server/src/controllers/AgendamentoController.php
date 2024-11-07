<?php
namespace App\Controllers;

use App\Models\AgendamentoModel;

class AgendamentoController
{
    private $agendamento;

    public function __construct($db)
    {
        $this->agendamento = new AgendamentoModel($db);
    }

    public function list()
    {
        $agendamentos = $this->agendamento->list();
        echo json_encode($agendamentos);
    }

    public function create()
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->data) && isset($data->hora) && isset($data->id_cliente)) {
            try {
                $this->agendamento->create($data->data, $data->hora,$data->id_cliente);

                http_response_code(201);
                echo json_encode(["message" => "Agendamento criado com sucesso."]);
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao criar o Agendamento."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function getById($id)
    {
        if (isset($id)) {
            try {
                $agendamento = $this->agendamento->getById($id[0]);
                if ($agendamento) {
                    echo json_encode($agendamento);
                } else {
                    http_response_code(404);
                    echo json_encode(["message" => "Agendamento não encontrado."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao buscar o Agendamento."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function update($id)
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->data) && isset($data->hora) && isset($data->id_cliente)) {
            try {
                $count = $this->agendamento->update($id[0], $data->data, $data->hora,$data->id_cliente);
                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Agendamento atualizado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao atualizar o Agendamento."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao atualizar o Agendamento."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }

    public function delete($id)
    {
        $data = json_decode(file_get_contents("php://input"));
        if (isset($id)) {
            try {
                $count = $this->agendamento->delete($id[0]);

                if ($count > 0) {
                    http_response_code(200);
                    echo json_encode(["message" => "Agendamento deletado com sucesso."]);
                } else {
                    http_response_code(500);
                    echo json_encode(["message" => "Erro ao deletar o Agendamento."]);
                }
            } catch (\Throwable $th) {
                http_response_code(500);
                echo json_encode(["message" => "Erro ao deletar o Agendamento."]);
            }
        } else {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
        }
    }
}