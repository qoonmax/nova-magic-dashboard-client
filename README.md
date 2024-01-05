# nova-magic-dashboard-client

## Локальная разработка

1. Создать .env файл в корне проекта и заполнить его по примеру .env.example.
2. Запуск проекта: `docker compose up -d --build`
3. Выполнение команды внутри контейнера: `docker compose exec -it php php artisan magic:generate` (для запуска генерации).
