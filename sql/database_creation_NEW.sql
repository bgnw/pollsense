DROP DATABASE pollsense;
CREATE DATABASE pollsense;

USE pollsense;

CREATE TABLE users (
    forename VARCHAR(64) NOT NULL,
    surname VARCHAR(64) NOT NULL,
    username VARCHAR(64) NOT NULL PRIMARY KEY UNIQUE,
    password VARCHAR(64) NOT NULL,
    admin BOOLEAN DEFAULT 0 NOT NULL
);

CREATE TABLE polls (
    poll_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL UNIQUE ,
    title VARCHAR(64) NOT NULL,
    mult_choice BOOLEAN DEFAULT 0 NOT NULL,
    username VARCHAR(64),
    reports INT UNSIGNED DEFAULT 0 NOT NULL,
    FOREIGN KEY (username) REFERENCES users(username) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE options (
    poll_id INT UNSIGNED,
    option_no INT UNSIGNED NOT NULL,
    option_text VARCHAR(64) NOT NULL,
    votes INT UNSIGNED DEFAULT 0 NOT NULL,
    PRIMARY KEY (poll_id, option_no),
    FOREIGN KEY (poll_id) REFERENCES polls(poll_id) ON DELETE CASCADE
);

INSERT INTO users VALUES
("Admin", "User", "admin", "7SxgFf29N2rJxuZB", 1),
("Alice", "Adams", "alice.adams", "AYXi6sooWjNc0ZVU", 0),
("Bob", "Bennett", "bob.bennett", "dCQi6Nzo1p7FLj1o", 0),
("Charlie", "Cook", "charlie.cook", "vVQuuR2IdpV9NFgU", 0);

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
