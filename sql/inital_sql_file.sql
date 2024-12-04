use cdkey_db;

DROP TABLE users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
);

INSERT INTO users (username, password) VALUES ('user', 'password');

ALTER TABLE users ADD COLUMN role ENUM('buyer', 'seller') NOT NULL;

select * from users;
select * from games;

CREATE TABLE games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    cover_art VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    cd_key TEXT NOT NULL
);
