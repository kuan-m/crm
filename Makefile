.PHONY: dev prod dev-init prod-init dev-up prod-up dev-down prod-down dev-migrate prod-migrate test swagger pint phpstan logs-app logs-app-prod dev-shell prod-shell dev-prepare prod-prepare dev-build prod-build dev-rebuild prod-rebuild

dev: dev-up
prod: prod-up

# === Енвы ===

HOST_UID  ?= 1000
HOST_GID  ?= 1000

APP_PATH  ?= /var/www/crm

DC        = docker compose --env-file infra/development/.env -f infra/development/docker-compose.yml
DC_PROD   = docker compose --env-file infra/production/.env -f infra/production/docker-compose.yml

APP       = $(DC) exec app
APP_PROD  = $(DC_PROD) exec app


# === Хелперы ===

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


# === Build ===

dev-build: infra/development/.env
	$(DC) build app

prod-build: infra/production/.env
	$(DC_PROD) build app

dev-rebuild: infra/development/.env
	$(DC) build --no-cache app

prod-rebuild: infra/production/.env
	$(DC_PROD) build --no-cache app


# === Init ===

dev-init: infra/development/.env services/crm/.env
	$(DC) build
	$(DC) up -d
	$(MAKE) dev-prepare
	$(APP) composer install
	$(APP) php $(APP_PATH)/artisan migrate --force
	$(APP) php $(APP_PATH)/artisan key:generate --force
	$(APP) php $(APP_PATH)/artisan storage:link
	$(DC) up -d
	$(APP) php $(APP_PATH)/artisan migrate --seed --force

prod-init: infra/production/.env services/crm/.env
	$(DC_PROD) build
	$(DC_PROD) up -d
	$(MAKE) prod-prepare
	$(APP_PROD) composer install --no-dev --optimize-autoloader
	$(APP_PROD) php $(APP_PATH)/artisan key:generate --force
	$(APP_PROD) php $(APP_PATH)/artisan storage:link
	$(DC_PROD) up -d
	$(APP_PROD) php $(APP_PATH)/artisan migrate --force
	$(APP_PROD) php $(APP_PATH)/artisan config:cache
	$(APP_PROD) php $(APP_PATH)/artisan route:cache
	$(APP_PROD) php $(APP_PATH)/artisan view:cache


# === Up ===

dev-up: infra/development/.env services/crm/.env
	$(DC) up -d
	$(MAKE) dev-prepare
	$(APP) sh -lc 'test -f $(APP_PATH)/vendor/autoload.php || composer install'

prod-up: infra/production/.env services/crm/.env
	$(DC_PROD) up -d
	$(MAKE) prod-prepare
	$(APP_PROD) sh -lc 'test -f $(APP_PATH)/vendor/autoload.php || composer install --no-dev --optimize-autoloader'


# === Prepare ===

dev-prepare:
	$(DC) exec --user root app sh -lc 'mkdir -p \
	$(APP_PATH)/storage/logs \
	$(APP_PATH)/storage/framework/cache/data \
	$(APP_PATH)/storage/framework/sessions \
	$(APP_PATH)/storage/framework/views \
	$(APP_PATH)/bootstrap/cache \
	$(APP_PATH)/vendor && \
	chown -R $(HOST_UID):$(HOST_GID) \
	$(APP_PATH)/storage \
	$(APP_PATH)/bootstrap/cache \
	$(APP_PATH)/vendor \
	$(APP_PATH)/.env'

prod-prepare:
	$(DC_PROD) exec --user root app sh -lc 'mkdir -p \
	$(APP_PATH)/storage/logs \
	$(APP_PATH)/storage/framework/cache/data \
	$(APP_PATH)/storage/framework/sessions \
	$(APP_PATH)/storage/framework/views \
	$(APP_PATH)/bootstrap/cache \
	$(APP_PATH)/vendor && \
	chown -R $(HOST_UID):$(HOST_GID) \
	$(APP_PATH)/storage \
	$(APP_PATH)/bootstrap/cache \
	$(APP_PATH)/vendor \
	$(APP_PATH)/.env'


# === Down ===

dev-down:
	$(DC) down

prod-down:
	$(DC_PROD) down


# === Migrate ===

dev-migrate:
	$(APP) php $(APP_PATH)/artisan migrate --force

dev-rollback:
	$(APP) php $(APP_PATH)/artisan migrate:rollback

prod-migrate:
	$(APP_PROD) php $(APP_PATH)/artisan migrate --force

prod-rollback:
	$(APP_PROD) php $(APP_PATH)/artisan migrate:rollback


# === Logs ===

logs-app:
	$(DC) logs -f app

logs-app-prod:
	$(DC_PROD) logs -f app nginx cloudflared


# === Shell ===

dev-shell:
	$(APP) sh

prod-shell:
	$(APP_PROD) sh


# === Composer ===

dev-composer-i:
	$(APP) composer install

prod-composer-i:
	$(APP_PROD) composer install


# === Tests ===

test:
	$(APP) php $(APP_PATH)/artisan test

pint:
	$(APP) $(APP_PATH)/vendor/bin/pint

phpstan:
	$(APP) $(APP_PATH)/vendor/bin/phpstan analyse -c $(APP_PATH)/phpstan.neon --memory-limit=2G

swagger:
	$(APP) sh -lc 'cd $(APP_PATH) && mkdir -p public/api-docs && ./vendor/bin/openapi --format yaml -o public/api-docs/openapi.yaml app routes'


# === Seed ===

dev-seed:
	$(APP) php $(APP_PATH)/artisan db:seed --force

prod-seed:
	$(APP_PROD) php $(APP_PATH)/artisan db:seed --force

# === Clear cache ===

dev-clear:
	$(APP) php $(APP_PATH)/artisan optimize:clear
	$(APP) php $(APP_PATH)/artisan cache:clear
	$(APP) php $(APP_PATH)/artisan config:clear
	$(APP) php $(APP_PATH)/artisan route:clear
	$(APP) php $(APP_PATH)/artisan view:clear
	$(APP) php $(APP_PATH)/artisan event:clear
	$(APP) php $(APP_PATH)/artisan clear-compiled

prod-clear:
	$(APP_PROD) php $(APP_PATH)/artisan optimize:clear
	$(APP_PROD) php $(APP_PATH)/artisan cache:clear
	$(APP_PROD) php $(APP_PATH)/artisan config:clear
	$(APP_PROD) php $(APP_PATH)/artisan route:clear
	$(APP_PROD) php $(APP_PATH)/artisan view:clear
	$(APP_PROD) php $(APP_PATH)/artisan event:clear
	$(APP_PROD) php $(APP_PATH)/artisan clear-compiled