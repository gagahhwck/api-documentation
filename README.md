# API Documentation

> by **gagahhwck** — Backend API built with Laravel & Scribe

This project is a Laravel-based REST API with auto-generated documentation powered by [Scribe](https://scribe.knuckles.wtf/).

## Tech Stack

| Layer | Technology |
|-------|------------|
| Backend Framework | Laravel |
| API Documentation | Scribe |
| Authentication | Laravel Sanctum (ready) |
| Database | MySQL / SQLite |

## Features

- ✅ User Registration (`POST /api/register`)
- ✅ Auto-generated API Docs (HTML & Postman Collection)
- ✅ OpenAPI Spec export
- ✅ Ready for Postman Documentation integration

## Quick Start

```bash
# Clone repo
git clone https://github.com/gagahhwck/api-documentation.git
cd api-documentation

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate

# Run migrations
php artisan migrate

# Start server
php artisan serve
```

## API Documentation

### HTML Docs
After running the server, visit:
```
http://localhost/docs
```

### Postman Collection
Import `postman-collection.json` into Postman to test endpoints directly.

### Update Documentation
Whenever you add or change API endpoints, regenerate docs:

```bash
php artisan scribe:generate
```

This updates:
- `resources/views/scribe/` — HTML docs
- `postman-collection.json` — Postman Collection
- `storage/app/private/scribe/openapi.yaml` — OpenAPI spec

## API Endpoints

| Method | Endpoint | Description | Auth |
|--------|----------|-------------|------|
| POST | `/api/register` | Register new user | No |

### Register User

**Request:**
```bash
curl -X POST http://localhost:8000/api/register \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
  }'
```

**Response (201 Created):**
```json
{
  "message": "User registered successfully",
  "user": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2024-01-15T10:00:00.000000Z",
    "updated_at": "2024-01-15T10:00:00.000000Z"
  }
}
```

## Project Structure

```
├── app/
│   └── Http/
│       └── Controllers/
│           └── AuthController.php      # API Controllers with Scribe annotations
├── routes/
│   └── api.php                         # API Routes
├── storage/app/private/scribe/
│   └── collection.json                 # Postman Collection (auto-generated)
│   └── openapi.yaml                    # OpenAPI Spec (auto-generated)
├── resources/views/scribe/
│   └── index.blade.php                 # HTML Docs (auto-generated)
└── postman-collection.json             # Postman Collection (copied to root)
```

## Optional: Postman Documentation Setup

1. Open Postman App
2. Click **Import** → Select `postman-collection.json`
3. Collection appears in sidebar
4. Click **⋮** → **View Documentation** → **Publish**
5. Share the public URL with your team

## Contributing

Feel free to fork and submit PRs.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

