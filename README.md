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
# secunda-project
