CREATE DATABASE api_db;


CREATE TABLE tb_cliente (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL
);

CREATE TABLE tb_agendamento (
    id SERIAL PRIMARY KEY,
    status CHAR(1) NOT NULL DEFAULT 'P',
    data VARCHAR(10) NOT NULL,
    hora VARCHAR(10) NOT NULL,
    id_cliente int NOT NULL
);