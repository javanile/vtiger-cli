

install:
	docker-compose run --rm composer install

## =====
## Tests
## =====

test-client:
	docker-compose run --rm vtiger php -f /app/bin/vtiger client a b c
