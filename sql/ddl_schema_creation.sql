-- Create the database if it doesn't exist
CREATE DATABASE IF NOT EXISTS cdkey_db;

-- Use the database
USE cdkey_db;

-- Drop tables if they exist (to avoid duplication errors)
DROP TABLE IF EXISTS Transactions;
DROP TABLE IF EXISTS Inventory_Management;
DROP TABLE IF EXISTS CD_Keys;
DROP TABLE IF EXISTS Promotions;
DROP TABLE IF EXISTS Games;
DROP TABLE IF EXISTS Users;

-- Create the tables
CREATE TABLE Games (
    Game_ID INT PRIMARY KEY,
    Game_Title VARCHAR(255) NOT NULL,
    Game_Platform VARCHAR(255) NOT NULL,
    Cover_art VARCHAR(255) NOT NULL,
    Genre VARCHAR(255)
);

CREATE TABLE Promotions (
    Promotion_ID INT PRIMARY KEY,
    Game_ID INT,
    Discount_Percent DECIMAL(5, 2),
    Start_Date DATE,
    End_Date DATE,
    FOREIGN KEY (Game_ID) REFERENCES Games(Game_ID)
);

CREATE TABLE Users (
    User_ID INT PRIMARY KEY,
    Username VARCHAR(255) NOT NULL UNIQUE,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    User_Type ENUM('buyer', 'seller') NOT NULL
);

CREATE TABLE CD_Keys (
    Key_ID INT PRIMARY KEY,
    CD_Key VARCHAR(255) NOT NULL UNIQUE,
    Game_ID INT NOT NULL,
    Seller_ID INT,
    Status VARCHAR(50),
    FOREIGN KEY (Game_ID) REFERENCES Games(Game_ID),
    FOREIGN KEY (Seller_ID) REFERENCES Users(User_ID)
);

CREATE TABLE Inventory_Management (
    Inventory_ID INT PRIMARY KEY,
    Key_ID INT NOT NULL,
    User_ID INT NOT NULL,
    Stock_Amount INT,
    FOREIGN KEY (Key_ID) REFERENCES CD_Keys(Key_ID),
    FOREIGN KEY (User_ID) REFERENCES Users(User_ID)
);

CREATE TABLE Transactions (
    Transaction_ID INT PRIMARY KEY,
    Buyer_ID INT NOT NULL,
    Seller_ID INT NOT NULL,
    CDKey_ID INT NOT NULL,
    Game_ID INT NOT NULL,
    Price DECIMAL(10, 2),
    Transaction_Date DATETIME,
    FOREIGN KEY (Buyer_ID) REFERENCES Users(User_ID),
    FOREIGN KEY (Seller_ID) REFERENCES Users(User_ID),
    FOREIGN KEY (CDKey_ID) REFERENCES CD_Keys(Key_ID),
    FOREIGN KEY (Game_ID) REFERENCES Games(Game_ID)
);