ALTER TABLE `appointment` ADD `note` VARCHAR(512) NOT NULL AFTER `total`;

ALTER TABLE `appointment` CHANGE `app_time` `app_time` INT NOT NULL;