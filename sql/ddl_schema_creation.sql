-- create the database if it doesn't exist
create database if not exists cdkey_db;

-- use the database
use cdkey_db;

-- drop tables if they exist (to avoid duplication errors)
drop table if exists transactions;
drop table if exists inventory_management;
drop table if exists cd_keys;
drop table if exists promotions;
drop table if exists games;
drop table if exists users;

-- create the tables
create table games (
    game_id int primary key,
    game_title varchar(255) not null,
    game_platform varchar(255) not null,
    cover_art varchar(255) not null,
    genre varchar(255)
);

create table promotions (
    promotion_id int primary key,
    game_id int,
    discount_percent decimal(5, 2),
    start_date date,
    end_date date,
    foreign key (game_id) references games(game_id)
);

create table users (
    user_id int primary key,
    username varchar(255) not null unique,
    email varchar(255) not null unique,
    password varchar(255) not null,
    user_type enum('buyer', 'seller') not null
);

create table cd_keys (
    key_id int primary key,
    cd_key varchar(255) not null unique,
    game_id int not null,
    seller_id int,
    status varchar(50),
    foreign key (game_id) references games(game_id),
    foreign key (seller_id) references users(user_id)
);

create table inventory_management (
    inventory_id int primary key,
    key_id int not null,
    user_id int not null,
    stock_amount int,
    foreign key (key_id) references cd_keys(key_id),
    foreign key (user_id) references users(user_id)
);

create table transactions (
    transaction_id int primary key,
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

-- insert data into games
insert into games (game_id, game_title, game_platform, cover_art, genre) 
values 
(1, 'cyberpunk 2077', 'pc', 'cyberpunk2077.jpg', 'rpg'),
(2, 'the witcher 3', 'pc', 'witcher3.jpg', 'action rpg'),
(3, 'minecraft', 'xbox', 'minecraft.jpg', 'sandbox'),
(4, 'fortnite', 'ps5', 'fortnite.jpg', 'battle royale');

-- insert data into promotions
insert into promotions (promotion_id, game_id, discount_percent, start_date, end_date) 
values 
(1, 1, 20.00, '2024-12-01', '2024-12-15'),
(2, 2, 15.00, '2024-12-10', '2024-12-25'),
(3, 4, 10.00, '2024-12-20', '2024-12-31');

-- insert data into users
insert into users (user_id, username, email, password, user_type) 
values 
(1, 'john_doe', 'john@example.com', 'password123', 'seller'),
(2, 'jane_doe', 'jane@example.com', 'securepassword', 'buyer'),
(3, 'admin_user', 'admin@example.com', 'adminpassword', 'seller');

-- insert data into cd_keys
insert into cd_keys (key_id, cd_key, game_id, seller_id, status) 
values 
(1, 'abcd1234', 1, 1, 'available'),
(2, 'efgh5678', 2, 1, 'sold'),
(3, 'ijkl9101', 3, 1, 'available'),
(4, 'mnop1121', 4, 3, 'available');

-- insert data into inventory_management
insert into inventory_management (inventory_id, key_id, user_id, stock_amount) 
values 
(1, 1, 1, 10),
(2, 3, 1, 5),
(3, 4, 3, 20);

-- insert data into transactions
insert into transactions (transaction_id, buyer_id, seller_id, cdkey_id, game_id, price, transaction_date) 
values 
(1, 2, 1, 2, 2, 39.99, '2024-12-01 14:30:00'),
(2, 2, 3, 4, 4, 19.99, '2024-12-03 10:00:00');