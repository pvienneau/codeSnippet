version 2

ALTER TABLE `invoice` DROP `taxe_rate`, DROP `discount_rate`, DROP `shipping_amount`;
ALTER TABLE `estimate` DROP `taxe_rate`, DROP `discount_rate`, DROP `shipping_amount`;

ALTER TABLE `invoice` ADD `tax2` FLOAT NOT NULL AFTER  `tax`;
ALTER TABLE `invoice` ADD `tax2_name` VARCHAR( 10 ) NOT NULL AFTER  `tax_name`;
ALTER TABLE `invoice` ADD `tax2_cumulative` TINYINT( 1 ) NOT NULL AFTER  `tax2_name`;

ALTER TABLE `invoice` 	ADD `discount_fee` FLOAT NOT NULL AFTER `management_fee` ,
						ADD `tax_fee` FLOAT NOT NULL AFTER `discount_fee` ,
						ADD `tax2_fee` FLOAT NOT NULL AFTER `tax_fee`;

ALTER TABLE `estimate` ADD `tax2` FLOAT NOT NULL AFTER  `tax`;
ALTER TABLE `estimate` ADD `tax2_name` VARCHAR( 10 ) NOT NULL AFTER  `tax_name`;
ALTER TABLE `estimate` ADD `tax2_cumulative` TINYINT( 1 ) NOT NULL AFTER  `tax2_name`;


ALTER TABLE `estimate` ADD `discount_fee` FLOAT NOT NULL AFTER `management_fee` ,
					ADD `tax_fee` FLOAT NOT NULL AFTER `discount_fee` ,
					ADD `tax2_fee` FLOAT NOT NULL AFTER `tax_fee`;
					
// -------------------------------------------------------------

ALTER TABLE `estimate_option` ADD `accepted` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `total` ;

ALTER TABLE `client` ADD `tax` FLOAT NOT NULL AFTER `tax_id` ,
ADD `tax2` FLOAT NOT NULL AFTER `tax` ,
ADD `tax_name` VARCHAR( 5 ) NOT NULL AFTER `tax2` ,
ADD `tax2_name` VARCHAR( 5 ) NOT NULL AFTER `tax_name` ,
ADD `tax2_cumulative` TINYINT( 1 ) NOT NULL DEFAULT '0' AFTER `tax2_name`;