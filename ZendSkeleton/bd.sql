create table Administrador (id int not null primary key auto_increment,nome varchar(40) not null ,email varchar(40) not null, senha varchar(10) not null)
CREATE TABLE Bairro (id int not null primary key auto_increment,nome varchar(60) not null, cidade int not null)
create table TipoComodo (id int not null primary key auto_increment,descricao varchar(40) not null)
create table TipoUso (id int not null primary key auto_increment, descricao varchar(40) not null)