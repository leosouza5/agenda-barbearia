# README

## Ideia do Projeto

Este projeto tem como proposta principal oferecer um sistema para auxiliar barbearias com uma interface de agendamento de horarios


### Público-Alvo

O público-alvo deste projeto são barbearias de pequeno porte.

## Stack utilizada

- **Back-end:** PHP puro
- **Front-end:** HTML, CSS e JavaScript
- **Banco de Dados:** PostgreSQL

### Iniciando o projeto

1. Clone este repositório:
   ```bash
   git clone https://github.com/leosouza5/agenda-barbearia
   ```
2. Navegue até o diretório do projeto:
   ```bash
   cd agenda-barbearia
   ```

### Iniciando o projeto

![DER](https://github.com/user-attachments/assets/da967335-a455-4798-b296-6cd68f0c8ef3)


# Documentação da API

## Cliente

### Listar Clientes
- **Método:** GET
- **Rota:** `/cliente`
- **Descrição:** Retorna uma lista de todos os clientes.
- **Parâmetros:** `Nenhum`

### Criar Cliente
- **Método:** POST
- **Rota:** `/cliente`
- **Descrição:** Cria um novo cliente.
- **Body esperado:**
  ```json
  {
    "nome": "Nome do cliente",
    "telefone": "Telefone do cliente"
  }
  
### Consultar Cliente por ID
- **Método:**  GET
- **Rota:**  `/cliente/{id}`
- **Descrição:**  Retorna os dados de um cliente específico pelo ID.
- **Parâmetros:**  `id (int): ID do cliente`


### Atualizar Cliente
- **Método:**  PUT
- **Rota:**  `/cliente/{id}`
- **Descrição:**  Atualiza os dados de um cliente específico pelo ID.
- **Parâmetros:**  `id (int): ID do cliente`
- **Body esperado:**
  ```json
  {
  "nome": "Nome atualizado do cliente",
  "telefone": "Telefone atualizado do cliente"
  }
  
  
### Deletar Cliente
- **Método:**  DELETE
- **Rota:**  `/cliente/{id}`
- **Descrição:**  Deleta um cliente específico pelo ID.
- **Parâmetros:** 
 `id (int): ID do cliente`
 
 
## Agendamento

### Listar Agendamentos
- **Método:**  GET
- **Rota:** : `/agendamento`
- **Descrição:**  Retorna uma lista de todos os agendamentos.
- **Parâmetros:**  `Nenhum`


### Consultar Agendamento por ID
- **Método:**  GET
- **Rota:**  `/agendamento/{id}`
- **Descrição:** : Retorna os dados de um agendamento específico pelo ID.
- **Parâmetros:** :
`id (int): ID do agendamento`


### Criar Agendamento
- **Método:**  POST
- **Rota:**  `/agendamento`
- **Descrição:** Cria um novo agendamento.
- **Body esperado:**
  ```json 
    {
      "cliente_id": "ID do cliente",
      "data": "Data do agendamento",
      "horario": "Horário do agendamento"
    }


### Atualizar Agendamento

- **Método:** PUT
- **Rota:** `/agendamento/{id}`
- **Descrição:** Atualiza os dados de um agendamento específico pelo ID.
- **Parâmetros:** :
id (int): ID do agendamento
- **Body esperado:**:
   ```json
      {
        "cliente_id": "ID do cliente",
        "data": "Data atualizada do agendamento",
        "horario": "Horário atualizado do agendamento",
        "observacoes": "Observações atualizadas do agendamento"
      }
### Deletar Agendamento
- **Método:** DELETE
- **Rota:** `/agendamento/{id}`
- **Descrição:** Deleta um agendamento específico pelo ID.
- **Parâmetros:** 
`id (int): ID do agendamento`


