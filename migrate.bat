@echo off
echo Running database migrations...
php src\db\migrate.php
echo.
echo Migration process completed.
pause