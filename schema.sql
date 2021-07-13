CREATE TABLE `users` (
    id          INTEGER PRIMARY KEY,
    username    VARCHAR(32) NOT NULL,
    password    VARCAHR(64) NOT NULL,
    privilege   UNSGINED TINYINT NOT NULL DEFAULT 0
);

CREATE TABLE `sessions` (
    userId      INTEGER,
    token       VARCHAR(32) NOT NULL,
    createAt    TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(userId) REFERENCES users(id)
);

-- Initialize database
INSERT INTO `users` (username, password, privilege) VALUES ('admin', '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', 255);
