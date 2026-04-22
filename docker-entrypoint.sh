#!/bin/sh
set -e

php artisan key:generate --force

echo "ждём..."
for i in $(seq 1 30); do
    echo "Attempt $i..."
    if mysql -h db -u laravel -plaravel --skip-ssl -e "SELECT 1" > /dev/null 2>&1; then
        echo "Всё"
        break
    fi
    echo "ждём ещё..."
    sleep 2
done

php artisan migrate --force
php artisan db:seed --force

exec php artisan serve --host=0.0.0.0 --port=8000
