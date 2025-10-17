# LARAVEL-API-SERVICE

## Начало работы
### Предварительные условия
Убедитесь, что у вас установлены Docker и Docker Compose. Проверить это можно, выполнив:

```bash
docker --version
docker compose version
```

Если эти команды не вернули версии, установите Docker и Docker Compose, используя официальную документацию: [Docker](https://docs.docker.com/get-docker/) и [Docker Compose](https://docs.docker.com/compose/install/).

### Клонирование репозитория

```bash
git clone https://github.com/ilya-yar/laravel-test-task.git
cd laravel-test-task
```

### Настройка DEV среды

1. Скопируйте файл .env.example в .env и настройте все необходимые переменные окружения:

```bash
cp .env.example .env
```

Настройте переменные `UID` и `GID` в файле `.env` так, чтобы они соответствовали вашему идентификатору пользователя и идентификатору группы. Вы можете найти их, выполнив в терминале команды `id -u` и `id -g`.

2. Запустите Docker Compose:

```bash
docker compose -f compose.dev.yaml up -d
```

3. Установите зависимости Laravel:

```bash
docker compose -f compose.dev.yaml exec workspace bash
composer install
```

4. Запустите миграции:

```bash
docker compose -f compose.dev.yaml exec workspace php artisan migrate
```

5. Конфигурация БД:

HOST=localhost  
PORT=5432  
POSTGRES_DB=app  
POSTGRES_USER=laravel  
POSTGRES_PASSWORD=secret

## Использование
### Доступ к контейнеру workspace

```bash
docker compose -f compose.dev.yaml exec workspace bash
```

### Запуск миграций:

```bash
docker compose -f compose.dev.yaml exec workspace php artisan migrate
```
### Запуск заполнения БД тестовыми данными:

```bash
docker compose -f compose.dev.yaml exec workspace php artisan db:seed
```

### Пересборка контейнеров:

```bash
docker compose -f compose.dev.yaml up -d --build
```

### Остановка контейнеров:

```bash
docker compose -f compose.dev.yaml down
```

### Генерация документации swagger:
```bash
docker compose -f compose.dev.yaml exec workspace composer swagger
```
Swagger файл сохраняется в файл resources/swagger/openapi.json 
Локально документация API доступна по ссылке: http://localhost/swagger
