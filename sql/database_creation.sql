-- Create the database.
CREATE DATABASE pollsense;

-- Create subsequent tables inside of the 'pollsense' database.
USE pollsense;

-- Create the three tables.
CREATE TABLE users (
    forename VARCHAR(64) NOT NULL,
    surname VARCHAR(64) NOT NULL,
    username VARCHAR(64) NOT NULL PRIMARY KEY UNIQUE,
    password VARCHAR(64) NOT NULL,
    admin BOOLEAN DEFAULT 0 NOT NULL,
    creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL
);

CREATE TABLE polls (
    poll_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY NOT NULL UNIQUE,
    title VARCHAR(512) NOT NULL,
    mult_choice BOOLEAN DEFAULT 0 NOT NULL,
    username VARCHAR(64),
    reports INT UNSIGNED DEFAULT 0 NOT NULL,
    creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    FOREIGN KEY (username) REFERENCES users(username) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE options (
    poll_id INT UNSIGNED,
    option_no INT UNSIGNED NOT NULL,
    option_text VARCHAR(512) NOT NULL,
    votes INT UNSIGNED DEFAULT 0 NOT NULL,
    PRIMARY KEY (poll_id, option_no),
    FOREIGN KEY (poll_id) REFERENCES polls(poll_id) ON DELETE CASCADE
);

-- Populate tables with test data.
INSERT INTO users (forename, surname, username, password, admin) VALUES
("AdminTest", "User", "admin.test", "7SxgFf29N2rJxuZB", 1),
("Alice", "Adams", "alice.adams", "AYXi6sooWjNc0ZVU", 0),
("Bob", "Bennett", "bob.bennett", "dCQi6Nzo1p7FLj1o", 0);

INSERT INTO polls (title, mult_choice, username) VALUES
("Favourite day?", 0, "alice.adams"),
("Best social network?", 1, "admin.test"),
("Favourite music genre?", 0, NULL),
("Best season?", 1, "admin.test");

INSERT INTO options (poll_id, option_no, option_text) VALUES
(1, 0, "Monday"),
(1, 1, "Tuesday"),
(1, 2, "Wednesday"),
(1, 3, "Thursday"),
(1, 4, "Friday"),
(1, 5, "Saturday"),
(1, 6, "Sunday"),

(2, 0, "Instagram"),
(2, 1, "Snapchat"),
(2, 2, "Twitter"),
(2, 3, "Reddit"),

(3, 0, "Pop"),
(3, 1, "Hip-Hop"),
(3, 2, "Rock"),
(3, 3, "Classical"),
(3, 4, "Country"),

(4, 0, "Spring"),
(4, 1, "Summer"),
(4, 2, "Autumn"),
(4, 3, "Winter");
