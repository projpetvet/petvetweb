ALTER TABLE `customer` ADD `web_key` VARCHAR(125) NOT NULL AFTER `password`, ADD `web_code` VARCHAR(5) NOT NULL AFTER `web_key`;