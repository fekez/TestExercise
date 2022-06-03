CREATE OR REPLACE DATABASE `porthu`;
USE `porthu`;


CREATE TABLE `channels` (
                        `id` varchar(255) NOT NULL,
                        `name` varchar(255) NOT NULL,
                        `logo` varchar(255) NULL,
                        PRIMARY KEY(`id`)
);

CREATE TABLE `programs` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `start_date` date NOT NULL,
                            `start_time` time NOT NULL,
                            `title` varchar(255) NOT NULL,
                            `short_description` varchar(255) NOT NULL,
                            `age_limit` int(11) NOT NULL,
                            `channel_id` varchar(255) NOT NULL,
                            PRIMARY KEY(`id`)
) ENGINE = InnoDB;

ALTER TABLE `programs`
    ADD CONSTRAINT FK_CHANNEL
        FOREIGN KEY (`channel_id`) REFERENCES `channels`(`id`)
            ON DELETE CASCADE;