CREATE DATABASE SyncLab
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_bin;


CREATE TABLE Endereco (
                          idEnd INT AUTO_INCREMENT PRIMARY KEY,
                          ruaEnd VARCHAR(255) NOT NULL,
                          cepEnd VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE Usuario (
                         idUsuario INT AUTO_INCREMENT PRIMARY KEY,
                         nome VARCHAR(255) NOT NULL,
                         username VARCHAR(100) NOT NULL UNIQUE,
                         senha VARCHAR(255) NOT NULL,
                         dataNasc DATE NOT NULL,
                         email VARCHAR(255) NOT NULL UNIQUE ,
                         cpf_ VARCHAR(11) NOT NULL UNIQUE,
                         complemento_ VARCHAR(255) NOT NULL,
                         numero_ INT NOT NULL,
                         fk_Endereco_idEnd INT,
                         FOREIGN KEY (fk_Endereco_idEnd) REFERENCES Endereco(idEnd) ON DELETE CASCADE
);

CREATE TABLE Laboratorio (
                             idLab INT AUTO_INCREMENT PRIMARY KEY,
                             statusLab ENUM('Ativo', 'Desativado'),
                             nomeLab VARCHAR(255) NOT NULL
);

CREATE TABLE Matricula (
                           idMat INT AUTO_INCREMENT PRIMARY KEY,
                           matriculaMat BIGINT UNIQUE NOT NULL,
                           tipoMat TINYINT NOT NULL,
                           statusMat ENUM('Ativo','Em análise','Rejeitado', 'Desativado') DEFAULT 'Em análise',
                           fk_Usuario_idUsuario INT,
                           dataCriacaoMat TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                           FOREIGN KEY (fk_Usuario_idUsuario) REFERENCES Usuario(idUsuario) ON DELETE CASCADE
);

CREATE TABLE Projeto (
                         idProj INT AUTO_INCREMENT PRIMARY KEY,
                         nomeProj VARCHAR(255) NOT NULL,
                         descricaoProj VARCHAR(1000) NOT NULL,
                         statusProj ENUM('Ativo','Em análise','Rejeitado', 'Desativado') DEFAULT 'Em análise',
                         fk_Matricula_idMat INT,
                         fk_Matricula_idMat_ INT,
                         dataCriacaoProj TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                         FOREIGN KEY (fk_Matricula_idMat) REFERENCES Matricula(idMat) ON DELETE CASCADE,
                         FOREIGN KEY (fk_Matricula_idMat_) REFERENCES Matricula(idMat) ON DELETE CASCADE
);

CREATE TABLE Requisicao (
                            idReq INT AUTO_INCREMENT PRIMARY KEY,
                            statusReq ENUM('Aceito', 'Recusado', 'Em análise') DEFAULT 'Em análise',
                            tituloReq VARCHAR(255) NOT NULL,
                            descricaoReq VARCHAR(1000) NOT NULL,
                            fk_Laboratorio_idLab INT NULL,
                            fk_Projeto_idProj INT NULL,
                            fk_Matricula_idMat INT,
                            dataCriacaoReq TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                            FOREIGN KEY (fk_Laboratorio_idLab) REFERENCES Laboratorio(idLab) ON DELETE SET NULL,
                            FOREIGN KEY (fk_Projeto_idProj) REFERENCES Projeto(idProj) ON DELETE SET NULL,
                            FOREIGN KEY (fk_Matricula_idMat) REFERENCES Matricula(idMat) ON DELETE CASCADE
);

CREATE TABLE Atividade (
                           idAtv INT AUTO_INCREMENT PRIMARY KEY,
                           statusAtv ENUM('Finalizada', 'Em análise', 'Em andamento', 'Cancelada') DEFAULT 'Em análise',
                           dataIniAtv TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                           dataFimAtv TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                           tituloAtv VARCHAR(255) NOT NULL,
                           descricaoAtv VARCHAR(1000) NOT NULL,
                           fk_Projeto_idProj INT,
                           FOREIGN KEY (fk_Projeto_idProj) REFERENCES Projeto(idProj) ON DELETE CASCADE
);


CREATE TABLE Integra (
                         fk_Matricula_idMat INT NULL,
                         fk_Projeto_idProj INT NULL,
                         FOREIGN KEY (fk_Matricula_idMat) REFERENCES Matricula(idMat) ON DELETE SET NULL,
                         FOREIGN KEY (fk_Projeto_idProj) REFERENCES Projeto(idProj) ON DELETE SET NULL
);

CREATE TABLE Participa (
                           fk_Matricula_idMat INT NULL,
                           fk_Atividade_idAtv INT NULL,
                           FOREIGN KEY (fk_Matricula_idMat) REFERENCES Matricula(idMat) ON DELETE SET NULL,
                           FOREIGN KEY (fk_Atividade_idAtv) REFERENCES Atividade(idAtv) ON DELETE SET NULL
);

CREATE TABLE Reserva (
                         idReserva INT AUTO_INCREMENT PRIMARY KEY,
                         fk_Laboratorio_idLab INT NULL,
                         fk_Matricula_idMat INT NULL,
                         dataReservaLab TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
                         FOREIGN KEY (fk_Laboratorio_idLab) REFERENCES Laboratorio(idLab) ON DELETE SET NULL,
                         FOREIGN KEY (fk_Matricula_idMat) REFERENCES Matricula(idMat) ON DELETE SET NULL
);
