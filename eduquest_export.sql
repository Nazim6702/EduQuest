-- Adminer 4.8.1 MySQL 8.0.41 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `answer`;
CREATE TABLE `answer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question_id` int NOT NULL,
  `texte` varchar(255) DEFAULT NULL,
  `is_correct` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Question_Answer` (`question_id`),
  CONSTRAINT `FK_Question_Answer` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `answer` (`id`, `question_id`, `texte`, `is_correct`) VALUES
(1,	1,	'4',	1),
(2,	1,	'5',	0),
(3,	1,	'6',	0),
(4,	2,	'3',	1),
(5,	2,	'4',	0),
(6,	2,	'5',	0),
(7,	3,	'π * r^2',	1),
(8,	3,	'2πr',	0),
(9,	3,	'4r',	0),
(10,	4,	'Paris',	1),
(11,	4,	'Berlin',	0),
(12,	4,	'London',	0),
(13,	5,	'Asia',	1),
(14,	5,	'Africa',	0),
(15,	5,	'Europe',	0),
(16,	6,	'Victor Hugo',	1),
(17,	6,	'Emile Zola',	0),
(18,	6,	'Marcel Proust',	0),
(19,	7,	'Shakespeare',	1),
(20,	7,	'Dickens',	0),
(21,	7,	'Tolkien',	0),
(22,	8,	'Van Gogh',	1),
(23,	8,	'Picasso',	0),
(24,	8,	'Monet',	0),
(25,	9,	'The Godfather',	1),
(26,	9,	'Pulp Fiction',	0),
(27,	9,	'The Matrix',	0),
(28,	10,	'Football',	1),
(29,	10,	'Basketball',	0),
(30,	10,	'Tennis',	0),
(31,	31,	'22',	1),
(32,	32,	'rouge',	1),
(33,	33,	'True',	1),
(34,	33,	'False',	0),
(35,	34,	'True',	0),
(36,	34,	'False',	1),
(37,	35,	'True',	1),
(38,	35,	'False',	0),
(39,	36,	'True',	0),
(40,	36,	'False',	1),
(41,	37,	'True',	1),
(42,	37,	'False',	0),
(43,	38,	'True',	0),
(44,	38,	'False',	1),
(45,	39,	'True',	1),
(46,	39,	'False',	0),
(47,	40,	'True',	1),
(48,	40,	'False',	0),
(49,	41,	'True',	0),
(50,	41,	'False',	1);

SET NAMES utf8mb4;

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

INSERT INTO `debate_message` (`id`, `author_id`, `parent_id`, `content`, `created_at`, `likes`) VALUES
(1,	4,	NULL,	'bonjour',	'2025-04-30 19:04:05',	0);

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250404093244',	'2025-04-04 11:41:33',	4598);

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
  `quiz_id` int NOT NULL,
  `date_participation` datetime NOT NULL,
  `score` double NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AB55E24FA76ED395` (`user_id`),
  KEY `IDX_AB55E24F853CD175` (`quiz_id`),
  CONSTRAINT `FK_AB55E24F853CD175` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`),
  CONSTRAINT `FK_AB55E24FA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `participation` (`id`, `user_id`, `quiz_id`, `date_participation`, `score`) VALUES
(1,	1,	1,	'2025-04-04 11:47:04',	1),
(2,	1,	6,	'2025-04-04 11:48:30',	0),
(3,	1,	5,	'2025-04-04 12:00:42',	0),
(4,	1,	11,	'2025-04-04 12:15:35',	0),
(5,	1,	12,	'2025-04-04 12:32:02',	2),
(6,	1,	13,	'2025-04-22 15:03:11',	0),
(7,	3,	13,	'2025-04-30 12:10:07',	2),
(8,	3,	12,	'2025-04-30 12:42:24',	2),
(9,	3,	11,	'2025-04-30 13:25:26',	0),
(10,	3,	1,	'2025-04-30 13:30:06',	1),
(11,	4,	13,	'2025-04-30 19:29:42',	1),
(12,	4,	1,	'2025-04-30 19:38:42',	1),
(13,	4,	11,	'2025-04-30 19:42:16',	0),
(14,	4,	2,	'2025-04-30 19:54:26',	1),
(15,	4,	3,	'2025-04-30 20:07:05',	0),
(16,	4,	14,	'2025-04-30 20:36:32',	3);

