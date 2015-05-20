
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- event
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `event`;

CREATE TABLE `event`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `event_user_id` INTEGER NOT NULL,
    `event_type` INTEGER NOT NULL,
    `event_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    INDEX `event_user_id` (`event_user_id`),
    INDEX `event_type` (`event_type`),
    CONSTRAINT `event_ibfk_1`
        FOREIGN KEY (`event_user_id`)
        REFERENCES `user` (`user_id`),
    CONSTRAINT `event_ibfk_2`
        FOREIGN KEY (`event_type`)
        REFERENCES `sport` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- sport
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sport`;

CREATE TABLE `sport`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `sport` VARCHAR(16) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- user
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user`
(
    `user_id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_name` VARCHAR(64) NOT NULL,
    `user_password_hash` VARCHAR(255) NOT NULL,
    `user_email` VARCHAR(64) NOT NULL,
    PRIMARY KEY (`user_id`),
    UNIQUE INDEX `user_name` (`user_name`),
    UNIQUE INDEX `user_email` (`user_email`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
