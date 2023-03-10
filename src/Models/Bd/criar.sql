CREATE DATABASE IF NOT EXISTS GC;
USE GC;
CREATE TABLE USUARIOS 
( 
 US_DESCRICAO VARCHAR(100),  
 US_DT_CRIACAO DATETIME NOT NULL,  
 US_ID INT PRIMARY KEY AUTO_INCREMENT,  
 US_NOME VARCHAR(40) NOT NULL,
 US_SENHA VARCHAR(40) NOT NULL
); 

CREATE TABLE ACESSOS 
( 
 AC_ID INT PRIMARY KEY AUTO_INCREMENT,  
 AC_DESCRICAO VARCHAR(30) NOT NULL
); 

CREATE TABLE GRUPOS 
( 
 GP_ID INT PRIMARY KEY AUTO_INCREMENT,  
 GP_DESCRICAO VARCHAR(20) NOT NULL
); 

CREATE TABLE CHAMADOS 
( 
 CH_DT_CRIACAO DATETIME NOT NULL,  
 CH_DT_ALTERACAO DATETIME NOT NULL,  
 CH_ID INT PRIMARY KEY AUTO_INCREMENT,  
 CH_DESCRICAO VARCHAR(300) NOT NULL,  
 CH_RESOLUCAO TEXT NULL,
 ID_USUARIO INT NOT NULL,  
 ID_ATENDENTE INT,  
 ID_ESTADO INT NOT NULL
); 

CREATE TABLE ESTADO 
( 
 ES_DESCRICAO VARCHAR(20) NOT NULL,  
 ES_ID INT PRIMARY KEY AUTO_INCREMENT
); 

CREATE TABLE SOLUCOES 
( 
 SO_DESCRICAO VARCHAR(300) NOT NULL,  
 SO_DT_CRIACAO DATE NOT NULL,  
 SO_ID INT PRIMARY KEY,  
 idCHAMADOS INT NOT NULL
); 

CREATE TABLE PERMITE 
( 
 US_ID INT,  
 AC_ID INT,
 CONSTRAINT pk_PE PRIMARY KEY (US_ID, AC_ID) 
); 

CREATE TABLE INCLUI 
( 
 AC_ID INT,  
 GP_ID INT,
 CONSTRAINT pk_IN PRIMARY KEY (GP_ID, AC_ID) 
); 

ALTER TABLE CHAMADOS ADD FOREIGN KEY(ID_USUARIO) REFERENCES USUARIOS (US_ID);
ALTER TABLE CHAMADOS ADD FOREIGN KEY(ID_ATENDENTE) REFERENCES USUARIOS (US_ID);
ALTER TABLE CHAMADOS ADD FOREIGN KEY(ID_ESTADO) REFERENCES ESTADO (ES_ID);
ALTER TABLE SOLUCOES ADD FOREIGN KEY(idCHAMADOS) REFERENCES CHAMADOS (CH_ID);
ALTER TABLE PERMITE ADD FOREIGN KEY(US_ID) REFERENCES USUARIOS (US_ID);
ALTER TABLE PERMITE ADD FOREIGN KEY(AC_ID) REFERENCES ACESSOS (AC_ID);
ALTER TABLE INCLUI ADD FOREIGN KEY(AC_ID) REFERENCES ACESSOS (AC_ID);
ALTER TABLE INCLUI ADD FOREIGN KEY(GP_ID) REFERENCES GRUPOS (GP_ID);

INSERT INTO `acessos`(`AC_DESCRICAO`) VALUES ('Abrir chamados'),('Encerrar chamados de outro solicitante'), ('Conceder acessos'), ('Visualizar chamados de outro solicitante'),('Abrir chamados para outro');
INSERT INTO `grupos`(`GP_DESCRICAO`) VALUES ('us_comum'),('us_administrador'), ('us_atendemte');
INSERT INTO `inclui`(`AC_ID`, `GP_ID`) VALUES ('1','1'), ('1','2'), ('2','2'), ('1','3'), ('2','3'), ('3','3');
INSERT INTO `estado` (`ES_DESCRICAO`, `ES_ID`) VALUES ('Aberto', '1'),('Fechado', '2'), ('Andamento', '3'), ('Reaberto', '4');


INSERT INTO `usuarios`(`US_DESCRICAO`, `US_DT_CRIACAO`, `US_NOME`, `US_SENHA`) VALUES ('Administrador', '2022-12-15 00:00:00', 'adm', '123');
INSERT INTO `permite`(`US_ID`, `AC_ID`) VALUES ('1', '1'), ('1', '2'), ('1', '3'), ('1', '4'), ('1', '5');


INSERT INTO `usuarios`(`US_DESCRICAO`, `US_DT_CRIACAO`, `US_NOME`, `US_SENHA`) VALUES ('Usuario teste', '2022-12-15 00:00:00', 'user', '123');
INSERT INTO `permite`(`US_ID`, `AC_ID`) VALUES ('2', '1');
