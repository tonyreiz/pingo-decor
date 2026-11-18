-- MySQL dump 10.13  Distrib 8.4.11, for Linux (x86_64)
--
-- Host: localhost    Database: db_pingodecor
-- ------------------------------------------------------
-- Server version	8.4.11

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` bigint NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` varchar(255) NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`),
  KEY `failed_jobs_connection_queue_failed_at_index` (`connection`,`queue`,`failed_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` smallint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_11_12_171137_create_tbl_formulario_table',1),(5,'2026_11_13_000000_add_fields_to_tbl_formulario_table',2),(6,'2026_11_13_000001_add_email_to_tbl_formulario_table',2),(7,'2026_11_13_000002_add_telefone_to_tbl_cliente_table',2),(8,'2026_11_14_000000_create_missing_application_tables',3);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_agendamento`
--

DROP TABLE IF EXISTS `tbl_agendamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_agendamento` (
  `id_agendamento` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `id_funcionario` int NOT NULL,
  `dia_agendamento` date NOT NULL,
  `horario_agendamento` time NOT NULL,
  `status_agendamento` varchar(50) NOT NULL,
  `endereco_agendamento` varchar(255) NOT NULL,
  `data_criacao_agendamento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao_agendamento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_agendamento`),
  KEY `fk_agendamento_cliente` (`id_cliente`),
  KEY `fk_agendamento_funcionario` (`id_funcionario`),
  CONSTRAINT `fk_agendamento_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `tbl_cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_agendamento_funcionario` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionario` (`id_funcionario`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_agendamento`
--

LOCK TABLES `tbl_agendamento` WRITE;
/*!40000 ALTER TABLE `tbl_agendamento` DISABLE KEYS */;
INSERT INTO `tbl_agendamento` VALUES (1,1,1,'2026-06-24','14:00:00','Pendente','Rua das Flores, 123, São Paulo - SP','2026-10-22 19:25:15','2026-10-22 19:57:55'),(2,2,2,'2026-06-25','08:30:00','Pendente','Av. Paulista, 1000, São Paulo - SP','2026-10-22 19:25:15','2026-10-22 19:57:46');
/*!40000 ALTER TABLE `tbl_agendamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_atualizacao_obra`
--

DROP TABLE IF EXISTS `tbl_atualizacao_obra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_atualizacao_obra` (
  `id_atualizacao_obra` int NOT NULL AUTO_INCREMENT,
  `id_projetos` int NOT NULL,
  `id_funcionario` int NOT NULL,
  `descricao_atualizacao_obra` text NOT NULL,
  `imagem_atualizacao_obra` varchar(255) DEFAULT NULL,
  `data_criacao_atualizacao_obra` datetime DEFAULT NULL,
  `data_atualizacao_atualizacao_obra` datetime DEFAULT NULL,
  PRIMARY KEY (`id_atualizacao_obra`),
  KEY `tbl_atualizacao_obra_id_projetos_foreign` (`id_projetos`),
  KEY `tbl_atualizacao_obra_id_funcionario_foreign` (`id_funcionario`),
  CONSTRAINT `tbl_atualizacao_obra_id_funcionario_foreign` FOREIGN KEY (`id_funcionario`) REFERENCES `tbl_funcionario` (`id_funcionario`),
  CONSTRAINT `tbl_atualizacao_obra_id_projetos_foreign` FOREIGN KEY (`id_projetos`) REFERENCES `tbl_projetos` (`id_projetos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_atualizacao_obra`
--

LOCK TABLES `tbl_atualizacao_obra` WRITE;
/*!40000 ALTER TABLE `tbl_atualizacao_obra` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_atualizacao_obra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_banner`
--

DROP TABLE IF EXISTS `tbl_banner`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_banner` (
  `id_banner` int NOT NULL AUTO_INCREMENT,
  `titulo_banner` varchar(50) NOT NULL,
  `imagem_banner` varchar(65) NOT NULL,
  `status_banner` varchar(10) NOT NULL,
  `data_criacao_banner` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao_banner` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_banner`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
  `id_cliente` int NOT NULL AUTO_INCREMENT,
  `nome_cliente` varchar(50) NOT NULL,
  `email_cliente` varchar(80) NOT NULL,
  `telefone_cliente` varchar(20) NOT NULL,
  `senha_cliente` varchar(255) NOT NULL,
  `foto_cliente` varchar(65) DEFAULT NULL,
  `status_cliente` varchar(10) NOT NULL,
  `data_criacao_cliente` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao_cliente` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_cliente`),
  UNIQUE KEY `uq_cliente_email` (`email_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_cliente`
--

LOCK TABLES `tbl_cliente` WRITE;
/*!40000 ALTER TABLE `tbl_cliente` DISABLE KEYS */;
INSERT INTO `tbl_cliente` VALUES (1,'Mariana Oliveira','mariana@email.com','+5511987654321','$2y$12$e1DcrifAbqFolLEsyQwGzuvz0HgjPHllyjYhggJLCRMR/aJbCr8AS','mariana.jpg','Ativo','2026-09-17 16:49:26','2026-11-13 19:37:40'),(2,'Camila Santos','camila@email.com','+5511912345678','$2y$12$jItsRRixVHdnowE7nYs8hedP5HnYQcVneJJPBX2AI/6X/8DgrtgtK','camila.jpg','Ativo','2026-09-17 16:49:26','2026-11-13 19:37:50'),(3,'Fernanda Costa','fernanda.costa@pingodecor.local','+5511998765432','$2y$12$dVJ5WzvDR4skfqeJB6.JYeCJOFfLxRsEONZU51DpE54X5mgIFXfsG','imagem-indisponivel.svg','Ativo','2026-09-17 16:49:26','2026-11-13 19:38:03'),(7,'Pedro Henrique','predo@email.com','+5511941566402','$2y$12$zitYwnSPah4oR8cuhntCpOdvVs9JYT9m2mR98SlhD7eFXCEAyIdo2','imagem-indisponivel.svg','Ativo','2026-11-13 20:19:09','2026-11-13 20:19:09');
/*!40000 ALTER TABLE `tbl_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_contato`
--

DROP TABLE IF EXISTS `tbl_contato`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_contato` (
  `id_contato` int NOT NULL AUTO_INCREMENT,
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
  `data_criacao_contato` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao_contato` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_contato`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
  `id_depoimento` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `titulo_depoimento` varchar(50) NOT NULL,
  `descricao_depoimento` text NOT NULL,
  `nota_depoimento` int NOT NULL,
  `status_depoimento` varchar(10) NOT NULL,
  `data_criacao_depoimento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao_depoimento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_depoimento`),
  KEY `fk_depoimento_cliente` (`id_cliente`),
  CONSTRAINT `fk_depoimento_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `tbl_cliente` (`id_cliente`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
-- Table structure for table `tbl_favoritos`
--

DROP TABLE IF EXISTS `tbl_favoritos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_favoritos` (
  `id_favoritos` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `id_projetos` int NOT NULL,
  `data_criacao_favoritos` datetime DEFAULT NULL,
  `data_atualizacao_favoritos` datetime DEFAULT NULL,
  PRIMARY KEY (`id_favoritos`),
  UNIQUE KEY `tbl_favoritos_id_cliente_id_projetos_unique` (`id_cliente`,`id_projetos`),
  KEY `tbl_favoritos_id_projetos_foreign` (`id_projetos`),
  CONSTRAINT `tbl_favoritos_id_cliente_foreign` FOREIGN KEY (`id_cliente`) REFERENCES `tbl_cliente` (`id_cliente`),
  CONSTRAINT `tbl_favoritos_id_projetos_foreign` FOREIGN KEY (`id_projetos`) REFERENCES `tbl_projetos` (`id_projetos`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_favoritos`
--

LOCK TABLES `tbl_favoritos` WRITE;
/*!40000 ALTER TABLE `tbl_favoritos` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_favoritos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_formulario`
--

DROP TABLE IF EXISTS `tbl_formulario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_formulario` (
  `id_formulario` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `profissao` varchar(255) DEFAULT NULL,
  `tipo_projeto` varchar(255) NOT NULL,
  `metragem` decimal(8,2) DEFAULT NULL,
  `prazo` varchar(255) DEFAULT NULL,
  `descricao` text,
  `observacoes` text,
  `status_formulario` varchar(10) NOT NULL DEFAULT 'pendente',
  `data_criacao_formulario` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao_formulario` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_formulario`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_formulario`
--

LOCK TABLES `tbl_formulario` WRITE;
/*!40000 ALTER TABLE `tbl_formulario` DISABLE KEYS */;
INSERT INTO `tbl_formulario` VALUES (1,'Mariana Oliveira','mariana@email.com','(11) 99999-1234','Rua das Flores, 150 - São Paulo/SP','Professora','Quarto de bebê',15.50,'3 meses','Gostaria de um quarto de bebê aconchegante, com espaço para berço e armário.','Prefiro tons claros e móveis planejados.','pendente','2026-11-13 17:10:51','2026-11-13 19:29:27'),(2,'Matheus Joaquim Alves de Oliveira','matheus@email.com','+5511941566402','sp','goleiro','Quarto infantil',15.70,'1 ano',NULL,NULL,'Novo','2026-11-13 18:28:55','2026-11-13 19:29:13'),(3,'Pedro Henrique','predo@email.com','+5511941566402','sp','goleiro','Quarto infantil',15.70,'1 ano','Quero um quarto perfeito','Vou ficar distante durante o processo','Novo','2026-11-13 20:08:59','2026-11-13 20:08:59');
/*!40000 ALTER TABLE `tbl_formulario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_funcionario`
--

DROP TABLE IF EXISTS `tbl_funcionario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_funcionario` (
  `id_funcionario` int NOT NULL AUTO_INCREMENT,
  `nome_funcionario` varchar(255) NOT NULL,
  `email_funcionario` varchar(255) NOT NULL,
  `telefone_funcionario` varchar(20) NOT NULL,
  `senha_funcionario` varchar(255) NOT NULL,
  `foto_funcionario` varchar(255) NOT NULL,
  `cargo_funcionario` varchar(100) NOT NULL,
  `status_funcionario` varchar(50) NOT NULL DEFAULT 'Ativo',
  `data_criacao_funcionario` datetime DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao_funcionario` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_funcionario`),
  UNIQUE KEY `uq_funcionario_email` (`email_funcionario`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_funcionario`
--

LOCK TABLES `tbl_funcionario` WRITE;
/*!40000 ALTER TABLE `tbl_funcionario` DISABLE KEYS */;
INSERT INTO `tbl_funcionario` VALUES (1,'Mariana Oliveira','mariana@email.com','+551189345674','$2y$12$.uINPl1f/17tZ9SmTHUqBujEHhHacqKjP8daX/ZYnepYBCZmWu852','mariana.jpg','ADMINISTRADOR','Ativo','2026-09-17 16:49:26','2026-11-03 17:09:07'),(2,'Camila Santos','camila@email.com','+551137489283','$2y$12$MyDdR84dr1A/bDOwVN8hFOkcRFvNg2ocwzSA//RIoOSO7hwbyPbby','camila.jpg','ADMINISTRADOR','Ativo','2026-09-17 16:49:26','2026-11-03 17:09:56'),(6,'Matheus Joaquim','matheus@email.com','11941566402','$2y$12$55jz5FpEcUBkN4oz58Yn/uyRI/8oDd2cTUGz9xAPvmuX207rRQluK','funcionario/matheus-joaquim_6_sq0vqg.jpg','ADMINISTRADOR','Ativo','2026-11-03 17:26:19','2026-11-03 17:30:02');
/*!40000 ALTER TABLE `tbl_funcionario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_orcamento`
--

DROP TABLE IF EXISTS `tbl_orcamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_orcamento` (
  `id_orcamento` int NOT NULL AUTO_INCREMENT,
  `id_cliente` int NOT NULL,
  `titulo_orcamento` varchar(50) NOT NULL,
  `valor_total_orcamento` decimal(10,2) NOT NULL,
  `prazo_execucao_orcamento` text NOT NULL,
  `observacoes_orcamento` text NOT NULL,
  `status_orcamento` varchar(10) NOT NULL,
  `data_criacao_orcamento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao_orcamento` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_orcamento`),
  KEY `fk_orcamento_cliente` (`id_cliente`),
  CONSTRAINT `fk_orcamento_cliente` FOREIGN KEY (`id_cliente`) REFERENCES `tbl_cliente` (`id_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
  `id_projetos` int NOT NULL AUTO_INCREMENT,
  `nome_projetos` varchar(30) NOT NULL,
  `imagem_projetos` varchar(65) NOT NULL,
  `status_projetos` varchar(10) NOT NULL,
  `data_criacao_projetos` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao_projetos` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_projetos`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
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
  `id_publicacoes` int NOT NULL AUTO_INCREMENT,
  `titulo_publicacoes` varchar(100) NOT NULL,
  `descricao_publicacoes` text NOT NULL,
  `imagem_publicacoes` varchar(255) NOT NULL,
  `link_publicacoes` varchar(255) NOT NULL,
  `data_publicacoes` datetime NOT NULL,
  `data_criacao_publicacoes` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_atualizacao_publicacoes` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_publicacoes`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_publicacoes`
--

LOCK TABLES `tbl_publicacoes` WRITE;
/*!40000 ALTER TABLE `tbl_publicacoes` DISABLE KEYS */;
INSERT INTO `tbl_publicacoes` VALUES (1,'5 Dicas para Quartos Montessori','Aprenda a organizar o ambiente para dar autonomia à criança.','montessori.jpg','https://pingodecor.com.br/montessori','2026-09-17 16:48:58','2026-09-17 16:48:58','2026-09-17 16:48:58');
/*!40000 ALTER TABLE `tbl_publicacoes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-11-18 19:46:48
