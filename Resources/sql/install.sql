CREATE TABLE IF NOT EXISTS `data_table_columns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `property` varchar(255) NOT NULL,
  `render` text NULL,
  `position` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT IGNORE INTO `data_table_columns` (`id`, `label`, `property`, `render`, `position`)
VALUES
	(1, 'Name', 'articleName', 'return \'<a href\' + \'=\"\' + row.linkDetails + \'\">\' + data + \'</a>\';', 0),
	(2, 'Ordernumber', 'ordernumber', '', 1),
	(3, 'Price', 'price', NULL, 2);
