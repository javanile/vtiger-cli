
up:
	@docker-compose up -d vtiger

permissions:
	@chmod +x bin/vtiger

install:
	docker-compose run --rm composer install

build-docs:
	@php -f script/build-docs.php

release: build-docs
	@git add .
	@git commit -am "Release "
	@echo $$((($$(date +%s) - 1609455600) / 86400))

## =====
## Tests
## =====
test:
	docker-compose run --rm phpunit tests

test-info: permissions
	docker-compose run --rm vtiger /app/bin/vtiger info

test-help: permissions
	docker-compose run --rm vtiger /app/bin/vtiger list

test-client: permissions up
	@docker-compose exec -T vtiger /app/bin/vtiger client describe Accounts

test-console: permissions
	docker-compose run --rm vtiger /app/bin/vtiger console
