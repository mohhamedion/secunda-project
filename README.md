# secunda-test-project

- Ссылка на проект http://localhost:8005/
- phpmyadmin http://localhost:8088/

Статический ключ
- x-access-key = 123123

Ссылка на документацию 
- http://localhost:8005/api/documentation

## Запуск проекта
Run docker
```
docker compose up --build -d
```

Run composer 
```
docker exec -it secunda_app composer install
```

Copy .env.example
```
docker exec -it secunda_app cp .env.example .env
```

Create app key
```
docker exec -it secunda_app php artisan key:generate
```

migrate with seeds
```
docker exec -it secunda_app php artisan migrate --seed
```

Generate swagger doc
```
docker exec -it secunda_app php artisan l5-swagger:generate
```

