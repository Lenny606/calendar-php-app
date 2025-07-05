<?php
/**
 * Database Migration Script
 * 
 * This script runs SQL migration files from the migrations directory.
 * It tracks executed migrations in a 'migrations' table to prevent duplicate runs.
 * 
 * Usage: php migrate.php
 */

// Load environment variables if .env file exists
if (file_exists(__DIR__ . '/../../.env')) {
    $envFile = file(__DIR__ . '/../../.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($envFile as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[$key] = $value;
            putenv("$key=$value");
        }
    }
}

// Database connection
require_once __DIR__ . '/connection.php';
global $connection; // Make the connection variable from connection.php available in this scope

// Directory containing migration files
$migrationsDir = __DIR__ . '/migrations';

// Create migrations table if it doesn't exist
$createMigrationsTableSQL = "
CREATE TABLE IF NOT EXISTS migrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
";
if (!$connection->query($createMigrationsTableSQL)) {
    die("Error creating migrations table: " . $connection->error);
}

// Get list of executed migrations
$executedMigrations = [];
$result = $connection->query("SELECT migration FROM migrations");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $executedMigrations[] = $row['migration'];
    }
    $result->free();
}

// Get list of migration files
$migrationFiles = [];
if (is_dir($migrationsDir)) {
    $files = scandir($migrationsDir);
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'sql') {
            $migrationFiles[] = $file;
        }
    }
    sort($migrationFiles); // Sort to ensure migrations run in order
}

// Run migrations
$migrationsRun = 0;
foreach ($migrationFiles as $migrationFile) {
    if (!in_array($migrationFile, $executedMigrations)) {
        echo "Running migration: $migrationFile\n";

        // Read and execute migration file
        $sql = file_get_contents($migrationsDir . '/' . $migrationFile);
        if ($connection->multi_query($sql)) {
            // Process all result sets to clear them
            do {
                if ($result = $connection->store_result()) {
                    $result->free();
                }
            } while ($connection->more_results() && $connection->next_result());

            // Record migration as executed
            $stmt = $connection->prepare("INSERT INTO migrations (migration) VALUES (?)");
            $stmt->bind_param("s", $migrationFile);
            $stmt->execute();
            $stmt->close();

            echo "Migration completed: $migrationFile\n";
            $migrationsRun++;
        } else {
            echo "Error running migration $migrationFile: " . $connection->error . "\n";
            exit(1);
        }
    }
}

if ($migrationsRun === 0) {
    echo "No new migrations to run.\n";
} else {
    echo "Successfully ran $migrationsRun migrations.\n";
}

$connection->close();
