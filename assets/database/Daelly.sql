# Create Database

DROP DATABASE `daelly`;
CREATE DATABASE `daelly`;
USE `daelly`;

# Create Tables

DROP TABLE IF EXISTS `administrador`;
DROP TABLE IF EXISTS `grupo`;
DROP TABLE IF EXISTS `funcionario`;
DROP TABLE IF EXISTS `funcao`;
DROP TABLE IF EXISTS `funca_funci`;
DROP TABLE IF EXISTS `tipo`;
DROP TABLE IF EXISTS `maquina_costura`;
DROP TABLE IF EXISTS `manutencao`;
DROP TABLE IF EXISTS `compressor`;
DROP TABLE IF EXISTS `maquina_costura_mapa`;

CREATE TABLE `administrador` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `email` INT DEFAULT NULL,
  `senha` VARCHAR(14) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `grupo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `numero` INT NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `funcionario` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_grupo` INT DEFAULT NULL,
  `cpf` VARCHAR(14) NOT NULL,
  `nome` VARCHAR(50) NULL,
  `inicio` VARCHAR(10) NULL,
  `saida` VARCHAR(10) NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `funcao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_tipo` INT DEFAULT NULL,
  `nome` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `funca_funci` (
  `id_funcionario` INT NOT NULL,
  `id_funcao` INT NOT NULL,
  PRIMARY KEY (`id_funcionario`,`id_funcao`)
);

CREATE TABLE `tipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
);

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

CREATE TABLE `manutencao` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_maquina_costura` INT DEFAULT NULL,
  `id_compressor` INT DEFAULT NULL,
  `descricao` VARCHAR(150) NULL,
  `data_manutencao` VARCHAR(10) NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `compressor` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `codigo` INT NOT NULL,
  `marca` VARCHAR(50) NULL,
  `modelo` VARCHAR(50) NULL,
  PRIMARY KEY (`id`)
);

CREATE TABLE `maquina_costura_mapa` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_maquina_costura` INT NOT NULL,
  `posicionado` INT NULL DEFAULT 0,
  `x` INT NULL DEFAULT 0,
  `y` INT NULL DEFAULT 0,
  PRIMARY KEY (`id`)
);