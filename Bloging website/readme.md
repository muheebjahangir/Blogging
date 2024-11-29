# Blogging Database Setup

This section explains how to create a simple database and table for your blog application.

## SQL Code for Database Setup

```sql
/// Creating Database

CREATE DATABASE blog;
USE blog;

-- Creating Table

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255),
    email VARCHAR(255),
    pass INT,
    token INT,
    token_expiry DATETIME
);
