-- Nâo utilizar sem autorização!
drop database if exists db_loja_carros;
drop table if exists tb_usuario;
drop table if exists tb_carros;
drop table if exists tb_pagina_devs;

-- criação do banco de dados
create database if not exists db_loja_carros;

use db_loja_carros;

-- tabela de usuarios e funcionarios 
create table if not exists tb_usuario(
Id int primary key auto_increment,
Nome varchar(50) not null,
Email varchar (80) not null,
Senha varchar (150) not null,
Telefone int default  ('n/a'),
Nivel varchar (20) default ('Usuario')
);

-- as categorias BEV e FCEV são dos carros totalmente elétricos
-- os outros 3 restantes são hubridos
create table if not exists tb_carros(
Id_carro int primary key auto_increment,
Nome_carro varchar(100) not null,
Marca enum (
'BYD',
'Tesla',
'GWM',
'Geely',
'Chery',
'GAC Aion',
'Leapmotor',
'Jaecoo',
'Toyota',
'Volvo',
'Renault',
'Hyundai',
'Kia',
'BMW',
'Mercedes-Benz',
'Chevrolet',
'Fiat',
'Ford',
'Volkswagen'
),
Categoria enum('BEV','FCEV','PHEV','HEV','MHEV') not null,
Preco decimal (10,2) not null,
Data_cadastro datetime default current_timestamp
);

-- tabela para a pagina em php
-- os nomes dos dev servem para catalogar uma nota de satisfação do usuario
create table if not exists tb_pagina_devs(
Id int auto_increment primary key,
Nome_usuario varchar (100) not null,
Email_usuario varchar(100) not null,
Henrique_n int default ('Não teve nota'),
Igor_n int default ('Não teve nota'),
Bruno_n int default ('Não teve nota')
);