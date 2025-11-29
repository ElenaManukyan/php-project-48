install:
	composer install

lint:
	./vendor/bin/phpcs --standard=PSR12 src

test:
	./vendor/bin/phpunit tests

test-coverage:
	XDEBUG_MODE=coverage ./vendor/bin/phpunit tests --coverage-clover build/logs/clover.xml
