use cdkey_db;

DELETE TABLE users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
);

INSERT INTO users (username, password) VALUES ('user', 'password');

ALTER TABLE users ADD COLUMN role ENUM('buyer', 'seller') NOT NULL;

select * from users;