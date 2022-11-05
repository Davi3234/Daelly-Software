# Create Database

DROP DATABASE `daelly`;
CREATE DATABASE `daelly`;
USE `daelly`;

# Create Tables

DROP TABLE IF EXISTS `administrador`;
CREATE TABLE `administrador` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(45) DEFAULT NULL,
  `email` VARCHAR(45) DEFAULT NULL,
  `senha` VARCHAR(45) DEFAULT NULL,
  `tentativas` INT DEFAULT NULL,
  `ultimo_acesso` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `grupo`;
CREATE TABLE `grupo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `numero` INT NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `funcionario`;
CREATE TABLE `funcionario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_grupo` INT DEFAULT NULL,
  `cpf` VARCHAR(14) NOT NULL,
  `nome` VARCHAR(50) NULL,
  `inicio` VARCHAR(10) NULL,
  `saida` VARCHAR(10) NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `funcao`;
CREATE TABLE `funcao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_tipo` INT DEFAULT NULL,
  `nome` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `funca_funci`;
CREATE TABLE `funca_funci` (
  `id_funcionario` INT NOT NULL,
  `id_funcao` INT NOT NULL,
  PRIMARY KEY (`id_funcionario`,`id_funcao`)
);

DROP TABLE IF EXISTS `tipo`;
CREATE TABLE `tipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `maquina_costura`;
CREATE TABLE `maquina_costura` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_tipo` INT NOT NULL,
  `codigo` INT NOT NULL,
  `modelo` VARCHAR(50) NULL,
  `marca` VARCHAR(50) NULL,
  `chassi` VARCHAR(50) NULL,
  `aquisicao` VARCHAR(50) NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `maquina_costura_mapa`;
CREATE TABLE `maquina_costura_mapa` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_maquina_costura` INT NOT NULL,
  `posicionado` INT NULL DEFAULT 0,
  `x` INT NULL DEFAULT 0,
  `y` INT NULL DEFAULT 0,
  `width` INT NOT NULL,
  `height` INT NOT NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `manutencao`;
CREATE TABLE `manutencao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_maquina_costura` INT DEFAULT NULL,
  `id_compressor` INT DEFAULT NULL,
  `descricao` VARCHAR(150) NULL,
  `data_manutencao` VARCHAR(10) NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `compressor`;
CREATE TABLE `compressor` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `codigo` INT NOT NULL,
  `marca` VARCHAR(50) NULL,
  `modelo` VARCHAR(50) NULL,
  PRIMARY KEY (`id`)
);

DROP TABLE IF EXISTS `mapa`;
CREATE TABLE `mapa` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `width` INT NOT NULL,
  `height` INT NOT NULL,
  PRIMARY KEY (`id`)
);