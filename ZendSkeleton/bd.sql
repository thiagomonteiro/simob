/*obs todas as tabelas tem que ser no formato utf8-ci*/
create table Administrador (id int not null primary key auto_increment,nome varchar(40) not null ,email varchar(40) not null, senha varchar(10) not null)
CREATE TABLE Bairro (id int not null primary key auto_increment,nome varchar(60) not null, cidade int not null, FOREIGN KEY(cidade) REFERENCES cidade(id))
/*create table TipoComodo (id int not null primary key auto_increment,descricao varchar(40) not null)*/
CREATE TABLE CategoriaImovel (id int not null primary key auto_increment, descricao varchar(40) not null)
CREATE TABLE SubCategoriaImovel (id int not null primary key auto_increment, descricao varchar(40) not null, categoria int not null, FOREIGN KEY(categoria) REFERENCES CategoriaImovel(id))
CREATE TABLE TipoTransacao (id int not null primary key auto_increment, descricao varchar(40) not null)
CREATE TABLE TipoComodos (id int not null primary key auto_increment,descricao varchar(40) not null)
CREATE TABLE Proprietario (id int not null primary key auto_increment, nome varchar(100) not null,logradouro varchar(100) not null, numero varchar(50), telefone varchar(10), celular varchar(11),cpf varchar(11) not null, rg varchar(20) not null, profissao varchar(40) not null, bairro int not null, FOREIGN KEY(bairro) REFERENCES Bairro(id))




INSERT INTO TipoTransacao (id,descricao) VALUES (1,"Venda");
INSERT INTO TipoTransacao (id,descricao) VALUES (2,"Aluguel");

INSERT INTO CategoriaImovel (id,descricao) VALUES (1,"Residencial");
INSERT INTO CategoriaImovel (id,descricao) VALUES (2,"Comercial");


INSERT INTO SubCategoriaImovel(id,descricao,categoria) VALUES (1,"Apartamento",1);
INSERT INTO SubCategoriaImovel(id,descricao,categoria) VALUES (2,"Casa",1);

INSERT INTO SubCategoriaImovel(id,descricao,categoria) VALUES (3,"Loja",2);
INSERT INTO SubCategoriaImovel(id,descricao,categoria) VALUES (4,"Restaurante",2);