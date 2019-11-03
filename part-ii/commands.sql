DROP DATABASE IF EXISTS `workshop`;
CREATE DATABASE IF NOT EXISTS `workshop` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `workshop`;

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task` varchar(128) NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;


INSERT INTO `tasks` (`id`, `task`, `status`) VALUES
(1, 'task-1', 0),
(2, 'task-2', 1),
(3, 'task-3', 0),
(4, 'task-4', 0),
(5, 'task-5', 0),
(6, 'task-6', 0),
(7, 'task-7', 0),
(8, 'task-8', 0),
(9, 'task-9', 0),
(10, 'task-10', 0);
COMMIT;
