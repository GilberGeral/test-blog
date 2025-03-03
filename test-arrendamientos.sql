/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 8.0.41-0ubuntu0.22.04.1 : Database - arrendamientos
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`arrendamientos` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `arrendamientos`;

/*Table structure for table `autores` */

DROP TABLE IF EXISTS `autores`;

CREATE TABLE `autores` (
  `IdAutor` bigint unsigned NOT NULL AUTO_INCREMENT,
  `IdMask` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Nombre` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `foto` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`IdAutor`),
  UNIQUE KEY `autores_idmask_unique` (`IdMask`),
  UNIQUE KEY `autores_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `autores` */

insert  into `autores`(`IdAutor`,`IdMask`,`Nombre`,`foto`,`email`,`created_at`,`created_by`,`updated_at`,`updated_by`) values (9,'dd46abd116084c86','Pedro jaramillo','autor_foto.png','pedroj@gmail.co','2025-03-01 22:23:19','front','2025-03-01 22:23:19','front'),(10,'9a1e931e63cdba7a','Gilberto Fandiño','fee176c465416c06.png','unmail@deu.co','2025-03-01 22:31:07','front','2025-03-01 22:31:07','front'),(11,'233a751f5c43a0d3','Juana de arco','16fdeea283ac59f8.jpg','hfran@fra.cu','2025-03-01 22:32:09','front','2025-03-01 22:32:09','front'),(13,'84eebe5349e97bce','Marcela Fandiño','32ffb787984a44f2.jpg','mivuhe@mailinator.com','2025-03-02 07:09:29','front','2025-03-02 07:10:33','front'),(14,'bab43ed3134e2161','primo','autor_foto.png','primo@prim.co','2025-03-02 09:16:09','front','2025-03-02 09:16:09','front'),(15,'416f988cf5d7446d','Laboriosam officiis','autor_foto.png','qosywo@mailinator.com','2025-03-02 09:18:24','front','2025-03-02 09:18:24','front'),(16,'12df2c9e7de4c4db','Romina','679cacfa4bcf8235.jpg','dupo@mailinator.com','2025-03-02 09:33:01','front','2025-03-02 18:57:00','front'),(17,'df7b83e0f62d37ab','Reprehenderit adipi','4380905dfc1c369a.jpg','lyriqojej@mailinator.com','2025-03-02 18:56:18','front','2025-03-02 18:56:18','front');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2025_03_01_144020_crear_tablas_iniciales',1);

/*Table structure for table `posts` */

DROP TABLE IF EXISTS `posts`;

CREATE TABLE `posts` (
  `IdPost` bigint unsigned NOT NULL AUTO_INCREMENT,
  `IdMask` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IdAutor` bigint unsigned NOT NULL,
  `titulo` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contenido` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `imagen` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `updated_by` varchar(16) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`IdPost`),
  UNIQUE KEY `posts_idmask_unique` (`IdMask`),
  KEY `posts_idautor_foreign` (`IdAutor`),
  CONSTRAINT `posts_idautor_foreign` FOREIGN KEY (`IdAutor`) REFERENCES `autores` (`IdAutor`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `posts` */

insert  into `posts`(`IdPost`,`IdMask`,`IdAutor`,`titulo`,`contenido`,`imagen`,`created_at`,`created_by`,`updated_at`,`updated_by`) values (3,'a5bb56d71b91623ecb65939e43079203',10,'Acerca de la calidad en el desarrollo de software, edit 2','La calidad del software es un pilar fundamental en el desarrollo de productos tecnológicos que no solo cumplan con las expectativas del cliente, sino que también sean fiables y eficientes. En este artículo, exploraremos qué es la calidad del software, los elementos clave que la componen y los principales estándares que guían su implementación en las organizaciones. edit 2','29743bb49d40f615.jpg','2025-03-02 11:45:42','front','2025-03-02 16:35:05','front'),(4,'4ffcc9ea40ae8494b0e6fb929eea42cc',11,'acerca de las web apps','Al contrario del pensamiento popular, el texto de Lorem Ipsum no es simplemente texto aleatorio. Tiene sus raices en una pieza cl´sica de la literatura del Latin, que data del año 45 antes de Cristo, haciendo que este adquiera mas de 2000 años de antiguedad. Richard McClintock, un profesor de Latin de la Universidad de Hampden-Sydney en Virginia, encontró una de las palabras más oscuras de la lengua del latín, \"consecteur\", en un pasaje de Lorem Ipsum, y al seguir leyendo distintos textos del latín, descubr','0514b77bb760fd0fe86a3560.png','2025-03-02 12:37:51','front','2025-03-02 12:37:51','front'),(5,'269d0858dbb671d8b3e01fec5e6d2934',10,'Videojuegos web','La Web rapidamente se ha convertido en una plataforma viable no solo para crear impresionantes juegos de alta calidad, sino también para distruibuirlos.El rango de juegos que pueden ser creados está a la par tanto de los juegos de escritorio como de SO nativos (Android, iOS). Con tecnologias Web modernas y un navegador reciente es totalmente posible hacer juegos de primera categoria para la Web.','b36ad060ec01f09b.jpg','2025-03-02 12:38:55','front','2025-03-02 16:45:57','front'),(6,'9adbd46ada10374413c5dbff4b902e97',10,'Ver atomos','La microscopía electrónica es una herramienta importante en la caracterización de nanomateriales. En su modalidad de alta resolución, es posible obtener imágenes de las columnas de átomos que conforman una muestra, o si el espesor es una monocapa, pueden obtenerse imágenes de átomos. Normalmente, el producto es una imagen con intensidades específicas, que para ser interpretado correctamente, se debe considerar la interacción del haz electrónico con la muestra.','bf711cc0e35e5bffab445efc.jpg','2025-03-02 16:44:28','front','2025-03-02 16:44:28','front'),(7,'1de1b0c602fdf0a05d925aefc94bedb5',14,'Vida en el extranjero','Vivir en el extranjero es una aventura, y más que una aventura también es un desafío. Pues al vivir en otro país uno deberá de adaptarse al cambio, al nuevo ambiente, a la sociedad y en muchas ocasiones también a la diferencia cultural.','c945f8f7801dcc956fa1c9b9.jpg','2025-03-02 18:27:32','front','2025-03-02 18:27:32','front'),(8,'9951d8c2d473dad6166f89442874b5b8',13,'Negocios online','Nunca antes fue tan fácil aprender cómo montar un negocio online sin dinero. Las herramientas para hacerlo están al alcance de cualquier persona con acceso a internet: la cuestión es descubrir cómo aprovecharlas para convertir una idea en una fuente de ingresos.','5280f964d3a5d4146f2a8034.png','2025-03-02 18:28:22','front','2025-03-02 18:28:22','front'),(9,'cb50c5ea1af6598c178e12025acf02d7',16,'Voluptatibus sint ap','Voluptatem Inventore praesentium optio veniam aliquip','0628fd5b1ad6694ad13cd383.jpg','2025-03-02 18:58:49','front','2025-03-02 18:58:49','front');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
