CREATE TABLE `user` (
    `id` CHAR(36) NOT NULL DEFAULT UUID(),

    `email` CHAR(254) NOT NULL,
    `password` VARCHAR(256) NOT NULL,
    `name` VARCHAR(128) NOT NULL,

    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `is_activated` BOOLEAN NOT NULL DEFAULT FALSE,

    `gauth_is_activated` BOOLEAN NOT NULL DEFAULT FALSE,
    `gauth_secret_key` CHAR(16) NULL,

    PRIMARY KEY (`id`),
    CONSTRAINT `UID_User_Email` UNIQUE (`email`)
);
