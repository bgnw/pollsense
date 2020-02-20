DROP DATABASE pollsense;
CREATE DATABASE pollsense;

USE pollsense;

CREATE TABLE users (
    forename VARCHAR(64) NOT NULL,
    surname VARCHAR(64) NOT NULL,
    username VARCHAR(64) NOT NULL UNIQUE PRIMARY KEY,
    password VARCHAR(64) NOT NULL,
    admin BOOLEAN DEFAULT 0 NOT NULL
);

CREATE TABLE polls (
    poll_id INT UNSIGNED AUTO_INCREMENT UNIQUE PRIMARY KEY NOT NULL,
    title VARCHAR(64) NOT NULL,
    mult_choice BOOLEAN DEFAULT 0 NOT NULL,
    username VARCHAR(64),
    FOREIGN KEY (username) REFERENCES users(username)
);

CREATE TABLE options (
    poll_id INT UNSIGNED,
    option_no INT UNSIGNED NOT NULL,
    option_text VARCHAR(64) NOT NULL,
    votes INT UNSIGNED DEFAULT 0 NOT NULL,
    PRIMARY KEY (poll_id, option_no),
    FOREIGN KEY (poll_id) REFERENCES polls(poll_id)
);

INSERT INTO users (forename, surname, username, password, admin) VALUES
("Admin", "User", "admin", "$B8b^BKRSJFn*$H-", 1),
("Alice", "Adams", "alice.adams", "pshg3yb78S3!R#!2", 0),
("Bob", "Bennett", "bob.bennett", "afZ9St2$!$Y*Su-W", 0),
("Charlie", "Cook", "charlie.cook", "WJmey5h=&8c&a#R^", 0);

INSERT INTO polls (title, mult_choice, username) VALUES
("Favourite day?", 0, "bob.bennett"),
("Best social network?", 1, "alice.adams"),
("Favourite music genre?", 0, NULL),
("Best season?", 1, "alice.adams");

INSERT INTO options (poll_id, option_no, option_text) VALUES
(1, 1, "Monday"),
(1, 2, "Tuesday"),
(1, 3, "Wednesday"),
(1, 4, "Thursday"),
(1, 5, "Friday"),
(1, 6, "Saturday"),
(1, 7, "Sunday"),

(2, 1, "Instagram"),
(2, 2, "Snapchat"),
(2, 3, "Twitter"),
(2, 4, "Reddit"),
(3, 1, "Pop"),
(3, 2, "Hip-Hop"),
(3, 3, "Rock"),
(3, 4, "Classical"),
(3, 5, "Country"),

(4, 1, "Spring"),
(4, 2, "Summer"),
(4, 3, "Autumn"),
(4, 4, "Winter");
