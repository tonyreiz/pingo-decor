
-- MySQL dump 10.13  Distrib 8.0.44, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: db_pingodecor
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_banner`
--

DROP TABLE IF EXISTS `tbl_banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_banner` (
  `id_banner` int(11) NOT NULL AUTO_INCREMENT,
  `titulo_banner` varchar(50) NOT NULL,
  `imagem_banner` varchar(65) NOT NULL,
  `status_banner` varchar(10) NOT NULL,
  `data_criacao_banner` datetime NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao_banner` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_banner`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_banner`
--

LOCK TABLES `tbl_banner` WRITE;
/*!40000 ALTER TABLE `tbl_banner` DISABLE KEYS */;
INSERT INTO `tbl_banner` VALUES (1,'Transformando Sonhos em Quartos Infantis','banner1.jpg','Ativo','2026-09-17 16:49:34','2026-09-17 16:49:34'),(2,'Projetos Personalizados para Crianças','banner2.jpg','Ativo','2026-09-17 16:49:34','2026-09-17 16:49:34');
/*!40000 ALTER TABLE `tbl_banner` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_cliente`
--

DROP TABLE IF EXISTS `tbl_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(50) NOT NULL,
  `email_cliente` varchar(80) NOT NULL,
  `senha_cliente` varchar(255) NOT NULL,
  `foto_cliente` varchar(65) NOT NULL,
  `status_cliente` varchar(10) NOT NULL,
  `data_criacao_cliente` datetime NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao_cliente` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cliente`
--

LOCK TABLES `tbl_cliente` WRITE;
/*!40000 ALTER TABLE `tbl_cliente` DISABLE KEYS */;
INSERT INTO `tbl_cliente` VALUES (1,'Mariana Oliveira','mariana@email.com','123456','mariana.jpg','Ativo','2026-09-17 16:49:26','2026-09-17 16:49:26'),(2,'Camila Santos','camila@email.com','123456','camila.jpg','Ativo','2026-09-17 16:49:26','2026-09-17 16:49:26'),(3,'Fernanda Costa','fernanda.costa@pingodecor.local','123456','imagem-indisponivel.svg','Ativo','2026-09-17 16:49:26','2026-09-17 16:49:26');
/*!40000 ALTER TABLE `tbl_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_contato`
--

DROP TABLE IF EXISTS `tbl_contato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_contato` (
  `id_contato` int(11) NOT NULL AUTO_INCREMENT,
  `nome_contato` varchar(60) NOT NULL,
  `nome_companheiro_contato` varchar(70) NOT NULL,
  `nome_idade_criancas_contato` varchar(60) NOT NULL,
  `email_contato` varchar(80) NOT NULL,
  `telefone_contato` varchar(15) NOT NULL,
  `cidade_bairro_contato` varchar(32) NOT NULL,
  `profissao_contato` varchar(80) NOT NULL,
  `origem_contato` varchar(23) NOT NULL,
  `ajuda_contato` varchar(47) NOT NULL,
  `metragem_contato` varchar(70) NOT NULL,
  `quantidades_ambientes_contato` varchar(14) NOT NULL,
  `trimestre_gestacao_contato` varchar(37) NOT NULL,
  `prazo_contato` varchar(15) NOT NULL,
  `detalhes_contato` varchar(80) NOT NULL,
  `data_criacao_contato` datetime NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao_contato` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_contato`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_contato`
--

LOCK TABLES `tbl_contato` WRITE;
/*!40000 ALTER TABLE `tbl_contato` DISABLE KEYS */;
INSERT INTO `tbl_contato` VALUES (1,'Mariana Oliveira','Rafael Oliveira','Helena - 4 anos','mariana.oliveira@email.com','11987654321','São Paulo - Moema','Empresária','Instagram','Quarto infantil completo','12 m²','1 ambiente','Não se aplica','3 meses','Quarto feminino com espaço para brincar','2026-09-17 16:41:08','2026-09-17 16:41:08'),(2,'Camila Santos','Lucas Santos','Theo - 2 anos','camila.santos@email.com','11991234567','São Paulo - Tatuapé','Médica','Indicação','Projeto de quarto infantil','10 m²','1 ambiente','Não se aplica','2 meses','Quarto infantil com cama e armários','2026-09-17 16:41:08','2026-09-17 16:41:08'),(3,'Fernanda Costa','André Costa','Miguel - 6 anos','fernanda.costa@email.com','11999887766','São Paulo - Vila Mariana','Advogada','Instagram','Reforma do quarto','14 m²','1 ambiente','Não se aplica','4 meses','Reforma completa com marcenaria','2026-09-17 16:41:08','2026-09-17 16:41:08');
/*!40000 ALTER TABLE `tbl_contato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_depoimento`
--

DROP TABLE IF EXISTS `tbl_depoimento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_depoimento` (
  `id_depoimento` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `titulo_depoimento` varchar(50) NOT NULL,
  `descricao_depoimento` text NOT NULL,
  `nota_depoimento` int(11) NOT NULL,
  `status_depoimento` varchar(10) NOT NULL,
  `data_criacao_depoimento` datetime NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao_depoimento` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_depoimento`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_depoimento`
--

LOCK TABLES `tbl_depoimento` WRITE;
/*!40000 ALTER TABLE `tbl_depoimento` DISABLE KEYS */;
INSERT INTO `tbl_depoimento` VALUES (1,1,'Projeto Incrível!','O quarto da Helena ficou perfeito, muito funcional e lindo.',5,'Ativo','2026-09-17 16:49:22','2026-09-17 16:49:22'),(2,2,'Super Recomendo','Atenção aos detalhes impecável em todo o processo.',5,'Ativo','2026-09-17 16:49:22','2026-09-17 16:49:22');
/*!40000 ALTER TABLE `tbl_depoimento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_orcamento`
--

DROP TABLE IF EXISTS `tbl_orcamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_orcamento` (
  `id_orcamento` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL,
  `titulo_orcamento` varchar(50) NOT NULL,
  `valor_total_orcamento` decimal(10,2) NOT NULL,
  `prazo_execucao_orcamento` text NOT NULL,
  `observacoes_orcamento` text NOT NULL,
  `status_orcamento` varchar(10) NOT NULL,
  `data_criacao_orcamento` datetime NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao_orcamento` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_orcamento`),
  KEY `fk_orcamento_cliente` (`id_cliente`),
  CONSTRAINT `fk_orcamento_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `tbl_cliente` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_orcamento`
--

LOCK TABLES `tbl_orcamento` WRITE;
/*!40000 ALTER TABLE `tbl_orcamento` DISABLE KEYS */;
INSERT INTO `tbl_orcamento` VALUES (10,1,'Quarto Infantil Helena',18500.00,'45 dias','Projeto de quarto infantil feminino com marcenaria planejada.','Pendente','2026-09-17 16:41:20','2026-09-17 16:41:20'),(11,2,'Quarto Infantil Theo',16200.00,'40 dias','Projeto de quarto infantil masculino com bancada de estudos.','Aprovado','2026-09-17 16:41:20','2026-09-17 16:41:20'),(12,3,'Quarto Infantil Miguel',22400.00,'60 dias','Reforma completa do quarto com marcenaria e iluminação.','Analise','2026-09-17 16:41:20','2026-09-17 16:41:20'),(13,1,'Quarto Infantil Helena',18500.00,'45 dias','Projeto de quarto infantil feminino com marcenaria planejada, cama, iluminação decorativa e espaço para brincar.','Pendente','2026-09-17 16:46:01','2026-09-17 16:46:01'),(14,2,'Quarto Infantil Theo',16200.00,'40 dias','Projeto de quarto infantil masculino com cama, armários planejados, bancada de estudos e decoração temática.','Aprovado','2026-09-17 16:46:01','2026-09-17 16:46:01'),(15,3,'Quarto Infantil Miguel',22400.00,'60 dias','Reforma completa do quarto com marcenaria planejada, área de estudos, iluminação e composição decorativa.','Analise','2026-09-17 16:46:01','2026-09-17 16:46:01');
/*!40000 ALTER TABLE `tbl_orcamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_projetos`
--

DROP TABLE IF EXISTS `tbl_projetos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_projetos` (
  `id_projetos` int(11) NOT NULL AUTO_INCREMENT,
  `nome_projetos` varchar(30) NOT NULL,
  `imagem_projetos` varchar(65) NOT NULL,
  `status_projetos` varchar(10) NOT NULL,
  `data_criacao_projetos` datetime NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao_projetos` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_projetos`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_projetos`
--

LOCK TABLES `tbl_projetos` WRITE;
/*!40000 ALTER TABLE `tbl_projetos` DISABLE KEYS */;
INSERT INTO `tbl_projetos` VALUES (1,'Quarto Infantil Helena','projeto_helena.jpg','Ativo','2026-09-17 16:51:45','2026-09-17 16:51:45'),(2,'Quarto Infantil Theo','projeto_theo.jpg','Ativo','2026-09-17 16:51:45','2026-09-17 16:51:45');
/*!40000 ALTER TABLE `tbl_projetos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_publicacoes`
--

DROP TABLE IF EXISTS `tbl_publicacoes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_publicacoes` (
  `id_publicacoes` int(11) NOT NULL AUTO_INCREMENT,
  `titulo_publicacoes` varchar(100) NOT NULL,
  `descricao_publicacoes` text NOT NULL,
  `imagem_publicacoes` varchar(255) NOT NULL,
  `link_publicacoes` varchar(255) NOT NULL,
  `data_publicacoes` datetime NOT NULL,
  `data_criacao_publicacoes` datetime NOT NULL DEFAULT current_timestamp(),
  `data_atualizacao_publicacoes` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id_publicacoes`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_publicacoes`
--

LOCK TABLES `tbl_publicacoes` WRITE;
/*!40000 ALTER TABLE `tbl_publicacoes` DISABLE KEYS */;
INSERT INTO `tbl_publicacoes` VALUES (1,'5 Dicas para Quartos Montessori','Aprenda a organizar o ambiente para dar autonomia à criança.','montessori.jpg','https://pingodecor.com.br/montessori','2026-09-17 16:48:58','2026-09-17 16:48:58','2026-09-17 16:48:58');
/*!40000 ALTER TABLE `tbl_publicacoes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-18 14:34:14
