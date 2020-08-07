DROP DATABASE IF EXISTS loja_test_1;
create database IF NOT EXISTS loja_test_1;

use loja_test_1;

create table tb_employees(
	id int not null primary key AUTO_INCREMENT,
	nome varchar(60) not null,
    cargo varchar(60) not null,
    data_nascimento date not null,
    data_admissao date not null
)

