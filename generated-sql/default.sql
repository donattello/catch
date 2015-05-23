
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- comments
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `comments`;

CREATE TABLE `comments`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `event_id` INTEGER,
    `user_submitting` INTEGER,
    `comment_field` TEXT,
    PRIMARY KEY (`id`),
    INDEX `event_id` (`event_id`),
    INDEX `user_submitting` (`user_submitting`),
    CONSTRAINT `comments_ibfk_1`
        FOREIGN KEY (`event_id`)
        REFERENCES `event` (`id`),
    CONSTRAINT `comments_ibfk_2`
        FOREIGN KEY (`user_submitting`)
        REFERENCES `user` (`user_id`)
) ENGINE=InnoDB;

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
    `event_place` VARCHAR(120) NOT NULL,
    `event_number_people` INTEGER(2) NOT NULL,
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
-- friend
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `friend`;

CREATE TABLE `friend`
(
    `friend_t_id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_id` INTEGER NOT NULL,
    `friend_id` INTEGER NOT NULL,
    PRIMARY KEY (`friend_t_id`),
    INDEX `user_id` (`user_id`),
    INDEX `friend_id` (`friend_id`),
    CONSTRAINT `friend_ibfk_1`
        FOREIGN KEY (`user_id`)
        REFERENCES `user` (`user_id`),
    CONSTRAINT `friend_ibfk_2`
        FOREIGN KEY (`friend_id`)
        REFERENCES `user` (`user_id`)
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
    `user_password_hash` VARCHAR(255),
    `user_email` VARCHAR(64),
    `bio` TEXT,
    `user_age` INTEGER(2),
    `user_gender` VARCHAR(6),
    PRIMARY KEY (`user_id`),
    UNIQUE INDEX `user_name` (`user_name`),
    UNIQUE INDEX `user_email` (`user_email`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
