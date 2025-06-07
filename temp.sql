-- First drop existing tables in correct order
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS developer_game;
DROP TABLE IF EXISTS game_platform;
DROP TABLE IF EXISTS game_genre;
DROP TABLE IF EXISTS games;
DROP TABLE IF EXISTS publishers;
DROP TABLE IF EXISTS developers;
DROP TABLE IF EXISTS platforms;
DROP TABLE IF EXISTS genres;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS sessions;

-- Create tables in correct order
CREATE TABLE users (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE publishers (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    founded_year INT,
    headquarters VARCHAR(255),
    website_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE developers (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    founded_year INT,
    headquarters VARCHAR(255),
    website_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE platforms (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    manufacturer VARCHAR(255),
    release_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE genres (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE games (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    release_date DATE,
    publisher_id BIGINT,
    rating DECIMAL(3,1),
    price DECIMAL(10,2),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (publisher_id) REFERENCES publishers(id) ON DELETE SET NULL
);

CREATE TABLE developer_game (
    developer_id BIGINT,
    game_id BIGINT,
    role VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (developer_id, game_id),
    FOREIGN KEY (developer_id) REFERENCES developers(id) ON DELETE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE
);

CREATE TABLE game_platform (
    game_id BIGINT,
    platform_id BIGINT,
    release_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (game_id, platform_id),
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE,
    FOREIGN KEY (platform_id) REFERENCES platforms(id) ON DELETE CASCADE
);

CREATE TABLE game_genre (
    game_id BIGINT,
    genre_id BIGINT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (game_id, genre_id),
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE,
    FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE CASCADE
);

CREATE TABLE reviews (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT,
    game_id BIGINT,
    rating DECIMAL(3,1) NOT NULL,
    title VARCHAR(255),
    content TEXT,
    is_recommended BOOLEAN,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE
);

-- Add sessions table
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload TEXT NOT NULL,
    last_activity INT NOT NULL
);

-- Sample Data Insertions

-- Users
INSERT INTO users (name, email, password) VALUES
('John Doe', 'john@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Jane Smith', 'jane@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('Mike Johnson', 'mike@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Publishers
INSERT INTO publishers (name, slug, description, founded_year, headquarters, website_url) VALUES
('Electronic Arts', 'electronic-arts', 'Leading gaming company', 1982, 'Redwood City, CA', 'https://www.ea.com'),
('Ubisoft', 'ubisoft', 'French video game company', 1986, 'Montreuil, France', 'https://www.ubisoft.com'),
('Nintendo', 'nintendo', 'Japanese gaming giant', 1889, 'Kyoto, Japan', 'https://www.nintendo.com');

-- Developers
INSERT INTO developers (name, slug, description, founded_year, headquarters, website_url) VALUES
('DICE', 'dice', 'Battlefield series developer', 1992, 'Stockholm, Sweden', 'https://www.dice.se'),
('Ubisoft Montreal', 'ubisoft-montreal', 'Leading Ubisoft studio', 1997, 'Montreal, Canada', 'https://montreal.ubisoft.com'),
('Nintendo EPD', 'nintendo-epd', 'Nintendo''s main development division', 2015, 'Kyoto, Japan', 'https://www.nintendo.com');

-- Platforms
INSERT INTO platforms (name, slug, manufacturer, release_date) VALUES
('PlayStation 5', 'ps5', 'Sony', '2020-11-12'),
('Xbox Series X', 'xbox-series-x', 'Microsoft', '2020-11-10'),
('Nintendo Switch', 'nintendo-switch', 'Nintendo', '2017-03-03');

-- Genres
INSERT INTO genres (name, slug, description) VALUES
('Action', 'action', 'Fast-paced gaming experiences'),
('RPG', 'rpg', 'Role-playing games with character development'),
('Sports', 'sports', 'Competitive sports simulations');

-- Games
INSERT INTO games (title, slug, description, release_date, publisher_id, rating, price, is_active) VALUES
('Battlefield 2042', 'battlefield-2042', 'Next-gen multiplayer shooter', '2021-11-19', 1, 7.5, 59.99, true),
('Assassin''s Creed Valhalla', 'assassins-creed-valhalla', 'Viking-era action RPG', '2020-11-10', 2, 8.0, 59.99, true),
('The Legend of Zelda: BOTW', 'zelda-breath-of-the-wild', 'Open-world adventure', '2017-03-03', 3, 9.5, 59.99, true);

-- Developer-Game Relationships
INSERT INTO developer_game (developer_id, game_id, role) VALUES
(1, 1, 'Lead Developer'),
(2, 2, 'Lead Developer'),
(3, 3, 'Lead Developer');

-- Game-Platform Relationships
INSERT INTO game_platform (game_id, platform_id, release_date) VALUES
(1, 1, '2021-11-19'),
(1, 2, '2021-11-19'),
(2, 1, '2020-11-10'),
(2, 2, '2020-11-10'),
(3, 3, '2017-03-03');

-- Game-Genre Relationships
INSERT INTO game_genre (game_id, genre_id) VALUES
(1, 1),  -- Battlefield 2042 - Action
(2, 1),  -- AC Valhalla - Action
(2, 2),  -- AC Valhalla - RPG
(3, 1),  -- Zelda BOTW - Action
(3, 2);  -- Zelda BOTW - RPG

-- Reviews
INSERT INTO reviews (user_id, game_id, rating, title, content, is_recommended) VALUES
(1, 1, 7.5, 'Good but needs work', 'Impressive graphics but has some bugs', true),
(2, 2, 8.0, 'Amazing Viking saga', 'Great story and beautiful world', true),
(3, 3, 9.5, 'Masterpiece', 'One of the best games ever made', true),
(1, 2, 8.5, 'Great RPG experience', 'Loved the character progression', true),
(2, 3, 9.0, 'Revolutionary', 'Changed how I think about open-world games', true);


SELECT * FROM developer_game;
SELECT * FROM game_platform;
SELECT * FROM game_genre;
SELECT * FROM games;
SELECT * FROM reviews;
SELECT * FROM users;
SELECT * FROM publishers;
SELECT * FROM developers;
SELECT * FROM platforms;
SELECT * FROM genres;
SELECT * FROM sessions;
