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
│   └── index.php
├── .env
├── docker-compose.yml
└── README.md
```

## Development

Place your PHP files in the `src` directory. The directory is mounted as a volume, so changes will be reflected immediately.