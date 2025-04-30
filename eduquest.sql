-- Adminer 4.8.1 MySQL 8.0.41 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `answer`;
CREATE TABLE `answer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question_id` int NOT NULL,
  `texte` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_correct` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DADD4A251E27F6BF` (`question_id`),
  CONSTRAINT `FK_DADD4A251E27F6BF` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `debate_message`;
CREATE TABLE `debate_message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_id` int DEFAULT NULL,
  `parent_id` int DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `likes` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4CA444B5F675F31B` (`author_id`),
  KEY `IDX_4CA444B5727ACA70` (`parent_id`),
  CONSTRAINT `FK_4CA444B5727ACA70` FOREIGN KEY (`parent_id`) REFERENCES `debate_message` (`id`),
  CONSTRAINT `FK_4CA444B5F675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;


DROP TABLE IF EXISTS `likes`;
CREATE TABLE `likes` (
  `id` int NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `participation`;
CREATE TABLE `participation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `date_participation` datetime NOT NULL,
  `score` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AB55E24FA76ED395` (`user_id`),
  CONSTRAINT `FK_AB55E24FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quiz_id` int NOT NULL,
  `texte` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B6F7494E853CD175` (`quiz_id`),
  CONSTRAINT `FK_B6F7494E853CD175` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `quiz`;
CREATE TABLE `quiz` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `duration` int NOT NULL,
  `created_at` datetime NOT NULL,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `quiz` (`id`, `title`, `description`, `duration`, `created_at`, `category`) VALUES
(1,	'Les bases de la Physique-Chimie',	'Testez vos bases en Physique-Chimie avec 6 questions (QCM et Vrai/Faux) sur les états de la matière, les symboles chimiques, les transformations physiques et les mélanges.',	6,	'2025-04-30 21:18:44',	'Physique-Chimie'),
(2,	'Les bases de l\'Histoire',	'Quiz de 5 questions pour réviser les grandes bases de l’Histoire : Révolution française, figures célèbres et faits marquants (QCM & Vrai/Faux).',	5,	'2025-04-30 21:23:19',	'Histoire'),
(3,	'Géographie : Vrai ou Faux ?',	'10 affirmations simples pour tester vos connaissances de base en géographie mondiale : continents, capitales, océans, pays, frontières.',	10,	'2025-04-30 21:26:39',	'Géographie'),
(4,	'Français – Questions ouvertes',	'5 questions ouvertes pour tester votre maîtrise du français : conjugaison, orthographe, grammaire et vocabulaire. Niveau intermédiaire.',	5,	'2025-04-30 21:32:56',	'Français'),
(5,	'Mathématiques – Niveau Avancé',	'6 questions complexes de calcul, logique et géométrie. Niveau difficile : réflexion, rigueur et précision exigées. 4 ouvertes, 1 QCM, 1 vrai/faux.',	6,	'2025-04-30 21:37:04',	'Maths'),
(6,	'Culture Générale – Niveau Facile',	'5 QCM simples pour tester vos connaissances générales sur les pays, les monuments, les inventions et la langue française. Idéal pour débuter ou réviser.',	5,	'2025-04-30 21:40:36',	'Culture Générale'),
(7,	'Anglais – Vrai ou Faux (niveau facile)',	'7 questions Vrai/Faux pour tester votre anglais de base : vocabulaire courant, phrases simples et compréhension de mots usuels.',	7,	'2025-04-30 21:43:00',	'Anglais'),
(8,	'SVT – Niveau Avancé',	'6 questions difficiles en SVT sur la biologie et la planète : 3 ouvertes, 2 QCM, 1 Vrai/Faux. Idéal pour tester ses connaissances pointues.',	6,	'2025-04-30 21:46:27',	'S.V.T'),
(9,	'Philosophie – Niveau Très Difficile',	'10 questions de philosophie avancée pour tester vos connaissances sur des notions complexes et des théories philosophiques des grands penseurs de l’histoire.',	10,	'2025-04-30 21:49:05',	'Philosophie'),
(10,	'Quiz Sport – Niveau Facile à Moyen',	'5 questions pour tester vos connaissances sportives : règles, événements sportifs célèbres, athlètes et disciplines populaires. Niveau facile à moyen.',	5,	'2025-04-30 21:51:19',	'Sports'),
(11,	'Maths – Niveau Moyen-Difficile',	'8 questions de calcul, géométrie et algèbre. Réponses uniquement numériques. Niveau intermédiaire à difficile pour tester vos compétences en mathématiques.',	8,	'2025-04-30 21:54:11',	'Maths');

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `user_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_level` int DEFAULT NULL,
  `grade_level` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `user_answer`;
CREATE TABLE `user_answer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question_id` int NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BF8F51181E27F6BF` (`question_id`),
  CONSTRAINT `FK_BF8F51181E27F6BF` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2025-04-30 20:25:18
