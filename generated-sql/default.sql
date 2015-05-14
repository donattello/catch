
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- users
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
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
