ALTER TABLE `order` ADD `total` DECIMAL(11,2) NOT NULL AFTER `note`;

ALTER TABLE `orders` CHANGE `cutomer_id` `customer_id` INT(11) NOT NULL;

ALTER TABLE `orders` CHANGE `status` `status` VARCHAR(125) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '1' COMMENT '1 - Pending,2 - On Process, 3 - On Delivery, 4 - Completed';