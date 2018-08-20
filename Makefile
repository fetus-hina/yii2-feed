all: vendor

vendor: composer.lock composer.phar
	./composer.phar update -vvv --prefer-dist

composer.lock: composer.json composer.phar
	./composer.phar install -vvv --prefer-dist

composer.phar:
	curl -sSL 'https://getcomposer.org/installer' | php -- --stable
