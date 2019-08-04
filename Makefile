SHELL := /bin/sh

MAKEFLAGS := --silent --no-print-directory

.DEFAULT_GOAL := help

help:
	@echo "Please use 'make <target>' where <target> is one of"
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z\._-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

build: ## Build images
	docker-compose -f docker/docker-compose.yml -f docker/docker-compose.dev.yml -p image-crawler build

up: ## Start containers in development mode
	docker-compose -f docker/docker-compose.yml -f docker/docker-compose.dev.yml -p image-crawler up -d

down: ## Stop containers
	docker-compose -f docker/docker-compose.yml -f docker/docker-compose.dev.yml -p image-crawler down

test: ## Run phpunit tests
	docker-compose -f docker/docker-compose.yml -f docker/docker-compose.dev.yml -p image-crawler exec -u php php-fpm bin/phpunit

test.unit: ## Run phpunit unit tests
	docker-compose -f docker/docker-compose.yml -f docker/docker-compose.dev.yml -p image-crawler exec -u php php-fpm bin/phpunit --testsuite=unit

test.integration: ## Run phpunit integration tests
	docker-compose -f docker/docker-compose.yml -f docker/docker-compose.dev.yml -p image-crawler exec -u php php-fpm bin/phpunit --testsuite=integration

test.functional: ## Run phpunit functional tests, please beware that this requires the application to be running
	docker-compose -f docker/docker-compose.yml -f docker/docker-compose.dev.yml -p image-crawler exec -u php php-fpm bin/phpunit --testsuite=functional

test.coverage: ## Run phpunit tests and generate coverage
	docker-compose -f docker/docker-compose.yml -f docker/docker-compose.dev.yml -p image-crawler exec -u php php-fpm bin/phpunit --coverage-html=/app/src/public/coverage

php.run: ## Run a command in the php container, requires a 'cmd' argument
	docker-compose -f docker/docker-compose.yml -f docker/docker-compose.dev.yml -p image-crawler exec -u php php-fpm ${cmd}

composer.install: ## Run composer install in the php container in development
	make php.run cmd="bin/composer install"

composer.update: ## Run composer update in the php container in development
	make php.run cmd="bin/composer update"

restart: ## Restart containers
	docker-compose -f docker/docker-compose.yml -f docker/docker-compose.dev.yml -p image-crawler restart

prod.up: ## Start containers
	docker-compose -f docker/docker-compose.yml -p image-crawler up -d

prod.down: ## Stop containers
	docker-compose -f docker/docker-compose.yml -p image-crawler down

prod.restart: ## Restart containers in production mdoe
	docker-compose -f docker/docker-compose.yml -p image-crawler restart
