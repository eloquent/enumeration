.PHONY: test
test: vendor
	php --version
	vendor/bin/phpunit --no-coverage

.PHONY: coverage
coverage: vendor
	phpdbg --version
	phpdbg -qrr vendor/bin/phpunit

.PHONY: coverage-open
coverage-open:
	open coverage/index.html

.PHONY: lint
lint: test/bin/php-cs-fixer
	test/bin/php-cs-fixer fix

vendor: composer.lock
	composer install
	@touch $@

composer.lock: composer.json
	composer update
	@touch $@

test/bin/php-cs-fixer:
	mkdir -p test/bin
	curl -sSL http://cs.sensiolabs.org/download/php-cs-fixer-v2.phar -o test/bin/php-cs-fixer
	chmod +x test/bin/php-cs-fixer
