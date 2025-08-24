# Task Manager Pro - Backend (Laravel API)

A robust Laravel API backend for the Task Manager Pro application, featuring JWT authentication, RESTful endpoints, and comprehensive task management functionality.

## Features

### 🔐 Authentication System
- JWT-based authentication with php-open-source-saver/jwt-auth
- Secure user registration and login
- Token refresh and logout functionality
- Password hashing and validation

### 📋 Task Management API
- Full CRUD operations for tasks
- Task categorization and prioritization
- Due date tracking and overdue detection
- Task completion status management
- Advanced filtering and search capabilities

### 🏷️ Category Management
- Custom category creation with colors
- Category-based task organization
- Category statistics and task counts

### 🛡️ Security Features
- CORS configuration for frontend integration
- Request validation and sanitization
- User-specific data isolation
- Secure API endpoints with middleware protection

## Technology Stack

- **Laravel 9**: PHP framework for robust API development
- **MySQL 8.0+**: Reliable database for data persistence
- **JWT Authentication**: Secure token-based authentication
- **php-open-source-saver/jwt-auth**: JWT implementation for Laravel
- **fruitcake/laravel-cors**: CORS handling
- **RESTful API Design**: Clean, standardized API endpoints

## Prerequisites

- PHP 8.0.2 or higher
- Composer
- MySQL 8.0 or higher
- Web server (Apache/Nginx) for production

## Installation & Setup

### 1. Clone Repository
```bash
git clone <repository-url>
cd todo-app/backend
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Publish and configure JWT
php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"
php artisan jwt:secret
```

### 4. Database Setup
```bash
# Create database
mysql -u root -p -e "CREATE DATABASE todo_app;"

# Configure .env file with your database credentials
```

Edit `.env` file:
```env
APP_NAME="Task Manager Pro API"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=todo_app
DB_USERNAME=your_username
DB_PASSWORD=your_password

JWT_SECRET=your_jwt_secret_here
JWT_TTL=60
JWT_REFRESH_TTL=20160
```

### 5. Run Migrations
```bash
# Run database migrations
php artisan migrate

# Optional: Seed with sample data
php artisan db:seed
```

### 6. Start Development Server
```bash
# Start Laravel development server
php artisan serve

# API will be available at http://localhost:8000
```

## API Documentation

### Base URL
```
http://localhost:8000/api
```

### Authentication Endpoints

#### Register User
```http
POST /api/auth/register
Content-Type: application/json

{
  "name": "John Doe",
  "email": "john@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

#### Login User
```http
POST /api/auth/login
Content-Type: application/json

{
  "email": "john@example.com",
  "password": "password123"
}
```

#### Get Current User
```http
GET /api/auth/me
Authorization: Bearer {token}
```

#### Refresh Token
```http
POST /api/auth/refresh
Authorization: Bearer {token}
```

#### Logout
```http
POST /api/auth/logout
Authorization: Bearer {token}
```

### Task Endpoints

#### Get All Tasks
```http
GET /api/tasks
Authorization: Bearer {token}

# With filters
GET /api/tasks?search=meeting&status=pending&priority=high&category_id=1
```

#### Create Task
```http
POST /api/tasks
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Complete project proposal",
  "description": "Finish the Q1 project proposal and send to client",
  "priority": "high",
  "due_date": "2024-12-31T23:59:59",
  "category_id": 1
}
```

#### Update Task
```http
PUT /api/tasks/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Updated task title",
  "is_completed": true
}
```

#### Delete Task
```http
DELETE /api/tasks/{id}
Authorization: Bearer {token}
```

#### Toggle Task Completion
```http
PATCH /api/tasks/{id}/toggle
Authorization: Bearer {token}
```

### Category Endpoints

#### Get All Categories
```http
GET /api/categories
Authorization: Bearer {token}
```

#### Create Category
```http
POST /api/categories
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Work Projects",
  "color": "#3B82F6"
}
```

#### Update Category
```http
PUT /api/categories/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
  "name": "Personal Tasks",
  "color": "#10B981"
}
```

#### Delete Category
```http
DELETE /api/categories/{id}
Authorization: Bearer {token}
```

## Architecture Patterns

### Repository Pattern
- Abstract data access layer
- Interface-based contracts
- Dependency injection for loose coupling

### Service Layer
- Business logic separation
- Reusable business operations
- Clean controller methods

### Request Validation
- Form request classes for input validation
- Centralized validation rules
- Automatic error responses

## Database Schema

### Users Table
- id (primary key)
- name (string)
- email (unique string)
- password (hashed string)
- timestamps

### Categories Table
- id (primary key)
- name (string)
- color (string, hex color)
- user_id (foreign key)
- timestamps

### Tasks Table
- id (primary key)
- title (string)
- description (text, nullable)
- is_completed (boolean, default false)
- due_date (timestamp, nullable)
- priority (enum: low, medium, high)
- user_id (foreign key)
- category_id (foreign key, nullable)
- timestamps
