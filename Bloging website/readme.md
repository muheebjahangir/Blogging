/// Creating Database

CREATE DATABASE blog;
USE blog;

// Creating Table

CREATE TABLE users(
id int AUTO_INCREMENT PRIMARY KEY,
username varchar(255),
email varchar(255),
pass int,
token int,
token_expiry datetime
);

"# Blogging" 
