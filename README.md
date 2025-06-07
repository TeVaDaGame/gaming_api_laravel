# Gaming API Documentation

A RESTful API for managing video games, developers, publishers, and reviews built with Laravel.

## Table of Contents
- [Setup](#setup)
- [Authentication](#authentication)
- [API Endpoints](#api-endpoints)
  - [Games](#games)
  - [Developers](#developers)
  - [Publishers](#publishers)
  - [Genres](#genres)
  - [Platforms](#platforms)
  - [Reviews](#reviews)
- [Thunder Client Testing](#thunder-client-testing)
- [Database Schema](#database-schema)
- [License](#license)

## Setup

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure database
4. Run migrations and seed data:
```bash
php artisan migrate
php artisan db:seed
```

## API Endpoints

All API endpoints are prefixed with `/api`.

### Games

#### List all games
```http
GET /api/games

Response:
{
    "data": [
        {
            "id": 1,
            "title": "Battlefield 2042",
            "slug": "battlefield-2042",
            "description": "Next-gen multiplayer shooter",
            "release_date": "2021-11-19",
            "publisher_id": 1,
            "rating": 7.5,
            "price": 59.99,
            "is_active": true,
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z",
            "publisher": {
                "id": 1,
                "name": "Electronic Arts"
            },
            "developers": [
                {
                    "id": 1,
                    "name": "DICE",
                    "role": "Lead Developer"
                }
            ]
        }
    ]
}
```

#### Create a game
```http
POST /api/games
Content-Type: application/json

Request:
{
    "title": "New Game",
    "slug": "new-game",
    "description": "Game description",
    "release_date": "2024-01-15",
    "publisher_id": 1,
    "rating": 8.5,
    "price": 59.99,
    "is_active": true,
    "developer_ids": [1, 2]
}

Response:
{
    "message": "Game created",
    "game": {
        "id": 4,
        "title": "New Game",
        "slug": "new-game",
        "description": "Game description",
        "release_date": "2024-01-15",
        "publisher_id": 1,
        "rating": 8.5,
        "price": 59.99,
        "is_active": true,
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### Search games
```http
GET /api/games/search?q=battlefield

Response:
{
    "data": [
        {
            "id": 1,
            "title": "Battlefield 2042",
            "slug": "battlefield-2042",
            "description": "Next-gen multiplayer shooter",
            "release_date": "2021-11-19",
            "publisher_id": 1,
            "rating": 7.5,
            "price": 59.99,
            "is_active": true,
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ]
}
```

#### Get popular games
```http
GET /api/games/popular

Response:
{
    "data": [
        {
            "id": 3,
            "title": "The Legend of Zelda: BOTW",
            "rating": 9.5,
            "review_count": 2,
            "average_rating": 9.25
        }
    ]
}
```

#### Get latest games
```http
GET /api/games/latest

Response:
{
    "data": [
        {
            "id": 1,
            "title": "Battlefield 2042",
            "release_date": "2021-11-19",
            "rating": 7.5
        }
    ]
}
```

#### Get game details
```http
GET /api/games/{id}

Response:
{
    "data": {
        "id": 1,
        "title": "Battlefield 2042",
        "slug": "battlefield-2042",
        "description": "Next-gen multiplayer shooter",
        "release_date": "2021-11-19",
        "publisher_id": 1,
        "rating": 7.5,
        "price": 59.99,
        "is_active": true,
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z",
        "publisher": {
            "id": 1,
            "name": "Electronic Arts"
        },
        "developers": [
            {
                "id": 1,
                "name": "DICE",
                "role": "Lead Developer"
            }
        ],
        "platforms": [
            {
                "id": 1,
                "name": "PlayStation 5",
                "release_date": "2021-11-19"
            }
        ],
        "genres": [
            {
                "id": 1,
                "name": "Action"
            }
        ]
    }
}
```

#### Update game
```http
PUT /api/games/{id}
Content-Type: application/json

Request:
{
    "title": "Updated Game",
    "slug": "updated-game",
    "description": "Updated description",
    "rating": 9.0,
    "price": 49.99,
    "is_active": true,
    "developer_ids": [1, 3]
}

Response:
{
    "message": "Game updated",
    "game": {
        "id": 1,
        "title": "Updated Game",
        "slug": "updated-game",
        "description": "Updated description",
        "rating": 9.0,
        "price": 49.99,
        "is_active": true,
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### Delete game
```http
DELETE /api/games/{id}

Response:
{
    "message": "Game deleted"
}
```

#### Get game developers
```http
GET /api/games/{id}/developers

Response:
{
    "data": [
        {
            "id": 1,
            "name": "DICE",
            "slug": "dice",
            "description": "Battlefield series developer",
            "founded_year": 1992,
            "headquarters": "Stockholm, Sweden",
            "website_url": "https://www.dice.se",
            "pivot": {
                "role": "Lead Developer"
            }
        }
    ]
}
```

#### Get game reviews
```http
GET /api/games/{id}/reviews

Response:
{
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "rating": 7.5,
            "title": "Good but needs work",
            "content": "Impressive graphics but has some bugs",
            "is_recommended": true,
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ]
}
```

#### Rate a game
```http
POST /api/games/{id}/rate
Content-Type: application/json

Request:
{
    "rating": 4.5,
    "title": "Great game!",
    "content": "Enjoyed playing this a lot",
    "is_recommended": true
}

Response:
{
    "message": "Review added successfully",
    "review": {
        "id": 6,
        "user_id": 1,
        "game_id": 1,
        "rating": 4.5,
        "title": "Great game!",
        "content": "Enjoyed playing this a lot",
        "is_recommended": true,
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

### Developers

#### List all developers
```http
GET /api/developers

Response:
{
    "data": [
        {
            "id": 1,
            "name": "DICE",
            "slug": "dice",
            "description": "Battlefield series developer",
            "founded_year": 1992,
            "headquarters": "Stockholm, Sweden",
            "website_url": "https://www.dice.se",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ]
}
```

#### Create developer
```http
POST /api/developers
Content-Type: application/json

Request:
{
    "name": "New Studio",
    "slug": "new-studio",
    "description": "Game development studio",
    "founded_year": 2020,
    "headquarters": "San Francisco, CA",
    "website_url": "https://example.com"
}

Response:
{
    "message": "Developer created",
    "developer": {
        "id": 4,
        "name": "New Studio",
        "slug": "new-studio",
        "description": "Game development studio",
        "founded_year": 2020,
        "headquarters": "San Francisco, CA",
        "website_url": "https://example.com",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### Search developers
```http
GET /api/developers/search?q=dice

Response:
{
    "data": [
        {
            "id": 1,
            "name": "DICE",
            "slug": "dice",
            "description": "Battlefield series developer",
            "founded_year": 1992,
            "headquarters": "Stockholm, Sweden",
            "website_url": "https://www.dice.se"
        }
    ]
}
```

#### Get developer details
```http
GET /api/developers/{id}

Response:
{
    "data": {
        "id": 1,
        "name": "DICE",
        "slug": "dice",
        "description": "Battlefield series developer",
        "founded_year": 1992,
        "headquarters": "Stockholm, Sweden",
        "website_url": "https://www.dice.se",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### Update developer
```http
PUT /api/developers/{id}
Content-Type: application/json

Request:
{
    "name": "Updated Studio",
    "description": "Updated description",
    "website_url": "https://newexample.com"
}

Response:
{
    "message": "Developer updated",
    "developer": {
        "id": 1,
        "name": "Updated Studio",
        "description": "Updated description",
        "website_url": "https://newexample.com",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### Delete developer
```http
DELETE /api/developers/{id}

Response:
{
    "message": "Developer deleted"
}
```

#### Get developer games
```http
GET /api/developers/{id}/games

Response:
{
    "data": [
        {
            "id": 1,
            "title": "Battlefield 2042",
            "slug": "battlefield-2042",
            "description": "Next-gen multiplayer shooter",
            "release_date": "2021-11-19",
            "rating": 7.5,
            "price": 59.99,
            "is_active": true,
            "pivot": {
                "role": "Lead Developer"
            }
        }
    ]
}
```

### Publishers

#### List all publishers
```http
GET /api/publishers

Response:
{
    "data": [
        {
            "id": 1,
            "name": "Electronic Arts",
            "slug": "electronic-arts",
            "description": "Leading gaming company",
            "founded_year": 1982,
            "headquarters": "Redwood City, CA",
            "website_url": "https://www.ea.com",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ]
}
```

#### Create publisher
```http
POST /api/publishers
Content-Type: application/json

Request:
{
    "name": "New Publisher",
    "slug": "new-publisher",
    "description": "Game publisher",
    "founded_year": 1990,
    "headquarters": "Tokyo, Japan",
    "website_url": "https://example.com"
}

Response:
{
    "message": "Publisher created",
    "publisher": {
        "id": 4,
        "name": "New Publisher",
        "slug": "new-publisher",
        "description": "Game publisher",
        "founded_year": 1990,
        "headquarters": "Tokyo, Japan",
        "website_url": "https://example.com",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### Search publishers
```http
GET /api/publishers/search?q=nintendo

Response:
{
    "data": [
        {
            "id": 3,
            "name": "Nintendo",
            "slug": "nintendo",
            "description": "Japanese gaming giant",
            "founded_year": 1889,
            "headquarters": "Kyoto, Japan",
            "website_url": "https://www.nintendo.com"
        }
    ]
}
```

#### Get publisher details
```http
GET /api/publishers/{id}

Response:
{
    "data": {
        "id": 1,
        "name": "Electronic Arts",
        "slug": "electronic-arts",
        "description": "Leading gaming company",
        "founded_year": 1982,
        "headquarters": "Redwood City, CA",
        "website_url": "https://www.ea.com",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### Update publisher
```http
PUT /api/publishers/{id}
Content-Type: application/json

Request:
{
    "name": "Updated Publisher",
    "description": "Updated description",
    "website_url": "https://newexample.com"
}

Response:
{
    "message": "Publisher updated",
    "publisher": {
        "id": 1,
        "name": "Updated Publisher",
        "description": "Updated description",
        "website_url": "https://newexample.com",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### Delete publisher
```http
DELETE /api/publishers/{id}

Response:
{
    "message": "Publisher deleted"
}
```

#### Get publisher games
```http
GET /api/publishers/{id}/games

Response:
{
    "data": [
        {
            "id": 1,
            "title": "Battlefield 2042",
            "slug": "battlefield-2042",
            "description": "Next-gen multiplayer shooter",
            "release_date": "2021-11-19",
            "rating": 7.5,
            "price": 59.99,
            "is_active": true
        }
    ]
}
```

### Genres

#### List all genres
```http
GET /api/genres

Response:
{
    "data": [
        {
            "id": 1,
            "name": "Action",
            "slug": "action",
            "description": "Fast-paced gaming experiences",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ]
}
```

#### Create genre
```http
POST /api/genres
Content-Type: application/json

Request:
{
    "name": "Strategy",
    "slug": "strategy",
    "description": "Games that emphasize strategic planning"
}

Response:
{
    "message": "Genre created",
    "genre": {
        "id": 4,
        "name": "Strategy",
        "slug": "strategy",
        "description": "Games that emphasize strategic planning",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### Get genre details
```http
GET /api/genres/{id}

Response:
{
    "data": {
        "id": 1,
        "name": "Action",
        "slug": "action",
        "description": "Fast-paced gaming experiences",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### Update genre
```http
PUT /api/genres/{id}
Content-Type: application/json

Request:
{
    "name": "Action Adventure",
    "description": "Updated description"
}

Response:
{
    "message": "Genre updated",
    "genre": {
        "id": 1,
        "name": "Action Adventure",
        "description": "Updated description",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### Delete genre
```http
DELETE /api/genres/{id}

Response:
{
    "message": "Genre deleted"
}
```

#### Get games in genre
```http
GET /api/genres/{id}/games

Response:
{
    "data": [
        {
            "id": 1,
            "title": "Battlefield 2042",
            "slug": "battlefield-2042",
            "description": "Next-gen multiplayer shooter",
            "release_date": "2021-11-19",
            "rating": 7.5,
            "price": 59.99,
            "is_active": true
        }
    ]
}
```

### Platforms

#### List all platforms
```http
GET /api/platforms

Response:
{
    "data": [
        {
            "id": 1,
            "name": "PlayStation 5",
            "slug": "ps5",
            "manufacturer": "Sony",
            "release_date": "2020-11-12",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z"
        }
    ]
}
```

#### Create platform
```http
POST /api/platforms
Content-Type: application/json

Request:
{
    "name": "Nintendo Switch 2",
    "slug": "switch-2",
    "manufacturer": "Nintendo",
    "release_date": "2024-09-01"
}

Response:
{
    "message": "Platform created",
    "platform": {
        "id": 4,
        "name": "Nintendo Switch 2",
        "slug": "switch-2",
        "manufacturer": "Nintendo",
        "release_date": "2024-09-01",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### Get platform details
```http
GET /api/platforms/{id}

Response:
{
    "data": {
        "id": 1,
        "name": "PlayStation 5",
        "slug": "ps5",
        "manufacturer": "Sony",
        "release_date": "2020-11-12",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### Update platform
```http
PUT /api/platforms/{id}
Content-Type: application/json

Request:
{
    "name": "PS5 Pro",
    "manufacturer": "Sony",
    "release_date": "2024-11-12"
}

Response:
{
    "message": "Platform updated",
    "platform": {
        "id": 1,
        "name": "PS5 Pro",
        "manufacturer": "Sony",
        "release_date": "2024-11-12",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### Delete platform
```http
DELETE /api/platforms/{id}

Response:
{
    "message": "Platform deleted"
}
```

#### Get platform games
```http
GET /api/platforms/{id}/games

Response:
{
    "data": [
        {
            "id": 1,
            "title": "Battlefield 2042",
            "slug": "battlefield-2042",
            "description": "Next-gen multiplayer shooter",
            "rating": 7.5,
            "price": 59.99,
            "is_active": true,
            "pivot": {
                "release_date": "2021-11-19"
            }
        }
    ]
}
```

### Reviews

#### List all reviews
```http
GET /api/reviews

Response:
{
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "game_id": 1,
            "rating": 7.5,
            "title": "Good but needs work",
            "content": "Impressive graphics but has some bugs",
            "is_recommended": true,
            "created_at": "2024-01-01T00:00:00.000000Z",
            "updated_at": "2024-01-01T00:00:00.000000Z",
            "user": {
                "id": 1,
                "name": "John Doe"
            },
            "game": {
                "id": 1,
                "title": "Battlefield 2042"
            }
        }
    ]
}
```

#### Create review
```http
POST /api/reviews
Content-Type: application/json

Request:
{
    "game_id": 1,
    "rating": 8.5,
    "title": "Fantastic game",
    "content": "One of the best games I've played this year",
    "is_recommended": true
}

Response:
{
    "message": "Review created",
    "review": {
        "id": 6,
        "user_id": 1,
        "game_id": 1,
        "rating": 8.5,
        "title": "Fantastic game",
        "content": "One of the best games I've played this year",
        "is_recommended": true,
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### Get review details
```http
GET /api/reviews/{id}

Response:
{
    "data": {
        "id": 1,
        "user_id": 1,
        "game_id": 1,
        "rating": 7.5,
        "title": "Good but needs work",
        "content": "Impressive graphics but has some bugs",
        "is_recommended": true,
        "created_at": "2024-01-01T00:00:00.000000Z",
        "updated_at": "2024-01-01T00:00:00.000000Z",
        "user": {
            "id": 1,
            "name": "John Doe"
        },
        "game": {
            "id": 1,
            "title": "Battlefield 2042"
        }
    }
}
```

#### Update review
```http
PUT /api/reviews/{id}
Content-Type: application/json

Request:
{
    "rating": 8.0,
    "title": "Updated review",
    "content": "Updated content after patches",
    "is_recommended": true
}

Response:
{
    "message": "Review updated",
    "review": {
        "id": 1,
        "rating": 8.0,
        "title": "Updated review",
        "content": "Updated content after patches",
        "is_recommended": true,
        "updated_at": "2024-01-01T00:00:00.000000Z"
    }
}
```

#### Delete review
```http
DELETE /api/reviews/{id}

Response:
{
    "message": "Review deleted"
}
```

## Authentication

This API uses Laravel Sanctum for authentication. To access protected endpoints:

1. First, obtain a token:
```http
POST /api/auth/login
Content-Type: application/json

Request:
{
    "email": "user@example.com",
    "password": "password"
}

Response:
{
    "token": "1|abcdef123456..."
}
```

2. Include the token in subsequent requests:
```http
GET /api/protected-endpoint
Authorization: Bearer 1|abcdef123456...
```

Protected endpoints require authentication:
- Creating, updating, and deleting resources
- Posting reviews
- Rating games

## Database Schema

### Users
- id (bigint, primary key)
- name (string)
- email (string, unique)
- email_verified_at (timestamp, nullable)
- password (string)
- remember_token (string, nullable)
- created_at (timestamp)
- updated_at (timestamp)

### Publishers
- id (bigint, primary key)
- name (string)
- slug (string, unique)
- description (text, nullable)
- founded_year (integer, nullable)
- headquarters (string, nullable)
- website_url (string, nullable)
- created_at (timestamp)
- updated_at (timestamp)

### Developers
- id (bigint, primary key)
- name (string)
- slug (string, unique)
- description (text, nullable)
- founded_year (integer, nullable)
- headquarters (string, nullable)
- website_url (string, nullable)
- created_at (timestamp)
- updated_at (timestamp)

### Platforms
- id (bigint, primary key)
- name (string)
- slug (string, unique)
- manufacturer (string)
- release_date (date)
- created_at (timestamp)
- updated_at (timestamp)

### Genres
- id (bigint, primary key)
- name (string)
- slug (string, unique)
- description (text, nullable)
- created_at (timestamp)
- updated_at (timestamp)

### Games
- id (bigint, primary key)
- title (string)
- slug (string, unique)
- description (text, nullable)
- release_date (date)
- publisher_id (bigint, foreign key)
- rating (decimal)
- price (decimal)
- is_active (boolean)
- created_at (timestamp)
- updated_at (timestamp)

### Reviews
- id (bigint, primary key)
- user_id (bigint, foreign key)
- game_id (bigint, foreign key)
- rating (decimal)
- title (string)
- content (text)
- is_recommended (boolean)
- created_at (timestamp)
- updated_at (timestamp)

### Pivot Tables
- developer_game (developer_id, game_id, role)
- game_platform (game_id, platform_id, release_date)
- game_genre (game_id, genre_id)

## Thunder Client Testing

A Thunder Client collection is included in the repository. To use it:

1. Install Thunder Client extension in VS Code
2. Import the collection from `thunder-collection_Gaming API.json`
3. Update the base URL in environment variables if needed
4. Run the authentication request first to get a token
5. Other requests will automatically use the token

## License

This project is open-sourced software licensed under the MIT license.
