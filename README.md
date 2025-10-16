# PHP-API-SERVICE

## Оглавление

- [Обзор](#overview)
- [Структура проекта](#project-structure)
    - [Структура директорий](#directory-structure)
    - [Dev среда](#development-environment)
    - [Production среда](#production-environment)
- [Начало работы](#getting-started)
    - [Клонирование репозитория](#clone-the-repository)
    - [Настройка dev окружения](#setting-up-the-development-environment)
- [Использование](#usage)
- [Production среда](#production-environment-1)
    - [Создание и запуск production среды](#building-and-running-the-production-environment)
- [Технические подробности](#technical-details)

## Структура проекта

Проект организован как типичное приложение Laravel, с добавлением директории `docker`, содержащей конфиги и скрипты Docker. Они разделены по окружениям и сервисам. В корневом каталоге находятся два основных файла Docker Compose:

- **compose.dev.yaml**: Конфиг для локальной разработки.
- **compose.prod.yaml**: Конфиг для продовой среды.

### Структура каталога

```
корень проекта/ 
├──── app/ # папка Laravel приложения
├── ...  # Другие файлы и каталоги Laravel 
├──── docker/ 
│ ├──── common/ # Общие конфиги
│ ├──── development/ # Конфиги, специфичные для локальной разработки 
│ ├──── production/ # Конфиги, специфичные для production-среды
├──── compose.dev.yaml # Docker Compose для разработки 
├──── compose.prod.yaml # Docker Compose для прода 
└── .env.example # Пример конфига окружения
```

Эта модульная структура обеспечивает общую логику между окружениями, позволяя при этом настраивать окружения по своему усмотрению.

### Production среда

Production среда настраивается с помощью файла `compose.prod.yaml`. Она оптимизирована для производительности и безопасности.
Эта среда предназначена для легкого развертывания на любой Docker-совместимой хостинговой платформе.

### Dev среда

Dev среда настраивается с помощью файла `compose.dev.yaml` и собирается поверх продовой версии. Таким образом, dev среда максимально приближена к продовой, но при этом поддерживает такие инструменты, как Xdebug и разрешения на запись.

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
git clone https://gitlab.com/rtb8624318/php-api-service.git
cd php-api-service
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
npm install
npm run dev
```

4. Запустите миграции:

```bash
docker compose -f compose.dev.yaml exec workspace php artisan migrate
```

5. Проверьте доступность приложения:

Откройте браузер и перейдите по адресу [http://localhost](http://localhost).

6. Конфигурация БД:

HOST=localhost  
PORT=5432  
POSTGRES_DB=app  
POSTGRES_USER=laravel  
POSTGRES_PASSWORD=secret

## Использование
### Доступ к контейнеру workspace

Контейнер workspace включает в себя Composer, Node.js, NPM и другие инструменты, необходимые для работы с Laravel (например, создание ресурсов).

```bash
docker compose -f compose.dev.yaml exec workspace bash
```

### Запуск команд Artisan:

```bash
docker compose -f compose.dev.yaml exec workspace php artisan migrate
```

### Пересборка контейнеров:

```bash
docker compose -f compose.dev.yaml up -d --build
```

### Остановка контейнеров:

```bash
docker compose -f compose.dev.yaml down
```

### Просмотр логов:

```bash
docker compose -f compose.dev.yaml logs -f
```

Для конкретных сервисов можно использовать:

```bash
docker compose -f compose.dev.yaml logs -f web
```

### Генерация документации swagger:
```bash
composer swagger
```
Локально документация API доступна по ссылке: http://localhost/swagger

### Генерация моделей с использованием Reliese:
```bash
php artisan code:models
```
Документация: https://github.com/reliese/laravel

### Пример создания контроллера:
```bash
php artisan make:controller Api/AuthController
```

### Запуск тестов
```bash
php artisan test
php artisan test --testsuite=Feature --stop-on-failure
```

### Процент покрытия кода тестами
```bash
vendor/bin/phpunit --coverage-text
```

## Production среда

Production среда разработана с учетом требований безопасности и эффективности:

- **Оптимизированные образы Docker**: Использует многоступенчатые сборки для минимизации конечного размера образа.
- **Управление переменными окружения**: Чувствительные данные, такие как пароли и API-ключи, тщательно управляются для предотвращения их перехвата.
- **Разрешения пользователей**: Контейнеры по возможности запускаются под управлением не root-пользователей, чтобы следовать принципу предоставления наименьших прав.
-  **Health Checks**: Реализованы для контроля состояния служб и обеспечения их правильной работы.
- **Настройка HTTPS**: Рекомендуется настроить SSL-сертификаты и использовать HTTPS в продовой среде.

### Развертывание

Prod образ может быть развернут на любом Docker-совместимом хостинге, например в AWS ECS, Kubernetes или на традиционном VPS.

## Технические детали

- **PHP**: Версия **8.3 FPM** используется для оптимальной производительности как в дев среде, так и в продовой среде.
- **Node.js**: Версия **22.x** используется в dev среде для создания фронтенда с помощью Vite.
- **PostgreSQL**: В качестве базы данных используется версия **16**.
- **Redis**: Используется для кэширования и управления сессиями, интегрирован как в dev среду, так и в prod среду.
- **Nginx**: Используется в качестве веб-сервера для обслуживания приложения Laravel и обработки HTTP-запросов.
- **Docker Compose**: Оркестрирует сервисы, упрощая процесс запуска и остановки среды.
- **Health Checks**: Реализованы в конфигурациях Docker Compose и приложении Laravel, чтобы убедиться в работоспособности всех служб.

(SELECT ROW_NUMBER() OVER (ORDER BY score_sum desc) AS rang, a.*
FROM (SELECT sum(score) as score_sum, user_id
FROM user_scores
WHERE ts >= (NOW() - INTERVAL 7 DAY)
GROUP BY user_id) a
LIMIT 3)
UNION
(SELECT ROW_NUMBER() OVER (ORDER BY score_sum desc) AS rang, a.*
FROM (SELECT sum(score) as score_sum, user_id
FROM user_scores
WHERE ts >= (NOW() - INTERVAL 7 DAY)
GROUP BY user_id) a
ORDER BY score_sum
LIMIT 3)
ORDER BY rang;



