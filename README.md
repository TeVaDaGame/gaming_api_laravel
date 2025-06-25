# Gaming API

A comprehensive RESTful API built with Laravel for managing video game data including games, developers, publishers, genres, platforms, and user reviews. This API provides endpoints for CRUD operations, search functionality, and relationship management between gaming entities.

## Features

- **Game Management**: Create, read, update, and delete games with detailed information
- **Developer & Publisher Management**: Track game studios and publishing companies
- **Genre & Platform Support**: Organize games by categories and supported platforms
- **User Reviews & Ratings**: Allow users to rate and review games
- **User Favorites & Wishlist**: Save favorite games and create personal wishlists
- **Search Functionality**: Search across games, developers, and publishers
- **Popular & Latest Games**: Get trending and recently released games
- **Authentication**: Secure API access using Laravel Sanctum
- **Database Relationships**: Many-to-many relationships between games, developers, genres, and platforms
- **Web Dashboard**: User-friendly web interface for managing games and favorites

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
  - [Favorites](#favorites)
- [Web Interface](#web-interface)
- [Thunder Client Testing](#thunder-client-testing)
- [Database Schema](#database-schema)
- [License](#license)

## Project Setup

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL or PostgreSQL database
- Laravel 11.x

### Installation Steps

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd gaming_api
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Environment configuration**
   ```bash
   cp .env.example .env
   ```
   Update the `.env` file with your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=gaming_api
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Generate application key**
   ```bash
   php artisan key:generate
   ```

5. **Run database migrations and seeders**
   ```bash
   php artisan migrate
   php artisan db:seed
   ```

6. **Start the development server**
   ```bash
   php artisan serve
   ```

The API will be available at `http://localhost:8000`

## API Overview

The Gaming API provides a comprehensive set of endpoints for managing video game data. All API endpoints are prefixed with `/api` and return JSON responses.

### Base URL
```
http://localhost:8000/api
```

### Response Format
All successful responses follow this structure:
```json
{
    "data": [...],      // For list endpoints
    "message": "...",   // For action endpoints
    "meta": {...}       // Pagination info (when applicable)
}
```

### Error Handling
Error responses include appropriate HTTP status codes and error details:
```json
{
    "message": "Error description",
    "errors": {
        "field": ["Validation error message"]
    }
}
```

## API Endpoints

### Games

The Games endpoints allow you to manage video game data, including CRUD operations, search, and relationship management.

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

Manage game development studios and their information.

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

Manage game publishing companies and their portfolio.

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

Organize and categorize games by genre types.

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

Manage gaming platforms and console information.

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

Handle user reviews and ratings for games.

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

### Favorites

Manage user favorites and wishlist functionality.

#### List user's favorites
```http
GET /api/favorites?type=favorite
Authorization: Bearer {token}

Query Parameters:
- type: "favorite" or "wishlist" (default: "favorite")

Response:
{
    "success": true,
    "data": [
        {
            "id": 1,
            "user_id": 1,
            "game_id": 1,
            "type": "favorite",
            "notes": "Amazing game! Can't wait to play it again.",
            "created_at": "2024-01-01T00:00:00.000000Z",
            "game": {
                "id": 1,
                "title": "Battlefield 2042",
                "rating": 8.5,
                "publisher": {
                    "name": "Electronic Arts"
                },
                "genres": [
                    {"name": "Action"},
                    {"name": "Shooter"}
                ]
            }
        }
    ],
    "type": "favorite",
    "count": 1
}
```

#### Add game to favorites/wishlist
```http
POST /api/favorites
Authorization: Bearer {token}
Content-Type: application/json

Request:
{
    "game_id": 1,
    "type": "favorite",
    "notes": "One of my all-time favorites!"
}

Response:
{
    "success": true,
    "message": "'Battlefield 2042' added to favorite list",
    "data": {
        "id": 1,
        "user_id": 1,
        "game_id": 1,
        "type": "favorite",
        "notes": "One of my all-time favorites!",
        "created_at": "2024-01-01T00:00:00.000000Z",
        "game": {
            "id": 1,
            "title": "Battlefield 2042"
        }
    }
}
```

#### Remove game from favorites/wishlist
```http
DELETE /api/favorites/{game_id}?type=favorite
Authorization: Bearer {token}

Query Parameters:
- type: "favorite" or "wishlist" (default: "favorite")

Response:
{
    "success": true,
    "message": "'Battlefield 2042' removed from favorite list"
}
```

#### Update favorite notes
```http
PUT /api/favorites/{favorite_id}
Authorization: Bearer {token}
Content-Type: application/json

Request:
{
    "notes": "Updated notes about this game"
}

Response:
{
    "success": true,
    "message": "Notes updated successfully",
    "data": {
        "id": 1,
        "notes": "Updated notes about this game",
        "updated_at": "2024-01-01T00:00:00.000000Z",
        "game": {
            "id": 1,
            "title": "Battlefield 2042"
        }
    }
}
```

#### Get favorites statistics
```http
GET /api/favorites/stats
Authorization: Bearer {token}

Response:
{
    "success": true,
    "data": {
        "total_favorites": 5,
        "total_wishlist": 3,
        "total_combined": 8,
        "recent_additions": [
            {
                "id": 1,
                "type": "favorite",
                "created_at": "2024-01-01T00:00:00.000000Z",
                "game": {
                    "id": 1,
                    "title": "Battlefield 2042"
                }
            }
        ],
        "favorite_genres": {
            "Action": 3,
            "RPG": 2,
            "Strategy": 1
        }
    }
}
```

#### Check if game is favorited
```http
GET /api/favorites/check/{game_id}?type=favorite
Authorization: Bearer {token}

Query Parameters:
- type: "favorite" or "wishlist" (default: "favorite")

Response:
{
    "success": true,
    "is_favorited": true,
    "type": "favorite"
}
```

## Web Interface

The Gaming API includes a comprehensive web dashboard for managing games and user interactions through a browser interface.

### Dashboard Features

- **User Authentication**: Login/register system with secure session management
- **Game Management**: Create, edit, and delete games through a user-friendly interface
- **Search & Browse**: Advanced search with filters for genre, publisher, rating, and price
- **Favorites & Wishlist**: Save favorite games and create personal wishlists
- **Review System**: Write and manage game reviews with ratings
- **Responsive Design**: Mobile-friendly interface using Bootstrap 5
- **Real-time Stats**: Dashboard showing user statistics and recent activity

### Key Pages

#### Dashboard (`/dashboard`)
- Overview of gaming statistics
- Quick access to favorites, wishlist, and reviews
- Recent activity feed
- User-specific statistics

#### Search Games (`/games/search`)
- Advanced search with multiple filters
- Grid/list view toggle
- Add to favorites/wishlist directly from search results
- Pagination and sorting options

#### Favorites Management (`/favorites`)
- View favorites and wishlist in separate tabs
- Edit personal notes for each game
- Remove games from lists
- Grid/list view options

#### Game Details (`/games/{game}`)
- Detailed game information
- Add to favorites/wishlist
- View and write reviews
- Related games suggestions

### Authentication Routes

- `GET /login` - Login form
- `POST /login` - Process login
- `GET /register` - Registration form
- `POST /register` - Process registration
- `POST /logout` - Logout user

### Protected Routes (require authentication)

- `GET /dashboard` - User dashboard
- `GET /favorites` - Manage favorites and wishlist
- `GET /games/search` - Search games
- `GET /reviews` - Manage reviews
- `GET /profile` - User profile management
- `GET /settings` - User settings

### Admin-Only Routes (require admin role)

- `GET /games/manage` - Game management dashboard
- `GET /games/create` - Create new games
- `GET /games/{game}/edit` - Edit existing games
- `GET /admin/dashboard` - Admin dashboard
- `GET /admin/users` - User management

### Access Control

The Gaming API implements role-based access control with two user types:

#### **Regular Users** can:
- Browse and search games
- View detailed game information
- Add games to favorites and wishlist
- Write and manage their own reviews
- Rate games
- Manage their profile and settings

#### **Admin Users** can:
- Everything regular users can do, PLUS:
- Create, edit, and delete games
- Manage developers, publishers, genres, and platforms
- Access admin dashboard with system statistics
- Manage user accounts and roles
- Bulk operations on games

## Authentication & Security

This Gaming API uses **Laravel Sanctum** for secure API authentication. Authentication is required for creating, updating, deleting resources, and posting reviews.

### Getting Started with Authentication

#### 1. User Registration
```http
POST /api/auth/register
Content-Type: application/json

Request:
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}

Response:
{
    "message": "User registered successfully",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    },
    "token": "1|abcdef123456..."
}
```

#### 2. User Login
```http
POST /api/auth/login
Content-Type: application/json

Request:
{
    "email": "john@example.com",
    "password": "password123"
}

Response:
{
    "message": "Login successful",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    },
    "token": "1|abcdef123456..."
}
```

#### 3. Using Authentication Tokens

Include the token in the Authorization header for protected endpoints:
```http
GET /api/games
Authorization: Bearer 1|abcdef123456...
```

#### 4. User Logout
```http
POST /api/auth/logout
Authorization: Bearer 1|abcdef123456...

Response:
{
    "message": "Logged out successfully"
}
```

### Protected Endpoints
The following operations require authentication:
- Creating, updating, and deleting games, developers, publishers, genres, and platforms
- Posting and managing reviews
- Rating games
- Accessing user-specific data

## Database Schema

The Gaming API uses a relational database structure with the following main entities and their relationships:

### Core Tables

#### Users Table
- id (bigint, primary key)
- name (string)
- email (string, unique)
- email_verified_at (timestamp, nullable)
- password (string)
- remember_token (string, nullable)
- created_at (timestamp)
- updated_at (timestamp)

#### Publishers Table
- id (bigint, primary key)
- name (string)
- slug (string, unique)
- description (text, nullable)
- founded_year (integer, nullable)
- headquarters (string, nullable)
- website_url (string, nullable)
- created_at (timestamp)
- updated_at (timestamp)

#### Developers Table
- id (bigint, primary key)
- name (string)
- slug (string, unique)
- description (text, nullable)
- founded_year (integer, nullable)
- headquarters (string, nullable)
- website_url (string, nullable)
- created_at (timestamp)
- updated_at (timestamp)

#### Platforms Table
- id (bigint, primary key)
- name (string)
- slug (string, unique)
- manufacturer (string)
- release_date (date)
- created_at (timestamp)
- updated_at (timestamp)

#### Genres Table
- id (bigint, primary key)
- name (string)
- slug (string, unique)
- description (text, nullable)
- created_at (timestamp)
- updated_at (timestamp)

#### Games Table
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

#### Reviews Table
- id (bigint, primary key)
- user_id (bigint, foreign key)
- game_id (bigint, foreign key)
- rating (decimal)
- title (string)
- content (text)
- is_recommended (boolean)
- created_at (timestamp)
- updated_at (timestamp)

### Relationship Tables (Many-to-Many)

#### Developer-Game Pivot Table (developer_game)
- developer_id (bigint, foreign key to developers.id)
- game_id (bigint, foreign key to games.id)
- role (string) - Developer's role in the game (e.g., "Lead Developer", "Co-Developer")

#### Game-Platform Pivot Table (game_platform)
- game_id (bigint, foreign key to games.id)
- platform_id (bigint, foreign key to platforms.id)
- release_date (date) - Game's release date on specific platform

#### Game-Genre Pivot Table (game_genre)
- game_id (bigint, foreign key to games.id)
- genre_id (bigint, foreign key to genres.id)

### Database Relationships
- **Users** → **Reviews** (One-to-Many): A user can write multiple reviews
- **Games** → **Reviews** (One-to-Many): A game can have multiple reviews
- **Publishers** → **Games** (One-to-Many): A publisher can publish multiple games
- **Games** ↔ **Developers** (Many-to-Many): Games can have multiple developers, developers can work on multiple games
- **Games** ↔ **Platforms** (Many-to-Many): Games can be on multiple platforms, platforms can have multiple games
- **Games** ↔ **Genres** (Many-to-Many): Games can belong to multiple genres, genres can contain multiple games

## Testing with Thunder Client

This project includes a pre-configured Thunder Client collection for easy API testing in VS Code.

### Setup Instructions

1. **Install Thunder Client Extension**
   - Open VS Code Extensions panel (`Ctrl+Shift+X`)
   - Search for "Thunder Client" 
   - Install the extension by RangaV

2. **Import the Collection**
   - Open Thunder Client panel in VS Code
   - Click "Import" button
   - Select `thunder-collection_Gaming API.json` from the project root
   - The collection will be loaded with all endpoints

3. **Configure Environment**
   - Set the base URL to `http://localhost:8000`
   - Ensure your Laravel development server is running

4. **Authentication Flow**
   - First, run the `POST /api/auth/login` request to get a token
   - The token will be automatically used in subsequent requests
   - Protected endpoints will work once authenticated

### Available Test Requests
The collection includes:
- **Authentication**: Login, register, logout
- **Games**: CRUD operations, search, popular/latest games
- **Developers**: CRUD operations and game relationships
- **Publishers**: CRUD operations and game relationships  
- **Genres**: CRUD operations and game relationships
- **Platforms**: CRUD operations and game relationships
- **Reviews**: CRUD operations and game ratings

### Quick Testing
1. Start your Laravel server: `php artisan serve`
2. Run the login request to authenticate
3. Test any endpoint - authentication is handled automatically

## Contributing

Contributions are welcome! Please feel free to submit issues and pull requests.

### Development Guidelines
1. Follow PSR-12 coding standards
2. Write tests for new features
3. Update documentation for API changes
4. Use meaningful commit messages
