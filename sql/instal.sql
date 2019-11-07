CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fio` varchar(255) NOT NULL DEFAULT '',
  `username` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `role` varchar(50) NOT NULL DEFAULT '',
  `group_id` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY(id),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caption` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `lessons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL DEFAULT 0,
  `predmet_id` int(11) NOT NULL DEFAULT 0,
  `teacher_id` int(11) NOT NULL DEFAULT 0,
  `visit` tinyint(1) NOT NULL DEFAULT 0,
  `date` date NULL DEFAULT NULL,
  PRIMARY KEY(id),
  KEY `student_id` (`student_id`),
  KEY `predmet_id` (`predmet_id`),
  KEY `teacher_id` (`teacher_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `lessons` (`id`, `student_id`, `predmet_id`, `teacher_id`, `visit`, `date`) VALUES
(1, 2, 1, 1, 1, '2019-11-01'),
(2, 2, 1, 1, 1, '2019-11-02'),
(3, 2, 1, 1, 1, '2019-11-03'),
(4, 2, 1, 1, 1, '2019-11-04'),
(5, 2, 1, 1, 1, '2019-11-05'),
(6, 2, 1, 1, 1, '2019-11-06'),
(7, 2, 1, 1, 1, '2019-11-07'),
(8, 2, 1, 1, 1, '2019-11-08'),
(9, 2, 1, 1, 1, '2019-11-09'),
(10, 2, 1, 1, 1, '2019-11-10'),
(11, 2, 1, 1, 1, '2019-11-11'),
(12, 2, 1, 1, 1, '2019-11-12'),
(13, 2, 1, 1, 1, '2019-11-13'),
(14, 2, 1, 1, 1, '2019-11-14'),
(15, 2, 1, 1, 1, '2019-11-15'),
(16, 2, 1, 1, 1, '2019-11-16'),
(17, 2, 1, 1, 1, '2019-11-17'),
(18, 2, 2, 1, 1, '2019-11-01'),
(19, 2, 2, 1, 1, '2019-11-02'),
(20, 2, 2, 1, 1, '2019-11-03'),
(21, 2, 2, 1, 1, '2019-11-04'),
(22, 2, 2, 1, 1, '2019-11-05'),
(23, 2, 2, 1, 1, '2019-11-06'),
(24, 2, 2, 1, 1, '2019-11-07'),
(25, 2, 2, 1, 1, '2019-11-08'),
(26, 2, 2, 1, 1, '2019-11-09'),
(27, 2, 2, 1, 1, '2019-11-10'),
(28, 2, 2, 1, 1, '2019-11-11'),
(29, 2, 2, 1, 1, '2019-11-12'),
(30, 2, 2, 1, 1, '2019-11-13'),
(31, 2, 2, 1, 1, '2019-11-14'),
(32, 2, 2, 1, 1, '2019-11-15'),
(33, 2, 2, 1, 1, '2019-11-16'),
(34, 2, 2, 1, 1, '2019-11-17');

CREATE TABLE `predmets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `caption` varchar(255) NOT NULL DEFAULT '',
  `count_hours` int(11) NOT NULL DEFAULT 0,
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;