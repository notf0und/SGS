#!/bin/sh
# Recreate storage symlink after volumes are mounted
rm -rf /app/www/public/games
ln -sfn ../storage/app/public/games /app/www/public/games
