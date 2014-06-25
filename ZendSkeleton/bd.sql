/*obs todas as tabelas tem que ser no formato utf8-ci*/
create table Administrador (id int not null primary key auto_increment,nome varchar(40) not null ,email varchar(40) not null, senha varchar(10) not null)
CREATE TABLE Bairro (id int not null primary key auto_increment,nome varchar(60) not null, cidade int not null, FOREIGN KEY(cidade) REFERENCES cidade(id))
/*create table TipoComodo (id int not null primary key auto_increment,descricao varchar(40) not null)*/
CREATE TABLE TipoImovel (id int not null primary key auto_increment, descricao varchar(40) not null)
CREATE TABLE SubTipoImovel (id int not null primary key auto_increment, descricao varchar(40) not null, id_tipo int not null, FOREIGN KEY(id_tipo) REFERENCES TipoImovel(id))
CREATE TABLE TipoTransacao (id int not null primary key auto_increment, descricao varchar(40) not null)
CREATE TABLE TipoComodos (id int not null primary key auto_increment,descricao varchar(40) not null)