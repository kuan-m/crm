.PHONY: dev-init prod-init dev-up prod-up dev-down prod-down dev-migrate prod-migrate test swagger pint phpstan logs-app logs-app-prod dev-shell prod-shell dev-prepare prod-prepare dev-build prod-build dev-rebuild prod-rebuild

# === Енвы ===
HOST_UID  ?= 1000
HOST_GID  ?= 1000
DC        = docker compose --env-file infra/development/.env -f infra/development/docker-compose.yml
DC_PROD   = docker compose --env-file infra/production/.env -f infra/production/docker-compose.yml
APP       = $(DC) exec app
APP_PROD  = $(DC_PROD) exec app

# === Хелперы функции ===

infra/development/.env:
	@if [ ! -f infra/development/.env ]; then \
		cp infra/development/.env.example infra/development/.env; \
	fi

infra/production/.env:
	@if [ ! -f infra/production/.env ]; then \
		cp infra/production/.env.example infra/production/.env; \
	fi

services/crm/.env:
	@if [ ! -f services/crm/.env ]; then \
		cp services/crm/.env.example services/crm/.env; \
	fi

# === Инициализация ===

dev-build: infra/development/.env
	$(DC) build app

prod-build: infra/production/.env
	$(DC_PROD) build app

dev-rebuild: infra/development/.env
	$(DC) build --no-cache app

prod-rebuild: infra/production/.env
	$(DC_PROD) build --no-cache app

dev-init: infra/development/.env services/crm/.env
	$(DC) build
	$(DC) up -d
	$(MAKE) dev-prepare
	$(APP) composer install
	$(APP) php artisan optimize:clear
	$(APP) php artisan key:generate --force
	$(APP) php artisan migrate --seed --force

prod-init: infra/production/.env services/crm/.env
	$(DC_PROD) build
	$(DC_PROD) up -d
	$(MAKE) prod-prepare
	$(APP_PROD) composer install --no-dev --optimize-autoloader
	$(APP_PROD) php artisan optimize:clear
	$(APP_PROD) php artisan key:generate --force
	$(APP_PROD) php artisan migrate --force
	$(APP_PROD) php artisan config:cache
	$(APP_PROD) php artisan route:cache
	$(APP_PROD) php artisan view:cache

# === Управление ===

dev-up: infra/development/.env services/crm/.env
	$(DC) up -d
	$(MAKE) dev-prepare
	$(APP) sh -lc 'test -f /var/www/crm/vendor/autoload.php || composer install'
	$(APP) php artisan optimize:clear

prod-up: infra/production/.env services/crm/.env
	$(DC_PROD) up -d
	$(MAKE) prod-prepare
	$(APP_PROD) sh -lc 'test -f /var/www/crm/vendor/autoload.php || composer install --no-dev --optimize-autoloader'

dev-prepare:
	$(DC) exec --user root app sh -lc 'mkdir -p /var/www/crm/storage/logs /var/www/crm/storage/framework/cache/data /var/www/crm/storage/framework/sessions /var/www/crm/storage/framework/views /var/www/crm/bootstrap/cache /var/www/crm/vendor && chown -R $(HOST_UID):$(HOST_GID) /var/www/crm/storage /var/www/crm/bootstrap/cache /var/www/crm/vendor'

prod-prepare:
	$(DC_PROD) exec --user root app sh -lc 'mkdir -p /var/www/crm/storage/logs /var/www/crm/storage/framework/cache/data /var/www/crm/storage/framework/sessions /var/www/crm/storage/framework/views /var/www/crm/bootstrap/cache /var/www/crm/vendor && chown -R $(HOST_UID):$(HOST_GID) /var/www/crm/storage /var/www/crm/bootstrap/cache /var/www/crm/vendor'

dev-down:
	$(DC) down

prod-down:
	$(DC_PROD) down

dev-migrate:
	$(APP) php artisan migrate --force

dev-rollback:
	$(APP) php artisan migrate:rollback

prod-migrate:
	$(APP_PROD) php artisan migrate --force

prod-rollback:
	$(APP_PROD) php artisan migrate:rollback

logs-app:
	$(DC) logs -f app

logs-app-prod:
	$(DC_PROD) logs -f app nginx cloudflared

dev-shell:
	$(APP) sh

prod-shell:
	$(APP_PROD) sh

# === Тесты/Код стайл ===

test:
	$(APP) php artisan test

pint:
	$(APP) ./vendor/bin/pint

phpstan:
	$(APP) ./vendor/bin/phpstan analyse app config database routes tests

swagger:
	$(APP) sh -lc 'cd /var/www/crm && mkdir -p storage/api-docs && ./vendor/bin/openapi --format yaml -o storage/api-docs/openapi.yaml app routes'