DROP TABLE IF EXISTS `question`;
CREATE TABLE `question` (
  `id` int NOT NULL AUTO_INCREMENT,
  `quiz_id` int NOT NULL,
  `texte` varchar(255) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `duration` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_Quiz_Question` (`quiz_id`),
  CONSTRAINT `FK_Quiz_Question` FOREIGN KEY (`quiz_id`) REFERENCES `quiz` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `question` (`id`, `quiz_id`, `texte`, `type`, `duration`) VALUES
(1,	1,	'Quelle est la racine carrée de 16 ?',	'QCM',	30),
(2,	1,	'Combien de côtés a un triangle ?',	'QCM',	30),
(3,	1,	'Quelle est la formule pour l\'aire d\'un cercle ?',	'QCM',	30),
(4,	2,	'Quelle est la capitale de la France ?',	'QCM',	40),
(5,	2,	'Quel est le plus grand continent ?',	'QCM',	40),
(6,	2,	'Combien de pays y a-t-il en Europe ?',	'QCM',	40),
(7,	3,	'Qui a écrit \"Les Misérables\" ?',	'QCM',	30),
(8,	3,	'Qui a peint \"La Joconde\" ?',	'QCM',	30),
(9,	3,	'Quel est le plus grand océan du monde ?',	'QCM',	30),
(10,	4,	'Qui était le premier président des États-Unis ?',	'QCM',	45),
(11,	4,	'En quelle année la Révolution française a-t-elle commencé ?',	'QCM',	45),
(12,	4,	'Quel événement a marqué la fin de la Seconde Guerre mondiale ?',	'QCM',	45),
(13,	5,	'Quel est le participe passé de \"manger\" ?',	'QCM',	35),
(14,	5,	'Comment conjugue-t-on \"être\" au futur simple ?',	'QCM',	35),
(15,	5,	'Quelle est la différence entre un adjectif et un adverbe ?',	'QCM',	35),
(16,	6,	'Qu\'est-ce qu\'un atome ?',	'QCM',	40),
(17,	6,	'Comment fonctionne la photosynthèse ?',	'QCM',	40),
(18,	6,	'Quel est l\'organe principal de la respiration humaine ?',	'QCM',	40),
(19,	7,	'Comment dit-on \"hello\" en anglais ?',	'QCM',	25),
(20,	7,	'Quel est le mot pour \"chat\" en anglais ?',	'QCM',	25),
(21,	7,	'Comment conjugue-t-on le verbe \"to be\" au présent ?',	'QCM',	25),
(22,	8,	'Qui a peint la \"Nuit étoilée\" ?',	'QCM',	30),
(23,	8,	'Quel mouvement artistique est associé à Picasso ?',	'QCM',	30),
(24,	8,	'Quelle est la principale caractéristique du cubisme ?',	'QCM',	30),
(25,	9,	'Quel film a remporté l\'Oscar du meilleur film en 1994 ?',	'QCM',	30),
(26,	9,	'Qui a réalisé \"Inception\" ?',	'QCM',	30),
(27,	9,	'Quel acteur a joué le rôle du Joker dans \"The Dark Knight\" ?',	'QCM',	30),
(28,	10,	'Quel est le sport le plus pratiqué au monde ?',	'QCM',	30),
(29,	10,	'Qui a remporté la Coupe du Monde de football en 1998 ?',	'QCM',	30),
(30,	10,	'Quel est le pays d\'origine du tennis ?',	'QCM',	30),
(31,	11,	'mon age',	'Open',	18),
(32,	11,	'couleur du feu',	'Open',	12),
(33,	12,	'vrai',	'True/False',	13),
(34,	12,	'faux',	'True/False',	8),
(35,	13,	'vrai',	'True/False',	17),
(36,	13,	'ezxfze',	'True/False',	14),
(37,	14,	'VRAI',	'True/False',	20),
(38,	14,	'FAUX',	'True/False',	20),
(39,	14,	'VRAI',	'True/False',	20),
(40,	14,	'VRAI',	'True/False',	20),
(41,	14,	'FAUX',	'True/False',	30);

DROP TABLE IF EXISTS `quiz`;
CREATE TABLE `quiz` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `duration` int NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `category` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `quiz` (`id`, `title`, `description`, `duration`, `created_at`, `category`) VALUES
(1,	'Quiz de Mathématiques',	'Testez vos connaissances en mathématiques',	30,	'2024-11-20 10:05:22',	'Maths'),
(2,	'Quiz de Géographie',	'Testez vos connaissances géographiques',	40,	'2024-11-20 10:05:22',	'Géographie'),
(3,	'Quiz de Culture Générale',	'Testez vos connaissances en culture générale',	30,	'2024-11-20 10:05:22',	'Culture Générale'),
(4,	'Quiz de Histoire',	'Testez vos connaissances en histoire',	45,	'2024-11-20 10:05:22',	'Histoire'),
(5,	'Quiz de Français',	'Testez vos connaissances en français',	35,	'2024-11-20 10:05:22',	'Français'),
(6,	'Quiz de Science',	'Testez vos connaissances en science',	40,	'2024-11-20 10:05:22',	'Science'),
(7,	'Quiz d\'Anglais',	'Testez vos connaissances en anglais',	25,	'2024-11-20 10:05:22',	'Anglais'),
(8,	'Quiz d\'Art',	'Testez vos connaissances en art',	30,	'2024-11-20 10:05:22',	'Art'),
(9,	'Quiz de Cinéma',	'Testez vos connaissances en cinéma',	30,	'2024-11-20 10:05:22',	'Cinéma'),
(10,	'Quiz de Sports',	'Testez vos connaissances en sports',	30,	'2024-11-20 10:05:22',	'Sports'),
(11,	'test',	'random',	7,	'2025-04-04 12:07:20',	'Culture Générale'),
(12,	'xfazefx',	'xazefazx',	4,	'2025-04-04 12:29:45',	'Physique-Chimie'),
(13,	'trdtrdtdr',	'tdrtdr',	3,	'2025-04-04 12:30:39',	'Histoire'),
(14,	'aaa',	'aaa',	30,	'2025-04-30 20:33:28',	'Culture Générale');

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

INSERT INTO `user` (`id`, `name`, `email`, `password`, `pseudo`, `created_at`, `user_type`, `admin_level`, `grade_level`, `subject`) VALUES
(1,	'etu',	'etu@gmail.com',	'$2y$13$269FLd/b3JP3N4jXtrDGwu7t2vtb2Ywj5jrgZqZcFXJ19Qni9x6cW',	'etu',	'2025-04-04 11:45:49',	'student',	NULL,	'Première année',	NULL),
(2,	'p',	'p@p',	'$2y$13$CkejLHdjTNVBGWn7uCzc8OUE0t5nQyT2v9Ib9fB1fPXRgiSIJzEQS',	'p',	'2025-04-04 12:04:59',	'teacher',	NULL,	NULL,	'Non défini'),
(3,	'a',	'a@a',	'$2y$13$bjNIj6XrFNXwvluPNCz5suXQdQCZ4UVOn1MHRcR6KvFLMqYQJyxPS',	'a',	'2025-04-30 11:44:39',	'student',	NULL,	'Première année',	NULL),
(4,	't',	't@t',	'$2y$13$IgRSa1Sw4KT1B6ePrdy8.uXdxg0HSMiwmjkkcToHEgFJMSaFoIckq',	't',	'2025-04-30 19:00:34',	'student',	NULL,	'Première année',	NULL),
(5,	'pp',	'pp@pp',	'$2y$13$fOo7jwjLIgL/VPGW0HTaMOkhtE29N4ubpcaoHe.3IuRBt9ak95OB2',	'p',	'2025-04-30 20:30:29',	'teacher',	NULL,	NULL,	'Non défini');

DROP TABLE IF EXISTS `user_answer`;
CREATE TABLE `user_answer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question_id` int NOT NULL,
  `is_correct` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_BF8F51181E27F6BF` (`question_id`),
  CONSTRAINT `FK_BF8F51181E27F6BF` FOREIGN KEY (`question_id`) REFERENCES `question` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


-- 2025-04-30 18:44:15