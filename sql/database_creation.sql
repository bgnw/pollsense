-- Create the database, and create all subsequent tables inside it.
CREATE DATABASE pollsense;
USE pollsense;

-- Create the users table.
CREATE TABLE users (

    -- Make a firstname and lastname field that may be up to 64 characters long.
    firstname VARCHAR(64) NOT NULL,
    lastname VARCHAR(64) NOT NULL,

    -- Make a username field that may be up to 64 characters long. This is the
    --   primary key for the table, and therefore must be a unique string.
    username VARCHAR(64) NOT NULL PRIMARY KEY,

    -- Make a password field that may be up to 64 characters long.
    password VARCHAR(512) NOT NULL
);

-- Create the polls table.
CREATE TABLE polls (

    -- Make a primary key called "poll_id" that will be made automatically
    --   unique using the AUTO_INCREMENT attribute.
    poll_id INT UNSIGNED AUTO_INCREMENT UNIQUE NOT NULL PRIMARY KEY,

    -- Make a (required) title field that can store up to 1024 characters.
    title TEXT NOT NULL,

    -- Make a (required) boolean field that will indicate if the poll allows
    --    multiple choices.
    mult_choice BOOLEAN NOT NULL,

    -- Make a (optional foreign key) username field that lets registered users
    --   manage the poll in the future.
    username VARCHAR(64),
    FOREIGN KEY (username) REFERENCES users(username),

    -- Make 10 option text fields, with two of them being required. Each field
    --   may be up to 1024 characters long.
    opt_0_text TEXT NOT NULL,
    opt_1_text TEXT NOT NULL,
    opt_2_text TEXT,
    opt_3_text TEXT,
    opt_4_text TEXT,
    opt_5_text TEXT,
    opt_6_text TEXT,
    opt_7_text TEXT,
    opt_8_text TEXT,
    opt_9_text TEXT,

    -- Make 10 option vote fields to record the number of votes each option has.
    opt_0_votes INT DEFAULT 0 NOT NULL,
    opt_1_votes INT DEFAULT 0 NOT NULL,
    opt_2_votes INT DEFAULT 0,
    opt_3_votes INT DEFAULT 0,
    opt_4_votes INT DEFAULT 0,
    opt_5_votes INT DEFAULT 0,
    opt_6_votes INT DEFAULT 0,
    opt_7_votes INT DEFAULT 0,
    opt_8_votes INT DEFAULT 0,
    opt_9_votes INT DEFAULT 0
);

-- Inserting some sample users.
INSERT INTO users (firstname, lastname, username, password) VALUES
("Alice", "Struthers", "astruthers", "4AFqL54jfQZYE264"),
("Bob", "Roberts", "bob.roberts", "bixu4SyzYCGKKnz6");

-- Inserting some sample polls.
INSERT INTO polls (poll_id, title, mult_choice, username, opt_0_text,
    opt_1_text, opt_2_text, opt_3_text, opt_4_text, opt_5_text, opt_6_text,
    opt_7_text, opt_8_text, opt_9_text, opt_0_votes, opt_1_votes, opt_2_votes,
    opt_3_votes, opt_4_votes, opt_5_votes, opt_6_votes, opt_7_votes,
    opt_8_votes, opt_9_votes) VALUES

(1, "Favourite social media network?", 0, "bob.roberts", "Reddit", "Twitter",
    "Instagram", "Facebook", "Snapchat", NULL, NULL, NULL, NULL, NULL, 0, 0, 0,
    0, 0, 0, 0, 0, 0, 0),

(2, "Favourite season?", 0, "astruthers", "Spring", "Summer", "Autumn",
    "Winter", NULL, NULL, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),

(3, "Lorem ipsum?", 0, "astruthers", "Dolor!", "Sit.", "Amet...", NULL, NULL,
    NULL, NULL, NULL, NULL, NULL, 4, 9, 6, 0, 0, 0, 0, 0, 0, 0),

(4, "Should Ben MacDonald be the actual Head Boy of Balwearie HS", 1, NULL,
    "Yes - 100%", "No - absolutly not, he's an idiot", "I prefer Adam Blyth",
    "I prefer Max Schroeder Smith over them all :)", NULL, NULL, NULL, NULL,
    NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
