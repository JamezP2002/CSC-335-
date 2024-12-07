-- Disable foreign key checks to allow dropping tables with dependencies
SET FOREIGN_KEY_CHECKS = 0;

-- Drop tables if they exist
drop table if exists transactions;
drop table if exists cd_keys;
drop table if exists promotions;
drop table if exists games;
drop table if exists users;
drop table if exists cart;

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- Create the tables
create table games (
    game_id int auto_increment primary key,
    game_title varchar(255) not null,
    game_platform varchar(255) not null,
    cover_art varchar(255) not null,
    genre varchar(255)
);

create table promotions (
    promotion_id int auto_increment primary key,
    game_id int,
    discount_percent decimal(5, 2),
    start_date date,
    end_date date,
    foreign key (game_id) references games(game_id)
);

create table users (
    user_id int auto_increment primary key,
    username varchar(255) not null unique,
    email varchar(255) not null unique,
    password varchar(255) not null,
    user_type enum('buyer', 'seller') not null
);

CREATE TABLE cd_keys (
    key_id INT AUTO_INCREMENT PRIMARY KEY,
    cd_key VARCHAR(255) NOT NULL UNIQUE, -- Each key is unique
    game_id INT NOT NULL,
    seller_id INT,
    buyer_id INT DEFAULT NULL, -- Tracks the user who purchased the key
    price DECIMAL(10, 2) NOT NULL,
    status ENUM('available', 'sold') DEFAULT 'available', -- Tracks availability
    FOREIGN KEY (game_id) REFERENCES games(game_id),
    FOREIGN KEY (seller_id) REFERENCES users(user_id),
    FOREIGN KEY (buyer_id) REFERENCES users(user_id) -- Tracks the buyer
);

create table transactions (
    transaction_id int auto_increment primary key,
    buyer_id int not null,
    seller_id int not null,
    cdkey_id int not null,
    game_id int not null,
    price decimal(10, 2),
    transaction_date datetime,
    foreign key (buyer_id) references users(user_id),
    foreign key (seller_id) references users(user_id),
    foreign key (cdkey_id) references cd_keys(key_id),
    foreign key (game_id) references games(game_id)
);

create table cart (
    cart_id int auto_increment primary key,
    user_id int not null,
    cdkey_id int not null,
    quantity int default 1,
    added_at datetime default current_timestamp,
    foreign key (user_id) references users(user_id),
    foreign key (cdkey_id) references cd_keys(key_id)
);

-- Insert data into games
insert into games (game_title, game_platform, cover_art, genre) 
values 
('Baltro', 'pc', 'baltro.jpg', 'rpg'),
('Days Gone', 'pc', 'days_gone.jpg', 'action rpg'),
('Farming Simulator', 'xbox', 'farming.jpg', 'sandbox'),
('Grand Theft Auto 5', 'ps5', 'gta5.jpg', 'battle royale');

-- Insert data into promotions
insert into promotions (game_id, discount_percent, start_date, end_date) 
values 
(1, 20.00, '2024-12-01', '2024-12-15'),
(2, 15.00, '2024-12-10', '2024-12-25'),
(4, 10.00, '2024-12-20', '2024-12-31');

-- Insert data into users
insert into users (username, email, password, user_type) 
values 
('john_doe', 'john@example.com', 'password123', 'seller'),
('jane_doe', 'jane@example.com', 'securepassword', 'buyer'),
('admin_user', 'admin@example.com', 'adminpassword', 'seller');

-- Insert data into cd_keys
insert into cd_keys (cd_key, game_id, seller_id, price, status) 
values 
('abcd1234', 1, 1, 49.99, 'available'),
('efgh5678', 2, 1, 39.99, 'sold'),
('ijkl9101', 3, 1, 29.99, 'available'),
('mnop1121', 4, 3, 19.99, 'available');

-- Insert data into transactions
insert into transactions (buyer_id, seller_id, cdkey_id, game_id, price, transaction_date) 
values 
(2, 1, 2, 2, 39.99, '2024-12-01 14:30:00'),
(2, 3, 4, 4, 19.99, '2024-12-03 10:00:00');
