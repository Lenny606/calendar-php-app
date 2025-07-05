# PHP Project Skeleton with Docker

This is a PHP project skeleton with Docker Compose, including PHP, MySQL, Adminer, and Nginx services.

## Requirements

- Docker
- Docker Compose

## Setup

1. Clone this repository
2. Run `docker-compose up -d`
3. Access the application at http://localhost
4. Access Adminer at http://localhost:8080

## Services

- **PHP**: PHP 8.2 with FPM
- **MySQL**: MySQL 8.0 database
- **Adminer**: Database management tool
- **Nginx**: Web server

## Environment Variables

You can modify the environment variables in the `.env` file:

- `DB_DATABASE`: Database name
- `DB_USERNAME`: Database username
- `DB_PASSWORD`: Database password
- `DB_ROOT_PASSWORD`: Database root password

## Project Structure

```
.
├── docker
│   ├── nginx
│   │   └── conf.d
│   │       └── app.conf
│   └── php
│       └── Dockerfile
├── src
│   ├── db
│   │   ├── migrations
│   │   │   └── *.sql
│   │   ├── connection.php
│   │   └── migrate.php
│   └── index.php
├── .env
├── docker-compose.yml
├── migrate.bat
├── migrate.sh
└── README.md
```

## Development

Place your PHP files in the `src` directory. The directory is mounted as a volume, so changes will be reflected immediately.

## Database Migrations

This project includes a simple database migration system to manage database schema changes.

### Creating Migrations

1. Create SQL migration files in the `src/db/migrations` directory
2. Name your migration files using the format: `YYYYMMDD_HHMMSS_description.sql`
   - Example: `20230101_120000_create_users_table.sql`
3. Each migration file should contain valid SQL statements

### Running Migrations

To run migrations:

- On Windows: Run `migrate.bat`
- On Linux/macOS: Run `./migrate.sh` (make it executable first with `chmod +x migrate.sh`)

The migration system will:
1. Create a `migrations` table if it doesn't exist
2. Execute any new migration files that haven't been run yet
3. Track executed migrations to prevent duplicate runs

### Migration Order

Migrations are executed in alphabetical order based on their filenames, which is why the timestamp naming convention is important to ensure proper sequencing.
