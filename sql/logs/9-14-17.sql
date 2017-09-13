ALTER TABLE `customer` ADD `is_verified` TINYINT(1) NOT NULL DEFAULT '1' AFTER `enabled`;

ALTER TABLE `customer` ADD `web_code_valid` TINYINT(1) NOT NULL DEFAULT '1' AFTER `web_code`;