#!/bin/sh

# Install dependencies if not found
if [ ! -d "./vendor/" ]; then
    composer install
    echo "Dependencies installed\n"
fi

# Create Database if not exist
FILE=./data.db
if [ ! -f "$FILE" ]; then
    echo "Database doesn't exists. Creating...."
    sqlite3 data.db < schema.sql
    echo "Database created at $FILE\n"
fi

echo "Starting Development Server...\n"
php -S 0.0.0.0:8080
