ALTER TABLE `orders` CHANGE `status` `status` VARCHAR(125) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '1' COMMENT '1 - Pending,2 - On Process, 3 - On Delivery, 4 - Completed, 5 - Canceled';

ALTER TABLE `appointment` CHANGE `status` `status` TINYINT(4) NOT NULL COMMENT '1 - Pending, 2 - Approved, 3 - Declined, 4 - Completed, 5 - Canceled';